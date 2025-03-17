<script src="./js/user-list.js"></script>

<template>
  <AddUserModal
    v-if="isAddUser"
    :type="type"
    :departments="departments"
    :roleList="roleList"
    :specializationList="specializationList"
    :positionList="positionList"
    @toggleAddUserModal="toggleAddUserModal"
  ></AddUserModal>

  <div class="container">
    <div class="forms-selection">
      <div class="search-bar">
        <i class="fa-solid fa-search"></i>

        <input
          type="text"
          name="search_value"
          v-model="search_bar"
          @input="searchUser(search_bar)"
          placeholder="Search a user"
        />
      </div>
      <div>
        <select name="" id="" class="select-type" v-model="user_type">
          <option value="user">All</option>
          <option value="teacher">Teachers</option>
          <option value="staff">Staff</option>
        </select>
      </div>
      <div v-if="user_type === 'staff'">
        <button @click="toggleAddUserModal()" class="add-btn" title="Add staff">
          Add {{ user_type }}
        </button>
      </div>
      <div v-if="user_type === 'teacher' || user_type === 'staff'">
        <button
          @click="toggleSyncUsers(user_type)"
          class="add-btn"
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
            <td class="td-title">
              <i class="fa-solid fa-user"></i>
              <span>{{ type.charAt(0).toUpperCase() + type.slice(1) }}'s Name</span>
            </td>
            <td class="td-action">Action</td>
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
        <tbody v-if="users.data.length === 0">
          <tr>
            <td>No users found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="footer">
      <InertiaLink :href="users.first_page_url">
        <i class="fa-solid fa-angles-left"></i>
      </InertiaLink>
      <InertiaLink :href="users.prev_page_url">
        <i class="fas fa-chevron-left"></i>
      </InertiaLink>

      <span>Page {{ users.current_page }} of {{ users.last_page }}</span>
      <InertiaLink :href="users.next_page_url">
        <i class="fas fa-chevron-right"></i>
      </InertiaLink>

      <InertiaLink :href="users.last_page_url">
        <i class="fa-solid fa-angles-right"></i>
      </InertiaLink>
    </div>
  </div>
</template>

<style scoped>
@import "./css/user-list.css";
</style>
