<template>
    <div class="modal" v-if="show">
        <div class="modal-content">
            <span class="close" @click="close">&times;</span>
            <p>You have items in your Checkout. Proceeding will replace them</p>
            <button @click="confirmReplace">Yes, replace</button>
            <button @click="close">Cancel</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['show'],
    methods: {
        close() {
            this.$emit('close');
        },
        confirmReplace() {
            this.$emit('confirmReplace');
        }
    }
};
</script>

<style scoped>
/* Add your CSS styles for the modal here */
</style>
