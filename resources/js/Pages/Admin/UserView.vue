<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  layout: Layout,
  props: {
    users: Object,
    roles: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    openEval() {
      Inertia.visit(`/user-list/${this.users.id}/evaluation-form`);
    },
  },
};
</script>

<template>
  <div class="container">
    <div class="content">
      <div class="user">
        <div class="user-content">
          <div>
            <img
              :src="
                users.img
                  ? `/storage/users/images/${users.img}`
                  : '/assets/images/user.png'
              "
              alt="User Image"
              class="user-img"
            />
          </div>
          <div class="user-details">
            <span class="name">{{ users.first_name }} {{ users.last_name }}</span>
            <div class="user-role">
              <i class="fas fa-user-cog"></i>
              <div>
                <span v-for="role in roles" :key="role" class="role-desc"
                  >{{ role }},</span
                >
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
  </div>
</template>
<style scoped>
@import "./css/user-view.css";
</style>
