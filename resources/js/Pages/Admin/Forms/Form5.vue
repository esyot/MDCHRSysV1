<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"
                >ACADEMIC AWARDS, HONORS, HONORARY DEGREE RECIEVED</span
            >
        </div>
        <div
            v-for="userAward in personalDetails.user_award_receives"
            :key="userAward.id"
            class="form-group"
        >
            <label>{{ userAward.title }}</label>
            <span>
                {{ userAward.date_received }} ||
                {{ userAward.recognition_place }} ||
                {{ userAward.awarded_by }}
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
