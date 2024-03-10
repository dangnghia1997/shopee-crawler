<script setup>
import AddToCartIcon from "@/Components/AddToCartIcon.vue";

const props = defineProps({
    name: String,
    id: Number,
    brand_name: String,
    brand_key: String,
    price: Number,
    sku: String,
    sold: Number,
    thumbnail: String,
})

function formatPrice(value) {
    let val = (value/1).toFixed(0).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

function addCart(productId) {
    console.log('added product Id ' + productId + ' to cart')
}
</script>

<template>
<div class="p-2 flex flex-col rounded-lg bg-white text-2xl">
    <img :src="thumbnail" width="280" height="280"/>
    <div class="py-2">
        <p class="line-clamp-1 text-2xl font-extrabold">{{formatPrice(price)}} <sup>₫</sup></p>
    </div>
    <div class="py-2">
        <span class="text-lg font-bold uppercase text-gray-500">{{brand_name}}</span>
    </div>
    <p class="text-lg text-balance line-clamp-3">{{name}}</p>
    <div class="py-2 flex justify-end">
        <button class="p-2 rounded-full bg-blue-500 text-white" @click="addCart(id)">
            <AddToCartIcon />
        </button>
    </div>
</div>
</template>

<style scoped>

</style>
