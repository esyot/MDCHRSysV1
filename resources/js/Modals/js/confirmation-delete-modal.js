export default {
    emits: ["deleteForm", "toggleDeleteForm"],
    props: {
        isDelete: Boolean,
        selected_id: String,
        selected_type: String,
    },

    methods: {
        deleteForm() {
            this.$emit("deleteForm");
        },
        toggleDeleteForm() {
            this.$emit("toggleDeleteForm");
        },
    },
};
