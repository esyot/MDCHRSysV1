<script>
import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    layout: Layout,
    props: {
        users: {
            type: Array,
            default: () => [],
        },
        roles: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            searchBar: "",
        };
    },
    computed: {
        filteredUsers() {
            if (!this.searchBar) return this.users;

            const searchLower = this.searchBar.toLowerCase();

            return this.users.filter(
                (user) =>
                    user.last_name.toLowerCase().includes(searchLower) ||
                    user.first_name.toLowerCase().includes(searchLower) ||
                    (user.middle_name?.toLowerCase().includes(searchLower) ??
                        false)
            );
        },
    },
    methods: {
        handleClick(user) {
            Inertia.visit(`/user-list/${user.id}`);
        },
    },
};
</script>

<template>
    <div class="container">
        <div class="forms-selection">
            <i class="fa-solid fa-search"></i>
            <input
                type="text"
                name="searchBar"
                class="searchBar"
                v-model="searchBar"
                placeholder="Search users . . ."
            />
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <td class="td-title">
                            <i class="fa-solid fa-user"></i>
                            <span>User Name</span>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in filteredUsers"
                        :key="user.id"
                        @click="handleClick(user)"
                    >
                        <td>
                            {{ user.last_name }}, {{ user.first_name }}
                            <span v-if="user.middle_name"
                                >.{{ user.middle_name[0] }}</span
                            >
                        </td>
                    </tr>
                </tbody>
                <tbody v-if="filteredUsers.length === 0">
                    <tr>
                        <td>No users found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
@import "./Styling/userList.css";
</style>
