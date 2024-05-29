<script>
import axios from "axios";

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
            defaultSeatPlans: [],
            customSeatPlan: {},
            activeSeatPlan: {},
            selectedSeatPlanId: null,
        }
    },
    mounted() {
        if (this.status === 'ended') {
            this.disabled = true
        }

        this.fetchSeatPlans()
    },
    watch: {
        seatType: {
            handler(oldVal, newVal) {
                this.handleSeatTypeChange(newVal, oldVal);
            }
        },
    },
    methods: {
        handleSeatTypeChange(newVal, oldVal) {
            if (newVal === 'no_seat_plan') {
                this.activeSeatPlan = this.defaultSeatPlans[0]
                this.selectedSeatPlanId = this.activeSeatPlan.id
            } else if (newVal === 'seat_plan') {
                this.activeSeatPlan = this.customSeatPlan
            }
        },
        handleActivePlanChange() {
            const selectedId = this.selectedSeatPlanId;
            this.activeSeatPlan = this.defaultSeatPlans.find(seatPlan => seatPlan.id === selectedId)
        },
        handleDeleteCategory(id) {
            this.activeSeatPlan.seat_plan_categories = this.activeSeatPlan.seat_plan_categories.filter(seatCat => seatCat.id !== id)
        },
        handleAddCategory() {
            this.activeSeatPlan.seat_plan_categories.push({
                id: null,
                name: '',
                places: 0,
                price: 0,
                description: '',
                seat_plan_id: this.activeSeatPlan.id,
            })
        },
        fetchSeatPlans() {
            axios.post('/admin/event/getDefaultSeatPlans').then(response=>{
                this.customSeatPlan = response.data.find(seatPlan => seatPlan.is_custom)
                this.defaultSeatPlans = response.data.filter(seatPlan => ! seatPlan.is_custom)
                this.activeSeatPlan = this.customSeatPlan
            }).catch(error=>{
                console.log(error)
            })
        }
    }
}
</script>

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
                        <select class="form-control" id="seating" v-model="selectedSeatPlanId" @change="handleActivePlanChange" :disabled="disabled">
                            <option v-for="seatPlan in defaultSeatPlans" :key="seatPlan.id" :value="seatPlan.id" :selected="selectedSeatPlanId === seatPlan.id">{{ seatPlan.name }} ({{ seatPlan.places }} seats)</option>
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
                        <tr v-for="category in activeSeatPlan.seat_plan_categories" :key="category.id">
                            <td><input type="text" class="form-control" :value="category.name" :disabled="disabled"></td>
                            <td><input type="text" class="form-control" :value="category.description" placeholder="Enter description text" :disabled="disabled"></td>
                            <td>{{ category.places }}</td>
                            <td><input type="number" class="form-control" :value="category.price" :disabled="disabled" min="0.1" step="0.1"></td>
                            <td>
                                <a @click="handleDeleteCategory(category.id)" class="btn btn-danger mx-2 delete-record">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">
                                <a @click="handleAddCategory" class="btn btn-success mx-2">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-if="seatType === 'no_seat_plan'" class="row">
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
                        <tr v-for="category in activeSeatPlan.seat_plan_categories" :key="category.id">
                            <td><input type="text" class="form-control" :value="category.name" :disabled="disabled"></td>
                            <td><input type="text" class="form-control" :value="category.description" placeholder="Enter description text" :disabled="disabled"></td>
                            <td><input type="number" class="form-control" :value="category.places" :disabled="disabled" min="1" step="1"></td>
                            <td><input type="number" class="form-control" :value="category.price" :disabled="disabled" min="0.1" step="0.1"></td>
                            <td>
                                <a @click="handleDeleteCategory(category.id)" class="btn btn-danger mx-2 delete-record">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">
                                <a @click="handleAddCategory" class="btn btn-success mx-2">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
