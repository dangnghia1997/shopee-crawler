<script setup>
import {Head, Link} from '@inertiajs/vue3';
import ProductList from "@/Components/ProductList.vue";
import SideBar from "@/Components/SideBar.vue";
import {computed, onMounted} from "vue";
import {useProductsStore} from "@/stores/useProductsStore.js";
import {useCartStore} from "@/stores/useCartStore.js";
import {storeToRefs} from "pinia";

const {getProducts} = useProductsStore()

const {getCart} = useCartStore()

const {
    cart
} = storeToRefs(useCartStore())

const itemsCount = computed(() => {
    return cart.value?.reduce(((accumulator, currentValue) => accumulator + currentValue.qty), 0) || 0
})


onMounted(async () => {
    await Promise([
        getProducts(),
        getCart()
    ])
})

</script>

<template>
    <Head title="PLP"/>

    <div
        class="bg-blue-50 min-h-screen"
    >
        <div class="max-w-screen-2xl mx-auto bg-yellow-300 border-b-4 border-green-700 flex justify-between items-center">
            <div>&nbsp;</div>
            <h1 class="text-center text-2xl font-bold py-4">Danh mục: Máy tính & Laptop</h1>
            <div class="p-2">
                <button class="bg-pink-100 p-4 rounded-xl shadow-2xl text-gray-700 font-bold">
                    Giỏ hàng <span class="text-red-600 text-lg p-1">({{itemsCount}})</span>
                </button>
            </div>
        </div>
        <div class="max-w-screen-2xl mx-auto flex justify-around gap-4">
            <SideBar />
            <ProductList/>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
