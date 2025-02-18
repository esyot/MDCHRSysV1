<script src="./js/travel-form.js"></script>
<style scoped>
@import "./css/travel-form.css";
</style>
<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    @submitForm="submitForm"
    @toggleConfirmForm="toggleConfirmForm"
  ></ConfirmationFormModal>

  <ConfirmationDelete :isDelete="isDelete"></ConfirmationDelete>

  <form @submit.prevent="toggleConfirmForm">
    <div class="forms-container">
      <div class="forms">
        <div class="forms-title">
          <span class="title">Travel details</span>
        </div>
        <div class="form-section">
          <label for="dates">Date Start of Travel:</label>
          <input
            type="date"
            id="dates"
            v-model="travelForm.date_start"
            class="form-control"
            required
          />
        </div>

        <div class="form-section">
          <label for="dates">Date End of Travel:</label>
          <input
            type="date"
            id="dates"
            v-model="travelForm.date_end"
            class="form-control"
            required
          />
        </div>

        <div class="form-section">
          <label for="place">Place:</label>
          <input
            type="text"
            id="place"
            v-model="travelForm.place"
            class="form-control"
            placeholder="Enter the place of travel"
            required
          />
        </div>

        <div class="form-section">
          <label for="purpose">Purpose/Event:</label>
          <input
            type="text"
            id="purpose"
            v-model="travelForm.purpose"
            class="form-control"
            placeholder="Enter the purpose or event"
            required
          />
        </div>

        <div class="form-section">
          <label for="contact_person">Contact Person:</label>
          <input
            type="text"
            id="contact_person"
            v-model="travelForm.contact_person"
            class="form-control"
            placeholder="Enter the organizer or contact person"
            required
          />
        </div>

        <div class="form-section">
          <label for="contact_person_no">Organizer/Contact Person's No:</label>
          <input
            type="text"
            id="contact_person_no"
            v-model="travelForm.contact_person_no"
            class="form-control"
            placeholder="Enter the organizer or contact person's contact number"
            required
          />
        </div>

        <div class="form-section">
          <label for="description">Short Description:</label>
          <textarea
            id="description"
            v-model="travelForm.description"
            class="form-control"
            placeholder="Enter a short description of the purpose or event"
            rows="4"
            required
          ></textarea>
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
                v-model="budget.selectedBudgetType"
                :value="item.value"
              />
              <label :for="item.id">{{ item.label }}</label>
            </div>
          </div>

          <div class="grid">
            <div class="sub-section-title">
              <label class="section-title">Budget Charged To:</label>
            </div>

            <div class="radio-item" v-for="item in budgetCharges" :key="item.id">
              <input
                type="radio"
                :id="item.value"
                v-model="budget.selectedChargedTo"
                :value="item.value"
              />
              <label :for="item.value">{{ item.label }}</label>
            </div>
          </div>
        </div>

        <div class="form-section">
          <label for="amount">Budget Amount:</label>
          <input
            type="number"
            id="amount"
            v-model="budget.amount"
            class="form-control"
            placeholder="Enter amount requested"
            required
          />
        </div>
        <div class="form-section">
          <label for="amount">Select Term:</label>
          <select class="form-control" v-model="travelForm.semister" required>
            <option value="" disabled selected>Select Term</option>
            <option value="1st">1st Semister</option>
            <option value="2nd">2nd Semister</option>
            <option value="Summer">Summer</option>
          </select>
        </div>
        <div class="form-section" v-if="roles.includes('teacher')">
          <label for="date_end">Do you have a substitute teacher?</label>

          <div class="radio-container">
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
          <label for="date_end">Please specify the alternatives used to the class.</label>
          <textarea
            type="text"
            v-model="formData.description"
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
            <small><i>(For MDC Teaching Employee only)</i></small>
          </div>
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
