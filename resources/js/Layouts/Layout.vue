<script>
import Leftbar from "@/Components/Leftbar.vue";
import Topbar from "@/Components/Topbar.vue";
import Footer from "@/Components/Footer.vue";
import SuccessModal from "@/Components/SuccessModal.vue";

export default {
  components: {
    Leftbar,
    Topbar,
    Footer,
    SuccessModal,
  },
  props: {
    user: Object,
    roles: Object,
    messageSuccess: String,
    pageTitle: String,
  },

  data() {
    return {
      successMessage: this.messageSuccess || null, // Initialize with messageSuccess or null if undefined
    };
  },

  methods: {
    closeSuccessModal() {
      this.successMessage = null; // Close the modal by clearing the successMessage
    },
  },

  watch: {
    messageSuccess(newMessage) {
      this.successMessage = newMessage && newMessage.trim() !== "" ? newMessage : null;
    },

    successMessage(newMessage) {
      this.successMessage = newMessage && newMessage.trim() !== "" ? newMessage : null;
    },
  },

  mounted() {
    if (this.messageSuccess && this.messageSuccess.trim() !== "") {
      this.successMessage = this.messageSuccess;
    }
  },
};
</script>

<template>
  <div class="container">
    <SuccessModal
      :successMessage="successMessage"
      @close-success-modal="closeSuccessModal"
      v-if="successMessage"
    />
    <Leftbar :roles="roles" />
    <div class="main-content">
      <Topbar :pageTitle="pageTitle" :user="user" />
      <slot> </slot>
      <Footer />
    </div>
  </div>
</template>

<style>
@media (orientation: landscape) {
  Footer {
    display: none;
  }
}
@keyframes increaseOpacity {
  0% {
    background-color: rgba(0, 0, 0, 0);
  }
  100% {
    background-color: rgba(0, 0, 0, 0.5);
  }
}

@keyframes popUp {
  0% {
    transform: scale(0.1);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
.hidden {
  display: none;
}
.link {
  color: currentColor;
  text-decoration: none;
}
::-webkit-scrollbar {
  width: 3px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.container {
  width: screen;
  display: flex;
  height: 100vh;
  transition: transform 0.3s ease-in-out;
}
.main-content {
  overflow-y: hidden;
  overflow-x: hidden;
  width: 100%;
  background: linear-gradient(to bottom, #2986c0, #02041d);
}
</style>
