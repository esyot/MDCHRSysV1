import Layout from "@/Layouts/Layout.vue";
import { router, WhenVisible } from "@inertiajs/vue3";
import Modal from "@/Pages/Forms/Tracking/TrackingModal.vue";
import DeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
import { useToast } from "vue-toastification";
import Loader from "@/Components/FormLoader.vue";

export default {
    layout: Layout,
    components: {
        Modal,
        DeleteModal,
        WhenVisible,
        Loader,
    },
    props: {
        forms: {
            type: Object,
        },
    },
    data() {
        return {
            selected_id: "",
            selected_type: "",
            selected_id_to_delete: "",
            selected_type_to_delete: "",
            isConfirmation: false,
            isDelete: false,
            statusMap: {
                pending: { text: "Pending", icon: "loading", color: "" },
                approved: {
                    text: "Approved",
                    icon: "fa-circle-check",
                    color: "green",
                },
                dean_approved: {
                    text: "Approved by Dean",
                    icon: "fa-circle-check",
                    color: "green",
                },
                hr_approved: {
                    text: "Approved by HR",
                    icon: "fa-circle-check",
                    color: "green",
                },
                vp_admin_approved: {
                    text: "Approved by VP_Admin",
                    icon: "fa-circle-check",
                    color: "green",
                },
                vp_acad_approved: {
                    text: "Approved by VP_Acad",
                    icon: "fa-circle-check",
                    color: "green",
                },
                declined: {
                    text: "Declined",
                    icon: "fa-circle-xmark",
                    color: "red",
                },
            },
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

        toggleFormModal(id, type) {
            this.selected_id = this.selected_id === id ? null : String(id);
            this.selected_type =
                this.selected_type === type ? null : String(type);
        },

        toggleDeleteForm(id, type) {
            this.isDelete = !this.isDelete;

            this.selected_id_to_delete =
                this.selected_id_to_delete === id ? null : String(id);
            this.selected_type_to_delete =
                this.selected_type_to_delete === type ? null : String(type);
        },

        deleteForm() {
            const toast = useToast();
            router.delete(
                `/form/delete/${this.selected_type_to_delete}/${this.selected_id_to_delete}`,
                {
                    onSuccess: () => {
                        toast.success("Form deleted successfully", {
                            position: "top-center",
                        });

                        this.toggleDeleteForm(
                            this.selected_id_to_delete,
                            this.selected_type_to_delete,
                        );
                    },
                },
            );
        },

        redirectToEditForm(id, type) {
            router.visit(`/forms/edit-mode/${id}/${type}`);
        },
    },
};
