<script src="./js/add-category-modal.js"></script>

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
