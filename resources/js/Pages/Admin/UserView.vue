<script>
import Layout from "@/Layouts/Layout.vue";
import PersonalDetails from "@/Pages/Admin/PersonalDetails.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  layout: Layout,
  props: {
    userRoles: Array,
    personalDetails: Object,
    userDepartments: Array,
    roles: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      activeTab: localStorage.getItem("activeTab") || "overview",
    };
  },
  methods: {
    openEval() {
      Inertia.visit(`/user-list/${this.personalDetails.id}/evaluation-form`);
    },
    setActiveTab(tab) {
      this.activeTab = tab;
      localStorage.setItem("activeTab", tab);
    },
  },
  components: {
    PersonalDetails,
  },
};
</script>

<template>
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
                <span v-for="dept in userDepartments" :key="dept.id" class="role-desc">{{
                  dept.name
                }}</span>
              </div>
            </div>
            <div class="user-role">
              <i class="fas fa-user-cog"></i>
              <div>
                <span v-for="role in userRoles" :key="role.id" class="role-desc">{{
                  role
                }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="buttons">
        <div class="btn-left">
          <select name="" id="">
            <option value="" selected disabled>All Forms</option>
            <option value="Travel Forms">Travel Forms</option>
            <option value="Leave Forms">Leave Forms</option>
          </select>
          <select name="" id="">
            <option value="" selected disabled>Filter By:</option>
            <option value="Annually">Annually</option>
            <option value="Monthly">Monthly</option>
            <option value="Weekly">Weekly</option>
          </select>
        </div>
        <div class="btn-right">
          <button>Edit Role</button>
          <button>History</button>
          <button @click="openEval()">Evaluate</button>
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
            <tr>
              <td><span>Personal</span></td>
              <td><span>12/12/2004</span></td>
              <td><span>12/12/2004</span></td>
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
