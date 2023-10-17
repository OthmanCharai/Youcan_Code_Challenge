<template>
    <div class="card m-3" style="width: 18rem">
        <img class="card-img-top" :src="product.image" alt="Card image cap" />
        <div class="card-body">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text">
                {{ product.description }}
            </p>
            <button class="btn btn-primary">{{ product.price }}$</button>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    product: Object,
});

const product = props.product;
</script>
<css></css>
