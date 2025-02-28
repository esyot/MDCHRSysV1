<style scoped>
@import "./css/form.css";
</style>

<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">WORK/TEACHING EXPERIENCE FORM</span>
    </div>
    <div class="add-field-btn">
      <button @click="addField">Add Field</button>
    </div>
    <div
      v-for="(userWorkExp, index) in userDetails.user_work_experiences"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="date_from">DATE FROM:</label>
        <input
          type="date"
          name="date_from"
          id="date_from"
          placeholder="e.g., 12-12-2000"
          v-model="userWorkExp.date_from"
          @input="handleFieldFocus(`user_work_experiences`)"
        />
      </div>
      <div class="form-group">
        <label for="date_to">DATE TO:</label>
        <input
          type="date"
          name="date_to"
          id="date_to"
          placeholder="e.g., 12-12-2000"
          v-model="userWorkExp.date_to"
          @input="handleFieldFocus(`user_work_experiences`)"
        />
      </div>
      <div class="form-group">
        <label for="position">POSITION TITLE:</label>
        <input
          type="text"
          name="position"
          id="position"
          class="form-control"
          placeholder="eg., Staff"
          v-model="userWorkExp.position"
          @input="handleFieldFocus(`user_work_experiences`)"
        />
      </div>
      <div class="form-group">
        <label for="company_name">NAME OF COMPANY/SCHOOL:</label>
        <input
          type="text"
          name="company_name"
          id="company_name"
          class="form-control"
          placeholder="eg., XYZ University"
          v-model="userWorkExp.company_name"
          @input="handleFieldFocus(`user_work_experiences`)"
        />
      </div>
      <div class="form-group">
        <label for="rank">RANK:</label>
        <input
          type="text"
          name="rank"
          id="rank"
          class="form-control"
          placeholder="eg., Staff II"
          v-model="userWorkExp.rank"
          @input="handleFieldFocus(`user_work_experiences`)"
        />
      </div>
      <div class="form-group">
        <label for="status">STATUS OF APPOINTMENT:</label>
        <input
          type="text"
          name="status"
          id="status"
          class="form-control"
          placeholder="eg., Permanent"
          v-model="userWorkExp.status"
          @input="handleFieldFocus(`user_work_experiences`)"
        />
      </div>
      <button
        v-if="
          userWorkExp.date_from == '' &&
          userWorkExp.date_to == '' &&
          userWorkExp.position == '' &&
          userWorkExp.company_name == '' &&
          userWorkExp.rank == '' &&
          userWorkExp.status == ''
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
      <span class="title">WORK/TEACHING EXPERIENCE</span>
    </div>
    <div
      v-for="userWorkExp in personalDetails.user_work_experiences"
      :key="userWorkExp.id"
      class="form-group"
    >
      <label> {{ userWorkExp.company_name }}</label>
      <span>
        {{ userWorkExp.date_from }} || {{ userWorkExp.date_to }} ||
        {{ userWorkExp.rank }} ||
        {{ userWorkExp.status }}
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
      this.userDetails.user_work_experiences.push({
        date_from: "",
        date_to: "",
        position: "",
        company_name: "",
        rank: "",
        status: "",
      });
    },
    removeField(index) {
      this.userDetails.user_work_experiences.splice(index, 1);
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_work_experiences = newVal.user_work_experiences || [];
      },
      immediate: true,
    },
  },
};
</script>
