<template>
    <!-- Prices -->
    <div class="row mt-4">
        <div class="col-md-12 mb-4">
            <h4>Prices</h4>
            <!-- First Row - Seating Options -->
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="seating">Seating</label>
                        <span v-if="bookingCount > 0" class="float-right text-muted">Price type can no longer be changed</span>
                        <div class="form-check">
                            <input v-model="seatType" class="form-check-input" type="radio" name="seat_type" id="seat_plan" value="seat_plan" checked :disabled="disabled">
                            <label class="form-check-label" for="seatplan">
                                Seatplan Selection
                            </label>
                        </div>
                        <div class="form-check">
                            <input v-model="seatType" class="form-check-input" type="radio" name="seat_type" id="no_seat_plan" value="no_seat_plan" :disabled="disabled">
                            <label class="form-check-label" for="no_seatplan">
                                No Seat Selection
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <div v-if="seatType === 'seat_plan'" class="form-group">
                        <label for="seating">Seating plan</label>
                        <span class="float-right text-muted">Seating plan can no longer be changed</span>
                        <select class="form-control" id="seating" :disabled="disabled">
                            <option value="seatplan">Orpheum Vienna Medium (320 seats)</option>
                            <option value="no_seatplan">Orpheum Vienna Small (150 seats)</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Second Row - Pricing Table -->
            <div v-if="seatType === 'seat_plan'" class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Places</th>
                            <th>Price (€)</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" class="form-control" value="Category A" :disabled="disabled"></td>
                            <td><input type="text" class="form-control" placeholder="Enter description text" :disabled="disabled"></td>
                            <td><input type="number" class="form-control" value="10" :disabled="disabled"></td>
                            <td><input type="number" class="form-control" value="28" :disabled="disabled"></td>
                            <td>
                                <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-if="seatType === 'no_seat_plan'" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="seating">Amount of seats</label>
                        <input v-model="seatAmount" type="number" step="1" min="0" class="form-control" :id="seatAmount" name="seat_amount" placeholder="0" :disabled="disabled" />
                    </div>
                </div>
                <div class="col-md-9"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        initSeatType: String,
        initSeatAmount: Number,
        status: String,
    },
    data() {
        return {
            seatType: this.initSeatType,
            seatAmount: this.initSeatAmount,
            bookingCount: 0,
            disabled: false,
        }
    },
    mounted() {
        if (this.status === 'ended') {
            this.disabled = true
        }
    },
    watch: {
        initSeatType: {
            handler(oldVal, newVal) {
                this.seatType = newVal;
            }
        },
    }
}
</script>

<style scoped>

</style>
