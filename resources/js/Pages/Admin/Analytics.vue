<script>
import Layout from "@/Layouts/Layout.vue";
export default {
  layout: Layout,
};
</script>

<template>
  <header class="header">
    <div class="header-item">
      <div class="search-bar">
        <i class="fas fa-magnifying-glass"></i>
        <input type="text" placeholder="Search a user" />
      </div>
      <select name="" id="">
        <option
          disabled
          selected
          value="
    "
        >
          Select Year
        </option>
      </select>
      <select name="" id="">
        <option
          disabled
          selected
          value="
    "
        >
          Select Type of form
        </option>
        <option value="">Leave Forms</option>
        <option value="">Travel Forms</option>
      </select>

      <select name="" id="">
        <option
          disabled
          selected
          value="
    "
        >
          Select Filter
        </option>

        <option value="">Annually</option>
        <option value="">Monthly</option>
        <option value="">Weekly</option>
      </select>
    </div>

    <div class="header-item">
      <button>
        <i class="fas fa-ellipsis-v"></i>
      </button>
    </div>
  </header>

  <section>
    <table>
      <thead>
        <tr>
          <th>Form type</th>
          <th>Date Start</th>
          <th>Date End</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Travel Form</td>
          <td>12/12/12</td>
          <td>12/12/12</td>
          <td><i class="fas fa-eye"></i></td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  background-color: #fff;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
}

.header .search-bar input {
  background-color: transparent;
  border: none;
  outline: none;
}

.header .search-bar i {
  color: #6a6a6a;
}
.header .search-bar {
  background-color: #fff;
  display: flex;
  align-items: center;
  gap: 0.2rem;
  padding: 10px;
  border-radius: 20px;
  box-shadow: inset 2px 2px 2px 2px rgba(0, 0, 0, 0.2);
  border: 1px solid #838383;
}

.header-item {
  display: flex;
  gap: 0.3rem;
}
.header-item select {
  box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
  border: 1px solid #888888;
  color: #000000;
  padding-inline: 5px;
  border-radius: 5px;
}

.header-item button {
  background-color: transparent;
  border: none;
  opacity: 50%;
}

.header-item button:hover {
  opacity: 100%;
  cursor: pointer;
}
.header-item button i {
  font-size: 20px;
}

table {
  width: 100%;
  background-color: #fff;
  border-collapse: collapse;
}

table thead {
  background-color: rgb(30, 125, 203);
  color: #fff;
}

table thead th {
  padding: 10px;
}

table tbody tr td {
  padding: 10px;
  text-align: center;
}
</style>
