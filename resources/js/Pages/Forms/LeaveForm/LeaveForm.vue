<script src="./js/leave-form.js"></script>

<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @submitForm="submitForm"
    @toggleConfirmForm="toggleConfirmForm"
  ></ConfirmationFormModal>

  <form @submit.prevent="submit">
    <div class="form-container">
      <div class="form-item">
        <div class="form-item-title">
          <span>Leave Details</span>
        </div>

        <div class="form-item-section">
          <label for="term">Term:</label>
          <WhenVisible data="terms">
            <template #fallback>
              <FormLoader :message="'fetching terms, please wait.'"></FormLoader>
            </template>
            <select name="" id="" v-model="formData.term_id" required>
              <option value="" disabled selected>Select Term</option>
              <option :value="term.id" v-for="(term, index) in terms" :key="index">
                {{ term.name }}
              </option>
            </select>

            <small class="error-msg" v-if="errors.term_id"> {{ errors.term_id }}</small>
          </WhenVisible>
        </div>

        <div class="form-item-section">
          <label for="leave_name">TYPE OF LEAVE:</label>
          <select id="leave_name" v-model="formData.leave_type" required>
            <option value="" disabled selected>Select type of leave</option>
            <option value="Personal">Personal</option>
            <option value="Maternity">Maternity</option>
            <option value="Paternity">Paternity</option>
            <option value="Sick">Sick</option>
            <option value="Educational">Educational</option>
            <option value="Others">Others</option>
          </select>

          <small class="error-msg" v-if="errors.leave_type">
            {{ errors.leave_type }}</small
          >
        </div>

        <div class="form-item-section" v-if="formData.leave_type == 'Personal'">
          <label for="leave_name">Select type of Personal leave:</label>
          <select id="leave_name" v-model="formData.leave_type_option" required>
            <option value="" disabled selected>Select type of Personal Leave</option>
            <option value="Vacation">Vacation Leave</option>
            <option value="Fiesta">Fiesta Leave</option>
            <option value="Birthday">Birthday Leave</option>
          </select>

          <small class="error-msg" v-if="errors.leave_type_option">
            {{ errors.leave_type_option }}</small
          >
        </div>

        <div class="form-item-section" v-if="formData.leave_type_option === 'Vacation'">
          <label for="leave_type_vacation">In case of Vacation Leave:</label>
          <select id="leave_type_vacation" v-model="formData.vacation_option" required>
            <option value="" disabled selected>Select a country</option>
            <option value="Within the Philippines">Within the Philippines</option>
            <option value="Abroad">Abroad</option>
          </select>

          <small class="error-msg" v-if="errors.vacation_option">
            {{ errors.vacation_option }}</small
          >
        </div>

        <div
          class="form-item-section"
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
            v-model="formData.address"
            placeholder="eg., Bohol, Tubigon"
            required
          />

          <small class="error-msg" v-if="errors.address">{{ errors.address }}</small>
        </div>
        <div class="form-item-section" v-if="formData.vacation_option === 'Abroad'">
          <label for="leave_vacation_abroad">If Abroad, please specify:</label>
          <input
            type="text"
            id="leave_vacation_abroad"
            v-model="formData.address"
            placeholder="eg., Tokyo, Japan"
            required
          />
          <small class="error-msg" v-if="errors.address">{{ errors.address }}</small>
        </div>
        <div class="form-item-section" v-if="formData.leave_type === 'Sick'">
          <label for="leave_type_sick">In case of Sick Leave:</label>

          <select id="leave_type_sick" v-model="formData.convalescence_place" required>
            <option value="" selected disabled>Select Recovery Place</option>
            <option value="In Hospital">In Hospital</option>
            <option value="Out Patient">Out Patient</option>
            <option value="Home Medication">Home Medication</option>
          </select>

          <small class="error-msg" v-if="errors.convalescence_place">
            {{ errors.convalescence_place }}</small
          >
        </div>
        <div class="form-item-section" v-if="formData.leave_type === 'Sick'">
          <label for="leave_sick_hospital">Please specify your illness: </label>
          <input
            type="text"
            v-model="formData.illness"
            @input="fetchCondition(formData.illness)"
            placeholder="Search for a condition..."
          />

          <small class="error-msg" v-if="errors.illness"> {{ errors.illness }}</small>

          <div v-if="isDisplaySuggestion" class="form-item-section-dropdown">
            <ul>
              <li
                v-for="(suggestion, index) in suggestions"
                :key="index"
                @click="selectedSuggestion(suggestion)"
              >
                {{ suggestion }}
              </li>
            </ul>
          </div>
        </div>

        <div
          class="form-item-section"
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
            placeholder="eg., Tubigon Center"
            v-model="formData.address"
            required
          />
          <small class="error-msg" v-if="errors.address">{{ errors.address }}</small>
        </div>

        <div class="form-item-section" v-if="formData.leave_type === 'Educational'">
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

          <small class="error-msg" v-if="errors.reason">{{ errors.reason }}</small>
        </div>
        <div
          class="form-item-section"
          v-if="formData.leave_type == 'Educational' && formData.reason === 'Others'"
        >
          <label for="leave_educ_others">Please specify:</label>
          <input
            type="text"
            id="leave_educ_others"
            v-model="formData.other_reason"
            placeholder="eg., Completion of Certification"
            required
          />

          <small class="error-msg" v-if="errors.other_reason">
            {{ errors.other_reason }}</small
          >
        </div>

        <div class="form-item-section" v-if="formData.leave_type === 'Others'">
          <label for="leave_type_others">If Others, please specify:</label>
          <input
            type="text"
            id="leave_type_others"
            placeholder="Enter details..."
            v-model="formData.other_reason"
            required
          />

          <small class="error-msg" v-if="errors.other_reason"
            >{{ errors.other_reason }}
          </small>
        </div>
        <div class="form-item-section" v-if="formData.leave_type === 'Sick'">
          <label for="date_of_confinement">Date of confinement:</label>
          <input
            type="date"
            id="date_of_confinement"
            v-model="formData.date_of_confinement"
            required
          />
          <small class="error-msg" v-if="errors.date_of_confinement">
            {{ errors.date_of_confinement }}</small
          >
        </div>

        <div class="form-item-section" v-if="formData.leave_type === 'Sick'">
          <label for="date_of_discharge">Date of discharge:</label>
          <input
            type="date"
            id="date_of_discharge"
            v-model="formData.date_of_discharge"
            required
          />

          <small class="error-msg" v-if="errors.date_of_discharge">
            {{ errors.date_of_discharge }}</small
          >
        </div>

        <div class="form-item-section">
          <label for="date_start">Date start of leave:</label>
          <input type="date" id="date_start" v-model="formData.date_start" required />

          <small class="error-msg" v-if="errors.date_start">{{
            errors.date_start
          }}</small>
        </div>

        <div class="form-item-section">
          <label for="date_end">Date end of leave:</label>
          <input type="date" id="date_end" v-model="formData.date_end" required />
          <small class="error-msg" v-if="errors.date_end">{{ errors.date_end }}</small>
        </div>

        <div class="form-item-section" v-if="formData.leave_type === 'Sick'">
          <label for=""
            >Upload a photo of supporting document (Medical certificate, Medical Check-up,
            etc.)</label
          >
          <input
            type="file"
            @change="handleFileChange"
            required
            accept=".jpg,.jpeg,.png"
          />

          <small>Note: <i>selected file must be in .jpg format</i></small>
          <small class="error-msg" v-if="errors.medical_certificate">{{
            errors.medical_certificate
          }}</small>
        </div>

        <div class="form-item-section" v-if="roles.includes('teacher')">
          <label for="date_end">Do you have a substitute teacher?</label>

          <div class="form-item-section-radio-1">
            <div class="radio" for="yes-substitute">
              <input
                type="radio"
                id="yes-substitute"
                v-model="isSubstitute"
                :value="true"
              />
              <span> Yes</span>
            </div>

            <div class="radio" for="no-substitute">
              <input
                type="radio"
                id="no-substitute"
                v-model="isSubstitute"
                :value="false"
              />
              <span> No</span>
            </div>
          </div>
        </div>
        <div v-if="!isSubstitute && roles.includes('teacher')" class="form-item-section">
          <label for="class_description">
            Please specify the alternatives used in the class during your absence.
          </label>

          <textarea
            id="class_description"
            type="text"
            v-model="formData.class_description"
            placeholder="Input text here."
            required
          />
        </div>
      </div>

      <div class="form-item" v-if="isSubstitute">
        <div class="form-item-title">
          <span>Substitute</span>
          <button type="button" @click="addTeachingSubstitute">
            <i class="fas fa-plus"></i> Add
          </button>
        </div>

        <div
          v-for="(substitute, index) in teachingSubstitutes"
          :key="index"
          class="substitute-form"
        >
          <div class="form-item-section">
            <label for="'subject' + index">Subject</label>

            <select
              :id="'subject' + index"
              v-model="teachingSubstitutes[index].subject_id"
              required
            >
              <option value="" selected disabled>Select a subject</option>
              <option
                :disabled="isSubjectDisabled(subject.id)"
                :value="subject.id"
                v-for="(subject, index) in subjects"
                :key="index"
              >
                {{ subject.course_no }} - {{ subject.description }}
              </option>
            </select>
          </div>

          <div class="form-item-section">
            <label :for="'teacher' + index">Substitute Teacher:</label>
            <input
              title="Add teacher"
              type="text"
              :id="'teacher' + index"
              v-model="teachingSubstitutes[index].teacher"
              placeholder="Click to search teacher"
              @input="toggleSearchTeacher(teachingSubstitutes[index].teacher, index)"
              required
            />

            <div class="form-item-section-dropdown">
              <ul v-if="searchTeacher">
                <li
                  @click="selectTeacher(teacher.id, index)"
                  v-for="teacher in teachers"
                  :key="teacher.id"
                >
                  {{ teacher.last_name }}, {{ teacher.first_name }}
                </li>
                <li class="empty-msg" v-if="teachers.length === 0">
                  <small class="error-msg" v-if="!teachingSubstitutes[index].user_id"
                    >No match found!</small
                  >
                </li>
              </ul>
            </div>
            <small class="error-msg" v-if="!teachingSubstitutes[index].user_id"
              >Select a valid teacher</small
            >
          </div>

          <div class="form-item-section">
            <div class="form-item-section-radio-2">
              <div class="radio" v-for="(day, dayIndex) in days" :key="dayIndex">
                <input
                  type="checkbox"
                  :id="'day' + index + '-' + dayIndex"
                  :value="day"
                  v-model="substitute.days"
                />
                <span>{{ day }}</span>
              </div>
            </div>
            <small
              v-if="substitute.days && substitute.days.length === 0"
              class="error-msg"
            >
              At least one day must be selected.
            </small>
          </div>

          <div class="form-item-section">
            <label for="'start_time' + index">Start Time</label>
            <input
              type="time"
              :id="'start_time' + index"
              required
              v-model="substitute.start_time"
              value="00:00"
            />
          </div>

          <div class="form-item-section">
            <label for="'end_time' + index">End Time</label>
            <input
              type="time"
              :id="'end_time' + index"
              v-model="substitute.end_time"
              value="00:00"
              required
            />
          </div>

          <div class="form-item-section">
            <div class="form-item-section-button">
              <button
                type="button"
                @click="removeTeachingSubstitute(index)"
                class="remove-button"
              >
                <i class="fa fa-trash"></i> Remove
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-item-section-submit">
      <button type="submit" title="Submit for approval">
        {{ formDataToEditCopy ? "Re-Submit Application" : "Submit Application" }}
      </button>
    </div>
  </form>
</template>
<style lang="scss" scoped>
@import "./css/leave-form.css";
</style>
