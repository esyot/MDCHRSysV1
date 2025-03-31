import Layout from "@/Layouts/Layout.vue";
import NewTemplateModal from "../Modals/NewTemplateModal.vue";
import OldTemplateModal from "../Modals/OldTemplateModal.vue";
import { router } from "@inertiajs/vue3";
import ConfirmationDeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
import { useToast } from "vue-toastification";

export default {
    layout: Layout,
    components: {
        NewTemplateModal,
        OldTemplateModal,
        ConfirmationDeleteModal,
    },
    props: {
        templates: Object,
    },
    data() {
        return {
            isNewTempModal: false,
            isOldTempModal: false,
            isDelete: false,
            selected_id: null,
        };
    },
    methods: {
        formatDate(date) {
            const convertedDate = new Date(date);
            const options = {
                month: "short",
                day: "numeric",
                year: "numeric",
                hour: "numeric",
                minute: "numeric",
                hour12: true,
            };
            return convertedDate.toLocaleString("en-US", options);
        },
        toggleNewTemplate() {
            this.isNewTempModal = !this.isNewTempModal;
        },
        toggleOldTemplate() {
            this.isOldTempModal = !this.isOldTempModal;
        },
        viewEvaluationTemplate(id) {
            router.visit(`/evaluations/evaluation-manager/${id}`);
        },
        toggleDeleteForm(id) {
            this.selected_id =
                this.selected_id === id
                    ? (this.selected_id = "")
                    : (this.selected_id = id + "");
            this.isDelete = !this.isDelete;
        },
        deleteForm(id) {
            const toast = useToast();

            router.delete(`/evaluations/template-delete/${this.selected_id}`, {
                onSuccess: () => {
                    toast.success("Template deleted successfully", {
                        position: "top-center",
                        duration: 3000,
                    });

                    this.toggleDeleteForm();
                },

                onError: (errors) => {
                    toast.error("An error occurred. Please try again.", {
                        position: "top-center",
                        duration: 3000,
                    });

                    this.toggleDeleteForm();
                },
            });
        },
        switchToggle(id, type) {
            const toast = useToast();

            router.visit(`/evaluations/template-toggle/${id}/${type}`, {
                onSuccess: () => {
                    toast.success("Evaluation form updated successfully!", {
                        position: "top-center",
                        duration: 1000,
                    });
                },

                onError: (errors) => {
                    toast.error("An error occurred. Please try again.", {
                        position: "top-center",
                        duration: 1000,
                    });
                },
            });
        },
    },
};
