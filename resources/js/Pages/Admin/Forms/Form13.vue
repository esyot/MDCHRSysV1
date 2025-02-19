<template>
    <div class="personal-details-items">
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
                    {{ personalDetails.user_other_details.criminal_charge }}
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
    props: {
        userDetails: Object,
        editMode: Boolean,
        personalDetails: Object,
    },
};
</script>

<style>
.details-group {
    display: flex;
    flex-direction: column;
    margin: 10px;
    gap: 1rem;
}
</style>
