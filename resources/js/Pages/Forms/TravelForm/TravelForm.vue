<script src="./js/travel-form.js"></script>
<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @submitForm="submitForm"
    @toggleConfirmForm="toggleConfirmForm"
  ></ConfirmationFormModal>

  <form @submit.prevent="submit">
    <div class="forms-container">
      <div class="forms">
        <div class="forms-title">
          <span class="title">Travel Details</span>
        </div>
        <div class="form-section">
          <label for="term">Select Term:</label>
          <select id="term" class="form-control" v-model="formData.term_id" required>
            <option value="" disabled selected>Select Term</option>
            <option :value="term.id" v-for="(term, index) in terms" :key="index">
              {{ term.name }}
            </option>
          </select>

          <small class="error-msg" v-if="errors.term_id"> {{ errors.term_id }}</small>
        </div>
        <div class="form-section">
          <label for="date_start">Date Start of Travel:</label>
          <input
            type="date"
            id="date_start"
            v-model="formData.date_start"
            class="form-control"
            required
          />

          <small class="error-msg" v-if="errors.date_start">
            {{ errors.date_start }}
          </small>
        </div>

        <div class="form-section">
          <label for="date_end">Date End of Travel:</label>
          <input
            type="date"
            id="date_end"
            v-model="formData.date_end"
            class="form-control"
            required
          />

          <small class="error-msg" v-if="errors.date_end"> {{ errors.date_end }}</small>
        </div>

        <div class="form-section">
          <label for="destination">Destination:</label>
          <input
            type="text"
            id="destination"
            v-model="formData.destination"
            class="form-control"
            placeholder="Enter the destination of travel eg. 'Tokyo, Japan'"
            required
            @input="fetchPlaceSuggestions(formData.destination)"
          />
          <small class="error-msg" v-if="errors.destination">
            {{ errors.destination }}
          </small>
          <div v-if="isDisplaySuggestion" class="suggestions">
            <span
              v-for="(suggestion, index) in suggestions"
              :key="index"
              @click="selectedSuggestion(suggestion)"
            >
              {{ suggestion }}
            </span>
          </div>
        </div>

        <div class="form-section">
          <label for="purpose">Purpose/Event:</label>
          <input
            type="text"
            id="purpose"
            v-model="formData.purpose"
            class="form-control"
            placeholder="Enter the purpose or event"
            required
          />

          <small class="errors-msg" v-if="errors.purpose"> {{ errors.purpose }}</small>
        </div>

        <div class="form-section">
          <label for="contact_person">Contact Person:</label>
          <input
            type="text"
            id="contact_person"
            v-model="formData.contact_person"
            class="form-control"
            placeholder="Enter the organizer or contact person"
            required
          />

          <small class="error-msg" v-if="errors.contact_person">
            {{ errors.contact_person }}</small
          >
        </div>

        <div class="form-section">
          <label for="contact_person_no">Organizer/Contact Person's No:</label>
          <input
            type="text"
            id="contact_person_no"
            v-model="formData.contact_person_no"
            class="form-control"
            placeholder="Enter the organizer or contact person's contact number"
            required
          />

          <small class="error-msg" v-if="errors.contact_person_no">
            {{ errors.contact_person_no }}</small
          >
        </div>

        <div class="form-section">
          <label for="description">Short Description:</label>
          <textarea
            id="description"
            v-model="formData.description"
            class="form-control"
            placeholder="Enter a short description of the purpose or event"
            rows="4"
            required
          ></textarea>

          <small class="error-msg" v-if="errors.description">
            {{ errors.description }}</small
          >
        </div>
      </div>

      <div class="forms">
        <div class="forms-title">
          <span class="title">Budget Requirements</span>
        </div>

        <div class="forms-separation">
          <div class="grid">
            <div class="sub-section-title">
              <label class="section-title">Budget Type:</label>
            </div>

            <div class="radio-item" v-for="item in budgetTypes" :key="item.id">
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

          <div class="grid">
            <div class="sub-section-title">
              <label class="section-title">Budget Charged To:</label>
            </div>

            <div class="radio-item" v-for="item in budgetCharges" :key="item.id">
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

        <div class="form-section">
          <label for="amount">Budget Amount:</label>
          <input
            type="number"
            id="amount"
            v-model="formData.amount"
            class="form-control"
            placeholder="Enter amount requested"
            required
          />

          <small class="error-msg" v-if="errors.amount"> {{ errors.amount }}</small>
        </div>

        <div class="form-section" v-if="roles.includes('teacher')">
          <label for="isSubstitute">Do you have a substitute teacher?</label>

          <div id="isSubstitute" class="radio-container">
            <div class="radio" for="yes-substitute">
              <input
                type="radio"
                id="yes-substitute"
                class="forms-controller"
                v-model="isSubstitute"
                :value="true"
              />
              <span> Yes</span>
            </div>

            <div class="radio" for="no-substitute">
              <input
                type="radio"
                id="no-substitute"
                class="forms-controller"
                v-model="isSubstitute"
                :value="false"
              />
              <span> No</span>
            </div>
          </div>
        </div>
        <div v-if="!isSubstitute" class="form-section">
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
      <div class="forms" v-if="isSubstitute">
        <div class="forms-title">
          <span class="title">Substitute</span>
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
          <div class="form-section">
            <label :for="'subject' + index">Subject:</label>
            <select
              :id="'subject' + index"
              class="forms-controller"
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

          <div class="form-section">
            <label :for="'teacher' + index">Substitute Teacher:</label>
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

          <div class="form-section">
            <label :for="'days' + index">Days:</label>
            <div class="days">
              <div class="days-item" v-for="(day, dayIndex) in days" :key="dayIndex">
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

          <div class="form-section">
            <label :for="'start_time' + index">Start Time:</label>
            <input
              type="time"
              :id="'start_time' + index"
              required
              class="forms-controller"
              v-model="substitute.start_time"
            />
          </div>

          <div class="form-section">
            <label :for="'end_time' + index">End Time</label>
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
      <button type="submit" class="submit" title="Submit for approval">
        {{ formDataToEditCopy ? "Re-Submit Application" : "Submit Application" }}
      </button>
    </div>
  </form>
</template>

<style scoped>
@import "./css/travel-form.css";
</style>
