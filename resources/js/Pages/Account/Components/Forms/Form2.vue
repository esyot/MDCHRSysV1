<style scoped>
@import "./css/form.css";
</style>

<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">FAMILY BACKGROUND</span>
    </div>
    <div class="form-group">
      <label for="type">SELECT FAMILY MEMBER:</label>
      <select v-model="selectedFamilyType" class="select-field">
        <option value="spouse">Spouse</option>
        <option value="father">Father</option>
        <option value="mother">Mother</option>
        <option value="child">Children</option>
      </select>
    </div>

    <div v-if="selectedFamilyType">
      <div
        v-if="filteredFamily.length > 0"
        v-for="family in filteredFamily"
        :key="family.id"
      >
        <div class="form-group">
          <label :for="`last_name_${family.id}`"
            >{{ family.type.toUpperCase() }} SURNAME:</label
          >
          <input
            type="text"
            v-model="family.last_name"
            :placeholder="`e.g. ${family.last_name}`"
            :id="`last_name_${family.id}`"
            @input="handleFieldFocus(`user_families`)"
          />
        </div>

        <div class="form-group">
          <label :for="`first_name_${family.id}`"
            >{{ family.type.toUpperCase() }} FIRST NAME:</label
          >
          <input
            type="text"
            v-model="family.first_name"
            :placeholder="`e.g. ${family.first_name}`"
            :id="`first_name_${family.id}`"
            @input="handleFieldFocus(`user_families`)"
          />
        </div>

        <div class="form-group">
          <label :for="`middle_name_${family.id}`"
            >{{ family.type.toUpperCase() }} MIDDLE NAME:</label
          >
          <input
            type="text"
            v-model="family.middle_name"
            :placeholder="`e.g. ${family.middle_name}`"
            :id="`middle_name_${family.id}`"
            @input="handleFieldFocus(`user_families`)"
          />
        </div>

        <div class="form-group">
          <label :for="`ext_${family.id}`"
            >{{ family.type.toUpperCase() }} NAME EXTENSION:</label
          >
          <input
            type="text"
            v-model="family.ext"
            :placeholder="`e.g. ${family.ext}`"
            :id="`ext_${family.id}`"
            @input="handleFieldFocus(`user_families`)"
          />
        </div>
        <div class="form-group">
          <label :for="`DOB_${family.id}`"
            >{{ family.type.toUpperCase() }} Date of Birth:</label
          >
          <input
            type="date"
            v-model="family.DOB"
            :placeholder="`e.g. ${family.DOB}`"
            :id="`DOB_${family.id}`"
            @input="handleFieldFocus(`user_families`)"
          />
        </div>

        <div class="form-group" v-if="family.type === 'spouse'">
          <label for="occupation">SPOUSE OCCUPATION:</label>
          <input
            type="text"
            v-model="family.occupation"
            placeholder="e.g. Teacher, Engineer, Doctor, etc."
            @input="handleFieldFocus('user_families')"
          />
        </div>

        <div class="form-group" v-if="family.type === 'mother'">
          <label for="maiden_name">MOTHER'S MAIDEN NAME:</label>
          <input
            type="text"
            v-model="family.maiden_name"
            placeholder="e.g. Caingles"
            @input="handleFieldFocus('user_families')"
          />
        </div>
        <hr v-show="selectedFamilyType === 'child'" />
      </div>

      <div v-else>
        <div class="form-group">
          <label>{{ selectedFamilyType.toUpperCase() }} SURNAME:</label>
          <input
            type="text"
            v-model="newFamily.last_name"
            placeholder="e.g. Esteban"
            @input="handleFieldFocus('user_families')"
          />
        </div>

        <div class="form-group">
          <label>{{ selectedFamilyType.toUpperCase() }} FIRST NAME:</label>
          <input
            type="text"
            v-model="newFamily.first_name"
            placeholder="e.g. Reinhard"
            @input="handleFieldFocus('user_families')"
          />
        </div>

        <div class="form-group">
          <label>{{ selectedFamilyType.toUpperCase() }} MIDDLE NAME:</label>
          <input
            type="text"
            v-model="newFamily.middle_name"
            placeholder="e.g. Lanoy"
            @input="handleFieldFocus('user_families')"
          />
        </div>

        <div class="form-group">
          <label>{{ selectedFamilyType.toUpperCase() }} NAME EXTENSION:</label>
          <input
            type="text"
            v-model="newFamily.ext"
            placeholder="e.g. Jr., Sr., III, etc."
            @input="handleFieldFocus('user_families')"
          />
        </div>

        <div class="form-group" v-if="selectedFamilyType === 'spouse'">
          <label for="occupation">SPOUSE OCCUPATION:</label>
          <input
            type="text"
            v-model="newFamily.occupation"
            placeholder="e.g. Teacher, Engineer, Doctor, etc."
            @input="handleFieldFocus('user_families')"
          />
        </div>

        <div class="form-group" v-if="selectedFamilyType === 'mother'">
          <label for="maiden_name">MOTHER'S MAIDEN NAME:</label>
          <input
            type="text"
            v-model="newFamily.maidenName"
            placeholder="e.g. Caingles"
            @input="handleFieldFocus('user_families')"
          />
        </div>
      </div>
    </div>
    <div class="add-field-btn" v-if="selectedFamilyType === 'child'" @click="addChild">
      <button>+ Add Another Child</button>
    </div>
  </div>

  <div class="personal-details-items" v-if="!editMode">
    <div class="title-container">
      <span class="title">FAMILY BACKGROUND:</span>
    </div>

    <div
      v-for="userFamily in personalDetails.user_families"
      :key="userFamily.id"
      class="form-group"
    >
      <label
        >{{ userFamily.type.charAt(0).toUpperCase() + userFamily.type.slice(1) }}
        Name:
      </label>
      <span>
        {{ userFamily.first_name }}
        {{ userFamily.middle_name }}
        {{ userFamily.last_name }}
        {{ userFamily.ext }}
      </span>

      <label>Occupation: </label>
      <span>{{ userFamily.occupation }}</span>
      <label>Date of Birth: </label>
      <span>{{ userFamily.DOB }}</span>
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
  data() {
    return {
      selectedFamilyType: "spouse",
      newFamily: {
        first_name: "",
        last_name: "",
        middle_name: "",
        ext: "",
        occupation: "",
        maidenName: "",
        DOB: "",
      },
    };
  },
  computed: {
    filteredFamily() {
      const existingFamily = this.userDetails.user_families.filter(
        (family) => family.type === this.selectedFamilyType
      );

      if (existingFamily.length === 0) {
        this.userDetails.user_families.push({
          type: this.selectedFamilyType,
          last_name: this.newFamily.last_name,
          first_name: this.newFamily.first_name,
          middle_name: this.newFamily.middle_name,
          ext: this.newFamily.ext,
          occupation: this.newFamily.occupation,
          DOB: this.newFamily.DOB,
        });

        return [this.newFamily];
      }

      return existingFamily;
    },
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
    addChild() {
      this.userDetails.user_families.push({
        type: "child",
        last_name: "",
        first_name: "",
        middle_name: "",
        ext: "",
        DOB: "",
      });
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_families = newVal.user_families || [];
      },
      immediate: true,
    },
  },
};
</script>
