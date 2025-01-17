<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">WORK/TEACHING EXPERIENCE FORM</span>
        </div>
        <div class="form-group">
            <label for="date_from">DATE FROM:</label>
            <input
                type="date"
                name="date_from"
                id="date_from"
                v-model="userDetails.userWorkExpDetails.date_from"
            />
        </div>
        <div class="form-group">
            <label for="date_to">DATE TO:</label>
            <input
                type="date"
                name="date_to"
                id="date_to"
                v-model="userDetails.userWorkExpDetails.date_to"
            />
        </div>
        <div class="form-group">
            <label for="position">POSITION TITLE:</label>
            <input
                type="text"
                name="position"
                id="position"
                v-model="userDetails.userWorkExpDetails.position"
                class="form-control"
                placeholder="eg., Staff"
            />
        </div>
        <div class="form-group">
            <label for="company_name">NAME OF COMPANY/SCHOOL:</label>
            <input
                type="text"
                name="company_name"
                id="company_name"
                v-model="userDetails.userWorkExpDetails.company_name"
                class="form-control"
                placeholder="eg., XYZ University"
            />
        </div>
        <div class="form-group">
            <label for="rank">RANK:</label>
            <input
                type="text"
                name="rank"
                id="rank"
                v-model="userDetails.userWorkExpDetails.rank"
                class="form-control"
                placeholder="eg., Staff II"
            />
        </div>
        <div class="form-group">
            <label for="status">STATUS OF APPOINTMENT:</label>
            <input
                type="text"
                name="status"
                id="status"
                v-model="userDetails.userWorkExpDetails.status"
                class="form-control"
                placeholder="eg., Permanent"
            />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">WORK/TEACHING EXPERIENCE</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userDetails: Object,
        editMode: Boolean,
    },
    watch: {
        userDetails: {
            handler(newVal) {
                this.$emit("update-user-details", newVal);
            },
            deep: true,
        },
    },
};
</script>
