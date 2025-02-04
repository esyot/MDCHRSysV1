<template>
  <div class="container-body">
    <div class="content-container">
      <section class="cards">
        <div class="card">
          <i class="fas fa-users fa-2x"></i>
          <span>Users:</span>
          <span>2000</span>
        </div>

        <div class="card">
          <i class="fas fa-hiking fa-2x"></i>
          <span>Users on Leave:</span>
          <span>23</span>
        </div>

        <div class="card">
          <i class="fas fa-plane-departure fa-2x"></i>
          <span>Users on Travel:</span>
          <span>2</span>
        </div>

        <div class="card">
          <i class="fas fa-hourglass-half fa-2x"></i>
          <span>Leave Requests:</span>
          <span>5</span>
        </div>

        <div class="card">
          <i class="fas fa-hourglass-half fa-2x"></i>
          <span>Travel Requests:</span>
          <span>7</span>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import Layout from "@/Layouts/Layout.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "BarChartComponent",
  layout: Layout,
});
</script>

<style scoped>
@import "./dashboard.css";
</style>
