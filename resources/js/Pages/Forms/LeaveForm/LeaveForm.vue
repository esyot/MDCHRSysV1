<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  data() {
    return {
      formData: {
        leave_type: "",
        leave_vacation: "",
        leave_sick: "",
        leave_educ: "",
      },
      teachingSubstitutes: [], // Add this array to store multiple substitutes
      days: ["M", "T", "W", "Th", "F", "S"], // Days for the substitute form
    };
  },
  methods: {
    addTeachingSubstitute() {
      this.teachingSubstitutes.push({
        subject: "",
        teacher: "",
        days: [],
        start_time: "",
        end_time: "",
      });
    },
    removeTeachingSubstitute(index) {
      this.teachingSubstitutes.splice(index, 1);
    },
    leaveFormPreview(event) {
      Inertia.get("/leave-form-preview", {
        teachingSubstitutes: this.teachingSubstitutes, // Send teachingSubstitutes instead of substitute
        formData: this.formData,
      });
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
  <form @submit.prevent="leaveFormPreview">
    <div class="forms-container">
      <!-- Leave Details Form -->
      <div class="forms">
        <div class="forms-title">
          <span class="title">DETAILS OF APPLICATION</span>
        </div>
        <!-- Leave Type Dropdown -->
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
        <!-- Conditional Leave Details -->
        <!-- ... (rest of your leave details form) ... -->
      </div>

      <!-- Substitute Form -->
      <div class="forms">
        <div class="forms-title">
          <span class="title">SUBSTITUTE</span>
          <button type="button" @click="addTeachingSubstitute">
            <i class="fas fa-plus"></i> Add
          </button>
          <small><i>(For MDC Teaching Employee only)</i></small>
        </div>

        <!-- Dynamic Substitute Forms -->
        <div
          v-for="(sub, index) in teachingSubstitutes"
          :key="index"
          class="substitute-form"
        >
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
            <div class="days">
              <div class="days-item" v-for="(day, dayIndex) in days" :key="dayIndex">
                <input
                  type="checkbox"
                  :id="'day' + index + '-' + dayIndex"
                  :value="day"
                  v-model="sub.days"
                />
                <label :for="'day' + index + '-' + dayIndex">{{ day }}</label>
              </div>
            </div>
          </div>

          <div class="form-section">
            <label :for="'start_time' + index">Start TIME</label>
            <input
              type="time"
              :id="'start_time' + index"
              class="forms-controller"
              v-model="sub.start_time"
            />
          </div>

          <div class="form-section">
            <label :for="'end_time' + index">End TIME</label>
            <input
              type="time"
              :id="'end_time' + index"
              class="forms-controller"
              v-model="sub.end_time"
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

    <!-- Form Submit Buttons -->
    <div class="form-submit">
      <button type="submit" class="preview" title="Preview form">
        <i class="fas fa-eye"></i>
        <span> Preview</span>
      </button>
      <button class="submit" title="Submit for approval">
        <i class="fas fa-check"></i>
        <span> Submit</span>
      </button>
    </div>
  </form>
</template>

<style scoped>
.days {
  display: flex;
}

.days-item {
  display: flex;
  align-items: center;
}

.checkbox {
  padding: 20px;
}
.preview {
  background-color: rgb(33, 208, 33);
}
.submit {
  background-color: rgb(35, 134, 200);
}
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
  opacity: 75%;
  margin: 5px;
}

.form-submit button:hover {
  cursor: pointer;
  opacity: 100%;
}
</style>
