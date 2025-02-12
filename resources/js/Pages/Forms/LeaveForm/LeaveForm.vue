<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  layout: Layout,
  props: {
    users: Object,
  },
  data() {
    return {
      formData: {
        leave_type: "",
        leave_type_option: "",
        vacation_option: "",
        convalescence_place: "",
        address: "",
        sick_type: "",
        illness: "",
        reason: "",
        other_reason: "",
        date_start: "",
        date_end: "",
        description: "",
        medical_certificate: null,
      },
      teachingSubstitutes: [],
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      searchTeacher: false,
      filteredUsers: this.users,
      substitute: false,
    };
  },

  methods: {
    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.formData.medical_certificate = file;
      }
    },
    addTeachingSubstitute() {
      const newSubstitute = {
        subject: "",
        user_id: "",
        teacher: "",
        days: [],
        start_time: "",
        end_time: "",
      };

      this.teachingSubstitutes.push(newSubstitute);
    },
    removeTeachingSubstitute(index) {
      this.teachingSubstitutes.splice(index, 1);
    },
    leaveFormSubmit(event) {
      const form = new FormData();
      if (this.formData.medical_certificate) {
        form.append("medical_certificate", this.formData.medical_certificate);
      }

      form.append("substitutes", this.teachingSubstitutes ?? null);

      for (const key in this.formData) {
        if (this.formData.hasOwnProperty(key)) {
          form.append(key, this.formData[key]);
        }
      }

      Inertia.post("/leave-form-submit", form);
    },
    toggleSearchTeacher(value) {
      if (value) {
        this.searchTeacher = true;

        const searchValue = value.toLowerCase();

        this.filteredUsers = this.users.filter(
          (user) =>
            user.first_name.toLowerCase().includes(searchValue) ||
            user.last_name.toLowerCase().includes(searchValue)
        );

        if (this.filteredUsers.length === 0) {
        }
      } else {
        this.searchTeacher = false;
        this.filteredUsers = [...this.users];
      }
    },
    selectTeacher(id, index) {
      const user = this.users.find((user) => user.id === id);
      if (user) {
        this.teachingSubstitutes[index].user_id = `${id}`;
        this.teachingSubstitutes[index].teacher = `${user.last_name}, ${user.first_name}`;
      }
      this.searchTeacher = false;
    },
  },
  watch: {
    "formData.leave_type": function () {
      this.formData.vacation_option = "";
      this.formData.convalescence_place = "";
      this.formData.address = "";
      this.formData.sick_type = "";
      this.formData.illness = "";
      this.formData.reason = "";
      this.formData.other_reason = "";
    },
  },
};
</script>

<template>
  <form @submit.prevent="leaveFormSubmit">
    <div class="forms-container">
      <div class="forms">
        <div class="forms-title">
          <span class="title">DETAILS OF APPLICATION</span>
        </div>
        <div class="form-section">
          <label for="leave_name">TYPE OF LEAVE:</label>
          <select id="leave_name" v-model="formData.leave_type" class="forms-controller">
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
          >
            <option value="" disabled selected>Select type of Personal Leave</option>
            <option value="Vacation">Vacation Leave</option>
            <option value="Fiesta">Fiesta Leave</option>
            <option value="Birthday">Birthday Leave</option>
          </select>
        </div>

        <div class="form-section" v-if="formData.leave_type_option === 'Vacation'">
          <label for="leave_type_vacation">In case of Vacation Leave:</label>
          <select id="leave_type_vacation" v-model="formData.vacation_option">
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
          />
        </div>
        <div class="form-section" v-if="formData.leave_type === 'Sick'">
          <label for="leave_type_sick">In case of Sick Leave:</label>
          <select id="leave_type_sick" v-model="formData.convalescence_place">
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
            >If in Hospital, please specify your illness: (optional)</label
          >
          <input
            type="text"
            id="leave_sick_hospital"
            class="forms-controller"
            placeholder="eg., Fever"
            v-model="formData.illness"
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
          />
        </div>
        <div
          class="form-section"
          v-if="
            formData.leave_type === 'Sick' &&
            formData.convalescence_place === 'Out Patient'
          "
        >
          <label for="leave_sick_outpatient"
            >If Out Patient, please specify ILLNESS:</label
          >
          <input
            type="text"
            id="leave_sick_outpatient"
            class="forms-controller"
            placeholder="eg., Fever"
            v-model="formData.illness"
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
          />
        </div>

        <div class="form-section" v-if="formData.leave_type === 'Educational'">
          <label for="leave_type_educational"> In case of Educational Leave: </label>
          <select id="leave_type_educational" v-model="formData.reason">
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
          />
        </div>

        <div class="form-section">
          <label for="date_start">Date Start:</label>
          <input
            type="date"
            id="date_start"
            class="forms-controller"
            v-model="formData.date_start"
          />
        </div>

        <div class="form-section">
          <label for="date_end">Date End:</label>
          <input
            type="date"
            id="date_end"
            class="forms-controller"
            v-model="formData.date_end"
          />
        </div>

        <div class="form-section" v-if="formData.leave_type === 'Sick'">
          <label for="">Upload Photo of Medical Certificate:</label>
          <input type="file" @change="handleFileChange" required />
          <small>Note: <i>selected file must be in .jpg format</i></small>
        </div>

        <div class="form-section">
          <label for="date_end">Need a substitute?</label>

          <div class="radio-container">
            <div class="radio" for="yes-substitute">
              <input
                type="radio"
                id="yes-substitute"
                class="forms-controller"
                v-model="substitute"
                :value="true"
              />
              <span> Yes</span>
            </div>

            <div class="radio" for="no-substitute">
              <input
                type="radio"
                id="no-substitute"
                class="forms-controller"
                v-model="substitute"
                :value="false"
              />
              <span> No</span>
            </div>
          </div>
        </div>
        <div v-if="!substitute" class="form-section">
          <label for="date_end">Please specify the alternatives used to the class.</label>
          <textarea
            type="text"
            v-model="formData.description"
            placeholder="Input text here."
            required
          />
        </div>
      </div>
      <div class="forms" v-if="substitute">
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
      <button class="submit" title="Submit for approval">
        <span> Submit</span>
      </button>
    </div>
  </form>
</template>

<style scoped>
@import "./leave-form.css";

.radio-container {
  display: flex;
}
.radio {
  display: flex;
  align-items: center;
  padding: 10px;
}

.radio input {
  margin-bottom: 4px;
}

.radio label {
  display: flex;
  align-items: center;
  width: 100%;
}

.form-section textarea {
  border-radius: 5px;
  margin-top: 10px;
  padding: 5px;
}
</style>
