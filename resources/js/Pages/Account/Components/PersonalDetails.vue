<script src="./js/personal-details.js"></script>

<template>
  <div id="confirmationSubmitModal" class="modal modal-hide">
    <div class="modal-content">
      <div class="modal-content-description">
        <label>Are you sure to save all your changes?</label>
      </div>
      <div class="modal-content-btn">
        <button
          type="button"
          @click="toggleConfirmationSubmitModal('close')"
          class="no-btn"
        >
          No
        </button>
        <button type="button" @click="personalDetailSubmit" class="yes-btn">Yes</button>
      </div>
    </div>
  </div>

  <form @submit.prevent="personalDetailSubmit" @keydown.enter.prevent>
    <div class="personal-details-content">
      <Form1
        v-if="currentPage === 1"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form2
        v-if="currentPage === 2"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form3
        v-if="currentPage === 3"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form4
        v-if="currentPage === 4"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form5
        v-if="currentPage === 5"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form6
        v-if="currentPage === 6"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form7
        v-if="currentPage === 7"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form8
        v-if="currentPage === 8"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form9
        v-if="currentPage === 9"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form10
        v-if="currentPage === 10"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form11
        v-if="currentPage === 11"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form12
        v-if="currentPage === 12"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form13
        v-if="currentPage === 13"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form14
        v-if="currentPage === 14"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
      <Form15
        v-if="currentPage === 15"
        :editMode="editMode"
        :userDetails="userDetails"
        :personalDetails="personalDetails"
        @update-user-details="updateUserDetails"
        @track-touched-field="trackTouchedField"
      />
    </div>
    <div class="footer">
      <div id="EditModeToggle">
        <span id="modeText">Edit Mode</span>
        <label class="switch">
          <input
            type="checkbox"
            id="toggleButton"
            @click="toggleEditMode"
            :checked="editMode == true"
          />
          <span class="slider"></span>
        </label>

        <button
          type="button"
          @click="toggleConfirmationSubmitModal('open')"
          class="saveChangesBtn"
          v-if="editModeHasChanged && editMode"
        >
          Save Changes
        </button>
      </div>

      <div class="navigation-buttons">
        <button type="button" @click="goToPage('prev')">
          <i class="fas fa-chevron-circle-left"></i>
        </button>

        <span class="pageNum">
          {{ currentPage }}
        </span>
        <button type="button" @click="goToPage('next')">
          <i class="fas fa-chevron-circle-right"></i>
        </button>
      </div>
    </div>
  </form>
</template>

<style scoped>
@import "./css/personal-details.css";
</style>
