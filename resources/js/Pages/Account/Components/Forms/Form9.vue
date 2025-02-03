<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title"
                >PARTICIPATION IN COMMUNITY OUTREACH FORM (Last 2 Years)
                FORM</span
            >
        </div>
        <div>
            <button @click="addField">Add Field</button>
        </div>
        <div
            v-for="(userPart, index) in userDetails.user_participations"
            :key="index"
            class="form-group"
        >
            <div class="form-group">
                <label for="title">NAME & ADDRESS OF ORGANIZATION:</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    v-model="userPart.title"
                    class="form-control"
                    placeholder="eg., Bohol Movements"
                    @input="handleFieldFocus(`user_participations`)"
                />
            </div>
            <div class="form-group">
                <label for="date_from">INCLUSIVE DATE FROM:</label>
                <input
                    type="date"
                    name="date_from"
                    id="date_to"
                    v-model="userPart.date_from"
                    class="form-control"
                    placeholder="eg., 2020-01-01"
                    @input="handleFieldFocus(`user_participations`)"
                />
            </div>
            <div class="form-group">
                <label for="date_to">INCLUSIVE DATE TO:</label>
                <input
                    type="date"
                    name="date_to"
                    id="date_to"
                    v-model="userPart.date_to"
                    class="form-control"
                    placeholder="eg., 2020-12-31"
                    @input="handleFieldFocus(`user_participations`)"
                />
            </div>
            <div class="form-group">
                <label for="hours_no">NUMBER OF HOURS:</label>
                <input
                    type="number"
                    name="hours_no"
                    id="hours_no"
                    v-model="userPart.hours_no"
                    class="form_control"
                    placeholder="eg., 200"
                    @input="handleFieldFocus(`user_participations`)"
                />
            </div>
            <div class="form-group">
                <label for="position">POSITION/NATURE OF INVOLVEMENT:</label>
                <input
                    type="text"
                    name="position"
                    id="position"
                    v-model="userPart.position"
                    class="form-control"
                    placeholder="eg., Volunteer"
                    @input="handleFieldFocus(`user_participations`)"
                />
            </div>
            <hr />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title"
                >PARTICIPATION IN COMMUNITY OUTREACH FORM (Last 2 Years)</span
            >
        </div>
        <div
            v-for="userParticipation in personalDetails.user_participations"
            :key="userParticipation.id"
            class="form-group"
        >
            <label> {{ userParticipation.title }}</label>
            <span>
                {{ userParticipation.date_from }} ||
                {{ userParticipation.date_to }} ||
                {{ userParticipation.hours_no }} ||
                {{ userParticipation.position }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["update-user-details"],
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
            this.userDetails.user_participations.push({
                title: "",
                date_from: "",
                date_to: "",
                hours_no: "",
                position: "",
            });
        },
    },
    watch: {
        personalDetails: {
            handler(newVal) {
                this.userDetails.user_participations =
                    newVal.user_participations || [];
            },
            immediate: true,
        },
    },
};
</script>
