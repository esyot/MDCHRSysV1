<script>
import Layout from "@/Layouts/Layout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  layout: Layout,
  props: {
    users: Object,
    department: Object,
    terms: Object,
    search_value: String,
    type: String,
  },
  components: {
    Link,
  },
  data() {
    return {
      search_bar: this.search_value ?? "",
    };
  },
  methods: {
    visitUser(user_id) {
      Inertia.visit(`/evaluations/user-view/${user_id}`);
    },
    searchUsers() {
      if (this.search_bar) {
        Inertia.get(`/evaluations/${this.type}`, {
          search_value: this.search_bar,
        });
      } else {
        Inertia.get(`/evaluations/${this.type}`);
      }
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
          v-model="search_bar"
          @input="searchUsers"
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
          <tr v-for="user in users.data" :key="user.id">
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
        <span class="table-msg" v-if="users.data.length === 0"> No users found. </span>
      </table>
    </div>
    <div class="footer">
      <Link :href="users.first_page_url">
        <i class="fa-solid fa-angles-left"></i>
      </Link>
      <Link :href="users.prev_page_url">
        <i class="fas fa-arrow-circle-left"></i>
      </Link>

      <span>Page {{ users.current_page }} of {{ users.last_page }}</span>
      <Link :href="users.next_page_url">
        <i class="fas fa-arrow-circle-right"></i>
      </Link>

      <Link :href="users.last_page_url">
        <i class="fa-solid fa-angles-right"></i>
      </Link>
    </div>
  </div>
</template>

<style scoped>
@import "./css/evaluation.css";
</style>
