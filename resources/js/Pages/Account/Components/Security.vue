<script src="./js/security.js"></script>

<template>
  <div class="security-content">
    <section class="security-items">
      <div class="title-container">
        <span class="title">Account Features</span>
      </div>
      <div class="form">
        <!-- <form @submit.prevent="accountFeatureSettingSubmit">
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
        </form> -->
      </div>
    </section>

    <section class="security-items">
      <div class="title-container">
        <span class="title">Account Details</span>
      </div>
      <form @submit.prevent="accountSettingFormSubmit">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" v-model="user.user" disabled />
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="user.email" disabled />
        </div>
        <div class="title-container">
          <span class="title">Change Password:</span>
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

<style scoped>
@import "./css/security.css";
</style>
