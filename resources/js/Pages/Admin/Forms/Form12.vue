<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"
                >CURRICULAR AND SCHOOL COMMITTEE ASSIGNMENTS</span
            >
        </div>
        <div
            v-for="userSchoolCur in personalDetails.user_school_curriculars"
            :key="userSchoolCur.id"
            class="form-group"
        >
            <label> {{ userSchoolCur.title }}</label>
            <span>
                {{ userSchoolCur.date }} || {{ userSchoolCur.event_name }} ||
                {{ userSchoolCur.designation }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userDetails: Object,
        personalDetails: Object,
    },
};
</script>

<style scoped>
.form-group {
    margin-bottom: 10px;
}
.title-container .title {
    font-weight: bold;
    font-size: 18px;
}
</style>
