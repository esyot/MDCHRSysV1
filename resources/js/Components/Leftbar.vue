<script>
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    Link,
  },

  props: {
    roles: Object,
    user: Object,
    pageTitle: String,
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
  mounted() {
    const menu = this.$el.querySelector(".menu");

    menu.addEventListener("scroll", () => {
      if (menu.scrollTop > 0) {
        menu.classList.add("show-scrollbar");
      } else {
        menu.classList.remove("show-scrollbar");
      }
    });
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
          <Link :href="'/dashboard'" :class="{ active: pageTitle === 'Dashboard' }">
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
              <Link :href="'/forms/travel-form-request'" prefetch cache-for="1m">
                <li
                  :class="{
                    active: pageTitle === 'Travel Form',
                  }"
                >
                  <span>Travel Form</span>
                </li>
              </Link>

              <Link
                :href="'/forms/leave-form-request'"
                class="link"
                prefetch
                cache-for="1m"
              >
                <li :class="{ active: pageTitle === 'Leave Form' }">
                  <span>Leave Form</span>
                </li>
              </Link>

              <Link :href="'/forms/tracking'" class="link">
                <li :class="{ active: pageTitle === 'Track Forms' }">
                  <span>Track Forms</span>
                </li>
              </Link>
            </ul>
          </li>

          <Link
            v-if="
              roles.includes('dean') ||
              roles.includes('hr') ||
              roles.includes('vp-admin') ||
              roles.includes('vp-acad') ||
              roles.includes('p-admin') ||
              roles.includes('admin')
            "
            :href="'/forms/checking'"
            :class="{ active: pageTitle === 'Checking' }"
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
                <li :class="{ active: pageTitle === `Teacher's Evaluation` }">
                  <span>Teacher Evaluation</span>
                </li>
              </Link>
              <Link v-if="roles.includes('hr')" :href="'/evaluations/staff'" class="link">
                <li :class="{ active: pageTitle === `Staff's Evaluation` }">
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
                <li :class="{ active: pageTitle === 'Users' }">
                  <span>Users</span>
                </li>
              </Link>

              <Link v-if="roles.includes('admin')" :href="'/departments'">
                <li
                  :class="{ active: pageTitle === 'Departments' }"
                  title="Add/Edit Departments"
                >
                  <span>Departments</span>
                </li>
              </Link>

              <Link :href="'/evaluations/evaluation-manager'">
                <li :class="{ active: pageTitle === 'Evaluation Manager' }">
                  <span>Evaluation Manager</span>
                </li>
              </Link>

              <Link :href="'/users/analytics'">
                <li :class="{ active: pageTitle === 'Analytics' }">
                  <span>Analytics</span>
                </li>
              </Link>
            </ul>
          </li>

          <!-- About Link -->
          <Link :href="'/about'" :class="{ active: pageTitle === 'About' }">
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
