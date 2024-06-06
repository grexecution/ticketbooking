<script>
import axios from "axios";
import Cookies from "js-cookie";

export default {
    name: "NoSeatPlan",
    props: {
        eventId: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            discounts: [],
            categories: [],
            errorMsg: '',
            event: {},
        };
    },
    mounted() {
        this.fetchEvent(this.eventId);
    },
    computed: {
        isCheckoutDisabled() {
            // Check if any tickets have been selected
            return this.filterTickets().length === 0;
        }
    },
    methods: {
        showToastMessage() {
            if (this.isCheckoutDisabled) {
                // Replace this with your preferred method of showing a toast message
                alert('Please select tickets to continue');
            }
        },
        async fetchEvent(eventId) {
            try {
                const response = await axios.post(`/api/events/${eventId}`);
                this.processEventData(response.data);
            } catch (error) {
                console.error("Error fetching event data:", error);
            }
        },
        processEventData(data) {
            this.event = data;
            this.processDiscounts(data.discounts);
            this.processCategories(data.seat_plan_categories);
        },
        processDiscounts(discounts) {
            this.discounts = discounts.map(discount => ({
                id: discount.id,
                name: discount.name,
                type: discount.type,
                fixed: discount.fixed,
                percentage: discount.percentage,
                description: discount.description
            }));
        },
        processCategories(categories) {
            this.categories = categories.map(category => {
                const discountPrices = this.calculateDiscountPrices(category);

                return {
                    id: category.id,
                    name: category.name,
                    price: category.price,
                    description: category.description,
                    regularPrice: {
                        name: 'Regular',
                        price: this.formatPrice(category.price),
                        count: 0
                    },
                    discountPrices: discountPrices,
                    showMore: false
                };
            });
        },
        calculateDiscountPrices(category) {
            return this.discounts.map(discount => {
                const price = discount.type === 'percentage'
                    ? category.price - (category.price * (discount.percentage / 100))
                    : category.price - discount.fixed;

                return {
                    discount_id: discount.id,
                    name: discount.name,
                    price: this.formatPrice(price),
                    count: 0
                };
            });
        },
        formatPrice(price) {
            return new Intl.NumberFormat('us-US', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(price);
        },
        filterTickets() {
            return this.categories.flatMap(category => {
                const regularTicket = {
                    count: category.regularPrice.count,
                    name: category.regularPrice.name,
                    price: category.regularPrice.price,
                    total: this.formatPrice(this.convertPriceToFloat(category.regularPrice.price) * category.regularPrice.count),
                    categoryId: category.id,
                    categoryName: category.name,
                    eventName: this.event.name,
                    eventDate: this.formatDate(this.event.start_date),
                    eventTime: this.formatTime(this.event.start_time),
                    eventLocation: `${this.event.venue.city}, ${this.event.venue.country}`,
                };

                const discountTickets = category.discountPrices
                    .filter(() => category.showMore)
                    .map(discountPrice => ({
                        count: discountPrice.count,
                        name: discountPrice.name,
                        price: discountPrice.price,
                        total: this.formatPrice(this.convertPriceToFloat(discountPrice.price) * discountPrice.count),
                        categoryId: category.id,
                        categoryName: category.name,
                        eventName: this.event.name,
                        eventDate: this.formatDate(this.event.start_date),
                        eventTime: this.formatTime(this.event.start_time),
                        eventLocation: `${this.event.venue.city}, ${this.event.venue.country}`,
                    }));

                return [regularTicket, ...discountTickets].filter(ticket => ticket.count > 0);
            });
        },
        calculateTotal(filteredData) {
            const amount = filteredData.reduce((total, item) => {
                const price = this.convertPriceToFloat(item.price);
                return total + (item.count * price);
            }, 0);

            return this.formatPrice(amount)
        },
        convertPriceToFloat(price) {
            return parseFloat(price.replace(',', ''))
        },
        proceedToCheckout() {
            this.errorMsg = null;
            if (this.isCheckoutDisabled) {
                this.showToastMessage();
                return;
            }

            const tickets = this.filterTickets();
            const total = this.calculateTotal(tickets);

            Cookies.set('cart_tickets', JSON.stringify(tickets));
            Cookies.set('cart_total', total);
            Cookies.set('cart_event', this.eventId);
            this.bookTickets(tickets)
        },
        async bookTickets(tickets) {
            try {
                const response = await axios.post(`/bookings/events/${this.eventId}`, {
                    event_id: this.eventId,
                    tickets: tickets,
                });

                Cookies.set('cart_bookings', response.data.bookings);
                Cookies.set('cart_session_id', response.data.session_id);

                window.location.href = `/checkout?event_id=${this.eventId}`;

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
    }
};
</script>

<template>
    <div class="container">
        <div class="px-6 py-2 card">
            <div class="col-12 pb-3">
                <h3 class="pt-4 pb-3 question-styling">Please choose seating category:</h3>

                <div v-for="category in categories" class="category-card mb-3 d-flex justify-content-between">
                    <div class="col-md-3 d-flex flex-row align-items-center">
                        <div class="d-flex flex-col">
                            <h6 class="category-title">{{ category.name }}</h6>
                            <p class="category-desc">{{ category.description }}</p>
                        </div>
                    </div>
                    <div class="col-md-9 d-flex flex-col gap-4">
                        <div class="d-flex flex-row w-100 align-items-center">
                            <div class="d-flex flex-col w-100">
                                <p>Regular Price</p>
                                <small v-if="! category.showMore && category.discountPrices.length > 0" @click="category.showMore = true" class="show-more-options" style="color:#ffc107; text-decoration: underline;">Show more price options</small>
                            </div>
                            <div class="price text-right d-flex">
                                <p class="category-title text-nowrap">€ {{ category.regularPrice.price }}</p>
                            </div>
                            <div class="quantity-selector">
                                <button @click="category.regularPrice.count > 0 ? category.regularPrice.count-- : 0" type="button" class="btn">-</button>
                                <span class="px-3">{{ category.regularPrice.count }}</span>
                                <button @click="category.regularPrice.count++" type="button" class="btn">+</button>
                            </div>
                        </div>
                        <hr v-if="category.showMore">
                        <div v-if="category.showMore" v-for="discount in category.discountPrices" class="d-flex flex-row w-100 d-flex flex-row w-100 align-items-center">
                            <div class="d-flex flex-col w-100">
                            <p>{{ discount.name }} Price</p>
                            </div>
                            <div class="price text-right d-flex">
                                <p class="category-title text-nowrap">€ {{ discount.price }}</p>
                            </div>
                            <div class="quantity-selector">
                                <button @click="discount.count > 0 ? discount.count-- : 0" type="button" class="btn">-</button>
                                <span class="px-3">{{ discount.count }}</span>
                                <button @click="discount.count++" type="button" class="btn">+</button>
                            </div>
                        </div>
                        <small v-if="category.showMore" @click="category.showMore = false" class="text-start show-less-options" style="color:#ffc107; text-decoration: underline;">Show less options</small>
                    </div>
                </div>

                <div class="text-right">
                    <div v-if="errorMsg" class="text-danger" style="text-align: center; padding: 10px 0 5px 0;">{{ errorMsg }}</div>
                    <a @click.prevent="proceedToCheckout"
                       :disabled="isCheckoutDisabled"
                       type="button"
                       class="btn-orange checkout-btn">Weiter zum Checkout</a>
                </div>
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
