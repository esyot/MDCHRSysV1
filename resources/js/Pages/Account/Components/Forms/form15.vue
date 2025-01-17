<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">USER VALID IDs FORM</span>
        </div>

        <div class="form-group">
            <label for="id_type">ID TYPE:</label>
            <select id="id_type" name="id_type"
            v-model="selectedId"
            @change="updateSelectedIds"
            class="form-control">
                <option value="">Select Type</option>
                <option value="SSS">SSS</option>
                <option value="PAG-IBIG">PAG-IBIG</option>
                <option value="PHILHEALTH">PHILHEALTH</option>
                <option value="TIN">TIN</option>
                <option value="DRIVER'S LICENSE">DRIVER'S LICENSE</option>
                <option value="PASSPORT">PASSPORT</option>
                <option value="GOVERNMENT ISSUED">GOVERNMENT ISSUED</option>
            </select>
        </div>

        <div v-if="selectedId" class="form-group">
            <label for="id_no">{{ selectedId.toUpperCase() }} NO:</label>
            <input
                type="text"
                v-model="userDetails.userValidId.id_no"
                class="form-control"
                placeholder="Enter ID No."
            />
        </div>
        <div v-if="selectedId" class="form-group">
            <label for="date_issued">{{ selectedId.toUpperCase() }} DATE ISSUED:</label>
            <input
                type="date"
                v-model="userDetails.userValidId.date_issued"
                class="form-control"
            />
        </div>
         <div v-if="selectedId" class="form-group">
            <label for="date_expiry">{{ selectedId.toUpperCase() }} DATE EXPIRY:</label>
            <input
                type="date"
                v-model="userDetails.userValidId.date_expiry"
                class="form-control"
            />
        </div>
    </div>

    <div class="personal-details-items" v-if="!editMode">
        <div class="title-container">
            <span class="title">USER VALID IDs</span>
        </div>
        <ul v-if="userDetails.validIds && Object.keys(userDetails.validIds).length">
            <li v-for="(number, type) in userDetails.validIds" :key="type">
                <strong>{{ type }}:</strong> {{ number }}
            </li>
        </ul>
        <p v-else>No valid IDs provided.</p>
    </div>
</template>

<script>
export default {
    props: {
        userDetails: Object,
        editMode: Boolean,
    },
    data() {
        return {
            selectedId: "",
        };
    },
    methods: {
        updateSelectedIds() {
            if (!this.userDetails.validIds) {
                this.userDetails.validIds = {};
            }
            if (!this.selectedId) return;
            if (!this.userDetails.validIds[this.selectedId]) {
                this.userDetails.validIds[this.selectedId] = "";
            }
        },
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
