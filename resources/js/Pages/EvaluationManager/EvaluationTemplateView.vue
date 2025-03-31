<script src="./js/evaluation-template-view.js"></script>
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
  <div class="top-nav">
    <div class="title">
      <span>View & Edit - {{ template.name }}</span>
    </div>
    <div class="top-nav-buttons">
      <button @click="toggleNewCategory"><i class="fa fa-plus"></i> Add Category</button>
      <button @click="toggleNewItem"><i class="fa fa-plus"></i> Add Item</button>
    </div>
  </div>
  <div class="content">
    <div class="category" v-for="(category, index) in categories" :key="category.id">
      <div class="category-header">
        <div class="category-header-item">
          <span>{{ String.fromCharCode(65 + (index % 26)) }}. {{ category.title }}</span>
        </div>
        <ul>
          <li v-for="(item, index) in category.items" :key="item.id">
            <span>{{ index + 1 }}. {{ item.description }}</span>

            <i class="blue fas fa-pencil" @click="toggleIsEditItem(item)"></i>
            <i class="red fas fa-trash" @click="toggleConfirmForm(item)"></i>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/evaluation-view.css";
</style>
