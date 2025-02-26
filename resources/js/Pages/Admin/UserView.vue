<script>
import Layout from "@/Layouts/Layout.vue";
import PersonalDetails from "@/Pages/Admin/PersonalDetails.vue";
import { Inertia } from "@inertiajs/inertia";
import EditRoleModal from "@/Modals/EditRoleModal.vue";
import EditDepartmentModal from "@/Modals/EditDepartmentModal.vue";

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
  },
  data() {
    return {
      activeTab: localStorage.getItem("activeTab") || "overview",
      isEditRole: false,
      isEditDepartment: false,
      selectedFormType: "All",
      selectedYear: "",
      selectedFilter: "",
    };
  },

  components: {
    PersonalDetails,
    EditRoleModal,
    EditDepartmentModal,
  },
  computed: {
    filteredForms() {
      let forms = this.forms;

      if (this.selectedFormType !== "All") {
        forms = forms.filter((form) => form.form_type === this.selectedFormType);
      }

      if (this.selectedYear) {
        forms = forms.filter(
          (form) =>
            new Date(form.date_start).getFullYear() === parseInt(this.selectedYear)
        );
      }

      if (this.selectedFilter) {
        const now = new Date();
        forms = forms.filter((form) => {
          const formDate = new Date(form.date_start);
          if (this.selectedFilter === "Annually") {
            return formDate.getFullYear() === now.getFullYear();
          } else if (this.selectedFilter === "Monthly") {
            return (
              formDate.getFullYear() === now.getFullYear() &&
              formDate.getMonth() === now.getMonth()
            );
          } else if (this.selectedFilter === "Weekly") {
            const oneWeekAgo = new Date();
            oneWeekAgo.setDate(now.getDate() - 7);
            return formDate >= oneWeekAgo && formDate <= now;
          }
          return true;
        });
      }

      return forms;
    },
    availableYears() {
      const years = new Set(
        this.forms.map((form) => new Date(form.date_start).getFullYear())
      );
      return Array.from(years).sort((a, b) => b - a);
    },
  },
  methods: {
    openEval() {
      Inertia.visit(`/users/user-list/${this.personalDetails.id}/evaluation-form`);
    },
    setActiveTab(tab) {
      this.activeTab = tab;
      localStorage.setItem("activeTab", tab);
    },
    toggleEditRole() {
      this.isEditRole = !this.isEditRole;
    },
    toggleEditDepartment() {
      this.isEditDepartment = !this.isEditDepartment;
    },
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
      :class="{ active: activeTab === 'overview' }"
      @click="setActiveTab('overview')"
      title="User Overview"
    >
      <i class="fa-solid fa-circle-info fa-lg"></i>
    </span>
    <span
      :class="{ active: activeTab === 'personalDetails' }"
      @click="setActiveTab('personalDetails')"
      title="Personal Details"
    >
      <i class="fa-solid fa-list fa-lg"></i>
    </span>
  </nav>
  <div class="container">
    <div class="content" v-if="activeTab === 'overview'">
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
            <option v-for="year in availableYears" :key="year" :value="year">
              {{ year }}
            </option>
          </select>
          <select v-model="selectedFilter" title="Filter the table">
            <option value="" disabled>Filter By:</option>
            <option value="Annually">Annually</option>
            <option value="Monthly">Monthly</option>
            <option value="Weekly">Weekly</option>
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
            @click="openEval()"
          >
            Evaluate
          </button>
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
            <tr v-for="form in filteredForms" :key="form.id">
              <td>
                <span>{{ form.form_type }}</span>
              </td>
              <td>
                <span>{{ form.date_start }}</span>
              </td>
              <td>
                <span>{{ form.date_end }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="activeTab === 'personalDetails'" class="content">
      <PersonalDetails :personalDetails="personalDetails" />
    </div>
  </div>
</template>
<style scoped>
@import "./css/user-view.css";
</style>
