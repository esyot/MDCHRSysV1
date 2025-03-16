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
      term: "",
      currentDate: new Date(),
      comments: {},
      ratings: {},
      overallPoints: 0,
      subjects: [],
    };
  },

  mounted() {
    this.loadFromLocalStorage();
  },

  watch: {
    term(newVal) {
      if (newVal) {
        this.fetchSubjects();
      }
    },
  },

  computed: {
    filteredSubjects() {
      return this.subjects.filter((subject) => {
        return (
          !Array.isArray(this.evaluations) ||
          !this.evaluations.some((evaluation) => evaluation.subject_id === subject.id)
        );
      });
    },
  },
  methods: {
    fetchSubjects() {
      const params = {
        code: this.api_key,
        teacher_id: this.user.teacher.id,
        term_id: this.term,
      };

      const queryString = new URLSearchParams(params).toString();

      try {
        axios
          .get(`https://sis.materdeicollege.com/api/hr/subject-classes/?${queryString}`)
          .then((response) => {
            this.subjects = response.data;
          })
          .catch((error) => {
            console.error("error fetching data:", error);
          });
      } catch (error) {
        console.error("error method:", error);
      }
    },

    goBack() {
      window.history.back();
    },

    submitForm(event) {
      event.preventDefault();

      Inertia.post(`/evaluations/evaluation-submit`, {
        user_id: this.user.id,
        template_id: this.template_id,
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
    <div class="user-details">
      <div class="user-details-item">
        <label for="">Name: </label>
        <span> {{ user.last_name }}, {{ user.first_name }} </span>
      </div>

      <div class="user-details-item">
        <label for="">Date: </label>
        <span> {{ formatDate(currentDate) }}</span>
      </div>
    </div>

    <div class="instruction">
      <div>
        <p>
          <strong>INSTRUCTION:</strong> Rate the teacher using the 5-point rating scale by
          checking the appropriate box that matches the given statement.
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
            <strong>4</strong> - Often Observed (When the teacher missed it around 1 to 3
            times when appropriate)
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

    <form @submit.prevent="submitForm">
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

<style scoped>
@import "./css/teacher-evaluation.css";
</style>
