import Layout from "@/Layouts/Layout.vue";
import AddCategoryModal from "./Modals/AddCategoryModal.vue";
import AddItemModal from "../Modals/AddItemModal.vue";
import EditItemModal from "../Modals/EditItemModal.vue";
import ConfirmationFormModal from "./Modals/ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";

export default {
    layout: Layout,
    components: {
        AddCategoryModal,
        AddItemModal,
        EditItemModal,
        ConfirmationFormModal,
    },
    props: {
        template: Object,
        categories: Object,
    },
    data() {
        return {
            isNewCategoryModal: false,
            isNewItemModal: false,
            template_id: this.template.id,
            selectediItem: [],
            isEditItem: false,
            isConfirmation: false,
            message: "Are you sure to remove this item?",
        };
    },
    methods: {
        toggleNewCategory() {
            this.isNewCategoryModal = !this.isNewCategoryModal;
        },
        toggleNewItem() {
            this.isNewItemModal = !this.isNewItemModal;
        },
        toggleIsEditItem(item) {
            this.isEditItem = !this.isEditItem;
            this.selectediItem = item;
        },

        toggleConfirmForm(item) {
            this.isConfirmation = !this.isConfirmation;
            item === this.selectediItem
                ? (this.selectediItem = null)
                : (this.selectediItem = item);
        },

        submitForm() {
            router.delete(
                `/evaluations/template/delete-item/${this.selectediItem.id}`,
            );
            this.toggleConfirmForm();
        },
    },
};
