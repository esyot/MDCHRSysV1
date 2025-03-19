<script>
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  emits: ["toggleEditDepartment"],
  props: {
    departmentList: Array,
    userDepartment: Object,
    user_id: String,
  },
  components: {
    ConfirmationFormModal,
  },

  data() {
    return {
      department_id: "",
      isConfirmation: false,
      message: "Confirm to update user's department?",
    };
  },
  methods: {
    closeModal() {
      this.$emit("toggleEditDepartment");
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
        <span>Edit Department</span>
        <i @click="closeModal">&times;</i>
      </div>
      <div class="input-group">
        <label for="">Current Department: </label>
        <span v-if="userDepartment"
          >{{ userDepartment.name }} ({{ userDepartment.acronym }})</span
        >
      </div>
      <div class="form-subtitle">
        <label>Departments: </label>
      </div>

      <div class="form-select">
        <select name="" id="" v-model="department_id">
          <option value="" selected disabled>Select a department</option>
          <option
            :value="department.id"
            v-for="department in departmentList"
            :key="department.id"
          >
            {{ department.name }}({{ department.acronym }})
          </option>
        </select>
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button v-if="department_id" @click="toggleConfirmForm()" class="update-btn">
          Update
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
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
}

.modal-content {
  background-color: #fff;
  margin: 5px;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  padding: 5px;
  align-items: center;
  border-bottom: 1px solid #c7c7c7;
}
.modal-header span {
  font-size: 16pt !important;
  padding-inline: 5px;
  font-weight: bold;
}

.modal-header i {
  font-weight: bold;
  font-size: 16pt !important;
  margin-inline: 10px;
  opacity: 50%;
}

.modal-header i:hover {
  opacity: 100%;
  cursor: pointer;
}
.input-group {
  display: flex;
  flex-direction: column;
  padding: 10px;
}

.input-group label {
  font-weight: bold;
}
.form-checkbox {
  padding: 10px;
  max-height: 50vh;
  overflow-y: auto;
}

.form-subtitle {
  padding-inline: 10px;
}

.form-subtitle label {
  font-weight: bold;
  display: block;
}

.checkbox-group {
  display: flex;
  margin-bottom: 5px;
  align-items: center;
  border: 1px solid #a0a0a0;
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
  width: auto;
  padding: 10px;
  gap: 0.3rem;
}

.checkbox-group:hover {
  background-color: #c7c7c7;
}
.checkbox-group input {
  margin-right: 5px;
  cursor: pointer;
  scale: 1.5;
}

.checkbox-group label {
  font-weight: bold;
  margin-bottom: 5px;
}

.buttons {
  display: flex;
  justify-content: end;
  margin: 10px;
  gap: 0.2rem;
}

.buttons button {
  padding: 10px;
  border-radius: 5px;
  border: none;
  opacity: 50%;
}

.buttons button:hover {
  opacity: 100%;
  cursor: pointer;
}

.close-btn {
  background-color: #848484;
  color: #fff;
}

.update-btn {
  background-color: rgb(32, 131, 222);
  color: #fff;
}

.form-select {
  padding: 10px;
}

.form-select select {
  padding: 10px;
  border-radius: 5px;
}
</style>
