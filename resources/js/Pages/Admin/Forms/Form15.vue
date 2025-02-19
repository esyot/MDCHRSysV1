<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">USER VALID IDs</span>
        </div>
        <div
            v-for="userValidIds in personalDetails.user_valid_ids"
            :key="userValidIds.id"
            class="form-group"
        >
            <label>{{ userValidIds.id_type }}</label>
            <span>
                {{ userValidIds.id_no }} || {{ userValidIds.date_issued }} ||
                {{ userValidIds.date_expiry }}
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
