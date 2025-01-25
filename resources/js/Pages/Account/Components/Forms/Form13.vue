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
                            userDetails.userOtherDetails.administrative_offense
                        "
                        value="yes"
                        class="form-control-radio"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="administrative_offense"
                        id="administrative_offense"
                        v-model="
                            userDetails.userOtherDetails.administrative_offense
                        "
                        value="no"
                        class="form-control-radio"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.userOtherDetails.administrative_offense ===
                    'yes'
                "
            >
                <label for="administrative_offense_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="administrative_offense_details"
                    id="administrative_offense_details"
                    v-model="userDetails.administrative_offense_details"
                    class="form-control"
                    placeholder="Enter details..."
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
                        v-model="userDetails.userOtherDetails.criminal_charge"
                        value="yes"
                        class="form-control-radio"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="criminal_charge"
                        id="criminal_charge"
                        v-model="userDetails.userOtherDetails.criminal_charge"
                        value="no"
                        class="form-control-radio"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="userDetails.userOtherDetails.criminal_charge === 'yes'"
            >
                <label for="criminal_charge_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="criminal_charge_details"
                    id="criminal_charge_details"
                    v-model="userDetails.criminal_charge_details"
                    class="form-control"
                    placeholder="Enter details..."
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
                        v-model="userDetails.userOtherDetails.tribunal"
                        value="yes"
                        class="form-control-radio"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="tribunal"
                        id="tribunal"
                        v-model="userDetails.userOtherDetails.tribunal"
                        value="no"
                        class="form-control-radio"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="userDetails.userOtherDetails.tribunal === 'yes'"
            >
                <label for="tribunal_details">If YES, give details:</label>
                <input
                    type="text"
                    name="tribunal_details"
                    id="tribunal_details"
                    v-model="userDetails.tribunal_details"
                    class="form-control"
                    placeholder="Enter details..."
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
                            userDetails.userOtherDetails.service_separation
                        "
                        value="yes"
                        class="form-control-radio"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="service_separation"
                        id="service_separation"
                        v-model="
                            userDetails.userOtherDetails.service_separation
                        "
                        value="no"
                        class="form-control-radio"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.userOtherDetails.service_separation === 'yes'
                "
            >
                <label for="service_separation_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="service_separation_details"
                    id="service_separation_details"
                    v-model="userDetails.service_separation_details"
                    class="form-control"
                    placeholder="Enter details..."
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
                            userDetails.userOtherDetails.election_candidacy
                        "
                        value="yes"
                        class="form-control-radio"
                    />
                    YES
                </label>
                <label>
                    <input
                        type="radio"
                        name="election_candidacy"
                        id="election_candidacy"
                        v-model="
                            userDetails.userOtherDetails.election_candidacy
                        "
                        value="no"
                        class="form-control-radio"
                    />
                    NO
                </label>
            </div>
            <div
                class="form-group"
                v-show="
                    userDetails.userOtherDetails.election_candidacy === 'yes'
                "
            >
                <label for="election_candidacy_details"
                    >If YES, give details:</label
                >
                <input
                    type="text"
                    name="election_candidacy_details"
                    id="election_candidacy"
                    v-model="userDetails.election_candidacy_details"
                    class="form-control"
                    placeholder="Enter details..."
                />
            </div>
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title"
                >CURRICULAR AND SCHOOL COMMITTEE ASSIGNMENTS</span
            >
        </div>
    </div>
</template>

<script>
export default {
    emits: ["update-user-details"],
    props: {
        userDetails: Object,
        editMode: Boolean,
    },
    watch: {
        userDetails: {
            handler(newVal) {
                this.$emit("update-user-details", newVal);
            },
            deep: true,
        },
    },
};
</script>
