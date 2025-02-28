<template>
  <div class="scroll-container">
    <div class="scrollable-content" ref="scrollableContent">
      <div class="page" v-for="(page, index) in pages" :key="index">
        <component :is="page" :personalDetails="personalDetails"></component>
      </div>
    </div>
    <div class="navigation-buttons">
      <button @click="prevPage" :disabled="currentPage === 0">Previous</button>
      <button @click="printPage">Print Page</button>
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
  props: {
    personalDetails: Object,
  },
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
    printPage() {
      const content = this.$refs.scrollableContent;
      const printWindow = window.open("", "", "height=600,width=800");

      // Inject the styles from the current document into the print window
      const styles = document.querySelectorAll('style, link[rel="stylesheet"]');
      let stylesString = "";
      styles.forEach((style) => {
        if (style.tagName.toLowerCase() === "style") {
          stylesString += `<style>${style.innerHTML}</style>`;
        } else if (style.tagName.toLowerCase() === "link") {
          stylesString += `<link rel="stylesheet" type="text/css" href="${style.href}">`;
        }
      });

      // Open the print window and write the content and styles
      printWindow.document.write(
        "<html><head><title>Print Page</title>" + stylesString + "</head><body>"
      );
      printWindow.document.write(content.innerHTML); // Copy content to the print window
      printWindow.document.write("</body></html>");
      printWindow.document.close();
      printWindow.print();
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

  background-color: #555;
  overflow-y: hidden;
}

.scrollable-content {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
}

.page {
  margin-top: 20px;
  margin-bottom: 20px;
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
