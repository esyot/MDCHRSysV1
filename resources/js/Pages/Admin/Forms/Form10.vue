<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"
                >SPECIAL TRAINING COURSES, SEMINARS, SYMPOSIA PARTICIPATED (Last
                5 Years)</span
            >
        </div>
        <div
            v-for="userSpecialTraining in personalDetails.user_special_trainings"
            :key="userSpecialTraining.id"
            class="form-group"
        >
            <label> {{ userSpecialTraining.title }}</label>
            <span>
                {{ userSpecialTraining.attendance_from }} ||
                {{ userSpecialTraining.attendance_to }} ||
                {{ userSpecialTraining.days }} ||
                {{ userSpecialTraining.type }} ||
                {{ userSpecialTraining.conducted_by }}
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
