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
    <div class="container px-10 py-2 card">
        <div class="row">
            <div class="col-12 pb-3">
                <h3 class="pt-4 pb-4 question-styling">Please choose seating category:</h3>
                <div class="category-card mb-3 d-flex justify-content-between">
                    <div class="col-md-6 d-flex flex-row align-items-center">
                        <div class="d-flex flex-col w-75">
                            <h6 class="category-title">Category A</h6>
                            <p class="category-desc">Category A Description</p>
                        </div>
                        <select class="custom-select mr-3">
                        <option selected>Regular Price</option>
                        <!-- Add more options here if needed -->
                        </select>
                    </div>
                    <div class="col-md-4 d-flex d-row justify-content-end align-items-center">
                       <div class="price text-right">
                            <p class="category-title">€ 28,00</p>
                        </div>
                        <div class="quantity-selector">
                            <button type="button" class="btn">-</button>
                            <span class="px-3">1</span>
                            <button type="button" class="btn">+</button>
                        </div>
                    </div>
                    
                </div>
                <div class="category-card mb-3 d-flex justify-content-between">
                    <div class="col-md-6 d-flex flex-row align-items-center">
                        <div class="d-flex flex-col w-75">
                            <h6 class="category-title">Category B</h6>
                            <p class="category-desc">Category B Description</p>
                        </div>
                        <select class="custom-select mr-3">
                        <option selected>Regular Price</option>
                        <!-- Add more options here if needed -->
                        </select>
                    </div>
                    <div class="col-md-4 d-flex d-row justify-content-end align-items-center">
                       <div class="price text-right">
                            <p class="category-title">€ 28,00</p>
                        </div>
                        <div class="quantity-selector">
                            <button type="button" class="btn">-</button>
                            <span class="px-3">0</span>
                            <button type="button" class="btn">+</button>
                        </div>
                    </div>
                    
                </div>
                <div class="text-right">
                    <a href="/checkout" type="button" class="btn-orange checkout-btn">Weiter zum Checkout</a>
                </div>
            </div>
            
        </div>
        
    </div>
</template>

<style scoped>
    .category-card {
        display: flex;
        align-items: center;
        padding: 25px 20px;
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
        font-size: 18px;
        font-weight: 600;
        border: none;
        color: #fff;
        border-radius: 5px;
        margin: 0 5px;
        background-color: #ffc107;
        border-color: #ffc107;
        -webkit-box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3); 
        box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
        height: calc(2.75rem + 2px);
    }
    .checkout-btn {
        background-color: #ffc107;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
    }
    .btn-orange {
        background-color: #ffc107;
        border-color: #ffc107;
        -webkit-box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3); 
        box-shadow: 0px 4px 10px 0px rgba(250,180,0,0.3);
        height: calc(2.75rem + 2px);
    }
    .question-styling {
        font-size: 18px;
        font-weight: 600;
    }
    .category-title {
        font-size: 16px;
        font-weight: 600;
    }
    .category-desc {
        font-size: 14px;
        font-weight: 400;
    }

</style>
