<script>
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  emits: ["toggleEditDepartment"],
  props: {
    departmentList: Array,
    userDepartments: Array,
    user_id: String,
  },
  components: {
    ConfirmationFormModal,
  },

  data() {
    return {
      formData: {
        departments: [],
      },
      isConfirmation: false,
    };
  },
  methods: {
    selectedDepartment(id, input) {
      if (this.formData.departments.includes(id)) {
        const index = this.formData.departments.indexOf(id);
        if (index !== -1) {
          this.formData.departments.splice(index, 1);
        }
      } else if (!this.userDepartments.includes(id) && input.checked) {
        this.formData.departments.push(id);
      }

      console.log(this.formData.departments);
    },

    closeModal() {
      this.$emit("toggleEditDepartment");
    },
    submitForm() {
      this.toggleConfirmForm();
      this.closeModal();
      Inertia.post(`/users/${this.user_id}/department-edit`, this.formData);
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
  },

  mounted() {
    const currentDepartments = this.departmentList.filter((department) =>
      this.userDepartments.includes(department.acronym)
    );
    this.formData.departments = currentDepartments.map(
      (department) => department.department_id
    );
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
      <div class="modal-header">
        <span>Edit Departments</span>
        <i @click="closeModal">&times;</i>
      </div>
      <div class="input-group">
        <label for="">Current Departments: </label>
        <span>{{ userDepartments.join(", ") }}</span>
      </div>
      <div class="form-subtitle">
        <label>Departments: </label>
      </div>

      <div class="form-checkbox-items form-checkbox">
        <div class="" v-for="department in departmentList" :key="department.id">
          <div class="checkbox-group">
            <input
              type="checkbox"
              :value="department.id"
              :checked="userDepartments.includes(department.acronym)"
              @change="selectedDepartment(department.department_id, $event.target)"
            />
            <span>{{ department.department_name }} ({{ department.acronym }})</span>
          </div>
        </div>
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button
          v-if="formData.departments.length != 0"
          @click="toggleConfirmForm()"
          class="update-btn"
        >
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
</style>
