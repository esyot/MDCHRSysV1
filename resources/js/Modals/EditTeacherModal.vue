<script src="./js/edit-teacher-modal.js"></script>

<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>

  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <span>Edit Teacher Details</span>
        <i @click="closeModal">&times;</i>
      </div>

      <div class="input-group">
        <label for="">Specialization: </label>
        <input
          type="text"
          list="specializationList"
          v-model="formData.specialization"
          placeholder="Search or Select type of specialization"
        />
        <datalist id="specializationList">
          <option
            :value="specialization"
            v-for="(specialization, index) in specializationList"
            :key="index"
          >
            {{ specialization }}
          </option>
        </datalist>
      </div>

      <div class="input-group">
        <label for="">Date Hired: </label>
        <input type="date" v-model="formData.date_hired" />
      </div>

      <div class="input-group">
        <label for="">Department: </label>
        <select name="" id="" v-model="formData.department_id">
          <option value="" selected disabled>Select a department</option>
          <option
            :value="department.id"
            v-for="department in departmentList"
            :key="department.id"
          >
            {{ department.name }}({{ department.acronym }})
          </option>
        </select>
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button @click="toggleConfirmForm()" class="update-btn">Update</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/edit-teacher-modal.css";
</style>
