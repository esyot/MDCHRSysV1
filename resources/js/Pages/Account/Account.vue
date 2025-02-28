<script>
import Layout from "@/Layouts/Layout.vue";
import Overview from "@/Pages/Account/Components/Overview.vue";
import PersonalDetails from "@/Pages/Account/Components/PersonalDetails.vue";
import Security from "@/Pages/Account/Components/Security.vue";
import Cropper from "@/Components/Cropper.vue";
import Authentication from "../Login/Authentication.vue";

export default {
  layout: Layout,
  props: {
    personalDetails: Object,
    user: Object,
    authDetails: Object,
    auth: Boolean,
    roles: Object,
    authError: String,
  },
  data() {
    return {
      activeTab: localStorage.getItem("activeTab") || "overview",
      showModal: false,
      userCredentials: {
        user: "",
        email: "",
        password: "",
      },
      dropdownOpen: false,
    };
  },
  components: {
    Overview,
    PersonalDetails,
    Security,
    Cropper,
    Authentication,
  },
  methods: {
    setActiveTab(tab) {
      this.activeTab = tab;
      localStorage.setItem("activeTab", tab);
    },
    openImageCropper() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
  },
};
</script>

<template>
  <Cropper :showModal="showModal" @close="closeModal" />
  <nav>
    <span
      :class="{ active: activeTab === 'overview' }"
      @click="setActiveTab('overview')"
      title="User Overview"
    >
      <i class="fa-solid fa-circle-info fa-lg"></i>
    </span>
    <span
      :class="{ active: activeTab === 'personalDetails' }"
      @click="setActiveTab('personalDetails')"
      title="Personal Details"
    >
      <i class="fa-solid fa-list fa-lg"></i>
    </span>
    <span
      :class="{ active: activeTab === 'security' }"
      @click="setActiveTab('security')"
      title="Security & Password"
    >
      <i class="fa-solid fa-lock fa-lg"></i>
    </span>

    <div
      v-if="activeTab === 'personalDetails'"
      title="Click to preview personal data"
      class="toggle-btn"
    >
      <i class="fas fa-ellipsis-v" @click="toggleDropdown"></i>
      <div class="dropdown-content" v-if="dropdownOpen" @click.self="toggleDropdown">
        <ul>
          <a
            href="/account/personal-data-sheet/preview"
            target="_blank"
            title="Click to preview personal data"
            ><li>View as .pdf</li></a
          >
        </ul>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="user" v-if="activeTab === 'overview'">
      <div class="user-content">
        <div>
          <img
            @click="openImageLarge"
            class="user-img"
            :src="
              personalDetails.img
                ? 'storage/users/images/' + personalDetails.img
                : './assets/images/user.png'
            "
            alt="User Image"
          />
          <i @click="openImageCropper" class="edit-btn fas fa-camera"></i>
        </div>

        <div class="user-details">
          <span class="name">{{ user.first_name }} {{ user.last_name }}</span>
          <div class="user-role">
            <i class="fas fa-globe"></i>
            <div>
              <span
                class="role-desc"
                v-for="(department, index) in user.departments"
                :key="department.id"
                >{{ department.name }}
                {{ user.departments.length >= index ? "" : ", " }}</span
              >
            </div>
          </div>
          <div class="user-role">
            <i class="fas fa-user-cog"></i>
            <div>
              <span class="role-desc">{{ roles.join(", ") }} </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Authentication :authDetails="authDetails" :authError="authError" v-if="!auth" />

    <section id="section" :class="!auth ? 'blur' : 'none-blur'">
      <div v-if="activeTab === 'overview'">
        <Overview :personalDetails="personalDetails" />
      </div>

      <div v-if="activeTab === 'personalDetails'" class="personal-details-container">
        <PersonalDetails :personalDetails="personalDetails" />
      </div>

      <div class="security" v-if="activeTab === 'security'">
        <Security :user="user" :userCredentials="userCredentials" />
      </div>
    </section>
  </div>
</template>

<style scoped>
#section {
  user-select: none;
}
.blur {
  filter: blur(5px);
}
@media (orientation: landscape) {
  nav {
    display: flex;
    align-items: center;
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
    align-items: center;
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
  margin: 5px;
}
.security {
  width: 100%;
  height: auto;
}

.count {
  font-size: 16px;
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

.edit-btn {
  display: absolute;
  position: relative;
  right: 30px;
  bottom: 12px;
  z-index: 9;
  color: #fff;
  font-size: 12px;
  background-color: rgb(55, 103, 246);
  padding: 7px;
  border-radius: 100%;
  cursor: pointer;
  box-shadow: 1px 2px 10px rgb(0, 0, 0);
}

.edit-btn:hover {
  background-color: rgb(29, 81, 236);
}

.dropdown-content {
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
  z-index: 100;
}

.dropdown-content ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.dropdown-content ul a {
  text-decoration: none;
  color: #000;
}

.dropdown-content li {
  padding: 8px 16px;
  cursor: pointer;
}

.dropdown-content li:hover {
  background-color: #cccccc;
}

.toggle-btn {
  display: block;
  margin-left: 20px;
  padding: 10px;
}

.toggle-btn i {
  color: #fff;
}
</style>
