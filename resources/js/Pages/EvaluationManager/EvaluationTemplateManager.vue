<script src="./js/evaluation-template-manager.js"></script>

<template>
  <NewTemplateModal v-if="isNewTempModal" @toggleNewTemplate="toggleNewTemplate">
  </NewTemplateModal>

  <OldTemplateModal
    v-if="isOldTempModal"
    :templates="templates"
    @toggleOldTemplate="toggleOldTemplate"
  >
  </OldTemplateModal>

  <ConfirmationDeleteModal
    v-if="isDelete"
    :selected_id="selected_id"
    :selected_type="null"
    :isDelete="isDelete"
    @toggleDeleteForm="toggleDeleteForm"
    @deleteForm="deleteForm"
  ></ConfirmationDeleteModal>

  <div class="main-container">
    <div class="top-nav">
      <button @click="toggleNewTemplate" title="Create a new template from scratch">
        <i class="fa fa-plus"></i> Create New Template
      </button>
      <button @click="toggleOldTemplate" title="Create a new template from a copy ">
        <i class="fa fa-plus"></i> Create From Template
      </button>
    </div>

    <div class="content">
      <div class="cards">
        <div class="card" v-for="template in templates" :key="template.id">
          <div class="card-header">
            <label> {{ template.name }}</label>
          </div>
          <div class="card-body">
            <div class="card-body-item">
              <label for="">For:</label>
              <span> {{ template.for }}</span>
            </div>

            <div class="card-body-item" v-if="template.for === 'teacher'">
              <label for="">Type: </label>
              <span>
                {{
                  template.type === "work"
                    ? "Working Performance"
                    : "Teaching Performance"
                }}</span
              >
            </div>

            <div class="card-body-item">
              <label for="">Created on:</label>
              <span> {{ formatDate(template.created_at) }}</span>
            </div>

            <div class="card-body">
              <div class="card-body-item">
                <span>Online:</span>
                <label class="switch">
                  <input
                    type="checkbox"
                    :checked="template.is_open === 1"
                    @change="switchToggle(template.id, template.for)"
                  />
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button class="open-btn" @click="viewEvaluationTemplate(template.id)">
              <i class="fa-solid fa-eye"></i> View
            </button>
            <button class="delete-btn" @click="toggleDeleteForm(template.id)">
              <i class="fa fa-trash"></i> Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/evaluation-manager.css";
</style>
