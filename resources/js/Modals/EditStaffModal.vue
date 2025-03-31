<script src="./js/edit-staff-modal.js"></script>

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
        <span>Edit Staff Details</span>
        <i @click="closeModal">&times;</i>
      </div>

      <div class="input-group">
        <label for="position">Position: </label>
        <input
          type="text"
          id="position"
          name="position"
          list="positionList"
          v-model="formData.position"
        />
        <datalist id="positionList">
          <option
            :value="position"
            v-for="(position, index) in positionList"
            :key="index"
          >
            {{ position }}
          </option>
        </datalist>
      </div>

      <div class="input-group">
        <label for="date_hired">Date Hired: </label>
        <input
          id="date_hired"
          name="date_hired"
          type="date"
          v-model="formData.date_hired"
        />
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button @click="toggleConfirmForm()" class="update-btn">Update</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/edit-staff-modal.css";
</style>
