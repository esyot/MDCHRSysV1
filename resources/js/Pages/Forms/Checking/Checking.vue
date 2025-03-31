<script>
import Layout from "@/Layouts/Layout.vue";
import LeaveFormModal from "./Modals/LeaveFormModal.vue";
import TravelFormModal from "./Modals/TravelFormModal.vue";
import { WhenVisible } from "@inertiajs/vue3";
import Loader from "@/Components/FormLoader.vue";

export default {
  layout: Layout,
  components: {
    LeaveFormModal,
    TravelFormModal,
    WhenVisible,
    Loader,
  },
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
      formData: [],
      statusMap: {
        pending: { text: "Pending", icon: "loading", color: "" },
        dean_approved: {
          text: "Recommended by the Dean",
          icon: "fa-circle-check",
          color: "green",
        },
        hr_approved: {
          text: "Approved by HR",
          icon: "fa-circle-check",
          color: "green",
        },

        vp_admin_approved: {
          text: "Approved by VP-Admin",
          icon: "fa-circle-check",
          color: "green",
        },

        vp_acad_approved: {
          text: "Approved by VP-Acad",
          icon: "fa-circle-check",
          color: "green",
        },

        p_admin_approved: {
          text: "Approved by President",
          icon: "fa-circle-check",
          color: "green",
        },
        endorsed: { text: "Endorsed", icon: "fa-truck", color: "green" },
        declined: { text: "Declined", icon: "fa-circle-xmark", color: "red" },
        recommended: { text: "Recommended", icon: "fa-handshake", color: "green" },
      },
    };
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

    toggleFormModal(id, type, form) {
      const isSelected = this.selected_id === id && this.selected_type === type;
      this.selected_id = isSelected ? null : id + "";
      this.selected_type = isSelected ? null : type + "";
      this.formData = form;
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

    travelForms() {
      return this.forms.filter((item) => item.form_type === "Travel Form");
    },
    leaveForms() {
      return this.forms.filter((item) => item.form_type === "Leave Form");
    },
  },
};
</script>

<template>
  <div v-if="selected_type == 'Leave Form'">
    <LeaveFormModal
      :selected_id="selected_id"
      :selected_type="selected_type"
      :formData="formData"
      :roles="roles"
      @toggleFormModal="toggleFormModal"
    ></LeaveFormModal>
  </div>

  <div v-if="selected_type == 'Travel Form'">
    <TravelFormModal
      :selected_id="selected_id"
      :selected_type="selected_type"
      :formData="formData"
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
      <WhenVisible data="forms">
        <template #fallback>
          <Loader :message="'fetching forms, please wait.'"></Loader>
        </template>

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
              <td
                class="td-title"
                v-if="
                  roles.includes('vp-admin') ||
                  roles.includes('vp-acad') ||
                  roles.includes('p-admin')
                "
              >
                <i class="fa-solid fa-user-cog"></i>
                <span>Endorsed by</span>
              </td>

              <td class="td-title" v-if="roles.includes('hr')">
                <i class="fa-solid fa-user-cog"></i>
                <span>Recommended by</span>
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
              @click="toggleFormModal(form.id, form.form_type, form)"
            >
              <td>{{ form.user.last_name }}, {{ form.user.first_name }}</td>
              <td>{{ form.form_type }}</td>
              <td class="td-status">
                <div class="status-item" v-if="statusMap[form.status]">
                  <span>{{ statusMap[form.status].text }} </span>
                  <i
                    v-if="statusMap[form.status].icon !== 'loading'"
                    :class="`fas ${statusMap[form.status].icon} ${
                      statusMap[form.status].color
                    }`"
                  ></i>
                  <img
                    v-else
                    class="loading"
                    src="/public/assets/loader/loading.gif"
                    alt=""
                  />
                </div>
              </td>

              <td v-if="form.endorser">
                {{ form.endorser.last_name }}, {{ form.endorser.first_name }}
              </td>
              <td v-if="!form.endorser && roles.includes('hr')">
                <span></span>
              </td>

              <td
                v-if="
                  !form.recommender &&
                  (roles.includes('vp-admin') ||
                    roles.includes('p-admin') ||
                    roles.includes('vp-acad'))
                "
              >
                <span></span>
              </td>

              <td v-if="form.recommender">
                {{ form.recommender.last_name }}, {{ form.recommender.first_name }}
              </td>
              <td>{{ formatDate(form.created_at) }}</td>
              <td class="td-action">
                <button
                  @click="toggleFormModal(form.id, form.form_type, form)"
                  class="edit-btn"
                >
                  <i class="fas fa-eye"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="empty-msg" v-if="forms && forms.length === 0">
          <span>There have been no submissions yet.</span>
        </div>
      </WhenVisible>
    </div>
  </div>
</template>

<style scoped>
@import "./Modals/css/checking.css";
</style>
