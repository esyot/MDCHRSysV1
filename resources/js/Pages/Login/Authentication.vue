<script src="./js/authentication.js"></script>

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
            required
          />
          <button type="submit">Authenticate</button>
        </div>
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

<style scoped>
@import "./css/authentication.css";
</style>
