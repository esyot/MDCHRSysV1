import { router } from "@inertiajs/vue3";

export default {
    data() {
        return {
            user: {
                value: "",
                errorMessage: "",
            },
            password: {
                value: "",
                errorMessage: "",
            },
            errorMessage: this.$page?.props?.errorMessage || "",
            loading: false,
            isPasswordVisible: false,
            buttonStyle: {
                transition: "transform 0.3s ease",
            },
        };
    },
    props: {
        responseData: {
            type: Object,
        },
    },
    watch: {
        "user.value": function (newValue) {
            if (newValue && this.password.value) {
                this.buttonStyle = {
                    transition: "transform 0.3s ease",
                    transform: "translate(0, 0)",
                };
            }
        },
        "password.value": function (newValue) {
            if (this.user.value && newValue) {
                this.buttonStyle = {
                    transition: "transform 0.3s ease",
                    transform: "translate(0, 0)",
                };
            }
        },
    },
    methods: {
        async handleLogin() {
            this.errorMessage = "";
            this.loading = true;

            if (this.user.value && this.password.value) {
                try {
                    await router.post("/login-submit", {
                        user: this.user.value,
                        password: this.password.value,
                    });
                } catch (error) {
                    this.errorMessage =
                        "Login failed. Please check your credentials.";
                    console.error("Login error: ", error);
                }
            } else {
                this.errorMessage = "Please enter both username and password.";
            }

            this.loading = false;
        },

        viewPassword() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },

        moveButton(event) {
            if (!this.user.value || !this.password.value) {
                const distance = 500;
                const offsetX = Math.random() * distance - distance / 2;
                const offsetY = Math.random() * distance - distance / 2;

                this.buttonStyle = {
                    transition: "transform 0.2s ease-out",
                    transform: `translate(${offsetX}px, ${offsetY}px)`,
                };
            }
        },
    },
};
