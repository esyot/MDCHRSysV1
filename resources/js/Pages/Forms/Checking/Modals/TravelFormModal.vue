<script>
export default {
  emits: ["toggleFormModal"],
  props: {
    formData: Object,
    selected_id: String,
    selected_type: String,
    roles: Array,
  },
  methods: {
    toggleFormModal() {
      this.$emit("toggleFormModal");
    },
  },
};
</script>

<template>
  <div class="modal" @click.self="toggleFormModal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="title">Travel Form</span>
        <span @click="toggleFormModal" class="x-btn">&times;</span>
      </div>
      <div class="heading-container">
        <div class="heading-img">
          <img src="/public/assets/images/mdc-logo.png" alt="MDC LOGO" />
        </div>
        <div class="heading-text">
          <text class="first">Mater Dei College</text>
          <text class="second">Tubigon, Bohol</text>
          <text class="third">HUMAN RESOURCE OFFICE</text>
        </div>
      </div>

      <text class="title">Details of Official Travel</text>

      <div class="section-details">
        <div class="item">
          <label>Date(s) of Travel: </label>
          <span>Start: {{ formData.date_start }} End: {{ formData.date_end }} </span>
        </div>

        <div class="item">
          <label>Place: </label>
          <span>{{ formData.place }}</span>
        </div>
        <div class="item">
          <label>Purpose/Event: </label>
          <span>{{ formData.purpose }}</span>
        </div>
        <div class="item">
          <label>Contact Person: </label>
          <span>{{ formData.contact_person }} - {{ formData.contact_person_no }}</span>
        </div>
        <div class="item">
          <label>Short Description: </label>
          <span class="item">
            {{ formData.description }}
          </span>
        </div>
      </div>

      <text class="title">Substitutes:</text>

      <div class="substitute-details">
        <div class="substitute-item" v-if="formData.substitutes.length != 0">
          <span v-for="substitute in formData.substitutes">
            {{ substitute.user.last_name }}, {{ substitute.user.first_name }} -
            {{ substitute.subject }}
          </span>
        </div>
      </div>

      <text class="title">Budgetary Requirements</text>
      <div class="section-budget">
        <div class="left-side">
          <span class="title">Budget type:</span>
          <div class="mb-2">
            <input
              type="checkbox"
              id="registration"
              name="budget_requirement"
              value="registration"
              :checked="formData.budget_type === 'Registration'"
              readonly
            />
            <label for="registration">Registration</label>
          </div>
          <div class="mb-2">
            <input
              type="checkbox"
              id="transportation"
              name="budget_requirement"
              value="transportation"
              :checked="formData.budget_type === 'Transportation'"
              readonly
            />
            <label for="transportation">Transportation</label>
          </div>
          <div class="mb-2">
            <input
              type="checkbox"
              id="representation"
              name="budget_requirement"
              value="representation"
              :checked="formData.budget_type === 'Representation Allowance'"
              readonly
            />
            <label for="representation">Representation Allowance</label>
          </div>
          <div>
            <input
              type="checkbox"
              id="miscellaneous"
              name="budget_requirement"
              value="miscellaneous"
              :checked="formData.budget_type === 'Miscellaneous'"
              readonly
            />
            <label for="miscellaneous">Miscellaneous</label>
          </div>
        </div>
        <span class="title">Budget charged to:</span>
        <div class="right-side">
          <div>
            <div class="mb-2">
              <input
                type="checkbox"
                id="departmental-fund"
                name="budget_charged"
                value="departmental-fund"
              />
              <label for="departmental-fund">Departmental Fund</label>
            </div>
            <div class="mb-2">
              <input
                type="checkbox"
                id="departmental-office-budget"
                name="budget_charged"
                value="departmental-office-budget"
                :checked="formData.budget_charged_to == 'Departmental/Office Fund'"
              />
              <label for="departmental-office-budget">Departmental/Office Fund</label>
            </div>

            <div class="mb-2">
              <input
                type="checkbox"
                id="school-fund"
                name="budget_charged"
                value="school-fund"
                :checked="formData.budget_charged_to == 'School Fund'"
              />
              <label for="school-fund">School Fund</label>
            </div>
          </div>
        </div>
      </div>
      <div class="amount">
        <label for="total">Total amount requested: </label>
        <span class="underline"> ₱ {{ formData.amount }}.00 only </span>
      </div>

      <div class="btn-container">
        <button class="close-btn" @click="toggleFormModal">Close</button>
        <button class="submit-btn" @click="toggleFormModal">Submit</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/travel-form-modal.css";
</style>
