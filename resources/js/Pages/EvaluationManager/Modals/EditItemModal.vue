<script>
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  emits: ["toggleIsEditItem"],
  components: {
    ConfirmationFormModal,
  },
  data() {
    return {
      formData: {
        item_id: this.selectediItem.id,
        description: this.selectediItem.description,
      },
      isConfirmation: false,
      message: "Are you sure to update description?",
    };
  },
  props: {
    selectediItem: Object,
  },
  methods: {
    closeModal() {
      this.$emit("toggleIsEditItem");
    },
    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },

    submitForm() {
      const formData = this.formData;
      Inertia.put("/evaluations/template/update-item", formData);
      this.toggleConfirmForm();
      this.closeModal();
    },
  },
};
</script>
<template>
  <ConfirmationFormModal
    v-if="isConfirmation"
    :message="message"
    :isConfirmation="isConfirmation"
    @submitForm="submitForm"
    @toggleConfirmForm="toggleConfirmForm"
  ></ConfirmationFormModal>

  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <span>Edit Item</span>
        <i @click="closeModal" class="fas fa-circle-xmark"></i>
      </div>
      <div class="input-group">
        <label for="">Edit description:</label>
        <textarea type="text" v-model="formData.description" />
      </div>

      <div class="modal-footer">
        <button type="button" class="cancel-btn">Cancel</button>
        <button type="button" class="submit-btn" @click="toggleConfirmForm">
          Submit
        </button>
      </div>
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

.modal-header {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.modal-header span {
  font-size: 14pt;
  font-weight: bold;
}

.modal-header i {
  color: rgb(233, 47, 47);
}

.modal-header i:hover {
  color: rgb(233, 47, 47);
  cursor: pointer;
  opacity: 50%;
}

.input-group {
  display: flex;
  flex-direction: column;
  margin: 10px;
}

.input-group textarea {
  padding: 10px 5px;
  border-radius: 10px;
  border: 1px solid #ddd;
  min-height: 100px;
}

.modal-footer {
  display: flex;
  justify-content: end;
  gap: 0.3rem;
  padding: 10px;
}

.modal-footer button {
  padding: 10px;
  opacity: 50%;
  border-radius: 5px;
  border: none;
}

.modal-footer button:hover {
  cursor: pointer;
  opacity: 100%;
}

.submit-btn {
  background-color: rgb(39, 136, 221);
  color: #fff;
}
</style>
