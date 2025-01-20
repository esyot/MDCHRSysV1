<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">FAMILY BACKGROUND</span>
        </div>

        <div class="form-group">
            <label for="type">SELECT FAMILY MEMBER:</label>
            <select v-model="familyMemberType" class="form-control">
                <option value="spouse">Spouse</option>
                <option value="father">Father</option>
                <option value="mother">Mother</option>
                <option value="children">Children</option>
            </select>
        </div>

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

            <div class="form-group" v-if="familyMemberType === 'spouse'">
                <label for="occupation">SPOUSE OCCUPATION:</label>
                <input
                    type="text"
                    v-model="userDetails.familyDetails.occupation"
                    class="form-control"
                    placeholder="e.g. Teacher, Engineer, Doctor, etc."
                />
            </div>

            <div class="form-group" v-if="familyMemberType === 'mother'">
                <label for="maiden_name">MOTHER'S MAIDEN NAME:</label>
                <input
                    type="text"
                    v-model="userDetails.familyDetails.maidenName"
                    class="form-control"
                    placeholder="e.g. Caingles"
                />
            </div>
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">FAMILY MEMBERS: </span>
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
    data() {
        return {
            familyMemberType: null,
        };
    },
    watch: {
        userDetails: {
            handler(newVal) {
                this.$emit("update-user-details", newVal);
            },
            deep: true,
        },
    },
    methods: {
        submitForm() {
            this.$emit("update-user-details", this.userDetails);
        },
    },
};
</script>
