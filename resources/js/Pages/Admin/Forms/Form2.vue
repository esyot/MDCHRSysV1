<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">FAMILY BACKGROUND:</span>
        </div>

        <div
            v-for="userFamily in personalDetails.user_families"
            :key="userFamily.id"
            class="form-group"
        >
            <label
                >{{
                    userFamily.type.charAt(0).toUpperCase() +
                    userFamily.type.slice(1)
                }}
                Name:
            </label>
            <span>
                {{ userFamily.first_name }}
                {{ userFamily.middle_name }}
                {{ userFamily.last_name }}
                {{ userFamily.ext }}
            </span>

            <label>Occupation: </label>
            <span>{{ userFamily.occupation }}</span>
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
