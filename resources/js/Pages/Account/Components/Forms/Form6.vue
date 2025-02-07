<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">ADMINISTRATIVE POSITIONS HELD FORM</span>
    </div>
    <div class="add-field-btn">
      <button @click="addField">Add Field</button>
    </div>
    <div
      v-for="(userAdminHeld, index) in userDetails.user_admin_pos_helds"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="date">INCLUSIVE DATES: </label>
        <input
          type="date"
          id="date"
          name="date"
          v-model="userAdminHeld.date"
          class="form-control"
          placeholder="Enter Date Recieved"
          @input="handleFieldFocus(`user_admin_pos_helds`)"
        />
      </div>
      <div class="form-group">
        <label for="title">NATURE/TITLE OF AWARD:</label>
        <input
          type="text"
          name="title"
          id="title"
          v-model="userAdminHeld.title"
          class="form-control"
          placeholder="Enter Title of Award"
          @input="handleFieldFocus(`user_admin_pos_helds`)"
        />
      </div>
      <div class="form-group">
        <label for="recognition_place">PLACE OF RECOGNITION:</label>
        <input
          type="text"
          name="recognition_place"
          id="recognition_place"
          v-model="userAdminHeld.recognition_place"
          class="form-control"
          placeholder="Enter Place of Recognition"
          @input="handleFieldFocus(`user_admin_pos_helds`)"
        />
      </div>
      <div class="form-group">
        <label for="awarded_by">AWARDED BY:</label>
        <input
          type="text"
          name="awarded_by"
          id="awarded_by"
          v-model="userAdminHeld.awarded_by"
          class="form-control"
          placeholder="Enter Awarded By"
          @input="handleFieldFocus(`user_admin_pos_helds`)"
        />
      </div>
      <hr />
    </div>
  </div>
  <div class="personal-details-items" v-if="editMode == false">
    <div class="title-container">
      <span class="title">ADMINISTRATIVE POSITIONS HELD</span>
    </div>
    <div
      v-for="userAdminHeld in personalDetails.user_admin_pos_helds"
      :key="userAdminHeld.id"
      class="form-group"
    >
      <label> {{ userAdminHeld.title }}</label>
      <span>
        {{ userAdminHeld.date }} || {{ userAdminHeld.recognition_place }} ||
        {{ userAdminHeld.awarded_by }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  emits: ["update-user-details"],
  props: {
    userDetails: Object,
    editMode: Boolean,
    personalDetails: Object,
  },
  methods: {
    handleFieldFocus(fieldName) {
      this.$emit("track-touched-field", fieldName);
    },

    handleFieldChange(fieldName) {
      this.$emit("update-user-details", {
        [fieldName]: this.userDetails[fieldName],
      });
    },
    addField() {
      this.userDetails.user_admin_pos_helds.push({
        date: "",
        title: "",
        recognition_place: "",
        awarded_by: "",
      });
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_admin_pos_helds = newVal.user_admin_pos_helds || [];
      },
      immediate: true,
    },
  },
};
</script>
