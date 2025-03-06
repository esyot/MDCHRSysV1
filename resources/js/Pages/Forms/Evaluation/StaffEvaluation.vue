<template>
  <div class="evaluation-container">
    <div class="navigation">
      <button @click="goBack()">
        <i class="fa fa-arrow-left"></i><span> Back</span>
      </button>
    </div>
    <div class="user-details">
      <span>
        Name: {{ user.last_name }}, {{ user.first_name }} {{ user.middle_name[0] }}.
      </span>
      <span>Date: {{ formatDate(currentDate) }}</span>
    </div>
    <h1>MDC STAFF PERFORMANCE EVALUATION FORM</h1>
    <form @submit.prevent="submitForm">
      <div class="forms">
        <div class="table-title">
          <span> A. TEACHER'S PERSONALITY </span>
        </div>
        <table class="evaluation-table">
          <thead>
            <tr>
              <th>Performance Indicator</th>
              <th>5</th>
              <th>4</th>
              <th>3</th>
              <th>2</th>
              <th>1</th>
            </tr>
          </thead>
          <tbody>
            <tr class="indicators">
              <td colspan="6">Use Of Time</td>
            </tr>
            <tr v-for="(question1, index) in question1" :key="index">
              <td>{{ question1 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q1-' + index"
                  v-model="ratings.q1[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>

            <tr class="indicators">
              <td colspan="6">Job Knowledge</td>
            </tr>
            <tr v-for="(question2, index) in question2" :key="index">
              <td>{{ question2 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q2-' + index"
                  v-model="ratings.q2[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>

            <tr class="indicators">
              <td colspan="6">Quality of Work</td>
            </tr>
            <tr v-for="(question3, index) in question3" :key="index">
              <td>{{ question3 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q3-' + index"
                  v-model="ratings.q3[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>

            <tr class="indicators">
              <td colspan="6">Quantity of Work</td>
            </tr>
            <tr v-for="(question4, index) in question4" :key="index">
              <td>{{ question4 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q4-' + index"
                  v-model="ratings.q4[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>

            <tr class="indicators">
              <td colspan="6">Utilization of Resources</td>
            </tr>
            <tr v-for="(question5, index) in question5" :key="index">
              <td>{{ question5 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q5-' + index"
                  v-model="ratings.q5[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>

            <tr class="indicators">
              <td colspan="6">
                The Initiative, Judgment, and Decision Making Capability
              </td>
            </tr>
            <tr v-for="(question6, index) in question6" :key="index">
              <td>{{ question6 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q6-' + index"
                  v-model="ratings.q6[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>

            <tr class="indicators">
              <td colspan="6">Working Relationship</td>
            </tr>
            <tr v-for="(question7, index) in question7" :key="index">
              <td>{{ question7 }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q7-' + index"
                  v-model="ratings.q7[index]"
                  :value="rating"
                  required
                />
              </td>
            </tr>
          </tbody>
        </table>
        <div class="last">
          <div class="comment">
            <label>Comments:</label>
            <textarea
              @input="saveToLocalStorage"
              name="c1"
              id=""
              rows="3"
              required
            ></textarea>
          </div>
          <div class="rating">
            <label>Rating:</label>
            <input type="text" :value="averageRating('q1')" disabled />
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
  props: {
    user: Object,
  },
  data() {
    return {
      currentDate: new Date(),
      ratings: {
        q1: Array(10).fill(null),
        q2: Array(10).fill(null),
        q3: Array(10).fill(null),
        q4: Array(10).fill(null),
        q5: Array(10).fill(null),
        q6: Array(10).fill(null),
        q7: Array(10).fill(null),
      },
      question1: [
        "Attendance and Punctuality in reporting to Duty",
        "On-time in accomplishing tasks",
      ],
      question2: [
        "Degree of Technical Knowledge",
        "Understanding of Job Procedures and Methods",
        "Use of logical reasoning based on knowledge in performing task.",
      ],
      question3: ["Competence", "Accuracy of Job Performed", "Neatness", "Thoroughness"],
      question4: [
        "Use of Time",
        "The volume of work accomplished",
        "Ability to meet schedules",
        "Production levels",
      ],
      question5: ["Effectiveness in utilizing the resources of the School"],
      question6: [
        "Have initiative in doing tasks",
        "Analyzes issues and concerns thoroughly",
      ],
      question7: [
        "Cooperation and ability to work with superiors",
        "Relationship with co-workers",
        "Ability to mingle and served the clientele-students",
      ],
    };
  },
  created() {
    this.loadFromLocalStorage();
  },
  methods: {
    goBack() {
      window.history.back();
    },
    submitForm(event) {
      event.preventDefault();

      const formData = new FormData(event.target);

      const formObject = {};
      formData.forEach((value, key) => {
        formObject[key] = value;
      });

      Inertia.post(`/users/${this.user.id}/evaluation-submit/`, {
        formData: formObject,
        ratings: this.overallRating,
      });

      localStorage.removeItem("ratings");
      localStorage.removeItem("comments");
    },
    formatDate(date) {
      const convertedDate = new Date(date);
      const options = {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: true,
      };
      return convertedDate.toLocaleString("en-US", options);
    },
    averageRating(section) {
      const ratings = this.ratings[section];
      const total = ratings.reduce((sum, rating) => sum + (rating || 0), 0);
      const count = ratings.filter((rating) => rating !== null).length;
      return count === 0 ? 0 : (total / count).toFixed(2);
    },
    saveToLocalStorage() {
      localStorage.setItem("ratings", JSON.stringify(this.ratings));
      localStorage.setItem("comments", JSON.stringify(this.comments));
    },
    loadFromLocalStorage() {
      const savedRatings = localStorage.getItem("ratings");
      const savedComments = localStorage.getItem("comments");

      if (savedRatings) {
        try {
          this.ratings = JSON.parse(savedRatings);
        } catch (e) {
          console.error("Error parsing ratings from localStorage:", e);
        }
      }

      if (savedComments) {
        try {
          this.comments = JSON.parse(savedComments);
        } catch (e) {
          console.error("Error parsing comments from localStorage:", e);
        }
      }

      if (!this.ratings) {
        this.ratings = {
          q1: Array(10).fill(null),
          q2: Array(10).fill(null),
          q3: Array(10).fill(null),
          q4: Array(10).fill(null),
          q5: Array(10).fill(null),
          q6: Array(10).fill(null),
          q7: Array(10).fill(null),
        };
      }
      if (!this.comments) {
        this.comments = {
          c1: "",
          c2: "",
          c3: "",
          c4: "",
        };
      }
    },
  },
  computed: {
    overallRating() {
      const allRatings = [
        ...this.ratings.q1,
        ...this.ratings.q2,
        ...this.ratings.q3,
        ...this.ratings.q4,
        ...this.ratings.q5,
        ...this.ratings.q6,
        ...this.ratings.q7,
      ];
      const total = allRatings.reduce((sum, rating) => sum + (rating || 0), 0);
      const count = allRatings.filter((rating) => rating !== null).length;
      return count === 0 ? 0 : (total / count).toFixed(2);
    },
  },
};
</script>

<style scoped>
.evaluation-container {
  max-width: 90%;
  margin: auto;
  padding: 20px;
  text-align: center;
}

.evaluation-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.evaluation-table th,
.evaluation-table td {
  border: 1px solid #ddd;
  padding: 8px;
  word-wrap: break-word;
}

.evaluation-table th {
  background-color: #f4f4f4;
  text-align: center;
  font-size: 14px;
}

.evaluation-table th:first-child {
  text-align: center;
  width: 40%;
}

.evaluation-table td:first-child {
  text-align: left;
  font-size: 14px;
  width: 40%;
}

input[type="radio"] {
  cursor: pointer;
}

.table-title {
  margin: 20px 0 0 25px;
  text-align: start;
  font-weight: bold;
}

.last {
  width: 100%;
  border-collapse: collapse;
  border: 1px solid #ddd;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  box-sizing: border-box;
}

.comment {
  text-align: start;
  flex: 1;
  font-size: 14px;
}

.comment label {
  display: block;
  margin-bottom: 5px;
}

textarea {
  display: block;
  width: 100%;
  border: 1px solid #ddd;
}

.rating {
  margin: 0px 50px 0 20px;
  font-size: 14px;
}

.rating input {
  width: 50px;
  border: none;
  border-bottom: 1px solid black;
  outline: none;
  text-align: center;
  margin-left: 5px;
}

.container {
  display: flex;
  justify-content: flex-end;
  align-items: flex-start;
  width: 100%;
}

.overall-rating {
  display: flex;
  margin: 10px;
  align-items: center;
  gap: 1rem;
  flex-direction: row;
  align-items: flex-end;
}

.overall-rating label {
  font-weight: bold;
  font-size: 14px;
}

.overall-rating input {
  border: none;
  border-bottom: 1px solid black;
  width: 50px;
  text-align: center;
  outline: none;
  margin-left: 5px;
  font-weight: bold;
}
.user-details {
  display: flex;
  flex-direction: column;
  text-align: left;
}
.user-details span {
  font-size: 18px;
  font-weight: bold;
  margin-left: 5px;
}
.navigation {
  display: flex;
  justify-content: start;
  padding: 10px;
}
.navigation button {
  background-color: #4caf50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  opacity: 50%;
}

.navigation button:hover {
  opacity: 100%;
  cursor: pointer;
}

.submit-btn {
  padding: 10px;
  border: none;
  background-color: rgb(20, 107, 237);
  border-radius: 5px;
  color: #fff;
  opacity: 75%;
}

.submit-btn:hover {
  opacity: 100%;
  cursor: pointer;
}

.indicators td {
  font-weight: bold;
  text-align: center;
  border: 1px solid #ddd;
  background-color: #f4f4f4;
}

@media (max-width: 768px) {
  .evaluation-table th,
  .evaluation-table td {
    font-size: 12px;
    padding: 6px;
  }
  .evaluation-table td:first-child {
    width: 35%;
  }
}
</style>
