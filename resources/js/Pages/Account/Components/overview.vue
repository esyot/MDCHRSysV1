<template>
  <div class="user-overview">
    <div class="overview-item">
      <i class="fas fa-star"></i>
      <div class="card-content">
        <label>Rank</label>
        <div class="items">
          <span v-for="jobDetail in personalDetails.user_job_details" :key="jobDetail">
            {{ jobDetail.rank }}
          </span>
        </div>
      </div>
    </div>
    <div class="overview-item">
      <i class="fas fa-peso-sign"></i>
      <div>
        <p class="title">Total Requested</p>
        <p class="count">15,000.00</p>
      </div>
    </div>
    <div class="overview-item">
      <i class="fas fa-calendar-day"></i>
      <div>
        <p class="title">Days Leave</p>
        <p class="count">20</p>
      </div>
    </div>
    <div class="overview-item">
      <i class="fas fa-plane-departure"></i>
      <div>
        <p class="title">Days Travel</p>
        <p class="count">10</p>
      </div>
    </div>
    <div class="overview-item">
      <i class="fas fa-plane-arrival"></i>
      <div>
        <p class="title">Days Travel Left</p>
        <p class="count">5</p>
      </div>
    </div>
    <div class="overview-item">
      <i class="fas fa-calendar-check"></i>
      <div>
        <p class="title">Days Leave Left</p>
        <p class="count">5</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Overview",
  props: {
    personalDetails: Object,
  },
};
</script>

<style scoped>
.user-overview {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  height: 50vh;
  overflow-y: auto;
  padding-top: 5px;
}
.card-content {
  display: flex;
  flex-direction: column;
}

.card-content label {
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

.overview-item {
  flex-grow: 1;
  flex-basis: 400px;
  display: flex;
  align-items: center;
  justify-content: start;
  text-align: left;
  background-color: #f4f4f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 250px;
  padding-left: 100px;
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
  background-color: #e0e0e0;
  cursor: pointer;
}
</style>
