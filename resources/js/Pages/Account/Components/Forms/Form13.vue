<template>
  <div class="personal-details-items" v-if="editMode">
    <div class="title-container">
      <span class="title">ADDITIONAL DETAILS</span>
    </div>

    <div
      v-for="(userOtherDetail, index) in userDetails.user_other_details"
      :key="index"
      class="form-group"
    >
      <div class="form-group">
        <label for="administrative_offense"
          >HAVE YOU EVER BEEN FOUND GUILTY OF ANY ADMINISTRATIVE OFFENSE?</label
        >
        <div class="radio-group">
          <label>
            <input
              type="radio"
              :name="'administrative_offense_' + index"
              :id="'administrative_offense_yes_' + index"
              v-model="administrative_selection"
              value="yes"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            YES
          </label>
          <label>
            <input
              type="radio"
              :name="'administrative_offense_' + index"
              :id="'administrative_offense_no_' + index"
              v-model="administrative_selection"
              value="no"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            NO
          </label>
        </div>

        <div v-if="administrative_selection === 'yes'">
          <input
            v-show="administrative_selection === 'yes'"
            type="text"
            v-model="userOtherDetail.administrative_offense"
            placeholder="Please specify the details"
            class="form-control mt-2"
            @input="handleFieldFocus('user_other_details')"
          />
        </div>
      </div>
      <div class="form-group">
        <label for="criminal_charge"
          >Have you been criminally charged before any court?</label
        >
        <div class="radio-group">
          <label>
            <input
              type="radio"
              :name="'criminal_charge_' + index"
              :id="'criminal_charge_no_' + index"
              v-model="criminal_selection"
              value="yes"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            YES
          </label>
          <label>
            <input
              type="radio"
              :name="'criminal_charge_' + index"
              :id="'criminal_charge_no_' + index"
              v-model="userOtherDetail.criminal_charge"
              value="no"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            NO
          </label>
        </div>
        <input
          v-show="criminal_selection === 'yes'"
          type="text"
          v-model="userOtherDetail.criminal_charge"
          placeholder="Please specify the details"
          class="form-control mt-2"
          @input="handleFieldFocus('user_other_details')"
        />
      </div>

      <div class="form-group">
        <label for="tribunal"
          >HAVE YOU EVER BEEN CONVICTED OF ANY CRIME OR VIOLATION OF ANY LAW, DECREE,
          ORDINANCE OR REGULATION BY ANY COURT OR TRIBUNAL?</label
        >
        <div class="radio-group">
          <label>
            <input
              type="radio"
              :name="'tribunal_' + index"
              :id="'tribunal_no_' + index"
              v-model="tribunal_selection"
              value="yes"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            YES
          </label>
          <label>
            <input
              type="radio"
              :name="'tribunal_' + index"
              :id="'tribunal_no_' + index"
              v-model="userOtherDetail.tribunal"
              value="no"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            NO
          </label>
        </div>
        <input
          v-show="tribunal_selection === 'yes'"
          type="text"
          v-model="userOtherDetail.tribunal"
          placeholder="Please specify the details"
          class="form-control mt-2"
          @input="handleFieldFocus('user_other_details')"
        />
      </div>

      <div class="form-group">
        <label for="service_separation"
          >HAVE YOU EVER BEEN SEPARATED FROM THE SERVICE IN ANY OF THE FOLLOWING MODES:
          RESIGNATION, RETIREMENT, DROPPED FROM THE ROLLS, DISMISSAL, TERMINATION, END OF
          TERM, FINISHED CONTRACT, OR PHASED OUT (ABOLITION) IN THE PUBLIC OR PRIVATE
          SECTOR?</label
        >
        <div class="radio-group">
          <label>
            <input
              type="radio"
              :name="'service_separation_' + index"
              :id="'service_separation_no_' + index"
              v-model="service_separation_selection"
              value="yes"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            YES
          </label>
          <label>
            <input
              type="radio"
              :name="'service_separation_' + index"
              :id="'service_separation_no_' + index"
              v-model="userOtherDetail.service_separation"
              value="no"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            NO
          </label>
        </div>
        <input
          v-show="service_separation_selection === 'yes'"
          type="text"
          v-model="userOtherDetail.service_separation"
          placeholder="Please specify the details"
          class="form-control mt-2"
          @input="handleFieldFocus('user_other_details')"
        />
      </div>

      <div class="form-group">
        <label for="election_candidacy"
          >HAVE YOU EVER BEEN A CANDIDATE IN A NATIONAL OR LOCAL ELECTION HELD WITHIN THE
          LAST YEAR (EXCEPT BARANGAY ELECTION)?</label
        >
        <div class="radio-group">
          <label>
            <input
              type="radio"
              :name="'election_candidacy_' + index"
              :id="'election_candidacy_no_' + index"
              v-model="election_candidacy_selection"
              value="yes"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            YES
          </label>
          <label>
            <input
              type="radio"
              :name="'election_candidacy_' + index"
              :id="'election_candidacy_no_' + index"
              v-model="election_candidacy_selection"
              value="no"
              class="form-control-radio"
              @input="handleFieldFocus('user_other_details')"
            />
            NO
          </label>
        </div>
        <input
          v-show="election_candidacy_selection === 'yes'"
          type="text"
          v-model="userOtherDetail.election_candidacy"
          placeholder="Please specify the details"
          class="form-control mt-2"
          @input="handleFieldFocus('user_other_details')"
        />
      </div>
    </div>
  </div>
  <div class="personal-details-items" v-else>
    <div class="title-container">
      <span class="title">ADDITIONAL DETAILS</span>
    </div>
    <div
      v-for="otherDetails in personalDetails.user_other_details"
      :key="otherDetails.id"
      class="form-group"
    >
      <label>HAVE YOU EVER BEEN FOUND GUILTY OF ANY ADMINISTRATIVE OFFENSE?</label>
      <span>
        <div v-if="otherDetails.administrative_offense !== 'no'">
          Answer: YES,
          {{ otherDetails.administrative_offense }}
        </div>
        <div v-else>
          Answer:
          {{ otherDetails.administrative_offense.toUpperCase() }}
        </div>
      </span>

      <label>HAVE YOU BEEN CRIMINALLY CHARGED BEFORE ANY COURT?</label>
      <span>
        <div v-if="otherDetails.criminal_charge !== 'no'">
          Answer: YES,
          {{ otherDetails.criminal_charge }}
        </div>
        <div v-else>
          Answer:
          {{ otherDetails.criminal_charge.toUpperCase() }}
        </div>
      </span>

      <label
        >HAVE YOU EVER BEEN CONVICTED OF ANY CRIME OR VIOLATION OF ANY LAW, DECREE,
        ORDINANCE OR REGULATION BY ANY COURT OR TRIBUNAL?</label
      >
      <span>
        <div v-if="otherDetails.tribunal !== 'no'">
          Answer: YES,
          {{ otherDetails.tribunal }}
        </div>
        <div v-else>
          Answer:
          {{ otherDetails.tribunal.toUpperCase() }}
        </div>
      </span>

      <label
        >HAVE YOU EVER BEEN SEPARATED FROM THE SERVICE IN ANY OF THE FOLLOWING MODES:
        RESIGNATION, RETIREMENT, DROPPED FROM THE ROLLS, DISMISSAL, TERMINATION, END OF
        TERM, FINISHED CONTRACT, OR PHASED OUT (ABOLITION) IN THE PUBLIC OR PRIVATE
        SECTOR?</label
      >

      <span>
        <div v-if="otherDetails.service_separation !== 'no'">
          Answer: YES,
          {{ otherDetails.service_separation }}
        </div>
        <div v-else>
          Answer:
          {{ otherDetails.service_separation.toUpperCase() }}
        </div>
      </span>

      <label
        >HAVE YOU EVER BEEN A CANDIDATE IN A NATIONAL OR LOCAL ELECTION HELD WITHIN THE
        LAST YEAR (EXCEPT BARANGAY ELECTION)?</label
      >
      <span>
        <div v-if="otherDetails.election_candidacy !== 'no'">
          Answer: YES,
          {{ otherDetails.election_candidacy }}
        </div>
        <div v-else>
          Answer:
          {{ otherDetails.election_candidacy.toUpperCase() }}
        </div>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      administrative_selection:
        this.userDetails.user_other_details.administrative_offense == "no" ? "no" : "yes",
      criminal_selection:
        this.userDetails.user_other_details.criminal_charge == "no" ? "no" : "yes",
      tribunal_selection:
        this.userDetails.user_other_details.tribunal == "no" ? "no" : "yes",
      service_separation_selection:
        this.userDetails.user_other_details.tribunal == "no" ? "no" : "yes",
      election_candidacy_selection:
        this.userDetails.user_other_details.tribunal == "no" ? "no" : "yes",
    };
  },
  emits: ["track-touched-field", "update-user-details"],
  props: {
    userDetails: Object,
    editMode: Boolean,
    personalDetails: Object,
  },
  methods: {
    handleFieldFocus(fieldName) {
      this.$emit("track-touched-field", fieldName);
    },

    handleFieldChange(fieldName) {
      this.$emit("update-user-details", {
        [fieldName]: this.userDetails[fieldName],
      });
    },
  },
  watch: {
    personalDetails: {
      handler(newVal) {
        if (newVal.user_other_details) {
          this.userDetails.user_other_details = {
            ...newVal.user_other_details,
          };
        }
      },
      immediate: true,
      deep: true,
    },

    administrative_selection: {
      handler(newVal) {
        if (newVal === "yes") {
          this.handleFieldFocus("user_other_details");
        } else {
          this.userDetails.user_other_details.administrative_offense = "no";
        }
      },
    },
    criminal_selection: {
      handler(newVal) {
        if (newVal === "yes") {
          this.handleFieldFocus("user_other_details");
        } else {
          this.userDetails.user_other_details.criminal_charge = "no";
        }
      },
    },
    tribunal_selection: {
      handler(newVal) {
        if (newVal === "yes") {
          this.handleFieldFocus("user_other_details");
        } else {
          this.userDetails.user_other_details.tribunal = "no";
        }
      },
    },
    service_separation_selection: {
      handler(newVal) {
        if (newVal === "yes") {
          this.handleFieldFocus("user_other_details");
        } else {
          this.userDetails.user_other_details.service_separation = "no";
        }
      },
    },
    election_candidacy_selection: {
      handler(newVal) {
        if (newVal === "yes") {
          this.handleFieldFocus("user_other_details");
        } else {
          this.userDetails.user_other_details.election_candidacy = "no";
        }
      },
    },
  },
};
</script>
