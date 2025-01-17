<template>
     <div class="personal-details-items">
        <div class="title-container">
            <span class="title">PARTICIPATION IN COMMUNITY OUTREACH FORM (Last 2 Years) FORM</span>
        </div>
        <div class="form-group">
            <label for="title">NAME & ADDRESS OF ORGANIZATION:</label>
            <input type="text" name="title" id="title"
            v-model="userDetails.userParticipationDetails.title"
            class="form-control" placeholder="eg., Bohol Movements">
        </div>
        <div class="form-group">
            <label for="date_from">INCLUSIVE DATE FROM:</label>
            <input type="date" name="date_from" id="date_to"
            v-model="userDetails.userParticipationDetails.date_from"
            class="form-control" placeholder="eg., 2020-01-01">
        </div>
        <div class="form-group">
            <label for="date_to">INCLUSIVE DATE TO:</label>
            <input type="date" name="date_to" id="date_to"
            v-model="userDetails.userParticipationDetails.date_to"
            class="form-control" placeholder="eg., 2020-12-31">
        </div>
        <div class="form-group">
            <label for="hours_no">NUMBER OF HOURS:</label>
            <input type="number" name="hours_no" id="hours_no"
            v-model="userDetails.userParticipationDetails.hours_no"
            class="form_control" placeholder="eg., 200">
        </div>
        <div class="form-group">
            <label for="position">POSITION/NATURE OF INVOLVEMENT:</label>
            <input type="text" name="position" id="position"
            v-model="userDetails.userParticipationDetails.position"
            class="form-control" placeholder="eg., Volunteer">
        </div>

        <div class="form-group submit-btn">
            <button type="submit" @click="submitForm">Submit</button>
        </div>


    </div>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">PARTICIPATION IN COMMUNITY OUTREACH FORM (Last 2 Years)</span>
        </div>

    </div>
</template>

<script>
export default{
    props:{
        userDetails:Object,
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
