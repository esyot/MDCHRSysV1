<script>
import Layout from "@/Layouts/Layout.vue";
import LeaveFormModal from "./Modals/LeaveFormModal.vue";
import TravelFormModal from "./Modals/TravelFormModal.vue";

export default {
  layout: Layout,
  props: {
    forms: {
      type: Array,
    },
    selected: String,
    roles: Array,
  },
  data() {
    return {
      selected_id: "",
      selected_type: "",
      form_selection: this.selected ?? "all",
      isNavigating: false,
    };
  },
  components: {
    LeaveFormModal,
    TravelFormModal,
  },
  methods: {
    formatDate(date) {
      const convertedDate = new Date(date);
      const options = {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: true,
      };
      return convertedDate.toLocaleString("en-US", options);
    },

    toggleFormModal(id, type) {
      const isSelected = this.selected_id === id && this.selected_type === type;
      this.selected_id = isSelected ? null : id + "";
      this.selected_type = isSelected ? null : type + "";
    },
  },
  computed: {
    filteredForms() {
      if (this.form_selection === "travel") {
        return this.forms.filter((item) => item.form_type === "Travel Form");
      } else if (this.form_selection === "leave") {
        return this.forms.filter((item) => item.form_type === "Leave Form");
      } else {
        return this.forms;
      }
    },
  },
};
</script>

<template>
  <div v-if="selected_type == 'Leave Form'">
    <LeaveFormModal
      :selected_id="selected_id"
      :selected_type="selected_type"
      :leaveForms="filteredForms"
      :roles="roles"
      @toggleFormModal="toggleFormModal"
    ></LeaveFormModal>
  </div>

  <div v-if="selected_type == 'Travel Form'">
    <TravelFormModal
      :selected_id="selected_id"
      :selected_type="selected_type"
      :travelForms="filteredForms"
      :roles="roles"
      @toggleFormModal="toggleFormModal"
    ></TravelFormModal>
  </div>
  <div class="container">
    <div class="forms-selection">
      <select name="" id="" v-model="form_selection">
        <option value="all">All Forms</option>
        <option value="travel">Travel Forms</option>
        <option value="leave">Leave Forms</option>
      </select>
    </div>
    <div class="content">
      <table>
        <thead>
          <tr>
            <td class="td-title">
              <i class="fa-solid fa-address-card"></i>
              <span>Name</span>
            </td>
            <td class="td-title">
              <i class="fa-solid fa-paperclip"></i>
              <span>Type</span>
            </td>
            <td class="td-title">
              <i class="fa-solid fa-temperature-empty"></i>
              <span>Status</span>
            </td>
            <td class="td-title">
              <i class="fa-solid fa-user-cog"></i>
              <span>Endorsed by</span>
            </td>
            <td class="td-title">
              <i class="fa-solid fa-share-from-square"></i>
              <span>Filed on</span>
            </td>
            <td class="td-action">
              <i class="fa-solid fa-gear"></i>
              <span>Action</span>
            </td>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="form in filteredForms"
            :key="form.id"
            @click="toggleFormModal(form.id, form.form_type)"
          >
            <td>
              {{ form.user.last_name }}, {{ form.user.first_name }}
              {{ form.user.middle_name[0] }}.
            </td>
            <td>{{ form.form_type }}</td>
            <td class="td-status">
              <img
                v-if="form.status == 'pending'"
                class="loading"
                src="/public/assets/loader/loading.gif"
                alt=""
              />
              <i v-if="form.status == 'approved'" class="green fas fa-circle-check"></i>
              <i v-if="form.status == 'endorsed'" class="green fa-solid fa-truck"></i>
              <i v-if="form.status == 'declined'" class="red fas fa-circle-xmark"></i>
              <i v-if="form.status == 'recommended'" class="green fas fa-handshake"></i>
              <span>{{ form.status }}</span>
            </td>
            <td v-if="form.endorser">
              {{ form.endorser.last_name }}, {{ form.endorser.first_name }}
              {{ form.endorser.middle_name[0] }}.
            </td>

            <td v-else></td>

            <td>{{ formatDate(form.created_at) }}</td>
            <td class="td-action">
              <button @click="toggleFormModal(form.id, form.form_type)" class="edit-btn">
                <i class="fas fa-eye"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="empty-msg" v-if="forms.length == 0">
        <span>There have been no submissions yet.</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./Modals/css/checking.css";
</style>
