<script src="./js/leave-form-modal.js"></script>

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

  <div class="modal" :key="formData.id" @click.self="toggleFormModal">
    <ImageViewer
      v-if="src"
      :src="src"
      @toggleLargeImgViewer="toggleLargeImgViewer"
    ></ImageViewer>
    <div class="modal-content">
      <div class="modal-header">
        <span class="title">Leave Application</span>
        <span @click="toggleFormModal" class="x-btn">&times;</span>
      </div>

      <div class="modal-details">
        <div>
          <div class="row">
            <div class="modal-subtitle">
              <text>Leave Type:</text>
            </div>
            <text class="underline">{{ formData.leave_type }}</text>
          </div>

          <div class="modal-items read-only">
            <div
              class="row"
              v-if="
                formData.leave_type == 'Personal' &&
                formData.leave_type_option != 'Vacation'
              "
            >
              <div class="modal-subtitle">
                <text>Reason:</text>
              </div>
              <span class="underline">{{ formData.leave_type_option }}</span>
            </div>
            <div class="radio-group" v-if="formData.leave_type_option == 'Vacation'">
              <span class="sub-title">Vacation:</span>
              <div v-if="formData.vacation_option === 'Within the Philippines'">
                <label
                  ><input
                    type="checkbox"
                    class="sub-checkbox"
                    :checked="formData.vacation_option === 'Within the Philippines'"
                  />
                  Within Philippines
                </label>
                <input type="text" v-model="formData.address" />
              </div>

              <label v-if="formData.vacation_option == 'Abroad'"
                ><input
                  type="checkbox"
                  class="sub-checkbox"
                  name="vacation_abroad"
                  :checked="formData.vacation_option === 'Abroad'" />
                Abroad :

                <input
                  type="text"
                  :value="formData.vacation_option === 'Abroad' ? formData.address : ''"
              /></label>
            </div>

            <div class="checkbox-group" v-if="formData.leave_type == 'Sick'">
              <div class="input-group">
                <label class="sub-title">Sick Leave Type: </label>
              </div>
              <label
                ><input
                  type="checkbox"
                  :checked="formData.convalescence_place == 'In Hospital'"
                  class="sub-checkbox"
                  name="sick_hospital"
                />
                Hospital
              </label>
              <label
                ><input
                  type="checkbox"
                  :checked="formData.convalescence_place == 'Out Patient'"
                  class="sub-checkbox"
                />
                Out Patient
              </label>
              <label
                ><input
                  type="checkbox"
                  :checked="formData.convalescence_place == 'Home Medication'"
                  class="sub-checkbox"
                  name="sick_home"
                />
                Home Medication
              </label>

              <div
                class="input-group"
                v-if="formData.convalescence_place == 'In Hospital'"
              >
                <label for="" class="sub-title">Place: </label>
                <span class="underline">{{ formData.address }}</span>
              </div>

              <div class="input-group">
                <label class="sub-title"> Illness: </label>
                <span class="underline">{{ formData.illness }}</span>
              </div>

              <div class="input-group">
                <label class="sub-title"> Medical Certificate: </label>
                <img
                  title="Click to view image"
                  @click="
                    toggleLargeImgViewer(
                      `/storage/users/medical_certificates/${formData.medical_certificate}`
                    )
                  "
                  class="medical-certificate"
                  :src="`/storage/users/medical_certificates/${formData.medical_certificate}`"
                  alt=""
                />
              </div>
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

          <div class="section-dates" v-if="formData.leave_type === 'Sick'">
            <div class="input-date">
              <label for="date_of_confinement">Date of Confinement: </label>
              <span class="underline">{{
                formatDate(formData.date_of_confinement)
              }}</span>
            </div>

            <div class="input-date">
              <label for="date_of_discharge">Date of Discharge:</label>
              <span class="underline">{{ formatDate(formData.date_of_discharge) }}</span>
            </div>
          </div>
          <div class="section-dates">
            <div class="input-date">
              <label for="date_start">Leave Date Start: </label>
              <span class="underline">{{ formatDate(formData.date_start) }}</span>
            </div>

            <div class="input-date">
              <label for="date_end">Leave Date End:</label>
              <span class="underline">{{ formatDate(formData.date_end) }}</span>
            </div>
          </div>

          <div class="radio-group" v-if="formData.status === 'dean_approved'">
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
            v-if="submission_type === 'disapproval' && formData.status == 'dean_approved'"
          >
            <textarea
              placeholder="Input a description for disapproval."
              name=""
              v-model="disapproval_description"
              id=""
              required
            ></textarea>
          </div>
        </div>
        <div
          v-if="
            roles.includes('dean') || roles.includes('admin') || roles.includes('vp-acad')
          "
        >
          <div class="modal-subtitle">
            <text>Substitute(s): </text>
            <span class="underline">{{
              formData.substitutes.length == 0 ? "None" : ""
            }}</span>
          </div>

          <div>
            <ul v-for="substitute in formData.substitutes">
              <li
                :title="
                  substitute.subject.description +
                  ' (' +
                  substitute.subject.course_no +
                  ')'
                "
              >
                {{ substitute.subject.course_no }} | {{ substitute.days }} |
                {{ substitute.user.last_name[0] }}.
                {{ substitute.user.first_name }}
              </li>
            </ul>
          </div>

          <div class="description" v-if="formData.substitutes.length === 0">
            <label for="">Class Description:</label>
            <text class="underline">
              {{ formData.class_description }}
            </text>
          </div>
        </div>

        <div class="certitification-credits">
          <div class="certification-title" v-if="roles.includes('hr')">
            <text>Certification of Leave Credits as of </text>
            <select v-model="currentYear">
              <option v-for="year in 2030 - 2021 + 1" :key="year" :value="2021 + year">
                {{ 2021 + year }}
              </option>
            </select>
          </div>
          <div class="certification-item">
            <text>Name of Applicant:</text>
            <span class="underline">
              {{ formData.user.last_name }}
              {{ formData.user.first_name }}
            </span>
          </div>

          <div class="certification-item">
            <text>Date Hired:</text>
            <span
              class="underline"
              v-if="
                formData.user.teacher
                  ? formData.user.teacher.date_hired
                  : formData.user.staff.date_hired
              "
            >
              {{
                formatDate(
                  formData.user.teacher
                    ? formData.user.teacher.date_hired
                    : formData.user.staff.date_hired
                )
              }}
            </span>
            <span
              class="error-msg"
              v-if="
                !(formData.user.teacher
                  ? formData.user.teacher.date_hired
                  : formData.user.staff.date_hired)
              "
            >
              {{ formData.user.last_name[0] }}. {{ formData.user.first_name }}'s hire date
              not found.</span
            >
          </div>

          <table
            v-if="
              roles.includes('hr') &&
              (formData.user.teacher
                ? formData.user.teacher.date_hired
                : formData.user.staff.date_hired) != null
            "
          >
            <thead>
              <tr>
                <th></th>
                <th>Personal Leave</th>
                <th>Sick Leave</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Available leave credits</td>
                <td class="end">
                  {{ calculateAvailablePersonalLeave(date_hired) }}
                  <small> day(s)</small>
                </td>
                <td class="end">
                  {{ calculateAvailableSickLeave(date_hired) }}
                  <small> day(s)</small>
                </td>
              </tr>
              <tr>
                <td>Availed leave credits</td>
                <td class="end">
                  <span>{{
                    calculateLeave(
                      formData.id,
                      formData.user_id,
                      "personal",
                      formData.leave_type
                    )
                  }}</span>
                  <small> day(s)</small>
                </td>
                <td class="end">
                  <span>{{
                    calculateLeave(
                      formData.id,
                      formData.user_id,
                      "sick",
                      formData.leave_type
                    )
                  }}</span>

                  <small> day(s)</small>
                </td>
              </tr>
              <tr>
                <td>Add this application</td>
                <td class="end">
                  {{
                    formData.leave_type != "Sick"
                      ? calculateDays("Personal", formData.date_start, formData.date_end)
                      : 0
                  }}
                  <small> day(s)</small>
                </td>
                <td class="end">
                  {{
                    formData.leave_type == "Sick"
                      ? calculateDays("Sick", formData.date_start, formData.date_end)
                      : 0
                  }}
                  <small> day(s)</small>
                </td>
              </tr>

              <tr>
                <td>Total availed credits</td>
                <td class="end">
                  {{
                    formData.leave_type != "Sick"
                      ? totalCurrentPersonalLeave + personalLeaveCount
                      : totalCurrentPersonalLeave
                  }}
                  <small> day(s)</small>
                </td>
                <td class="end">
                  {{
                    formData.leave_type == "Sick"
                      ? sickLeaveCount + totalCurrentSickLeave
                      : totalCurrentSickLeave
                  }}
                  <small> day(s)</small>
                </td>
              </tr>
              <tr>
                <td>Remaining leave credits</td>
                <td class="end">
                  {{
                    calculateAvailablePersonalLeave(date_hired) -
                    (formData.leave_type != "Sick"
                      ? personalLeaveCount + totalCurrentPersonalLeave
                      : totalCurrentPersonalLeave)
                  }}
                  <small> day(s) left</small>
                </td>
                <td class="end">
                  {{
                    calculateAvailableSickLeave(date_hired) -
                    (formData.leave_type == "Sick"
                      ? sickLeaveCount + totalCurrentSickLeave
                      : totalCurrentSickLeave)
                  }}
                  <small> day(s) left</small>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="roles.includes('hr')">
            <div class="certification-item">
              <text>Records:</text>
            </div>

            <table>
              <thead>
                <tr>
                  <th>Date(s)</th>

                  <th>Leave Type</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="form in forms" :key="form.id">
                  <td>
                    {{ formatDate(form.date_start) }} - {{ formatDate(form.date_end) }}
                  </td>

                  <td class="end">{{ form.leave_type }}</td>
                </tr>
              </tbody>
            </table>

            <div class="records-table-footer" v-if="forms.length === 0">
              <span>No records found!</span>
            </div>
          </div>

          <div
            class="modal-item"
            v-if="
              formData.status === 'pending' ||
              formData.status === 'hr_approved' ||
              formData.status === 'vp_admin_approved' ||
              formData.status === 'vp_acad_approved'
            "
          >
            <div>
              <label for="">Submit as:</label>
              <div class="submission-selection">
                <label for="approval">
                  <input type="radio" v-model="submission_type" value="approval" />
                  Approval</label
                >

                <label for="disapproval">
                  <input type="radio" value="disapproval" v-model="submission_type" />
                  Disapproval</label
                >
              </div>
            </div>
          </div>

          <div class="modal-item" v-if="formData.status === 'pending'">
            <div v-if="submission_type == 'disapproval' && formData.status == 'pending'">
              <label for="">Disapproved Due To:</label>
              <div class="input-container">
                <textarea
                  name=""
                  v-model="disapproval_description"
                  id=""
                  placeholder="input disapproval description."
                  required
                ></textarea>
              </div>
            </div>
          </div>

          <div class="modal-item" v-if="formData.status === 'hr_approved'">
            <div v-if="submission_type == 'approval'">
              <label for="">Approved for:</label>
              <div class="input-container">
                <input
                  type="text"
                  v-model="days_with_pay"
                  placeholder="Input no. of days"
                  required
                />
                <span>days with pay.</span>
              </div>

              <div class="input-container">
                <input
                  type="text"
                  v-model="days_without_pay"
                  placeholder="Input no. of days"
                  required
                />
                <span>days without pay.</span>
              </div>

              <div class="input-container">
                <input type="text" v-model="others" placeholder="Specify" />
                <span>others please spicify.</span>
              </div>
            </div>

            <div
              v-if="submission_type == 'disapproval' && formData.status == 'hr_approved'"
            >
              <label for="">Disapproved Due To:</label>
              <div class="input-container">
                <textarea
                  name=""
                  v-model="disapproval_description"
                  id=""
                  placeholder="input disapproval description."
                ></textarea>
              </div>
            </div>
          </div>

          <div
            v-if="
              submission_type == 'disapproval' && formData.status == 'vp_admin_approved'
            "
          >
            <label for="">Disapproved Due To:</label>
            <div class="input-container">
              <textarea
                name=""
                v-model="disapproval_description"
                id=""
                placeholder="input disapproval description."
                required
              ></textarea>
            </div>
          </div>
          <div
            v-if="
              submission_type == 'disapproval' && formData.status == 'vp_acad_approved'
            "
          >
            <label for="">Disapproved Due To:</label>
            <div class="input-container">
              <textarea
                name=""
                v-model="disapproval_description"
                id=""
                placeholder="input disapproval description."
              ></textarea>
            </div>
          </div>
        </div>
      </div>

      <div
        class="btn-container"
        v-if="
          formData.status === 'pending' && submission_type === 'approval'
            ? disapproval_description == null
            : (disapproval_description && formData.status === 'pending') ||
              (submission_type === 'disapproval' &&
                disapproval_description &&
                formData.status === 'pending')
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="toggleFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="
            submission_type == 'approval'
              ? toggleConfirmForm('dean_approved')
              : toggleConfirmForm('dean_disapproved')
          "
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>

      <div
        class="btn-container"
        v-if="
          formData.status === 'dean_approved' && submission_type === 'approval'
            ? disapproval_description == null
            : (disapproval_description && formData.status === 'dean_approved') ||
              (submission_type === 'disapproval' &&
                disapproval_description &&
                formData.status === 'dean_approved')
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="toggleFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="
            submission_type == 'approval'
              ? toggleConfirmForm('hr_approved')
              : toggleConfirmForm('hr_disapproved')
          "
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>

      <div
        class="btn-container"
        v-if="
          formData.status === 'hr_approved' && submission_type === 'approval'
            ? disapproval_description == null
            : (disapproval_description && formData.status === 'hr_approved') ||
              (submission_type === 'disapproval' &&
                disapproval_description &&
                formData.status === 'hr_approved')
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="toggleFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="
            submission_type == 'approval'
              ? toggleConfirmForm('vp_admin_approved')
              : toggleConfirmForm('vp_admin_disapproved')
          "
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>

      <div
        class="btn-container"
        v-if="
          formData.status === 'vp_admin_approved' && submission_type === 'approval'
            ? disapproval_description == null
            : (disapproval_description && formData.status === 'vp_admin_approved') ||
              (submission_type === 'disapproval' &&
                disapproval_description &&
                formData.status === 'vp_admin_approved')
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="toggleFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="
            submission_type == 'approval'
              ? toggleConfirmForm('vp_acad_approved')
              : toggleConfirmForm('vp_acad_disapproved')
          "
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>

      <div
        class="btn-container"
        v-if="
          (formData.status === 'vp_acad_approved' &&
            (submission_type === 'approval'
              ? disapproval_description == null
              : disapproval_description) &&
            formData.status === 'vp_acad_approved') ||
          (submission_type === 'disapproval' &&
            disapproval_description &&
            formData.status === 'vp_acad_approved')
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="toggleFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="
            submission_type == 'approval'
              ? toggleConfirmForm('p_admin_approved')
              : toggleConfirmForm('p_admin_disapproved')
          "
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>
<style scoped>
@import "./css/leave-form-modal.css";
</style>
