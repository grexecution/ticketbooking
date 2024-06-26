<template>
    <div class="row mt-4">
        <div class="col-md-12 mb-4">
            <div class="row">
                <div class="col-md-2">
                    <div>Add events</div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-right" style="padding-bottom: 4px">
                                <span v-if="!hasBoughtTickets" class="btn btn-info btn-xs select-all" style="border-radius: 0">Select All</span>
                                <span v-if="!hasBoughtTickets" class="btn btn-info btn-xs deselect-all" style="border-radius: 0">Deselect All</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <select v-model="selected" name="event_ids[]" class="form-control select2" id="selectEvent" multiple="multiple" :disabled="hasBoughtTickets">
                                <option v-for="event in allEvents" :value="event.id">{{ event.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Seat Category</th>
                            <th>Sales volume</th>
                            <th>
                                <button @click="dividePrice" type="button" class="btn btn-dark" :disabled="hasBoughtTickets">
                                    Divide aliquots
                                    <i class="fas fa-arrows-alt-h ml-auto"></i>
                                </button>
                            </th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(selectedEvent, index) in selectedEvents">
                            <td>{{ selectedEvent.name }}</td>
                            <td>
                                <div class="categories">
                                    <button v-if="selectedEvent.seat_plan_categories_for_subscriptions" v-for="category in selectedEvent.seat_plan_categories_for_subscriptions" id="{{ category.id}}" type="button" class="btn btn-dark">
                                        <input type="hidden" :name="'category_ids[' + selectedEvent.id + '][]'" :value="category.id" />
                                        {{ category.name }}
                                        <i v-if="!hasBoughtTickets" class="fas fa-times" @click="deleteEventCategory(selectedEvent.id, category.id)"></i>
                                    </button>
                                    <button v-if="!selectedEvent.seat_plan_categories_for_subscriptions"  v-for="category in selectedEvent.seat_plan_categories" id="{{ category.id}}" type="button" class="btn btn-dark">
                                        <input type="hidden" :name="'category_ids[' + selectedEvent.id + '][]'" :value="category.id" />
                                        {{ category.name }}
                                        <i class="fas fa-times" @click="deleteEventCategory(selectedEvent.id, category.id)"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="volume">
                                    <select
                                        v-model="selectedEvent.type"
                                        :id="'type' + selectedEvent.id"
                                        :name="'type[' + selectedEvent.id + ']'"
                                        @change="dividePrice"
                                        class="form-control type"
                                        :disabled="hasBoughtTickets"
                                    >
                                        <option value="percentage">%</option>
                                        <option value="fixed">Є</option>
                                    </select>
                                    <input
                                        v-model="selectedEvent.discount"
                                        :id="'discount' + selectedEvent.id"
                                        :name="'discount[' + selectedEvent.id + ']'"
                                        @change="dividePrice"
                                        type="number"
                                        step="0.1"
                                        min="0"
                                        class="form-control discount"
                                        placeholder="0"
                                        :disabled="hasBoughtTickets"
                                    />
                                </div>
                            </td>
                            <td>
                                = €
                                <span :id="'sum' + selectedEvent.id">{{ selectedEvent.sum }}</span>
                                <input type="hidden" :name="'sum[' + selectedEvent.id + ']'" :value="selectedEvent.sum" />
                            </td>
                            <td>
                                <a v-if="!hasBoughtTickets" @click="deleteSelectedEvent(selectedEvent.id)" href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-weight-bold" colspan="2">Subscription: {{ this.currentName }}</td>
                            <td class="font-weight-bold" colspan="2">Number of shows: {{ this.selectedEvents.length }}</td>
                            <td class="font-weight-bold">Total: {{ this.currentPrice }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div v-if="error" class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show alert-hide">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> {{ error }}</h5>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        initName: String,
        initPrice: Number,
        initEventIds: Array,
        initSelectedEvents: Object,
        hasBoughtTickets: Boolean,
    },
    data() {
        return {
            selected: [],
            allEvents: [],
            selectedEvents: [],
            currentName: this.initName,
            currentPrice: this.initPrice,
            error: null,
        }
    },
    watch: {
        initName: {
            handler(newVal, oldVal) {
                this.currentName = newVal;
            }
        },
        initPrice: {
            handler(newVal, oldVal) {
                this.currentPrice = newVal;
            }
        },
        selectedEvents: {
            handler(newVal, oldVal) {
                // This will be triggered whenever selectedEvents changes
                // console.log('Selected events changed:', newVal);
            },
            deep: true // This ensures that changes within the selectedEvents array are detected
        }
    },
    methods: {
        getEvents() {
            return new Promise((resolve, reject) => {
                axios.get('/api/events')
                    .then((response) => {
                        this.allEvents = response.data;
                        resolve(); // Resolve the promise once data is fetched and assigned
                    })
                    .catch(error => {
                        reject(error); // Reject the promise if an error occurs
                    });
            });
        },
        initAttachedEvents() {
            if (this.initSelectedEvents.length > 0) {
                this.initSelectedEvents.forEach(event => {
                    this.selected.push(event.id);
                    this.selectedEvents.push(event);
                })
            }
        },
        addToSelectedEvents(eventId) {
            const exists = this.selectedEvents.some(event => event.id === eventId);
            if (! exists) {
                const selectedEvent = this.allEvents.find(event => event.id === eventId);
                selectedEvent.type = 'percentage';
                selectedEvent.discount = 0;
                this.selectedEvents.push(selectedEvent);
            }
        },
        removeFromSelectedEvents(eventId) {
            const index = this.selectedEvents.findIndex(event => event.id === eventId);
            if (index !== -1) {
                this.selectedEvents.splice(index, 1);
            }
        },
        deleteEventCategory(eventId, categoryId) {
            const event = this.selectedEvents.find(event => event.id === eventId)
            if (event) {
                const index = event.seat_plan_categories.findIndex(category => category.id === categoryId)
                if (index !== -1) {
                    event.seat_plan_categories.splice(index, 1)
                }
            }
        },
        deleteSelectedEvent(eventId) {
            const selectEvent = $('#selectEvent');
            const optionToRemove = selectEvent.find(`option[value='${eventId}']`); // Find the option element corresponding to the event ID
            optionToRemove.prop('selected', false); // Deselect the option by removing the selected attribute
            selectEvent.trigger('change');  // Trigger change event for Select2 to update its display
            this.removeFromSelectedEvents(eventId);
        },
        clearSelectedEvents() {
            this.selectedEvents = [];
        },
        dividePrice() {
            this.error = null;
            let totalLeftSum = this.currentPrice;
            const fixedEvents = this.selectedEvents.filter(event => event.type === 'fixed');
            const percentageEvents = this.selectedEvents.filter(event => event.type === 'percentage');

            if (fixedEvents.length > 0) {
                const totalFixed = fixedEvents.reduce((total, event) => total + event.discount, 0);
                if (totalFixed <= 0) {
                    this.error = 'Invalid fixed price value. Should be bigger than zero.'
                } else if (!percentageEvents.length && totalFixed != totalLeftSum) {
                    let diff = 0;
                    if (totalLeftSum > totalFixed) {
                        diff = Math.abs(totalFixed - totalLeftSum).toFixed(1)
                        this.error = `Invalid fixed price value. Missing ${diff}€`
                    } else if (totalLeftSum < totalFixed) {
                        diff = (totalFixed - totalLeftSum).toFixed(1)
                        this.error = `Invalid fixed price value. More than ${diff}€`
                    } else {
                        this.error = 'Invalid fixed price value.'
                    }
                }
                fixedEvents.forEach(event => {
                    event.sum = event.discount.toFixed(1);
                    totalLeftSum -= event.discount;
                });
            }

            if (!this.error && percentageEvents.length > 0) {
                const totalPercentage = percentageEvents.reduce((total, event) => total + event.discount, 0);
                if (totalPercentage !== 100) {
                    this.error = 'Invalid percentage value. Should be equal 100% if percentage is used.'
                }
                percentageEvents.forEach(event => {
                    event.sum = ((event.discount / 100) * totalLeftSum).toFixed(1);
                })
            }
        }
    },
    mounted() {
        this.getEvents();

        const selectEvent = $('#selectEvent');
        selectEvent.select2(); // Initialize Select2 for the select element

        // Add event listener for "select2:select" event on Select2
        selectEvent.on('select2:select', (e) => {
            const selectedOption = e.params.data; // Access the selected option's data
            const selectedEventId = parseInt(selectedOption.id);
            this.addToSelectedEvents(selectedEventId); // Add the selected event to the selectedEvents array
            this.dividePrice()
        });

        // Add event listener for "unselect" event on Select2
        selectEvent.on('select2:unselect', (e) => {
            const unselectedOption = e.params.data; // Access the unselected option's data
            const unselectedEventId = parseInt(unselectedOption.id);
            this.removeFromSelectedEvents(unselectedEventId); // Remove the unselected event from the selectedEvents array
            this.dividePrice()
        });

        // Add event listener for "Select All" button
        $('.select-all').on('click', () => {
            selectEvent.find('option').prop('selected', true); // Select all options
            selectEvent.trigger('change'); // Trigger change event for Select2
            this.allEvents.forEach(event => this.addToSelectedEvents(event.id));
            this.dividePrice()
        });

        // Add event listener for "Deselect All" Program button
        $('.deselect-all').on('click', () => {
            selectEvent.find('option').prop('selected', false); // Deselect all options
            selectEvent.trigger('change'); // Trigger change event for Select2
            this.clearSelectedEvents(); // Clear the selectedEvents array
            this.dividePrice()
        });

        // Add event listener for Subscription Name input
        $('#name').on('change', () => {
            this.currentName = $('#name').val();
        });

        // Add event listener for Subscription Price input
        $('#price').on('change', () => {
            this.currentPrice = parseFloat($('#price').val());
        });

        // After fetching events data, initialize attached events
        this.getEvents().then(() => {
            this.initAttachedEvents();
            this.selected.forEach(value => {
                selectEvent.find(`option[value="${value}"]`).prop('selected', true);
            });
            selectEvent.trigger('change');  // Trigger the change event to update Select2 UI
        });
    }
}
</script>

<style scoped>
 .volume {
     display: flex;
     gap: 10px;
 }
 .type {
     max-width: 50pt;
 }
 .discount {
     max-width: 60pt;
 }
 .categories{
     display: flex;
     gap: 10px;
 }
</style>
