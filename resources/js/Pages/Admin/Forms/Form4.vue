<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"
                >PROFESSIONAL GOVERNMENT PASSED/CIVIL SERVICE ELIGIBILITY</span
            >
        </div>
        <div
            v-for="userProf in personalDetails.user_professional_examinations"
            :key="userProf.id"
            class="form-group"
        >
            <label>{{ userProf.title }}</label>
            <span>
                {{ userProf.rating }} || {{ userProf.date }} ||
                {{ userProf.place }} || {{ userProf.license_no }} ||
                {{ userProf.validity }}
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

input.form-control {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
}
</style>
