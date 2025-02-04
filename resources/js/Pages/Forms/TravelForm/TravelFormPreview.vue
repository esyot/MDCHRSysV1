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
@import "./travel-form-preview.css";
</style>
