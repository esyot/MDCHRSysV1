import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
export default {
    emits: ["toggleAddDepartmentModal"],
    components: {
        ConfirmationFormModal,
    },
    props: {
        parentDepartments: Array,
        isAddDepartment: Boolean,
        departmentList: Object,
    },
    methods: {
        closeModal() {
            this.$emit("toggleAddDepartmentModal");
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        submitForm() {
            this.toggleConfirmForm();
            this.closeModal();
            router.post("/departments/department-add", this.formData);
        },
    },
    data() {
        return {
            formData: {
                name: "",
                acronym: "",
                parent_id: "",
            },
            isConfirmation: false,
        };
    },
};
