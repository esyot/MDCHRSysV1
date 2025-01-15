<template>
    <div class="topbar" ref="topbar">
        <div class="userToggleBtn" @click="toggleDropdown" ref="userToggleBtn">
            <span class="userName">Josefina Pangan</span>
            <div class="userIconBtn">
                <i class="fas fa-user"></i>
                <i class="fas fa-chevron-circle-down fa-xs"></i>
            </div>
        </div>
        <div
            id="dropdown"
            class="dropdown"
            :class="{ show: isDropdownVisible }"
            ref="dropdown"
        >
            <InertiaLink :href="'/account'" class="link">
                <span><i class="fas fa-user-cog"></i> Account</span>
            </InertiaLink>

            <span class="logout"><i class="fas fa-sign-out"></i> Logout</span>
        </div>
    </div>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    data() {
        return {
            isDropdownVisible: false,
        };
    },
    components: {
        InertiaLink,
    },
    methods: {
        toggleDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;
        },
        closeDropdown(event) {
            if (
                this.$refs.dropdown &&
                !this.$refs.dropdown.contains(event.target) &&
                !this.$refs.userToggleBtn.contains(event.target)
            ) {
                this.isDropdownVisible = false;
            }
        },
    },
    mounted() {
        document.addEventListener("click", this.closeDropdown);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.closeDropdown);
    },
};
</script>

<style scoped>
.userName {
    font-size: 14px;
}
.topbar {
    user-select: none;
    display: flex;
    justify-content: end;
    background: linear-gradient(to right, #81ecec, #0b7fab);
    padding: 1rem;
    position: relative;
}

.userToggleBtn {
    display: flex;
    gap: 0.5rem;
    color: #fff;
    opacity: 75%;
    cursor: pointer;
    align-items: center;
}

.userToggleBtn:hover {
    opacity: 100%;
}

.userIconBtn {
    display: flex;
    align-items: end;
}

.dropdown {
    display: none;
    flex-direction: column;
    position: fixed;
    background-color: #fff;
    top: 3rem;
    right: 3;
    border: solid #eee 1px;
    filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.2));
}

.dropdown span {
    cursor: pointer;
    font-size: 12px;
    padding: 10px;
    gap: 0.5rem;
    display: flex;
    align-items: center;
}
.logout {
    border-top: solid 1px #d3d3d3;
}
.dropdown i {
    color: #d3d3d3;
    font-size: 12px;
}
.dropdown span:hover {
    background-color: #ededed;
}

.dropdown.show {
    display: block;
}

.dropdown li:hover {
    background-color: #f1f1f1;
}
</style>
