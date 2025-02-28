<template>
  <div class="scroll-container">
    <div class="scrollable-content" ref="scrollableContent">
      <!-- Dynamically render page components -->
      <div class="page" v-for="(page, index) in pages" :key="index">
        <component :is="page"></component>
      </div>
    </div>
    <div class="navigation-buttons">
      <button @click="prevPage" :disabled="currentPage === 0">Previous</button>
      <button @click="nextPage" :disabled="currentPage === pages.length - 1">Next</button>
    </div>
  </div>
</template>

<script>
import Page1 from "./Pages/Page1.vue";
import Page2 from "./Pages/Page2.vue";
import Page3 from "./Pages/Page3.vue";
import Page4 from "./Pages/Page4.vue";

export default {
  data() {
    return {
      currentPage: 0, // Start on the first page
      pages: [Page1, Page2, Page3, Page4], // Array of page components
    };
  },
  methods: {
    prevPage() {
      if (this.currentPage > 0) {
        this.currentPage -= 1;
        this.scrollToPage(this.currentPage);
      }
    },
    nextPage() {
      if (this.currentPage < this.pages.length - 1) {
        this.currentPage += 1;
        this.scrollToPage(this.currentPage);
      }
    },
    scrollToPage(pageIndex) {
      const scrollableContent = this.$refs.scrollableContent;
      const page = scrollableContent.children[pageIndex];
      scrollableContent.scrollTo({
        left: page.offsetLeft,
        behavior: "smooth",
      });
    },
  },
};
</script>

<style scoped>
::-webkit-scrollbar {
  width: 5px;
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
.scroll-container {
  display: flex;
  overflow-y: hidden;
  background-color: #555;
  overflow-y: hidden;
}

.scrollable-content {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  overflow-y: hidden;
}

.page {
  min-width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 10px;
  box-sizing: border-box;
}

.navigation-buttons {
  display: flex;
  position: fixed;
  right: 0;
  left: 0;
  margin-inline: 100px;
  padding: 10px;
  bottom: 0;
  justify-content: space-between;
  margin-top: 20px;
}

button {
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
