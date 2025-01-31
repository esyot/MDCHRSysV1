<script>
import { Inertia } from "@inertiajs/inertia";

export default {
  props: {
    formData: Object,
    roles: Object,
  },

  data() {
    return {
      action: "",
      confirmation_modal: false,
    };
  },

  methods: {
    confirmationModal(action) {
      this.action = action;
      this.confirmation_modal = !this.confirmation_modal;
    },
    submitForm() {
      if (this.action == "edit") {
        Inertia.get("/forms/travel-form-request/", this.formData);
      } else if (this.action == "submit") {
        Inertia.post("/forms/travel-form-submit", this.formData);
      }
    },
  },
};
</script>

<template>
  <div v-if="confirmation_modal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-title">Confirmation</span>
        <span class="x-btn">&times;</span>
      </div>
      <section>
        {{
          action === "edit"
            ? "Are you sure to edit the contents?"
            : "Are you sure to submit your form to your dean?"
        }}
      </section>
      <footer>
        <button class="no-btn" @click="confirmationModal">No</button>
        <button class="yes-btn" @click="submitForm">Yes</button>
      </footer>
    </div>
  </div>
  <div class="form-container">
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
    <h3 class="title title-form">Travel Application Form</h3>
    <div class="section">
      <div class="input-group">
        <label
          >Office/Department:
          <span v-for="department in formData.departments" :key="department">
            {{ department.name }}
          </span>
        </label>
        <label
          >Last Name:
          <span>{{ formData.last_name }}</span>
        </label>
        <label
          >First Name:
          <span>{{ formData.first_name }}</span>
        </label>
        <label
          >Middle Name:
          <span>{{ formData.middle_name }}</span>
        </label>
      </div>
    </div>
    <div class="section">
      <div class="input-group">
        <label
          >Date of Filing:
          <span>{{ formData.filing_date }}</span>
        </label>
        <label
          >Position:
          <span>{{ formData.position }}</span>
        </label>
        <label
          >Rank:
          <span>{{ formData.rank }}</span>
        </label>
      </div>
    </div>

    <h3 class="title">Details of Official Travel</h3>
    <div class="travel-section">
      <div class="travel-group">
        <div>
          <label>Date(s) of Travel:</label>
          <span>Start: {{ formData.date_start }} End: {{ formData.date_end }} </span>
        </div>

        <div>
          <label>Place:</label>
          <span>{{ formData.place }}</span>
        </div>
        <div>
          <label>Purpose/Event:</label>
          <span>{{ formData.purpose }}</span>
        </div>
        <div>
          <label>Contact Person:</label>
          <span>{{ formData.contact_person }} - {{ formData.contact_person_no }}</span>
        </div>
        <div class="full-width">
          <label>Short Description:</label>
          <div class="description">
            {{ formData.description }}
          </div>
        </div>
      </div>
    </div>

    <h3 class="title">Budgetary Requirements</h3>
    <div class="budget-section">
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
        <div class="amount">
          <label for="total">Total amount requested: </label>
          <span class="underline"> ₱ {{ formData.amount }}.00 only </span>
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
              :checked="formData.budget_charged_to == 'Departmental/Office Budget'"
            />
            <label for="departmental-office-budget">Departmental/Office Budget</label>
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

    <div class="signature-section">
      <div class="signature-box">
        <p>Requested by:</p>
        <p class="underline">
          {{
            formData.first_name.toUpperCase() +
            " " +
            formData.middle_name.toUpperCase() +
            " " +
            formData.last_name.toUpperCase()
          }}
        </p>
        <p>Employee</p>
        <small
          >Note: this is a computer generated form and it doenst require a
          signature.</small
        >
      </div>
      <div class="signature-box">
        <p>Endorsed by:</p>
        <p class="underline">{{ formData.endorser_name }}</p>
        <p>Dean/Principal/Chairman/Head of Office</p>
        <small
          >Note: this is a computer generated form and it doenst require a
          signature.</small
        >
      </div>
    </div>

    <div class="buttons-container">
      <button type="button" class="edit" @click="confirmationModal('edit')">Edit</button>
      <button type="button" class="submit" @click="confirmationModal('submit')">
        Submit
      </button>
    </div>

    <div v-if="formData.status">
      <h3 class="title">Details of Action on Application</h3>
      <div class="box-container">
        <div class="sextion">
          <div class="lef-side">
            <label>NUMBER OF DAYS TRAVELLED</label>
            <div class="as-group">
              <label>As of</label>
              <input type="text" class="others" />
            </div>

            <table>
              <tr>
                <th></th>
                <th>1st sem</th>
                <th>2nd sem</th>
                <th>Summer</th>
              </tr>
              <tr>
                <td>Previous total number of days travelled</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Add this application</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Total Days</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>

            <div class="hr-officer">
              <label for="">JOSEFINA J. PANGAN</label>
              <label for="">HR Officer</label>
            </div>
          </div>

          <div class="righ-section">
            <div class="recommendation">
              <h4>RECOMMENDATION</h4>

              <div>
                <input type="radio" id="approval" name="recommendation" />
                <label for="approval">For approval</label>
              </div>

              <div class="disapproval-section">
                <input type="radio" id="disapproval" name="recommendation" />
                <label for="disapproval">For disapproval due to</label>

                <textarea class="big-input"></textarea>
              </div>

              <div class="department-head">
                <input type="text" class="others" />
                <label for="department_head">Department Head/Head of Office</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="backs-container">
        <div class="last">
          <div>
            <label>Approved for:</label>
            <input type="text" class="underlast" />
            <label>days with pay</label>
          </div>

          <div>
            <input type="text" class="underlast" />
            <label>days without pay</label>
          </div>

          <div>
            <input type="text" class="underlast" />
            <label>others (Specify)</label>
          </div>
        </div>

        <div class="disapproved">
          <div>
            <label>Disapproved due to:</label>
            <textarea class="dis" rows="2"></textarea>
          </div>
        </div>
        <div class="names">
          <div>
            <label>ARTEMIO M. GULILAT, CPA</label>
            <label>VP for Admin and Finance</label>
          </div>
          <div>
            <label>MARIA NYMPA S. RESERVA, Ph.D.</label>
            <label>VP for Academics</label>
          </div>
          <div>
            <label>MARIANO M. LERIN, CPA, Ph.D.</label>
            <label>President</label>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="note">
      <label for=""
        >Note: This form should be submitted in duplicate copy at least 10 days in
        advance.</label
      >
    </div> -->
  </div>
</template>
<style scoped>
.buttons-container {
  display: flex;
  justify-content: center;
  padding: 10px;
  gap: 0.2rem;
}

.buttons-container .submit {
  padding: 10px;
  border: none;
  background-color: rgb(0, 184, 34);
  color: #fff;
  border-radius: 5px;
}

.buttons-container .edit {
  padding: 10px;
  border: none;
  background-color: rgb(28, 118, 245);
  color: #fff;
  border-radius: 5px;
}

.buttons-container .edit,
.submit {
  opacity: 75%;
}
.buttons-container .edit:hover,
.submit:hover {
  opacity: 100%;
  cursor: pointer;
}
@font-face {
  font-family: "RM New Albion";
  src: url("/public/assets/fonts/rm_new_albion.woff") format("woff");
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}

.amount span {
  font-size: 16px;
  font-weight: bold;
}

.heading-text {
  display: flex;
  flex-direction: column;
  gap: 0.1rem;
}

.heading-text .first {
  font-size: 42pt !important;
  font-family: "RM New Albion";
  font-weight: bold;
}
.heading-text .second {
  font-weight: bold;
}

.heading-text .third {
  font-weight: bold;
}

.heading-container {
  margin-left: 10px;
  display: flex;
  align-items: start;
  justify-content: center;
  width: 100%;
  gap: 1rem;
}

.form-container {
  max-width: 1000px;
  margin: 20px auto;
  background-color: #fff;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header {
  text-align: center;
  margin-bottom: 20px;
}

.header img {
  width: 80px;
  height: auto;
  margin-bottom: 10px;
}

.header h2 {
  font-size: 24px;
  margin: 0;
  color: #030405;
}

.header p {
  margin: 5px 0;
  font-size: 14px;
  color: #555;
}

.title {
  font-size: 14px;
  color: black;
  text-align: center;

  border-bottom: 1px solid #ddd;
  padding-bottom: 5px;
}

.title-form {
  text-align: center;
  font-size: 23px;
}

.section {
  margin-bottom: 10px;
}

.input-group {
  margin-left: 50px;
  display: flex;
  flex-direction: row;
  gap: 15px;
}

.input-group label {
  display: flex;
  margin-left: 30px;
  flex-direction: column;
  font-size: 12px;
  color: #333;
  min-width: 150px; /* Adjust this width as needed */
}

.input-group span {
  font-size: 14px;
  font-weight: bold;
  padding: 5px;
  /* border-bottom: 1px solid black; */
  min-width: 180px;
  white-space: nowrap; /* Prevent text wrapping */
  overflow: hidden;
  text-overflow: ellipsis; /* Add ellipsis if text overflows */
}

.travel-group input {
  border: none;
  border-bottom: 1px solid #ddd;
  outline: none;
  width: 50%;
}
.others {
  border: none;
  border-bottom: 1px solid #100a0a;
  outline: none;
  width: 50%;
}
.input-group input:focus {
  border-bottom: 1px solid #003366;
}
.inline-fields {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}
.inline-fields label {
  flex: 1;
}
.inline-fields input[name="last_name"] {
  width: 35%;
}
.inline-fields input[name="first_name"] {
  width: 35%;
}
.inline-fields input[name="middle_name"] {
  width: 28%;
}
.travel-section .travel-group {
  display: grid;
  font-size: 12px;
  grid-template-columns: 1fr 1fr; /* Two columns */
  gap: 15px;
}

.travel-section label {
  margin-left: 20px;
}

.travel-section span {
  margin-left: 20px;
}

.travel-group .full-width {
  grid-column: span 2; /* Full-width for textarea or large content */
}

.travel-group label {
  display: block;
  font-size: 12px;
  color: #333;
  margin-bottom: 2px; /* Space between label and data */
}

.travel-group span {
  font-size: 14px;
  font-weight: bold;
  padding: 5px;
  min-width: 200px; /* Fixed width for consistent alignment */
  display: inline-block;
  white-space: nowrap; /* Prevent wrapping */
  overflow: hidden;
  text-overflow: ellipsis; /* Ellipsis for overflow */
}

.travel-group .description {
  padding: 5px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
  min-height: 50px; /* Ensure textarea replacement spans multiple rows */
}

table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}
table th,
table td {
  border: 1px solid #0a0909;
  padding: 8px;
  text-align: center;
}
table th {
}
.signature-section {
  display: flex;
  font-size: 12px;
  justify-content: space-between;
  margin-top: 10px;
}
.signature-box {
  text-align: center;
  flex: 1;
}
.signature-box p {
  margin: 5px 0;
}
.full-width {
  display: flex;
  flex-direction: column;
}
.full-width label {
  font-size: 12px;
  margin-bottom: 3px;
}
.full-width textarea {
  width: 97.7%;
  height: 30%;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 12px;
  resize: none;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.description {
  margin: 0 20px;
  width: 95%;
}
.budget-section {
  display: flex;
  font-size: 12px;
  justify-content: space-between;
  align-items: flex-start;
  pointer-events: none;
}
.left-side,
.righ-side {
  width: 48%;
}

.left-side label,
.right-side label {
  display: inline-block;
  margin-bottom: 8px;
}
.amount {
  display: flex;
  align-items: start;
  gap: 10px;
}
.amount input {
  border: none;
  border-bottom: 1px solid #000;
  padding: 4px;
  width: 200px;
}
.underline {
  text-decoration: underline;
}
.box-container {
  display: flex;
  font-size: 12px;
  justify-content: space-between;
}
.sextion {
  display: flex;
  width: 100%;
  gap: 20px;
}
.lef-side,
.right-section {
  flex: 1;
}
.disapproval-section {
  gap: 10px;
}
textarea {
  width: 90%;
  height: 100px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.department-head {
  margin-top: 25px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.department-head label {
  text-align: center;
  font-size: 12px;
  font-weight: bold;
}
.others {
  border-bottom: 1px solid #0a0505;
}
.hr-officer {
  font-weight: bold;
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}
.backs-container {
  border: 2px solid #ccc;
  padding: 10px;
  border-radius: 2px;
  width: 95%;
  margin: 10px auto;
}
.last {
  display: flex;
  flex-direction: row;
  gap: 70px;
  font-size: 12px;
}
.underlast {
  border: none;
  border-bottom: 1px solid #000;
  width: 50px;
}
.disapproved {
  margin-top: 10px;
  font-size: 12px;
}
.dis {
  width: 97%;
  margin-top: 1px;
  height: 20px;
}
.names {
  font-weight: bold;
  margin-top: 6px;
  font-size: 14px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  text-align: center;
  width: 100%;
}

.names div {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.names label {
  word-wrap: break-word;
  white-space: normal;
}

.heading-text {
  align-items: center;
  text-align: center;
  margin-righ: 90px;
}
.heading-img img {
  width: 80px;
  height: auto;
}
.school-name {
  font-family: "Old English Text MT", serif;
  margin: 0 10px;
}
.title-container {
  text-align: center;
}

.department {
  margin-top: -20px;
}

.big-input {
  height: 40px;
  margin-top: 10px;
}

.input-group {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
}

.input-group label {
  display: flex;
  flex-direction: column;
  font-size: 12px;
  color: #333;
  text-align: center; /* Center align text if needed */
  flex: 1; /* Make all labels take up equal space */
}

.input-group span {
  font-size: 14px;
  font-weight: bold;
  padding: 5px;
  display: inline-block;
  text-align: center; /* Center align dynamic content */
  min-width: 120px; /* Ensure consistent width for span */
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis; /* Add ellipsis for overflow */
  text-decoration: none; /* Ensure no underline from text styles */
}

.note label {
  margin: 0 50px;
  font-size: 13px;
  font-weight: 600;
}

.modal {
  display: flex;
  position: fixed;
  justify-content: center;
  align-items: center;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.2);
  z-index: 10;
}

.modal-content {
  background-color: #fff;
  border-top: 4px solid rgb(45, 93, 235);
  border-radius: 5px;
  box-shadow: 20px 20px 20px 1.2px rgba(0, 0, 0, 0.1);
  border: 1px solid #cccccc;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  padding: 2px;
  border-bottom: 1px solid rgb(178, 178, 178);
}

.modal-header .modal-title {
  font-size: 18px;
  font-weight: bold;
  padding: 2px;
}

.modal-header .x-btn {
  padding-right: 5px;
  padding-top: 2px;
  font-weight: bold;
  font-size: 18px;
}

.modal-header .x-btn:hover {
  cursor: pointer;
  opacity: 75%;
}
.modal-content section {
  border-bottom: 1px solid #b2b2b2;
  padding: 10px;
}

.modal-content footer {
  display: flex;
  justify-content: end;
  padding: 5px;
  gap: 0.2rem;
  background-color: #ececec;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
}
.modal-content footer button {
  padding: 10px;
  border-radius: 5px;
  border: none;
  opacity: 75%;
}

.modal-content footer button:hover {
  opacity: 100%;
  cursor: pointer;
}

.modal-content .yes-btn {
  background-color: rgb(28, 118, 245);
  color: #fff;
}

.modal-content .no-btn {
  background-color: rgb(190, 2, 2);
  color: #fff;
  padding-left: 12px;
  padding-right: 12px;
}
</style>
