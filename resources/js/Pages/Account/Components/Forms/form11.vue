<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">OTHER INFORMATION</span>
        </div>
        <div class="form-group">
            <label for="skill">SPECIAL SKILLS & HOBBIES:</label>
            <input
                type="text"
                name="skills"
                id="skills"
                v-model="userDetails.userOtherInfo.skill"
                class="form-control"
                placeholder="eg., Singing, Dancing, Martial Arts, etc."
            />
        </div>
        <div class="form-group">
            <label for="recognition_title"
                >NON-ACADEMIC DITICNTIONS/RECOGNITION (Write in Full):</label
            >
            <input
                type="text"
                name="recognition_title"
                id="recognition_title"
                v-model="userDetails.userOtherInfo.recognition"
                class="form-control"
                placeholder="eg., Best Student, Best Athlete, etc."
            />
        </div>
        <div class="form-group">
            <label for="org_name"
                >MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in Full):</label
            >
            <input
                type="text"
                name="org_name"
                id="org_name"
                v-model="userDetails.userOtherInfo.org"
                class="form-control"
                placeholder="eg., Rotary Club, Lions Club, etc."
            />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">OTHER INFORMATION</span>
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
