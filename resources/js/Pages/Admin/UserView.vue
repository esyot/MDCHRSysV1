<script>
import Layout from "@/Layouts/Layout.vue";
import Overview from "@/Pages/Account/Components/Overview.vue";
import Cropper from "@/Components/Cropper.vue";

export default {
    layout: Layout,
    props: {
        users: Object,
        roles: {
            type: Array,
            default: () => [],
        },
    },
    components: {
        Overview,
    },
};
</script>

<template>
    <div class="container">
        <div class="content">
            <div class="user">
                <div class="user-content">
                    <div>
                        <img
                            :src="
                                users.img
                                    ? `/storage/users/images/${users.img}`
                                    : '/assets/images/user.png'
                            "
                            alt="User Image"
                            class="user-img"
                        />
                    </div>
                    <div class="user-details">
                        <span class="name"
                            >{{ users.first_name }} {{ users.last_name }}</span
                        >
                        <div class="user-role">
                            <i class="fas fa-user-cog"></i>
                            <div>
                                <span
                                    v-for="role in roles"
                                    :key="role"
                                    class="role-desc"
                                    >{{ role }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <div class="btn-left">
                    <select name="" id="">
                        <option value="" selected disabled>All Forms</option>
                        <option value="Travel Forms">Travel Forms</option>
                        <option value="Leave Forms">Leave Forms</option>
                    </select>
                    <select name="" id="">
                        <option value="" selected disabled>Filter By:</option>
                        <option value="Annually">Annually</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Weekly">Weekly</option>
                    </select>
                </div>
                <div class="btn-right">
                    <button>Edit Role</button>
                    <button>History</button>
                    <button>Evaluate</button>
                </div>
            </div>
            <div class="forms">
                <table>
                    <thead>
                        <tr>
                            <td class="td-title">
                                <span>Leave Type</span>
                            </td>
                            <td class="td-title">
                                <span>Date start of Leave</span>
                            </td>
                            <td class="td-title">
                                <span>Date end of Leave</span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span>Personal</span></td>
                            <td><span>12/12/2004</span></td>
                            <td><span>12/12/2004</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<style scoped>
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
#section {
    user-select: none;
}
.blur {
    filter: blur(5px);
}
@media (orientation: landscape) {
    nav {
        display: flex;
        justify-content: start;
        margin: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    nav span {
        text-align: center;
        font-weight: bold;
        z-index: 10;
        padding-top: 10px;
        padding-bottom: 10px;
        opacity: 40%;
        color: #fff;
        margin-left: 3rem;
    }

    nav span:hover {
        opacity: 100%;
        scale: 1.3;
        transition-duration: 600ms;
    }

    nav i {
        filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.3));
    }
    nav span.active {
        color: #fff;
        opacity: 100%;
        scale: 1.3;
    }
}

@media (orientation: portrait) {
    nav {
        display: flex;
        justify-content: space-around;
        margin: 5px;
        border-radius: 5px;
    }
    nav span {
        text-align: center;
        font-weight: bold;
        z-index: 10;
        padding-top: 10px;
        padding-bottom: 10px;
        opacity: 40%;
        color: #fff;
    }

    nav span:hover {
        opacity: 100%;
        scale: 1.2;
    }

    nav i {
        filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.3));
    }
    nav span.active {
        color: #fff;
        opacity: 100%;
        scale: 1.3;
    }
}

.user-content {
    padding: 10px;
}

.user-role {
    display: flex;
    gap: 0.5rem;
}
.user-details {
    display: flex;
    flex-direction: column;
}
.user-details .name {
    font-size: 30px;
    font-weight: bold;
}

.user-details h1 {
    color: #fff;
}

.user-details i {
    color: #fff;
}

.user-details span {
    color: #fff;
}

.content {
    width: 99%;
    margin: 5px;
}

.profile-container {
    display: flex;
}

.user {
    border-radius: 5px;
    background: linear-gradient(to top, rgb(0, 0, 0), rgba(0, 0, 0, 0.1));
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: end;
    align-items: start;
    height: 30vh;
    box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.3);
}

.user-img {
    height: 100px;
    width: 100px;
    border-radius: 50%;
    object-fit: fill;
    border: #dadada 4px solid;
    box-shadow: 1px 2px 10px rgb(0, 0, 0);
}
.user-img:hover {
    cursor: pointer;
    opacity: 60%;
}
@media (orientation: portrait) {
    .td-title span {
        display: none;
    }

    .td-title {
        text-align: center;
    }

    .td-action {
        text-align: center;
    }

    .td-action span {
        display: none;
    }
}
.forms {
    display: block;
    margin: 10px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

table {
    user-select: none;
    width: 100%;
    border-collapse: collapse;
}

thead {
    background-color: #e0e0e0;
    color: #676767;
}

thead td {
    padding: 12px 15px;
    font-weight: bold;
    text-align: left;
}

tbody tr {
    border-bottom: 1px solid #ddd;
    cursor: pointer;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

td {
    padding: 12px 15px;
    text-align: left;
}
.buttons {
    display: flex;
    justify-content: space-between;
    margin: 10px;
}
.btn-right button {
    background-color: rgb(35, 134, 200);
    color: #fff;
    margin: 5px;
    padding: 10px 20px;
    border-radius: 7px;
}
.btn-left select {
    padding: 10px;
    margin: 5px;
    border-radius: 7px;
}
</style>
