<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"
                >PARTICIPATION IN COMMUNITY OUTREACH FORM (Last 2 Years)</span
            >
        </div>
        <div
            v-for="userParticipation in personalDetails.user_participations"
            :key="userParticipation.id"
            class="form-group"
        >
            <label> {{ userParticipation.title }}</label>
            <span>
                {{ userParticipation.date_from }} ||
                {{ userParticipation.date_to }} ||
                {{ userParticipation.hours_no }} ||
                {{ userParticipation.position }}
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
