require("./bootstrap");

// Depandency goes here
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";

// Components go here
import ProductIndex from "./components/products/index";

// define varianbles & const
const routes = [
    {
        path: "/",
        component: ProductIndex,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp({})
    .use(router)
    .mount("#app");
