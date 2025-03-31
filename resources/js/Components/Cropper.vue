<script src="./js/cropper.js"></script>

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

<style scoped>
@import "./css/cropper.css";
</style>
