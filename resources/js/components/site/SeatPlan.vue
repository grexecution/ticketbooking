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
            this.boughtTickets = this.generateBoughtTickets(data.orders);
            this.seatCategories = this.generateSeatCategories(data.seat_plan_categories);
        },
        generateBoughtTickets(orders) {
            const boughtTickets = [];
            orders.forEach(order => {
                const tickets = order.tickets.map(ticket => ({
                    ticketId: ticket.id,
                    categoryId: ticket.event_seat_plan_category_id,
                    categoryName: ticket.category_name,
                    row: ticket.row,
                    seat: ticket.seat,
                }));
                boughtTickets.push(...tickets);
            });
            return boughtTickets;
        },
        generateSeatCategories(categories) {
            return categories.map((category, categoryIndex) => {
                const aislesAfterArr = category.aisles_after.split(',').map(Number);
                return {
                    id: category.id,
                    name: category.name,
                    price: category.price,
                    rows: Array(category.rows)
                        .fill()
                        .map((_, rowIndex) => {
                            return this.generateRow(category.seats, aislesAfterArr, rowIndex + 1, categoryIndex + 1, category.id, category.name)
                        })
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
            let seat = this.seatCategories[categoryIndex].rows[rowIndex][seatIndex];
            seat.selected = !seat.selected;
            if (seat.selected) {
                this.cart.push({ ...seat, price: this.seatCategories[categoryIndex].price });
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
                    count: 1,
                    name: 'Regular',
                    price: category.price,
                    row: category.number,
                    seat: category.seatNumber,
                    total: this.formatPrice(category.price),
                    categoryId: category.categoryId,
                    categoryName: category.categoryName,
                    eventName: this.event.name,
                    eventDate: this.formatDate(this.event.start_date),
                    eventTime: this.formatTime(this.event.start_time),
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
        formatDate(date) {
            return date ? new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) : '';
        },
        formatTime(time) {
            return time ? new Date(time).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric' }) : '';
        },
    }
};
</script>

<template>
    <div class="seatmap">
        <div v-for="(category, categoryIndex) in seatCategories" :key="categoryIndex" class="category">
            <div class="category-name">{{ category.name }}</div>
            <div v-for="(row, rowIndex) in category.rows" :key="rowIndex" class="row">
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
                    <span v-else-if="!seat.aisle">×</span>
                </div>
            </div>
        </div>
        <div v-if="cart.length" class="selected-seats">
            <h2>Cart:</h2>
            <ul>
                <li v-for="(seat, index) in selectedSeats" :key="index">
                    Category: {{ seat.categoryName }}, Row: {{ seat.number }}, Seat: {{ seat.seatNumber }}, Price: {{ formatPrice(seat.price) }}
                    <button @click="removeSeat(seat)" class="delete-button"></button>
                </li>
            </ul>
            <div v-if="errorMsg" class="text-danger" style="text-align: center; padding: 10px 0 5px 0;">{{ errorMsg }}</div>
            <button @click.prevent="proceedToCheckout"
                    :disabled="cart.length === 0"
                    type="button"
                    class="btn-orange checkout-btn"
            >Weiter zum Checkout</button>
        </div>
    </div>
</template>

<style scoped>
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
    background-color: white;
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
    position: absolute;
    top: 0;
    right: 0;
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
    background: none;
    border: none;
    cursor: pointer;
    color: red;
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
</style>
