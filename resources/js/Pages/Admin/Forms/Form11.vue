<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">OTHER INFORMATION</span>
        </div>
        <div
            v-for="userOtherInfo in personalDetails.user_other_infos"
            :key="userOtherInfo.id"
            class="form-group"
        >
            <label> {{ userOtherInfo.org_name }}</label>
            <span>
                {{ userOtherInfo.recognition_title }} ||
                {{ userOtherInfo.skill }}
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
