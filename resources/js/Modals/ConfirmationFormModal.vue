<script>
export default {
  name: "ConfirmationFormModal",
  emits: ["submitForm", "toggleConfirmForm"],
  props: {
    confirmation_submission: Boolean,
  },
  methods: {
    submitForm() {
      this.$emit("submitForm");
    },

    toggleConfirmForm() {
      this.$emit("toggleConfirmForm");
    },
  },
};
</script>

<template>
  <div
    class="confirmation-modal"
    v-if="confirmation_submission"
    @click.self="toggleConfirmForm"
  >
    <div class="confirmation-modal-content">
      <text>Are you sure you want to submit?</text>
      <div class="confirmation-modal-btn">
        <button @click="toggleConfirmForm" class="no-btn">No</button>
        <button @click="submitForm" class="yes-btn">Yes</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.confirmation-modal {
  display: flex;
  position: fixed;
  inset: 0;
  z-index: 100;
  justify-content: center;
  align-items: center;
  background-color: rgba(255, 0, 0, 0);
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
}

.confirmation-modal-content {
  display: flex;
  border-radius: 5px;
  flex-direction: column;
  background-color: #fff;
  border: 1px solid #7a7a7a;
  box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.3);
}

.confirmation-modal-content text {
  margin: 12px;
  padding: 5px;
  font-size: 16pt !important;
}

.confirmation-modal-btn {
  margin: 10px;
  display: flex;
  justify-content: end;
  gap: 0.2rem;
}

.confirmation-modal-btn button {
  padding: 10px;
  border-radius: 5px;
  border: none;
  opacity: 50%;
  color: #fff;
}

.confirmation-modal-btn .no-btn {
  background-color: #8a8a8a;
  padding-inline: 12px;
}

.confirmation-modal-btn .yes-btn {
  background-color: rgb(41, 108, 242);
}

.confirmation-modal-btn button:hover {
  cursor: pointer;
  opacity: 100%;
}
</style>
