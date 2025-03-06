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

<script>
export default {
  name: "Overview",
  props: {
    user_job_details: Object,
    overviewData: Object,
  },
};
</script>

<style scoped>
.user-overview {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  height: 100%;
  overflow-y: auto;
  padding-top: 5px;
}

.card-content label {
  margin: 10px;
  font-size: 20px;
  font-weight: bold;
}
.overview-item ul {
  display: flex;
  justify-content: start;
  list-style: none;
}

.overview-item li {
  font-weight: bold;
  font-size: 18px;
}

.overview-item-container {
  flex-grow: 1;
  flex-basis: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f4f4f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.overview-item {
  display: flex;
  justify-content: start;
  align-items: center;
  border-radius: 8px;
  width: 250px;
  padding: 10px;
}

.items {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: left;
}

.overview-item i {
  font-size: 36px;
  color: #2282ff;
  margin-right: 15px;
}

.overview-item .title {
  font-weight: bold;
  font-size: 16px;
  color: #333;
}

.overview-item .count {
  font-size: 20px;
  color: #000;
  margin-top: 5px;
}

.overview-item:hover {
  cursor: pointer;
}
</style>
