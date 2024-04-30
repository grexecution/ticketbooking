import './bootstrap';

import { createApp } from "vue";
import SubscriptionEvents from "./components/SubscriptionEvents";
import SeatPlan from "./components/SeatPlan.vue";

const app = createApp({})
app.component('subscription-events', SubscriptionEvents)
app.component('seat-plan', SeatPlan)
app.mount('#app')

