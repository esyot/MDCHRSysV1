<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import Modal from "@/Pages/Forms/Tracking/TrackingModal.vue";
import DeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
export default {
  layout: Layout,
  props: {
    forms: {
      type: Object,
    },
  },
  data() {
    return {
      selected_id: null,
      selected_type: null,
      isConfirmation: false,
      isDelete: false,
      statusMap: {
        pending: { text: "Pending", icon: "loading", color: "" },
        approved: { text: "Approved", icon: "fa-circle-check", color: "green" },
        dean_approved: {
          text: "Approved by Dean",
          icon: "fa-circle-check",
          color: "green",
        },
        hr_approved: { text: "Approved by HR", icon: "fa-circle-check", color: "green" },
        vp_admin_approved: {
          text: "Approved by VP_Admin",
          icon: "fa-circle-check",
          color: "green",
        },
        vp_acad_approved: {
          text: "Approved by VP_Acad",
          icon: "fa-circle-check",
          color: "green",
        },
        declined: { text: "Declined", icon: "fa-circle-xmark", color: "red" },
      },
    };
  },
  components: {
    Modal,
    DeleteModal,
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
      this.selected_id = this.selected_id === id ? null : id + "";
      this.selected_type = this.selected_type === type ? null : type + "";
    },

    toggleDeleteForm(id, type) {
      this.isDelete = !this.isDelete;
      this.selected_id = this.selected_id === id ? null : id + "";
      this.selected_type = this.selected_type === type ? null : type + "";
    },

    deleteForm() {
      Inertia.delete(`/form/delete/${this.selected_type}/${this.selected_id}`, {
        onSuccess: () => {
          this.toggleDeleteForm(this.selected_id, this.selected_type);
        },
      });
    },
  },
};
</script>

<template>
  <Modal
    v-if="!isDelete"
    :forms="forms"
    :selected_id="selected_id"
    :selected_type="selected_type"
    @toggleFormModal="toggleFormModal"
  />

  <DeleteModal
    v-if="isDelete"
    :selected_id="selected_id"
    :selected_type="selected_type"
    @deleteForm="deleteForm"
    @toggleDeleteForm="toggleDeleteForm"
  ></DeleteModal>

  <div class="container">
    <div class="content">
      <table>
        <thead>
          <tr>
            <td class="td-title">
              <i class="fa-solid fa-paperclip"></i>
              <span>Type</span>
            </td>
            <td class="td-title">
              <i class="fa-solid fa-temperature-empty"></i>
              <span>Status</span>
            </td>
            <td class="td-title">
              <i class="fa-solid fa-share-from-square"></i>
              <span>Submitted on</span>
            </td>
            <td class="td-action">
              <i class="fa-solid fa-gear"></i>
              <span>Action</span>
            </td>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="form in forms"
            :key="form.id"
            @click="toggleFormModal(form.id, form.form_type)"
          >
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
            <td>{{ formatDate(form.created_at) }}</td>
            <td class="td-action">
              <button @click="toggleFormModal(form.id, form.form_type)" class="edit-btn">
                <i class="fas fa-eye"></i>
              </button>
              <button
                @click="toggleDeleteForm(form.id, form.form_type)"
                v-if="form.status == 'pending'"
                class="delete-btn"
              >
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="empty-msg" v-if="forms.length == 0">
        <span>You haven't submitted a form yet.</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/tracking.css";
</style>
