<script>
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  emits: ["toggleEditStaff"],
  props: {
    user_id: String,
    positionList: Array,
  },
  components: {
    ConfirmationFormModal,
  },

  data() {
    return {
      isConfirmation: false,
      message: "Confirm to update user's department?",
    };
  },
  methods: {
    closeModal() {
      this.$emit("toggleEditStaff");
    },
    submitForm() {
      this.toggleConfirmForm();
      this.closeModal();

      Inertia.patch(`/users/user-department-update`, {
        user_id: this.user_id,
        department_id: this.department_id,
      });
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
  },
};
</script>

<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>

  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <span>Edit Staff Details</span>
        <i @click="closeModal">&times;</i>
      </div>

      <div class="input-group">
        <label for="">Position: </label>
        <input type="text" list="positionList" />
        <datalist id="positionList">
          <option
            :value="position"
            v-for="(position, index) in positionList"
            :key="index"
          >
            {{ position }}
          </option>
        </datalist>
      </div>

      <div class="input-group">
        <label for="">Date Hired: </label>
        <input type="date" />
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button @click="toggleConfirmForm()" class="update-btn">Update</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/edit-staff-modal.css";
</style>
