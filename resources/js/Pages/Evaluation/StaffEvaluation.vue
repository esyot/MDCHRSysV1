<script>
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

export default {
  props: {
    user: Object,
    terms: Object,
    evalCategories: Object,
    template_id: Number,
    api_key: String,
    evaluations: Object,
  },

  data() {
    return {
      currentDate: new Date(),
      comments: {},
      ratings: {},
      overallPoints: 0,
      overallMean: 0,
      subjects: [],
      subject_id: "",
      term_id: "",
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

      Inertia.post(`/evaluations/evaluation-submit`, {
        type: "teacher",
        user_id: this.user.id,
        template_id: this.template_id,
        term_id: this.term_id,
        subject_id: this.subject_id,
        overallPoints: this.overallPoints,
        overallMean: this.overallMean.toFixed(2),
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
      let totalPoints = 0;
      let totalMean = 0;

      this.evalCategories.forEach((category) => {
        const categoryPoints = category.items.reduce((acc, item) => {
          const rating = this.ratings[`c${category.id}_i${item.id}`];
          return acc + (rating || 0);
        }, 0);

        const categoryMean =
          category.items.length > 0 ? categoryPoints / category.items.length : 0;

        totalPoints += categoryPoints;

        totalMean += categoryMean;
      });

      this.overallPoints = totalPoints;

      this.overallMean = totalMean / this.evalCategories.length;
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

<template>
  <div class="evaluation-container" v-if="evalCategories.length > 0">
    <div class="navigation">
      <button @click="goBack()">
        <i class="fa fa-arrow-left"></i><span> Back</span>
      </button>
    </div>
    <div class="evaluation-form-title">
      <span>Staff's Evaluation</span>
    </div>
    <form @submit.prevent="submitForm">
      <div class="user-details">
        <div class="user-details-item">
          <label for="">Name: </label>
          <span> {{ user.last_name }}, {{ user.first_name }} </span>
        </div>

        <div class="user-details-item">
          <label for="">Date: </label>
          <span> {{ formatDate(currentDate) }}</span>
        </div>

        <div class="user-details-item">
          <label for="">Term: </label>
          <select v-model="term_id" required>
            <option value="" selected disabled>Select a Term</option>
            <option v-for="term in terms" :key="term.id" :value="term.id">
              {{ term.name }}
            </option>
          </select>
        </div>
      </div>

      <div class="instruction">
        <div>
          <p>
            <strong>INSTRUCTION:</strong> Rate the teacher using the 5-point rating scale
            by checking the appropriate box that matches the given statement.
          </p>
          <p>
            <strong>Description:</strong>
          </p>
          <ul>
            <li>
              <strong>5</strong> - Always Observed (When the teacher did not miss in doing
              it all meetings)
            </li>
            <li>
              <strong>4</strong> - Often Observed (When the teacher missed it around 1 to
              3 times when appropriate)
            </li>
            <li>
              <strong>3</strong> - Sometimes Observed (When the teacher missed it around 4
              to 7 times when appropriate)
            </li>
            <li>
              <strong>2</strong> - Rarely Observed (When the teacher missed it more than 7
              times when appropriate)
            </li>
            <li>
              <strong>1</strong> - Never Observed (When the teacher did not do it at all
              when appropriate)
            </li>
          </ul>
        </div>
      </div>
      <div v-if="evalCategories && evalCategories.length > 0">
        <div v-for="(category, index) in evalCategories" :key="index" class="forms">
          <table class="evaluation-table">
            <thead>
              <tr>
                <th class="td-item">{{ category.title }}</th>
                <th class="th-rating"><label>Rate</label></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in category.items || []" :key="index">
                <td>{{ item.description }}</td>
                <td>
                  <div class="td-rating">
                    <div v-for="rating in [5, 4, 3, 2, 1]" :key="rating">
                      <input
                        type="radio"
                        :name="'c' + category.id + '_i' + item.id"
                        :value="rating"
                        v-model="ratings[`c${category.id}_i${item.id}`]"
                        @change="saveToLocalStorage"
                        :checked="ratings[`c${category.id}_i${item.id}`] === rating"
                        required
                      />
                      <label for=""> {{ rating }}</label>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="table-footer">
            <div class="comment">
              <label>Comments:</label>
              <textarea
                v-model="comments[category.id]"
                @input="saveToLocalStorage"
                rows="3"
                required
              ></textarea>
            </div>
            <div class="rating">
              <div>
                <label>Points: </label>
                <span class="underline"> {{ calculateCategoryRating(category.id) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer">
        <div class="item">
          <label for="">Overall Points:</label>
          <span class="underline">{{ overallPoints }}</span>
        </div>

        <div class="item">
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

<style scoped>
@import "./css/teacher-evaluation.css";
</style>
