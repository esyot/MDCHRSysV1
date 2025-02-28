<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">REFERENCES</span>
        </div>
        <div
            v-for="userRef in personalDetails.user_references"
            :key="userRef.id"
            class="form-group"
        >
            <label> {{ userRef.name }}</label>
            <span> {{ userRef.contact_no }} || </span>
            <span>{{ userRef.address.house_no }}</span>
            <span>{{ userRef.address.street }}</span>
            <span>{{ userRef.address.subdv }}</span>
            <span>{{ userRef.address.brgy }}</span>
            <span>{{ userRef.address.municipality }}</span>
            <span>{{ userRef.address.province }}</span>
            <span>{{ userRef.address.zip_code }}</span>
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
