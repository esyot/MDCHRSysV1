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
@import "./css/footer.css";
</style>
