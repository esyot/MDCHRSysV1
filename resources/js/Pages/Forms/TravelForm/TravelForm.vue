<script src="./js/travel-form.js"></script>
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
          <span>Travel Details</span>
        </div>
        <div class="form-item-section">
          <label for="term">Select Term:</label>
          <select id v-model="formData.term_id" required>
            <option value="" disabled selected>Select Term</option>
            <option :value="term.id" v-for="(term, index) in terms" :key="index">
              {{ term.name }}
            </option>
          </select>

          <small class="error-msg" v-if="errors.term_id"> {{ errors.term_id }}</small>
        </div>
        <div class="form-item-section">
          <label for="date_start">Date Start of Travel:</label>
          <input type="date" id="date_start" v-model="formData.date_start" required />

          <small class="error-msg" v-if="errors.date_start">
            {{ errors.date_start }}
          </small>
        </div>

        <div class="form-item-section">
          <label for="date_end">Date End of Travel:</label>
          <input type="date" id="date_end" v-model="formData.date_end" required />

          <small class="error-msg" v-if="errors.date_end"> {{ errors.date_end }}</small>
        </div>

        <div class="form-item-section">
          <label for="destination">Destination:</label>
          <input
            type="text"
            id="destination"
            v-model="formData.destination"
            placeholder="Enter the destination of travel eg. 'Tokyo, Japan'"
            required
            @input="fetchPlaceSuggestions(formData.destination)"
          />
          <small class="error-msg" v-if="errors.destination">
            {{ errors.destination }}
          </small>
          <div v-if="isDisplaySuggestion" class="form-item-section-dropdown">
            <ul
              v-for="(suggestion, index) in suggestions"
              :key="index"
              @click="selectedSuggestion(suggestion)"
            >
              <li>{{ suggestion }}</li>
            </ul>
          </div>
        </div>

        <div class="form-item-section">
          <label for="purpose">Purpose/Event:</label>
          <input
            type="text"
            id="purpose"
            v-model="formData.purpose"
            placeholder="Enter the purpose or event"
            required
          />

          <small class="errors-msg" v-if="errors.purpose"> {{ errors.purpose }}</small>
        </div>

        <div class="form-item-section">
          <label for="contact_person">Contact Person:</label>
          <input
            type="text"
            id="contact_person"
            v-model="formData.contact_person"
            placeholder="Enter the organizer or contact person"
            required
          />

          <small class="error-msg" v-if="errors.contact_person">
            {{ errors.contact_person }}</small
          >
        </div>

        <div class="form-item-section">
          <label for="contact_person_no">Organizer/Contact Person's No:</label>
          <input
            type="text"
            id="contact_person_no"
            v-model="formData.contact_person_no"
            placeholder="Enter the organizer or contact person's contact number"
            required
          />

          <small class="error-msg" v-if="errors.contact_person_no">
            {{ errors.contact_person_no }}</small
          >
        </div>

        <div class="form-item-section">
          <label for="description">Short Description:</label>
          <textarea
            id="description"
            v-model="formData.description"
            placeholder="Enter a short description of the purpose or event"
            rows="4"
            required
          ></textarea>

          <small class="error-msg" v-if="errors.description">
            {{ errors.description }}</small
          >
        </div>
      </div>

      <div class="form-item">
        <div class="form-item-title">
          <span>Budget Requirements</span>
        </div>

        <div class="form-item-section-devided">
          <div class="form-item-section-devided-item">
            <div class="form-item-section-devided-title">
              <label>Budget type:</label>
            </div>

            <div
              class="form-item-section-devided-radio"
              v-for="item in budgetTypes"
              :key="item.id"
            >
              <input
                type="radio"
                :id="item.value"
                v-model="formData.budget_type"
                :value="item.value"
              />
              <label :for="item.id">{{ item.label }}</label>
            </div>
            <small class="error-msg" v-if="errors.budget_type">{{
              errors.budget_type
            }}</small>
          </div>

          <div class="form-item-section-devided-item">
            <div class="form-item-section-devided-title">
              <label>Budget charged to:</label>
            </div>

            <div
              class="form-item-section-devided-radio"
              v-for="item in budgetCharges"
              :key="item.id"
            >
              <input
                type="radio"
                :id="item.value"
                v-model="formData.budget_charged_to"
                :value="item.value"
              />
              <label :for="item.value">{{ item.label }}</label>
            </div>
            <small class="error-msg" v-if="errors.budget_charged_to">
              {{ errors.budget_charged_to }}</small
            >
          </div>
        </div>

        <div class="form-item-section">
          <label for="amount">Budget Amount:</label>
          <input
            type="number"
            id="amount"
            v-model="formData.amount"
            placeholder="Enter amount requested"
            required
          />

          <small class="error-msg" v-if="errors.amount"> {{ errors.amount }}</small>
        </div>

        <div class="form-item-section" v-if="roles.includes('teacher')">
          <label for="isSubstitute">Do you have a substitute teacher?</label>

          <div id="isSubstitute" class="form-item-section-radio-1">
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
        <div v-if="!isSubstitute" class="form-item-section">
          <label for="alternative_description">
            Please specify the alternatives used in the class during your absence.
          </label>

          <textarea
            id="alternative_description"
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
          <div>
            <button type="button" @click="addTeachingSubstitute">
              <i class="fas fa-plus"></i> Add
            </button>
          </div>
        </div>

        <div
          v-for="(substitute, index) in teachingSubstitutes"
          :key="index"
          class="substitute-form"
        >
          <div class="form-item-section">
            <label :for="'subject' + index">Subject:</label>
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
            <label :for="'days' + index">Days:</label>
            <div class="form-item-section-radio-2">
              <div class="radio" v-for="(day, dayIndex) in days" :key="dayIndex">
                <input
                  type="checkbox"
                  :id="'day' + index + '-' + dayIndex"
                  :value="day"
                  v-model="substitute.days"
                  @change="validateDays(index)"
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
            <label :for="'start_time' + index">Start Time:</label>
            <input
              type="time"
              :id="'start_time' + index"
              required
              v-model="substitute.start_time"
            />
          </div>

          <div class="form-item-section">
            <label :for="'end_time' + index">End Time</label>
            <input
              type="time"
              :id="'end_time' + index"
              v-model="substitute.end_time"
              required
            />
          </div>

          <div class="form-item-section">
            <div class="form-item-section-button">
              <button @click="removeTeachingSubstitute(index)" class="remove-button">
                <i class="fa fa-trash"></i>
                <span> Remove</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-item-section-submit">
      <button type="submit" class="submit" title="Submit for approval">
        {{ formDataToEditCopy ? "Re-Submit Application" : "Submit Application" }}
      </button>
    </div>
  </form>
</template>

<style lang="scss" scoped>
@import "./css/travel-form.css";
</style>
