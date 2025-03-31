import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

export default {
    emits: ["toggleEditTeacher"],
    props: {
        departmentList: Array,
        user_id: String,
        specializationList: Array,
        teacher: Object,
    },
    components: {
        ConfirmationFormModal,
    },

    data() {
        return {
            formData: {
                specialization: this.teacher.specialization ?? "",
                date_hired: this.teacher.date_hired ?? "",
                department_id: this.teacher.department_id ?? "",
            },
            isConfirmation: false,
            message: "Are sure to update teacher's details?",
        };
    },
    methods: {
        closeModal() {
            this.$emit("toggleEditTeacher");
        },
        submitForm() {
            this.toggleConfirmForm();
            this.closeModal();

            const toast = useToast();

            router.put(
                `/users/teacher/edit-details`,
                {
                    formData: this.formData,
                    teacher_id: this.teacher.id,
                },
                {
                    onSuccess: (response) => {
                        toast.success(response.props.success, {
                            position: "top-center",
                            duration: 3000,
                        });
                    },
                    onError: (errors) => {
                        toast.error(errors.message, {
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
