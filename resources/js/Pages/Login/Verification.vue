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

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
  data() {
    return {
      code: "",
    };
  },
  props: {
    user: Object,
    error: String,
  },

  methods: {
    verificationSubmit() {
      Inertia.post("/verification-submit", {
        code: this.code,
      });
    },
  },
};
</script>

<style scoped>
.error {
  color: red;
}
section {
  display: flex;
  justify-content: center;
}
.details {
  padding: 10px;
}

.background {
  display: flex;
  position: fixed;
  align-items: center;
  justify-content: center;
  inset: 0;
  background: linear-gradient(to bottom, rgba(94, 204, 216, 0.3), rgba(10, 124, 137));
}

.verification-content {
  background-color: #fff;
  border-radius: 5px;
}

.header {
  border-top: 6px solid rgb(47, 154, 211);
  margin-bottom: 12px;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  border-bottom: 1px solid #aaaaaa;
  background-color: #e9e9e9;
  width: 100%;
}

.header label {
  display: block;
  padding: 5px;
  font-size: 20px;
  font-weight: bold;
}

.form-group label {
  font-weight: bold;
}

.container-inputs {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
  padding: 10px;
}
.container-inputs button {
  border: none;
  background-color: rgb(58, 204, 129);
  color: white;
  padding: 10px;
  border-radius: 5px;
  opacity: 75%;
}

.container-inputs button:hover {
  opacity: 100%;
  cursor: pointer;
}
.input-container input {
  border-radius: 5px;
  border: 1px solid #aaaaaa;
}

.input-container {
  display: flex;
  gap: 0.2rem;
}

.user-img {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}

.user-img span {
  font-size: 22px;
  font-weight: bold;
}

.user-img img {
  width: 80px;
  border: 3px solid #aaaaaa;
  border-radius: 100%;
}
</style>
