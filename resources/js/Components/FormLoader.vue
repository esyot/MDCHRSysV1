<script>
export default {
  name: "FormLoader",
  props: {
    message: {
      type: String,
      default: "Loading...",
    },
  },
};
</script>

<template>
  <div class="loader-container">
    <div class="loader"></div>
    <span class="loader-message">{{ message }}</span>
  </div>
</template>

<style scoped>
.loader-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;
}

.loader {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 1s linear infinite;
  margin-bottom: 10px;
}

.loader-message {
  font-size: 14px;
  color: #3498db;
  font-weight: bold;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
