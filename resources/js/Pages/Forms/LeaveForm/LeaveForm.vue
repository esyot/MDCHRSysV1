<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  props: {
    users: Object,
  },
  data() {
    return {
      formData: {
        leave_type: "",
        leave_vacation: "",
        leave_sick: "",
        leave_educ: "",
        address: "",
      },
      teachingSubstitutes: [],
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      searchTeacher: false,
      filteredUsers: this.users,
    };
  },

  methods: {
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
    leaveFormPreview(event) {
      Inertia.get("/leave-form-preview", {
        teachingSubstitutes: this.teachingSubstitutes,
        formData: this.formData,
      });
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
    "formData.leave_type"(newVal) {
      if (newVal !== "VACATION") {
        this.formData.leave_vacation = "";
      }
      if (newVal !== "SICK") {
        this.formData.leave_sick = "";
      }
      if (newVal !== "EDUCATIONAL") {
        this.formData.leave_educ = "";
      }
    },
  },
  layout: Layout,
};
</script>

<template>
  {{ console.table(teachingSubstitutes) }}
  <form @submit.prevent="leaveFormPreview">
    <div class="forms-container">
      <div class="forms">
        <div class="forms-title">
          <span class="title">DETAILS OF APPLICATION</span>
        </div>
        <div class="form-section">
          <label for="leave_name">TYPE OF LEAVE:</label>
          <select id="leave_name" v-model="formData.leave_type" class="forms-controller">
            <option value="VACATION">VACATION</option>
            <option value="MATERNITY">MATERNITY</option>
            <option value="PATERNITY">PATERNITY</option>
            <option value="SICK">SICK</option>
            <option value="EDUCATIONAL">EDUCATIONAL</option>
            <option value="OTHERS">OTHERS</option>
          </select>
        </div>
        <div class="form-section" v-show="formData.leave_type === 'VACATION'">
          <label for="leave_type_vacation">In case of Vacation Leave:</label>
          <select id="leave_type_vacation" v-model="formData.leave_vacation">
            <option value="Within the Philippines">Within the Philippines</option>
            <option value="Abroad">Abroad</option>
          </select>
        </div>
        <div
          class="form-section"
          v-show="
            formData.leave_type === 'VACATION' &&
            formData.leave_vacation === 'Within the Philippines'
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
        <div class="form-section" v-show="formData.leave_vacation === 'Abroad'">
          <label for="leave_vacation_abroad">If Abroad, please specify:</label>
          <input
            type="text"
            id="leave_vacation_abroad"
            class="forms-controller"
            v-model="formData.address"
            placeholder="eg., Tokyo, Japan"
          />
        </div>
        <div class="form-section" v-show="formData.leave_type === 'SICK'">
          <label for="leave_type_sick">In case of Sick Leave:</label>
          <select id="leave_type_sick" v-model="formData.leave_sick">
            <option value="In Hospital">In Hospital</option>
            <option value="Out Patient">Out Patient</option>
            <option value="Home Medication">Home Medication</option>
          </select>
        </div>
        <div class="form-section" v-show="formData.leave_sick === 'In Hospital'">
          <label for="leave_sick_hospital">If in Hospital, please specify ILLNESS:</label>
          <input
            type="text"
            id="leave_sick_hospital"
            class="forms-controller"
            placeholder="eg., Covid 19"
          />
        </div>
        <div class="form-section" v-show="formData.leave_sick === 'Out Patient'">
          <label for="leave_sick_outpatient"
            >If Out Patient, please specify ILLNESS:</label
          >
          <input
            type="text"
            id="leave_sick_outpatient"
            class="forms-controller"
            placeholder="eg., Fever"
          />
        </div>
        <div class="form-section" v-show="formData.leave_sick === 'Home Medication'">
          <label for="leave_sick_home_medication"
            >If Home Medication, please specify ILLNESS:</label
          >
          <input
            type="text"
            id="leave_sick_home_medication"
            class="forms-controller"
            placeholder="eg., Headache"
          />
        </div>

        <div class="form-section" v-show="formData.leave_type === 'EDUCATIONAL'">
          <label for="leave_type_educational"> In case of Educational Leave: </label>
          <select id="leave_type_educational" v-model="formData.leave_educ">
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
        <div class="form-section" v-show="formData.leave_educ === 'Others'">
          <label for="leave_educ_others">Please specify:</label>
          <input
            type="text"
            id="leave_educ_others"
            class="forms-controller"
            placeholder="eg., Completion of Certification"
          />
        </div>

        <div class="form-section" v-show="formData.leave_type === 'OTHERS'">
          <label for="leave_type_others">If Others, please specify:</label>
          <input
            type="text"
            id="leave_type_others"
            class="forms-controller"
            placeholder="Enter details..."
          />
        </div>
      </div>
      <div class="forms">
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
              placeholder="eg., Mathematics"
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
                  required
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
</style>
