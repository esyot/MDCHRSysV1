<script>
export default {
  emits: ["toggleFormModal"],
  props: {
    forms: Object,
    selected_id: String,
    selected_type: String,
  },
  data() {
    return {
      modal_id: this.selected_id ?? null,
      modal_type: this.selected_type ?? null,
    };
  },
  watch: {
    selected_id(newVal) {
      this.modal_id = newVal;
    },

    selected_type(newVal, oldVal) {
      this.modal_type = newVal ?? oldVal;
    },
    modal_id(newVal, oldVal) {
      if (oldVal) {
        const modalId = `modal-${this.modal_type
          .toLowerCase()
          .replace(" ", "-")}-${oldVal}`;

        document.getElementById(modalId).classList.add("hidden");
        document.getElementById(modalId).classList.remove("flex");
      }

      if (newVal) {
        const modalId = `modal-${this.modal_type
          .toLowerCase()
          .replace(" ", "-")}-${newVal}`;

        document.getElementById(modalId).classList.remove("hidden");
        document.getElementById(modalId).classList.add("flex");
      }
    },
  },
  methods: {
    closeFormModal() {
      this.$emit("toggleFormModal", this.selected_id, this.selected_type);
    },
  },
  computed: {
    travelForms() {
      return this.forms.filter((item) => item.form_type === "Travel Form");
    },
    leaveForms() {
      return this.forms.filter((item) => item.form_type === "Leave Form");
    },
  },
};
</script>

<template>
  <div
    :id="'modal-travel-form-' + formData.id"
    class="hidden modal"
    v-for="formData in travelForms"
    :key="formData.id"
    @click.self="closeFormModal"
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

  <div
    :id="'modal-leave-form-' + formData.id"
    class="hidden modal"
    v-for="formData in leaveForms"
    :key="formData"
    @click.self="closeFormModal"
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
      <h3 class="title">Leave Application Form</h3>
      <span class="sub-title">Leave type</span>
      <div class="content-details">
        <div class="row">
          <div class="radio-group">
            <label
              ><input
                type="radio"
                :checked="formData.leave_type === 'Personal'"
                name="leave_type"
              />
              Personal
            </label>
            <label
              ><input
                type="radio"
                :checked="formData.leave_type == 'Maternity'"
                name="leave_type"
              />
              Maternity</label
            >
            <label
              ><input
                type="radio"
                :checked="formData.leave_type == 'Paternity'"
                name="leave_type"
              />
              Paternity Leave</label
            >

            <label
              ><input
                type="radio"
                :checked="formData.leave_type == 'Sick'"
                name="leave_type"
              />
              Sick Leave</label
            >
            <label
              ><input
                type="radio"
                :checked="formData.leave_type == 'Educational'"
                name="leave_type"
              />
              Educational Leave</label
            >
            <label>
              <input type="radio" name="leave_type" /> Others: <input type="text" />
            </label>
          </div>

          <div class="section-dates">
            <div class="input-group">
              <label for="date_start">Start date: </label>

              <input
                type="text"
                id="date_start"
                v-model="formData.date_start"
                name="date_start"
              />

              <label for="date_end">End date:</label>
              <input
                type="text"
                id="date_end"
                v-model="formData.date_end"
                name="date_end"
              />
            </div>
          </div>
        </div>
        <span class="sub-title">Details of Leave</span>
        <div class="container-details">
          <div class="radio-group" v-if="formData.leave_type_option == 'Vacation'">
            <span class="sub-title">Vacation:</span>
            <label
              ><input
                type="checkbox"
                class="sub-checkbox"
                :checked="formData.vacation_option === 'Within the Philippines'"
              />
              Within Philippines (Specify)
            </label>
            <input type="text" v-model="formData.address" />

            <label v-if="formData.vacation_option == 'Abroad'"
              ><input
                type="checkbox"
                class="sub-checkbox"
                name="vacation_abroad"
                :checked="formData.vacation_option === 'Abroad'" />
              Abroad (Specify):

              <input
                type="text"
                :value="formData.vacation_option === 'Abroad' ? formData.address : ''"
            /></label>
          </div>

          <div class="checkbox-group" v-if="formData.leave_type == 'Sick'">
            <span class="sub-title"> Incase of Sick Leave: </span>
            <label
              ><input
                type="checkbox"
                :checked="formData.convalescence_place == 'In Hospital'"
                class="sub-checkbox"
                name="sick_hospital"
              />
              Hospital:
            </label>
            <label
              ><input
                type="checkbox"
                :checked="formData.convalescence_place == 'Out Patient'"
                class="sub-checkbox"
              />
              Out Patient:
            </label>
            <label
              ><input
                type="checkbox"
                :checked="formData.convalescence_place == 'Home Medication'"
                class="sub-checkbox"
                name="sick_home"
              />
              Home Medication:
            </label>
          </div>
          <div class="checkbox-group" v-if="formData.leave_type == 'Educational'">
            <span class="sub-title">Incase of Educational Leave: </span>
            <label
              ><input type="checkbox" class="sub-checkbox" name="sick_hospital" />
              Completion of Doctor's Degree</label
            >
            <label
              ><input type="checkbox" class="sub-checkbox" name="sick_outpatient" />
              Completion of Master's Degree</label
            >
            <label
              ><input type="checkbox" class="sub-checkbox" name="sick_home" /> Board
              Examination Review</label
            >
          </div>
        </div>

        <div class="close-btn-container">
          <button @click="closeFormModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./tracking-modal.css";

.section-user-info {
  margin-bottom: 20px;
}

.section-user-info .user-info {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.user-info label {
  font-size: 16px;
}

.content-details {
  margin-top: 10px;
  padding: 5px;
}

.content-details .row {
  display: flex;
  justify-content: space-between;
}

.radio-group {
  pointer-events: none;
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding: 10px;
}

.radio-group label {
  font-size: 16px;
  display: flex;
  align-items: center;
}

.radio-group input[type="checkbox"] {
  margin-right: 10px;
}

.input-group {
  margin-bottom: 10px;
}

.input-group label {
  font-size: 16px;
  margin-bottom: 5px;
  display: block;
}

.input-group input {
  padding: 5px;
  font-size: 16px;
  width: 100%;
  box-sizing: border-box;
}

.section-dates {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  padding-right: 10px;
}

.container-details {
  display: flex;
  padding: 10px;
}

.sub-checkbox {
  margin-left: 15px;
}

.sub-checkbox + input[type="text"] {
  margin-top: 5px;
  padding: 5px;
  font-size: 16px;
}

span.sub-title {
  display: flex;
  margin-top: 8px;
  margin-left: 5px;
  font-size: 16px;
  font-weight: bold;
  padding-inline: 5px;
}

.close-btn-container {
  display: flex;
  justify-content: center;
  padding: 10px;
}

.close-btn-container button {
  padding: 10px;
  border: none;
  background-color: rgb(173, 160, 160);
  border-radius: 5px;
  opacity: 75%;
}

.close-btn-container button:hover {
  opacity: 100%;
  cursor: pointer;
}
.checkbox-group {
  pointer-events: none;
}
.section-dates {
  pointer-events: none;
}
</style>
