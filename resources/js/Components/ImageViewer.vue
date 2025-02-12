<script>
export default {
  emits: ["toggleLargeImgViewer"],
  props: {
    src: String,
  },
  methods: {
    toggleLargeImgViewer(src) {
      this.$emit("toggleLargeImgViewer", src);
    },
  },
};
</script>

<template>
  <div class="modal" @click.self="toggleLargeImgViewer(src)">
    <div class="modal-content">
      <img :src="src" alt="" />
    </div>
  </div>
</template>

<style scoped>
.modal {
  display: flex;
  position: fixed;
  inset: 0;
  justify-content: center;
  align-items: center;
  z-index: 100;
}

.modal-content {
  background-color: #fff;
  margin: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  max-width: 90%;
  max-height: 90%;
  overflow: hidden;
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.3);
}

.modal-content img {
  width: 100%;
  height: auto;
}

@media (max-width: 768px) {
  .modal-content {
    max-width: 100%;
    max-height: 80%;
  }

  .modal-content img {
    width: 100%;
    height: auto;
  }
}

@media (min-width: 769px) {
  .modal-content {
    width: 600px;
    height: auto;
  }

  .modal-content img {
    width: 100%;
    height: auto;
  }
}
</style>
