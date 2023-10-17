<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link class="btn btn-primary mx-4" to="/"
            >Create Product</router-link
        >
        <!--   <router-link class="btn btn-primary"> </router-link>  -->
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="alert alert-success" v-if="uploadedSuccessed">
                    ProductCreated with success
                </div>
                <form
                    @submit.prevent="uploadFile"
                    enctype="multipart/form-data"
                >
                    <div class="form-group mt-2">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            id="name"
                            class="form-control"
                            v-model="formData.name"
                        />
                    </div>
                    <div class="form-group mt-2">
                        <label for="name">Category</label>
                        <select
                            v-model="formData.category_id"
                            class="form-control"
                            id=""
                        >
                            <option
                                v-for="category in categories"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="price">Price</label>
                        <input
                            type="number"
                            id="price"
                            class="form-control"
                            v-model="formData.price"
                        />
                    </div>
                    <div class="form-group mt-2">
                        <label for="file">File</label>
                        <input
                            type="file"
                            id="file"
                            class="form-control-file"
                            @change="handleFileChange"
                        />
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            class="form-control"
                            v-model="formData.description"
                        ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { BASE_URL } from "../../config";
const categories = ref([]);

onMounted(() => {
    //Get Categories :todo should be in pinia
    axios
        .get(`${BASE_URL}/category`)
        .then((response) => {
            categories.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
});

const formData = ref({
    name: "",
    price: 0,
    description: "",
    image: null,
    category_id: null,
});

const uploadedSuccessed = ref(false);

const handleFileChange = (event) => {
    formData.image = event.target.files[0];
};

const uploadFile = () => {
    const form = new FormData();
    form.append("name", formData.name);
    form.append("price", formData.price);
    form.append("description", formData.description);
    form.append("category_id", formData.category_id);
    form.append("image", formData.image);
    console.log(formData);
    debugger
    axios
        .post(`${BASE_URL}/product`, form)
        .then((success) => {
            console.log("okk");
            uploadedSuccessed.value = true;
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
