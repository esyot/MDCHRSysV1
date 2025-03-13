import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import AddUserModal from "@/Modals/AddUserModal.vue";

export default {
    layout: Layout,
    components: {
        AddUserModal,
    },
    props: {
        users: Object,
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
        };
    },
    computed: {
        filteredUsers() {
            if (!this.search_value) return this.users;

            const searchLower = this.search_value.toLowerCase();

            return this.users.filter(
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
            Inertia.visit(`/users/user-list/${user.id}`);
        },

        toggleAddUserModal() {
            this.isAddUser = !this.isAddUser;
        },
        toggleSyncUsers() {
            Inertia.visit("/users/sync");
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
