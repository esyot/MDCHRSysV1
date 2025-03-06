<script>
import Layout from "@/Layouts/Layout.vue";
import PersonalDetails from "@/Pages/Admin/PersonalDetails.vue";
import { Inertia } from "@inertiajs/inertia";
import EditRoleModal from "@/Modals/EditRoleModal.vue";
import EditDepartmentModal from "@/Modals/EditDepartmentModal.vue";
import Evaluations from "./Evaluations.vue";

export default {
  layout: Layout,
  props: {
    user_id: String,
    userRoles: Array,
    personalDetails: Object,
    userDepartments: Array,
    forms: Object,
    roles: {
      type: Array,
      default: () => [],
    },
    roleList: Array,
    departmentList: Array,
    evaluations: Object,
  },
  data() {
    return {
      AdminActiveTab: localStorage.getItem("AdminActiveTab") || "overview",
      isEditRole: false,
      isEditDepartment: false,
      selectedFormType: "All",
      selectedFilter: "",
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
      isOpenEvalationDropDown: false,
    };
  },

  components: {
    PersonalDetails,
    EditRoleModal,
    EditDepartmentModal,
    Evaluations,
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
    openEval(type) {
      if (type === "teacher") {
        Inertia.visit(`/forms/evaluation-form/${this.personalDetails.id}/teacher`);
      } else if (type === "staff") {
        Inertia.visit(`/forms/evaluation-form/${this.personalDetails.id}/staff`);
      }
    },
    setAdminActiveTab(tab) {
      this.AdminActiveTab = tab;
      localStorage.setItem("AdminActiveTab", tab);
    },
    toggleEditRole() {
      this.isEditRole = !this.isEditRole;
    },
    toggleEditDepartment() {
      this.isEditDepartment = !this.isEditDepartment;
    },
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
    toggleEvaluationDropDown() {
      this.isOpenEvalationDropDown = !this.isOpenEvalationDropDown;
    },
    closeEvaluationDropDown(event) {
      if (
        this.$refs.evaluationDropDown &&
        !this.$refs.toggleEvaluationDropDown.contains(event.target) &&
        !this.$refs.toggleEvaluationDropDown.contains(event.target)
      ) {
        this.isOpenEvalationDropDown = false;
      }
    },
  },
  mounted() {
    document.addEventListener("click", this.closeEvaluationDropDown);
  },
  beforeDestroy() {
    document.removeEventListener("click", this.closeEvaluationDropDown);
  },
};
</script>

<template>
  <EditRoleModal
    v-if="isEditRole"
    :roleList="roleList"
    :userRoles="userRoles"
    :user_id="user_id"
    @toggleEditRole="toggleEditRole"
  ></EditRoleModal>

  <EditDepartmentModal
    v-if="isEditDepartment"
    :userDepartments="userDepartments"
    :departmentList="departmentList"
    :user_id="user_id"
    @toggleEditDepartment="toggleEditDepartment"
  ></EditDepartmentModal>
  <nav>
    <span
      :class="{ active: AdminActiveTab === 'overview' }"
      @click="setAdminActiveTab('overview')"
      title="User Overview"
    >
      <i class="fa-solid fa-circle-info fa-lg"></i>
    </span>
    <span
      :class="{ active: AdminActiveTab === 'personalDetails' }"
      @click="setAdminActiveTab('personalDetails')"
      title="Personal Details"
    >
      <i class="fa-solid fa-list fa-lg"></i>
    </span>
    <span
      :class="{ active: AdminActiveTab === 'evaluations' }"
      @click="setAdminActiveTab('evaluations')"
      title="Evaluations"
    >
      <i class="fas fa-file"></i>
    </span>
  </nav>
  <div class="container">
    <div class="content" v-if="AdminActiveTab === 'overview'">
      <div class="user">
        <div class="user-content">
          <div>
            <img
              :src="
                personalDetails.img
                  ? `/storage/users/images/${personalDetails.img}`
                  : '/assets/images/user.png'
              "
              alt="User Image"
              class="user-img"
            />
          </div>
          <div class="user-details">
            <span class="name"
              >{{ personalDetails.first_name }} {{ personalDetails.last_name }}</span
            >
            <div class="user-role">
              <i class="fas fa-globe"></i>
              <div>
                <span class="role-desc">{{ userDepartments.join(", ") }}</span>
              </div>
            </div>
            <div class="user-role">
              <i class="fas fa-user-cog"></i>
              <div>
                <span class="role-desc">{{ userRoles.join(", ") }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="buttons">
        <div class="btn-left">
          <select
            v-model="selectedFormType"
            title="Select type of forms to be displayed in the table below."
          >
            <option value="All">All Forms</option>
            <option value="Travel Form">Travel Forms</option>
            <option value="Leave Form">Leave Forms</option>
          </select>
          <select
            v-model="selectedYear"
            title="Select a year to be filtered in the table below."
          >
            <option value="" disabled>Select Year</option>
            <option v-for="year in years" :key="year" :value="year">
              {{ year }}
            </option>
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
            <option v-for="month in months" :key="month" :value="month">
              {{ month }}
            </option>
          </select>

          <select name="" id="" v-model="week" v-if="date_report == 'Weekly'">
            <option value="" disabled selected>Select Week</option>
            <option value="">All Weeks</option>
            <option value="1">1st Week</option>
            <option value="2">2nd Week</option>
            <option value="3">3rd Week</option>
            <option value="4">4th Week</option>
          </select>
        </div>
        <div class="btn-right">
          <button
            :title="`Edit role of  ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEditRole"
          >
            Edit Role
          </button>
          <button
            :title="`Edit department of  ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEditDepartment"
          >
            Edit Department
          </button>

          <button
            :title="`Add evaluation for  ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEvaluationDropDown"
            ref="toggleEvaluationDropDown"
          >
            Evaluate
          </button>

          <div
            ref="evaluationDropDown"
            class="evalution-dropdown"
            v-if="isOpenEvalationDropDown"
          >
            <span @click="openEval('teacher')">Teacher Evaluation</span>
            <span @click="openEval('staff')">Staff Evaluation</span>
          </div>
        </div>
      </div>
      <div class="forms">
        <table>
          <thead>
            <tr>
              <td class="td-title">
                <span>Leave Type</span>
              </td>
              <td class="td-title">
                <span>Date start of Leave</span>
              </td>
              <td class="td-title">
                <span>Date end of Leave</span>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="form in filteredForms" :key="form.form_type">
              <td>
                <span>{{ form.form_type }}</span>
              </td>
              <td>
                <span>{{ formatDate(form.date_start) }}</span>
              </td>
              <td>
                <span>{{ formatDate(form.date_end) }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="AdminActiveTab === 'personalDetails'" class="content">
      <PersonalDetails :personalDetails="personalDetails" />
    </div>

    <div v-if="AdminActiveTab === 'evaluations'" class="content">
      <Evaluations :evaluations="evaluations" />
    </div>
  </div>
</template>
<style scoped>
@import "./css/user-view.css";
</style>
