<template>
    <div class="order-summary">
        <div class="ticket-warning">Tickets are still available for: 09:48 min.</div>
        <div class="mt-3" v-for="(item, index) in tickets" :key="index">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <p class="co-price-text">{{ item.count }} x {{ eventName }}</p>
                    <p class="co-price-details">{{ eventDate }} | {{ eventTime }}</p>
                    <p class="co-price-details">{{ eventLocation }}</p>
                    <p class="co-price-details">{{ item.categoryName }} | Ticket: {{ item.name }}</p>
                </div>
                <p>€{{ item.total }}</p>
            </div>
        </div>
        <hr class="my-3">
        <div class="d-flex flex-row justify-content-between">
            <h5 style="font-weight:700">Total:</h5>
            <h5 style="font-weight:700">€{{ total }}</h5>
        </div>
        <form :action="actionUrl" :class="{ 'stripe-payment-form': isPaymentForm }" method="get">
            <input type="hidden" name="event_id" :value="eventId">
            <button type="submit" class="btn btn-continue btn-block mt-3">{{ isPaymentForm ? 'Buy Now' : 'Select Payment' }}</button>
        </form>
        <div class="d-flex justify-content-center">
            <small class="text-secondary">Ticketpreise enthalten 13% Umsatzsteuer</small>
        </div>
    </div>
</template>

<script>
import Cookies from 'js-cookie';
import axios from "axios";
import moment from "moment";

export default {
    name: 'OrderSummary',
    props: {
        actionUrl: {
            type: String,
            required: true
        },
        eventId: {
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
    data() {
        return {
            tickets: [],
            total: '0,00',
            eventName: '',
            eventDate: '',
            eventTime: '',
            eventLocation: ''
        };
    },
    mounted() {
        this.fetchEvent(this.eventId);
        this.loadTicketData();
        if (this.isPaymentForm) {
            this.loadStripeScript();
        }
    },
    methods: {
        async fetchEvent(eventId) {
            try {
                const response = await axios.post(`/api/events/${eventId}`);
                this.processEventData(response.data);
            } catch (error) {
                console.error("Error fetching event data:", error);
            }
        },
        processEventData(data) {
            this.eventName = data.name;
            this.eventDate = this.formatDate(data.start_date);
            this.eventTime = this.formatTime(data.start_time);
            this.eventLocation = `${data.venue.city}, ${data.venue.country}`;
        },
        loadTicketData() {
            const tickets = Cookies.get('cart_tickets');
            const total = Cookies.get('cart_total');
            if (tickets) {
                this.tickets = JSON.parse(tickets);
            }
            if (total) {
                this.total = total;
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
                    event.preventDefault();

                    try {
                        const response = await axios.post('/stripe/session', {
                            event_id: this.eventId,
                            amount: this.convertPriceToFloat(this.total),
                        });

                        const data = response.data;
                        if (data.status === 'success') {
                            this.clearCookies();
                            stripe.redirectToCheckout({ sessionId: data.sessionId });
                        } else {
                            console.error('Payment failed:', data.message);
                        }
                    } catch (error) {
                        console.error('Error during payment:', error);
                    }
                });
            }
        },
        clearCookies() {
            Cookies.remove('cart_tickets');
            Cookies.remove('cart_total');
        },
        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },
        formatTime(date) {
            return moment(date).format('HH:mm');
        },
        convertPriceToFloat(price) {
            return parseFloat(price.replace('.', ',').replace(',', ''));
        },
    }
};
</script>
