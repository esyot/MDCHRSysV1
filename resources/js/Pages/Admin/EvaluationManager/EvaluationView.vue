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
  props: {
    template: Array,
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
  <AddCategory
    v-if="isNewCategoryModal"
    :isNewCategoryModal="isNewCategoryModal"
    @toggleNewCategory="toggleNewCategory"
  >
  </AddCategory>
  <AddItemModal
    v-if="isNewItemModal"
    :isNewItemModal="isNewItemModal"
    @toggleNewItem="toggleNewItem"
  >
  </AddItemModal>
  <div class="main-container">
    <div class="top-nav">
      <div class="title">
        <span>View Evaluation - ({{ template.name }})</span>
      </div>
      <div class="buttons">
        <button @click="toggleNewCategory">
          <i class="fa fa-plus"></i> Add Category
        </button>
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
@import "./css/evaluation-view.css";
</style>
