<script>
export default {
  emits: ["toggleFormModal"],
  props: {
    forms: Object,
    selected_id: String,
  },
  data() {
    return {
      modal_id: this.selected_id ?? null,
    };
  },
  watch: {
    selected_id(newVal) {
      this.modal_id = newVal;
    },
    modal_id(newVal, oldVal) {
      if (oldVal) {
        document.getElementById("modal-" + oldVal).classList.add("hidden");
        document.getElementById("modal-" + oldVal).classList.remove("flex");
      }
      if (newVal) {
        document.getElementById("modal-" + newVal).classList.remove("hidden");
        document.getElementById("modal-" + newVal).classList.add("flex");
      }
    },
  },
  methods: {
    closeFormModal() {
      this.$emit("toggleFormModal", this.selected_id);
    },
  },
};
</script>

<template>
  <div
    :id="'modal-' + formData.id"
    class="hidden modal"
    v-for="formData in forms"
    :key="formData.id"
  >
    <div class="modal-content">
      <div class="modal-header">
        <span class="title">Preview</span>
        <span @click="closeFormModal" class="x-btn">&times;</span>
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
      <h3 class="title">Travel Application Form</h3>
      <div class="section-user-info">
        <label>Office/Department: </label>

        <span v-for="department in formData.departments" :key="department">
          {{ department.name }}
        </span>

        <label>Last Name: </label>

        <span>{{ formData.last_name }}</span>

        <label>First Name: </label>
        <span>{{ formData.first_name }}</span>

        <label>Middle Name: </label>
        <span>{{ formData.middle_name }}</span>
      </div>
      <div class="section-user-info">
        <label>Date of Filing: </label>
        <span>{{ formData.filing_date }}</span>

        <label>Position: </label>
        <span>{{ formData.position }}</span>
        <label>Rank: </label>
        <span>{{ formData.rank }}</span>
      </div>

      <h3 class="title">Details of Official Travel</h3>

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

      <h3 class="title">Budgetary Requirements</h3>
      <div class="section-budget">
        <div class="left-side">
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

        <div class="right-side">
          <div>
            <label class="block font-bold mb-2">Budget charged to:</label>
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

      <div class="modal-footer">
        <button @click="closeFormModal">Close</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./tracking-modal.css";
</style>
