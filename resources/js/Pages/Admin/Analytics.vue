<script>
import Layout from "@/Layouts/Layout.vue";
export default {
  layout: Layout,
  props: {
    forms: Object,
    user: Object,
  },
  data() {
    return {
      form_selection: "",
      currentYear: new Date().getFullYear(),
      selectedYear: new Date().getFullYear(),
      months: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      month: "",
      date_report: "",
      week: "",
      search_value: "",
    };
  },
  computed: {
    filteredForms() {
      let filtered = this.forms;

      if (this.form_selection) {
        filtered = filtered.filter((item) => {
          if (this.form_selection === "travel") {
            return item.form_type === "Travel Form";
          } else if (this.form_selection === "leave") {
            return item.form_type === "Leave Form";
          } else {
            return true;
          }
        });
      }

      if (this.selectedYear) {
        filtered = filtered.filter((item) => {
          const startYear = new Date(item.date_start).getFullYear();
          const endYear = new Date(item.date_end).getFullYear();
          return (
            startYear === parseInt(this.selectedYear) ||
            endYear === parseInt(this.selectedYear)
          );
        });
      }

      if (this.date_report && this.month) {
        const monthIndex = this.months.indexOf(this.month);
        filtered = filtered.filter((item) => {
          const startMonth = new Date(item.date_start).getMonth();
          const endMonth = new Date(item.date_end).getMonth();
          return startMonth === monthIndex || endMonth === monthIndex;
        });

        if (this.date_report === "Weekly" && this.week) {
          filtered = filtered.filter((item) => {
            const startDate = new Date(item.date_start);
            const endDate = new Date(item.date_end);
            const startWeek = this.getWeekOfMonth(startDate);
            const endWeek = this.getWeekOfMonth(endDate);

            const startMonth = startDate.getMonth();
            const endMonth = endDate.getMonth();

            return (
              (startWeek === parseInt(this.week) && startMonth === monthIndex) ||
              (endWeek === parseInt(this.week) && endMonth === monthIndex)
            );
          });
        }
      }

      if (this.search_value) {
        filtered = filtered.filter(
          (item) =>
            item.user.first_name
              .toLowerCase()
              .includes(this.search_value.toLowerCase()) ||
            item.user.last_name.toLowerCase().includes(this.search_value.toLowerCase()) ||
            item.user.middle_name.toLowerCase().includes(this.search_value.toLowerCase())
        );
      }

      return filtered;
    },

    years() {
      const startYear = 2025;
      const endYear = this.currentYear + 30;
      const years = [];
      for (let year = startYear; year <= endYear; year++) {
        years.push(year);
      }
      return years;
    },
  },
  methods: {
    getWeekNumber(date) {
      const tempDate = new Date(date.getTime());
      tempDate.setMonth(0, 1);
      tempDate.setHours(0, 0, 0, 0);

      const startOfYear = tempDate;
      const diff = date - startOfYear;

      const millisecondsInWeek = 1000 * 60 * 60 * 24 * 7;

      return Math.floor(diff / millisecondsInWeek) + 1;
    },
    formatDate(date) {
      const convertedDate = new Date(date);
      const options = {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: true,
      };
      return convertedDate.toLocaleString("en-US", options);
    },
    getWeekOfMonth(date) {
      const tempDate = new Date(date.getTime());
      tempDate.setDate(1);
      const startOfMonth = tempDate.getDay();
      const diff = date.getDate() + startOfMonth - 1;
      return Math.ceil(diff / 7);
    },
    clearSearchBar() {
      this.search_value = null;
    },
  },
};
</script>

<template>
  <header class="header">
    <div class="header-item">
      <div class="search-bar">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" placeholder="Search a user" v-model="search_value" />
        <span
          v-if="search_value"
          @click="clearSearchBar"
          class="fa-solid fa-circle-xmark clear-icon"
        ></span>
      </div>
      <select name="" id="" v-model="selectedYear">
        <option disabled selected value="">Select Year</option>
        <option value="">All</option>
        <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
      </select>
      <select name="" id="" v-model="form_selection">
        <option value="" disabled selected>Select Type of form</option>
        <option value="all">All Forms</option>
        <option value="leave">Leave Forms</option>
        <option value="travel">Travel Forms</option>
      </select>

      <select name="" id="" v-model="date_report">
        <option value="" disabled selected>Select Filter</option>

        <option value="">Annually</option>
        <option value="Monthly">Monthly</option>
        <option value="Weekly">Weekly</option>
      </select>

      <select
        name=""
        id=""
        v-model="month"
        v-if="date_report == 'Monthly' || date_report == 'Weekly'"
      >
        <option disabled selected value="">Select Month</option>
        <option v-for="month in months" :key="month" :value="month">{{ month }}</option>
      </select>

      <select name="" id="" v-model="week" v-if="date_report == 'Weekly'">
        <option value="" disabled selected>Select Week</option>
        <option value="">All Weeks</option>
        <option value="1">1st Week</option>
        <option value="2">2nd Week</option>
        <option value="3">3rd Week</option>
        <option value="4">4th Week</option>
        <option value="5">5th Week</option>
      </select>
    </div>

    <div class="header-item">
      <button>
        <i class="fas fa-ellipsis-v"></i>
      </button>
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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="form in filteredForms"
          :key="form.form_type"
          @click="toggleFormModal(form.id, form.form_type, form)"
        >
          <td>
            {{ form.user.last_name }}, {{ form.user.first_name }}
            {{ form.user.middle_name[0] }}.
          </td>
          <td>{{ form.form_type }}</td>

          <td>{{ formatDate(form.date_start) }}</td>
          <td>{{ formatDate(form.date_end) }}</td>
          <td class="td-action">
            <button
              @click="toggleFormModal(form.id, form.form_type, form)"
              class="edit-btn"
            >
              <i class="fas fa-eye"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  background-color: #fff;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
}

.header .search-bar input {
  background-color: transparent;
  border: none;
  outline: none;
}

.header .search-bar i {
  color: #6a6a6a;
}
.header .search-bar {
  background-color: #fff;
  display: flex;
  align-items: center;
  gap: 0.2rem;
  padding: 10px;
  border-radius: 20px;
  box-shadow: inset 2px 2px 2px 2px rgba(0, 0, 0, 0.2);
  border: 1px solid #838383;
}

.header-item {
  display: flex;
  gap: 0.3rem;
}
.header-item select {
  box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
  border: 1px solid #888888;
  color: #000000;
  padding-inline: 5px;
  border-radius: 5px;
}

.header-item button {
  background-color: transparent;
  border: none;
  opacity: 50%;
}

.header-item button:hover {
  opacity: 100%;
  cursor: pointer;
}
.header-item button i {
  font-size: 20px;
}

.table-container {
  height: 80vh;
  overflow-y: auto;
}

.table-container table thead {
  position: sticky;
  top: 0;
}

table {
  width: 100%;
  background-color: #fff;
  border-collapse: collapse;
}

table thead {
  background-color: rgb(30, 125, 203);
  color: #fff;
}

table thead th {
  padding: 10px;
}

table tbody tr td {
  padding: 10px;
  text-align: center;
}

.clear-icon {
  color: red;
  opacity: 50%;
}

.clear-icon:hover {
  opacity: 100%;
  cursor: pointer;
}
</style>
