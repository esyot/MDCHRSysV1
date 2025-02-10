<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">PROFESSIONAL EXAMINATION FORM</span>
        </div>
        <div class="add-field-btn">
            <button @click="addField">Add Field</button>
        </div>
        <div
            v-for="(
                userProf, index
            ) in userDetails.user_professional_examinations"
            :key="index"
            class="form-group"
        >
            <div class="form-group">
                <label for="title">PROFESSIONAL/BOARD EXAMINATION:</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="form-control"
                    v-model="userProf.title"
                    placeholder="e.g., Civil Engineer Licensure Exam"
                    @input="handleFieldFocus(`user_professional_examinations`)"
                />
            </div>
            <div class="form-group">
                <label for="rating">RATING (If Applicable):</label>
                <input
                    type="text"
                    name="rating"
                    id="rating"
                    class="form-control"
                    v-model="userProf.rating"
                    placeholder="e.g., 85.00% or 85.00/100.00"
                    @input="handleFieldFocus(`user_professional_examinations`)"
                />
            </div>
            <div class="form-group">
                <label for="date">DATE PASSED:</label>
                <input
                    type="date"
                    name="date"
                    id="date"
                    class="form-control"
                    v-model="userProf.date"
                    @input="handleFieldFocus(`user_professional_examinations`)"
                />
            </div>
            <div class="form-group">
                <label for="place">PLACE OF EXAMINATION/CONFERMENT:</label>
                <input
                    type="text"
                    name="place"
                    id="place"
                    class="form-control"
                    v-model="userProf.place"
                    placeholder="e.g., Professional Regulation Commission (PRC), Manila"
                    @input="handleFieldFocus(`user_professional_examinations`)"
                />
            </div>
            <div class="form-group">
                <label for="license_no">LICENSE NO.(If Applicable):</label>
                <input
                    type="text"
                    name="license_no"
                    id="license_no"
                    class="form-control"
                    v-model="userProf.license_no"
                    placeholder="e.g., 123456"
                    @input="handleFieldFocus(`user_professional_examinations`)"
                />
            </div>
            <div class="form-group">
                <label for="validity">VALIDITY (If Applicable):</label>
                <input
                    type="text"
                    name="validity"
                    id="validity"
                    class="form-control"
                    v-model="userProf.validity"
                    placeholder="e.g., 2022-2025"
                    @input="handleFieldFocus(`user_professional_examinations`)"
                />
            </div>
            <button
                v-if="
                    userProf.title == '' &&
                    userProf.rating == '' &&
                    userProf.date == '' &&
                    userProf.place == '' &&
                    userProf.license_no == '' &&
                    userProf.validity == ''
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
                >PROFESSIONAL GOVERNMENT PASSED/CIVIL SERVICE ELIGIBILITY</span
            >
        </div>
        <div
            v-for="userProf in personalDetails.user_professional_examinations"
            :key="userProf.id"
            class="form-group"
        >
            <label>{{ userProf.title }}</label>
            <span>
                {{ userProf.rating }} || {{ userProf.date }} ||
                {{ userProf.place }} || {{ userProf.license_no }} ||
                {{ userProf.validity }}
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
            this.userDetails.user_professional_examinations.push({
                title: "",
                rating: "",
                date: "",
                place: "",
                license_no: "",
                validity: "",
            });
        },
        removeField(index) {
            this.userDetails.user_professional_examinations.splice(index, 1);
        },
    },
    watch: {
        personalDetails: {
            handler(newVal) {
                this.userDetails.user_professional_examinations =
                    newVal.user_professional_examinations || [];
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
