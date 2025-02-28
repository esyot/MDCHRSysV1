<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"
                >RESEARCH STUDIES, RESEARCH PROJECTS AND BOOK PUBLISHED</span
            >
        </div>
        <div
            v-for="userStud in personalDetails.user_studies"
            :key="userStud.id"
            class="form-group"
        >
            <label> {{ userStud.research_title }}</label>
            <span>
                {{ userStud.date_published }} || {{ userStud.journal_name }} ||
                {{ userStud.link }}
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
