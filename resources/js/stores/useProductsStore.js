import {defineStore} from "pinia";
import {computed, ref, watch} from "vue";

export const useProductsStore = defineStore('useProductsStore', function () {
    const loading = ref(false)
    const rawData = ref([]);
    const page = ref(1);
    const sortBy = ref('created_at.desc')
    const brand = ref('')
    const price = ref('')

    const pageLinks = computed(() => {
        return rawData.value?.links || [];
    })

    const products = computed(() => {
        return rawData.value?.data || [];
    })

    watch(sortBy, function(newSortBy) {
        getProducts()
    })

    watch(price, function(newSortBy) {
        getProducts()
    })

    watch(brand, function(newSortBy) {
        getProducts()
    })

    async function setPage(_page = 1) {
        page.value = _page;
        await getProducts();
    }

    function objectToQueryString(obj) {
        const keys = Object.keys(obj);
        const keyValuePairs = keys.map(key => {
            return encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]);
        });
        return keyValuePairs.join('&');
    }

    const queryString = computed(() => {
        const params = {
            page: page.value,
            ...sortBy.value ? {sort_by: sortBy.value} : null,
            ...brand.value ? {brand: brand.value} : null,
            ...price.value ? {price: price.value} : null,
        };
        return objectToQueryString(params);
    })

    async function getProducts() {
        try {
            loading.value = true;
            const {data} = await axios.get(
                `http://localhost/api/products?${queryString.value}`
            );
            rawData.value = data
            // products.value = data.data;
            // pageLinks.value = data.links;
            loading.value = false;
            return data;
        } catch (e) {
            console.error(e);
            loading.value = false;
        }
    }

    return {
        loading,
        products,
        setPage,
        pageLinks,
        getProducts,
        sortBy,
        price,
        brand,
    }
})
