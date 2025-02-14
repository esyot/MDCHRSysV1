<script>
import { Inertia } from "@inertiajs/inertia";
import ImageViewer from "@/Components/ImageViewer.vue";
export default {
  emits: ["toggleFormModal"],
  props: {
    leaveForms: Object,
    selected_id: String,
    selected_type: String,
    roles: Array,
  },
  components: {
    ImageViewer,
  },

  data() {
    return {
      submission_type: "approval",
      disapproval_description: null,
      days_with_pay: "",
      days_without_pay: "",
      others: "",
      currentYear: new Date().getFullYear(),
      personalLeaveCount: 0,
      sickLeaveCount: 0,
      totalCurrentSickLeave: 0,
      totalCurrentPersonalLeave: 0,
      availableLeaveCount: 0,
      src: "",
      forms: [],
      fetchedDataCache: [],
      confirmation_submission: false,
      confirmation_submission_selected: false,
      action: "",
    };
  },
  watch: {
    selected_id(newVal, oldVal) {
      if (oldVal) {
        const oldModalId = `modal-${this.modal_type
          .toLowerCase()
          .replace(" ", "-")}-${oldVal}`;
        const oldModal = document.getElementById(oldModalId);
        if (oldModal) {
          oldModal.classList.add("hidden");
          oldModal.classList.remove("flex");
        }
      }
      if (newVal) {
        const newModalId = `modal-${this.modal_type
          .toLowerCase()
          .replace(" ", "-")}-${newVal}`;
        const newModal = document.getElementById(newModalId);
        if (newModal) {
          newModal.classList.remove("hidden");
          newModal.classList.add("flex");
        }
      }
    },
  },

  methods: {
    toggleLargeImgViewer(src) {
      this.src == src ? (this.src = null) : (this.src = src);
    },

    toggleConfirmForm(action) {
      this.action === action ? (this.action = null) : (this.action = action);
      this.confirmation_submission = !this.confirmation_submission;
    },
    submitForm() {
      const formData = {
        id: this.selected_id,
        form_type: this.selected_type,
        submission_type: this.submission_type,
        submission_description: this.submission_description,
        disapproval_description: this.disapproval_description ?? null,
        days_with_pay: this.days_with_pay,
        days_without_pay: this.days_without_pay,
        others: this.others,
        action: this.action,
      };

      Inertia.post("/forms/checking/forward", formData, {
        onSuccess: () => {
          this.action = "";
          this.confirmation_submission = !this.confirmation_submission;
          this.closeFormModal;
        },
      });
    },

    closeFormModal() {
      this.$emit("toggleFormModal");
    },

    fetchLeaveForms(user_id) {
      if (this.fetchedDataCache[user_id]) {
        this.forms = this.fetchedDataCache[user_id];
        return;
      }

      fetch(`/forms/find/${user_id}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.forms = data;
          this.fetchedDataCache[user_id] = data;
        })
        .catch((error) => {
          console.error("Error fetching leave forms:", error);
        });
    },

    calculateLeave(user_id, type, current_leave_type) {
      this.fetchLeaveForms(user_id);
      let leaveCount = 0;
      let totalDays = 0;

      if (type === "sick") {
        const filteredArray = this.forms.filter((item) => {
          const itemYear = new Date(item.created_at).getFullYear();
          return (
            item.user_id === user_id &&
            item.status === "approved" &&
            itemYear === this.currentYear &&
            item.leave_type === "Sick"
          );
        });

        filteredArray.forEach((item) => {
          const dateStart = new Date(item.date_start);
          const dateEnd = new Date(item.date_end);
          const daysDifference = (dateEnd - dateStart) / (1000 * 3600 * 24) + 1;
          totalDays += daysDifference;
        });

        if (type == "sick") {
          this.totalCurrentSickLeave = totalDays;
        }

        return totalDays;
      } else {
        const filteredArray = this.forms.filter((item) => {
          const itemYear = new Date(item.created_at).getFullYear();
          return (
            item.user_id === user_id &&
            item.status === "approved" &&
            itemYear === this.currentYear &&
            item.leave_type !== "Sick"
          );
        });

        filteredArray.forEach((item) => {
          const dateStart = new Date(item.date_start);
          const dateEnd = new Date(item.date_end);
          const daysDifference = (dateEnd - dateStart) / (1000 * 3600 * 24) + 1;
          totalDays += daysDifference;
        });

        if (current_leave_type != "Sick") {
          this.totalCurrentPersonalLeave = totalDays;
        }

        return totalDays;
      }
    },

    calculateDays(type, date_start, date_end) {
      const dateStart = new Date(date_start);
      const dateEnd = new Date(date_end);

      const daysDifference = (dateEnd - dateStart) / (1000 * 3600 * 24) + 1;

      if (type == "Sick") {
        this.sickLeaveCount = daysDifference;
      } else {
        this.personalLeaveCount = daysDifference;
      }
      return daysDifference;
    },

    calculateAvailablePersonalLeave(date) {
      const date_today = new Date();
      const year_today = date_today.getFullYear();
      const year_provided = new Date(date).getFullYear();
      const yearDiff = year_today - year_provided;

      return yearDiff >= 10 ? 10 : yearDiff;
    },
    calculateAvailableSickLeave(date) {
      const date_today = new Date();
      const year_today = date_today.getFullYear();
      const year_provided = new Date(date).getFullYear();
      const yearDiff = year_today - year_provided;

      return yearDiff >= 1 ? 15 : yearDiff;
    },
  },

  watch: {
    submission_type(newVal) {
      this.disapproval_description = null;
    },
  },
};
</script>

<template>
  <div
    class="confirmation-modal"
    v-if="confirmation_submission"
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

  <div
    :id="`modal-leave-form-${formData.id}`"
    class="modal"
    v-show="formData.id == selected_id"
    v-for="formData in leaveForms"
    :key="formData.id"
    @click.self="closeFormModal"
  >
    <ImageViewer
      v-if="src"
      :src="src"
      @toggleLargeImgViewer="toggleLargeImgViewer"
    ></ImageViewer>
    <div class="modal-content">
      <div class="modal-header">
        <span class="title">Leave Application</span>
        <span @click="closeFormModal" class="x-btn">&times;</span>
      </div>
      <!-- <div class="heading-container">
        <div class="heading-img">
          <img src="/public/assets/images/mdc-logo.png" alt="MDC LOGO" />
        </div>
        <div class="heading-text">
          <text class="first">Mater Dei College</text>
          <text class="second">Tubigon, Bohol</text>
          <text class="third">HUMAN RESOURCE OFFICE</text>
        </div>
      </div>
      <div class="modal-title">
        <text>Leave Application Form</text>
      </div> -->
      <div class="modal-details">
        <div>
          <div class="modal-subtitle">
            <text>Leave type:</text>
          </div>

          <div class="row">
            <div class="radio-group read-only">
              <text class="underline">{{ formData.leave_type }}</text>
            </div>
          </div>

          <div class="modal-items read-only">
            <div
              v-if="
                formData.leave_type == 'Personal' &&
                formData.leave_type_option != 'Vacation'
              "
            >
              <span> Reason: {{ formData.leave_type_option }}</span>
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
          <div class="section-dates">
            <div class="input-date">
              <label for="date_start">Start date: </label>
              <span class="underline">{{ formData.date_start }}</span>
            </div>

            <div class="input-date">
              <label for="date_end">End date:</label>
              <span class="underline">{{ formData.date_end }}</span>
            </div>
          </div>

          <div class="radio-group" v-if="formData.status === 'endorsed'">
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
            v-if="submission_type === 'disapproval' && formData.status == 'endorsed'"
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
        <div v-if="roles.includes('dean') || roles.includes('admin')">
          <div class="modal-subtitle">
            <text>Substitute(s): </text>
            <span>{{ formData.substitutes.length == 0 ? "None" : "" }}</span>
          </div>

          <div>
            <ul v-for="substitute in formData.substitutes">
              <li>
                {{ substitute.subject }} | {{ substitute.days }} -
                {{ substitute.user.last_name }},
                {{ substitute.user.first_name }}
              </li>
            </ul>
          </div>

          <div class="description" v-if="formData.substitutes.length === 0">
            <label for="">Class Alternatives:</label>
            <text>
              {{ formData.description }}
            </text>
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
          <div class="certification-item">
            <text>Name of Applicant:</text>
            <span class="underline">
              {{ formData.user.last_name }},
              {{ formData.user.first_name }}
              {{ formData.user.middle_name[0] }}.
            </span>
          </div>

          <div class="certification-item">
            <text>Date Hired:</text>
            <span class="underline">
              {{ formData.user_job_detail.date_hired }}
            </span>
          </div>

          <table>
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
                  {{
                    calculateAvailablePersonalLeave(formData.user_job_detail.date_hired)
                  }}
                  <small> day(s)</small>
                </td>
                <td class="end">
                  {{ calculateAvailableSickLeave(formData.user_job_detail.date_hired) }}
                  <small> day(s)</small>
                </td>
              </tr>
              <tr>
                <td>Availed leave credits</td>
                <td class="end">
                  <span>{{
                    calculateLeave(formData.user_id, "personal", formData.leave_type)
                  }}</span>
                  <small> day(s)</small>
                </td>
                <td class="end">
                  <span>{{
                    calculateLeave(formData.user_id, "sick", formData.leave_type)
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
                      ? sickLeaveCount + totalCurrentSickLeave
                      : totalCurrentSickLeave
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
                    calculateAvailablePersonalLeave(formData.user_job_detail.date_hired) -
                    (formData.leave_type != "Sick"
                      ? sickLeaveCount + totalCurrentSickLeave
                      : totalCurrentSickLeave)
                  }}
                  <small> day(s) left</small>
                </td>
                <td class="end">
                  {{
                    calculateAvailableSickLeave(formData.user_job_detail.date_hired) -
                    (formData.leave_type == "Sick"
                      ? sickLeaveCount + totalCurrentSickLeave
                      : totalCurrentSickLeave)
                  }}
                  <small> day(s) left</small>
                </td>
              </tr>
            </tbody>
          </table>

          <div
            class="modal-item"
            v-if="
              formData.status === 'recommended' || formData.status === 'finance_approved'
            "
          >
            <div>
              <label for="">Submit as:</label>
              <div class="submission-selection">
                <label for="approval">
                  <input
                    type="radio"
                    v-model="submission_type"
                    id="approval"
                    name="submission"
                    value="approval"
                  />
                  Approval</label
                >

                <label for="disapproval">
                  <input
                    type="radio"
                    v-model="submission_type"
                    id="disapproval"
                    name="submission"
                    value="disapproval"
                  />
                  Disapproval</label
                >
              </div>
            </div>
          </div>

          <div class="modal-item" v-if="formData.status === 'recommended'">
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
              v-if="submission_type == 'disapproval' && formData.status == 'recommended'"
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
              submission_type == 'disapproval' && formData.status == 'finance_approved'
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
        </div>
      </div>
      <div class="btn-container" v-if="formData.status == 'pending'">
        <button
          type="button"
          title="Close the form"
          class="close-btn"
          @click="closeFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="toggleConfirmForm('endorse')"
          class="submit-btn"
          title="Forward to VP Acads and VP Finance"
        >
          Endorse
        </button>
      </div>
      <div
        class="btn-container"
        v-if="
          (formData.status == 'endorsed' &&
            (submission_type === 'approval'
              ? disapproval_description == null
              : disapproval_description)) ||
          (submission_type === 'disapproval'
            ? disapproval_description
            : disapproval_description)
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="closeFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="toggleConfirmForm('recommend')"
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>

      <div class="btn-container" v-if="formData.status == 'recommended'">
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="closeFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="toggleConfirmForm('finance_approval')"
          class="submit-btn"
          title="Proceed to Approval"
        >
          Submit
        </button>
      </div>

      <div
        class="btn-container"
        v-if="
          ((submission_type === 'approval'
            ? disapproval_description == null
            : disapproval_description) &&
            formData.status === 'finance_approved') ||
          (submission_type === 'disapproval' &&
            disapproval_description &&
            formData.status === 'finance_approved')
        "
      >
        <button
          type="button"
          class="close-btn"
          title="Close the form"
          @click="closeFormModal"
        >
          Close
        </button>
        <button
          type="submit"
          @click="toggleConfirmForm(submission_type)"
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
