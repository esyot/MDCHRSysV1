<template>
    <div id="sidebar" class="sidebar">
        <div class="sidebar-content">
            <div class="logo">
                <div class="logo-img-container">
                    <img
                        src="/public/assets/images/mdc-logo.png"
                        class="logo-img"
                        alt="Logo"
                    />
                </div>

                <span id="app-name">MDC - HR System</span>
            </div>

            <div>
                <span v-for="role in roles" :key="role" class="role-desc">{{
                    role
                }}</span>
            </div>
            <hr />
            <div id="menu" class="menu">
                <ul id="menu-items">
                    <InertiaLink :href="'/dashboard'" class="link"
                        ><li class="menu-li" title="Home">
                            <i class="fas fa-gauge"></i>
                            <span>Dashboard</span>
                        </li>
                    </InertiaLink>
                    <li title="Services">
                        <div class="menu-li" @click="openSubMenu('Services')">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            <span>Services</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <ul id="submenu-services" class="submenu">
                            <InertiaLink :href="'/forms/travel-form-request'">
                                <li>
                                    <span>Request Travel Application</span>
                                </li></InertiaLink
                            >

                            <InertiaLink :href="'/forms/leave-form-request'">
                                <li><span>Request Leave Application</span></li>
                            </InertiaLink>
                        </ul>
                    </li>
                    <li title="Users">
                        <div class="menu-li" @click="openSubMenu('Users')">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <ul id="submenu-users" class="submenu">
                            <li><span>Tracking</span></li>
                            <li><span>Travel Application Requests </span></li>
                            <li><span>Leave Application Requests</span></li>
                        </ul>
                    </li>
                    <li class="menu-li" title="About">
                        <i class="fas fa-info-circle"></i><span>About</span>
                    </li>
                </ul>
            </div>
            <div class="footer">
                <span id="copy-desc">All rights reserved &copy; 2025</span>
            </div>
        </div>
    </div>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    props: {
        roles: Object,
    },
    components: {
        InertiaLink,
    },
    methods: {
        openSubMenu(menuName) {
            if (menuName === "Services") {
                const submenu = document.getElementById("submenu-services");
                if (submenu.style.display === "block") {
                    submenu.style.display = "none";
                } else {
                    submenu.style.display = "block";
                }
            } else if (menuName === "Users") {
                const submenu = document.getElementById("submenu-users");
                if (submenu.style.display === "block") {
                    submenu.style.display = "none";
                } else {
                    submenu.style.display = "block";
                }
            }
        },
    },
};
</script>

<style scoped>
@media (orientation: portrait) {
    .sidebar {
        display: none;
    }
}
hr {
    border: 0;
    height: 1px;
    background-color: #fff;
    opacity: 20%;
}

.role-desc {
    padding: 10px;
    font-size: 12px;
}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.sidebar-open {
    width: 20px;
}

.sidebar {
    overflow-x: hidden;
    overflow-y: hidden;
    width: 200px;
    background: linear-gradient(to bottom, #34ace0, #043b5c);
    color: white;
    height: 100%;
    box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
    transform: translateX(0);
    transition: transform 0.3s ease-in-out;
    user-select: none;
}

.sidebar.hidden {
    transform: translateX(-100%);
}

.sidebar-content {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.logo {
    display: flex;
    padding: 10px;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}
.logo-img-container {
    display: flex;
    padding: 5px;
}

.logo-img {
    display: flex;
    width: 64px;
    height: 64px;
    text-align: center;
    justify-content: center;
    object-fit: contain;
    filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.2));
}

h1 {
    text-align: center;
    margin-top: 10px;
}

.menu {
    flex-grow: 1;
    display: flex;
    justify-content: start;
    margin-left: 20px;
    margin-top: 10%;
}

.menu ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    align-content: center;
    flex-direction: column;
    gap: 1.5rem;
}

.menu-li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.menu li {
    cursor: pointer;
}

.menu li span {
    opacity: 75%;
    font-size: 12px;
}

.menu li i {
    opacity: 30%;
}

.menu li:hover span,
.menu li:hover i {
    opacity: 100%;
}

.submenu {
    margin-left: 40px;
}

.menu li ul {
    display: none;
}

.submenu li {
    list-style-type: disc;
    opacity: 40%;
    padding: 5px;
}

.submenu li:hover {
    opacity: 100%;
}

.footer {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    text-align: center;
    font-size: 14px;
    margin-top: auto;
}

.main-content {
    flex-grow: 1;
    padding: 10px;
}

.sidebar-toggle {
    background-color: #3b82f6;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
    font-size: 20px;
}

.sidebar-toggle:focus {
    outline: none;
}
.footer span {
    font-size: 10px;
    opacity: 60%;
    margin-bottom: 1rem;
}
</style>
