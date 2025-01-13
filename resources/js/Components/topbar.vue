<template>
    <div class="topbar">
        <div class="userToggleBtn" @click="toggleDropdown">
            Josefina Pangan

            <div class="userIconBtn">
                <i class="fas fa-user"></i>
                <i class="fas fa-chevron-circle-down fa-xs"></i>
            </div>
        </div>
        <div
            id="dropdown"
            class="dropdown"
            :class="{ show: isDropdownVisible }"
        >
            <span><i class="fas fa-user"></i> Personal Details</span>
            <span><i class="fas fa-user-cog"></i> Account</span>
            <span class="logout"><i class="fas fa-sign-out"></i> Logout</span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDropdownVisible: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;

            if (this.isDropdownVisible == true) {
                document.getElementById("dropdown").style.display = "flex";
            } else {
                document.getElementById("dropdown").style.display = "none";
            }
        },
    },
};
</script>

<style scoped>
.topbar {
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

    gap: 0.5rem;
    position: fixed;
    background-color: #fff;
    top: 3rem;
    right: 3;

    border: solid #eee 1px;
    filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.2));
}

.dropdown span {
    cursor: pointer;
    font-size: 16px;
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
