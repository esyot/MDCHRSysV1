<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">ADMINISTRATIVE POSITIONS HELD FORM</span>
        </div>
        <div class="form-group">
            <label for="date">INCLUSIVE DATES: </label>
            <input type="date" id="date" name="date"
            v-model="userDetails.userAdministrativeAwardDetails.date"
            class="form-control"/>
        </div>
        <div class="form-group">
            <label for="title">NATURE/TITLE OF AWARD:</label>
            <input type="text" name="title" id="title"
             v-model="userDetails.userAdministrativeAwardDetails.title"
            class="form-control" placeholder="Enter Title of Award">
        </div>
        <div class="form-group">
            <label for="recognition_place">PLACE OF RECOGNITION:</label>
            <input type="text" name="recognition_place" id="recognition_place"
             v-model="userDetails.userAdministrativeAwardDetails.recognition_place"
            class="form-control" placeholder="Enter Place of Recognition">
        </div>
        <div class="form-group">
            <label for="awarded_by">AWARDED BY:</label>
            <input type="text" name="awarded_by" id="awarded_by"
             v-model="userDetails.userAdministrativeAwardDetails.awarded_by"
            class="form-control" placeholder="Enter Awarded By">
        </div>
        <div class="form-group submit-btn">
            <button type="submit" @click="submitForm">Submit</button>
        </div>

    </div>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">ADMINISTRATIVE POSITIONS HELD</span>
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
