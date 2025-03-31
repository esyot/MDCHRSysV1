import { router } from "@inertiajs/vue3";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { useToast } from "vue-toastification";
import axios from "axios";
export default {
    name: "AddUserModal",
    emits: ["toggleAddUserModal"],
    components: {
        ConfirmationFormModal,
    },
    data() {
        return {
            formData: {
                first_name: "",
                last_name: "",
                middle_name: "",
                date_hired: "",
                specialization: "",
                department_id: "",
                position: "",
                roles: [],
            },
            selected_id: "",
            searchValue: "",
            isSearchUser: false,
            staffs: [],
            isConfirmation: false,
            errors: {
                department: false,
                roles: false,
                selected_id: false,
                department_error: "Please select atleast one department.",
                roles_error: "Please select atleast one role.",
                selected_id_error: "Please select a user from the list.",
                specialization_error:
                    "Please select a teacher's specialization from the list.",
            },
        };
    },
    props: {
        departments: Array,
        roleList: Array,
        specializationList: Array,
        positionList: Array,
        type: String,
    },
    methods: {
        closeModal() {
            this.$emit("toggleAddUserModal");
        },
        selectedDepartment(id) {
            if (this.formData.departments.includes(id)) {
                const index = this.formData.departments.indexOf(id);
                this.formData.departments.splice(index, 1);
            } else {
                this.formData.departments.push(id);
            }
        },
        selectedRole(id) {
            if (this.formData.roles.includes(id)) {
                const index = this.formData.roles.indexOf(id);
                this.formData.roles.splice(index, 1);
            } else {
                this.formData.roles.push(id);
            }
        },
        validateForm() {
            if (this.type === "user") {
                this.errors.roles = this.formData.roles.length === 0;
                return !this.errors.roles;
            } else if (this.type === "teacher") {
                this.errors.selected_id =
                    this.selected_id === "" || this.selected_id === null;

                const specializationExists = this.specializationList.some(
                    (specialization) =>
                        specialization === this.formData.specialization,
                );

                this.errors.specialization = !specializationExists;

                const departmentExists = this.departments.some(
                    (department) => department === this.formData.department_id,
                );

                this.errors.department = !departmentExists;

                return (
                    !this.errors.departments &&
                    !this.errors.selected_id &&
                    !this.errors.specialization
                );
            } else if (this.type === "staff") {
                this.errors.selected_id =
                    this.selected_id === "" || this.selected_id === null;
                return !this.errors.selected_id;
            }
        },
        submitForm() {
            if (this.validateForm()) {
                this.toggleConfirmForm();
                this.closeModal();

                const toast = useToast();

                router.post(
                    `/users/${this.type}/add`,
                    {
                        formData: this.formData,
                        selected_id: this.selected_id,
                        type: this.type,
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
            }
        },
        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        searchUser(value) {
            if (!value) return (this.isSearchUser = false);

            this.isSearchUser = true;
            axios
                .get("/users/search/", {
                    params: { search_value: value },
                    headers: { "Content-Type": "application/json" },
                })
                .then(({ data }) => {
                    this.staffs = Array.isArray(data) ? data : [];
                    if (!data.length) this.selected_id = "";
                })
                .catch(() => {
                    console.error("Error fetching users");
                    this.staffs = [];
                });
        },
        selectUser(id, name) {
            this.selected_id = id;
            this.searchValue = name;
            this.isSearchUser = false;
        },
        removeSelectedUser() {
            this.selected_id = "";
            this.searchValue = "";
        },
    },
};
