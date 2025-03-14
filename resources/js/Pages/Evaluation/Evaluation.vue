<script>
import Layout from "@/Layouts/Layout.vue";
import { InertiaLink } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  layout: Layout,
  props: {
    users: Object,
    allUsers: Object,
    department: Object,
    terms: Object,
  },
  components: {
    InertiaLink,
  },
  data() {
    return {
      search_value: "",
    };
  },
  methods: {
    visitUser(user) {
      Inertia.visit(`/evaluations/evaluate-user/${user}`);
    },
  },
  computed: {
    filteredUsers() {
      if (!this.search_value) return this.users.data;

      const searchLower = this.search_value.toLowerCase();

      return this.allUsers.filter(
        (user) =>
          user.last_name.toLowerCase().includes(searchLower) ||
          user.first_name.toLowerCase().includes(searchLower) ||
          (user.middle_name?.toLowerCase().includes(searchLower) ?? false)
      );
    },
  },
};
</script>

<template>
  <div class="container">
    <div class="forms-selection">
      <div>
        <span class="department-name" v-if="department"> {{ department.name }} </span>
      </div>

      <div class="search-bar">
        <i class="fa-solid fa-search"></i>

        <input
          type="text"
          name="search_value"
          v-model="search_value"
          placeholder="Search a user..."
        />
      </div>
    </div>

    <div class="content">
      <table>
        <thead>
          <tr>
            <td class="td-title">
              <i class="fa-solid fa-user"></i>
              <span>User's Name</span>
            </td>
            <td class="td-action">Action</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id">
            <td>
              {{ user.last_name }}, {{ user.first_name }}
              <span v-if="user.middle_name">{{ user.middle_name[0] }}.</span>
            </td>
            <td class="td-action">
              <i
                title="Click to visit user"
                @click="visitUser(user.id)"
                class="fas fa-eye"
              ></i>
            </td>
          </tr>
        </tbody>
        <span class="table-msg" v-if="filteredUsers.length === 0"> No users found. </span>
      </table>
    </div>
    <div class="footer">
      <InertiaLink :href="users.first_page_url">
        <i class="fa-solid fa-angles-left"></i>
      </InertiaLink>
      <InertiaLink :href="users.prev_page_url">
        <i class="fas fa-arrow-circle-left"></i>
      </InertiaLink>

      <span>Page {{ users.current_page }} of {{ users.last_page }}</span>
      <InertiaLink :href="users.next_page_url">
        <i class="fas fa-arrow-circle-right"></i>
      </InertiaLink>

      <InertiaLink :href="users.last_page_url">
        <i class="fa-solid fa-angles-right"></i>
      </InertiaLink>
    </div>
  </div>
</template>

<style scoped>
@import "./css/evaluation.css";
</style>
