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
.container {
  background-color: #fff;
  display: flex;
  flex-direction: column;
}
.container .title span {
  font-size: 20px;
  font-weight: bold;
}
.container .title {
  padding: 10px;
  box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.1);
}
.content {
  display: block;
  margin: 10px;
  background-color: #fff;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

table {
  width: 100%;
  border-collapse: collapse;
}

.td-action {
  width: 100px;
  text-align: center;
}

thead {
  background-color: #e0e0e0;
  color: #676767;
}

thead td {
  padding: 12px 15px;
  font-weight: bold;
  text-align: left;
}

tbody tr {
  border-bottom: 1px solid #ddd;
}

tbody tr:nth-child(even) {
  background-color: #f8f9fa;
}

tbody tr:hover {
  background-color: #f1f1f1;
}

td {
  padding: 12px 15px;
  text-align: left;
}

button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  padding: 5px;
  margin: 0 5px;
  transition: color 0.3s ease;
}

.edit-btn {
  color: #007bff;
  opacity: 75%;
}

.delete-btn {
  color: #ca0909;
  opacity: 50%;
}

.edit-btn:hover,
.delete-btn:hover {
  opacity: 100%;
  cursor: pointer;
}
button i {
  font-size: 16px;
}
</style>
