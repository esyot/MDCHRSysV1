<template>
  <div>
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <label for="">Crop Image</label>
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

        this.closeModal();
      }
    },
  },
};
</script>

<style scoped>
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 10px;
  padding: 3px;
}

.modal-header label {
  font-size: 22px;
  font-weight: bold;
}
.modal-header span {
  font-size: 24px;
  font-weight: bold;
  padding-right: 5px;
  cursor: pointer;
  opacity: 50%;
}

.modal-header span:hover {
  opacity: 100;
}
.buttons {
  display: flex;
  justify-content: end;
  padding: 10px;
  gap: 0.3rem;
}
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  border-radius: 8px;
  width: 80%;
  max-width: 600px;
}

.modal-content-items {
  padding: 10px;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 28px;
  cursor: pointer;
}

.buttons .cancel-btn {
  background-color: rgb(223, 50, 50);
}
button {
  margin-top: 20px;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.preview-container {
  margin-top: 20px;
  text-align: center;
}

.cropped-preview {
  max-width: 100%;
  max-height: 300px;
  margin-top: 10px;
}
</style>
