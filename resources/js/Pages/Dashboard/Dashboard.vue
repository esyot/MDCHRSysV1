<script>
import { router } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";

export default {
  name: "Dashboard",
  layout: Layout,
  props: {
    teacherCount: Number,
    staffCount: Number,
    leaveRequestCount: Number,
    travelRequestCount: Number,
    userOnLeave: Number,
    userOnTravel: Number,
    roles: Array,
  },

  methods: {
    toFormsChecking(action) {
      router.get(`/forms/checking/${action}`);
    },
  },
};
</script>

<template>
  <div class="container-body">
    <div class="content-container">
      <section class="cards">
        <div class="card">
          <i class="fas fa-users fa-2x"></i>
          <span>Teachers</span>
          <span>{{ teacherCount }}</span>
        </div>

        <div class="card">
          <i class="fas fa-users-cog fa-2x"></i>
          <span>Staffs</span>
          <span>{{ staffCount }}</span>
        </div>

        <div class="card">
          <i class="fas fa-hiking fa-2x"></i>
          <span>Users on Leave</span>
          <span>{{ userOnLeave }}</span>
        </div>

        <div class="card">
          <i class="fas fa-plane-departure fa-2x"></i>
          <span>Users on Travel</span>
          <span>{{ userOnTravel }}</span>
        </div>

        <div
          @click="toFormsChecking('leave')"
          class="card"
          v-if="
            roles.includes('hr') || roles.includes('admin') || roles.includes('p-admin')
          "
        >
          <i class="fas fa-hourglass-half fa-2x"></i>
          <span>Leave Requests</span>
          <span>{{ leaveRequestCount }}</span>
        </div>

        <div @click="toFormsChecking('travel')" class="card">
          <i class="fas fa-hourglass-half fa-2x"></i>
          <span>Travel Requests</span>
          <span>{{ travelRequestCount }}</span>
        </div>
      </section>
    </div>
    <div class="back-img">
      <img src="/public/assets/images/mdc-logo.png" alt="" />
    </div>
  </div>
</template>

<style scoped>
@import "./css/dashboard.css";
</style>
