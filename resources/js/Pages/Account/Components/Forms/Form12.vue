<style scoped>
@import "./css/form.css";
</style>

<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">CURRICULAR AND SCHOOL COMMITTEE ASSIGNMENTS</span>
      <small>(Last 2 years.)</small>
    </div>

    <div class="add-field-btn">
      <button @click="addField">Add Field</button>
    </div>
    <div
      v-for="(userSchoolCur, index) in userDetails.user_school_curriculars"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="designation">DESIGNATION:</label>
        <input
          type="text"
          id="designation"
          name="designation"
          v-model="userSchoolCur.designation"
          class="form-control"
          placeholder="e.g., Organizer, Coordinator, Director, Moderator, Coach, Cultural Presentor, Chairman, Adviser"
          @input="handleFieldFocus(`user_school_curriculars`)"
        />
      </div>
      <div class="form-group">
        <label for="event_name">NAME OF EVENTS:</label>
        <input
          type="text"
          id="event_name"
          name="event_name"
          v-model="userSchoolCur.event_name"
          class="form-control"
          placeholder="Enter Event Name"
          @input="handleFieldFocus(`user_school_curriculars`)"
        />
      </div>
      <div class="form-group">
        <label for="title">NATURE/TITLE OF ASSIGNMENTS:</label>
        <input
          type="text"
          name="title"
          id="title"
          v-model="userSchoolCur.title"
          class="form-control"
          placeholder="Enter Title"
          @input="handleFieldFocus(`user_school_curriculars`)"
        />
      </div>
      <div class="form-group">
        <label for="date">INCLUSIVE DATES:</label>
        <input
          type="date"
          name="date"
          id="date"
          v-model="userSchoolCur.date"
          class="form-control"
          @input="handleFieldFocus(`user_school_curriculars`)"
        />
      </div>
      <button
        v-if="
          userSchoolCur.designation == '' &&
          userSchoolCur.event_name == '' &&
          userSchoolCur.title == '' &&
          userSchoolCur.date == ''
        "
        @click="removeField(index)"
        class="remove-btn"
      >
        Remove
      </button>
      <hr />
    </div>
  </div>
  <div class="personal-details-items" v-if="editMode == false">
    <div class="title-container">
      <span class="title">CURRICULAR AND SCHOOL COMMITTEE ASSIGNMENTS</span>
    </div>
    <div
      v-for="userSchoolCur in personalDetails.user_school_curriculars"
      :key="userSchoolCur.id"
      class="form-group"
    >
      <label> {{ userSchoolCur.title }}</label>
      <span>
        {{ userSchoolCur.date }} || {{ userSchoolCur.event_name }} ||
        {{ userSchoolCur.designation }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  emits: ["track-touched-field", "update-user-details"],
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
      this.userDetails.user_school_curriculars.push({
        designation: "",
        event_name: "",
        title: "",
        date: "",
      });
    },
    removeField(index) {
      this.userDetails.user_school_curriculars.splice(index, 1);
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_school_curriculars = newVal.user_school_curriculars || [];
      },
      immediate: true,
    },
  },
};
</script>
