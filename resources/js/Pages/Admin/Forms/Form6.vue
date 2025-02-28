<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">ADMINISTRATIVE POSITIONS HELD</span>
        </div>
        <div
            v-for="userAdminHeld in personalDetails.user_admin_pos_helds"
            :key="userAdminHeld.id"
            class="form-group"
        >
            <label> {{ userAdminHeld.title }}</label>
            <span>
                {{ userAdminHeld.date }} ||
                {{ userAdminHeld.recognition_place }} ||
                {{ userAdminHeld.awarded_by }}
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
.add-field-btn {
    margin-bottom: 20px;
}

.title-container .title {
    font-weight: bold;
    font-size: 18px;
}
</style>
