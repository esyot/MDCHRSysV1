<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import AddUserModal from "@/Modals/AddUserModal.vue";

export default {
  layout: Layout,
  components: {
    AddUserModal,
  },
  props: {
    users: Object,
    roles: Array,
    departments: Array,
    roleList: Array,
  },
  data() {
    return {
      search_value: "",
      isAddUser: false,
    };
  },
  computed: {
    filteredUsers() {
      if (!this.search_value) return this.users;

      const searchLower = this.search_value.toLowerCase();

      return this.users.filter(
        (user) =>
          user.last_name.toLowerCase().includes(searchLower) ||
          user.first_name.toLowerCase().includes(searchLower) ||
          (user.middle_name?.toLowerCase().includes(searchLower) ?? false)
      );
    },
  },
  methods: {
    handleClick(user) {
      Inertia.visit(`/user-list/${user.id}`);
    },

    toggleAddUserModal() {
      this.isAddUser = !this.isAddUser;
    },
  },
};
</script>

<template>
  <AddUserModal
    v-if="isAddUser"
    :departments="departments"
    :roleList="roleList"
    @toggleAddUserModal="toggleAddUserModal"
  ></AddUserModal>

  <div class="container">
    <div class="forms-selection">
      <div class="search-bar">
        <i class="fa-solid fa-search"></i>
        <input
          type="text"
          name="search_value"
          v-model="search_value"
          placeholder="Search a user..."
        />
      </div>

      <button @click="toggleAddUserModal" class="add-btn">Add User</button>
    </div>

    <div class="content">
      <table>
        <thead>
          <tr>
            <td class="td-title">
              <i class="fa-solid fa-user"></i>
              <span>User Name</span>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id" @click="handleClick(user)">
            <td>
              {{ user.last_name }}, {{ user.first_name }}
              <span v-if="user.middle_name">{{ user.middle_name[0] }}.</span>
            </td>
          </tr>
        </tbody>
        <tbody v-if="filteredUsers.length === 0">
          <tr>
            <td>No users found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
@import "./css/user-list.css";
</style>
