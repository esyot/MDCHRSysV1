<script>
import Layout from "@/Layouts/Layout.vue";
import AddCategory from "./Modals/AddCategory.vue";
import AddItemModal from "./Modals/AddItemModal.vue";
export default {
    layout: Layout,
    components: {
        AddCategory,
        AddItemModal,
    },
    data() {
        return {
            isNewCategoryModal: false,
            isNewItemModal: false,
        };
    },
    methods: {
        toggleNewCategory() {
            this.isNewCategoryModal = !this.isNewCategoryModal;
        },
        toggleNewItem() {
            this.isNewItemModal = !this.isNewItemModal;
        },
    },
};
</script>
<template>
    <AddCategory v-if="isNewCategoryModal" :isNewCategoryModal="isNewCategoryModal"
        @toggleNewCategory="toggleNewCategory">
    </AddCategory>
    <AddItemModal v-if="isNewItemModal" :isNewItemModal="isNewItemModal" @toggleNewItem="toggleNewItem">
    </AddItemModal>
    <div class="main-container">
        <div class="top-nav">
            <div class="title">
                <span>View Evaluation - (Template Title)</span>
            </div>
            <div class="buttons">
                <button @click="toggleNewCategory"><i class="fa fa-plus"></i> Add Category</button>
                <button @click="toggleNewItem"><i class="fa fa-plus"></i> Add Item</button>
            </div>
        </div>
        <div class="content">
            <div class="category" v-for="i in 3" :key="i">
                <div class="category-header">
                    <span>{{ i }}. Category</span>
                </div>
                <div class="category-body">
                    <div class="item" v-for="j in 3" :key="j">
                        <div class="item-header">
                            <span>{{ j }}. Item</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.main-container {
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    padding-left: 20px;
    padding-right: 20px;
    flex-direction: column;
    gap: 1rem;
}

.top-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #011325;
}

.title {
    font-size: 1.5rem;
}

.buttons {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.buttons button {
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.buttons button:hover {
    opacity: 0.8;
}

.content {
    background-color: rgb(4, 173, 173);
    border-radius: 5px;
    gap: 1rem;
}

.category {
    margin: 1rem;
    padding-left: 1rem;
}

.item {
    padding-left: 1rem;
}
</style>
