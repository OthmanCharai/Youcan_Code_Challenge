require("./bootstrap");

// Dependency goes here
import { createApp } from "vue";

import { createRouter, createWebHistory } from "vue-router";

// Components go here
import ProductIndex from "./views/products/index.vue";
import CreateProduct from "./views/products/create.vue";

// define variables & const
const routes = [
    {
        path: "/",
        component: ProductIndex,
    },
    {
        path: "/store",
        component: CreateProduct
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp({})
    .use(router)
    .mount("#app");
