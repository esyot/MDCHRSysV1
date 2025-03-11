<style scoped>
@import "./css/form.css";
</style>

<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">ADDITIONAL DETAILS</span>
        </div>

        <div class="form-group">
            <div class="form-group">
                <label for="administrative_offense">
                    Have you ever been found guilty of any administrative
                    offense?
                </label>

                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            name="administrative_offense"
                            value="yes"
                            v-model="administrative_selection"
                            :checked="
                                userDetails.user_other_details
                                    .administrative_offense != 'no' &&
                                userDetails.user_other_details
                                    .administrative_offense != null
                            "
                            class="form-control-radio"
                            @input="
                                handleFieldFocus(
                                    'personalDetails.user_other_details'
                                )
                            "
                        />
                        YES
                    </label>

                    <label>
                        <input
                            type="radio"
                            :name="'administrative_offense'"
                            :id="'administrative_offense_no'"
                            v-model="administrative_selection"
                            value="no"
                            class="form-control-radio"
                            :checked="
                                userDetails.user_other_details
                                    .administrative_offense == 'no'
                            "
                            @input="handleFieldFocus('user_other_details')"
                        />
                        NO
                    </label>
                </div>

                <div
                    v-if="
                        userDetails.user_other_details.administrative_offense !=
                            'no' || administrative_selection == 'yes'
                    "
                >
                    <input
                        type="text"
                        v-model="
                            userDetails.user_other_details
                                .administrative_offense
                        "
                        placeholder="Please specify the details"
                        class="form-control mt-2"
                        @input="handleFieldFocus('user_other_details')"
                    />
                </div>
            </div>
            <div class="form-group">
                <label for="criminal_charge">
                    Have you ever been criminally charged in any court?
                </label>
                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            :name="'criminal_charge'"
                            :id="'criminal_charge_no'"
                            v-model="criminal_selection"
                            value="yes"
                            :checked="
                                userDetails.user_other_details
                                    .criminal_charge != 'no' &&
                                userDetails.user_other_details
                                    .criminal_charge != null
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        YES
                    </label>
                    <label>
                        <input
                            type="radio"
                            :name="'criminal_charge'"
                            :id="'criminal_charge_no'"
                            v-model="criminal_selection"
                            value="no"
                            :checked="
                                userDetails.user_other_details
                                    .criminal_charge == 'no'
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        NO
                    </label>
                </div>
                <input
                    v-if="
                        userDetails.user_other_details.criminal_charge !=
                            'no' || criminal_selection == 'yes'
                    "
                    type="text"
                    v-model="userDetails.user_other_details.criminal_charge"
                    placeholder="Please provide Status of Case/s: (Pending, Dismissed, Acquitted, Convicted)"
                    class="form-control mt-2"
                    @input="handleFieldFocus('user_other_details')"
                />
                <input
                    v-if="
                        userDetails.user_other_details.criminal_charge !=
                            'no' || criminal_selection == 'yes'
                    "
                    type="date"
                    v-model="userDetails.user_other_details.date_filed"
                    class="form-control mt-2"
                    @input="handleFieldFocus('user_other_details')"
                />
            </div>

            <div class="form-group">
                <label for="tribunal">
                    Have you ever been convicted of any crime or violation of
                    any law, decree, ordinance, or regulation by any court or
                    tribunal?
                </label>
                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            :name="'tribunal'"
                            :id="'tribunal_no'"
                            v-model="tribunal_selection"
                            value="yes"
                            :checked="
                                userDetails.user_other_details.tribunal !=
                                    'no' &&
                                userDetails.user_other_details.tribunal != null
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        YES
                    </label>
                    <label>
                        <input
                            type="radio"
                            :name="'tribunal'"
                            :id="'tribunal_no'"
                            v-model="tribunal_selection"
                            value="no"
                            :checked="
                                userDetails.user_other_details.tribunal == 'no'
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        NO
                    </label>
                </div>
                <input
                    v-show="
                        userDetails.user_other_details.tribunal != 'no' ||
                        tribunal_selection == 'yes'
                    "
                    type="text"
                    v-model="userDetails.user_other_details.tribunal"
                    placeholder="Please specify the details"
                    class="form-control mt-2"
                    @input="handleFieldFocus('user_other_details')"
                />
            </div>

            <div class="form-group">
                <label for="service_separation">
                    Have you ever been separated from the service in any of the
                    following ways: resignation, retirement, being dropped from
                    the rolls, dismissal, termination, end of term, finished
                    contract, or phased out (abolition) in the public or private
                    sector?
                </label>
                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            :name="'service_separation'"
                            :id="'service_separation_no'"
                            v-model="service_separation_selection"
                            value="yes"
                            :checked="
                                userDetails.user_other_details
                                    .service_separation != 'no' &&
                                userDetails.user_other_details
                                    .service_separation != null
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        YES
                    </label>
                    <label>
                        <input
                            type="radio"
                            :name="'service_separation'"
                            :id="'service_separation_no'"
                            v-model="service_separation_selection"
                            value="no"
                            :checked="
                                userDetails.user_other_details
                                    .service_separation == 'no'
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        NO
                    </label>
                </div>
                <input
                    v-show="
                        userDetails.user_other_details.service_separation !=
                            'no' || service_separation_selection == 'yes'
                    "
                    type="text"
                    v-model="userDetails.user_other_details.service_separation"
                    placeholder="Please specify the details"
                    class="form-control mt-2"
                    @input="handleFieldFocus('user_other_details')"
                />
            </div>

            <div class="form-group">
                <label for="election_candidacy">
                    Have you ever been a candidate in a national or local
                    election held within the last year (excluding barangay
                    elections)?
                </label>
                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            :name="'election_candidacy'"
                            :id="'election_candidacy_no'"
                            v-model="election_candidacy_selection"
                            value="yes"
                            :checked="
                                userDetails.user_other_details
                                    .election_candidacy != 'no' &&
                                userDetails.user_other_details
                                    .election_candidacy != null
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        YES
                    </label>
                    <label>
                        <input
                            type="radio"
                            :name="'election_candidacy'"
                            :id="'election_candidacy_no'"
                            v-model="election_candidacy_selection"
                            value="no"
                            :checked="
                                userDetails.user_other_details
                                    .election_candidacy == 'no'
                            "
                            class="form-control-radio"
                            @input="handleFieldFocus('user_other_details')"
                        />
                        NO
                    </label>
                </div>
                <input
                    v-show="
                        userDetails.user_other_details.election_candidacy !=
                            'no' || election_candidacy_selection == 'yes'
                    "
                    type="text"
                    v-model="userDetails.user_other_details.election_candidacy"
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
        <div class="details-group" v-if="personalDetails.user_other_details">
            <b
                >1. Have you ever been found guilty of any administrative
                offense?</b
            >
            <span>
                <div
                    v-if="
                        personalDetails.user_other_details
                            .administrative_offense !== 'no'
                    "
                >
                    Answer: YES,
                    {{
                        personalDetails.user_other_details
                            .administrative_offense
                    }}
                </div>
                <div v-else>
                    Answer:
                    {{
                        personalDetails.user_other_details.administrative_offense.toUpperCase()
                    }}
                </div>
            </span>
            <b>2. Have you ever been criminally charged in any court? </b>
            <span>
                <div
                    v-if="
                        personalDetails.user_other_details.criminal_charge !==
                        'no'
                    "
                >
                    Answer: YES,
                    {{ personalDetails.user_other_details.criminal_charge }}.
                    Date Filed:
                    {{ personalDetails.user_other_details.date_filed }}
                </div>
                <div v-else>
                    Answer:
                    {{
                        personalDetails.user_other_details.criminal_charge.toUpperCase()
                    }}
                </div>
            </span>

            <b
                >3. Have you ever been convicted of any crime or violation of
                any law, decree, ordinance, or regulation by any court or
                tribunal?
            </b>
            <span>
                <div
                    v-if="personalDetails.user_other_details.tribunal !== 'no'"
                >
                    Answer: YES,
                    {{ personalDetails.user_other_details.tribunal }}
                </div>
                <div v-else>
                    Answer:
                    {{
                        personalDetails.user_other_details.tribunal.toUpperCase()
                    }}
                </div>
            </span>

            <b
                >4. Have you ever been separated from the service in any of the
                following ways: resignation, retirement, being dropped from the
                rolls, dismissal, termination, end of term, finished contract,
                or phased out (abolition) in the public or private sector?
            </b>

            <span>
                <div
                    v-if="
                        personalDetails.user_other_details
                            .service_separation !== 'no'
                    "
                >
                    Answer: YES,
                    {{ personalDetails.user_other_details.service_separation }}
                </div>
                <div v-else>
                    Answer:
                    {{
                        personalDetails.user_other_details.service_separation.toUpperCase()
                    }}
                </div>
            </span>

            <b>
                5. Have you ever been a candidate in a national or local
                election held within the last year (excluding barangay
                elections)?
            </b>
            <span>
                <div
                    v-if="
                        personalDetails.user_other_details
                            .election_candidacy !== 'no'
                    "
                >
                    Answer: YES,
                    {{ personalDetails.user_other_details.election_candidacy }}
                </div>
                <div v-else>
                    Answer:
                    {{
                        personalDetails.user_other_details.election_candidacy.toUpperCase()
                    }}
                </div>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            administrative_selection: "",
            criminal_selection: "",
            tribunal_selection: "",
            service_separation_selection: "",
            election_candidacy_selection: "",
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
                    this.userDetails.user_other_details.administrative_offense =
                        this.personalDetails.user_other_details.administrative_offense;
                } else {
                    this.userDetails.user_other_details.administrative_offense =
                        "no";
                }
            },
        },
        criminal_selection: {
            handler(newVal) {
                if (newVal === "yes") {
                    this.handleFieldFocus("user_other_details");
                    this.userDetails.user_other_details.criminal_charge =
                        this.personalDetails.user_other_details.criminal_charge;
                } else {
                    this.userDetails.user_other_details.criminal_charge = "no";
                }
            },
        },
        tribunal_selection: {
            handler(newVal) {
                if (newVal === "yes") {
                    this.handleFieldFocus("user_other_details");
                    this.userDetails.user_other_details.tribunal =
                        this.personalDetails.user_other_details.tribunal;
                } else {
                    this.userDetails.user_other_details.tribunal = "no";
                }
            },
        },
        service_separation_selection: {
            handler(newVal) {
                if (newVal === "yes") {
                    this.handleFieldFocus("user_other_details");
                    this.userDetails.user_other_details.service_separation =
                        this.personalDetails.user_other_details.service_separation;
                } else {
                    this.userDetails.user_other_details.service_separation =
                        "no";
                }
            },
        },
        election_candidacy_selection: {
            handler(newVal) {
                if (newVal === "yes") {
                    this.handleFieldFocus("user_other_details");
                    this.userDetails.user_other_details.election_candidacy =
                        this.personalDetails.user_other_details.election_candidacy;
                } else {
                    this.userDetails.user_other_details.election_candidacy =
                        "no";
                }
            },
        },
    },
};
</script>
