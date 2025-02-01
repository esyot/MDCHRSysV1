<script>
import Layout from "@/Layouts/Layout.vue";
export default {
  layout: Layout,
  props: {
    forms: {
      type: Object,
    },
  },
};
</script>

<template>
  <div class="container">
    <div class="title">
      <span>Track Forms</span>
    </div>

    <div class="content">
      <table>
        <thead>
          <tr>
            <td>Type</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </thead>

        <tbody>
          <tr v-for="form in forms" :key="form.id">
            <td>{{ form.form_type }}</td>
            <td>{{ form.status }}</td>
            <td>
              <button><i class="fas fa-eye"></i></button>
              <button><i class="fas fa-trash"></i></button>
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
  width: 100%;
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

thead {
  background-color: #007bff;
  color: #fff;
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
  color: #007bff;
  transition: color 0.3s ease;
}

button:hover {
  color: #0056b3;
}

button i {
  font-size: 16px;
}
</style>
