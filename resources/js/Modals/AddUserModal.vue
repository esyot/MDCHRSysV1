<script>
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
export default {
  name: "AddUserModal",
  emits: ["toggleAddUserModal"],
  components: {
    ConfirmationFormModal,
  },
  data() {
    return {
      formData: {
        first_name: "",
        last_name: "",
        middle_name: "",
        date_hired: "",
        departments: [],
        roles: [],
      },
      isConfirmation: false,
      errors: {
        departments: false,
        roles: false,
      },
    };
  },
  props: {
    departments: Array,
    roleList: Array,
  },
  methods: {
    closeModal() {
      this.$emit("toggleAddUserModal");
    },
    selectedDepartment(id) {
      if (this.formData.departments.includes(id)) {
        const index = this.formData.departments.indexOf(id);
        this.formData.departments.splice(index, 1);
      } else {
        this.formData.departments.push(id);
      }
    },
    selectedRole(id) {
      if (this.formData.roles.includes(id)) {
        const index = this.formData.roles.indexOf(id);
        this.formData.roles.splice(index, 1);
      } else {
        this.formData.roles.push(id);
      }
    },
    validateForm() {
      this.errors.departments = this.formData.departments.length === 0;
      this.errors.roles = this.formData.roles.length === 0;
      return !this.errors.departments && !this.errors.roles;
    },
    submitForm() {
      if (this.validateForm()) {
        this.toggleConfirmForm();
        this.closeModal();
        Inertia.post("/users/user-add", this.formData);
      }
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
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>

  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <form @submit.prevent="submitForm" class="form">
        <div class="form-title">
          <span>Add a user</span>
          <i @click="closeModal">&times;</i>
        </div>
        <div class="form-group">
          <label for="first_name">First name:</label>
          <input
            id="first_name"
            type="text"
            placeholder="Input first name"
            v-model="formData.first_name"
            required
          />
        </div>

        <div class="form-group">
          <label for="last_name">Last name:</label>
          <input
            id="last_name"
            type="text"
            placeholder="Input last name"
            v-model="formData.last_name"
            required
          />
        </div>

        <div class="form-group">
          <label for="middle_name">Middle name:</label>
          <input
            id="middle_name"
            type="text"
            placeholder="Input middle name"
            v-model="formData.middle_name"
            required
          />
        </div>

        <div class="grouped-checkboxes">
          <div class="form-checkbox">
            <label>Departments:</label>
            <div v-for="dept in departments" :key="dept.department_id">
              <div class="checkbox-group">
                <input
                  type="checkbox"
                  :value="dept.department_id"
                  v-model="formData.departments"
                  @click="selectedDepartment(dept.department_id)"
                />
                <span>{{ dept.department_name }}</span>
              </div>
            </div>
          </div>

          <div class="form-checkbox">
            <label>Roles:</label>
            <div v-for="role in roleList" :key="role.id">
              <div class="checkbox-group">
                <input
                  type="checkbox"
                  :value="role.id"
                  v-model="formData.roles"
                  @click="selectedRole(role.id)"
                />
                <span>{{ role.name }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <span v-if="errors.departments" class="error"
            >Please select atleast one department.</span
          >
          <span v-if="errors.roles" class="error">Please select atleast one role.</span>
        </div>

        <div class="form-group">
          <label for="date_hired">Date Hired:</label>
          <input id="date_hired" type="date" v-model="formData.date_hired" required />
        </div>

        <div class="form-buttons">
          <button type="button" @click="closeModal" class="cancel-btn">Cancel</button>
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
  align-items: center;
  justify-content: center;
  inset: 0;
  z-index: 99;
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
}

.modal-content {
  user-select: none;
  display: flex;
  flex-direction: column;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  margin: 10px;
}

.form {
  display: flex;
  flex-direction: column;
}
.form-title {
  display: flex;
  justify-content: space-between;
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 10px;
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.form-title i {
  opacity: 50%;
}

.form-title i:hover {
  cursor: pointer;
  opacity: 100%;
}
.form-group {
  display: flex;
  flex-direction: column;
  padding-inline: 10px;
  margin-bottom: 5px;
}

.form-group label {
  font-weight: bold;
  margin-bottom: 5px;
}

.form-checkbox {
  display: flex;
  flex-direction: column;
  padding: 10px;
}
.form-checkbox label {
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input {
  padding: 10px;
  border: 1px solid #7a7a7a;
  border-radius: 5px;
  width: 100%;
  box-sizing: border-box;
  box-shadow: inset 3px 3px 3px rgba(0, 0, 0, 0.1);
}
.checkbox-group {
  display: flex;
  width: 200px;
  margin-bottom: 5px;
}
.checkbox-group input {
  margin-right: 5px;
}

.grouped {
  display: flex;
  align-items: center;
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

.grouped-checkboxes {
  display: flex;
  border: 1px solid #787878;
  margin-inline: 10px;
  border-radius: 5px;
  margin-top: 5px;
  margin-bottom: 5px;
  box-shadow: inset 3px 3px 3px rgba(0, 0, 0, 0.1);
}

.error {
  color: red;
  font-size: 0.875rem;
  margin-top: 5px;
}
</style>
