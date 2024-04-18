<script>
export default {
    data() {
        return {
            allEvents: [],
            selectedEvents: [],
        }
    },
    methods: {
        getEvents() {
            axios.get('/api/events')
                .then((response) => {
                    this.allEvents = response.data.data
                })
        },
        addToSelectedEvents(eventId) {
            const exists = this.selectedEvents.some(event => event.id === eventId);
            if (! exists) {
                const selectedEvent = this.allEvents.find(event => event.id === eventId);
                this.selectedEvents.push(selectedEvent);
            } else {
                console.log('Event ' + eventId + ' already exists.')
            }
        },
        removeFromSelectedEvents(eventId) {
            const index = this.selectedEvents.findIndex(event => event.id === eventId);
            if (index !== -1) {
                this.selectedEvents.splice(index, 1);
            }
        },
        clearSelectedEvents() {
            this.selectedEvents = [];
        }
    },
    mounted() {
        this.getEvents();

        const selectEvent = $('#selectEvent');
        // Initialize Select2 for the select element
        selectEvent.select2();

        // Add event listener for "select2:select" event on Select2
        selectEvent.on('select2:select', (e) => {
            const selectedOption = e.params.data; // Access the selected option's data
            const selectedEventId = parseInt(selectedOption.id);
            this.addToSelectedEvents(selectedEventId); // Add the selected event to the selectedEvents array
        });

        // Add event listener for "unselect" event on Select2
        selectEvent.on('select2:unselect', (e) => {
            const unselectedOption = e.params.data; // Access the unselected option's data
            const unselectedEventId = parseInt(unselectedOption.id);
            this.removeFromSelectedEvents(unselectedEventId); // Remove the unselected event from the selectedEvents array
        });

        // Add event listener for "Select All" button
        $('.select-all').on('click', () => {
            selectEvent.find('option').prop('selected', true); // Select all options
            selectEvent.trigger('change'); // Trigger change event for Select2
            this.allEvents.forEach(event => this.addToSelectedEvents(event.id));
        });

        // Add event listener for "Deselect All" Program button
        $('.deselect-all').on('click', () => {
            selectEvent.find('option').prop('selected', false); // Deselect all options
            selectEvent.trigger('change'); // Trigger change event for Select2
            this.clearSelectedEvents(); // Clear the selectedEvents array
        });
    }
}
</script>

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
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">Select All</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">Deselect All</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <select name="event_ids[]" class="form-control select2" id="selectEvent" multiple="multiple">
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
                            <th></th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="selectedEvent in selectedEvents">
                            <td>{{ selectedEvent.name }}</td>
                            <td>
                                <button v-for="category in selectedEvent.categories" id="{{ category.id}}" type="button" class="btn btn-dark">
                                    {{ category.name }}
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="percentageInput" placeholder="Enter percentage" aria-describedby="percentageAddon">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="percentageAddon">
                                            <i class="fas fa-percent"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>= €73.18</td>
                            <td>
                                <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="font-weight-bold" colspan="2">Subscription: Flo & Wisch - All shows</td>
                            <td class="font-weight-bold" colspan="2">Number of shows: {{ this.selectedEvents.length }}</td>
                            <td class="font-weight-bold">Total: 365.90</td>
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
