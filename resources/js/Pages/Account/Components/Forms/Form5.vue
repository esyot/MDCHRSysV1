<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">ACADEMIC AWARDS RECIEVED FORM</span>
        </div>
        <div class="add-field-btn">
            <button @click="addField">Add Field</button>
        </div>
        <div
            v-for="(userAward, index) in userDetails.user_award_receives"
            :key="index"
            class="form-group"
        >
            <div class="form-group">
                <label for="date_recieved">DATE RECEIVED:</label>
                <input
                    type="date"
                    id="date_recieved"
                    name="date_recieved"
                    v-model="userAward.date_received"
                    class="form-control"
                    placeholder="Enter Date Recieved"
                    @input="handleFieldFocus(`user_award_receives`)"
                />
            </div>
            <div class="form-group">
                <label for="title">NATURE/TITLE OF AWARD:</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    v-model="userAward.title"
                    class="form-control"
                    placeholder="Enter Title of Award"
                    @input="handleFieldFocus(`user_award_receives`)"
                />
            </div>
            <div class="form-group">
                <label for="recognition_place">PLACE OF RECOGNITION:</label>
                <input
                    type="text"
                    id="recognition_place"
                    name="recognition_place"
                    v-model="userAward.recognition_place"
                    class="form-control"
                    placeholder="Enter Place of Recognition"
                    @input="handleFieldFocus(`user_award_receives`)"
                />
            </div>
            <div class="form-group">
                <label for="awarded_by">AWARDED BY:</label>
                <input
                    type="text"
                    id="awarded_by"
                    name="awarded_by"
                    v-model="userAward.awarded_by"
                    class="form-control"
                    placeholder="Enter Awarded By"
                    @input="handleFieldFocus(`user_award_receives`)"
                />
            </div>
            <button
                v-if="
                    userAward.date_received == '' &&
                    userAward.title == '' &&
                    userAward.recognition_place == '' &&
                    userAward.awarded_by == ''
                "
                @click="removeField(index)"
                class="remove-btn"
            >
                Remove
            </button>
            <hr />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title"
                >ACADEMIC AWARDS, HONORS, HONORARY DEGREE RECIEVED</span
            >
        </div>
        <div
            v-for="userAward in personalDetails.user_award_receives"
            :key="userAward.id"
            class="form-group"
        >
            <label>{{ userAward.title }}</label>
            <span>
                {{ userAward.date_received }} ||
                {{ userAward.recognition_place }} ||
                {{ userAward.awarded_by }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["track-touched-field", "update-user-details"],
    props: {
        userDetails: Object,
        editMode: Boolean,
        personalDetails: Object,
    },
    methods: {
        handleFieldFocus(fieldName) {
            this.$emit("track-touched-field", fieldName);
        },

        handleFieldChange(fieldName) {
            this.$emit("update-user-details", {
                [fieldName]: this.userDetails[fieldName],
            });
        },
        addField() {
            this.userDetails.user_award_receives.push({
                date_received: "",
                title: "",
                recognition_place: "",
                awarded_by: "",
            });
        },
        removeField(index) {
            this.userDetails.user_award_receives.splice(index, 1);
        },
    },

    watch: {
        personalDetails: {
            handler(newVal) {
                this.userDetails.user_award_receives =
                    newVal.user_award_receives || [];
            },
            immediate: true,
        },
    },
};
</script>

<style scoped>
.remove-btn {
    margin-top: 10px;
    color: red;
    background: none;
    border: 1px solid red;
    cursor: pointer;
    padding: 5px 10px;
}

.remove-btn:hover {
    background-color: red;
    color: white;
}

.form-group {
    margin-bottom: 10px;
}

.add-field-btn {
    margin-bottom: 20px;
}

.title-container .title {
    font-weight: bold;
    font-size: 18px;
}

input.form-control {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
}
</style>
