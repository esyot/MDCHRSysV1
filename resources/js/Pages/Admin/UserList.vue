<script src="./js/user-list.js"></script>

<template>
  <AddUserModal
    v-if="isAddUser"
    :type="type"
    :roleList="roleList"
    :specializationList="specializationList"
    :positionList="positionList"
    @toggleAddUserModal="toggleAddUserModal"
  ></AddUserModal>

  <div class="container">
    <div class="container-items">
      <div class="left">
        <div class="search-bar">
          <input
            type="text"
            name="search_value"
            v-model="search_bar"
            placeholder="Search a user"
          />

          <i
            v-if="search_bar"
            @click="filterUsers()"
            class="fa-solid fa-circle-arrow-right fa-lg"
          ></i>
        </div>
      </div>

      <div class="right">
        <select
          name=""
          id=""
          class="select-type"
          v-model="user_type"
          @change="filterUsers()"
        >
          <option value="user">All Users</option>
          <option value="teacher">Teachers</option>
          <option value="staff">Staff</option>
        </select>

        <select
          name=""
          id=""
          v-if="user_type === 'teacher'"
          v-model="department_id"
          @change="filterUsers()"
        >
          <option value="" selected disabled>Department</option>
          <option value="">All</option>
          <option
            :value="department.id"
            v-for="department in departmentList"
            :key="department.id"
          >
            {{ department.acronym }}
          </option>
        </select>

        <select
          name=""
          id=""
          class="select-type"
          v-model="order_by"
          @change="filterUsers()"
        >
          <option value="" selected disabled>Order By</option>
          <option value="ASC">ASC</option>
          <option value="DESC">DESC</option>
        </select>

        <button
          v-if="user_type === 'staff'"
          @click="toggleAddUserModal()"
          title="Add staff"
        >
          Add {{ user_type }}
        </button>

        <button
          v-if="user_type === 'teacher' || user_type === 'staff'"
          @click="toggleSyncUsers(user_type)"
          title="Sync users from Mater Dei College SIS"
        >
          Sync {{ user_type }}s
        </button>
      </div>
    </div>

    <div class="content">
      <table>
        <thead>
          <tr>
            <th>
              <i class="fa-solid fa-address-card"></i>
              <span> {{ " " + type.charAt(0).toUpperCase() + type.slice(1) }} </span>
            </th>
            <th><i class="fas fa-cog"></i><span> Action</span></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id">
            <td>
              {{ user.last_name }}, {{ user.first_name }}
              <span v-if="user.middle_name">{{ user.middle_name[0] }}.</span>
            </td>
            <td class="td-action">
              <i
                title="Click to visit user"
                @click="visitUser(user)"
                class="fas fa-eye"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="empty-msg" v-if="users.data.length === 0">
        <div>
          <p>No users found.</p>
        </div>
      </div>
    </div>
    <div class="footer">
      <i
        @click="paginationControl(users.first_page_url)"
        class="fa-solid fa-angles-left"
      ></i>

      <i @click="paginationControl(users.prev_page_url)" class="fas fa-chevron-left"></i>

      <span>Page {{ users.current_page }} of {{ users.last_page }}</span>

      <i @click="paginationControl(users.next_page_url)" class="fas fa-chevron-right"></i>

      <i
        @click="paginationControl(users.last_page_url)"
        class="fa-solid fa-angles-right"
      ></i>
    </div>
  </div>
</template>

<style scoped>
@import "./css/user-list.css";
</style>
