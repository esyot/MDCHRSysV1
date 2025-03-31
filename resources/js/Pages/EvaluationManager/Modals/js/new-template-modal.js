import ConfirmationFormModal from "../ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
export default {
    emits: ["toggleNewTemplate"],
    components: {
        ConfirmationFormModal,
    },

    methods: {
        closeModal() {
            this.$emit("toggleNewTemplate");
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        submitForm() {
            const toast = useToast();

            router.post("/evaluations/add-new-template", this.formData, {
                onSuccess: () => {
                    toast.success("New template added successfully", {
                        position: "top-center",
                        duration: 3000,
                    });
                    this.removeFromLocalStorage();
                    this.closeModal();
                },
                onError: (errors) => {
                    toast.error("An error occurred. Please try again.", {
                        position: "top-center",
                        duration: 3000,
                    });
                },
            });
        },
        saveToLocalStorage() {
            localStorage.setItem(
                "newTemplateData",
                JSON.stringify(this.formData),
            );
        },
        removeFromLocalStorage() {
            localStorage.removeItem("newTemplateData");
        },
        cancelForm() {
            this.removeFromLocalStorage();
            this.closeModal();
        },
    },
    created() {
        const newTemplateData = localStorage.getItem("newTemplateData");
        if (newTemplateData) {
            this.formData = JSON.parse(newTemplateData);
        }
    },
    data() {
        return {
            formData: {
                name: "",
                for: "",
                type: "",
            },
            isConfirmation: false,
            message: "Are you sure you want to submit?",
        };
    },
};
