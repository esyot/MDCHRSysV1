<template>
  <div class="evaluation-container" v-if="evalCategories.length > 0">
    <div class="navigation">
      <button @click="goBack()">
        <i class="fa fa-arrow-left"></i><span> Back</span>
      </button>
    </div>
    <div class="user-details">
      <span> Name: {{ user.last_name }}, {{ user.first_name }} </span>
      <span>Date: {{ formatDate(currentDate) }}</span>

      <div>
        <select v-model="term" required>
          <option value="" selected disabled>Select Term</option>
          <option v-for="term in terms" :key="term.id" :value="term.id">
            {{ term.name }}
          </option>
        </select>
      </div>
    </div>
    <h1>Evaluation Form</h1>
    <form @submit.prevent="submitForm">
      <div v-if="evalCategories && evalCategories.length > 0">
        <div v-for="(category, index) in evalCategories" :key="index" class="forms">
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
              <tr v-for="(item, index) in category.items || []" :key="index">
                <td>{{ item.description }}</td>
                <td v-for="rating in [5, 4, 3, 2, 1]" :key="rating">
                  <input
                    type="radio"
                    :name="'c' + category.id + '_i' + item.id"
                    :value="rating"
                    v-model="ratings[`c${category.id}_i${item.id}`]"
                    @change="saveToLocalStorage"
                    :checked="ratings[`c${category.id}_i${item.id}`] === rating"
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
                v-model="comments[category.id]"
                @input="saveToLocalStorage"
                rows="3"
                required
              ></textarea>
            </div>
            <div class="category-rating">
              <label>Rating: </label>
              <span class="underline"> {{ calculateCategoryRating(category.id) }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="overall-rating">
          <label for="">Overall Rating:</label>
          <input type="text" :value="overallPoints" disabled />
          <button class="submit-btn">Submit</button>
        </div>
      </div>
    </form>
  </div>
  <div v-else class="error-msg">
    <p>
      No template available for this time, if you find this as an error, please contact
      the system's administrator.
    </p>
    <button @click="goBack()">back</button>
  </div>
</template>

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
      comments: {},
      ratings: {},
      overallPoints: 0,
    };
  },

  mounted() {
    this.loadFromLocalStorage();
  },

  methods: {
    goBack() {
      window.history.back();
    },

    submitForm(event) {
      event.preventDefault();

      Inertia.post(`/users/${this.user.id}/evaluation-submit/`, {
        ratings: this.ratings,
        comments: this.comments,
        overallPoints: this.overallPoints,
      });

      localStorage.removeItem("ratings");
      localStorage.removeItem("comments");
    },

    saveToLocalStorage() {
      localStorage.setItem("ratings", JSON.stringify(this.ratings));
      localStorage.setItem("comments", JSON.stringify(this.comments));

      this.calculateOverallPoints();
    },

    loadFromLocalStorage() {
      const savedRatings = localStorage.getItem("ratings");
      const savedComments = localStorage.getItem("comments");

      if (savedRatings) {
        this.ratings = JSON.parse(savedRatings);
      }
      if (savedComments) {
        this.comments = JSON.parse(savedComments);
      }

      this.calculateOverallPoints();
    },

    calculateOverallPoints() {
      const totalPoints = Object.values(this.ratings).reduce((acc, rating) => {
        return acc + rating;
      }, 0);

      this.overallPoints = totalPoints;
    },

    calculateCategoryRating(categoryId) {
      const categoryRatings = Object.keys(this.ratings)
        .filter((key) => key.startsWith(`c${categoryId}`))
        .map((key) => this.ratings[key]);

      const categoryTotal = categoryRatings.reduce((acc, rating) => acc + rating, 0);
      return categoryRatings.length > 0 ? categoryTotal : 0;
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
  },
};
</script>

<style scoped>
@import "./css/teacher-evaluation.css";
</style>
