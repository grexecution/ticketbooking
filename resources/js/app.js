import './bootstrap';
import { createApp } from "vue";
import SubscriptionEvents from "./components/admin/SubscriptionEvents";
import SeatPlan from "./components/admin/SeatPlan.vue";
import NoSeatPlan from "./components/site/NoSeatPlan.vue";
import OrderSummary from "./components/site/OrderSummary.vue";
import SeatMap from "./components/SeatMap.vue";

// Admin components
const adminApp = createApp({})
adminApp.component('subscription-events', SubscriptionEvents)
adminApp.component('seat-plan', SeatPlan)
adminApp.mount('#app')

// Site components
const siteApp = createApp({});
siteApp.component('no-seat-plan', NoSeatPlan);
siteApp.component('order-summary', OrderSummary);
siteApp.component('seat-map', SeatMap);
siteApp.mount('#site-app');
