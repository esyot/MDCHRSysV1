<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">FAMILY BACKGROUND</span>
        </div>

        <!-- Family Member Type Selection -->
        <div class="form-group">
            <label for="type">SELECT FAMILY MEMBER:</label>
            <select v-model="familyMemberType" class="form-control">
                <option value="spouse">Spouse</option>
                <option value="father">Father</option>
                <option value="mother">Mother</option>
                <option value="children">Children</option>
            </select>
        </div>

        <!-- Dynamic Form Fields Based on Family Member Type -->
        <div v-if="familyMemberType">
            <div class="form-group">
                <label for="last_name"
                    >{{ familyMemberType.toUpperCase() }} SURNAME:</label
                >
                <input
                    type="text"
                    v-model="userDetails.familyDetails.lastName"
                    class="form-control"
                    placeholder="e.g. Esteban"
                />
            </div>

            <div class="form-group">
                <label for="first_name"
                    >{{ familyMemberType.toUpperCase() }} FIRST NAME:</label
                >
                <input
                    type="text"
                    v-model="userDetails.familyDetails.firstName"
                    class="form-control"
                    placeholder="e.g. Reinhard"
                />
            </div>

            <div class="form-group">
                <label for="middle_name"
                    >{{ familyMemberType.toUpperCase() }} MIDDLE NAME:</label
                >
                <input
                    type="text"
                    v-model="userDetails.familyDetails.middleName"
                    class="form-control"
                    placeholder="e.g. Lanoy"
                />
            </div>

            <div class="form-group">
                <label for="ext"
                    >{{ familyMemberType.toUpperCase() }} NAME EXTENSION:</label
                >
                <input
                    type="text"
                    v-model="userDetails.familyDetails.ext"
                    class="form-control"
                    placeholder="e.g. Jr., Sr., III, etc."
                />
            </div>

            <!-- Spouse Specific Fields -->
            <div class="form-group" v-if="familyMemberType === 'spouse'">
                <label for="occupation">SPOUSE OCCUPATION:</label>
                <input
                    type="text"
                    v-model="userDetails.familyDetails.occupation"
                    class="form-control"
                    placeholder="e.g. Teacher, Engineer, Doctor, etc."
                />
            </div>

            <!-- Mother Specific Fields -->
            <div class="form-group" v-if="familyMemberType === 'mother'">
                <label for="maiden_name">MOTHER'S MAIDEN NAME:</label>
                <input
                    type="text"
                    v-model="userDetails.familyDetails.maidenName"
                    class="form-control"
                    placeholder="e.g. Caingles"
                />
            </div>

            <!-- Submit Button -->
            <div class="form-group submit-btn">
                <button type="submit" @click="submitForm">Submit</button>
            </div>
        </div>
    </div>

    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">FAMILY MEMBERS: </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userDetails: Object, // This comes from the parent, holding the familyDetails object
    },
    data() {
        return {
            familyMemberType: null, // The selected family member type
        };
    },
    watch: {
        // Watch for changes in userDetails and emit back to parent
        userDetails: {
            handler(newVal) {
                this.$emit("update-user-details", newVal);
            },
            deep: true, // Ensures nested changes are captured
        },
    },
    methods: {
        submitForm() {
            // Handle form submission logic here
            // You could perform validation or other actions before emitting the updated userDetails.
            this.$emit("update-user-details", this.userDetails);
        },
    },
};
</script>
