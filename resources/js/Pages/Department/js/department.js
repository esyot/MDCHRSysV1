import Layout from "@/Layouts/Layout.vue";
import AddDepartmentModal from "@/Modals/AddDepartmentModal.vue";
import ConfirmationDeleteModal from "@/Modals/ConfirmationDeleteModal.vue";
import { router } from "@inertiajs/vue3";
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

            router.visit(`/departments/sync/`, {
                onSuccess(response) {
                    toast.success(response.props.success, {
                        position: "top-center",
                    });
                },
                onError(errors) {
                    toast.error(errors.error, {
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
