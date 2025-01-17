<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">PROFESSIONAL EXAMINATION FORM</span>
        </div>
        <div class="form-group">
            <label for="title">PROFESSIONAL/BOARD EXAMINATION:</label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-control"
                v-model="userDetails.userProfExamDetails.title"
                placeholder="e.g., Civil Engineer Licensure Exam"
            />
        </div>
        <div class="form-group">
            <label for="rating">RATING (If Applicable):</label>
            <input
                type="text"
                name="rating"
                id="rating"
                class="form-control"
                v-model="userDetails.userProfExamDetails.rating"
                placeholder="e.g., 85.00% or 85.00/100.00"
            />
        </div>
        <div class="form-group">
            <label for="date">DATE PASSED:</label>
            <input
                type="date"
                name="date"
                id="date"
                class="form-control"
                v-model="userDetails.userProfExamDetails.date"
            />
        </div>
        <div class="form-group">
            <label for="place">PLACE OF EXAMINATION/CONFERMENT:</label>
            <input
                type="text"
                name="place"
                id="place"
                class="form-control"
                v-model="userDetails.userProfExamDetails.place"
                placeholder="e.g., Professional Regulation Commission (PRC), Manila"
            />
        </div>
        <div class="form-group">
            <label for="license_no">LICENSE NO.(If Applicable):</label>
            <input
                type="text"
                name="license_no"
                id="license_no"
                class="form-control"
                v-model="userDetails.userProfExamDetails.license_no"
                placeholder="e.g., 123456"
            />
        </div>
        <div class="form-group">
            <label for="validity">VALIDITY (If Applicable):</label>
            <input
                type="text"
                name="validity"
                id="validity"
                class="form-control"
                v-model="userDetails.userProfExamDetails.validity"
                placeholder="e.g., 2022-2025"
            />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title"
                >PROFESSIONAL GOVERNMENT PASSED/CIVIL SERVICE ELIGIBILITY</span
            >
        </div>
    </div>
</template>

<script>
export default {
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
