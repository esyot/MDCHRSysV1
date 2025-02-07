<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title"
        >RESEARCH STUDIES, RESEARCH PROJECTS AND BOOK PUBLISHED FORM</span
      >
    </div>
    <div class="add-field-btn">
      <button @click="addField">Add Field</button>
    </div>
    <div
      v-for="(userStud, index) in userDetails.user_studies"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="date_published">DATE PUBLISHED:</label>
        <input
          type="date"
          name="date_published"
          id="date_published"
          class="form-control"
          v-model="userStud.date_published"
          @input="handleFieldFocus(`user_studies`)"
        />
      </div>
      <div class="form-group">
        <label for="research_title">RESEARCH TITLE:</label>
        <input
          type="text"
          name="research_title"
          id="research_title"
          class="form-control"
          placeholder="eg., Research"
          v-model="userStud.research_title"
          @input="handleFieldFocus(`user_studies`)"
        />
      </div>
      <div class="form-group">
        <label for="journal_name">NAME OR JOURNAL:</label>
        <input
          type="text"
          name="journal_name"
          id="journal_name"
          class="form-control"
          placeholder="eg., Journal Name"
          v-model="userStud.journal_name"
          @input="handleFieldFocus(`user_studies`)"
        />
      </div>
      <div class="form-group">
        <label for="link">LINK OF JOURNAL/VOLUME NUMBER:</label>
        <input
          type="text"
          name="link"
          id="link"
          class="form-control"
          placeholder="eg., https://example.com"
          v-model="userStud.link"
          @input="handleFieldFocus(`user_studies`)"
        />
      </div>
      <hr />
    </div>
  </div>
  <div class="personal-details-items" v-if="editMode == false">
    <div class="title-container">
      <span class="title">RESEARCH STUDIES, RESEARCH PROJECTS AND BOOK PUBLISHED</span>
    </div>
    <div
      v-for="userStud in personalDetails.user_studies"
      :key="userStud.id"
      class="form-group"
    >
      <label> {{ userStud.research_title }}</label>
      <span>
        {{ userStud.date_published }} || {{ userStud.journal_name }} ||
        {{ userStud.link }}
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
      this.userDetails.user_studies.push({
        date_published: "",
        research_title: "",
        journal_name: "",
        link: "",
      });
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_studies = newVal.user_studies || [];
      },
      immediate: true,
    },
  },
};
</script>
