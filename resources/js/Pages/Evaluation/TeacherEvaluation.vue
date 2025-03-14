<script>
import { Inertia } from "@inertiajs/inertia";
export default {
  props: {
    user: Object,
    terms: Object,
    evalCategories: Object,
  },
  data() {
    return {
      term: "",
      currentDate: new Date(),
      ratings: {
        q1: Array(10).fill(null),
        q2: Array(10).fill(null),
        q3: Array(10).fill(null),
        q4: Array(10).fill(null),
      },
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
      ];
      const total = allRatings.reduce((sum, rating) => sum + (rating || 0), 0);
      const count = allRatings.filter((rating) => rating !== null).length;
      return count === 0 ? 0 : (total / count).toFixed(2);
    },
  },
};
</script>
<template>
  <div class="evaluation-container">
    <div class="navigation">
      <button @click="goBack()">
        <i class="fa fa-arrow-left"></i><span> Back</span>
      </button>
    </div>
    <div class="user-details">
      <span> Name: {{ user.last_name }}, {{ user.first_name }} </span>
      <span>Date: {{ formatDate(currentDate) }}</span>

      <div>
        <select name="" id="" v-model="term">
          <option value="" selected disabled>Select Term</option>
          <option :value="term.id" v-for="term in terms" :key="term.id">
            {{ term.name }}
          </option>
        </select>

        <select name="" id="" v-if="term">
          <option value="" selected disabled>Select Subject</option>
        </select>
      </div>
    </div>
    <h1>Evaluation Form</h1>
    <form @submit.prevent="submitForm">
      <div class="forms" v-for="category in evalCategories" :key="category.id">
        <div class="table-title">
          <span>{{ category.title }}</span>
        </div>
        <table class="evaluation-table">
          <thead>
            <tr>
              <th>The teacher ...</th>
              <th><label>Outstanding</label><br />5</th>
              <th><label>Very Satisfactory</label><br />4</th>
              <th><label>Satisfactory</label><br />3</th>
              <th><label>Poor</label><br />2</th>
              <th><label>Very Poor</label><br />1</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in category.items" :key="index">
              <td>{{ item.description }}</td>
              <td v-for="rating in 5" :key="rating">
                <input
                  type="radio"
                  @change="saveToLocalStorage"
                  :name="'q' + category.id + '-' + index"
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

      <div class="container">
        <div class="overall-rating">
          <label for="">Overall Rating:</label>
          <input type="text" :value="overallRating" disabled />
          <button class="submit-btn">Submit</button>
        </div>
      </div>
    </form>
  </div>
</template>

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
  text-align: left;
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
