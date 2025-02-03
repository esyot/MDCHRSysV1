<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">REFERENCES FORM</span>
        </div>
        <div class="form-control">
            <span class="italic"
                >(Note: Person not related by consanguinity or affinity to
                applicant/appointee.)</span
            >
        </div>
        <div>
            <button @click="addField">Add Field</button>
        </div>
        <div
            v-for="(userRef, index) in userDetails.user_references"
            :key="index"
            class="form-group"
        >
            <div class="form-group">
                <label for="name">NAME:</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    v-model="userRef.name"
                    class="form-control"
                    placeholder="eg., Reinhard Esteban"
                    @input="handleFieldFocus(`user_references`)"
                />
            </div>
            <div class="form-group">
                <label for="address_id">ADDRESS:</label>
                <input
                    type="text"
                    name="address_id"
                    id="address_id"
                    v-model="userRef.address_id"
                    class="form-control"
                    placeholder="eg., 1234, 5th Street, San Juan, Metro Manila"
                    @input="handleFieldFocus(`user_references`)"
                />
            </div>
            <div class="form-group">
                <label for="contact_no">CONTACT NUMBER:</label>
                <input
                    type="text"
                    name="contact_no"
                    id="contact_no"
                    v-model="userRef.contact_no"
                    class="form-control"
                    placeholder="eg., 0917-123-4567"
                    @input="handleFieldFocus(`user_references`)"
                />
            </div>
            <hr />
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">REFERENCES</span>
        </div>
        <div
            v-for="userRef in personalDetails.user_references"
            :key="userRef.id"
            class="form-group"
        >
            <label> {{ userRef.name }}</label>
            <span>
                {{ userRef.contact_no }} ||
                {{ userRef.address_id }}
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
            this.userDetails.user_references.push({
                name: "",
                address_id: "",
                contact_no: "",
            });
        },
    },
    watch: {
        personalDetails: {
            handler(newVal) {
                this.userDetails.user_references = newVal.user_references || [];
            },
            immediate: true,
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
