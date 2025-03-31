import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
export default {
    emits: ["toggleEditStaff"],
    props: {
        user_id: String,
        staff: Object,
        positionList: Array,
    },
    components: {
        ConfirmationFormModal,
    },

    data() {
        return {
            formData: {
                position: this.staff.position ?? "",
                date_hired: this.staff.date_hired ?? "",
            },
            isConfirmation: false,
            message: "Are you sure to update staff details?",
        };
    },
    methods: {
        closeModal() {
            this.$emit("toggleEditStaff");
        },
        submitForm() {
            this.toggleConfirmForm();
            this.closeModal();

            const toast = useToast();

            router.put(
                `/users/staff/edit-details`,
                {
                    staff_id: this.staff.id,
                    formData: this.formData,
                },
                {
                    onSuccess: (response) => {
                        toast.success(response.props.success, {
                            position: "top-center",
                            duration: 3000,
                        });
                    },

                    onError: (errors) => {
                        toast.error(errors.error, {
                            position: "top-center",
                            duration: 3000,
                        });
                    },
                },
            );
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
    },
};
