<template>
    <div class="seatmap">
        <div v-for="(category, categoryIndex) in seatCategories" :key="categoryIndex" class="category">
            <div class="category-name">{{ category.name }}</div>
            <div v-for="(row, rowIndex) in category.rows" :key="rowIndex" class="row">
                <div v-for="(seat, seatIndex) in row" :key="seatIndex" class="seat" :class="{ aisle: seat.aisle, selected: seat.selected }" @click="!seat.aisle && selectSeat(categoryIndex, rowIndex, seatIndex)">
                    <span v-if="seat.selected">✓</span>
                    <span v-else-if="!seat.aisle">×</span>
                </div>
            </div>
        </div>
        <div class="selected-seats">
            <h2>Cart:</h2>
            <ul>
                <li v-for="(seat, index) in selectedSeats" :key="index">
                    Category: {{ seat.categoryIndex + 1 }}, Row: {{ seat.rowNumber }}, Seat: {{ seat.number }}
                    <button @click="removeSeat(index)"></button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            seatCategories: [],
            cart: []
        };
    },
    computed: {
        selectedSeats() {
            return this.cart;
        }
    },
    created() {
        this.seatCategories = this.generateSeatCategories([
            { name: 'VIP', rowCount: 3 },
            { name: 'Category A', rowCount: 6 },
            { name: 'Category B', rowCount: 10 },
            // Add more categories as needed
        ], 12, [8]); // 14 seats per row, double aisle after the 7th and 8th seats
    },
    methods: {
        generateSeatCategories(categories, seatCount, aislesAfter) {
            return categories.map((category, categoryIndex) => ({
                name: category.name,
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
        selectSeat(categoryIndex, rowIndex, seatIndex) {
            let seat = this.seatCategories[categoryIndex].rows[rowIndex][seatIndex];
            seat.selected = !seat.selected;
            if (seat.selected) {
                this.cart.push(seat);
            } else {
                let index = this.cart.indexOf(seat);
                if (index !== -1) {
                    this.cart.splice(index, 1);
                }
            }
        },
        removeSeat(index) {
            let seat = this.cart[index];
            seat.selected = false;
            this.cart.splice(index, 1);
        }
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
    background-color: white;
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

.selected-seats button {
    background: none;
    border: none;
    cursor: pointer;
    color: red;
}

.selected-seats button:before {
    content: "\2715";
    font-size: 16px;
}
</style>
