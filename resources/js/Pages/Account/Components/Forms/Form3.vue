<style scoped>
@import "./css/form.css";
</style>

<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">EDUCATIONAL BACKGROUND FORM</span>
    </div>

    <div class="form-group">
      <label for="level">SELECT LEVEL:</label>
      <select v-model="educLevel" class="select-field">
        <option value="" selected disabled>Select Type</option>
        <option value="elem">Elementary</option>
        <option value="sec">Secondary</option>
        <option value="college">College</option>
        <option value="gs">Graduate Study</option>
        <option value="pgs">Post Graduate Study</option>
      </select>
    </div>

    <div v-if="educLevel">
      <div v-if="filteredEduc.length > 0" v-for="educ in filteredEduc" :key="educ.id">
        <div class="form-group">
          <label for="school_name">{{ selectedLevel.toUpperCase() }} SCHOOL NAME:</label>
          <input
            type="text"
            v-model="educ.school_name"
            class="form-control"
            :placeholder="`e.g. St. Paul College, University of the Philippines ${educ.school_name}`"
            :id="`school_name_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div class="form-group">
          <label for="school_address"
            >{{ selectedLevel.toUpperCase() }} SCHOOL ADDRESS:</label
          >
          <input
            type="text"
            v-model="educ.school_address"
            class="form-control"
            :placeholder="`e.g. 1234, 5th Street, Brgy. San Isidro, Poblacion, Cebu City, etc. ${educ.school_address}`"
            :id="`school_address_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div
          class="form-group"
          v-if="educLevel === 'college' || educLevel === 'gs' || educLevel === 'pgs'"
        >
          <label for="course">COURSE:</label>
          <input
            type="text"
            v-model="educ.course"
            class="form-control"
            :placeholder="`e.g, Bachelor of Science and Information Technology ${educ.course}`"
            :id="`course_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div class="form-group">
          <label for="period_attendance_from">PERIOD ATTENDANCE FROM:</label>
          <input
            type="date"
            v-model="educ.period_attendance_from"
            class="form-control"
            :placeholder="`e.g, 12-12-2000 ${educ.period_attendance_from}`"
            :id="`period_attendance_from_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div class="form-group">
          <label for="period_attendance_to">PERIOD ATTENDANCE TO:</label>
          <input
            type="date"
            v-model="educ.period_attendance_to"
            class="form-control"
            :placeholder="`e.g, 12-12-2000 ${educ.period_attendance_to}`"
            :id="`period_attendance_to_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div
          class="form-group"
          v-if="educLevel === 'college' || educLevel === 'gs' || educLevel === 'pgs'"
        >
          <label for="units">{{ educLevel.toUpperCase() }} UNITS:</label>
          <input
            type="number"
            v-model="educ.units"
            class="form-control"
            :placeholder="`e.g, 12-12-2000 ${educ.units}`"
            :id="`units_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div class="form-group">
          <label for="year_graduated"
            >YEAR GRADUATED FROM {{ educLevel.toUpperCase() }}:</label
          >
          <input
            type="number"
            min="1600"
            max="3000"
            v-model="educ.year_graduated"
            class="form-control"
            :placeholder="`e.g, 2000 ${educ.year_graduated}`"
            :id="`year_graduated_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>

        <div class="form-group">
          <label for="acad_honors_received">SCHOLARSHIP/ACADEMIC HONORS RECEIVED:</label>
          <input
            type="text"
            v-model="educ.acad_honors_received"
            class="form-control"
            :placeholder="`e.g. Dean's Lister, etc. ${educ.acad_honors_received}`"
            :id="`acad_honors_received_${educ.id}`"
            @input="handleFieldFocus(`user_educational_backgrounds`)"
          />
        </div>
      </div>
      <div v-else>
        <div class="form-group">
          <label for="school_name">{{ selectedLevel.toUpperCase() }} SCHOOL NAME:</label>
          <input
            type="text"
            v-model="personalDetails.user_educational_backgrounds.school_name"
            class="form-control"
            placeholder="e.g. St. Paul College, University of the Philippines, etc."
          />
        </div>

        <div class="form-group">
          <label for="school_address"
            >{{ selectedLevel.toUpperCase() }} SCHOOL ADDRESS:</label
          >
          <input
            type="text"
            v-model="personalDetails.user_educational_backgrounds.school_address"
            class="form-control"
            placeholder="e.g. 1234, 5th Street, Brgy. San Isidro, Poblacion, Cebu City, etc."
          />
        </div>

        <div
          class="form-group"
          v-if="educLevel === 'college' || educLevel === 'gs' || educLevel === 'pgs'"
        >
          <label for="course">COURSE:</label>
          <input
            type="text"
            v-model="personalDetails.user_educational_backgrounds.course"
            class="form-control"
            placeholder="e.g. N/A"
          />
        </div>

        <div class="form-group">
          <label for="period_attendance_from">PERIOD ATTENDANCE FROM:</label>
          <input
            type="date"
            v-model="personalDetails.user_educational_backgrounds.period_attendance_from"
            class="form-control"
            placeholder="e.g. 2020-01-01"
          />
        </div>

        <div class="form-group">
          <label for="period_attendance_to">PERIOD ATTENDANCE TO:</label>
          <input
            type="date"
            v-model="personalDetails.user_educational_backgrounds.period_attendance_to"
            class="form-control"
            placeholder="e.g. 2020-01-01"
          />
        </div>

        <div
          class="form-group"
          v-if="educLevel === 'college' || educLevel === 'gs' || educLevel === 'pgs'"
        >
          <label for="units">{{ educLevel.toUpperCase() }} UNITS:</label>
          <input
            type="number"
            v-model="personalDetails.user_educational_backgrounds.units"
            class="form-control"
            placeholder="e.g. 60"
          />
        </div>

        <div class="form-group">
          <label for="year_graduated"
            >YEAR GRADUATED FROM {{ educLevel.toUpperCase() }}:</label
          >
          <input
            type="date"
            v-model="personalDetails.user_educational_backgrounds.year_graduated"
            class="form-control"
            placeholder="e.g. 2020"
          />
        </div>

        <div class="form-group">
          <label for="acad_honors_received">SCHOLARSHIP/ACADEMIC HONORS RECEIVED:</label>
          <input
            type="text"
            v-model="personalDetails.user_educational_backgrounds.acad_honors_received"
            class="form-control"
            placeholder="e.g. Dean's Lister, etc."
          />
        </div>
      </div>
    </div>
  </div>

  <div class="personal-details-items" v-if="!editMode">
    <div class="title-container">
      <span class="title">EDUCATIONAL BACKGROUND</span>
    </div>
    <div
      v-for="userEduc in personalDetails.user_educational_backgrounds"
      :key="userEduc.id"
      class="form-group"
    >
      <label>{{ userEduc.level.toUpperCase() }}</label>
      <span>
        {{ userEduc.school_name }} || {{ userEduc.school_address }} ||
        {{ userEduc.course }} || {{ userEduc.year_graduated }} ||
        {{ userEduc.acad_honors_received }} ||
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
  data() {
    return {
      educLevel: "",
      newEducation: {
        school_name: "",
        school_address: "",
        course: "",
        units: "",
        year_graduated: "",
        acad_honors_received: "",
      },
    };
  },
  computed: {
    selectedLevel() {
      switch (this.educLevel) {
        case "elem":
          return "elementary";
        case "sec":
          return "secondary";
        case "college":
          return "college";
        case "gs":
          return "graduate study";
        case "pgs":
          return "post graduate study";
        default:
          return "";
      }
    },
    filteredEduc() {
      const existingEducation = this.userDetails.user_educational_backgrounds.filter(
        (educ) => educ.level === this.educLevel
      );

      if (existingEducation.length === 0) {
        const newEducation = {
          level: this.educLevel,
          school_name: (this.school_name = ""),
          school_address: (this.school_address = ""),
          course: (this.course = ""),
          units: (this.units = ""),
          year_graduated: (this.year_graduated = ""),
          acad_honors_received: (this.acad_honors_received = ""),
        };

        this.userDetails.user_educational_backgrounds.push(newEducation);
        return [newEducation];
      }
      return existingEducation;
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
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_educational_backgrounds =
          newVal.user_educational_backgrounds || [];
      },
      immediate: true,
    },
  },
};
</script>
