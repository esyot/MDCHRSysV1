<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">ADDITIONAL DETAILS</span>
        </div>
        <div class="form-group">
            <label for="administrative_offense"
                >HAVE YOU EVER BEEN FOUND GUILTY OF ANY ADMINISTRATIVE
                OFFENSE?</label
            >
            <div class="radio-group">
                <label>
                    <input
                        type="radio"
                        name="administrative_offense"
                        id="administrative_offense"
                        v-model="
                            userDetails.user_other_details
                                .administrative_offense
                        "
                        value="yes"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="administrative_offense"
                        id="administrative_offense"
                        v-model="
                            userDetails.user_other_details
                                .administrative_offense
                        "
                        value="no"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.user_other_details.administrative_offense ===
                    'yes'
                "
            >
                <label for="administrative_offense_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="administrative_offense_details_yes"
                    id="administrative_offense_details_yes"
                    v-model="
                        userDetails.user_other_details
                            .administrative_offense_details
                    "
                    class="form-control"
                    placeholder="Enter details..."
                    @input="handleFieldFocus(`user_other_details`)"
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
                        name="criminal_charge"
                        id="criminal_charge"
                        v-model="userDetails.user_other_details.criminal_charge"
                        value="yes"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="criminal_charge"
                        id="criminal_charge"
                        v-model="userDetails.user_other_details.criminal_charge"
                        value="no"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.user_other_details.criminal_charge === 'yes'
                "
            >
                <label for="criminal_charge_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="criminal_charge_details_yes"
                    id="criminal_charge_details_yes"
                    v-model="
                        userDetails.user_other_details.criminal_charge_details
                    "
                    class="form-control"
                    placeholder="Enter details..."
                    @input="handleFieldFocus(`user_other_details`)"
                />
            </div>
        </div>
        <div class="form-group">
            <label for="tribunal"
                >HAVE YOU EVER BEEN CONVICTED OF ANY CRIME OR VIOLATION OF ANY
                LAW, DECREE, ORDINANCE OR REGULATION BY ANY COURT OR
                TRIBUNAL?</label
            >
            <div class="radio-group">
                <label>
                    <input
                        type="radio"
                        name="tribunal"
                        id="tribunal"
                        v-model="userDetails.user_other_details.tribunal"
                        value="yes"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="tribunal"
                        id="tribunal"
                        v-model="userDetails.user_other_details.tribunal"
                        value="no"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="userDetails.user_other_details.tribunal === 'yes'"
            >
                <label for="tribunal_details">If YES, give details:</label>
                <input
                    type="text"
                    name="tribunal_details_yes"
                    id="tribunal_details_yes"
                    v-model="userDetails.user_other_details.tribunal_details"
                    class="form-control"
                    placeholder="Enter details..."
                    @input="handleFieldFocus(`user_other_details`)"
                />
            </div>
        </div>
        <div class="form-group">
            <label for="service_separation"
                >HAVE YOU EVER BEEN SEPARATED FROM THE SERVICE IN ANY OF THE
                FOLLOWING MODES: RESIGNATION, RETIREMENT, DROPPED FROM THE
                ROLLS, DISMISSAL, TERMINATION, END OF TERM, FINISHED CONTRACT,
                OR PHASED OUT (ABOLITION) IN THE PUBLIC OR PRIVATE
                SECTOR?</label
            >
            <div class="radio-group">
                <label>
                    <input
                        type="radio"
                        name="service_separation"
                        id="service_separation"
                        v-model="
                            userDetails.user_other_details.service_separation
                        "
                        value="yes"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="service_separation"
                        id="service_separation"
                        v-model="
                            userDetails.user_other_details.service_separation
                        "
                        value="no"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.user_other_details.service_separation === 'yes'
                "
            >
                <label for="service_separation_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="service_separation_details_yes"
                    id="service_separation_details_yes"
                    v-model="
                        userDetails.user_other_details
                            .service_separation_details
                    "
                    class="form-control"
                    placeholder="Enter details..."
                    @input="handleFieldFocus(`user_other_details`)"
                />
            </div>
        </div>
        <div class="form-group">
            <label for="election_candidacy"
                >HAVE YOU EVER BEEN CANDIDATE IN A NATIONAL OR LOCAL ELECTION
                HELD WITHIN THE LAST YEAR (EXCEPT BARANGAY ELECTION)?</label
            >
            <div class="radio-group">
                <label>
                    <input
                        type="radio"
                        name="election_candidacy"
                        id="election_candidacy"
                        v-model="
                            userDetails.user_other_details.election_candidacy
                        "
                        value="yes"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="election_candidacy"
                        id="election_candidacy"
                        v-model="
                            userDetails.user_other_details.election_candidacy
                        "
                        value="no"
                        class="form-control-radio"
                        @input="handleFieldFocus(`user_other_details`)"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.user_other_details.election_candidacy === 'yes'
                "
            >
                <label for="election_candidacy_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="election_candidacy_details_yes"
                    id="election_candidacy_details_yes"
                    v-model="
                        userDetails.user_other_details
                            .election_candidacy_details
                    "
                    class="form-control"
                    placeholder="Enter details..."
                    @input="handleFieldFocus(`user_other_details`)"
                />
            </div>
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">ADDITIONAL DETAILS</span>
        </div>
        <div
            v-for="otherDetails in personalDetails.user_other_details"
            :key="otherDetails.id"
            class="form-group"
        >
            <label>ADMINISTRATIVE OFFENSES:</label>
            <span>{{ otherDetails.administrative_offense }}</span>

            <label>CRIMINAL CHARGES:</label>
            <span>{{ otherDetails.criminal_charge }}</span>
            >
            <label>ADMINISTRATIVE OFFENSES:</label>
            <span>{{ otherDetails.tribunal }}</span>
            >
            <label>ADMINISTRATIVE OFFENSES:</label>
            <span>{{ otherDetails.service_separation }}</span>
            >
            <label>ADMINISTRATIVE OFFENSES:</label>
            <span>{{ otherDetails.election_candidacy }}</span>
        </div>
    </div>
</template>

<script>
export default {
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
                this.userDetails.user_other_details =
                    newVal.user_other_details || {
                        administrative_offense: "",
                        criminal_charge: "",
                        tribunal: "",
                        service_separation: "",
                        election_candidacy: "",
                    };
            },
            immediate: true,
        },
    },
};
</script>
