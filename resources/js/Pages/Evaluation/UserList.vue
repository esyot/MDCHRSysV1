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
    searchValue: String,
    type: String,
    orderBy: String,
  },
  components: {
    Link,
  },
  data() {
    return {
      search_value: this.searchValue ?? "",
      order_by: this.orderBy ?? "ASC",
    };
  },
  watch: {
    search_value(newVal) {
      if (newVal === "") {
        Inertia.get(`/evaluations/${this.type}`, {
          orderBy: this.order_by,
        });
      }
    },
  },
  methods: {
    visitUser(user_id) {
      Inertia.get(`/evaluations/user-view/${user_id}`);
    },
    paginationControl(link) {
      Inertia.get(link, {
        searchValue: this.search_value,
        orderBy: this.order_by,
      });
    },
    filterUsers() {
      Inertia.get(`/evaluations/${this.type}`, {
        searchValue: this.search_value,
        orderBy: this.order_by,
      });
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

      <div class="right">
        <div class="search-bar">
          <input
            type="text"
            name="searchValue"
            v-model="search_value"
            placeholder="Search a user..."
          />

          <i
            v-if="search_value"
            @click="filterUsers()"
            class="fa-solid fa-circle-arrow-right fa-lg"
          ></i>
        </div>

        <select name="" id="" v-model="order_by" @change="filterUsers()">
          <option value="ASC">ASC</option>
          <option value="DESC">DESC</option>
        </select>
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
      <i
        @click="paginationControl(users.first_page_url)"
        class="fa-solid fa-angles-left"
      ></i>

      <i
        @click="paginationControl(users.prev_page_url)"
        class="fas fa-arrow-circle-left"
      ></i>

      <span>Page {{ users.current_page }} of {{ users.last_page }}</span>

      <i
        @click="paginationControl(users.next_page_url)"
        class="fas fa-arrow-circle-right"
      ></i>

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
