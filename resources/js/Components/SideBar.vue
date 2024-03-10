<script setup>
import {ref} from "vue";

const checked = ref('')

const options = ref([{
    key: 'hp',
    label: 'HP'
}, {
    key: 'dell',
    label: 'Dell'
}, {
    key: 'apple',
    label: 'Apple'
},
    {
        key: 'acer',
        label: 'Acer'
    }
]);
const priceFrom = ref('')
const priceTo = ref('')

function applyPriceFilter() {
    console.log('from: ' + priceFrom.value);
    console.log('to: ' + priceTo.value);
}
</script>

<template>
    <div class="bg-white basis-1/5 block">
        <div class="px-3 flex flex-col gap-3 mb-2">
            <h3 class="text-lg text-blue-700 font-bold border-b-2 border-black uppercase w-full m-0 py-2">
                Thương hiệu
            </h3>
            <div class="space-y-2">
                <div class="w-full flex items-center gap-2 text-lg py-2 px-1 rounded group hover:bg-gray-100"
                     v-for="option in options">
                    <input type="radio" :id="option.key" :value="option.key" v-model="checked"/>
                    <label :for="option.key" class="block w-full group-hover:cursor-pointer">{{ option.label }}</label>
                </div>
            </div>
        </div>
        <div class="px-3 flex flex-col gap-3">
            <h3 class="text-lg text-blue-700 font-bold border-b-2 border-black uppercase w-full m-0 py-2">
                Khoảng Giá
            </h3>
            <div class="space-y-2">
                <div class="w-full flex items-center gap-2 text-lg py-2 px-1">
                    <input type="number" id="price_from" v-model.number="priceFrom" value=""/>
                    <span class="text-gray-500">-</span>
                    <input type="number" id="price_to" v-model.number="priceTo" value=""/>
                </div>
                <div class="w-full flex items-center gap-2 text-lg px-1">
                    <button class="w-full py-2  px-1 bg-blue-500 hover:bg-blue-700 text-white uppercase"
                            @click="applyPriceFilter">Áp dụng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
