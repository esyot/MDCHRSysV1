<template>
  <div class="security-content">
    <section class="security-items">
      <div class="title-container">
        <span class="title">Account Features</span>
      </div>
      <div class="form">
        <form @submit.prevent="accountFeatureSettingSubmit">
          <div class="form-items">
            <div>
              <input
                type="checkbox"
                name="is_update_with_email"
                :checked="user.is_update_with_email"
              />
              <span>Receive Updates Through Email</span>
            </div>
            <small>
              <i class="fas fa-circle-exclamation"></i>
              Note: Receive updates from the system through given email.</small
            >
          </div>
          <div class="form-items">
            <div>
              <input
                type="checkbox"
                name="is_two_step_verification"
                :checked="user.is_two_step_verification"
              />
              <span>Two Authentication Mode</span>
            </div>

            <small>
              <i class="fas fa-circle-exclamation"></i>
              Note: Receive and input a code first when logging in.</small
            >
          </div>
          <div>
            <button type="submit">Save Changes</button>
          </div>
        </form>
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
              placeholder="Input new password"
              v-model="new_password_1"
            />
            <i class="fas fa-circle-check" v-if="newPasswordChecked"></i>
          </div>
          <div class="requirement-labels">
            <small>
              <i
                :class="
                  !this.passwordLength
                    ? 'icon-info fas fa-circle-exclamation'
                    : 'icon-check fas fa-circle-check'
                "
              ></i>
              At least 12-16 characters.
            </small>
            <small>
              <i
                :class="
                  !this.passwordUpperLowerCase
                    ? 'icon-info fas fa-circle-exclamation'
                    : 'icon-check fas fa-circle-check'
                "
              ></i>
              At least 1 uppercase and 1 lowercase letter.
            </small>

            <small>
              <i
                :class="
                  !this.passwordSpecialChar
                    ? 'icon-info fas fa-circle-exclamation'
                    : 'icon-check fas fa-circle-check'
                "
              ></i>
              At least 1 special character such as "[!@#$%^&*(),.?":{}|<>]".
            </small>
          </div>
        </div>

        <div class="form-group" v-if="isPassword">
          <label for="retype-password">Re-type Password:</label>
          <div class="form-field-password">
            <input
              type="password"
              placeholder="Re-type password"
              v-model="new_password_2"
              :disabled="!passwordValidated"
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
      is_two_step_verification: "",
      is_update_with_email: "",
      old_password: "",
      localUserCredentials: { ...this.user },
      isPassword: false,
      isAccountFormComplete: false,
      new_password_1: "",
      new_password_2: "",
      isNewPasswordEqual: false,
      passwordLength: false,
      passwordUpperLowerCase: false,
      passwordSpecialChar: false,
      passwordValidated: false,
      newPasswordChecked: false,
    };
  },
  watch: {
    userCredentials: {
      handler(newVal) {
        this.userCredentials.username = newVal.username || "";
      },
      immediate: true,
    },
    new_password_1(newValue) {
      this.passwordUpperLowerCase = /[a-z]/.test(newValue) && /[A-Z]/.test(newValue);

      this.passwordLength = newValue.length > 8;

      this.passwordSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(newValue);

      if (
        this.passwordUpperLowerCase &&
        this.passwordLength &&
        this.passwordSpecialChar
      ) {
        this.passwordValidated = true;
      } else {
        this.passwordValidated = false;
      }
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

    accountFeatureSettingSubmit(event) {
      const formData = new FormData(event.target);
      Inertia.post("/user-account-feature-update", formData);
    },
  },
};
</script>

<style scoped>
.title-container {
  border-bottom: #cecece 1px solid;
  background-color: #ebebeb;
  box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
  padding: 10px;
  position: sticky;
  top: 0;
  z-index: 1;
}

.title {
  font-size: 14px;
  padding: 10px;
  font-weight: bold;
}
.form-group {
  margin-bottom: 15px;
  padding: 10px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  font-size: 12px;
}

.form-group input {
  width: 96%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}
.form button {
  border: none;
  float: right;
  padding: 10px;
  background-color: #3b82f6;
  color: #fff;
  border-radius: 5px;
  opacity: 75%;
  margin: 10px;
}
.form span {
  font-size: 16px;
  font-weight: bold;
}
.form button:hover {
  opacity: 100%;
  cursor: pointer;
}
.requirement-labels {
  display: flex;
  flex-direction: column;
  margin-top: 5px;
}
.icon-check {
  color: green;
}
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
  background-color: #3b82f6;
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
