<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";
import { formatDistanceToNow, differenceInSeconds } from "date-fns";

export default {
  data() {
    return {
      notifications: [],
      fetchInterval: null,
      isOpenAccountOptions: false,
      isOpenNotifications: false,
      isOpenNotificationsOptions: false,
    };
  },
  props: {
    user: Object,
    pageTitle: String,
  },
  components: {
    InertiaLink,
  },

  methods: {
    // Native browser back behavior
    goBack() {
      window.history.back(); // Goes back to the previous page in the history
    },

    toggleAccountOptions() {
      this.isOpenAccountOptions = !this.isOpenAccountOptions;
    },
    toggleNotifications() {
      this.isOpenNotifications = !this.isOpenNotifications;
    },
    toggleNotificationOptions(event) {
      event.stopPropagation();
      this.isOpenNotificationsOptions = !this.isOpenNotificationsOptions;
    },
    closeAccountOptions(event) {
      if (
        this.$refs.accountOptions &&
        !this.$refs.accountOptions.contains(event.target) &&
        !this.$refs.toggleAccountOptions.contains(event.target)
      ) {
        this.isOpenAccountOptions = false;
      }
    },
    closeNotifications(event) {
      if (
        this.$refs.notificationContainer &&
        !this.$refs.notificationContainer.contains(event.target) &&
        !this.$refs.notificationBell.contains(event.target)
      ) {
        this.isOpenNotifications = false;
        this.isOpenNotificationsOptions = false;
      }
    },
    closeNotificationsOptions(event) {
      if (
        this.$refs.notificationOptions &&
        !this.$refs.notificationOptions.contains(event.target)
      ) {
        this.isOpenNotificationsOptions = false;
      }
    },
    logoutConfirm() {
      document.getElementById("logoutConfirmModal").classList.toggle("hidden");
    },

    fetchNotifCount(user) {
      fetch(`/notifications/${user}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.notifications = data ?? null;
        })
        .catch((error) => {
          console.error("Error fetching leave forms:", error);
        });
    },
    startFetchingNotifications() {
      this.fetchNotifCount(this.user.id);
      this.fetchInterval = setInterval(() => {
        this.fetchNotifCount(this.user.id);
      }, 6000);
    },
    stopFetchingNotifications() {
      if (this.fetchInterval) {
        clearInterval(this.fetchInterval);
        this.fetchInterval = null;
      }
    },
    calculateTimeAgo(createdAt) {
      const now = new Date();
      const createdDate = new Date(createdAt);
      const secondsAgo = differenceInSeconds(now, createdDate);

      if (secondsAgo < 60) {
        return `${secondsAgo} secs`;
      }

      const timeAgo = formatDistanceToNow(createdDate, { addSuffix: false });
      const regex = /about |ago/gi;
      let result = timeAgo.replace(regex, "").trim();

      result = result.replace(/minute(s)?/gi, (match) =>
        match.includes("s") ? "mins" : "min"
      );
      result = result.replace(/hour(s)?/gi, (match) =>
        match.includes("s") ? "hrs" : "hr"
      );

      return result;
    },
    checkStatus(array) {
      if (array && array.includes(this.user.id)) {
        return "";
      } else {
        return "not-read";
      }
    },
  },
  mounted() {
    this.startFetchingNotifications();
    document.addEventListener("click", this.closeAccountOptions);
    document.addEventListener("click", this.closeNotifications);
    document.addEventListener("click", this.closeNotificationsOptions);
  },
  beforeDestroy() {
    this.stopFetchingNotifications();
    document.removeEventListener("click", this.closeAccountOptions);
    document.removeEventListener("click", this.closeNotifications);
    document.removeEventListener("click", this.closeNotificationsOptions);
  },
  computed: {
    count() {
      const notificationsArray = Object.values(this.notifications);

      if (!Array.isArray(notificationsArray)) {
        console.error("notificationsArray is not an array", notificationsArray);
        return 0;
      }

      const unreadNotifications = notificationsArray.filter((notification) => {
        const isReadByArray = notification.isReadBy ? notification.isReadBy : [];
        return !isReadByArray.includes(this.user.id);
      });

      return unreadNotifications.length;
    },
  },
};
</script>

<template>
  <div class="topbar" ref="topbar">
    <div class="left">
      <div class="page-title">
        <i
          @click="goBack"
          title="Click this to go back previous tab"
          class="back-btn fas fa-arrow-circle-left"
        ></i>

        <span class="app-name">MDC HR Sys v1.0</span>
        <i class="fas fa-chevron-right"></i>
        <span class="text">{{ pageTitle }}</span>
      </div>
    </div>
    <div class="right">
      <div class="notif" ref="notificationBell" @click.self="toggleNotificationOptions">
        <i class="fas fa-bell fa-lg" @click="toggleNotifications"></i>
        <span class="notif-count" v-if="count"
          >{{ count }} {{ fetchNotifCount(user.id) }}</span
        >
        <div
          class="notification-container"
          v-if="isOpenNotifications"
          ref="notificationContainer"
        >
          <div class="title">
            <span>Notifications</span>
            <i @click="toggleNotificationOptions" class="fas fa-ellipsis-v"></i>

            <div
              ref="notificationOptions"
              v-if="isOpenNotificationsOptions"
              class="notification-options"
            >
              <InertiaLink :href="`/notifications/read/${user.id}/all`"
                >Mark all as read</InertiaLink
              >
              <InertiaLink :href="`/notifications/delete/${user.id}/all`"
                >Delete all</InertiaLink
              >
            </div>
          </div>
          <InertiaLink
            :href="notification.link"
            v-for="notification in notifications"
            :key="notification.id"
            :class="checkStatus(notification.isReadBy)"
          >
            <div class="notif-item">
              <div class="item-left">
                <span class="notif-title">{{ notification.title }}</span>
                <small class="notif-desc">{{ notification.description }}</small>
              </div>
              <div class="item-right">
                <small>{{ calculateTimeAgo(notification.created_at) }}</small>
              </div>
            </div>
          </InertiaLink>
          <span class="notif-msg" v-if="notifications.length === 0">
            No new notifications in this time.
          </span>
        </div>
      </div>

      <div class="userToggleBtn" title="Dropdown settings">
        <div class="userIconBtn" @click="toggleAccountOptions" ref="toggleAccountOptions">
          <div class="user-img">
            <img
              class="user-img"
              :src="
                user.img ? '/storage/users/images/' + user.img : '/assets/images/user.png'
              "
              alt="User Image"
            />
            <i class="fas fa-cog fa-xs"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="account-options" v-if="isOpenAccountOptions" ref="accountOptions">
      <InertiaLink :href="'/account'" class="link" title="Account Settings">
        <span class="account"
          ><i class="fas fa-user-cog"></i>

          {{ user.first_name }} {{ user.last_name }}
        </span>
      </InertiaLink>

      <span @click="logoutConfirm" class="logout" title="Logout"
        ><i class="fas fa-sign-out"></i> Logout</span
      >
    </div>
  </div>

  <div @click.self="logoutConfirm" id="logoutConfirmModal" class="modal hidden">
    <section class="modal-content">
      <h2>Are you sure to logout?</h2>
      <footer>
        <button @click="logoutConfirm">No</button>
        <InertiaLink :href="'/logout'"> Yes </InertiaLink>
      </footer>
    </section>
  </div>
</template>

<style scoped>
@import "./css/topbar.css";
</style>
