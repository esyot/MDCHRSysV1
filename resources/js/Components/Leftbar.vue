<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    roles: Object,
    user: Object,
  },
  components: {
    InertiaLink,
  },
  methods: {
    openSubMenu(menuName) {
      if (menuName === "Services") {
        const submenu = document.getElementById("submenu-services");
        if (submenu.style.display === "block") {
          submenu.style.display = "none";
        } else {
          submenu.style.display = "block";
        }
      } else if (menuName === "Users") {
        const submenu = document.getElementById("submenu-users");
        if (submenu.style.display === "block") {
          submenu.style.display = "none";
        } else {
          submenu.style.display = "block";
        }
      }
    },
  },
};
</script>

<template>
  <div id="sidebar" class="sidebar">
    <div class="sidebar-content">
      <div class="logo">
        <div class="logo-img-container">
          <img src="/public/assets/images/mdc-logo.png" class="logo-img" alt="Logo" />
        </div>
        <text>Welcome!</text>
        <span id="app-name">{{ user.last_name }}, {{ user.first_name }}</span>
      </div>
      <div class="role-container">
        <small>roles: {{ roles.join(", ") }}</small>
      </div>
      <hr />
      <div id="menu" class="menu">
        <ul id="menu-items">
          <InertiaLink :href="'/dashboard'" class="link"
            ><li class="menu-li" title="Home">
              <i class="fas fa-gauge"></i>
              <span>Dashboard</span>
            </li>
          </InertiaLink>
          <li title="Services">
            <div class="menu-li" @click="openSubMenu('Services')">
              <i class="fa-solid fa-screwdriver-wrench"></i>
              <span>Services</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <ul id="submenu-services" class="submenu">
              <InertiaLink :href="'/forms/travel-form-request'" class="link">
                <li>
                  <span>Travel Form</span>
                </li></InertiaLink
              >

              <InertiaLink :href="'/forms/leave-form-request'" class="link">
                <li><span>Leave Form</span></li>
              </InertiaLink>

              <InertiaLink :href="'/forms/tracking'" class="link">
                <li><span>Track Submitted Forms</span></li>
              </InertiaLink>
            </ul>
          </li>
          <InertiaLink
            v-if="!roles.includes('staff')"
            :href="'/forms/checking'"
            class="link"
            ><li class="menu-li" title="Check Forms">
              <i class="fas fa-desktop"></i>
              <span>Check Forms</span>
            </li>
          </InertiaLink>

          <InertiaLink v-if="roles.includes('admin')" :href="'/departments'" class="link"
            ><li class="menu-li" title="Add/Edit Departments">
              <i class="fa-solid fa-list"></i>
              <span>Departments</span>
            </li>
          </InertiaLink>

          <li title="Users" v-if="roles.includes('admin') || roles.includes('hr')">
            <div class="menu-li" @click="openSubMenu('Users')">
              <i class="fa-solid fa-users"></i>
              <span>Users</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <ul id="submenu-users" class="submenu">
              <InertiaLink :href="'/user-list'" class="link">
                <li><span>Search</span></li>
              </InertiaLink>

              <li><span>Tracking</span></li>

              <InertiaLink :href="'/forms/evaluation-form'" class="link">
                <li><span>Evaluation</span></li>
              </InertiaLink>
            </ul>
          </li>
          <li class="menu-li" title="About">
            <i class="fas fa-info-circle"></i><span>About</span>
          </li>
        </ul>
      </div>
      <div class="footer">
        <span id="copy-desc">All rights reserved &copy; 2025</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/leftbar.css";
</style>
