<script>
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
export default {
  emits: ["toggleOldTemplate"],
  components: {
    ConfirmationFormModal,
  },
  methods: {
    closeModal() {
      this.$emit("toggleOldTemplate");
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
    submitForm() {
      Inertia.post("/evalutions/copy-old-template/", this.formData);
      this.toggleConfirmForm();
      this.closeModal();
      this.removeFromLocalStorage();
    },

    saveToLocalStorage() {
      localStorage.setItem("oldTemplateData", JSON.stringify(this.formData));
    },

    removeFromLocalStorage() {
      localStorage.removeItem("oldTemplateData");
      this.closeModal();
    },
  },

  created() {
    const oldTemplateData = localStorage.getItem("oldTemplateData");

    if (oldTemplateData) {
      this.formData = JSON.parse(oldTemplateData);
    }
  },
  props: {
    templates: Object,
  },
  data() {
    return {
      formData: {
        template_id: "",
        name: "",
        for: "",
      },
      isConfirmation: false,
      message: "Submit this as a new evaluation template?",
    };
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
          <span>Create From Template</span>
          <i @click="closeModal">&times;</i>
        </div>
        <div class="form-group">
          <label for="copy_from">Copy From</label>
          <select
            name="copy_from"
            id="copy_from"
            v-model="formData.template_id"
            @change="saveToLocalStorage"
          >
            <option value="" selected disabled>Select From Template</option>
            <option :value="template.id" v-for="template in templates" :key="template.id">
              {{ template.name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="name">Template Name</label>
          <input
            type="text"
            id="name"
            name="name"
            v-model="formData.name"
            placeholder="Enter template name"
            @input="saveToLocalStorage"
          />
        </div>

        <div class="form-group">
          <label>For:</label>
          <select
            id="temp_type"
            name="temp_type"
            v-model="formData.for"
            @change="saveToLocalStorage"
          >
            <option value="" selected disabled>Select evaluation type</option>
            <option value="teacher">Teachers</option>
            <option value="staff">Staffs</option>
            <option value="others">Others</option>
          </select>
        </div>

        <div class="form-buttons">
          <button type="button" @click="removeFromLocalStorage" class="cancel-btn">
            Cancel
          </button>
          <button type="submit" class="submit-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.modal {
  display: flex;
  position: fixed;
  justify-content: center;
  align-items: center;
  inset: 0;
  z-index: 99;
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
}

.modal-content {
  user-select: none;
  background-color: #fefefe;
  border: 1px solid #888;
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  min-width: 400px;
}

.form-title {
  display: flex;
  justify-content: space-between;
  font-size: 14pt !important;
  font-weight: bold;
  align-items: center;
  margin-bottom: 10px;
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.form-title i {
  font-size: 20pt !important;
  opacity: 50%;
}

.form-title i:hover {
  cursor: pointer;
  opacity: 100%;
}

.form-group {
  display: flex;
  flex-direction: column;
  padding: 10px;
}

.form-group label {
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input {
  padding: 10px;
  border: 1px solid #7a7a7a;
  border-radius: 5px;
  width: 100%;
  box-sizing: border-box;
}

.form-group select {
  padding: 10px;
  border: 1px solid #7a7a7a;
  border-radius: 5px;
  width: 100%;
  box-sizing: border-box;
}

.form-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
  padding: 10px;
  background-color: #f1f1f1;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
}

.form-buttons button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.cancel-btn {
  background-color: #ccc;
  color: #333;
}

.submit-btn {
  background-color: #007bff;
  color: #fff;
}

.cancel-btn:hover,
.submit-btn:hover {
  opacity: 0.8;
}
</style>
