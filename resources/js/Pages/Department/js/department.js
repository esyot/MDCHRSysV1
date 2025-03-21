import Layout from "@/Layouts/Layout.vue";
import AddDepartmentModal from "@/Modals/AddDepartmentModal.vue";
import ConfirmationDeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "vue-toastification";

export default {
    layout: Layout,
    components: {
        AddDepartmentModal,
        ConfirmationDeleteModal,
    },
    props: {
        departments: Array,
        parentDepartments: Array,
        departmentList: Object,
    },
    data() {
        return {
            isAddDepartment: false,
            isDelete: false,
            selected_id: "",
        };
    },
    methods: {
        toggleSyncDepartments() {
            const toast = useToast();

            Inertia.visit(`/departments/sync/`, {
                onSuccess() {
                    toast.success("Users synced successfully!", {
                        position: "top-center",
                    });
                },
                onError() {
                    toast.error("Failed to sync users. Please try again.", {
                        position: "top-center",
                    });
                },
            });
        },
        toggleAddDepartmentModal() {
            this.isAddDepartment = !this.isAddDepartment;
        },

        selectId(id) {
            this.selected_id === id
                ? (this.selected_id = null)
                : (this.selected_id = id);

            this.toggleDeleteForm();
        },
        toggleDeleteForm() {
            this.isDelete = !this.isDelete;
        },
    },
};
