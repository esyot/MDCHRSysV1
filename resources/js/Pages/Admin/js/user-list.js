import Layout from "@/Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import AddUserModal from "@/Modals/AddUserModal.vue";
import { useToast } from "vue-toastification";

export default {
    layout: Layout,
    components: {
        AddUserModal,
        Link,
    },
    props: {
        users: Object,
        search_value: String,
        roles: Array,
        departmentList: Object,
        roleList: Array,
        specializationList: Array,
        positionList: Array,
        type: String,
        orderBy: String,
        department: String,
    },
    data() {
        return {
            isAddUser: false,
            isAddTeacher: false,
            isAddStaff: false,
            user_type: this.type,
            nextPageUrl: this.users.next_page_url,
            order_by: this.orderBy,
            search_bar: this.search_value ?? "",
            department_id: this.department ?? "",
        };
    },

    watch: {
        search_bar(newVal) {
            if (newVal === "") {
                router.get("/users/users-list", {
                    type: this.user_type,
                    orderBy: this.order_by,
                    department: this.department_id,
                });
            }
        },
    },

    methods: {
        paginationControl(link) {
            router.get(link, {
                type: this.user_type,
                search_value: this.search_bar,
                orderBy: this.order_by,
                department: this.department_id,
            });
        },
        filterUsers() {
            router.get("/users/users-list", {
                type: this.user_type,
                search_value: this.search_bar,
                orderBy: this.order_by,
                department: this.department_id,
            });
        },

        visitUser(user) {
            router.visit(`/users/user-list/${user.id}/false`);
        },

        toggleAddUserModal() {
            this.isAddUser = !this.isAddUser;
        },

        toggleSyncUsers(type) {
            const toast = useToast();

            const userType = type;

            type = type.charAt(0).toUpperCase() + type.slice(1) + "s";

            const success_msg = `${type} have been synced successfully.`;
            const error_msg = `Failed to sync ${type}. Please try again.`;

            router.visit(`/users/sync/${userType}`, {
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
};
