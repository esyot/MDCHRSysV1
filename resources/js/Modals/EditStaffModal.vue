<script>
import ConfirmationFormModal from "./ConfirmationFormModal.vue";
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "vue-toastification";
export default {
  emits: ["toggleEditStaff"],
  props: {
    user_id: String,
    staff: Object,
    positionList: Array,
  },
  components: {
    ConfirmationFormModal,
  },

  data() {
    return {
      formData: {
        position: this.staff.position ?? "",
        date_hired: this.staff.date_hired ?? "",
      },
      isConfirmation: false,
      message: "Are you sure to update staff details?",
    };
  },
  methods: {
    closeModal() {
      this.$emit("toggleEditStaff");
    },
    submitForm() {
      this.toggleConfirmForm();
      this.closeModal();

      const toast = useToast();

      Inertia.put(
        `/users/staff/edit-details`,
        {
          staff_id: this.staff.id,
          formData: this.formData,
        },
        {
          onSuccess: (response) => {
            toast.success(response.props.success, {
              position: "top-center",
              duration: 3000,
            });
          },

          onError: (errors) => {
            toast.error(errors.error, {
              position: "top-center",
              duration: 3000,
            });
          },
        }
      );
    },

    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
  },
};
</script>

<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>

  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <span>Edit Staff Details</span>
        <i @click="closeModal">&times;</i>
      </div>

      <div class="input-group">
        <label for="position">Position: </label>
        <input
          type="text"
          id="position"
          name="position"
          list="positionList"
          v-model="formData.position"
        />
        <datalist id="positionList">
          <option
            :value="position"
            v-for="(position, index) in positionList"
            :key="index"
          >
            {{ position }}
          </option>
        </datalist>
      </div>

      <div class="input-group">
        <label for="date_hired">Date Hired: </label>
        <input
          id="date_hired"
          name="date_hired"
          type="date"
          v-model="formData.date_hired"
        />
      </div>

      <div class="buttons">
        <button @click="closeModal" class="close-btn">Close</button>
        <button @click="toggleConfirmForm()" class="update-btn">Update</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "./css/edit-staff-modal.css";
</style>
