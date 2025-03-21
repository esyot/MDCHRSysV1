<script src="./js/analytics.js"></script>
<template>
  <header class="header">
    <div class="header-item">
      <div class="search-bar">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" placeholder="Search" v-model="search_value" />
        <span
          v-if="search_value"
          @click="clearSearchBar"
          class="fa-solid fa-circle-xmark clear-icon"
        ></span>
      </div>

      <select v-model="form_type">
        <option value="" disabled selected>Type</option>
        <option value="all">All</option>
        <option value="leave">Leave</option>
        <option value="travel">Travel</option>
      </select>

      <select v-if="form_type === 'leave'" v-model="leave_type">
        <option value="" disabled selected>Type of Leave</option>
        <option value="all">All</option>
        <option value="personal">Personal</option>
        <option value="sick">Sick</option>
      </select>

      <select
        v-if="form_type === 'leave' && leave_type === 'sick'"
        v-model="illness_type"
      >
        <option value="" disabled selected>Type of Illness</option>
        <option :value="ill" v-for="(ill, index) in illness" :key="ill">{{ ill }}</option>
      </select>

      <select v-model="filter">
        <option value="" disabled selected>Filter By</option>
        <option value="">Year</option>
        <option value="Month">Month</option>
        <option value="Week">Week</option>
      </select>

      <select v-model="selected_year">
        <option disabled selected value="">Select Year</option>
        <option value="">All</option>
        <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
      </select>

      <select v-model="month" v-if="filter === 'Month' || filter === 'Week'">
        <option disabled selected value="">Select Month</option>
        <option v-for="month in months" :key="month" :value="month">{{ month }}</option>
      </select>

      <select v-model="week" v-if="filter === 'Week'">
        <option value="" disabled selected>Select Week</option>
        <option value="">All Weeks</option>
        <option value="1">1st Week</option>
        <option value="2">2nd Week</option>
        <option value="3">3rd Week</option>
        <option value="4">4th Week</option>
        <option value="5">5th Week</option>
      </select>
    </div>
  </header>

  <section class="table-container">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Form type</th>
          <th>Date Start</th>
          <th>Date End</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="form in filteredForms" :key="form.form_type">
          <td>
            {{ form.user.last_name }}, {{ form.user.first_name }}
            {{ form.user.middle_name[0] }}.
          </td>
          <td>{{ form.form_type }}</td>
          <td>{{ formatDate(form.date_start) }}</td>
          <td>{{ formatDate(form.date_end) }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
@import "./css/analytics.css";
</style>
