import {defineStore} from "pinia";
import {ref} from "vue";

export const useCartStore = defineStore('useCartStore', () => {
    const loading = ref(false)
    const cartMaskedId = ref('')
    const cart = ref([])

    async function callCreateEmptyCart() {
        const {data} = await axios.post(
            `http://localhost/api/cart`
        );
        return data.data?.cart_id || '';
    }

    async function callGetCart() {
        const {data} = await axios.get(
            `http://localhost/api/cart/${cartMaskedId.value}`
        );

        return data.data || [];
    }

    async function getCart() {
        if (!cartMaskedId.value) {
            cartMaskedId.value = await callCreateEmptyCart();
        }
        cart.value = await callGetCart();
    }

    async function addItemToCart(item) {
        loading.value = true;
        const {data} = await axios.post(
            `http://localhost/api/cart/${cartMaskedId.value}`,
            {
                qty: item?.qty || 1,
                product_id: item?.product_id || 0
            }
        );
        loading.value = false;

        cart.value = data.data || [];
    }

    return {cartMaskedId, cart, loading, getCart, addItemToCart}
}, {
    persist: true
})
