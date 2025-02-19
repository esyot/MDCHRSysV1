<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">WORK/TEACHING EXPERIENCE</span>
        </div>
        <div
            v-for="userWorkExp in personalDetails.user_work_experiences"
            :key="userWorkExp.id"
            class="form-group"
        >
            <label> {{ userWorkExp.company_name }}</label>
            <span>
                {{ userWorkExp.date_from }} || {{ userWorkExp.date_to }} ||
                {{ userWorkExp.rank }} ||
                {{ userWorkExp.status }}
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
