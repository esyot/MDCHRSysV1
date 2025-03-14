<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

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
    is_evaluation: Boolean,
    terms: Object,
  },
  data() {
    return {
      AdminActiveTab: "overview",
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
      selectedTerm: "",
    };
  },

  components: {},
  computed: {
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
            <div class="user-role" v-if="userDepartments">
              <i class="fas fa-globe"></i>
              <div>
                <span class="role-desc" v-for="dept in userDepartments" :key="dept.id">
                  {{ dept.name }}
                </span>
              </div>
            </div>
            <div class="user-role" v-if="userRoles">
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
            <option value="All">All</option>
            <option value="teacher">Teacher Evaluation</option>
            <option value="staff">Staff Evaluation</option>
          </select>

          <select
            v-model="selectedTerm"
            title="Select a year to be filtered in the table below."
          >
            <option value="" disabled>Select Term</option>
            <option v-for="term in terms" :key="term.id" :value="term.id">
              {{ term.name }}
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
            v-if="roles.includes('dean') || roles.includes('hr')"
            :title="`Add evaluation for  ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEvaluationDropDown"
            ref="toggleEvaluationDropDown"
          >
            Add Another Evaluation
          </button>

          <div
            ref="evaluationDropDown"
            class="evalution-dropdown"
            v-if="isOpenEvalationDropDown"
          >
            <span v-if="roles.includes('dean')" @click="openEval('teacher')"
              >Teacher Evaluation</span
            >
            <span v-if="roles.includes('hr')" @click="openEval('staff')"
              >Staff Evaluation</span
            >
          </div>
        </div>
      </div>
      <div class="tables">
        <table>
          <thead>
            <tr>
              <td class="td-title">
                <span>Evaluation Type</span>
              </td>
              <td class="td-title">
                <span>Subject</span>
              </td>
              <td class="td-title">
                <span>Rating</span>
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
        <table>
          <thead>
            <tr>
              <td class="td-title">
                <span>Evaluation Type</span>
              </td>
              <td class="td-title">
                <span>Subject</span>
              </td>
              <td class="td-title">
                <span>Rating</span>
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
