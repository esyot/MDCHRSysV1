<template>
  <div class="security-content">
    <section class="security-items">
      <div class="title-container">
        <span class="title">Account Features</span>
      </div>
      <div class="form">
        <div class="form-items">
          <div>
            <input type="checkbox" id="username" />
            <span>Receive Updates Through Email</span>
          </div>
          <small>
            <i class="fas fa-circle-exclamation"></i>
            Note: Receive updates from the system through given email.</small
          >
        </div>
        <div class="form-items">
          <div>
            <input type="checkbox" id="username" />
            <span>Two Authentication Mode</span>
          </div>

          <small>
            <i class="fas fa-circle-exclamation"></i>
            Note: Receive and input a code first when logging in.</small
          >
        </div>
      </div>
    </section>

    <section class="security-items">
      <div class="title-container">
        <span class="title">Account Settings</span>
      </div>
      <form @submit.prevent="accountSettingFormSubmit">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" v-model="user.user" disabled />
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="user.email" />
        </div>

        <div class="form-group">
          <label for="old-password">Input Old Password:</label>
          <div class="form-field-password">
            <input
              type="password"
              maxlength="8"
              placeholder="Input old password"
              v-model="old_password"
            />
            <i class="fas fa-circle-check" v-if="isPassword"></i>
            <img
              src="/public/assets/loader/loading.gif"
              v-if="!isPassword && this.old_password"
              alt=""
            />
          </div>
        </div>

        <div class="form-group" v-if="isPassword">
          <label for="new-password">Input New Password:</label>
          <div class="form-field-password">
            <input
              type="password"
              maxlength="8"
              placeholder="Input new password"
              v-model="new_password_1"
            />
            <i class="fas fa-circle-check" v-if="this.new_password_1.length === 8"></i>
          </div>
          <small>
            <i class="icon-info fas fa-circle-exclamation"></i>
            Password must contain atleast 8-12 characters.
          </small>
        </div>

        <div class="form-group" v-if="isPassword">
          <label for="retype-password">Re-type Password:</label>
          <div class="form-field-password">
            <input
              type="password"
              maxlength="8"
              placeholder="Re-type password"
              v-model="new_password_2"
            />
            <i class="fas fa-circle-check" v-if="this.isNewPasswordEqual"></i>
          </div>
        </div>
        <div class="form-group-foooter" v-if="this.isNewPasswordEqual">
          <button type="submit">Save Changes</button>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import bcrypt from "bcryptjs";
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "Security",
  props: {
    user: Object,
    userCredentials: Object,
  },
  data() {
    return {
      old_password: "",
      localUserCredentials: { ...this.user },
      isPassword: false,
      isAccountFormComplete: false,
      new_password_1: "",
      new_password_2: "",
      isNewPasswordEqual: false,
    };
  },
  watch: {
    userCredentials: {
      handler(newVal) {
        this.userCredentials.username = newVal.username || "";
      },
      immediate: true,
    },
    old_password(newValue) {
      this.checkOldPassword();
    },

    new_password_2(newValue) {
      this.PasswordCompare();
    },
  },
  methods: {
    async checkOldPassword() {
      const isMatch = await bcrypt.compare(this.old_password, this.user.password);

      if (isMatch) {
        this.isPassword = true;
      } else {
        this.isPassword = false;
      }
    },

    PasswordCompare() {
      if (this.new_password_1 === this.new_password_2) {
        this.isNewPasswordEqual = true;
      } else {
        this.isNewPasswordEqual = false;
      }
    },

    accountSettingFormSubmit() {
      const data = {
        email: this.user.email,
        password: this.new_password_2,
      };

      this.old_password = "";
      this.new_password_1 = "";
      this.new_password_2 = "";
      this.isNewPasswordEqual = false;

      Inertia.post("/user-account-setting-update", data);
    },
  },
};
</script>

<style scoped>
.icon-info {
  color: red;
}
.form-field-password {
  border: 1px solid #b7b7b7;
  border-radius: 5px;
  display: flex;
  align-items: center;
}

.form-field-password input {
  background-color: transparent;
  border: none;
  width: 100%;
}

.form-field-password i {
  padding: 10px;
  color: green;
}

.form-field-password img {
  width: 20px;
  padding: 10px;
}
.form-field-password input:focus {
  outline: none;
}
.field-password {
  display: flex;
  justify-content: space-between;
  padding: 10px;
}
.security-content {
  display: flex;
  flex-wrap: wrap;
  height: 78vh;
  overflow-y: auto;
  margin-top: 5px;
  gap: 0.5rem;
}

.security-items {
  flex-grow: 1;
  flex-basis: 400px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.form-group-foooter {
  display: flex;
  padding: 10px;
  justify-content: end;
}

.form-group-foooter button {
  background-color: rgb(56, 129, 254);
  border: none;
  padding: 10px;
  color: #fff;
  border-radius: 5px;
  opacity: 75%;
}
.form-group-foooter button:hover {
  opacity: 100%;
  cursor: pointer;
}

.form {
  padding: 10px;
  gap: 0.5rem;
}

.form-items {
  padding: 10px;
}

.form-items i {
  color: rgb(245, 15, 15);
}
</style>
