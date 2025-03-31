import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
export default {
    emits: ["toggleEditDepartment"],
    props: {
        departmentList: Array,
        userDepartment: Object,
        user_id: String,
    },
    components: {
        ConfirmationFormModal,
    },

    data() {
        return {
            department_id: "",
            isConfirmation: false,
            message: "Confirm to update user's department?",
        };
    },
    methods: {
        closeModal() {
            this.$emit("toggleEditDepartment");
        },
        submitForm() {
            this.toggleConfirmForm();
            this.closeModal();

            router.patch(`/users/user-department-update`, {
                user_id: this.user_id,
                department_id: this.department_id,
            });
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
    },
};
