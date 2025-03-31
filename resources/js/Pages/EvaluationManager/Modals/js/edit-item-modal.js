import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
export default {
    emits: ["toggleIsEditItem"],
    components: {
        ConfirmationFormModal,
    },
    data() {
        return {
            formData: {
                item_id: this.selectediItem.id,
                description: this.selectediItem.description,
            },
            isConfirmation: false,
            message: "Are you sure to update description?",
        };
    },
    props: {
        selectediItem: Object,
    },
    methods: {
        closeModal() {
            this.$emit("toggleIsEditItem");
        },
        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },

        submitForm() {
            const formData = this.formData;
            router.put("/evaluations/template/update-item", formData);
            this.toggleConfirmForm();
            this.closeModal();
        },
    },
};
