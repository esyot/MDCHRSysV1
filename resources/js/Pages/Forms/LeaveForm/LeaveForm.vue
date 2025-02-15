<script src="./js/leave-form.js"></script>
<style scoped>
@import "./css/leave-form.css";
</style>

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
          <span class="title">DETAILS OF APPLICATION</span>
        </div>
        <div class="form-section">
          <label for="leave_name">TYPE OF LEAVE:</label>
          <select
            id="leave_name"
            v-model="formData.leave_type"
            class="forms-controller"
            required
          >
            <option value="" disabled selected>Select type of leave</option>
            <option value="Personal">Personal</option>
            <option value="Maternity">Maternity</option>
            <option value="Paternity">Peternity</option>
            <option value="Sick">Sick</option>
            <option value="Educational">Educational</option>
            <option value="Others">Others</option>
          </select>
        </div>

        <div class="form-section" v-if="formData.leave_type == 'Personal'">
          <label for="leave_name">Select type of Personal leave:</label>
          <select
            id="leave_name"
            v-model="formData.leave_type_option"
            class="forms-controller"
            required
          >
            <option value="" disabled selected>Select type of Personal Leave</option>
            <option value="Vacation">Vacation Leave</option>
            <option value="Fiesta">Fiesta Leave</option>
            <option value="Birthday">Birthday Leave</option>
          </select>
        </div>

        <div class="form-section" v-if="formData.leave_type_option === 'Vacation'">
          <label for="leave_type_vacation">In case of Vacation Leave:</label>
          <select id="leave_type_vacation" v-model="formData.vacation_option" required>
            <option value="" disabled selected>Select a country</option>
            <option value="Within the Philippines">Within the Philippines</option>
            <option value="Abroad">Abroad</option>
          </select>
        </div>

        <div
          class="form-section"
          v-if="
            formData.leave_type_option === 'Vacation' &&
            formData.vacation_option === 'Within the Philippines'
          "
        >
          <label for="leave_vacation_phil"
            >If within the Philippines, please specify:</label
          >
          <input
            type="text"
            id="leave_vacation_phil"
            class="forms-controller"
            v-model="formData.address"
            placeholder="eg., Bohol, Tubigon"
            required
          />
        </div>
        <div class="form-section" v-if="formData.vacation_option === 'Abroad'">
          <label for="leave_vacation_abroad">If Abroad, please specify:</label>
          <input
            type="text"
            id="leave_vacation_abroad"
            class="forms-controller"
            v-model="formData.address"
            placeholder="eg., Tokyo, Japan"
            required
          />
        </div>
        <div class="form-section" v-if="formData.leave_type === 'Sick'">
          <label for="leave_type_sick">In case of Sick Leave:</label>
          <select id="leave_type_sick" v-model="formData.convalescence_place" required>
            <option value="In Hospital">In Hospital</option>
            <option value="Out Patient">Out Patient</option>
            <option value="Home Medication">Home Medication</option>
          </select>
        </div>
        <div
          class="form-section"
          v-if="
            formData.leave_type === 'Sick' &&
            formData.convalescence_place === 'In Hospital'
          "
        >
          <label for="leave_sick_hospital"
            >If in Hospital, please specify your illness:</label
          >
          <input
            type="text"
            id="leave_sick_hospital"
            class="forms-controller"
            placeholder="eg., Fever"
            v-model="formData.illness"
            required
          />
        </div>

        <div
          class="form-section"
          v-if="
            formData.leave_type === 'Sick' &&
            formData.convalescence_place === 'In Hospital'
          "
        >
          <label for="leave_sick_hospital_address"
            >If in Hospital, please specify address of Hospital:</label
          >
          <input
            type="text"
            id="leave_sick_hospital_address"
            class="forms-controller"
            placeholder="eg., Tubigon Center"
            v-model="formData.address"
            required
          />
        </div>
        <div
          class="form-section"
          v-if="
            formData.leave_type === 'Sick' &&
            formData.convalescence_place === 'Out Patient'
          "
        >
          <label for="leave_sick_outpatient">Specify illness:</label>
          <input
            type="text"
            id="leave_sick_outpatient"
            class="forms-controller"
            placeholder="eg., Fever"
            v-model="formData.illness"
            required
          />
        </div>

        <div
          class="form-section"
          v-if="
            formData.leave_type === 'Sick' &&
            formData.convalescence_place === 'Home Medication'
          "
        >
          <label for="leave_sick_home_medication"
            >If Home Medication, please specify ILLNESS:</label
          >
          <input
            type="text"
            id="leave_sick_home_medication"
            class="forms-controller"
            v-model="formData.illness"
            placeholder="eg., Headache"
            required
          />
        </div>

        <div class="form-section" v-if="formData.leave_type === 'Educational'">
          <label for="leave_type_educational"> In case of Educational Leave: </label>
          <select id="leave_type_educational" v-model="formData.reason" required>
            <option value="Completion of Doctor's Degree">
              Completion of Doctor's Degree
            </option>
            <option value="Completion of Master's Degree">
              Completion of Master's Degree
            </option>
            <option value="Board Examination Review">Board Examination Review</option>
            <option value="Others">Others</option>
          </select>
        </div>
        <div
          class="form-section"
          v-if="formData.leave_type == 'Educational' && formData.reason === 'Others'"
        >
          <label for="leave_educ_others">Please specify:</label>
          <input
            type="text"
            id="leave_educ_others"
            class="forms-controller"
            v-model="formData.other_reason"
            placeholder="eg., Completion of Certification"
            required
          />
        </div>

        <div class="form-section" v-if="formData.leave_type === 'Others'">
          <label for="leave_type_others">If Others, please specify:</label>
          <input
            type="text"
            id="leave_type_others"
            class="forms-controller"
            placeholder="Enter details..."
            v-model="formData.other_reason"
            required
          />
        </div>
        <div class="form-section" v-if="formData.leave_type === 'Sick'">
          <label for="date_start">Date of confinement:</label>
          <input
            type="date"
            id="date_start"
            class="forms-controller"
            v-model="formData.date_start"
            required
          />
        </div>

        <div class="form-section" v-if="formData.leave_type === 'Sick'">
          <label for="date_end">Date of discharge:</label>
          <input
            type="date"
            id="date_end"
            class="forms-controller"
            v-model="formData.date_end"
            required
          />
        </div>

        <div class="form-section">
          <label for="date_start">Date start of leave:</label>
          <input
            type="date"
            id="date_start"
            class="forms-controller"
            v-model="formData.date_start"
            required
          />
        </div>

        <div class="form-section">
          <label for="date_end">Date end of leave:</label>
          <input
            type="date"
            id="date_end"
            class="forms-controller"
            v-model="formData.date_end"
            required
          />
        </div>

        <div class="form-section" v-if="formData.leave_type === 'Sick'">
          <label for=""
            >Upload a photo of supporting document (Medical certificate, Medical Check-up,
            etc.)</label
          >
          <input type="file" @change="handleFileChange" required />
          <small>Note: <i>selected file must be in .jpg format</i></small>
        </div>

        <div class="form-section" v-if="roles.includes('teacher')">
          <label for="date_end">Do you have a substitute teacher?</label>

          <div class="radio-container">
            <div class="radio" for="yes-substitute">
              <input
                type="radio"
                id="yes-substitute"
                class="forms-controller"
                v-model="formData.substitute"
                :value="true"
              />
              <span> Yes</span>
            </div>

            <div class="radio" for="no-substitute">
              <input
                type="radio"
                id="no-substitute"
                class="forms-controller"
                v-model="formData.substitute"
                :value="false"
              />
              <span> No</span>
            </div>
          </div>
        </div>
        <div v-if="!formData.substitute" class="form-section">
          <label for="date_end">Please specify the alternatives used to the class.</label>
          <textarea
            type="text"
            v-model="formData.description"
            placeholder="Input text here."
            required
          />
        </div>
      </div>
      <div class="forms" v-if="formData.substitute">
        <div class="forms-title">
          <span class="title">SUBSTITUTE</span>
          <button type="button" @click="addTeachingSubstitute">
            <i class="fas fa-plus"></i> Add
          </button>
          <small><i>(For MDC Teaching Employee only)</i></small>
        </div>

        <div
          v-for="(substitute, index) in teachingSubstitutes"
          :key="index"
          class="substitute-form"
        >
          <div class="form-section">
            <label for="'subject' + index">Subject</label>
            <input
              type="text"
              :id="'subject' + index"
              class="forms-controller"
              v-model="substitute.subject"
              placeholder="eg., Math 101"
              required
            />
          </div>

          <div class="form-section">
            <label for="'teacher' + index">Substitute Teacher</label>
            <div class="search-bar">
              <input
                title="Add teacher"
                type="text"
                :id="'teacher' + index"
                v-model="teachingSubstitutes[index].teacher"
                placeholder="Click to search teacher"
                @input="toggleSearchTeacher(teachingSubstitutes[index].teacher, index)"
                required
              />
            </div>
            <div class="dropdown-teachers">
              <ul v-if="searchTeacher">
                <li
                  @click="selectTeacher(user.id, index)"
                  v-for="user in filteredUsers"
                  :key="user.id"
                >
                  {{ user.last_name }}, {{ user.first_name }}
                </li>
              </ul>
            </div>
          </div>

          <div class="form-section">
            <div class="days">
              <div class="days-item" v-for="(day, dayIndex) in days" :key="dayIndex">
                <input
                  type="checkbox"
                  :id="'day' + index + '-' + dayIndex"
                  :value="day"
                  v-model="substitute.days"
                />
                <span>{{ day }}</span>
              </div>
            </div>
          </div>

          <div class="form-section">
            <label for="'start_time' + index">Start Time</label>
            <input
              type="time"
              :id="'start_time' + index"
              required
              class="forms-controller"
              v-model="substitute.start_time"
            />
          </div>

          <div class="form-section">
            <label for="'end_time' + index">End Time</label>
            <input
              type="time"
              :id="'end_time' + index"
              class="forms-controller"
              v-model="substitute.end_time"
              required
            />
          </div>

          <div class="button-container">
            <button @click="removeTeachingSubstitute(index)" class="remove-btn">
              <i class="fa fa-trash"></i> Remove
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="form-submit">
      <button type="submit" class="submit" title="Submit for approval">Submit</button>
    </div>
  </form>
</template>
