<script>
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  emits: ["toggleEditRole"],
  props: {
    roleList: Array,
    userRoles: Array,
    user_id: String,
  },
  components: {
    ConfirmationFormModal,
  },

  data() {
    return {
      formData: {
        roles: [],
      },
      isConfirmation: false,
    };
  },
  methods: {
    selectedRole(id, input) {
      if (this.formData.roles.includes(id)) {
        const index = this.formData.roles.indexOf(id);
        if (index !== -1) {
          this.formData.roles.splice(index, 1);
        }
      } else if (!this.userRoles.includes(id) && input.checked) {
        this.formData.roles.push(id);
      }
    },

    closeModal() {
      this.$emit("toggleEditRole");
    },
    submitForm() {
      this.toggleConfirmForm();
      this.closeModal();
      Inertia.post(`/users/${this.user_id}/role-edit`, this.formData);
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
  },

  mounted() {
    const currentRoles = this.roleList.filter((role) =>
      this.userRoles.includes(role.name)
    );
    this.formData.roles = currentRoles.map((role) => role.id);
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
        <span>Edit Roles</span>
        <i>&times;</i>
      </div>
      <div class="input-group">
        <label for="">Current Roles: </label>
        <span v-for="role in userRoles" :key="role" class="role-desc">{{ role }}</span>
      </div>

      <div class="form-checkbox">
        <label>Roles: </label>
        <div v-for="role in roleList" :key="role.id">
          <div class="checkbox-group">
            <input
              type="checkbox"
              :value="role.id"
              :checked="userRoles.includes(role.name)"
              @change="selectedRole(role.id, $event.target)"
            />
            <span>{{ role.name }}</span>
          </div>
        </div>
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button @click="toggleConfirmForm()" class="update-btn">Update</button>
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
}
.input-group {
  padding: 10px;
}

.input-group label {
  font-weight: bold;
}
.form-checkbox {
  padding: 10px;
}

.form-checkbox label {
  font-weight: bold;
}
.checkbox-group {
  display: flex;
  width: 200px;
  margin-bottom: 5px;
}
.checkbox-group input {
  margin-right: 5px;
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
