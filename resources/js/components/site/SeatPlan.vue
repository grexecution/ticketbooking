<script>
import axios from 'axios';
import Cookies from "js-cookie";

export default {
    name: "SeatPlan",
    props: {
        eventId: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            discounts: [],
            seatCategories: [],
            categories: [],
            bookings: [],
            boughtTickets: [],
            cart: [],
            errorMsg: '',
            event: {},
        };
    },
    computed: {
        selectedSeats() {
            return this.cart;
        }
    },
    created() {
        this.fetchEvent(this.eventId);
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
            this.event = data;
            this.bookings = data.bookings;
            this.processDiscounts(data.discounts);
            this.boughtTickets = this.generateBoughtTickets(data.orders);
            this.seatCategories = this.generateSeatCategories(data.seat_plan_categories);
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
        generateBoughtTickets(orders) {
            const boughtTickets = [];
            orders.forEach(order => {
                if (order.order_status === 'succeeded' || (order.order_status === 'new' && order.wait_to_payment)) {
                    const tickets = order.tickets.map(ticket => ({
                        ticketId: ticket.id,
                        categoryId: ticket.event_seat_plan_category_id,
                        categoryName: ticket.category_name,
                        row: ticket.row,
                        seat: ticket.seat,
                    }));
                    boughtTickets.push(...tickets);
                }
            });
            return boughtTickets;
        },
        generateSeatCategories(categories) {
            return categories.map((category, categoryIndex) => {
                const aislesAfterArr = category.aisles_after.split(',').map(Number);
                const discountPrices = this.calculateDiscountPrices(category);
                const regularPrice = {
                    name: 'Regular',
                    price: category.price,
                    count: 0,
                }

                return {
                    id: category.id,
                    name: category.name,
                    price: category.price, // uses by default
                    prices: [regularPrice, ...discountPrices],
                    rows: Array(category.rows)
                        .fill()
                        .map((_, rowIndex) => {
                            return this.generateRow(category.seats, aislesAfterArr, rowIndex + 1, categoryIndex + 1, category.id, category.name)
                        })
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
                    price: price,
                    count: 0
                };
            });
        },
        generateRow(seatCount, aislesAfter, rowNumber, categoryIndex, categoryId, categoryName) {
            let row = [];
            for (let i = 0; i < seatCount; i++) {
                if (aislesAfter.includes(i)) {
                    row.push({ aisle: true }); // Add an aisle
                    // if (aislesAfter.includes(i + 1)) {
                    //     row.push({ aisle: true }); // Add a second aisle if the next seat is also an aisle
                    //     i++; // Skip the next seat
                    // }
                }
                let seatNumber = i + 1;
                let isBooked = this.bookings.some(booking => {
                    return booking.row === rowNumber && booking.seat === seatNumber && booking.event_seat_plan_category_id === categoryId;
                });
                let isBought = this.boughtTickets.some(ticket => {
                    return ticket.row === rowNumber && ticket.seat === seatNumber && ticket.categoryId === categoryId;
                });
                let seat = {
                    selected: false,
                    booked: isBooked || isBought || false,
                    number: rowNumber,
                    seatNumber,
                    categoryIndex,
                    categoryId,
                    categoryName
                };
                row.push(seat);
            }
            return row;
        },
        selectSeat(categoryIndex, rowIndex, seatIndex) {
            const category = this.seatCategories[categoryIndex]
            let seat = category.rows[rowIndex][seatIndex];
            seat.selected = !seat.selected;
            if (seat.selected) {
                this.cart.push({
                    ...seat,
                    price: this.seatCategories[categoryIndex].price,
                    prices: category.prices
                });
            } else {
                let index = this.cart.findIndex(cartSeat => cartSeat.number === seat.number && cartSeat.rowNumber === seat.rowNumber && cartSeat.categoryIndex === seat.categoryIndex);
                if (index !== -1) {
                    this.cart.splice(index, 1);
                }
            }
        },
        removeSeat(seat) {
            let index = this.cart.findIndex(cartSeat => cartSeat.number === seat.number && cartSeat.rowNumber === seat.rowNumber && cartSeat.categoryIndex === seat.categoryIndex);
            if (index !== -1) {
                this.cart.splice(index, 1);
            }
            const category = this.seatCategories.find(el => el.id === seat.categoryId)
            const row = category.rows.find(row => row.some(el => el.number === seat.number));
            const rowSeat = row.find(el => el.seatNumber === seat.seatNumber)
            if (rowSeat) {
                rowSeat.selected = false;
            }
        },
        proceedToCheckout() {
            this.errorMsg = null;
            if (! this.cart.length) {
                this.errorMsg = 'Cart is empty';
                return;
            }

            const tickets = this.filterTickets();
            const total = this.calculateTotal(tickets);

            Cookies.set('cart_tickets', JSON.stringify(tickets));
            Cookies.set('cart_total', total);
            Cookies.set('cart_event', this.eventId);

            this.bookTickets(tickets)
        },
        filterTickets() {
            return this.cart.flatMap(category => {
                return {
                    event_id: this.event.id,
                    count: 1,
                    name: 'Regular',
                    price: category.price,
                    prices: category.prices, // uses when there are some discounts
                    row: category.number,
                    seat: category.seatNumber,
                    total: this.formatPrice(category.price),
                    categoryId: category.categoryId,
                    categoryName: category.categoryName,
                    eventName: this.event.name,
                    eventDate: this.formatDate(this.event.start_date),
                    eventTime: this.event.carbon_start_time,
                    eventLocation: `${this.event.venue.city}, ${this.event.venue.country}`,
                };
            });
        },
        calculateTotal(tickets) {
            const amount = tickets.reduce((total, item) => total + item.price, 0);
            return this.formatPrice(amount)
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
        formatPrice(price) {
            return new Intl.NumberFormat('us-US', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(price);
        },
        /*formatDate(date) {
            return date ? new Date(date).toLocaleDateString('de', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC' }) : '';
        },*/
        formatDate(date) {
            if (!date) return '';
            let localDate = new Date(date);
            localDate.setUTCHours(0,0,0,0);
            return localDate.toLocaleDateString('de', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC' });
        },
        formatTime(time) {
            return time ? new Date(time).toLocaleTimeString('de', { hour: 'numeric', minute: 'numeric', timeZone: 'UTC' }) : '';
        },
    }
};
</script>

<template>
    <div class="seatmap">
        <div v-for="(category, categoryIndex) in seatCategories" :key="categoryIndex" class="category">
            <div v-if="categoryIndex === 0" class="bg-black text-white py-6 mb-3 category-name w-100 w-md-50 text-center"><p>BÜHNE</p></div>
            <div class="category-name px-3 py-2 mb-2" style="background-color: #ffc107; color: black; font-size:18px;font-weight:600; border-radius: 10px">{{ category.name }}</div>
            <div class="category-seats px-3">
                <div v-for="(row, rowIndex) in category.rows" :key="rowIndex" class="row seat-overflow">
                    <div v-for="(seat, seatIndex) in row"
                         @click="!seat.aisle && !seat.booked && selectSeat(categoryIndex, rowIndex, seatIndex)"
                         :key="seatIndex" class="seat"
                         :class="{
                         aisle: seat.aisle,
                         selected: seat.selected,
                         booked: seat.booked
                     }"
                    >
                        <span v-if="seat.selected">✓</span>
                        <span v-if="seat.booked">x</span>
                        <span v-else-if="!seat.aisle"> </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="selected-box">
            <div class="selected-cats">
                <h2 class="cart-heading">Kategorien</h2>
                <hr>
                <div class="d-flex flex-col pt-2 gap-2">
                    <div v-for="(category, categoryIndex) in seatCategories" :key="categoryIndex" class="category d-flex flex-row gap-2 justify-content-between">
                        <div class="" >{{ category.name }}</div>
                        <div class="" >€{{ formatPrice(category.price) }}</div>
                    </div>
                </div>
            </div>
            <div class="selected-seats">
                <h2 class="cart-heading">Warenkorb</h2>
                <hr>
                <ul class="seat-list pb-2">
                    <li v-for="(seat, index) in selectedSeats" :key="index">
                        <div class="d-flex col px-0 py-2 gap-2 justify-content-between">
                            <div>
                                <p>1x {{ seat.categoryName }}</p>
                                <div class="d-flex flex-col px-0">
                                    <small>Reihe: {{ seat.number }}, Platz: {{ seat.seatNumber }}</small>
                                    <small v-if="seat.prices.length === 1"><strong>Preis: {{ formatPrice(seat.price) }}</strong></small>
                                    <div v-if="seat.prices.length > 1">
                                        <label>Preis: </label>
                                        <select v-model="seat.price" class="form-control">
                                            <option v-for="(price, index) in seat.prices" :key="index" :value="price.price">€{{ formatPrice(price.price) }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button @click="removeSeat(seat)" class="delete-button" style=""></button>
                        </div>
                        <hr>
                    </li>
                </ul>
                <div v-if="errorMsg" class="text-danger" style="text-align: center; padding: 10px 0 5px 0;">{{ errorMsg }}</div>
                <button @click.prevent="proceedToCheckout"
                        :disabled="cart.length === 0"
                        type="button"
                        class="btn btn-orange checkout-btn w-100 mt-2"
                ><i class="fas fa-money-bill mr-2"></i>Weiter zur Kassa</button>
            </div>
        </div>

    </div>
</template>

<style scoped>
.cart-heading {
    text-align: center;
    margin-bottom: 10px!important;
    font-size: 18px;
    font-weight: 600;
}
.seatmap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    position: relative;
}

.category-name {
    font-weight: bold;
    text-align: center;
}

.row {
    display: flex;
    justify-content: center;
}

.seat {
    width: 30px;
    height: 30px;
    border: 1px solid black;
    border-radius: 5px;
    margin: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.seat:hover {
    background-color: #ddd;
}

.seat.aisle {
    background-color: unset;
    border: none;
    cursor: default;
}

.seat.selected {
    background-color: #4caf50;
    color: white;
}

.seat.booked {
    background-color: #ccc;
    color: #888;
    cursor: not-allowed;
}

.selected-seats {
    position: relative;
    width: 300px;
    background-color: white;
    border: 1px solid #ddd;
    padding: 20px;
    z-index: 1;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    max-height: 550px;
    overflow: scroll;
}

.selected-box {
    position: absolute;
    display: flex;
    flex-direction: column;
    gap:20px;
    top: 0;
    right: 10px;
}

.selected-cats {
    width: 300px;
    background-color: white;
    border: 1px solid #ddd;
    padding: 20px;
    z-index: 1;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.selected-seats h2 {
    text-align: center;
    margin-bottom: 20px;
}

.delete-button {
    border: none;
    cursor: pointer;
    width: 30px;
    height: 30px;
    background-color:#d9d9d9;
    border-radius: 10px;
    color: black;
}

.delete-button:before {
    content: "\2715";
    font-size: 16px;
}
.checkout-button {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

.btn-orange {
    background-color: #ffc107;
    border-color: #ffc107;
    -webkit-box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
    box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
    height: calc(2.75rem + 2px);
    font-weight: 600;
    color: white;
}

@media (max-width:480px) {
    .selected-seats {
        position: fixed;
        bottom: 0;
        top: unset;
        right: 0;
        width: 100%;
        max-height: 330px;
        background-color: white;
        border: 1px solid #ddd;
        padding: 20px;
        z-index: 1;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .seat-list {
        overflow: scroll;
        max-height: 150px;
    }

    .seat-overflow {
        flex-wrap: nowrap!important;
        overflow: visible;
    }
    .seatmap {
        overflow: scroll;
        align-items: baseline;
    }
    .selected-box {
        position: relative;
        right: 0;
    }
}
</style>
