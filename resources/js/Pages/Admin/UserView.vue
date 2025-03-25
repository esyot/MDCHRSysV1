<script src="./js/user-view.js"></script>

<template>
  <EditStaffModal
    v-if="isEditStaff"
    :staff="staff"
    :positionList="positionList"
    @toggleEditStaff="toggleEditStaff"
  >
  </EditStaffModal>

  <EditTeacherModal
    v-if="isEditTeacher"
    :departmentList="departmentList"
    :specializationList="specializationList"
    :teacher="teacher"
    @toggleEditTeacher="toggleEditTeacher"
  >
  </EditTeacherModal>

  <EditUserModal
    v-if="isEditUser"
    :roleList="roleList"
    :userRoles="userRoles"
    :personalDetails="personalDetails"
    :userId="userId"
    @toggleEditUser="toggleEditUser"
  >
  </EditUserModal>

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
              >{{ personalDetails.first_name }} {{ personalDetails.last_name }}

              ({{ personalDetails.user }})</span
            >
            <div class="user-department" v-if="teacher">
              <i class="fas fa-building"></i>
              <div>
                <span class="role-desc" v-if="teacher.department">
                  {{ teacher.department.name }}
                </span>
              </div>
            </div>
            <div class="user-role">
              <i class="fas fa-user-cog"></i>
              <div>
                <span class="role-desc">{{ userRoles.join(", ") }}</span>
              </div>
            </div>

            <div class="user-position" v-if="staff">
              <i class="fa-solid fa-briefcase"></i>
              <div>
                <span class="role-desc">
                  {{ staff.position }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="buttons">
        <div class="btn-left">
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
            <option :value="ill" v-for="(ill, index) in illness" :key="ill">
              {{ ill }}
            </option>
          </select>

          <select v-model="filter_by">
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

          <select v-model="month" v-if="filter_by === 'Month' || filter_by === 'Week'">
            <option disabled selected value="">Select Month</option>
            <option v-for="month in months" :key="month" :value="month">
              {{ month }}
            </option>
          </select>

          <select v-model="week" v-if="filter_by === 'Week'">
            <option value="" disabled selected>Select Week</option>
            <option value="">All Weeks</option>
            <option value="1">1st Week</option>
            <option value="2">2nd Week</option>
            <option value="3">3rd Week</option>
            <option value="4">4th Week</option>
            <option value="5">5th Week</option>
          </select>
        </div>
        <div class="btn-right">
          <button
            :title="`Edit Staff details of ${personalDetails.last_name}, ${personalDetails.first_name}`"
            v-if="personalDetails.staff"
            @click="toggleEditStaff"
          >
            Edit Staff
          </button>
          <button
            :title="`Edit Teacher details of ${personalDetails.last_name}, ${personalDetails.first_name}`"
            v-if="personalDetails.teacher"
            @click="toggleEditTeacher"
          >
            Edit Teacher
          </button>
          <button
            v-if="roles.includes('admin')"
            :title="`Edit User details of ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEditUser"
          >
            Edit User
          </button>
        </div>
      </div>

      <div class="forms">
        <table>
          <thead>
            <tr>
              <td class="td-title">
                <i class="fas fa-list"></i>
                <span> Leave Type</span>
              </td>
              <td class="td-title">
                <i class="fas fa-calendar-day"></i>
                <span> Date Start</span>
              </td>
              <td class="td-title">
                <i class="fas fa-calendar-day"></i>
                <span> Date End</span>
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
