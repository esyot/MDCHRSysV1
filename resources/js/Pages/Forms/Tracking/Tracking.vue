<script>
import Layout from "@/Layouts/Layout.vue";
import Modal from "@/Pages/Forms/Tracking/TrackingModal.vue";
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
    };
  },
  components: {
    Modal,
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

    toggleFormModal(id) {
      this.selected_id = this.selected_id === id ? null : id + "";
    },
  },
};
</script>

<template>
  <Modal :forms="forms" :selected_id="selected_id" @toggleFormModal="toggleFormModal" />
  <div class="container">
    <div class="content">
      <table>
        <thead>
          <tr>
            <td>Form Type</td>
            <td>Status</td>
            <td>Submitted on</td>
            <td class="td-action">Action</td>
          </tr>
        </thead>

        <tbody>
          <tr v-for="form in forms" :key="form.id">
            <td>{{ form.form_type }}</td>
            <td>{{ form.status }}</td>
            <td>{{ formatDate(form.created_at) }}</td>
            <td class="td-action">
              <button @click="toggleFormModal(form.id)" class="edit-btn">
                <i class="fas fa-eye"></i>
              </button>
              <button class="delete-btn"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
@import "./tracking.css";
</style>
