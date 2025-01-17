<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">ACADEMIC AWARDS RECIEVED FORM</span>
        </div>
        <div class="form-group">
            <label for="date_recieved">DATE RECIEVED:</label>
            <input type="date" id="date_recieved" name="date_recieved"
            v-model="userDetails.userAwardDetails.date_recieved"
            class="form-control" placeholder="Enter Date Recieved">
        </div>
        <div class="form-group">
            <label for="title">NATURE/TITLE OF AWARD:</label>
            <input type="text" id="title" name="title"
            v-model="userDetails.userAwardDetails.title"
            class="form-control" placeholder="Enter Title of Award">
        </div>
        <div class="form-group">
            <label for="recognition_place">PLACE OF RECOGNITION:</label>
            <input type="text" id="recognition_place" name="recognition_place"
            v-model="userDetails.userAwardDetails.recognition_place"
            class="form-control" placeholder="Enter Place of Recognition">
        </div>
        <div class="form-group">
            <label for="awarded_by">AWARDED BY:</label>
            <input type="text" id="awarded_by" name="awarded_by"
            v-model="userDetails.userAwardDetails.awarded_by"
            class="form-control" placeholder="Enter Awarded By">
        </div>

        <div class="form-group submit-btn">
            <button type="submit" @click="submitForm">Submit</button>
        </div>
    </div>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">ACADEMIC AWARDS, HONORS, HONORARY DEGREE RECIEVED</span>
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
