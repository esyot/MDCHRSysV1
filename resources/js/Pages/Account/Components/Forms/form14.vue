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
        <div class="form-group">
            <label for="name">NAME:</label>
            <input
                type="text"
                name="name"
                id="name"
                v-model="userDetails.userRefDetails.name"
                class="form-control"
                placeholder="eg., Reinhard Esteban"
            />
        </div>
        <div class="form-group">
            <label for="address_id">ADDRESS:</label>
            <input
                type="text"
                name="address_id"
                id="address_id"
                v-model="userDetails.userRefDetails.address_id"
                class="form-control"
                placeholder="eg., 1234, 5th Street, San Juan, Metro Manila"
            />
        </div>
        <div class="form-group">
            <label for="contact_no">CONTACT NUMBER:</label>
            <input
                type="text"
                name="contact_no"
                id="contact_no"
                v-model="userDetails.userRefDetails.contact_no"
                class="form-control"
                placeholder="eg., 0917-123-4567"
            />
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">REFERENCES</span>
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
