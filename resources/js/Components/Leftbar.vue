<script>
import { usePage } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  setup() {
    const { url } = usePage();

    return {
      currentRoute: url,
    };
  },
  props: {
    roles: Object,
    user: Object,
  },
  components: {
    Link,
  },
  methods: {
    openSubMenu(menuName) {
      const submenuId = `submenu-${menuName.toLowerCase().replace(" ", "-")}`;
      const submenu = document.getElementById(submenuId);
      if (submenu) {
        submenu.style.display = submenu.style.display === "block" ? "none" : "block";
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
          <!-- Dashboard Link -->
          <Link :href="'/dashboard'" :class="{ active: currentRoute === '/dashboard' }">
            <li title="Home" class="menu-li">
              <i class="fas fa-gauge"></i>
              <span>Dashboard</span>
            </li>
          </Link>

          <li title="Services">
            <div class="menu-li" @click="openSubMenu('Services')">
              <i class="fa-solid fa-screwdriver-wrench"></i>
              <span>Services</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <ul id="submenu-services" class="submenu">
              <Link :href="'/forms/travel-form-request'">
                <li :class="{ active: currentRoute === '/forms/travel-form-request' }">
                  <span>Travel Form</span>
                </li>
              </Link>

              <Link :href="'/forms/leave-form-request'" class="link">
                <li :class="{ active: currentRoute === '/forms/leave-form-request' }">
                  <span>Leave Form</span>
                </li>
              </Link>

              <Link :href="'/forms/tracking'" class="link">
                <li :class="{ active: currentRoute === '/forms/tracking' }">
                  <span>Track Forms</span>
                </li>
              </Link>
            </ul>
          </li>

          <Link
            v-if="!roles.includes('staff')"
            :href="'/forms/checking'"
            :class="{ active: currentRoute === '/forms/checking' }"
          >
            <li class="menu-li" title="Check Forms">
              <i class="fas fa-desktop"></i>
              <span>Check Forms</span>
            </li>
          </Link>

          <li title="Evaluation" v-if="roles.includes('dean') || roles.includes('hr')">
            <div class="menu-li" @click="openSubMenu('Evaluation')">
              <i class="fa-solid fa-file"></i>
              <span>Evaluation</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <ul id="submenu-evaluation" class="submenu">
              <Link :href="'/evaluations/teacher'">
                <li :class="{ active: currentRoute === '/evaluations/teacher' }">
                  <span>Teacher Evaluation</span>
                </li>
              </Link>
              <Link v-if="roles.includes('hr')" :href="'/evaluations/staff'" class="link">
                <li :class="{ active: currentRoute === '/evaluations/staff' }">
                  <span>Staff Evaluation</span>
                </li>
              </Link>
            </ul>
          </li>

          <li title="Users" v-if="roles.includes('admin') || roles.includes('hr')">
            <div class="menu-li" @click="openSubMenu('Admin Panel')">
              <i class="fa-solid fa-users"></i>
              <span>Administrator</span>
              <i class="fas fa-chevron-down"></i>
            </div>

            <ul id="submenu-admin-panel" class="submenu">
              <Link :href="'/users/users-list'">
                <li :class="{ active: currentRoute === '/users/users-list' }">
                  <span>Users</span>
                </li>
              </Link>

              <Link v-if="roles.includes('admin')" :href="'/departments'">
                <li
                  :class="{ active: currentRoute === '/departments' }"
                  title="Add/Edit Departments"
                >
                  <span>Departments</span>
                </li>
              </Link>

              <Link :href="'/evaluations/evaluation-manager'">
                <li
                  :class="{ active: currentRoute === '/evaluations/evaluation-manager' }"
                >
                  <span>Evaluation Manager</span>
                </li>
              </Link>

              <Link :href="'/users/analytics'">
                <li :class="{ active: currentRoute === '/users/analytics' }">
                  <span>Analytics</span>
                </li>
              </Link>
            </ul>
          </li>

          <!-- About Link -->
          <Link :href="'/about'" :class="{ active: currentRoute === '/about' }">
            <li class="menu-li" title="View About">
              <i class="fa-solid fa-info-circle"></i>
              <span>About</span>
            </li>
          </Link>
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
