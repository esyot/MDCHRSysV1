<script>
import Layout from "@/Layouts/Layout.vue";
import Overview from "@/Pages/Account/Components/Overview.vue";
import PersonalDetails from "@/Pages/Account/Components/PersonalDetails.vue";
import Security from "@/Pages/Account/Components/Security.vue";
import Cropper from "@/Components/Cropper.vue";
import Authentication from "../Login/Authentication.vue";
import { useToast } from "vue-toastification";

export default {
  layout: Layout,
  props: {
    personalDetails: Object,
    user: Object,
    authDetails: Object,
    auth: Boolean,
    roles: Object,
    authError: String,
    overviewData: Object,
    tab: String,
    isDefaultPass: Number,
  },
  mounted() {
    if (this.isDefaultPass === 1) {
      localStorage.setItem("activeTab", this.tab);
      const toast = useToast();

      toast.warning("You need to change your password first before using the system.", {
        position: "top-center",
        duration: 3000,
      });
    }
  },
  data() {
    return {
      activeTab: this.tab ? this.tab : localStorage.getItem("activeTab"),
      showModal: false,
      userCredentials: {
        user: "",
        email: "",
        password: "",
      },
      dropdownOpen: false,
      user_job_details: this.personalDetails.user_job_details,
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
      @click="toggleDropdown"
    >
      <i class="fas fa-ellipsis-v"></i>

      <div class="dropdown-content" v-if="dropdownOpen" @click.self="toggleDropdown">
        <a
          href="/account/personal-data-sheet/preview"
          target="_blank"
          title="Click to preview personal data"
        >
          View as .pdf
        </a>
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
          <span class="name"
            >{{ user.first_name }} {{ user.last_name }} ({{ user.user }})</span
          >
          <div class="user-role" v-if="user.teacher.department">
            <i class="fas fa-globe"></i>
            <div>
              <span class="role-desc">
                {{ user.teacher.department.name }} ({{
                  user.teacher.department.acronym
                }})</span
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
        <Overview :user_job_details="user_job_details" :overviewData="overviewData" />
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
@import "./css/account.css";
</style>
