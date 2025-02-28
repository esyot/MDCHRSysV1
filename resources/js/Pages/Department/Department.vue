<script>
import Layout from "@/Layouts/Layout.vue";
import AddDepartmentModal from "@/Modals/AddDepartmentModal.vue";
import ConfirmationDeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  layout: Layout,
  components: {
    AddDepartmentModal,
    ConfirmationDeleteModal,
  },
  props: {
    departments: Array,
    parentDepartments: Array,
  },
  data() {
    return {
      isAddDepartment: false,
      isDelete: false,
      selected_id: "",
    };
  },
  methods: {
    toggleAddDepartmentModal() {
      this.isAddDepartment = !this.isAddDepartment;
    },

    selectId(id) {
      this.selected_id === id ? (this.selected_id = null) : (this.selected_id = id);

      this.toggleDeleteForm();
    },
    toggleDeleteForm() {
      this.isDelete = !this.isDelete;
    },
    deleteForm() {
      Inertia.get(`/departments/department-delete/${this.selected_id}`);
      this.selected_id = null;
    },
  },
};
</script>
<template>
  <ConfirmationDeleteModal
    v-if="isDelete"
    :isDelete="isDelete"
    @deleteForm="deleteForm"
    @toggleDeleteForm="toggleDeleteForm"
  >
  </ConfirmationDeleteModal>
  <AddDepartmentModal
    v-if="isAddDepartment"
    :isAddDepartment="isAddDepartment"
    :parentDepartments="parentDepartments"
    @toggleAddDepartmentModal="toggleAddDepartmentModal"
  ></AddDepartmentModal>
  <header>
    <div class="container-btn">
      <button class="add-btn" @click="toggleAddDepartmentModal">Add Department</button>
    </div>
  </header>
  <section class="container">
    <table>
      <thead>
        <tr>
          <th class="start">Department Name</th>
          <th>Department Acronym</th>
          <th>Parent Department</th>
          <th>Dean</th>
          <th class="center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="department in departments" :key="department.id">
          <td>{{ department.name }}</td>
          <td class="center">{{ department.acronym }}</td>
          <td class="center">{{ department.parent ? department.parent.name : null }}</td>
          <td class="center">
            <span
              v-if="department.user_heads.length > 0"
              v-for="head in department.user_heads"
            >
              {{ head.last_name }},
              {{ head.first_name }}
              {{ head.middle_name[0] }}.
            </span>
          </td>
          <td class="buttons">
            <button @click="selectId(department.id)" class="delete-btn">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
header {
  display: flex;
  justify-content: flex-end;
  background-color: #fff;
}

.add-btn {
  background-color: rgb(55, 103, 246);
  color: white;
  padding: 10px;
  margin: 10px;
  border-radius: 5px;
  border: none;
  opacity: 50%;
}

.add-btn:hover {
  opacity: 100%;
  cursor: pointer;
}

.container {
  height: 80vh;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  background-color: #ebebeb;
}

.end {
  text-align: end;
}

.center {
  text-align: center;
}
.start {
  text-align: start;
}

table {
  width: 100%;
  border-collapse: collapse;
  background-color: #e4e4e4;
}

table thead {
  position: sticky;
  top: 0;
  z-index: 2;
}

table thead tr {
  background-color: #51bfff;
}

table thead tr th {
  padding: 10px;
  color: white;
}

tbody tr td {
  padding: 5px;
}

tbody tr:hover {
  background-color: #fff;
  cursor: pointer;
}

.buttons {
  display: flex;
  float: right;
}

.edit-btn {
  background-color: rgb(55, 103, 246);
  color: white;
  padding: 8px 10px;
  border-radius: 5px;
  border: none;
}

.delete-btn {
  background-color: rgb(255, 0, 0);
  color: white;
  padding: 5px 10px;

  border-radius: 5px;
  border: none;
}

.assign-btn {
  background-color: rgb(52, 168, 79);
  color: white;
  padding: 5px 8px;
  border-radius: 5px;
  border: none;
}

tbody tr td button {
  opacity: 50%;
  margin-inline: 10px;
}

tbody tr td button:hover {
  opacity: 100%;
  cursor: pointer;
}
</style>
