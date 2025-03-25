<script src="./js/teacher-evaluation.js"></script>

<template>
  <div id="content" class="content" ref="content" @scroll="onScroll">
    <div class="evaluation-container" v-if="evalCategories.length > 0">
      <div class="navigation">
        <button @click="goBack()">
          <i class="fa fa-arrow-left"></i><span> Back</span>
        </button>
      </div>
      <div class="evaluation-form-title">
        <span>Teacher's Evaluation</span>
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
          <div v-if="term_id && template.type != 'work'" class="user-details-item">
            <label for="">Subject: </label>
            <select name="" id="" v-model="subject_id" required>
              <option value="" selected disabled>Select a Subject</option>
              <option
                :value="subject.id"
                v-for="subject in filteredSubjects"
                :key="subject.id"
              >
                {{ subject.course_no }} - {{ subject.description }}
              </option>
            </select>
          </div>
        </div>

        <div class="instruction">
          <div>
            <p>
              <strong>INSTRUCTION:</strong> Rate the teacher using the 5-point rating
              scale by checking the appropriate box that matches the given statement.
            </p>
            <p>
              <strong>Description:</strong>
            </p>
            <ul>
              <li>
                <strong>5</strong> - Always Observed (When the teacher did not miss in
                doing it all meetings)
              </li>
              <li>
                <strong>4</strong> - Often Observed (When the teacher missed it around 1
                to 3 times when appropriate)
              </li>
              <li>
                <strong>3</strong> - Sometimes Observed (When the teacher missed it around
                4 to 7 times when appropriate)
              </li>
              <li>
                <strong>2</strong> - Rarely Observed (When the teacher missed it more than
                7 times when appropriate)
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
                  <span class="underline">
                    {{ calculateCategoryRating(category.id) }}</span
                  >
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
    <div @click="scroll('down')" v-if="scrollPosition === 0" class="scroll-to-down">
      <i class="fas fa-circle-chevron-down fa-2x"></i>
    </div>

    <div @click="scroll('top')" v-if="scrollPosition === max" class="scroll-to-top">
      <i class="fas fa-circle-chevron-up fa-2x"></i>
    </div>
  </div>
</template>

<style scoped>
@import "./css/teacher-evaluation.css";
</style>
