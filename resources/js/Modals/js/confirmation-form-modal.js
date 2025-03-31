export default {
    name: "ConfirmationFormModal",
    emits: ["submitForm", "toggleConfirmForm"],
    props: {
        isConfirmation: Boolean,
        message: String,
    },
    methods: {
        submitForm() {
            this.$emit("submitForm");
        },

        toggleConfirmForm() {
            this.$emit("toggleConfirmForm");
        },
    },
};
