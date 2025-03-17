<script>
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
export default {
  emits: ["toggleNewItem"],
  components: {
    ConfirmationFormModal,
  },
  props: {
    categories: Object,
  },
  methods: {
    saveToLocalStorage() {
      localStorage.setItem("templateItemData", JSON.stringify(this.item));
    },

    removeFromLocalStorage() {
      localStorage.removeItem("templateItemData");
    },
    closeModal() {
      this.$emit("toggleNewItem");
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
    submitForm() {
      Inertia.post("/evaluations/template/add-item", {
        item: this.item,
      });
      this.removeFromLocalStorage();
      this.toggleConfirmForm();
      this.closeModal();
    },
    cancelForm() {
      this.removeFromLocalStorage();
      this.closeModal();
    },
  },

  created() {
    const item = localStorage.getItem("templateItemData");

    if (item) {
      this.item = JSON.parse(item);
    }
  },
  data() {
    return {
      message: "Are you sure to insert this item?",
      isConfirmation: false,
      item: {
        category_id: "",
        description: "",
      },
    };
  },
};
</script>

<template>
  <ConfirmationFormModal
    v-if="isConfirmation"
    :message="message"
    :isConfirmation="isConfirmation"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>

  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <form @submit.prevent="toggleConfirmForm" class="form">
        <div class="form-title">
          <span>Add Category</span>
          <i @click="closeModal">&times;</i>
        </div>
        <div class="form-group">
          <label for="name">Category</label>
          <select
            name="category"
            id="category"
            v-model="item.category_id"
            @change="saveToLocalStorage"
          >
            <option value="" selected disabled>Select a category</option>
            <option
              :value="category.id"
              v-for="category in categories"
              :key="category.id"
            >
              {{ category.title }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="desc">Description</label>
          <textarea
            name="desc"
            id="desc"
            v-model="item.description"
            @input="saveToLocalStorage"
          ></textarea>
        </div>
        <div class="form-buttons">
          <button type="button" @click="cancelForm" class="cancel-btn">
            {{ item.category_id || item.description ? "Cancel" : "Close" }}
          </button>
          <button
            type="submit"
            class="submit-btn"
            v-if="item.category_id && item.description"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
@import "./css/add-item-modal.css";
</style>
