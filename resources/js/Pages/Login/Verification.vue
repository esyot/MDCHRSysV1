<script src="./js/verification.js"></script>

<template>
  <div class="background">
    <div class="verification-content">
      <div class="header">
        <label for="">Two Step Verification</label>
      </div>

      <section>
        <div class="user-img">
          <img
            class="user-img"
            :src="
              user.img ? '/storage/users/images/' + user.img : './assets/images/user.png'
            "
            alt="User Image"
          />
          <div>
            <span>{{ user.first_name }} {{ user.last_name }}</span>
          </div>
        </div>
      </section>
      <div class="details">
        We've sent you a code in your email, please input the code below.
      </div>
      <div class="container-inputs">
        <form @submit.prevent="verificationSubmit">
          <div class="input-container">
            <input type="text" v-model="code" placeholder="Input your code" />

            <button type="submit">Submit</button>
          </div>
          <small class="error">{{ error }}</small>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/verification.css";
</style>
