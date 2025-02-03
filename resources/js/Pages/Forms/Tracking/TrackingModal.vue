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
.hidden {
  display: none;
}

.flex {
  display: flex;
}
.modal {
  position: fixed;
  z-index: 100;
  justify-content: center;
  align-items: center;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.2);
}

.modal-content {
  background-color: #fff;
  display: flex;
  flex-direction: column;
  position: relative;
  margin: 10px;
  border-radius: 5px;
  box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.2);
}

@font-face {
  font-family: "RM New Albion";
  src: url("/public/assets/fonts/rm_new_albion.woff") format("woff");
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-left: 2px;
  padding-right: 10px;
}
.modal-header {
  padding: 5px;
  border-bottom: 1px solid #b5b5b5;
}
.modal-header .title {
  font-size: 18pt !important;
  margin-left: 10px;
}

.x-btn {
  font-size: 18pt !important;
  opacity: 50%;
  font-weight: bold;
}

.x-btn:hover {
  opacity: 100%;
  cursor: pointer;
}

.heading-container {
  display: flex;
  justify-content: center;
  align-items: end;
  gap: 1rem;
  padding: 10px;
  border-bottom: 1px solid #adadad;
}

.heading-container img {
  width: 80px;
}

.heading-text {
  display: flex;
  flex-direction: column;
  text-align: center;
}

.heading-text .first {
  font-family: RM New Albion;
  font-size: 50pt !important;
}

.heading-text .second {
  font-size: 12pt !important;
  font-weight: bold;
}

.heading-text .third {
  font-size: 12pt !important;
  font-weight: bold;
}
.title {
  text-align: center;
}

.section-user-info {
  display: flex;
  flex-wrap: wrap;
  gap: 1.2rem;
  padding: 10px;
}

.section-user-info label {
  font-weight: bold;
}

.section-details {
  padding: 10px;
}

.section-details label {
  font-weight: bold;
}

.section-budget {
  display: flex;
  justify-content: space-between;
  padding: 10px;
}

.amount {
  padding: 10px;
}
.amount label {
  font-weight: bold;
}
.modal-footer {
  display: flex;
  justify-content: center;
  padding: 10px;
}

.modal-footer button {
  padding: 10px;
  background-color: rgb(106, 106, 106);
  border: none;
  color: #fff;
  border-radius: 5px;
  opacity: 75%;
}

.modal-footer button:hover {
  opacity: 100%;
  cursor: pointer;
}
</style>
