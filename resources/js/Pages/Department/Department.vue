<script src="./js/department.js"></script>
<template>
  <header>
    <div class="container-btn">
      <button class="add-btn" @click="toggleSyncDepartments">Sync Departments</button>
    </div>
  </header>
  <section class="container">
    <table>
      <thead>
        <tr>
          <th class="start">Name</th>
          <th>Acronym</th>
          <th>Parent</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="department in departments" :key="department.id">
          <td>{{ department.name }}</td>
          <td class="center">{{ department.acronym }}</td>
          <td class="center">{{ department.parent ? department.parent.name : null }}</td>
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
  background-color: rgb(37, 154, 237);
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
  padding: 10px 15px;
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
