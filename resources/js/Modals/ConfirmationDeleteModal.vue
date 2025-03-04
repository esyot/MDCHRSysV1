<script>
export default {
  emits: ["deleteForm", "toggleDeleteForm"],
  props: {
    isDelete: Boolean,
    selected_id: String,
    selected_type: String,
  },

  methods: {
    deleteForm() {
      this.$emit("deleteForm");
    },
    toggleDeleteForm() {
      this.$emit("toggleDeleteForm");
    },
  },
};
</script>
<template>
  <div class="modal" @click.self="toggleDeleteForm">
    <div class="modal-content">
      <text>Are you sure you want to delete this form?</text>

      <div class="modal-buttons">
        <button @click="toggleDeleteForm()" class="no-btn">No</button>
        <button @click="deleteForm" class="yes-btn">Yes</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  inset: 0;
  z-index: 100;
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}

.modal-content text {
  font-size: 1.2rem;
}

.modal-buttons {
  margin-top: 20px;
  display: flex;
  justify-content: end;
  gap: 0.3rem;
}

.modal-buttons button {
  padding: 10px;
  opacity: 60%;
}

.modal-buttons button:hover {
  opacity: 100%;
  cursor: pointer;
}

.yes-btn {
  background-color: #ff0000;
  color: white;
  border: none;
  border-radius: 5px;
}

.no-btn {
  border: 1px solid #ff0000;
  color: #ff0000;
  border-radius: 5px;
}
</style>
