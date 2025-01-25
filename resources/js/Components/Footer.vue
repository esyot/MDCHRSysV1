<template>
  <footer class="sticky-footer">
    <div class="nav-btns">
      <InertiaLink :href="'/dashboard'" class="link">
        <i class="fas fa-users fa-2x"></i>
      </InertiaLink>

      <InertiaLink :href="'/dashboard'" class="link">
        <i class="icon-center fas fa-home fa-2x"></i>
      </InertiaLink>

      <div class="popup-content" v-if="popupServices">
        <InertiaLink :href="'/forms/travel-form-request'" class="link">
          <span>Request Travel Application</span>
        </InertiaLink>
        <InertiaLink :href="'/forms/leave-form-request'" class="link">
          <span>Request Leave Application</span>
        </InertiaLink>
      </div>

      <div @click="showServices">
        <i class="fa-solid fa-screwdriver-wrench fa-2x"></i>
      </div>
    </div>
  </footer>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  name: "Footer",

  components: {
    InertiaLink,
  },

  data() {
    return {
      popupServices: false,
    };
  },
  methods: {
    showServices() {
      this.popupServices = !this.popupServices;
    },
  },
};
</script>

<style scoped>
i {
  color: #fff;
  opacity: 60%;
}

i:hover {
  opacity: 100%;
}
.popup-container {
  position: relative;
  display: inline-block;
}

.popup-button {
  background-color: #4caf50;
  color: white;
  padding: 10px 15px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}
.popup-content {
  display: flex;
  flex-direction: column;
  position: fixed;
  bottom: 6rem;
  left: 12rem;
  background-color: #fff;
  padding: 10px;
  border-radius: 5px;
  filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.2));
  gap: 1rem;
}

.popup-content a {
  color: #000;
  text-decoration: none;
}

@media (orientation: landscape) {
  .sticky-footer {
    display: none;
  }
}
footer {
  display: flex;
  position: fixed;
  justify-content: center;
  align-items: center;
  bottom: 0;
  right: 0;
  left: 0;
}
.sticky-footer {
  background: linear-gradient(to right, #083d6b, #0d949b);
  padding: 10px;
  z-index: 50;
}
.nav-btns {
  user-select: none;
  display: flex;
  justify-content: space-between;
  gap: 2.5rem;
  align-items: center;
}

.nav-btns a {
  opacity: 60%;
  filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.2));
}

.nav-btns a:hover {
  opacity: 100%;
}
.icon-center {
  background-color: rgb(65, 142, 224);
  border-radius: 100%;
  padding-top: 10px;
  padding-bottom: 15px;
  padding-right: 10px;
  padding-left: 10px;
  color: #fff;
  opacity: 60%;
}

.icon-center:hover {
  opacity: 100%;
}
</style>
