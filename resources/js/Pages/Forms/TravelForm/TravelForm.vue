<template>
  <form @submit.prevent="travelFormSubmit">
    <div class="forms-container">
      <div class="forms">
        <div class="forms-title">
          <span class="title">Travel details</span>
        </div>
        <div class="form-section">
          <label for="dates">Date Start of Travel:</label>
          <input
            type="date"
            id="dates"
            v-model="travelForm.date_start"
            class="form-control"
            required
          />
        </div>

        <div class="form-section">
          <label for="dates">Date End of Travel:</label>
          <input
            type="date"
            id="dates"
            v-model="travelForm.date_end"
            class="form-control"
            required
          />
        </div>

        <div class="form-section">
          <label for="place">Place:</label>
          <input
            type="text"
            id="place"
            v-model="travelForm.place"
            class="form-control"
            placeholder="Enter the place of travel"
            required
          />
        </div>

        <div class="form-section">
          <label for="purpose">Purpose/Event:</label>
          <input
            type="text"
            id="purpose"
            v-model="travelForm.purpose"
            class="form-control"
            placeholder="Enter the purpose or event"
            required
          />
        </div>

        <div class="form-section">
          <label for="contact_person">Contact Person:</label>
          <input
            type="text"
            id="contact_person"
            v-model="travelForm.contact_person"
            class="form-control"
            placeholder="Enter the organizer or contact person"
            required
          />
        </div>

        <div class="form-section">
          <label for="contact_person_no">Organizer/Contact Person's No:</label>
          <input
            type="text"
            id="contact_person_no"
            v-model="travelForm.contact_person_no"
            class="form-control"
            placeholder="Enter the organizer or contact person's contact number"
            required
          />
        </div>

        <div class="form-section">
          <label for="description">Short Description:</label>
          <textarea
            id="description"
            v-model="travelForm.description"
            class="form-control"
            placeholder="Enter a short description of the purpose or event"
            rows="4"
            required
          ></textarea>
        </div>
      </div>

      <div class="forms">
        <div class="forms-title">
          <span class="title">Budget Requirements</span>
        </div>

        <div class="forms-separation">
          <div class="grid">
            <div class="sub-section-title">
              <label class="section-title">Budget Type:</label>
            </div>

            <div class="radio-item" v-for="item in budgetTypes" :key="item.id">
              <input
                type="radio"
                :id="item.value"
                v-model="budget.selectedBudgetType"
                :value="item.value"
              />
              <label :for="item.id">{{ item.label }}</label>
            </div>
          </div>

          <div class="grid">
            <div class="sub-section-title">
              <label class="section-title">Budget Charged To:</label>
            </div>

            <div class="radio-item" v-for="item in budgetCharges" :key="item.id">
              <input
                type="radio"
                :id="item.value"
                v-model="budget.selectedChargedTo"
                :value="item.value"
              />
              <label :for="item.value">{{ item.label }}</label>
            </div>
          </div>
        </div>

        <div class="form-section">
          <label for="amount">Budget Amount:</label>
          <input
            type="number"
            id="amount"
            v-model="budget.amount"
            class="form-control"
            placeholder="Enter amount requested"
            required
          />
        </div>
        <div class="form-submit">
          <button class="submit" title="Submit for approval">
            <span> Submit</span>
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  props: {
    budgetTypes: Object,
    budgetCharges: Object,
    formData: Object,
  },
  data() {
    return {
      travelForm: {
        date_start: this.formData.date_start ?? "",
        date_end: this.formData.date_end ?? "",
        place: this.formData.place ?? "",
        purpose: this.formData.purpose ?? "",
        contact_person: this.formData.contact_person ?? "",
        contact_person_no: this.formData.contact_person_no ?? "",
        description: this.formData.description ?? "",
      },
      budget: {
        amount: this.formData.amount ?? "",
        selectedChargedTo: this.formData.budget_charged_to ?? "",
        selectedBudgetType: this.formData.budget_type ?? "",
        othersReason: "",
      },
    };
  },
  methods: {
    travelFormSubmit(event) {
      event.preventDefault();

      const formData = {
        date_start: this.travelForm.date_start,
        date_end: this.travelForm.date_end,
        description: this.travelForm.description,
        place: this.travelForm.place,
        purpose: this.travelForm.purpose,
        contact_person: this.travelForm.contact_person,
        contact_person_no: this.travelForm.contact_person_no,
        amount: this.budget.amount,
        budget_type: this.budget.selectedBudgetType,
        budget_charged_to: this.budget.selectedChargedTo,
        filing_date: this.formData.filing_date ?? new Date().toString().split("T")[0],
      };

      Inertia.get("/forms/travel-form-preview", formData);
    },
  },
  layout: Layout,
};
</script>

<style scoped>
.preview {
  background-color: rgb(33, 208, 33);
}
.submit {
  background-color: rgb(35, 134, 200);
}
.forms-container {
  display: flex;
  flex-wrap: wrap;
  max-height: 100%;
  overflow-y: auto;
  overflow-x: hidden;
  margin-top: 5px;
  gap: 0.5rem;
}

.forms {
  flex-grow: 1;
  flex-basis: 400px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.forms-separation {
  display: flex;
  justify-content: space-around;
  width: auto;
  align-items: start;
}
.grid {
  padding: 10px;
}
.radio-item {
  margin-top: 10px;
  font-size: 12px;
}
.input-field {
  margin-top: 10px;
}
.section-title {
  font-size: 14px;
  margin-bottom: 50px;
  font-weight: bold;
}
.forms-container {
  display: flex;
  overflow-y: auto;
  height: 80vh;
  padding: 10px;
}
.form-submit {
  display: flex;
  justify-content: end;
  padding-right: 10px;
}

.form-submit button {
  border: none;
  padding: 10px 15px 10px 15px;
  border-radius: 5px;
  color: white;
  opacity: 75%;
  margin: 5px;
}

.form-submit button:hover {
  cursor: pointer;
  opacity: 100%;
}
.forms-title {
  display: block;
  border-bottom: #dedede 1px solid;
  background-color: #fff;
  box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  padding: 10px;
  z-index: 10;
}

.title {
  font-size: 16px;
  padding: 10px;
  font-weight: bold;
}

.form-section {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
  padding: 10px;
}

.form-section label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  font-size: 12px;
}

.form-section input {
  display: flex;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

.radio-group {
  display: flex;
  align-items: center;
  gap: 10px;
}

.radio-group label {
  display: flex;
  align-items: center;
}

.forms-controller-radio {
  margin-right: 5px;
}
.italic {
  font-style: italic;
  font-size: 12px;
  margin-left: 20px;
}
textarea {
  border-radius: 5px;
  width: 100%;
  max-width: 99%;
}
</style>
