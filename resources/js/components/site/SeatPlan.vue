<template>
    <div class="seatmap">
        <div class="container card mb-4 bg-black">
            <div class="text-center text-white py-6">STAGE</div>
        </div>
        <div class="position-relative w-100">
            <div class="seatplan-container">
                <div v-for="(category, categoryIndex) in seatCategories" :key="categoryIndex" class="category">
                    <div class="category-name">{{ category.name }}</div>
                    <div v-for="(row, rowIndex) in category.rows" :key="rowIndex" class="row">
                        <div v-for="(seat, seatIndex) in row" :key="seatIndex" class="seat"
                             :class="{ aisle: seat.aisle, selected: isSelected(categoryIndex, rowIndex, seatIndex) }"
                             @click="!seat.aisle && toggleSeat(categoryIndex, rowIndex, seatIndex)">
                            <span v-if="seat.selected">✓</span>
                            <span v-else-if="!seat.aisle">×</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="selected-seats">
                <h2>Cart</h2>
                <ul>
                    <li v-for="(seat, index) in selectedSeats" :key="index">
                        Category: {{ seat.categoryIndex + 1 }}, Row: {{ seat.rowNumber }}, Seat: {{ seat.number }}, Price: {{ formatPrice(seat.price) }}
                        <button @click="removeSeat(index)" class="delete-button"></button>
                    </li>
                </ul>
                <button @click="proceedToCheckout" type="button" class="checkout-button">Checkout</button>
            </div>
        </div>
        <div>
            <h3>Seat Plan Name: {{ seatPlanName }}</h3>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Cookies from 'js-cookie';
export default {
    props: ['eventId'],
    data() {
        return {
            eventName: '',
            seatPlanName: '',
            seatPlanCategories: [],
            seatCategories: [],
            cart: []
        };
    },
    computed: {
        selectedSeats() {
            return this.cart;
        },
        checkoutTickets() {
            return this.cart.map(seat => ({
                count: 1, // assuming each seat is a separate ticket
                name: `Category: ${seat.categoryIndex + 1}, Row: ${seat.rowNumber}, Seat: ${seat.number}`,
                price: this.formatPrice(seat.price),
                total: this.formatPrice(seat.price), // total is the same as price for a single ticket
                categoryId: seat.categoryIndex + 1, // assuming categoryIndex starts from 0
                categoryName: this.seatCategories[seat.categoryIndex].name
            }));
        }
    },
    created() {
        this.fetchEvent(this.eventId);
    },
    methods: {
        async fetchEvent(eventId) {
            try {
                // Fetch the event data
                const eventResponse = await axios.get(`/api/events/${eventId}`);
                this.eventName = eventResponse.data.name;
                this.seatPlanName = eventResponse.data.seat_plan.name;

                // Fetch the seat plan categories using the seat_plan_id from the event data
                const seatPlanId = eventResponse.data.seat_plan.id;
                const seatPlanCategoriesResponse = await axios.get(`/api/seat_plan_categories/${seatPlanId}`);
                this.seatPlanCategories = seatPlanCategoriesResponse.data; // assign the seat plan categories data

                // Get the seatCount and aislesAfter from the event data
                const seatCount = eventResponse.data.seat_plan.seatCount;
                const aislesAfter = eventResponse.data.seat_plan.aislesAfter.split(',').map(Number); // assuming aislesAfter is a comma-separated string

                // Map the seatPlanCategories to seatCategories
                this.seatCategories = this.seatPlanCategories.map(category => ({
                    name: category.name,
                    rowCount: category.rows, // assuming 'rows' is the correct field for rowCount
                    price: category.price
                }));

                // Generate the seat layout
                this.seatCategories = this.seatCategories.map((category, categoryIndex) => ({
                    ...category,
                    rows: Array(category.rowCount).fill().map((_, rowIndex) => this.generateRow(seatCount, aislesAfter, rowIndex + 1, categoryIndex + 1))
                }));
            } catch (error) {
                console.error(error);
            }
        },
        generateSeatCategories(categories, seatCount, aislesAfter) {
            return categories.map((category, categoryIndex) => ({
                name: category.name,
                price: category.price,
                rows: Array(category.rowCount).fill().map((_, rowIndex) => this.generateRow(seatCount, aislesAfter, rowIndex + 1, categoryIndex + 1))
            }));
        },
        generateRow(seatCount, aislesAfter, rowNumber, categoryIndex) {
            let row = [];
            for (let i = 0; i < seatCount; i++) {
                if (aislesAfter.includes(i)) {
                    row.push({ aisle: true }); // Add an aisle
                    if (aislesAfter.includes(i + 1)) {
                        row.push({ aisle: true }); // Add a second aisle if the next seat is also an aisle
                        i++; // Skip the next seat
                    }
                }
                let seat = { selected: false, number: i + 1, rowNumber, categoryIndex };
                row.push(seat);
            }
            return row;
        },
        isSelected(categoryIndex, rowIndex, seatIndex) {
            let seat = this.seatCategories[categoryIndex].rows[rowIndex][seatIndex];
            return this.cart.some(cartSeat => cartSeat.number === seat.number && cartSeat.rowNumber === seat.rowNumber && cartSeat.categoryIndex === seat.categoryIndex);
        },
        toggleSeat(categoryIndex, rowIndex, seatIndex) {
            let seat = this.seatCategories[categoryIndex].rows[rowIndex][seatIndex];
            let index = this.cart.findIndex(cartSeat => cartSeat.number === seat.number && cartSeat.rowNumber === seat.rowNumber && cartSeat.categoryIndex === seat.categoryIndex);
            if (index !== -1) {
                this.cart.splice(index, 1);
            } else {
                this.cart.push({ ...seat, price: this.seatCategories[categoryIndex].price });
            }
        },
        removeSeat(index) {
            let seat = this.cart[index];
            // Deselect the seat in the seat map
            this.seatCategories[seat.categoryIndex].rows[seat.rowNumber - 1][seat.number - 1].selected = false;
            this.cart.splice(index, 1);
        },
        formatPrice(price) {
            return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(price);
        },
        proceedToCheckout() {
            // Save the ticket data to a cookie
            Cookies.set('cart_tickets', JSON.stringify(this.checkoutTickets));
            Cookies.set('cart_total', this.formatPrice(this.cart.reduce((total, seat) => total + seat.price, 0)));

            // Redirect to the checkout page
            window.location.href = `/checkout?event_id=${this.eventId}`;
        },
    }
};
</script>

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
    background-color: transparent;
    border: none;
    cursor: default;
}

.seat.selected {
    background-color: #4caf50;
    color: white;
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
