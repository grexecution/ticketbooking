<script>
export default {
    name: "NoSeatPlan",
    data() {
        return {
        }
    }
}
</script>

<template>
    <div class="">
        <div class="row">
            <div class="col-12">
                <h5>1. Please choose how many tickets:</h5>
                <div class="quantity-selector my-3">
                    <button type="button" class="btn">-</button>
                    <span class="px-3">1</span>
                    <button type="button" class="btn">+</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h5>2. Please choose seating category:</h5>
                <div class="category-card mb-3">
                    <div class="custom-radio">
                        <input type="radio" id="categoryA" name="category" checked>
                    </div>
                    <div class="description">
                        <h6>Category A</h6>
                        <p>Category Description</p>
                    </div>
                    <select class="custom-select mr-3">
                        <option selected>Regular Price</option>
                        <!-- Add more options here if needed -->
                    </select>
                    <div class="price">€ 28,00</div>
                </div>
                <div class="category-card">
                    <div class="custom-radio">
                        <input type="radio" id="categoryB" name="category">
                    </div>
                    <div class="description">
                        <h6>Category B</h6>
                        <p>Category Description</p>
                    </div>
                    <select class="custom-select mr-3">
                        <option selected>Regular Price</option>
                        <!-- Add more options here if needed -->
                    </select>
                    <div class="price">€ 28,00</div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-right">
                <button type="button" class="checkout-btn">To the checkout</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .category-card {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        margin-bottom: 10px;
        background-color: #f8f9fa;
    }
    .category-card .description {
        flex-grow: 1;
        margin-left: 15px;
    }
    .category-card .price {
        margin-right: 15px;
    }
    .category-card .custom-radio {
        margin-right: 10px;
    }
    .quantity-selector {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .quantity-selector button {
        width: 40px;
        height: 40px;
        font-size: 20px;
        background-color: #ffc107;
        border: none;
        color: #fff;
        border-radius: 5px;
        margin: 0 5px;
    }
    .checkout-btn {
        background-color: #ffc107;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
    }
</style>
