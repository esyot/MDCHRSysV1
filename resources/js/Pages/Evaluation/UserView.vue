<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: Layout,
  props: {
    user_id: String,
    userRoles: Array,
    personalDetails: Object,
    terms: Array,
    currentTerm: Number,
    roles: {
      type: Array,
      default: () => [],
    },
    evaluations: Object,
  },
  data() {
    return {
      AdminActiveTab: "overview",
      selectedFormType: "teacher",
      selectedTerm: this.currentTerm ?? null,
      isOpenEvalationDropDown: false,
    };
  },

  computed: {
    firstSem() {
      return this.evaluations.filter(
        (evaluation) =>
          evaluation.semister === "first" && evaluation.acad_term_id === this.selectedTerm
      );
    },
    secondSem() {
      return this.evaluations.filter(
        (evaluation) =>
          evaluation.semister === "second" &&
          evaluation.acad_term_id === this.selectedTerm
      );
    },
  },

  methods: {
    openEval(type) {
      if (type === "teacher") {
        Inertia.visit(`/forms/evaluation-form/${this.personalDetails.id}/teacher`);
      } else if (type === "staff") {
        Inertia.visit(`/forms/evaluation-form/${this.personalDetails.id}/staff`);
      }
    },
    toggleEvaluationDropDown() {
      this.isOpenEvalationDropDown = !this.isOpenEvalationDropDown;
    },
    closeEvaluationDropDown(event) {
      if (
        this.$refs.evaluationDropDown &&
        !this.$refs.toggleEvaluationDropDown.contains(event.target)
      ) {
        this.isOpenEvalationDropDown = false;
      }
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
    calculateOverallPercentage(evaluations) {
      let totalPercentage = 0;
      let count = evaluations.length;

      evaluations.forEach((evaluation) => {
        const percentage = (evaluation.overall_mean / 5) * 100;
        totalPercentage += percentage;
      });

      const percentage = count > 0 ? totalPercentage / count : 0;

      if (percentage === 0) {
        return percentage.toString();
      }

      return percentage % 1 === 0 ? percentage.toString() : percentage.toFixed(2);
    },
    calculateOverallPoints(evaluations) {
      let totalPoints = 0;

      evaluations.forEach((evaluation) => {
        const point = evaluation.overall_points * 1;
        totalPoints += point;
      });

      return totalPoints;
    },

    overallSemisterPoints(evaluations) {
      let totalPoints = 0;

      evaluations.forEach((evaluation) => {
        const point = evaluation.overall_points * 1;
        totalPoints += point;
      });

      return totalPoints;
    },

    overallSemisterPercentage(evaluations) {
      let totalPercentage = 0;
      let count = evaluations.length;

      evaluations.forEach((evaluation) => {
        const percentage = (evaluation.overall_mean / 5) * 100;
        totalPercentage += percentage;
      });

      const percentage = count > 0 ? totalPercentage / count : 0;

      return percentage.toFixed(2);
    },
  },

  mounted() {
    document.addEventListener("click", this.closeEvaluationDropDown);
  },
  beforeDestroy() {
    document.removeEventListener("click", this.closeEvaluationDropDown);
  },
};
</script>

<template>
  <div class="container">
    <div class="content" v-if="AdminActiveTab === 'overview'">
      <div class="user">
        <div class="user-content">
          <div>
            <img
              :src="
                personalDetails.img
                  ? `/storage/users/images/${personalDetails.img}`
                  : '/assets/images/user.png'
              "
              alt="User Image"
              class="user-img"
            />
          </div>
          <div class="user-details">
            <span class="name"
              >{{ personalDetails.first_name }} {{ personalDetails.last_name }}</span
            >
            <div class="user-role" v-if="personalDetails.teacher?.department">
              <i class="fas fa-globe"></i>
              <div>
                <span class="role-desc">{{
                  personalDetails.teacher.department.name
                }}</span>
              </div>
            </div>
            <div class="user-role" v-if="userRoles.length">
              <i class="fas fa-user-cog"></i>
              <div>
                <span class="role-desc">{{ userRoles.join(", ") }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="buttons">
        <div class="btn-left">
          <select
            v-model="selectedFormType"
            title="Select type of forms to be displayed in the table below."
          >
            <option value="teacher">Teacher Evaluation</option>
            <option value="staff">Staff Evaluation</option>
          </select>

          <select
            v-model="selectedTerm"
            title="Select a year to be filtered in the table below."
          >
            <option v-for="(term, index) in terms" :key="index" :value="term.id">
              AY - {{ term.start }}-{{ term.end }}
            </option>
          </select>
        </div>

        <div class="btn-right">
          <button
            v-if="roles.includes('dean') || roles.includes('hr')"
            :title="`Add evaluation for ${personalDetails.last_name}, ${personalDetails.first_name}`"
            @click="toggleEvaluationDropDown"
            ref="toggleEvaluationDropDown"
          >
            Add Another Evaluation
          </button>

          <div
            ref="evaluationDropDown"
            class="evalution-dropdown"
            v-if="isOpenEvalationDropDown"
          >
            <span
              v-if="roles.includes('dean') && userRoles.includes('teacher')"
              @click="openEval('teacher')"
              >Teacher Evaluation</span
            >
            <span
              v-if="roles.includes('hr') && userRoles.includes('staff')"
              @click="openEval('staff')"
              >Staff Evaluation</span
            >
          </div>
        </div>
      </div>

      <div class="table-container">
        <div class="tables">
          <div class="table">
            <div class="table-title">
              <span>1st Semester</span>
            </div>

            <table>
              <thead>
                <tr>
                  <th class="left"><i class="fas fa-list"></i></th>
                  <th><i class="fas fa-calendar-days"></i></th>
                  <th><i class="fas fa-star"></i></th>
                  <th><i class="fas fa-percent"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="evaluation in firstSem" :key="evaluation.id">
                  <td>
                    <span
                      >{{ evaluation.subject.course_no }} -
                      <small> {{ evaluation.subject.description }}</small></span
                    >
                  </td>
                  <td>
                    <span>{{ formatDate(evaluation.created_at) }}</span>
                  </td>
                  <td>
                    <span
                      >{{ evaluation.overall_points }} / {{ evaluation.maxPoints }}
                    </span>
                  </td>

                  <td>
                    <span>{{ (evaluation.overall_mean / 5) * 100 }}% </span>
                  </td>
                </tr>
                <tr class="ratings">
                  <td>Result:</td>
                  <td></td>
                  <td>{{ calculateOverallPoints(firstSem) }} pts</td>
                  <td>{{ calculateOverallPercentage(firstSem) }}%</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="table">
            <div class="table-title">
              <span>2nd Semester</span>
            </div>
            <table>
              <thead>
                <tr>
                  <th class="left"><i class="fas fa-list"></i></th>
                  <th><i class="fas fa-calendar-days"></i></th>
                  <th><i class="fas fa-star"></i></th>
                  <th><i class="fas fa-percent"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="evaluation in secondSem" :key="evaluation.id">
                  <td>
                    <span
                      >{{ evaluation.subject.course_no }} -
                      <small> {{ evaluation.subject.description }}</small></span
                    >
                  </td>
                  <td>
                    <span>{{ formatDate(evaluation.created_at) }}</span>
                  </td>
                  <td>
                    <span
                      >{{ evaluation.overall_points }} / {{ evaluation.maxPoints }}
                    </span>
                  </td>

                  <td>
                    <span>{{ (evaluation.overall_mean / 5) * 100 }}% </span>
                  </td>
                </tr>
                <tr class="ratings">
                  <td>Result:</td>
                  <td></td>
                  <td>{{ calculateOverallPoints(secondSem) }} pts</td>
                  <td>{{ calculateOverallPercentage(secondSem) }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="table-footer">
          <label for="">Overall Semister Points</label>
          <span>{{ overallSemisterPoints(evaluations) }} pts</span>

          <label for="">Overall Semister Percentage</label>
          <span>{{ overallSemisterPercentage(evaluations) }}%</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/user-view.css";
</style>
