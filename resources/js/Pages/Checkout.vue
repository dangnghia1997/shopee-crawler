<script setup>
import {Head, Link} from "@inertiajs/vue3";
import {useCartStore} from "@/stores/useCartStore.js";
import {storeToRefs} from "pinia";
import {computed} from "vue";

const {
    cart
} = storeToRefs(useCartStore())

const items = computed(() => cart.value?.items || [])

function formatPrice(value) {
    let val = (value / 1).toFixed(0).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

</script>

<template>
    <Head title="Checkout"/>

    <div
        class="bg-blue-50 min-h-screen"
    >
        <div
            class="max-w-screen-2xl mx-auto bg-yellow-300 border-b-4 border-green-700 flex items-center justify-between">
            <Link href="/" class="bg-gray-50 p-2 mx-2 rounded">Trang Chủ</Link>
            <h1 class="text-2xl font-bold py-4 text-center">Thanh Toán</h1>
            <div>&nbsp;</div>
        </div>
        <div class="max-w-screen-2xl bg-white mx-auto flex justify-around gap-4">
            <div class="bg-white w-3/4 min-h-screen mx-auto">
<!--                <h1 class="text-2xl font-bold text-center py-4">Thanh Toán</h1>-->
                <div class="space-y-4 px-4 my-4">
                    <div class="grid grid-cols-4 items-center p-3 gap-3 text-lg border-4 border-dotted">
                        <p class="text-gray-600">Tên sản phẩm</p>
                        <p class="text-xl font-bold text-gray-500">Giá</p>
                        <p class="text-red-500 font-bold text-2xl">Số lượng</p>
                        <p class="font-bold text-2xl">Tạm tính(<sup>₫</sup>)</p>
                    </div>
                </div>
                <div class="space-y-3 px-4 mb-4">
                    <div class="grid grid-cols-4 items-center p-3 gap-3 text-lg border-4 border-dotted"
                         v-for="item in items" :key="item">
                        <p class="text-gray-600">{{ item.name }}</p>
                        <p class="text-xl font-bold text-gray-500">{{ formatPrice(item.price) }}<sup> ₫</sup></p>
                        <p class="text-red-500 font-bold text-2xl">x {{ item.qty }}</p>
                        <p class="font-bold text-2xl">= {{ formatPrice(item.row_total) }}<sup> ₫</sup></p>
                    </div>
                </div>
                <div class="space-y-3 px-4 mb-10">
                    <div class="flex items-center justify-between p-3 border-4">
                        <div class="flex items-center justify-center gap-3">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-2xl px-4 py-2 rounded">
                                Hoàn tất đơn hàng
                            </button>
                        </div>
                        <div class="flex items-center justify-center gap-3">
                            <p class="text-3xl text-gray-600">Tổng:</p>
                            <p class="text-2xl text-red-500 font-bold">{{ formatPrice(cart.grant_total) }}<sup> ₫</sup>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
