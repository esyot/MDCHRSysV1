<template>
  <div class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <label for="">Authentication</label>
      </div>

      <form @submit.prevent="authCheckSubmit" class="form-items" autocomplete="off">
        <div class="authentication-form">
          <input
            type="password"
            name="password"
            v-model="password"
            autocomplete="off"
            placeholder="Enter your password"
          />

          <button type="submit">Authenticate</button>
        </div>

        <small class="error">{{ authError }}</small>
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
  props: {
    authError: {
      type: Object,
    },
  },
  methods: {
    authCheckSubmit() {
      Inertia.post("/authentication-check", { password: this.password });
    },
  },
};
</script>

<style scoped>
.authentication-form {
  display: flex;
  gap: 0.2rem;
}
.error {
  display: flex;
  font-style: italic;
  color: #ff0000;
  font-weight: lighter;
  font-size: 12px;
}
.modal {
  display: flex;
  position: fixed;
  inset: 0;
  z-index: 9;
  justify-content: center;
  align-items: center;
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
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
  flex-direction: column;
  gap: 0.5rem;
  padding: 10px;
}

.form-items input {
  padding: 10px;
  border-radius: 5px;
  width: 100%;
}

.form-items button {
  border: none;
  background-color: rgb(43, 235, 91);
  border-radius: 5px;
  cursor: pointer;
  color: #fff;
  opacity: 75%;
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
