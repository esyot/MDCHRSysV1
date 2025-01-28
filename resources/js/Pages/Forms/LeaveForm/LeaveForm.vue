<template>
  <div class="forms-container">
    <div class="forms">
      <div class="forms-title">
        <span class="title">DETAILS OF APPLICATION</span>
      </div>
      <div class="form-section">
        <label for="leave_name">TYPE OF LEAVE:</label>
        <select id="leave_name" v-model="leave_type" class="forms-controller">
          <option value="VACATION">VACATION</option>
          <option value="MATERNITY">MATERNITY</option>
          <option value="PATERNITY">PATERNITY</option>
          <option value="SICK">SICK</option>
          <option value="EDUCATIONAL">EDUCATIONAL</option>
          <option value="OTHERS">OTHERS</option>
        </select>
      </div>
      <div class="form-section" v-show="leave_type === 'VACATION'">
        <label for="leave_type_vacation">In case of Vacation Leave:</label>
        <select id="leave_type_vacation" v-model="leave_vacation">
          <option value="Within the Philippines">Within the Philippines</option>
          <option value="Abroad">Abroad</option>
        </select>
      </div>
      <div class="form-section" v-show="leave_vacation === 'Within the Philippines'">
        <label for="leave_vacation_phil"
          >If within the Philippines, please specify:</label
        >
        <input
          type="text"
          id="leave_vacation_phil"
          class="forms-controller"
          placeholder="eg., Bohol, Tubigon"
        />
      </div>
      <div class="form-section" v-show="leave_vacation === 'Abroad'">
        <label for="leave_vacation_abroad">If Abroad, please specify:</label>
        <input
          type="text"
          id="leave_vacation_abroad"
          class="forms-controller"
          placeholder="eg., Tokyo, Japan"
        />
      </div>
      <div class="form-section" v-show="leave_type === 'SICK'">
        <label for="leave_type_sick">In case of Sick Leave:</label>
        <select id="leave_type_sick" v-model="leave_sick">
          <option value="In Hospital">In Hospital</option>
          <option value="Out Patient">Out Patient</option>
          <option value="Home Medication">Home Medication</option>
        </select>
      </div>
      <div class="form-section" v-show="leave_sick === 'In Hospital'">
        <label for="leave_sick_hospital">If in Hospital, please specify ILLNESS:</label>
        <input
          type="text"
          id="leave_sick_hospital"
          class="forms-controller"
          placeholder="eg., Covid 19"
        />
      </div>
      <div class="form-section" v-show="leave_sick === 'Out Patient'">
        <label for="leave_sick_outpatient">If Out Patient, please specify ILLNESS:</label>
        <input
          type="text"
          id="leave_sick_outpatient"
          class="forms-controller"
          placeholder="eg., Fever"
        />
      </div>
      <div class="form-section" v-show="leave_sick === 'Home Medication'">
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

      <div class="form-section" v-show="leave_type === 'EDUCATIONAL'">
        <label for="leave_type_educational"> In case of Educational Leave: </label>
        <select id="leave_type_educational" v-model="leave_educ">
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
      <div class="form-section" v-show="leave_educ === 'Others'">
        <label for="leave_educ_others">Please specify:</label>
        <input
          type="text"
          id="leave_educ_others"
          class="forms-controller"
          placeholder="eg., Completion of Certification"
        />
      </div>

      <div class="form-section" v-show="leave_type === 'OTHERS'">
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
        <button @click="addTeachingSubstitute"><i class="fas fa-plus"></i> Add</button>
        <small><i>(For MDC Teaching Employee only)</i></small>
      </div>

      <div v-for="(sub, index) in teachingSubstitutes" :key="index">
        <div class="form-section">
          <label :for="'sub' + index">SUBJECT</label>
          <input
            type="text"
            :id="'sub' + index"
            class="forms-controller"
            v-model="sub.subject"
            placeholder="eg., Mathematics"
          />
        </div>
        <div class="form-section">
          <label :for="'time' + index">TIME</label>
          <input
            type="time"
            :id="'time' + index"
            class="forms-controller"
            v-model="sub.time"
          />
        </div>
        <div class="form-section">
          <label :for="'subs_teacher' + index">SUBSTITUTE TEACHER</label>
          <input
            type="text"
            :id="'subs_teacher' + index"
            class="forms-controller"
            v-model="sub.teacher"
            placeholder="eg., John Meward"
          />
        </div>
        <button @click="removeTeachingSubstitute(index)" class="remove-btn">
          <i class="fa fa-trash"></i> Remove
        </button>
      </div>
    </div>
  </div>
  <div class="form-submit">
    <button>Submit</button>
  </div>
</template>

<script>
import Layout from "@/Layouts/Layout.vue";

export default {
  data() {
    return {
      leave_type: "",
      leave_vacation: "",
      leave_sick: "",
      leave_educ: "",
      teachingSubstitutes: [],
    };
  },
  methods: {
    addTeachingSubstitute() {
      this.teachingSubstitutes.push({
        subject: "",
        time: "",
        teacher: "",
      });
    },
    removeTeachingSubstitute(index) {
      this.teachingSubstitutes.splice(index, 1);
    },
  },
  watch: {
    leave_type(newVal) {
      if (newVal !== "VACATION") {
        this.leave_vacation = "";
      }
      if (newVal !== "SICK") {
        this.leave_sick = "";
      }
      if (newVal !== "EDUCATIONAL") {
        this.leave_educ = "";
      }
    },
  },
  layout: Layout,
};
</script>

<style scoped>
.forms-container {
  display: flex;
  overflow-y: auto;
  height: 80vh;
  padding: 10px;
}

.forms-title {
  display: flex;
  align-items: center;
  border-bottom: #dedede 1px solid;
  background-color: #fff;
  box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 10;
}

.forms-title small {
  margin-left: 10px;
}
.forms-title button {
  background-color: #3b82f6;
  color: #fff;
  border: none;
  padding: 5px 10px 5px 10px;
  border-radius: 5px;
  opacity: 75%;
}

.forms-title button:hover {
  opacity: 100%;
  cursor: pointer;
}

.remove-btn {
  padding: 10px;
  margin: 10px;
  color: #fff;
  border: none;
  background-color: #ed1a1a;
  border-radius: 5px;
  opacity: 75%;
}

.remove-btn:hover {
  opacity: 100%;
  cursor: pointer;
}

.title {
  font-size: 14px;
  padding: 10px;
  font-weight: bold;
}

.forms-container {
  display: flex;
  flex-wrap: wrap;
  max-height: 90vh;
  overflow-y: auto;
  margin-top: 5px;
  gap: 0.5rem;
}

.forms {
  flex-grow: 1;
  flex-basis: 400px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-section {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
  padding: 10px;
}

.form-section label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  font-size: 12px;
}

.form-section input {
  display: flex;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

.form-section select {
  display: flex;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

.radio-group {
  display: flex;
  align-items: center;
  gap: 10px;
}

.radio-group label {
  display: flex;
  align-items: center;
}

.forms-controller-radio {
  margin-right: 5px;
}

.form-submit {
  display: flex;
  justify-content: end;
  padding-right: 10px;
}

.form-submit button {
  border: none;
  padding: 10px 15px 10px 15px;
  border-radius: 5px;
  color: white;
  background-color: rgb(35, 134, 200);
  opacity: 75%;
  margin: 5px;
}

.form-submit button:hover {
  cursor: pointer;
  opacity: 100%;
}
</style>
