<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title"
                >CURRICULAR AND SCHOOL COMMITTEE ASSIGNMENTS</span
            >
        </div>
        <div class="form-control">
            <span class="italic">(Last 2 years.)</span>
        </div>
        <div class="form-group">
            <label for="designation">DESIGNATION:</label>
            <input
                type="text"
                id="designation"
                name="designation"
                v-model="userDetails.userCurAssignDetails.designation"
                class="form-control"
                placeholder="e.g., Organizer, Coordinator, Director, Moderator, Coach, Cultural Presentor, Chairman, Adviser"
            />
        </div>
        <div class="form-group">
            <label for="event_name">NAME OF EVENTS:</label>
            <input
                type="text"
                id="event_name"
                name="event_name"
                v-model="userDetails.userCurAssignDetails.event_name"
                class="form-control"
                placeholder="Enter Event Name"
            />
        </div>
        <div class="form-group">
            <label for="title">NATURE/TITLE OF ASSIGNMENTS:</label>
            <input
                type="text"
                name="title"
                id="title"
                v-model="userDetails.userCurAssignDetails.title"
                class="form-control"
                placeholder="Enter Title"
            />
        </div>
        <div class="form-group">
            <label for="date">INCLUSIVE DATES:</label>
            <input
                type="date"
                name="date"
                id="date"
                v-model="userDetails.userCurAssignDetails.date"
                class="form-control"
            />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title"
                >CURRICULAR AND SCHOOL COMMITTEE ASSIGNMENTS</span
            >
        </div>
    </div>
</template>

<script>
export default {
    emits: ["update-user-details"],
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

<style scoped>
.italic {
    font-style: italic;
    font-size: 12px;
    margin-left: 20px;
}
</style>
