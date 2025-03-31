<template>
  <footer class="sticky-footer">
    <div class="nav-btns">
      <Link :href="'/dashboard'" class="link">
        <i class="fas fa-home fa-2x"></i>
      </Link>
      <Link v-if="!roles.includes('staff')" :href="'/forms/checking'" class="link">
        <i class="fas fa-display fa-2x"></i>
      </Link>

      <Link v-if="roles.includes('admin')" :href="'/departments'" class="link">
        <i class="fas fa-list fa-2x"></i>
      </Link>

      <div @click="showPopUp('services')">
        <i class="fa-solid fa-screwdriver-wrench fa-2x"></i>
      </div>
      <div @click="showPopUp('users')">
        <i class="fa-solid fa-users fa-2x"></i>
      </div>
      <Link :href="'/about'" class="link">
        <i class="fas fa-info-circle fa-2x"></i>
      </Link>

      <!-- PopUps -->
      <div class="popup-content" v-if="popupServices">
        <Link :href="'/forms/travel-form-request'" class="link">
          <span>Request Travel Application</span>
        </Link>
        <Link :href="'/forms/leave-form-request'" class="link">
          <span>Request Leave Application</span>
        </Link>

        <Link :href="'/forms/tracking'" class="link">
          <span>Track Submitted Forms</span>
        </Link>
        <div @click="showPopUp('services')" class="close-btn">Close</div>
      </div>

      <div class="popup-content-users" v-if="popupUsers">
        <Link :href="'/users/user-list'" class="link">
          <span>Users</span>
        </Link>
        <Link :href="'/users/analytics'" class="link">
          <span>Analytics</span>
        </Link>

        <div @click="showPopUp('users')" class="close-btn">Close</div>
      </div>
    </div>
  </footer>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  name: "Footer",
  props: {
    roles: Array,
  },

  components: {
    Link,
  },

  data() {
    return {
      popupServices: false,
      popupUsers: false,
    };
  },
  methods: {
    showPopUp(action) {
      if (action === "users") {
        this.popupUsers = !this.popupUsers;
        this.popupServices = false;
      } else if (action === "services") {
        this.popupServices = !this.popupServices;
        this.popupUsers = false;
      }
    },
  },
};
</script>

<style scoped>
@import "./css/footer.css";
</style>
