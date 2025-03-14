<script>
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
export default {
  emits: ["toggleNewCategory"],
  components: {
    ConfirmationFormModal,
  },
  props: {
    template_id: Number,
  },

  data() {
    return {
      isConfirmation: false,
      category: {
        template_id: "",
        title: "",
      },
      message: "Are you sure to insert this category?",
    };
  },
  methods: {
    closeModal() {
      this.$emit("toggleNewCategory");
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
    submitForm() {
      Inertia.post("/evaluations/template/add-category", {
        category: this.category,
      });
      this.toggleConfirmForm();
      this.closeModal();
      this.removeFromLocalStorage();
    },
    saveToLocalStorage() {
      localStorage.setItem("templateCategoryData", JSON.stringify(this.category));
    },
    removeFromLocalStorage() {
      localStorage.removeItem("templateCategoryData");
    },
    cancelForm() {
      this.removeFromLocalStorage();
      this.closeModal();
    },
  },

  created() {
    const category = localStorage.getItem("templateCategoryData");
    if (category) {
      this.category = JSON.parse(category);
    }

    this.category.template_id = this.template_id;
  },
};
</script>

<template>
  <ConfirmationFormModal
    v-if="isConfirmation"
    :isConfirmation="isConfirmation"
    :message="message"
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
          <label for="name">Title:</label>

          <input
            type="text"
            id="name"
            name="name"
            placeholder="Enter a category title"
            v-model="category.title"
            @input="saveToLocalStorage"
          />
        </div>
        <div class="form-footer">
          <button type="button" @click="cancelForm" class="cancel-btn">
            {{ category.title ? "Cancel" : "Close" }}
          </button>
          <button type="submit" class="submit-btn" v-if="category.title">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
@import "./css/add-category.css";
</style>
