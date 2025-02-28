<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">EDUCATIONAL BACKGROUND</span>
        </div>
        <div
            v-for="userEduc in personalDetails.user_educational_backgrounds"
            :key="userEduc.id"
            class="form-group"
        >
            <label>{{ userEduc.level.toUpperCase() }}</label>
            <span>
                {{ userEduc.school_name }} || {{ userEduc.school_address }} ||
                {{ userEduc.course }} || {{ userEduc.year_graduated }} ||
                {{ userEduc.acad_honors_received }} ||
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
