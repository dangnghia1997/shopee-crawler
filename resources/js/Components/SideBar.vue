<script setup>
import {computed, ref} from "vue";
import {useProductsStore} from "@/stores/useProductsStore.js";
import {storeToRefs} from "pinia";


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

const priceString = computed(() => {
    return priceFrom.value !== '' && priceTo.value !== '' ? `${priceFrom.value},${priceTo.value}` : '';
})

const {
    price,
    brand,
} = storeToRefs(useProductsStore())

function applyPriceFilter() {
    if (priceFrom.value === '') {
        return priceFrom.value = 0;
    }
    price.value = priceString.value;
}

const isShowRemoveFilter = computed(() => price.value !== '' || brand.value !== '')

function resetFilter() {
    priceFrom.value = '';
    priceTo.value = '';
    price.value = '';
    brand.value = '';
}
</script>

<template>
    <div class="bg-white basis-1/5 block">
        <div class="px-3 flex flex-col gap-3 mb-2 py-8">
            <h3 class="text-lg text-blue-700 font-bold border-b-2 border-black uppercase w-full m-0 py-2">
                Thương hiệu
            </h3>
            <div class="space-y-2">
                <div class="w-full flex items-center gap-2 text-lg py-2 px-1 rounded group hover:bg-gray-100"
                     v-for="option in options">
                    <input type="radio" :id="option.key" :value="option.key" v-model="brand"/>
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
                <div class="w-full flex items-center gap-2 text-lg px-1" v-if="isShowRemoveFilter">
                    <button class="w-full py-2  px-1 bg-blue-500 hover:bg-blue-700 text-white uppercase"
                            @click="resetFilter">
                        Xoá bộ lọc
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
