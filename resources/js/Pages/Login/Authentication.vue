<template>
  <div class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <label for="">Authentication</label>
      </div>

      <form @submit.prevent="authCheckSubmit" class="form-items" autocomplete="off">
        <input
          type="password"
          name="password"
          v-model="password"
          autocomplete="off"
          placeholder="Enter your password"
        />
        <button type="submit">Authenticate</button>
      </form>
      <div class="modal-footer">
        <div class="info">
          <i class="icon-warning fas fa-circle-exclamation fa-sm"></i>
          <small>Please input your password to procceed this page.</small>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "Authentication",
  data() {
    return {
      password: "",
    };
  },
  methods: {
    authCheckSubmit() {
      Inertia.post("/authentication-check", { password: this.password });
    },
  },
};
</script>

<style scoped>
.modal {
  display: flex;
  position: fixed;
  inset: 0;
  z-index: 9;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.3);
}
.modal-content {
  background-color: #fff;
  padding: 5px;
  border-radius: 5px;
}
.modal-header {
  padding: 5px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.modal-header label {
  font-size: 18px;
  font-weight: bold;
}

.modal-header span {
  font-size: 18px;
  font-weight: bold;
  opacity: 60%;
  cursor: pointer;
}

.modal-header span:hover {
  opacity: 100%;
}

.form-items {
  display: flex;
  gap: 0.5rem;
  padding: 10px;
}

.form-items input {
  padding: 10px;
  width: 100%;
}

.form-items button {
  border: none;
  background-color: rgb(43, 235, 91);
  border-radius: 5px;
  cursor: pointer;
  color: #fff;
  opacity: 50%;
}

.form-items button:hover {
  opacity: 100%;
}

.modal-footer {
  padding: 10px;
}

.modal-footer .info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 0.2rem;
}

.modal-footer .icon-warning {
  color: red;
}
</style>
