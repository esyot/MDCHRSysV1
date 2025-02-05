<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      isDropdownVisible: false,
    };
  },
  props: {
    user: Object,
    pageTitle: String,
  },
  components: {
    InertiaLink,
  },
  methods: {
    toggleDropdown() {
      this.isDropdownVisible = !this.isDropdownVisible;
    },
    closeDropdown(event) {
      if (
        this.$refs.dropdown &&
        !this.$refs.dropdown.contains(event.target) &&
        !this.$refs.userToggleBtn.contains(event.target)
      ) {
        this.isDropdownVisible = false;
      }
    },
    logoutConfirm() {
      document.getElementById("logoutConfirmModal").classList.toggle("hidden");
    },
    uc_first(text) {
      return text[0];
    },
  },
  mounted() {
    document.addEventListener("click", this.closeDropdown);
  },
  beforeDestroy() {
    document.removeEventListener("click", this.closeDropdown);
  },
};
</script>

<template>
  <div class="topbar" ref="topbar">
    <div class="page-title">
      <span class="app-name">MDC HR Sys v1.0</span>
      <i class="fas fa-chevron-right"></i>
      <span class="text">{{ pageTitle }}</span>
    </div>
    <div
      class="userToggleBtn"
      @click="toggleDropdown"
      title="Dropdown settings"
      ref="userToggleBtn"
    >
      <div class="userIconBtn">
        <div class="user-img">
          <img
            class="user-img"
            :src="
              user.img ? 'storage/users/images/' + user.img : '../assets/images/user.png'
            "
            alt="User Image"
          />
          <i class="fas fa-cog fa-xs"></i>
        </div>
      </div>
    </div>
    <div
      id="dropdown"
      class="dropdown"
      :class="{ show: isDropdownVisible }"
      ref="dropdown"
    >
      <InertiaLink :href="'/account'" class="link" title="Account Settings">
        <span
          ><i class="fas fa-user-cog"></i>

          {{ user.first_name }} {{ user.last_name }}
        </span>
      </InertiaLink>

      <span @click="logoutConfirm" class="logout" title="Logout"
        ><i class="fas fa-sign-out"></i> Logout</span
      >
    </div>
  </div>

  <div id="logoutConfirmModal" class="modal hidden">
    <section class="modal-content">
      <h2>Are you sure to logout?</h2>
      <footer>
        <button @click="logoutConfirm">No</button>
        <InertiaLink :href="'/logout'"> Yes </InertiaLink>
      </footer>
    </section>
  </div>
</template>

<style scoped>

@import "./topbar.css";
</style>
