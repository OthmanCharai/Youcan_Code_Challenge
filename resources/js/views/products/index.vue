<template lang="">
    <div class="container">
        <div class="row">
            <div class="col-md-3" v-for="product in products" :key="product.id">
                <product-cart :product="product"></product-cart>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import productCart from "../../components/products/productCart.vue";
import axios from "axios";
// Import base url
import { BASE_URL } from "./../../config";

const products = ref([]);
const categories=ref([])

onMounted(() => {
    axios
        .get(`${BASE_URL}/product`)
        .then((response) => {
            products.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
});
</script>
<style lang=""></style>
