<template>
  <div>
    <div v-if="showModal" class="modal" @click.self="closeModal">
      <div class="modal-content">
        <div class="modal-header">
          <label for="">{{ !imageUrl ? "Upload Image" : "Crop image" }}</label>
          <span @click="closeModal" title="Close Croppper">&times;</span>
        </div>
        <div class="modal-content-items">
          <input
            :type="!croppedImage ? 'file' : 'hidden'"
            @change="onImageChange"
            accept="image/*"
          />

          <div v-if="imageUrl && !croppedImage">
            <img
              ref="image"
              :src="imageUrl"
              alt="Image to crop"
              style="max-width: 100%"
            />
          </div>

          <div v-if="croppedImage" class="preview-container">
            <img :src="croppedImage" alt="Cropped Image" class="cropped-preview" />
          </div>

          <div class="buttons">
            <button v-if="imageUrl && !croppedImage" @click="cropImage">
              Crop Image
            </button>
            <button v-if="croppedImage" @click="closeModal" class="cancel-btn">
              Cancel
            </button>

            <button v-if="croppedImage" @click="submitCroppedImage">Upload Image</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.min.css";
import { Inertia } from "@inertiajs/inertia";

export default {
  props: {
    showModal: Boolean,
    currentImage: String,
  },
  data() {
    return {
      imageUrl: null,
      croppedImage: null,
      cropper: null,
    };
  },
  watch: {
    showModal(newVal) {
      if (!newVal && this.cropper) {
        this.closeModal();
      }
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
      if (this.cropper) {
        this.cropper.destroy();
        this.cropper = null;
      }
      this.imageUrl = null;
      this.croppedImage = null;
    },
    onImageChange(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imageUrl = e.target.result;
          this.$nextTick(() => {
            if (this.cropper) {
              this.cropper.destroy();
            }

            this.cropper = new Cropper(this.$refs.image, {
              aspectRatio: 1,
              viewMode: 1,
              autoCropArea: 0.5,
              responsive: true,
            });
          });
        };
        reader.readAsDataURL(file);
      }
    },
    cropImage() {
      if (this.cropper) {
        const canvas = this.cropper.getCroppedCanvas();

        if (canvas) {
          this.croppedImage = canvas.toDataURL();
          this.cropper.destroy();
          this.cropper = null;
        }
      }
    },
    submitCroppedImage() {
      if (this.croppedImage) {
        this.$emit("update-image", this.croppedImage);

        Inertia.post("/upload-cropped-profile-pic", {
          image: this.croppedImage,
        });

        this.successMessage = this.messageSuccess;

        this.closeModal();
      }
    },
  },
};
</script>

<style scoped>
@import "./css/cropper.css";
</style>
