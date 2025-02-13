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
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.3);
  border-radius: 5px;
}

.modal-content img {
  width: 450px;
  box-sizing: border-box;
  border-radius: 10px;
  padding-inline: 20px;
}
</style>
