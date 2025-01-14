<script>
import Layout from "@/Layouts/layout.vue";

export default {
    layout: Layout,
};
</script>

<template>
    <div class="content">
        <div class="profile-container">
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
                <li>Overview</li>
                <li>Personal Details</li>
                <li>Security & passwords</li>
            </ul>
        </nav>
        <section class="user-overview">
            <div class="overview-item">
                <i class="fas fa-star"></i>
                <div>
                    <p class="title">Rank</p>
                    <p class="count">Teacher, Staff</p>
                </div>
            </div>
            <div class="overview-item">
                <i class="fas fa-peso-sign"></i>
                <div>
                    <p class="title">Total Requested</p>
                    <p class="count">15,000.00</p>
                </div>
            </div>
            <div class="overview-item">
                <i class="fas fa-calendar-day"></i>
                <div>
                    <p class="title">Days Leave</p>
                    <p class="count">20</p>
                </div>
            </div>
            <div class="overview-item">
                <i class="fas fa-plane-departure"></i>
                <div>
                    <p class="title">Days Travel</p>
                    <p class="count">10</p>
                </div>
            </div>
            <div class="overview-item">
                <i class="fas fa-plane-arrival"></i>
                <div>
                    <p class="title">Days Travel Left</p>
                    <p class="count">5</p>
                </div>
            </div>
            <div class="overview-item">
                <i class="fas fa-calendar-check"></i>
                <div>
                    <p class="title">Days Leave Left</p>
                    <p class="count">5</p>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
.count {
    font-size: 16px;
}
.user-overview {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    max-height: 320px;
    min-height: 200px;
    overflow-y: auto;
    padding: 5px;
}

.overview-item {
    flex-grow: 1;
    flex-basis: 400px;
    display: flex;
    align-items: center;
    justify-content: start;
    background-color: #f4f4f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 250px;
    padding-left: 40px;
}

.overview-item i {
    font-size: 36px;
    color: #2282ff;
    margin-right: 15px;
}

.overview-item .title {
    font-weight: bold;
    font-size: 16px;
    color: #333;
}

.overview-item .count {
    font-size: 20px;
    color: #000;
    margin-top: 5px;
}

.overview-item:hover {
    background-color: #e0e0e0;
    cursor: pointer;
}

.nav {
    background-color: #fff;
    border-bottom: 1px solid rgb(188, 188, 188);
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
.content {
    background-color: #fff;
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
