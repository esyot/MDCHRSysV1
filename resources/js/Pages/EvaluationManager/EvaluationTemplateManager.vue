<script>
import Layout from "@/Layouts/Layout.vue";
import NewTemplateModal from "../EvaluationManager/Modals/NewTemplateModal.vue";
import OldTemplateModal from "../EvaluationManager/Modals/OldTemplateModal.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationDeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
import { useToast } from "vue-toastification";

export default {
  layout: Layout,
  components: {
    NewTemplateModal,
    OldTemplateModal,
    ConfirmationDeleteModal,
  },
  props: {
    templates: Object,
  },
  data() {
    return {
      isNewTempModal: false,
      isOldTempModal: false,
      isDelete: false,
      selected_id: null,
    };
  },
  methods: {
    formatDate(date) {
      const convertedDate = new Date(date);
      const options = {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: true,
      };
      return convertedDate.toLocaleString("en-US", options);
    },
    toggleNewTemplate() {
      this.isNewTempModal = !this.isNewTempModal;
    },
    toggleOldTemplate() {
      this.isOldTempModal = !this.isOldTempModal;
    },
    viewEvaluationTemplate(id) {
      Inertia.visit(`/evaluations/evaluation-manager/${id}`);
    },
    toggleDeleteForm(id) {
      this.selected_id =
        this.selected_id === id ? (this.selected_id = "") : (this.selected_id = id + "");
      this.isDelete = !this.isDelete;
    },
    deleteForm(id) {
      const toast = useToast();

      Inertia.delete(`/evaluations/template-delete/${this.selected_id}`, {
        onSuccess: () => {
          toast.success("Template deleted successfully", {
            position: "top-center",
            duration: 3000,
          });

          this.toggleDeleteForm();
        },

        onError: (errors) => {
          toast.error("An error occurred. Please try again.", {
            position: "top-center",
            duration: 3000,
          });

          this.toggleDeleteForm();
        },
      });
    },
    switchToggle(id, type) {
      const toast = useToast();

      Inertia.visit(`/evaluations/template-toggle/${id}/${type}`, {
        onSuccess: () => {
          toast.success("Evaluation form updated successfully!", {
            position: "top-center",
            duration: 1000,
          });
        },

        onError: (errors) => {
          toast.error("An error occurred. Please try again.", {
            position: "top-center",
            duration: 1000,
          });
        },
      });
    },
  },
};
</script>

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
            <label for="">Name:</label>
            <span> {{ template.name }}</span>
          </div>
          <div class="card-body">
            <div class="card-body-item">
              <label for="">For:</label>
              <span> {{ template.for }}</span>
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
