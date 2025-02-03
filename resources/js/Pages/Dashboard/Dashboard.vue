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
.container-body {
  height: 100%;
}
.content-container {
  margin: 0.5rem;
}

.content-container .cards {
  display: flex;
  flex: 1;
  flex-wrap: wrap;
  justify-content: space-between;
  overflow-y: auto;
  height: 60vh;
  overflow-x: hidden;
}

.content-container .card {
  display: flex;
  flex-grow: 1;
  flex-basis: 400px;
  min-width: 300px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 0.5rem;
  border-radius: 0.5rem;
  background-color: #59abe3;
  color: #fff;
  cursor: pointer;
}

.content-container .card:hover {
  scale: 90%;
  transition-duration: 600ms;
  transition-property: all;
  background-color: rgba(0, 0, 0, 0.5);
}

.content-container .card span {
  font-size: 24px;
}

.charts {
  display: flex;
  flex: 1;
  flex-wrap: wrap;
  justify-content: space-between;
  height: auto;
  gap: 1rem;
  margin: 0.5rem;
}

.chart {
  display: flex;
  flex-grow: 1;
  flex-basis: 100px;
  background-color: #fff;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  height: auto;
  min-width: 150px;
  border-radius: 5px;
}
</style>
