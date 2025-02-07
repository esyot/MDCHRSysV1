<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">OTHER INFORMATION</span>
    </div>
    <div class="add-field-btn">
      <button @click="addField">Add Field</button>
    </div>
    <div
      v-for="(userOtherInfo, index) in userDetails.user_other_infos"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="skill">SPECIAL SKILLS & HOBBIES:</label>
        <input
          type="text"
          name="skills"
          id="skills"
          v-model="userOtherInfo.skill"
          class="form-control"
          placeholder="eg., Singing, Dancing, Martial Arts, etc."
          @input="handleFieldFocus(`user_other_infos`)"
        />
      </div>
      <div class="form-group">
        <label for="recognition_title"
          >NON-ACADEMIC DITICNTIONS/RECOGNITION (Write in Full):</label
        >
        <input
          type="text"
          name="recognition_title"
          id="recognition_title"
          v-model="userOtherInfo.recognition_title"
          class="form-control"
          placeholder="eg., Best Student, Best Athlete, etc."
          @input="handleFieldFocus(`user_other_infos`)"
        />
      </div>
      <div class="form-group">
        <label for="org_name"
          >MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in Full):</label
        >
        <input
          type="text"
          name="org_name"
          id="org_name"
          v-model="userOtherInfo.org_name"
          class="form-control"
          placeholder="eg., Rotary Club, Lions Club, etc."
          @input="handleFieldFocus(`user_other_infos`)"
        />
      </div>
      <button
        v-if="
          userOtherInfo.skill == '' &&
          userOtherInfo.org_name == '' &&
          userOtherInfo.recognition_title == ''
        "
        @click="removeField(index)"
        class="remove-btn"
      >
        Remove
      </button>
      <hr />
    </div>
  </div>
  <div class="personal-details-items" v-if="!editMode">
    <div class="title-container">
      <span class="title">OTHER INFORMATION</span>
    </div>
    <div
      v-for="userOtherInfo in personalDetails.user_other_infos"
      :key="userOtherInfo.id"
      class="form-group"
    >
      <label> {{ userOtherInfo.org_name }}</label>
      <span>
        {{ userOtherInfo.recognition_title }} ||
        {{ userOtherInfo.skill }}
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
      this.userDetails.user_other_infos.push({
        skill: "",
        recognition_title: "",
        org_name: "",
      });
    },

    removeField(index) {
      this.userDetails.user_other_infos.splice(index, 1);
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_other_infos = newVal.user_other_infos || [];
      },
      immediate: true,
    },
  },
};
</script>

<style scoped>
.remove-btn {
  margin-top: 10px;
  color: red;
  background: none;
  border: 1px solid red;
  cursor: pointer;
  padding: 5px 10px;
}

.remove-btn:hover {
  background-color: red;
  color: white;
}

.form-group {
  margin-bottom: 10px;
}

.add-field-btn {
  margin-bottom: 20px;
}

.title-container .title {
  font-weight: bold;
  font-size: 18px;
}

input.form-control {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
}
</style>
