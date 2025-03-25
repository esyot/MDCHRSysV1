<script>
import Layout from "@/Layouts/Layout.vue";
import AddCategoryModal from "./Modals/AddCategoryModal.vue";
import AddItemModal from "./Modals/AddItemModal.vue";
import EditItemModal from "./Modals/EditItemModal.vue";
import ConfirmationFormModal from "./Modals/ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: Layout,
  components: {
    AddCategoryModal,
    AddItemModal,
    EditItemModal,
    ConfirmationFormModal,
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
      selectediItem: [],
      isEditItem: false,
      isConfirmation: false,
      message: "Are you sure to remove this item?",
    };
  },
  methods: {
    toggleNewCategory() {
      this.isNewCategoryModal = !this.isNewCategoryModal;
    },
    toggleNewItem() {
      this.isNewItemModal = !this.isNewItemModal;
    },
    toggleIsEditItem(item) {
      this.isEditItem = !this.isEditItem;
      this.selectediItem = item;
    },

    toggleConfirmForm(item) {
      this.isConfirmation = !this.isConfirmation;
      item === this.selectediItem
        ? (this.selectediItem = null)
        : (this.selectediItem = item);
    },

    submitForm() {
      Inertia.delete(`/evaluations/template/delete-item/${this.selectediItem.id}`);
      this.toggleConfirmForm();
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

  <EditItemModal
    v-if="isEditItem"
    :selectediItem="selectediItem"
    @toggleIsEditItem="toggleIsEditItem"
  ></EditItemModal>

  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>

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
          <div class="category-header-item">
            <span>{{ category.title }}</span>
          </div>
          <ul>
            <li v-for="(item, index) in category.items" :key="item.id">
              <span>{{ index + 1 }}. {{ item.description }}</span>

              <i class="blue fas fa-pencil" @click="toggleIsEditItem(item)"></i>
              <i class="red fas fa-trash" @click="toggleConfirmForm(item)"></i>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>
s
<style scoped>
@import "./css/evaluation-view.css";
</style>
