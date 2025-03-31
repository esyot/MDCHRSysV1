import { router } from "@inertiajs/vue3";
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
export default {
    emits: ["toggleNewItem"],
    components: {
        ConfirmationFormModal,
    },
    props: {
        categories: Object,
    },
    methods: {
        saveToLocalStorage() {
            localStorage.setItem("templateItemData", JSON.stringify(this.item));
        },

        removeFromLocalStorage() {
            localStorage.removeItem("templateItemData");
        },
        closeModal() {
            this.$emit("toggleNewItem");
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        submitForm() {
            router.post("/evaluations/template/add-item", {
                item: this.item,
            });
            this.removeFromLocalStorage();
            this.toggleConfirmForm();
            this.closeModal();
        },
        cancelForm() {
            this.removeFromLocalStorage();
            this.closeModal();
        },
    },

    created() {
        const item = localStorage.getItem("templateItemData");

        if (item) {
            this.item = JSON.parse(item);
        }
    },
    data() {
        return {
            message: "Are you sure to insert this item?",
            isConfirmation: false,
            item: {
                category_id: "",
                description: "",
            },
        };
    },
};
