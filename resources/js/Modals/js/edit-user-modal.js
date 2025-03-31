import { useToast } from "vue-toastification";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { router } from "@inertiajs/vue3";
export default {
    emits: ["toggleEditUser"],
    props: {
        roleList: Array,
        userRoles: Array,
        userId: String,
        personalDetails: Object,
    },
    components: {
        ConfirmationFormModal,
    },

    data() {
        return {
            formData: {
                user: this.personalDetails.user,
                password: "",
                roles: [],
                is_active: this.personalDetails.is_active === 1 ? true : false,
            },
            message: "Are you sure to update User Details?",
            isConfirmation: false,
        };
    },
    methods: {
        selectedRole(id, input) {
            if (this.formData.roles.includes(id)) {
                const index = this.formData.roles.indexOf(id);
                if (index !== -1) {
                    this.formData.roles.splice(index, 1);
                }
            } else if (!this.userRoles.includes(id) && input.checked) {
                this.formData.roles.push(id);
            }
        },

        closeModal() {
            this.$emit("toggleEditUser");
        },
        submitForm() {
            this.toggleConfirmForm();
            this.closeModal();

            const toast = useToast();

            router.put(
                `/users/user/edit-details`,
                {
                    formData: this.formData,
                    userId: this.userId,
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
        viewPassword() {
            const icon = document.getElementById("icon-eye");
            const input = document.getElementById("password");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        },

        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
    },

    mounted() {
        const currentRoles = this.roleList.filter((role) =>
            this.userRoles.includes(role.name),
        );
        this.formData.roles = currentRoles.map((role) => role.id);
    },
};
