import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import { InertiaLink } from "@inertiajs/inertia-vue3";
import AddUserModal from "@/Modals/AddUserModal.vue";
import { useToast } from "vue-toastification";

export default {
    layout: Layout,
    components: {
        AddUserModal,
        InertiaLink,
    },
    props: {
        users: Object,
        allUsers: Object,
        roles: Array,
        departments: Array,
        roleList: Array,
        specializationList: Array,
        positionList: Array,
        type: String,
    },
    data() {
        return {
            search_value: "",
            isAddUser: false,
            isAddTeacher: false,
            isAddStaff: false,
            user_type: this.type,
            combinedData: this.users.data,
            nextPageUrl: this.users.next_page_url,
            loading: false,
        };
    },
    computed: {
        filteredUsers() {
            if (!this.search_value) return this.users.data;

            const searchLower = this.search_value.toLowerCase();

            return this.allUsers.filter(
                (user) =>
                    user.last_name.toLowerCase().includes(searchLower) ||
                    user.first_name.toLowerCase().includes(searchLower) ||
                    (user.middle_name?.toLowerCase().includes(searchLower) ??
                        false),
            );
        },
    },

    methods: {
        visitUser(user) {
            Inertia.visit(`/users/user-list/${user.id}/false`);
        },

        toggleAddUserModal() {
            this.isAddUser = !this.isAddUser;
        },

        toggleSyncUsers(type) {
            const toast = useToast();

            Inertia.visit(`/users/sync/${type}`, {
                onSuccess() {
                    toast.success("Users synced successfully!", {
                        position: "top-center",
                        timeout: 3000,
                        closeButton: true,
                    });
                },
                onError() {
                    toast.error("Failed to sync users. Please try again.", {
                        position: "top-center",
                        timeout: 5000,
                        closeButton: true,
                    });
                },
            });
        },
    },

    watch: {
        user_type(newVal) {
            if (newVal === "user") {
                Inertia.visit("/users/users-list");
            } else if (newVal === "teacher") {
                Inertia.visit("/users/teachers-list");
            } else if (newVal === "staff") {
                Inertia.visit("/users/staffs-list");
            }
        },
    },
};
