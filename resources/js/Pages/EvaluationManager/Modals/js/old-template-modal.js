import { router } from "@inertiajs/vue3";
import ConfirmationFormModal from "../ConfirmationFormModal.vue";
export default {
    emits: ["toggleOldTemplate"],
    components: {
        ConfirmationFormModal,
    },
    methods: {
        closeModal() {
            this.$emit("toggleOldTemplate");
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        submitForm() {
            router.post("/evalutions/copy-old-template/", this.formData);
            this.toggleConfirmForm();
            this.closeModal();
            this.removeFromLocalStorage();
        },

        saveToLocalStorage() {
            localStorage.setItem(
                "oldTemplateData",
                JSON.stringify(this.formData),
            );
        },

        removeFromLocalStorage() {
            localStorage.removeItem("oldTemplateData");
            this.closeModal();
        },
    },

    created() {
        const oldTemplateData = localStorage.getItem("oldTemplateData");

        if (oldTemplateData) {
            this.formData = JSON.parse(oldTemplateData);
        }
    },
    props: {
        templates: Object,
    },
    data() {
        return {
            formData: {
                template_id: "",
                name: "",
                for: "",
            },
            isConfirmation: false,
            message: "Submit this as a new evaluation template?",
        };
    },
};
