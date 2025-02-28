<style scoped>
@import "./css/form.css";
</style>

<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">USER VALID IDs FORM</span>
    </div>

    <div class="form-group">
      <label for="id_type">ID TYPE:</label>
      <select id="id_type" name="id_type" v-model="selectedId" class="select-field">
        <option value="">Select Type</option>
        <option value="SSS">SSS</option>
        <option value="PAG-IBIG">PAG-IBIG</option>
        <option value="PHILHEALTH">PHILHEALTH</option>
        <option value="TIN">TIN</option>
        <option value="DRIVER'S LICENSE">DRIVER'S LICENSE</option>
        <option value="PASSPORT">PASSPORT</option>
        <option value="GOVERNMENT ISSUED">GOVERNMENT ISSUED</option>
      </select>
    </div>

    <div v-if="selectedId" class="form-group">
      <div v-if="filteredID.length > 0" v-for="Id in filteredID" :key="Id.id">
        <div class="form-group">
          <label for="id_no">{{ selectedId.toUpperCase() }} NO:</label>
          <input
            type="text"
            v-model="Id.id_no"
            class="form-control"
            :placeholder="`e.g. Enter ID No. ${Id.id_no}`"
            :id="`id_no_${Id.id_no}`"
            @input="handleFieldFocus(`user_valid_ids`)"
          />
        </div>
        <div class="form-group">
          <label for="date_issued">{{ selectedId.toUpperCase() }} DATE ISSUED:</label>
          <input
            type="date"
            v-model="Id.date_issued"
            class="form-control"
            :placeholder="`e.g. Enter date issued. ${Id.date_issued}`"
            :id="`date_issued_${Id.date_issued}`"
            @input="handleFieldFocus(`user_valid_ids`)"
          />
        </div>
        <div class="form-group">
          <label for="date_expiry">{{ selectedId.toUpperCase() }} DATE EXPIRY:</label>
          <input
            type="date"
            v-model="Id.date_expiry"
            class="form-control"
            :placeholder="`e.g. Enter expiry date. ${Id.date_expiry}`"
            :id="`date_expiry_${Id.date_expiry}`"
            @input="handleFieldFocus(`user_valid_ids`)"
          />
        </div>
      </div>
    </div>
  </div>
  <div class="personal-details-items" v-if="!editMode">
    <div class="title-container">
      <span class="title">USER VALID IDs</span>
    </div>
    <div
      v-for="userValidIds in personalDetails.user_valid_ids"
      :key="userValidIds.id"
      class="form-group"
    >
      <label>{{ userValidIds.id_type }}</label>
      <span>
        {{ userValidIds.id_no }} || {{ userValidIds.date_issued }} ||
        {{ userValidIds.date_expiry }}
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
      selectedId: "",
      newId: {
        id_no: "",
        date_issued: "",
        date_expiry: "",
      },
    };
  },
  computed: {
    filteredID() {
      return this.userDetails.user_valid_ids.filter(
        (id) => id.id_type === this.selectedId
      );
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
    selectedId(newVal) {
      if (
        newVal &&
        !this.userDetails.user_valid_ids.some((id) => id.id_type === newVal)
      ) {
        this.userDetails.user_valid_ids.push({
          id_type: newVal,
          id_no: "",
          date_issued: "",
          date_expiry: "",
        });
      }
    },
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_valid_ids = [...(newVal.user_valid_ids || [])];
      },
      immediate: true,
    },
  },
};
</script>
