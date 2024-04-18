import './bootstrap';

import { createApp } from "vue";
import SubscriptionEvents from "./components/SubscriptionEvents";

const app = createApp({})
app.component('subscription-events', SubscriptionEvents)
app.mount('#app')

