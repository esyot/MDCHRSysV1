<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">SPECIAL TRAINING COURSES, SEMINARS, SYMPOSIA PARTICIPATED (Last 5 Years) FORM</span>
        </div>
        <div class="form-control">
            <span class="italic">(Note: Start from the most recent training and include only the relevant training or program.)</span>
        </div>
        <div class="form-group">
            <label for="title">TITLE OF TRAINING/SEMINARS/CONFERENCES ATTENDED (Write in Full):</label>
            <input type="text" id="title" name="title"
            v-model="userDetails.userSpecialTrainingDetails.title"
            class="form-control" placeholder="Title of the Training Course, Seminar, Symposium, etc.">
        </div>
        <div class="form-group">
            <label for="attendance_from">INCLUSIVE DATE FROM:</label>
            <input type="date" id="attendance_from" name="attendance_from"
            v-model="userDetails.userSpecialTrainingDetails.attendance_from"
            class="form-control">
        </div>
        <div class="form-group">
            <label for="attendance_to">INCLUSIVE DATE TO:</label>
            <input type="date" id="attendance_to" name="attendance_to"
            v-model="userDetails.userSpecialTrainingDetails.attendance_to"
            class="form-control">
        </div>
        <div class="form-group">
            <label for="days">NUMBER OF DAYS:</label>
            <input type="number" name="days" id="days"
            v-model="userDetails.userSpecialTrainingDetails.days"
            class="form-control" placeholder="eg., 30">
        </div>
        <div class="form-group">
            <label for="type">TYPE OF TRAINING:</label>
            <input type="text" name="type" id="type"
            v-model="userDetails.userSpecialTrainingDetails.type"
            class="form-control" placeholder="eg., Managerial/Supervisor/Technical, etc.">
        </div>
        <div class="form-group">
            <label for="conducted_by">CONDUCTED/SPONSORED BY (Write in Full):</label>
            <input type="text" name="conducted_by" id="conducted_by"
            v-model="userDetails.userSpecialTrainingDetails.conducted_by"
            class="form-control" placeholder="eg., Mr/Mrs. Example ">
        </div>


        <div class="form-group submit-btn">
            <button type="submit" @click="submitForm">Submit</button>
        </div>

    </div>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">SPECIAL TRAINING COURSES, SEMINARS, SYMPOSIA PARTICIPATED (Last 5 Years)</span>
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

<style scoped>
.italic{
    font-style: italic;
    font-size: 12px;
    margin-left: 20px;
}
</style>
