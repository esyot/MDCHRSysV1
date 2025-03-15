<script>
import Layout from "@/Layouts/Layout.vue";
import AddCategoryModal from "./Modals/AddCategoryModal.vue";
import AddItemModal from "./Modals/AddItemModal.vue";
export default {
  layout: Layout,
  components: {
    AddCategoryModal,
    AddItemModal,
  },
  props: {
    template: Object,
    categories: Object,
  },
  data() {
    return {
      isNewCategoryModal: false,
      isNewItemModal: false,
      template_id: this.template.id,
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
  <AddCategoryModal
    v-if="isNewCategoryModal"
    :template_id="template_id"
    @toggleNewCategory="toggleNewCategory"
  >
  </AddCategoryModal>

  <AddItemModal
    v-if="isNewItemModal"
    :categories="categories"
    @toggleNewItem="toggleNewItem"
  >
  </AddItemModal>
  <div class="main-container">
    <div class="top-nav">
      <div class="title">
        <span>View & Edit - {{ template.name }}</span>
      </div>
      <div class="top-nav-buttons">
        <button @click="toggleNewCategory">
          <i class="fa fa-plus"></i> Add Category
        </button>
        <button @click="toggleNewItem"><i class="fa fa-plus"></i> Add Item</button>
      </div>
    </div>
    <ul class="content">
      <li class="category" v-for="category in categories" :key="category.id">
        <div class="category-header">
          <span>{{ category.title }}</span>
          <ul>
            <li v-for="item in category.items" :key="item.id">
              {{ item.description }}
            </li>
          </ul>
        </div>
        <div class="category-body">
          <div class="item" v-for="item in template.item" :key="item.id">
            <div class="item-header">
              <span>{{ item.description }}</span>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
s
<style scoped>
@import "./css/evaluation-view.css";
</style>
