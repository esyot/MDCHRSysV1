<template>
    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title"
                >RESEARCH STUDIES, RESEARCH PROJECTS AND BOOK PUBLISHED
                FORM</span
            >
        </div>
        <div class="form-group">
            <label for="date_published">DATE PUBLISHED:</label>
            <input
                type="date"
                name="date_published"
                id="date_published"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="research_title">RESEARCH TITLE:</label>
            <input
                type="text"
                name="research_title"
                id="research_title"
                class="form-control"
                placeholder="eg., Research"
            />
        </div>
        <div class="form-group">
            <label for="journal_name">NAME OR JOURNAL:</label>
            <input
                type="text"
                name="journal_name"
                id="journal_name"
                class="form-control"
                placeholder="eg., Journal Name"
            />
        </div>
        <div class="form-group">
            <label for="link">LINK OF JOURNAL/VOLUME NUMBER:</label>
            <input
                type="text"
                name="link"
                id="link"
                class="form-control"
                placeholder="eg., https://example.com"
            />
        </div>
    </div>
    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title"
                >RESEARCH STUDIES, RESEARCH PROJECTS AND BOOK PUBLISHED</span
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
