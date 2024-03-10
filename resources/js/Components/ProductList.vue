<script setup>
import Card from "@/Components/Card.vue";
import {storeToRefs} from "pinia";
import {useProductsStore} from "@/stores/useProductsStore.js";
import {computed, ref, watch} from "vue";

const {setPage} = useProductsStore()

const {
    products,
    pageLinks,
    sortBy
} = storeToRefs(useProductsStore())


function getPageParamFromUrl(url) {
    let paramString = url.split('?')[1];
    const urlParams = new URLSearchParams(paramString);
    return urlParams.get('page') || 1;
}

async function paginateTo(url) {
    const page = getPageParamFromUrl(url);
    await setPage(page)
}

const options = ref([
    { name: 'Giá', value: '' },
    { name: 'Giá: Tăng dần', value: 'price.asc' },
    { name: 'Giá: Giảm dần', value: 'price.desc' }
]);


const optionValues = computed(() => {
    return options.value.map(o => o.value)
});

const selected = ref('')

watch(selected, function (_option) {
    if (_option !== '') {
        sortBy.value = _option;
    }
});

const latestSortActiveClass = computed(() => {
  return sortBy.value === 'created_at.desc' ? 'bg-blue-500 text-white font-bold' : 'bg-white text-gray-900'
})
const bestSaleActiveClass = computed(() => {
  return sortBy.value === 'sold.desc' ? 'bg-blue-500 text-white font-bold' : 'bg-white text-gray-900'
})


function quickSort(_sortBy) {
    sortBy.value = _sortBy;
    selected.value = '';
}

</script>

<template>
    <div class="basis-4/5 pb-10">
        <div class="flex items-center gap-4 my-4">
            <h4 class="text-lg font-bold text-gray-600">Sắp xếp theo</h4>
            <button :class="[
                'px-3 h-12 text-lg rounded-sm',
                latestSortActiveClass
            ]" @click="quickSort('created_at.desc')">
                Mới nhất
            </button>
            <button :class="[
                'px-3 h-12 text-lg rounded-sm',
                bestSaleActiveClass
            ]" @click="quickSort('sold.desc')">
                Bán chạy
            </button>
            <select v-model="selected" :class="['h-12 text-lg rounded-sm', selected !== '' ? 'text-blue-600 font-bold' : 'text-gray-900']">
                <option v-for="option in options" :value="option.value">
                    {{ option.name}}
                </option>
            </select>
        </div>
        <div class="grid grid-cols-4 flex-wrap gap-4">
            <Card v-for="product in products" v-bind="product" :key="product.id"/>
        </div>
        <div class="flex gap-4 my-4 justify-center">
            <button :class="[
            'p-2 min-w-10 text-center truncate rounded-md hover:bg-blue-500 hover:text-white',
            link.active ? 'bg-blue-600 text-white font-bold' : 'bg-white text-black'
        ]" v-for="link in pageLinks" :key="link"
                    @click="paginateTo(link.url)">
                <span v-html="link.label"></span>
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
