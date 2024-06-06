<script>
import axios from "axios";
import Cookies from "js-cookie";

export default {
    name: "Subscription",
    props: {
        subscriptionId: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            subscription: {},
            events: [],
            errorMsg: '',
        };
    },
    mounted() {
        this.fetchSubscription(this.subscriptionId);
    },
    methods: {
        async fetchSubscription(subscriptionId) {
            try {
                const response = await axios.get(`/api/subscriptions/${subscriptionId}`);
                this.subscription = response.data;
                console.log('response.data', response.data);
                this.processEvents(response.data.eventsLive)
            } catch (error) {
                console.error("Error fetching subscription data:", error);
                this.errorMsg = "Error fetching subscription data";
            }
        },
        processEvents(events) {
            this.events = events.map(event => {
                event.seat_plan_categories_for_subscriptions = event.seat_plan_categories_for_subscriptions.map(category => {
                    return {
                        id: category.id,
                        event_id: event.id,
                        subscription_id: this.subscriptionId,
                        categoryName: category.name,
                        price: category.price,
                        total: this.formatPrice(category.price),
                        description: category.description,
                        name: 'Subscription',
                        count: 0,
                        eventName: event.name,
                        eventDate: this.formatDate(event.start_date),
                        eventTime: this.formatTime(event.start_time),
                        eventLocation: `${event.venue.city}, ${event.venue.country}`,
                    };
                });
                return event;
            });
        },
        filterTickets(events) {
            const categories = [];
            events.forEach(event => {
                event.seat_plan_categories_for_subscriptions.forEach(category => {
                    if (category.count > 0) {
                        category.total = this.formatPrice(category.price * category.count);
                        categories.push(category);
                    }
                });
            });
            return categories;
        },
        proceedToCheckout() {
            this.errorMsg = null;
            if (this.isCheckoutDisabled) {
                this.showToastMessage('Please select tickets to continue');
                return;
            }
            if (this.subscription.used >= this.subscription.max_usage) {
                this.errorMsg = 'The number of subscriptions issued reached a maximum';
                return;
            }

            const tickets = this.filterTickets(this.events);
            const total = this.calculateTotal(tickets);

            Cookies.set('cart_tickets', JSON.stringify(tickets));
            Cookies.set('cart_total', total);
            Cookies.set('cart_event', this.eventId);

            this.bookTickets(tickets)
        },
        calculateTotal(tickets) {
            const amount = tickets.reduce((total, item) => {
                const price = item.price;
                return total + (item.count * price);
            }, 0);

            return this.formatPrice(amount)
        },
        async bookTickets(tickets) {
            try {
                const response = await axios.post(`/bookings/bookSubscriptionTickets`, {
                    event_id: this.eventId,
                    tickets: tickets,
                });

                Cookies.set('cart_bookings', response.data.bookings);
                Cookies.set('cart_session_id', response.data.session_id);

                window.location.href = `/checkout`;

            } catch (error) {
                if (error.response && error.response.data) {
                    this.errorMsg = error.response.data.message;
                    console.error('Booking error:', error.response.data.errors);
                    this.showToastMessage('Booking error:' + error.response.data.errors);
                } else {
                    this.errorMsg = 'An unexpected error occurred. Please try again.';
                    console.error('There was an error processing the checkout:', error);
                    this.showToastMessage('Error booking the tickets. Please try again.');
                }
            }
        },
        convertPriceToFloat(price) {
            return parseFloat(price.replace(',', ''))
        },
        formatDate(date) {
            return date ? new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) : '';
        },
        formatTime(time) {
            return time ? new Date(time).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric' }) : '';
        },
        showToastMessage(message) {
            if (this.isCheckoutDisabled) {
                alert(message);
            }
        },
        formatPrice(price) {
            return parseFloat(price).toFixed(2);
        },
    }
};
</script>

<template>
    <div class="container">
        <!-- Existing subscription details -->
        <div class="col py-6 mb-5 container m-auto gap-2">
            <h2 class="sub-subheadline">Events included in this Subscription:</h2>
            <div v-for="event in events" :key="event.id" class="card my-3 rounded overflow-hidden">
                <div class="d-flex">
                    <div class="col-md-3 p-0">
                        <img :src="event.logo_event_url" class="img-fluid event-image" alt="Event Image">
                    </div>
                    <div class="card-body py-6">
                        <h5 class="mb-1 sub-event-title">{{ event.name }}</h5>
                        <div>
                            <p class="card-text" v-html="event.short_desc"></p>
                        </div>
                        <div class="row mt-3">
                            <div class="col d-flex gap-6">
                                <div class="event-detail">
                                    <i class="fas fa-calendar-alt"></i> {{ formatDate(event.start_date) }} | {{ formatTime(event.start_time) }}
                                </div>
                                <div class="event-detail">
                                    <i class="fas fa-map-marker-alt"></i> {{ event.venue?.name || '' }}
                                </div>
                                <div class="event-detail">
                                    <i class="fas fa-money-bill"></i> Preis ab €{{ event.price || 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category selection section -->
                <div class="px-6 py-2 card">
                    <div class="col-12 pb-3">
                        <h3 class="pt-4 pb-3 question-styling">Please choose seating category:</h3>
                        <div v-for="category in event.seat_plan_categories_for_subscriptions" class="category-card mb-3 d-flex justify-content-between">
                            <div class="col-md-3 d-flex flex-row align-items-center">
                                <div class="d-flex flex-col">
                                    <h6 class="category-title">{{ category.categoryName }}</h6>
                                    <p class="category-desc">{{ category.description }}</p>
                                </div>
                            </div>
                            <div class="col-md-9 d-flex flex-col gap-4">
                                <div class="d-flex flex-row w-100 align-items-center">
                                    <div class="d-flex flex-col w-100">
                                        <p>Subscription Price</p>
                                    </div>
                                    <div class="price text-right d-flex">
                                        <p class="category-title text-nowrap">€ {{ category.price }}</p>
                                    </div>
                                    <div class="quantity-selector">
                                        <button @click="category.count > 0 ? category.count-- : 0" type="button" class="btn">-</button>
                                        <span class="px-3">{{ category.count }}</span>
                                        <button @click="category.count++" type="button" class="btn">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div v-if="errorMsg" class="text-danger" style="text-align: center; padding: 10px 0 5px 0;">{{ errorMsg }}</div>
                <a @click.prevent="proceedToCheckout" :disabled="isCheckoutDisabled" type="button" class="btn-orange checkout-btn">Weiter zum Checkout</a>
            </div>
        </div>
    </div>
</template>

<style scoped>
.category-card {
    display: flex;
    align-items: flex-start;
    padding: 25px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #f8f9fa;
}
.category-card .description {
    flex-grow: 1;
    margin-left: 15px;
}
.category-card .price {
    margin-right: 15px;
}
.category-card .custom-radio {
    margin-right: 10px;
}
.quantity-selector {
    display: flex;
    align-items: center;
    justify-content: center;
}
.quantity-selector button {
    width: 40px;
    height: 40px;
    font-size: 18px;
    font-weight: 600;
    border: none;
    color: #fff;
    border-radius: 5px;
    margin: 0 5px;
    background-color: #ffc107;
    border-color: #ffc107;
    -webkit-box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
    box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
    height: calc(2.75rem + 2px);
}
.checkout-btn {
    background-color: #ffc107;
    border: none;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
}
.btn-orange {
    background-color: #ffc107;
    border-color: #ffc107;
    -webkit-box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
    box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
    height: calc(2.75rem + 2px);
}
.question-styling {
    font-size: 18px;
    font-weight: 600;
}
.category-title {
    font-size: 16px;
    font-weight: 600;
}
.category-desc {
    font-size: 14px;
    font-weight: 400;
}
.show-more-options {
    cursor: pointer;
}
.show-less-options {
    cursor: pointer;
}
</style>

