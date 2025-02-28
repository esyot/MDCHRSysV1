<template>
  <div class="success-modal" @click.self="closeSuccessModal">
    <div class="success-modal-content">
      <div class="success-modal-icon">
        <i class="fas fa-circle-check fa-3x"></i>
      </div>

      <div class="message-content">
        <span>{{ successMessage }}</span>
      </div>
      <button @click="closeSuccessModal">Close</button>
    </div>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "SuccessModal",
  props: {
    successMessage: String,
  },
  methods: {
    closeSuccessModal() {
      Inertia.get("/success-session-remove");
    },
  },
};
</script>
<style scoped>
.success-modal {
  display: flex;
  position: fixed;
  align-items: center;
  justify-content: center;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.2);
  z-index: 100;
}

.success-modal-content {
  background-color: #fff;
  border-radius: 5px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);
  border: 1px solid rgb(200, 200, 200);
}

.success-modal-content button {
  border: none;
  padding: 10px;
  background-color: rgb(37, 174, 92);
  color: rgb(229, 255, 229);
  border-radius: 5px;
  opacity: 70%;
  cursor: pointer;
}

.success-modal-content button:hover {
  opacity: 100%;
}

.success-modal-icon i {
  color: rgb(25, 186, 25);
}
</style>
