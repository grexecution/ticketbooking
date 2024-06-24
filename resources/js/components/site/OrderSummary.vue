<template>
    <div class="order-summary">
        <!-- Checkout Timer-->
        <div v-if="!isCartEmpty" class="ticket-warning">Tickets sind reserviert für: {{ minutes }}:{{ secondsFormatted }} Min</div>
        <div v-else class="ticket-warning">Der Warenkorb ist leer.</div>
        <time-up-modal v-if="timeIsUp" @close="goHome"></time-up-modal>
        <div class="mt-3" v-for="(item, index) in tickets" :key="index">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <p class="co-price-text">{{ item.count }} x {{ item.eventName }}</p>
                    <p class="co-price-details">{{ item.eventDate }} | {{ item.eventTime }}</p>
                    <p class="co-price-details">{{ item.eventLocation }}</p>
                    <p class="co-price-details">{{ item.categoryName }} | Ticket: {{ item.name }}</p>
                </div>
                <p>€{{ item.total }}</p>
            </div>
        </div>
        <hr class="my-3">
        <div>
            <div class="d-flex flex-row justify-content-between pb-3">
                <h5 style="font-weight:700">Gesamt:</h5>
                <h5 style="font-weight:700">€{{ totalWithDiscount || total }}</h5>
            </div>
            <div v-if="discount" class="d-flex flex-row justify-content-between">
                <h5 style="font-weight:700">Gutschein:</h5>
                <h5 style="font-weight:700; color: red;">-€{{ discount }}</h5>
            </div>
            <div v-if="isPaymentForm" class="promo-code-container">
                <input v-model="promoCode" type="text" placeholder="Gutscheincode eingeben" class="form-control" />
                <button @click="applyPromoCode(promoCode)" class="btn bg-black text-white">Anwenden</button>
                <div v-if="promoError" class="text-danger">{{ promoError }}</div>
            </div>
            <form v-if="isPaymentForm" :action="actionUrl" class="stripe-payment-form" method="get">
                <input type="hidden" name="event_id" :value="eventId">
                <button type="submit" class="btn btn-continue btn-block mt-3">Weiter zur Zahlung</button>
                <div v-if="errorMsg" class="text-danger" style="text-align: center; padding: 10px 0 5px 0;">{{ errorMsg }}</div>
            </form>
            <div v-else>
                <button @click="sendCustomerData" type="button" class="btn btn-continue btn-block mt-3">Weiter zur Kassa</button>
            </div>
            <div class="d-flex justify-content-center">
                <small class="text-secondary">Ticketpreise enthalten 13% Umsatzsteuer</small>
            </div>
        </div>
    </div>
</template>

<script>
import Cookies from 'js-cookie';
import axios from "axios";
import moment from "moment";
import TimeUpModal from './TimeUpModal.vue';


export default {
    name: 'OrderSummary',
    props: {
        actionUrl: {
            type: String,
            required: true
        },
        isPaymentForm: {
            type: Boolean,
            required: true
        },
        stripePublicKey: {
            type: String,
            required: false
        }
    },
    components: {
        TimeUpModal,
    },
    data() {
        return {
            tickets: [],
            total: '0,00',
            totalWithDiscount: 0,
            event: {},
            errorMsg: '',
            time: 10 * 60, // 10 minutes in seconds
            timeIsUp: false,
            startTime: null,
            promoCode: '',
            promoError: '',
            discount: 0,
        };
    },
    computed: {
        minutes() {
            return Math.floor(this.time / 60);
        },
        seconds() {
            return this.time % 60;
        },
        secondsFormatted() {
            return this.seconds < 10 ? '0' + this.seconds : this.seconds;
        },
        isCartEmpty() {
            return this.tickets.length === 0;
        },
    },
    mounted() {
        this.loadTicketData();
        if (this.isPaymentForm) {
            this.loadStripeScript();
        }
        if (!this.isCartEmpty) {
            this.loadStartTime();
            this.startTimer();
        }
    },
    methods: {
        startTimer() {
            const interval = setInterval(async () => {
                if (this.time === 0) {
                    clearInterval(interval);
                    this.timeIsUp = true;
                    await this.expireBookings();
                } else {
                    this.time--;
                }
            }, 1000);
        },
        async loadStartTime() {
            try {
                const sessionId = Cookies.get('cart_session_id');
                const response = await axios.post(`/bookings/start-time/${sessionId}`);
                const startTime = response.data.start_time;

                if (startTime) {
                    const now = moment();
                    const start = moment(startTime);
                    const diff = now.diff(start, 'seconds');
                    this.time = Math.max(this.time - diff, 0);

                    if (this.time <= 0) {
                        this.timeIsUp = true;
                        await this.expireBookings();
                    }
                } else {
                    Cookies.set('start_time', moment().toISOString());
                }
            } catch (error) {
                console.error('Error fetching booking start time:', error);
                Cookies.set('start_time', moment().toISOString());
            }
        },
        async expireBookings() {
            try {
                const sessionId = Cookies.get('cart_session_id');
                if (sessionId) {
                    await axios.post(`/bookings/expire-session/${sessionId}`).then(response => {
                        this.clearCookies();
                    });
                }
            } catch (error) {
                console.error('Error expiring bookings:', error);
            }
        },
        goHome() {
            window.location.href = '/'; // Replace with your home route
        },
        sendCustomerData() {
            const form = document.getElementById('customer-data-form');
            form.submit();
        },
        loadTicketData() {
            const tickets = Cookies.get('cart_tickets');
            const total = Cookies.get('cart_total');
            const event = Cookies.get('cart_event');
            if (tickets) {
                this.tickets = JSON.parse(tickets);
            }
            if (total) {
                this.total = total;
            }
            if (event) {
                this.event = event;
            }
        },
        loadStripeScript() {
            const script = document.createElement('script');
            script.src = "https://js.stripe.com/v3/";
            script.onload = this.initStripe;
            document.head.appendChild(script);
        },
        initStripe() {
            const stripe = Stripe(this.stripePublicKey);
            const form = document.querySelector('.stripe-payment-form');

            if (form) {
                form.addEventListener('submit', async (event) => {
                    this.errorMsg = null
                    event.preventDefault();
                    try {
                        const response = await axios.post('/stripe/session', {
                            event_id: this.eventId,
                            tickets: this.tickets,
                            amount: this.convertPriceToFloat(this.total),
                            promoCode: this.promoCode,
                            discount: this.discount ? parseFloat(this.discount.replace(',', '.')) : null,
                            amountDiscount: this.totalWithDiscount ? parseFloat(this.totalWithDiscount.replace(',', '.')) : null,
                        });

                        const data = response.data;
                        if (data.status === 'success') {
                            this.clearCookies();
                            stripe.redirectToCheckout({
                                sessionId: data.sessionId,
                                locale: 'de'
                            });
                        } else {
                            console.error('Payment failed:', data.message);
                            this.errorMsg = 'Etwas ist schief gelaufen. Bitte versuchen Sie es erneut.'
                        }
                    } catch (error) {
                        console.error('Error during payment:', error);
                        this.errorMsg = 'Etwas ist schief gelaufen. Bitte versuchen Sie es erneut.'
                    }
                });
            }
        },
        clearCookies() {
            Cookies.remove('cart_tickets');
            Cookies.remove('cart_bookings');
            Cookies.remove('cart_session_id');
            Cookies.remove('cart_total');
            Cookies.remove('start_time');
        },
        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },
        formatTime(date) {
            return moment(date).format('HH:mm');
        },
        convertPriceToFloat(price) {
            return parseFloat(price.replace(',', ''))
        },
        async applyPromoCode(promoCode) {
            try {
                const response = await axios.post('/checkout/apply-promo-code', {
                    promoCode: promoCode,
                    total: this.convertPriceToFloat(this.total),
                    eventIds: this.tickets.flatMap(el => el.event_id)
                });

                if (response.data.success) {
                    this.totalWithDiscount = this.formatPrice(response.data.newTotal);
                    this.discount = this.formatPrice(response.data.discount);
                    this.promoError = '';
                } else {
                    this.promoError = response.data.message;
                    this.discount = 0.0;
                }
            } catch (error) {
                this.promoError = 'Fehlgeschlagen. Bitte versuchen Sie es erneut.';
                this.discount = 0.0;
                this.totalWithDiscount = this.total
            }
        },
        formatPrice(price) {
            return price.toFixed(2).replace('.', ',');
        }
    }
};

</script>
