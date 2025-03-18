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
        search_value: String,
        roles: Array,
        departments: Array,
        roleList: Array,
        specializationList: Array,
        positionList: Array,
        type: String,
    },
    data() {
        return {
            search_bar: this.search_value,
            isAddUser: false,
            isAddTeacher: false,
            isAddStaff: false,
            user_type: this.type,
            combinedData: this.users.data,
            nextPageUrl: this.users.next_page_url,
            loading: false,
        };
    },

    methods: {
        searchUser(search_bar) {
            Inertia.get("/users/users-list", {
                search_value: search_bar,
            });
        },
        visitUser(user) {
            Inertia.visit(`/users/user-list/${user.id}/false`);
        },

        toggleAddUserModal() {
            this.isAddUser = !this.isAddUser;
        },

        toggleSyncUsers(type) {
            const toast = useToast();

            type = type.charAt(0).toUpperCase() + type.slice(1) + "s";

            const success_msg = `${type} have been synced successfully.`;
            const error_msg = `Failed to sync ${type}. Please try again.`;

            Inertia.visit(`/users/sync/${type}`, {
                onSuccess() {
                    toast.success(success_msg, {
                        position: "top-center",
                    });
                },
                onError() {
                    toast.error(error_msg, {
                        position: "top-center",
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
