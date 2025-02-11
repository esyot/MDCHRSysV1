<template>
  <div class="container-body">
    <div class="content-container">
      <section class="cards">
        <div class="card">
          <i class="fas fa-users fa-2x"></i>
          <span>Users</span>
          <span>{{ userCount }}</span>
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

        <div @click="toFormsChecking('leave')" class="card">
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

<script>
import { Inertia } from "@inertiajs/inertia";
import Layout from "@/Layouts/Layout.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "BarChartComponent",
  layout: Layout,
  props: {
    userCount: Number,
    leaveRequestCount: Number,
    travelRequestCount: Number,
    userOnLeave: Number,
    userOnTravel: Number,
  },

  methods: {
    toFormsChecking(action) {
      Inertia.get(`/forms/checking/${action}`);
    },
  },
});
</script>

<style scoped>
@import "./dashboard.css";
</style>
