<script src="./js/user-view.js"></script>

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
    :userDepartment="userDepartment"
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
            <div class="user-department" v-if="userDepartment">
              <i class="fas fa-building"></i>
              <div>
                <span class="role-desc">
                  {{ userDepartment.name }}
                </span>
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
            v-if="roles.includes('admin')"
            :title="`Edit role of  ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEditRole"
          >
            Edit Role
          </button>
          <button
            v-if="userRoles.includes('teacher') && roles.includes('admin')"
            :title="`Edit department of  ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEditDepartment"
          >
            Edit Department
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
  </div>
</template>
<style scoped>
@import "./css/user-view.css";
</style>
