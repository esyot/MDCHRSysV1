<script src="./js/overview.js"></script>

<template>
  <div class="user-overview">
    <div class="overview-item-container">
      <div class="overview-item">
        <i class="fas fa-star"></i>
        <div class="card-content">
          <label>Current Rank</label>
          <div class="items">
            <span v-for="jobDetail in user_job_details" :key="jobDetail">
              {{ jobDetail.rank }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="overview-item-container">
      <div class="overview-item">
        <i class="fas fa-peso-sign"></i>
        <div class="card-content">
          <label>Amount Requested</label>
          <div class="items">
            <span> {{ overviewData.amount }} </span>
          </div>
        </div>
      </div>
    </div>
    <div class="overview-item-container">
      <div class="overview-item">
        <i class="fas fa-calendar-day"></i>
        <div class="card-content">
          <label>Personal Leave</label>
          <div class="items">
            <span> {{ overviewData.personalLeaves }} </span>
          </div>
        </div>
      </div>
    </div>

    <div class="overview-item-container">
      <div class="overview-item">
        <i class="fas fa-calendar-day"></i>
        <div class="card-content">
          <label>Sick Leave</label>
          <div class="items">
            <span> {{ overviewData.sickLeaves }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="overview-item-container">
      <div class="overview-item">
        <i class="fas fa-plane-departure"></i>
        <div class="card-content">
          <label>Days Traveled </label>
          <div class="items">
            <span> {{ overviewData.traveledDays }} </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/overview.css";
</style>
