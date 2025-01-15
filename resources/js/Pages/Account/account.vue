<script>
import Layout from "@/Layouts/Layout.vue";
import Overview from "@/Pages/Account/Components/overview.vue";
import PersonalDetails from "@/Pages/Account/Components/personalDetails.vue";
import Security from "@/Pages/Account/Components/security.vue";

export default {
    layout: Layout,
    data() {
        return {
            activeTab: localStorage.getItem("activeTab") || "overview",
        };
    },
    components: {
        Overview,
        PersonalDetails,
        Security,
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab;
            localStorage.setItem("activeTab", tab);
        },
    },
};
</script>

<template>
    <div class="content">
        <div v-if="activeTab === 'overview'" class="profile-container">
            <div class="user">
                <div>
                    <img
                        class="user-img"
                        src="/public/assets/images/user.png"
                        alt="User Image"
                    />
                    <i class="edit-btn fa-solid fa-pen-to-square"></i>
                </div>
            </div>
        </div>

        <nav class="nav">
            <ul class="nav-items">
                <li
                    :class="{ active: activeTab === 'overview' }"
                    @click="setActiveTab('overview')"
                >
                    Overview
                </li>
                <li
                    :class="{ active: activeTab === 'personalDetails' }"
                    @click="setActiveTab('personalDetails')"
                >
                    Personal Details
                </li>
                <li
                    :class="{ active: activeTab === 'security' }"
                    @click="setActiveTab('security')"
                >
                    Security & Passwords
                </li>
            </ul>
        </nav>

        <section class="user-overview">
            <div v-if="activeTab === 'overview'">
                <Overview />
            </div>

            <div v-if="activeTab === 'personalDetails'">
                <PersonalDetails />
            </div>

            <div class="security" v-if="activeTab === 'security'">
                <Security />
            </div>
        </section>
    </div>
</template>

<style scoped>
.security {
    width: 100%;
    height: auto;
}

.count {
    font-size: 16px;
}

.user-overview {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    height: auto;
    overflow-y: auto;
}

.nav {
    user-select: none;
    display: flex;
    padding: 5px;
    background-color: #fff;
    border-bottom: #d3d3d3 1px solid;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
}

.nav-items {
    display: flex;
    gap: 1.5rem;
}

.nav-items li {
    list-style: none;
    cursor: pointer;
    color: #000;
    opacity: 50%;
    font-weight: 600;
    font-size: 12px;
}

.nav-items li:hover {
    opacity: 100%;
}

.nav-items li.active {
    color: #2282ff;
    opacity: 100%;
}
.content {
    margin: 0.5rem;
    border-radius: 10px;
}

.profile-container {
    display: flex;
    justify-content: center;
    width: 100%;
}

.user {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    background: linear-gradient(
        to bottom,
        rgba(94, 204, 216, 0.3),
        rgba(10, 124, 137)
    );
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px;
}

.user-img {
    height: 200px;
    width: 200px;
    border-radius: 50%;
    object-fit: cover;
    border: #dadada 4px solid;
    box-shadow: 1px 2px 10px gray;
}

.edit-btn {
    display: absolute;
    position: relative;
    right: 50px;
    bottom: 20px;
    color: #fff;
    background-color: rgb(55, 103, 246);
    padding: 10px;
    border-radius: 100%;
    cursor: pointer;
    box-shadow: 1px 2px 10px gray;
}

.edit-btn:hover {
    background-color: rgb(29, 81, 236);
}
</style>
