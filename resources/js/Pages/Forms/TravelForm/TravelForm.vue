<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  data() {
    return {
      form: {
        office: "",
        lastName: "",
        firstName: "",
        middleName: "",
        dateOfFiling: "",
        position: "",
        rank: "",
      },
      travelForm: {
        dates: "",
        place: "",
        purpose: "",
        organizer: "",
        description: "",
      },
      budget: {
        registration: false,
        transportation: false,
        representation: false,
        miscellaneous: false,
        departmentalFund: false,
        officeBudget: false,
        schoolFund: false,
        others: false,
        othersReason: "",
      },
    };
  },
  methods: {
    travelFormSubmit(event) {
      const formData = new FormData(event.target);

      Inertia.get("/travel-form-submit", formData);
    },
  },
  layout: Layout,
};
</script>

<template>
  <form @submit.prevent="travelFormSubmit">
    <div class="forms-container">
      <div class="forms">
        <div class="forms-title">
          <span class="title">Travel details</span>
        </div>
        <div class="form-section">
          <label for="dates">Date of Filing:</label>
          <input
            type="date"
            id="dates"
            v-model="form.dateOfFiling"
            class="form-control"
            required
          />
        </div>

        <div class="form-section">
          <label for="dates">Date(s) of Travel:</label>
          <input
            type="date"
            id="dates"
            v-model="travelForm.dates"
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
          <label for="organizer">Organizer/Contact Person:</label>
          <input
            type="text"
            id="organizer"
            v-model="travelForm.organizer"
            class="form-control"
            placeholder="Enter the organizer or contact person"
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
            <div class="checkbox-item">
              <input type="checkbox" id="registration" v-model="budget.registration" />
              <label for="registration">Registration</label>
            </div>
            <div class="checkbox-item">
              <input
                type="checkbox"
                id="transportation"
                v-model="budget.transportation"
              />
              <label for="transportation">Transportation</label>
            </div>
            <div class="checkbox-item">
              <input
                type="checkbox"
                id="representation"
                v-model="budget.representation"
              />
              <label for="representation">Representation Allowance</label>
            </div>
            <div class="checkbox-item">
              <input type="checkbox" id="miscellaneous" v-model="budget.miscellaneous" />
              <label for="miscellaneous">Miscellaneous</label>
            </div>

            <div class="checkbox-item">
              <label for="total">Total amount requested:</label><br />
              <input type="text" class="input-field" />
            </div>
          </div>

          <div class="grid">
            <div class="sub-section-title">
              <label class="section-title">Budget charged to:</label>
            </div>
            <div class="checkbox-item">
              <input type="checkbox" id="registration" v-model="budget.registration" />
              <label for="registration">Department Fund</label>
            </div>
            <div class="checkbox-item">
              <input
                type="checkbox"
                id="transportation"
                v-model="budget.transportation"
              />
              <label for="transportation">Departmental/Office fund</label>
            </div>
            <div class="checkbox-item">
              <input
                type="checkbox"
                id="representation"
                v-model="budget.representation"
              />
              <label for="representation">School Fund</label>
            </div>

            <div class="checkbox-item">
              <input
                type="checkbox"
                id="representation"
                v-model="budget.representation"
              />
              <label for="total">Others, specify</label><br />
              <input type="text" class="input-field" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-submit">
      <button class="preview" title="Preview form">
        <i class="fas fa-eye"></i>
        <span> Preview</span>
      </button>
      <button class="submit" title="Submit for approval">
        <i class="fas fa-check"></i>
        <span> Submit</span>
      </button>
    </div>
  </form>
</template>

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
  max-height: 75vh;
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
.form-grid {
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  gap: 10px;
  margin: 10px 10px 10px 10px;
}
.grid {
  padding: 10px;
}
.checkbox-item {
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
