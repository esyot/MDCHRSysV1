<script>
import { Inertia } from "@inertiajs/inertia";
export default {
  emits: ["toggleFormModal"],
  props: {
    leaveForms: Object,
    selected_id: String,
    selected_type: String,
  },
  data() {
    return {
      submission_type: "approval",
      disapproval_description: "",
      currentYear: new Date().getFullYear(),
      personalLeaveCount: 0,
      sickLeaveCount: 0,
      totalCurrentSickLeave: 0,
      totalCurrentPersonalLeave: 0,
      availableLeaveCount: 0,
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
    submitForm(id, action) {
      const formData = {
        id: id,
        form_type: this.selected_type,
        submission_type: this.submission_type,
        submission_description: this.submission_description,
        action: action,
      };

      Inertia.post("/forms/checking/forward", formData);

      this.closeFormModal;
    },

    closeFormModal() {
      this.$emit("toggleFormModal");
    },

    calculateLeave(user_id, type, current_leave_type) {
      let leaveCount = 0;
      let totalDays = 0;

      if (type === "sick") {
        const filteredArray = this.leaveForms.filter((item) => {
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

        if (current_leave_type == "Sick") {
          this.totalCurrentSickLeave = totalDays;
        }

        return totalDays;
      } else {
        const filteredArray = this.leaveForms.filter((item) => {
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
};
</script>

<template>
  <div
    :id="`modal-leave-form-${formData.id}`"
    class="modal"
    v-show="formData.id == selected_id"
    v-for="formData in leaveForms"
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
      <div class="modal-title">
        <text>Leave Application Form</text>
      </div>
      <div class="modal-details">
        <div>
          <div class="modal-subtitle">
            <text>Leave type</text>
          </div>

          <div class="row">
            <div class="radio-group">
              <label
                ><input type="radio" :checked="formData.leave_type === 'Personal'" />
                Personal</label
              >
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
                Paternity</label
              >

              <label>
                <input type="radio" :checked="formData.leave_type == 'Sick'" />
                Sick</label
              >
              <label
                ><input
                  type="radio"
                  :checked="formData.leave_type == 'Educational'"
                  name="leave_type"
                />
                Educational
              </label>
              <label>
                <input type="radio" name="leave_type" /> Others: <input type="text" />
              </label>
            </div>

            <div class="section-dates">
              <div class="input-date">
                <label for="date_start">Start date: </label>
                <input
                  type="text"
                  id="date_start"
                  v-model="formData.date_start"
                  name="date_start"
                />
              </div>

              <div class="input-date">
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

          <div class="modal-subtitle">
            <text>Details of Leave</text>
          </div>

          <div class="modal-details">
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
              <label
                ><input
                  type="checkbox"
                  class="sub-checkbox"
                  :checked="formData.vacation_option === 'Within the Philippines'"
                />
                Within Philippines (Specify)
              </label>
              <input type="text" v-model="formData.address" />

              <label v-if="formData.leave_type == 'Abroad'"
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
              <span class="sub-title">Sick Leave: </span>
              <label
                ><input
                  type="checkbox"
                  :checked="formData.convalescence_place == 'Hospital'"
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

              <div class="input-group">
                <span class="sub-title"> Illness: </span>
                <input
                  type="input"
                  v-model="formData.illness"
                  class="sub-checkbox"
                  name="sick_home"
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
          <div class="textarea-container" v-if="submission_type === 'disapproval'">
            <textarea
              placeholder="Input a description for disapproval."
              name=""
              v-model="disapproval_description"
              id=""
              required
            ></textarea>
          </div>
        </div>

        <div class="certitification-credits" v-if="formData.status == 'pending'">
          <div class="certification-title">
            <text>Certification of Leave Credits as of</text>

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
                  {{ calculateLeave(formData.user_id, "personal", formData.leave_type) }}
                  <small> day(s)</small>
                </td>
                <td class="end">
                  {{ calculateLeave(formData.user_id, "sick", formData.leave_type) }}

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
                      ? personalLeaveCount + totalCurrentPersonalLeave
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
                    calculateAvailablePersonalLeave(formData.user_job_detail.date_hired) -
                    (formData.leave_type != "Sick"
                      ? personalLeaveCount + totalCurrentPersonalLeave
                      : totalCurrentPersonalLeave)
                  }}
                  <small> day(s) left</small>
                </td>
                <td class="end">
                  {{
                    formData.leave_type == "Sick"
                      ? calculateAvailableSickLeave(formData.user_job_detail.date_hired) -
                        (formData.leave_type != "Sick"
                          ? personalLeaveCount + totalCurrentPersonalLeave
                          : totalCurrentPersonalLeave)
                      : calculateAvailableSickLeave(formData.user_job_detail.date_hired)
                  }}
                  <small> day(s) left</small>
                </td>
              </tr>
            </tbody>
          </table>
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
              @click="submitForm(formData.id, 'endorse')"
              class="submit-btn"
              title="Forward to VP Acads and VP Finance"
            >
              Endorse
            </button>
          </div>
        </div>
      </div>
      <div class="btn-container" v-if="formData.status == 'endorsed'">
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
          @click="submitForm(formData.id, 'recommend')"
          class="submit-btn"
          title="Proceed to Approval"
        >
          Recommend
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/leave-form-modal.css";
</style>
