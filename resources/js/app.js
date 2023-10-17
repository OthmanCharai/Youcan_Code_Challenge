require("./bootstrap");

// Dependency goes here
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";

// Components go here
import ProductIndex from "./components/products/index";

// define variables & const
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
