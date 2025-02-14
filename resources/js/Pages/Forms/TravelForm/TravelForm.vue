<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";

export default {
  components: {
    ConfirmationFormModal,
  },
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
      confirmation_submission: false,
    };
  },
  methods: {
    toggleConfirmForm() {
      this.confirmation_submission = !this.confirmation_submission;
    },
    submitForm() {
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
        filing_date: this.formData.filing_date ?? new Date().toISOString().split("T")[0],
      };

      Inertia.get("/forms/travel-form-submit", formData);
    },
  },
  layout: Layout,
};
</script>

<template>
  <ConfirmationFormModal
    :confirmation_submission="confirmation_submission"
    @submitForm="submitForm"
    @toggleConfirmForm="toggleConfirmForm"
  ></ConfirmationFormModal>

  <form @submit.prevent="toggleConfirmForm">
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

<style scoped>
@import "./travel-form.css";
</style>
