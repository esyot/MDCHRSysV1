<template>
  <div class="container">
    <div class="content">
      <div class="logo">
        <img src="/public/assets/images/mdc-logo.png" alt="Logo" />
      </div>

      <div class="login-form">
        <h2>Welcome to MDC-HR System</h2>
        <form @submit.prevent="handleLogin">
          <div class="input-group">
            <label for="user">Username:</label>
            <div class="usernameField">
              <i class="fas fa-user field-icon-user"></i>
              <input
                id="user"
                v-model="user.value"
                placeholder="Enter your username"
                required
                type="text"
              />
            </div>
            <span v-if="responseData" class="error">
              {{ responseData.user.errorMessage }}
            </span>
          </div>

          <div class="input-group">
            <label for="password">Password:</label>
            <div class="passwordField">
              <i class="fas fa-key field-icon-pass"></i>
              <input
                id="password"
                v-model="password.value"
                placeholder="Enter your password"
                required
                :type="isPasswordVisible ? 'text' : 'password'"
              />
              <i
                id="eye-icon"
                class="fas"
                :class="isPasswordVisible ? 'fa-eye' : 'fa-eye-slash'"
                @click="viewPassword"
              ></i>
            </div>
            <span v-if="responseData" class="error">
              {{ responseData.password.errorMessage }}
            </span>
          </div>
          <div class="login-btn" @mouseover="moveButton" :style="buttonStyle">
            <button type="submit">Log In</button>
          </div>
        </form>

        <p class="description">
          If you don’t remember your account credentials or have forgotten your password,
          please get in touch with the Systems Development & Administration Office.
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";

export default {
  data() {
    return {
      user: {
        value: "",
        errorMessage: "",
      },
      password: {
        value: "",
        errorMessage: "",
      },
      errorMessage: this.$page?.props?.errorMessage || "",
      loading: false,
      isPasswordVisible: false,
      buttonStyle: {
        transition: "transform 0.3s ease",
      },
    };
  },
  props: {
    responseData: {
      type: Object,
    },
  },
  watch: {
    "user.value": function (newValue) {
      if (newValue && this.password.value) {
        this.buttonStyle = {
          transition: "transform 0.3s ease",
          transform: "translate(0, 0)",
        };
      }
    },
    "password.value": function (newValue) {
      if (this.user.value && newValue) {
        this.buttonStyle = {
          transition: "transform 0.3s ease",
          transform: "translate(0, 0)",
        };
      }
    },
  },
  methods: {
    async handleLogin() {
      this.errorMessage = "";
      this.loading = true;

      if (this.user.value && this.password.value) {
        try {
          await Inertia.post("/login-submit", {
            user: this.user.value,
            password: this.password.value,
          });
        } catch (error) {
          this.errorMessage = "Login failed. Please check your credentials.";
          console.error("Login error: ", error);
        }
      } else {
        this.errorMessage = "Please enter both username and password.";
      }

      this.loading = false;
    },

    viewPassword() {
      this.isPasswordVisible = !this.isPasswordVisible;
    },

    moveButton(event) {
      if (!this.user.value || !this.password.value) {
        const distance = 500;
        const offsetX = Math.random() * distance - distance / 2;
        const offsetY = Math.random() * distance - distance / 2;

        this.buttonStyle = {
          transition: "transform 0.2s ease-out",
          transform: `translate(${offsetX}px, ${offsetY}px)`,
        };
      }
    },
  },
};
</script>

<style scoped>
@import "./css/login.css";
</style>
