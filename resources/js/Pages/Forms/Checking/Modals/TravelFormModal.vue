<script src="./js/travel-form-modal.js"></script>
<template>
  <div
    class="confirmation-modal"
    v-if="isConfirmation"
    @click.self="toggleConfirmForm(action)"
  >
    <div class="confirmation-modal-content">
      <text>Are you sure you want to submit?</text>
      <div class="confirmation-modal-btn">
        <button @click="toggleConfirmForm(action)" class="no-btn">No</button>
        <button @click="submitForm" class="yes-btn">Yes</button>
      </div>
    </div>
  </div>

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

      <div class="modal-container">
        <div class="modal-container-items">
          <div class="item">
            <div class="item-title">
              <text>Details of Official Travel</text>
            </div>
            <div class="grouped-details">
              <div class="group">
                <label>Date Start: </label>
                <span class="underline">{{ formatDate(formData.date_start) }} </span>

                <label>Date End: </label>
                <span class="underline">{{ formatDate(formData.date_end) }} </span>

                <label>Place: </label>
                <span class="underline">{{ formData.place }}</span>

                <label>Purpose/Event: </label>
                <span class="underline">{{ formData.purpose }}</span>

                <label>Contact Person: </label>
                <span class="underline"
                  >{{ formData.contact_person }} - {{ formData.contact_person_no }}</span
                >
                <label>Short Description: </label>
                <span class="underline">
                  {{ formData.description }}
                </span>
              </div>
            </div>
          </div>

          <div class="item" v-if="formData.substitutes.length != 0">
            <div class="item-title">
              <text>Substitutes:</text>
            </div>
            <div class="grouped-details">
              <div class="group">
                <span v-for="substitute in formData.substitutes">
                  {{ substitute.user.last_name }}, {{ substitute.user.first_name }} -
                  {{ substitute.subject }}
                </span>
              </div>
            </div>
          </div>

          <div class="item">
            <div class="item-title">
              <text>Budgetary Requirements</text>
            </div>

            <div class="grouped-details">
              <div class="group">
                <div class="item-subtitle">
                  <text>Budget type:</text>
                </div>
                <div>
                  <input
                    type="checkbox"
                    id="registration"
                    name="budget_requirement"
                    value="registration"
                    :checked="formData.budget_type === 'Registration'"
                    readonly
                  />
                  <span for="registration">Registration</span>
                </div>
                <div>
                  <input
                    type="checkbox"
                    id="transportation"
                    name="budget_requirement"
                    value="transportation"
                    :checked="formData.budget_type === 'Transportation'"
                    readonly
                  />
                  <span for="transportation">Transportation</span>
                </div>
                <div>
                  <input
                    type="checkbox"
                    id="representation"
                    name="budget_requirement"
                    value="representation"
                    :checked="formData.budget_type === 'Representation Allowance'"
                    readonly
                  />
                  <span for="representation">Representation Allowance</span>
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
                  <span for="miscellaneous">Miscellaneous</span>
                </div>
              </div>

              <div class="group">
                <div class="item-subtitle">
                  <text>Budget charged to:</text>
                </div>

                <div>
                  <input
                    type="checkbox"
                    id="departmental-fund"
                    name="budget_charged"
                    value="departmental-fund"
                  />
                  <span for="departmental-fund">Departmental Fund</span>
                </div>
                <div>
                  <input
                    type="checkbox"
                    id="departmental-office-budget"
                    name="budget_charged"
                    value="departmental-office-budget"
                    :checked="formData.budget_charged_to == 'Departmental/Office Fund'"
                  />
                  <span for="departmental-office-budget">Departmental/Office Fund</span>
                </div>

                <div>
                  <input
                    type="checkbox"
                    id="school-fund"
                    name="budget_charged"
                    value="school-fund"
                    :checked="formData.budget_charged_to == 'School Fund'"
                  />
                  <span for="school-fund">School Fund</span>
                </div>
              </div>

              <div class="group">
                <div class="item-subtitle">
                  <text>Total amount requested: </text>
                </div>
                <span class="underline"> ₱ {{ formData.amount }} only </span>
              </div>
            </div>
          </div>
        </div>

        <div class="certitification-credits">
          <div class="certification-title">
            <text>Certification of Leave Credits as of </text>
            <select v-model="currentYear">
              <option v-for="year in 2030 - 2021 + 1" :key="year" :value="2021 + year">
                {{ 2021 + year }}
              </option>
            </select>
          </div>
          <div class="group">
            <label>Name of Applicant: </label>
            <span class="underline">
              {{ formData.user.last_name }}
              {{ formData.user.first_name }}
              {{ formData.user.middle_name[0] }}.
            </span>
          </div>

          <div class="group">
            <label>Date Hired: </label>
            <span class="underline">
              {{ formData.user_job_detail.date_hired }}
            </span>
          </div>

          <table>
            <thead>
              <tr>
                <th></th>
                <th>1st Sem</th>
                <th>2nd Sem</th>
                <th>Summer</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Previous total no. of days travelled</td>
                <td class="end">
                  <small> {{ fetchTraveledDays("1st") }} day(s)</small>
                </td>
                <td class="end">
                  <small> {{ fetchTraveledDays("2nd") }} day(s)</small>
                </td>
                <td class="end">
                  <small> {{ fetchTraveledDays("summer") }} day(s)</small>
                </td>
              </tr>

              <tr>
                <td>Add this application</td>
                <td class="end">
                  <small>
                    {{
                      formData.semister === "1st"
                        ? calculateDays(formData.date_start, formData.date_end)
                        : 0
                    }}
                    day(s)
                  </small>
                </td>
                <td class="end">
                  <small>
                    {{
                      formData.semister === "2nd"
                        ? calculateDays(formData.date_start, formData.date_end)
                        : 0
                    }}
                    day(s)
                  </small>
                </td>
                <td class="end">
                  <small>
                    {{
                      formData.semister === "summer"
                        ? calculateDays(formData.date_start, formData.date_end)
                        : 0
                    }}
                    day(s)
                  </small>
                </td>
              </tr>

              <tr>
                <td>Total availed credits</td>
                <td class="end">
                  <small>
                    {{
                      fetchTraveledDays("1st") +
                      (formData.semister === "1st"
                        ? calculateDays(formData.date_start, formData.date_end)
                        : 0)
                    }}
                    day(s)
                  </small>
                </td>
                <td class="end">
                  <small>
                    {{
                      fetchTraveledDays("2nd") +
                      (formData.semister === "2nd"
                        ? calculateDays(formData.date_start, formData.date_end)
                        : 0)
                    }}
                    day(s)
                  </small>
                </td>
                <td class="end">
                  <small>
                    {{
                      fetchTraveledDays("summer") +
                      (formData.semister === "summer"
                        ? calculateDays(formData.date_start, formData.date_end)
                        : 0)
                    }}
                    day(s)
                  </small>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="roles.includes('hr')">
            <div class="certification-">
              <text>Records:</text>
            </div>

            <table>
              <thead>
                <tr>
                  <th>Date(s)</th>

                  <th>Semister</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="form in forms" :key="form.id">
                  <td>
                    {{ formatDate(form.date_start) }} - {{ formatDate(form.date_end) }}
                  </td>

                  <td class="end">{{ form.semister }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div
            class="radio-group"
            v-if="
              formData.status === 'hr_approved' ||
              formData.status === 'vp_admin_approved' ||
              formData.status === 'vp_acad_approved'
            "
          >
            <div class="modal-subtitle">
              <text>Recommendation: </text>
            </div>
            <label>
              <input
                type="radio"
                v-model="submission_type"
                value="approval"
                class="sub-radio"
              />
              For Approval
            </label>
            <label>
              <input
                type="radio"
                v-model="submission_type"
                value="disapproval"
                class="sub-radio"
              />
              For Disapproval
            </label>
          </div>
          <div
            class="textarea-container"
            v-if="
              (submission_type === 'disapproval' && formData.status == 'hr_approved') ||
              (submission_type === 'disapproval' &&
                formData.status == 'vp_admin_approved') ||
              (submission_type === 'disapproval' && formData.status == 'vp_acad_approved')
            "
          >
            <textarea
              placeholder="Input a description for disapproval."
              v-model="disapproval_description"
              required
            ></textarea>
          </div>
        </div>
      </div>
      <div class="btn-container" v-if="formData.status === 'pending'">
        <button class="close-btn" @click="toggleFormModal">Close</button>
        <button class="submit-btn" @click="toggleConfirmForm('dean_approved')">
          Submit
        </button>
      </div>

      <div class="btn-container" v-if="formData.status === 'dean_approved'">
        <button class="close-btn" @click="toggleFormModal">Close</button>
        <button class="submit-btn" @click="toggleConfirmForm('hr_approved')">
          Submit
        </button>
      </div>

      <div class="btn-container" v-if="formData.status === 'hr_approved'">
        <button class="close-btn" @click="toggleFormModal">Close</button>
        <button class="submit-btn" @click="toggleConfirmForm('vp_admin_approved')">
          Submit
        </button>
      </div>

      <div class="btn-container" v-if="formData.status === 'vp_admin_approved'">
        <button class="close-btn" @click="toggleFormModal">Close</button>
        <button class="submit-btn" @click="toggleConfirmForm('vp_acad_approved')">
          Submit
        </button>
      </div>

      <div
        class="btn-container"
        v-if="
          submission_type === 'approval'
            ? formData.status === 'vp_acad_approved'
            : formData.status === 'vp_acad_approved' && disapproval_description !== ''
        "
      >
        <button class="close-btn" @click="toggleFormModal">Close</button>
        <button class="submit-btn" @click="toggleConfirmForm('p_admin_approved')">
          Submit
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/travel-form-modal.css";
</style>
