<template lang="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link class="btn btn-primary mx-4" to="/store"
            >Create Product</router-link
        >

        <div
            class="collapse navbar-collapse d-flex"
            id="navbarSupportedContent"
        >
            <form
                @submit.prevent="getProducts"
                class="form-inline my-2 my-lg-0 d-flex"
            >
                <label for="price">Price Range</label>
                <input
                    v-model="priceRange"
                    class="form-control mr-sm-2 mx-2"
                    type="number"
                    placeholder="Max Price Range"
                    id="price"
                />

                <label for="category">Selct category</label>
                <select class="form-control mx-2" v-model="categoryId" id="category">
                    <option v-for="category in categories" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                <button
                    class="btn btn-outline-success my-2 my-sm-0"
                    type="submit"
                >
                    Search
                </button>
            </form>
        </div>
        <!--   <router-link class="btn btn-primary"> </router-link>  -->
    </nav>
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
const categories = ref([]);

const categoryId = ref(null);
const priceRange = ref(0);

const getProducts = () => {
    axios
        .get(
            `${BASE_URL}/product?category=${categoryId.value}&price=${priceRange.value}`
        )
        .then((response) => {
            products.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

//On Mounted
onMounted(() => {
    // Get Products
    getProducts();

    //Get Categories
    axios
        .get(`${BASE_URL}/category`)
        .then((response) => {
            categories.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
});
</script>
<style lang=""></style>
