<script src="./js/tracking-modal.js"></script>
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
          <label>Destination: </label>
          <span>{{ formData.destination }}</span>
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

        <div class="item">
          <label>Term: </label>
          <span class="item">
            {{ formData.term.name }}
          </span>
        </div>
      </div>
      <div class="substitute-details">
        <div class="substitute-item" v-if="formData.substitutes.length != 0">
          <label for="">Substitutes:</label>
          <span
            v-for="substitute in formData.substitutes"
            :title="substitute.subject.description"
          >
            {{ substitute.user.last_name[0] }}. {{ substitute.user.first_name }} |
            {{ substitute.subject.course_no }} |
            {{ substitute.days }}
          </span>
        </div>

        <div v-else class="substitute-item">
          <label for="">Substitutes:</label>
          <span>None</span>
          <label for="">Class Alternatives:</label>
          <span>{{ formData.class_description }}</span>
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

      <div class="content-details">
        <div class="content-details-item">
          <div class="input-group">
            <label>Leave Type: </label>
            <span>
              {{ formData.leave_type }}
            </span>
          </div>

          <div class="input-group">
            <label>Term: </label>
            <span>
              {{ formData.term.name }}
            </span>
          </div>
          <div class="row">
            <div class="input-group">
              <label for="date_start">Start date: </label>

              <span>{{ formData.date_start }}</span>

              <label for="date_end">End date:</label>
              <span>{{ formData.date_end }}</span>
            </div>

            <div class="sick-details">
              <div class="input-group" v-if="formData.leave_type === 'Sick'">
                <label for="">Place:</label>
                <input type="text" v-model="formData.address" />

                <label for="">Illness:</label>
                <input type="text" v-model="formData.illness" />
              </div>

              <div class="section-dates" v-if="formData.leave_type === 'Sick'">
                <div class="input-group">
                  <label for="date_of_confinement">Date of Confinement: </label>

                  <input
                    type="text"
                    id="date_of_confinement"
                    v-model="formData.date_of_confinement"
                    name="date_start"
                  />

                  <label for="date_of_discharge">Date of Discharge:</label>
                  <input
                    type="text"
                    id="date_of_discharge"
                    v-model="formData.date_of_discharge"
                    name="date_end"
                  />
                </div>
              </div>
            </div>
          </div>
          <span class="sub-title" v-if="formData.leave_type_option"
            >Details of Leave:</span
          >

          <div class="input-group">
            <span>{{ formData.leave_type_option }}</span>
          </div>
        </div>

        <div class="content-details-item">
          <div class="substitute-details">
            <div class="substitute-item" v-if="formData.substitutes.length != 0">
              <label for="">Substitutes:</label>
              <span v-for="substitute in formData.substitutes">
                {{ substitute.user.last_name[0] }}. {{ substitute.user.first_name }} |
                {{ substitute.subject.course_no }} | {{ substitute.days }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="close-btn-container">
        <button @click="closeFormModal">Close</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/tracking-modal.css";
</style>
