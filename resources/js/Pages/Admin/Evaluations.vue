<script>
export default {
  name: "Evaluations",
  props: {
    evaluations: Object,
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
  },
};
</script>
<template>
  <header>
    <span class="title">Evaluations</span>
    <select name="" id="">
      <option value="" selected disabled>Select a year</option>
    </select>
  </header>
  <section>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Date</th>
          <th>Ratings</th>
          <th>Conducted By</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="evaluation in evaluations" :key="evaluation.id">
          <td>
            {{ evaluation.user.last_name }}, {{ evaluation.user.first_name }}
            {{ evaluation.user.middle_name[0] }}.
          </td>
          <td>{{ formatDate(evaluation.date_time) }}</td>
          <td>{{ evaluation.ratings }}</td>
          <td>
            {{ evaluation.conductor.last_name }}, {{ evaluation.conductor.first_name }}

            {{ evaluation.conductor.middle_name[0] }}.
          </td>
          <td><i title="Click to display preview" class="preview-btn fas fa-eye"></i></td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
header {
  display: flex;
  justify-content: space-between;
  background-color: #fff;
  align-items: center;
}

header select {
  padding: 5px;
  margin-right: 10px;
}

section table {
  width: 100%;
  background-color: #fff;
  border-collapse: collapse;
}

section table thead {
  background-color: rgb(12, 175, 234);
  color: #fff;
}

table thead tr th {
  padding: 10px;
}

table tbody tr td {
  text-align: center;
  padding: 10px;
}
.title {
  font-size: 16pt !important;
  margin: 0;
}

.preview-btn {
  color: rgb(20, 114, 215);
  opacity: 75%;
}

.preview-btn:hover {
  opacity: 100%;
  cursor: pointer;
}
</style>
