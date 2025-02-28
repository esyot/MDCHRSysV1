<style scoped>
@import "./css/form.css";
</style>

<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">REFERENCES FORM </span>
      <small
        >(Note: Person not related by consanguinity or affinity to
        applicant/appointee.)</small
      >
    </div>

    <div class="add-field-btn">
      <button @click="addField">Add Field</button>
    </div>

    {{ console.log(userDetails.user_references) }}
    <div
      v-for="(userRef, index) in userDetails.user_references"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="name">NAME:</label>
        <input
          type="text"
          name="name"
          id="name"
          v-model="userRef.name"
          class="form-control"
          placeholder="eg., Reinhard Esteban"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>
      <div class="form-group">
        <label for="house_no">House No:</label>
        <input
          type="text"
          name="house_no"
          id="house_no"
          v-model="userRef.address.house_no"
          class="form-control"
          placeholder="eg., 123"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="street">Street:</label>
        <input
          type="text"
          name="street"
          id="street"
          v-model="userRef.address.street"
          class="form-control"
          placeholder="eg., Joselle Street"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="subdv">Subdivision:</label>
        <input
          type="text"
          name="subdv"
          id="subdv"
          v-model="userRef.address.subdv"
          class="form-control"
          placeholder="eg., Reinhard Exclusive Subdivision"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="brgy">Barangay:</label>
        <input
          type="text"
          name="brgy"
          id="brgy"
          v-model="userRef.address.brgy"
          class="form-control"
          placeholder="eg., Ilijan Sur"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="municipality">Municipality:</label>
        <input
          type="text"
          name="municipality"
          id="municipality"
          v-model="userRef.address.municipality"
          class="form-control"
          placeholder="eg., Tubigon"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="province">Province:</label>
        <input
          type="text"
          name="province"
          id="province"
          v-model="userRef.address.province"
          class="form-control"
          placeholder="eg., Bohol"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="zip_code">Zip Code:</label>
        <input
          type="text"
          name="zip_code"
          id="zip_code"
          v-model="userRef.address.zip_code"
          class="form-control"
          placeholder="eg., 6329"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>

      <div class="form-group">
        <label for="contact_no">CONTACT NUMBER:</label>
        <input
          type="text"
          name="contact_no"
          id="contact_no"
          v-model="userRef.contact_no"
          class="form-control"
          placeholder="eg., 0917-123-4567"
          @input="handleFieldFocus(`user_references`)"
        />
      </div>
      <button
        v-if="
          userRef.name == '' &&
          userRef.contact_no == '' &&
          userRef.address.house_no == '' &&
          userRef.address.street == '' &&
          userRef.address.subdv == '' &&
          userRef.address.brgy == '' &&
          userRef.address.municipality == '' &&
          userRef.address.province == '' &&
          userRef.address.zip_code == ''
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
      <span class="title">REFERENCES</span>
    </div>
    <div
      v-for="userRef in personalDetails.user_references"
      :key="userRef.id"
      class="form-group"
    >
      <label> {{ userRef.name }}</label>
      <span> {{ userRef.contact_no }} || </span>
      <span>{{ userRef.address.house_no }}</span>
      <span>{{ userRef.address.street }}</span>
      <span>{{ userRef.address.subdv }}</span>
      <span>{{ userRef.address.brgy }}</span>
      <span>{{ userRef.address.municipality }}</span>
      <span>{{ userRef.address.province }}</span>
      <span>{{ userRef.address.zip_code }}</span>
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
      this.userDetails.user_references.push({
        name: "",
        contact_no: "",
        address: {
          house_no: "",
          street: "",
          subdv: "",
          brgy: "",
          municipality: "",
          province: "",
          zip_code: "",
        },
      });
    },

    removeField(index) {
      this.userDetails.user_references.splice(index, 1);
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        this.userDetails.user_references = newVal.user_references || [];
      },
      immediate: true,
    },
  },
};
</script>
