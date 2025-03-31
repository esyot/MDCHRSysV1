<script>
import Layout from "@/Layouts/Layout.vue";

export default {
  layout: Layout,
  data() {
    return {
      currentPassword: "",
      newPassword: "",
      confirmPassword: "",
      errorMessage: "",
      successMessage: "",
    };
  },
  methods: {
    updatePassword() {
      if (this.newPassword !== this.confirmPassword) {
        this.errorMessage = "New password and confirm password do not match.";
        return;
      }

      setTimeout(() => {
        this.successMessage = "Password updated successfully!";
        this.errorMessage = "";
        this.currentPassword = "";
        this.newPassword = "";
        this.confirmPassword = "";
      }, 1000);
    },
  },
};
</script>

<template>
  <div class="security-container">
    <h1>Security Settings</h1>
    <div class="form-container">
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>
      <form @submit.prevent="updatePassword">
        <div class="form-group">
          <label for="currentPassword">Current Password</label>
          <input
            type="password"
            id="currentPassword"
            v-model="currentPassword"
            required
          />
        </div>
        <div class="form-group">
          <label for="newPassword">New Password</label>
          <input type="password" id="newPassword" v-model="newPassword" required />
        </div>
        <div class="form-group">
          <label for="confirmPassword">Confirm New Password</label>
          <input
            type="password"
            id="confirmPassword"
            v-model="confirmPassword"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.security-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

.form-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 5px;
  font-weight: bold;
}

input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

.alert {
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 4px;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}
</style>
