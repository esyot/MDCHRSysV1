<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      isDropdownVisible: false,
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
    logoutConfirm() {
      document.getElementById("logoutConfirmModal").classList.toggle("hidden");
    },
    uc_first(text) {
      return text[0];
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

<template>
  <div class="topbar" ref="topbar">
    <div class="page-title">
      <span>{{ pageTitle }}</span>
    </div>
    <div
      class="userToggleBtn"
      @click="toggleDropdown"
      title="Dropdown settings"
      ref="userToggleBtn"
    >
      <div class="userIconBtn">
        <div class="user-img">
          <img
            class="user-img"
            :src="
              user.img ? 'storage/users/images/' + user.img : '../assets/images/user.png'
            "
            alt="User Image"
          />
          <i class="fas fa-cog fa-xs"></i>
        </div>
      </div>
    </div>
    <div
      id="dropdown"
      class="dropdown"
      :class="{ show: isDropdownVisible }"
      ref="dropdown"
    >
      <InertiaLink :href="'/account'" class="link" title="Account Settings">
        <span
          ><i class="fas fa-user-cog"></i>

          {{ user.first_name }} {{ user.last_name }}
        </span>
      </InertiaLink>

      <span @click="logoutConfirm" class="logout" title="Logout"
        ><i class="fas fa-sign-out"></i> Logout</span
      >
    </div>
  </div>

  <div id="logoutConfirmModal" class="modal hidden">
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
.topbar {
  user-select: none;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(to right, #81ecec, #0b7fab);
  padding: 8px;
  position: relative;
  z-index: 50;
}

.topbar .page-title {
  font-size: 16pt !important;
  color: #ffffff;
  filter: drop-shadow(6px 6px 6px rgba(0, 0, 0, 0.3));
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
  justify-content: space-between;
}

.user-img {
  display: flex;
  align-items: end;
  position: relative;
}

.user-img i {
  color: rgb(255, 255, 255);
  font-size: 14px;
  display: flex;
  position: fixed;
  right: 6px;
  filter: drop-shadow(10px 10px 10px rgba(0, 0, 0, 0.6));
  top: 40px;
}
.user-img img {
  width: 35px;
  border-radius: 100%;
  border: 2px solid #ffffff;
  box-shadow: 1px 2px 10px gray;
}
footer {
  display: flex;
  justify-content: end;
  gap: 0.2rem;
  padding: 10px;
}

footer a {
  text-decoration: none;
  color: #fff;
  background-color: #e22020;
  padding: 8px 10px;
  border-radius: 5px;
  opacity: 60%;
  transition: opacity 0.3s ease, background-color 0.3s ease;
}

.modal-content button {
  background-color: transparent;
  padding: 8px 10px;
  border-radius: 5px;
  opacity: 60%;
  color: #e22020;
  border: 1px solid #e22020;
}

footer a:hover,
button:hover {
  opacity: 100%;
  cursor: pointer;
}
.modal {
  display: flex;
  position: fixed;
  inset: 0;
  z-index: 100;
  justify-content: center;
  align-items: center;
  background-color: rgba(255, 0, 0, 0);
  animation: increaseOpacity 2s forwards;
}

@keyframes increaseOpacity {
  0% {
    background-color: rgba(0, 0, 0, 0);
  }
  100% {
    background-color: rgba(0, 0, 0, 0.8);
  }
}

.modal-content {
  display: flex;
  padding: 0px 20px;
  border-radius: 5px;
  flex-direction: column;
  background-color: #fff;
  border: 1px solid #7a7a7a;
}

.dropdown {
  display: none;
  flex-direction: column;
  position: fixed;
  background-color: #fff;
  z-index: 120;
  top: 3rem;
<<<<<<< HEAD:resources/js/Components/Topbar.vue
  right: 10px;
  box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);
  border: 1px solid #d1d1d1;
=======
  right: 3;
  box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);
  border: 1px solid #d1d1d1;
  border-radius: 5px;
>>>>>>> ab2a90d (updated codes -main):resources/js/Components/topbar.vue
}

.dropdown span {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 14px;
  padding: 10px;
  gap: 0.5rem;
  display: flex;
  align-items: center;
}
.logout {
  border-top: solid 1px #d3d3d3;
}
.dropdown i {
  color: #686868;
  font-size: 14px;
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

.modal-content footer {
  padding: 10px;
}
.hidden {
  display: none;
}
.userName {
  font-size: 14px;
}
</style>
