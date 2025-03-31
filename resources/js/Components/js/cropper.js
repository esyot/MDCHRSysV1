import Cropper from "cropperjs";
import "cropperjs/dist/cropper.min.css";
import { router } from "@inertiajs/vue3";

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

                router.post("/upload-cropped-profile-pic", {
                    image: this.croppedImage,
                });

                this.successMessage = this.messageSuccess;

                this.closeModal();
            }
        },
    },
};
