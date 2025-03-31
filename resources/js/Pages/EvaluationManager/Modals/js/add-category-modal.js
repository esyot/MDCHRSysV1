import { router } from "@inertiajs/vue3";
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
export default {
    emits: ["toggleNewCategory"],
    components: {
        ConfirmationFormModal,
    },
    props: {
        template_id: Number,
    },

    data() {
        return {
            isConfirmation: false,
            category: {
                template_id: "",
                title: "",
            },
            message: "Are you sure to insert this category?",
        };
    },
    methods: {
        closeModal() {
            this.$emit("toggleNewCategory");
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        submitForm() {
            router.post("/evaluations/template/add-category", {
                category: this.category,
            });
            this.toggleConfirmForm();
            this.closeModal();
            this.removeFromLocalStorage();
        },
        saveToLocalStorage() {
            localStorage.setItem(
                "templateCategoryData",
                JSON.stringify(this.category),
            );
        },
        removeFromLocalStorage() {
            localStorage.removeItem("templateCategoryData");
        },
        cancelForm() {
            this.removeFromLocalStorage();
            this.closeModal();
        },
    },

    created() {
        const category = localStorage.getItem("templateCategoryData");
        if (category) {
            this.category = JSON.parse(category);
        }

        this.category.template_id = this.template_id;
    },
};
