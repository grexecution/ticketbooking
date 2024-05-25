import './bootstrap';
import { createApp } from "vue";
import SubscriptionEvents from "./components/admin/SubscriptionEvents";
import SeatPlan from "./components/admin/SeatPlan.vue";
import NoSeatPlan from "./components/site/NoSeatPlan.vue";

// Admin components
const adminApp = createApp({})
adminApp.component('subscription-events', SubscriptionEvents)
adminApp.component('seat-plan', SeatPlan)
adminApp.mount('#app')

// Site components
const siteApp = createApp({});
siteApp.component('no-seat-plan', NoSeatPlan);
siteApp.mount('#site-app');
