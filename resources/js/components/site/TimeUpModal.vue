<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <h3>Your checkout time has expired.</h3>
                <p>Your cart has been cleared.</p>
                <button @click="$emit('close')">Go Home</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TimeUpModal',
    methods: {
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-container {
    width: 300px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    padding: 20px;
    text-align: center;
}

.modal-container h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.modal-container p {
    font-size: 16px;
    margin-bottom: 20px;
}

.modal-container button {
    padding: 10px 20px;
    background-color: #ffc107;
    border: none;
    border-radius: 2px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-container button:hover {
    background-color: #e0a800;
}
</style>
