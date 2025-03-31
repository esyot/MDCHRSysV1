<script src="./js/login.js"></script>

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

<style scoped>
@import "./css/login.css";
</style>
