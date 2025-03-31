import bcrypt from "bcryptjs";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

export default {
    name: "Security",
    props: {
        user: Object,
        userCredentials: Object,
    },
    data() {
        return {
            is_two_step_verification: "",
            is_update_with_email: "",
            old_password: "",
            localUserCredentials: { ...this.user },
            isPassword: false,
            isAccountFormComplete: false,
            new_password_1: "",
            new_password_2: "",
            isNewPasswordEqual: false,
            passwordLength: false,
            passwordUpperLowerCase: false,
            passwordSpecialChar: false,
            passwordValidated: false,
            newPasswordChecked: false,
        };
    },
    watch: {
        userCredentials: {
            handler(newVal) {
                this.userCredentials.username = newVal.username || "";
            },
            immediate: true,
        },
        new_password_1(newValue) {
            this.passwordUpperLowerCase =
                /[a-z]/.test(newValue) && /[A-Z]/.test(newValue);

            this.passwordLength = newValue.length > 8;

            this.passwordSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(newValue);

            if (
                this.passwordUpperLowerCase &&
                this.passwordLength &&
                this.passwordSpecialChar
            ) {
                this.passwordValidated = true;
            } else {
                this.passwordValidated = false;
            }
        },
        old_password(newValue) {
            this.checkOldPassword();
        },

        new_password_2(newValue) {
            this.PasswordCompare();
        },
    },
    methods: {
        async checkOldPassword() {
            const isMatch = await bcrypt.compare(
                this.old_password,
                this.user.password,
            );

            if (isMatch) {
                this.isPassword = true;
            } else {
                this.isPassword = false;
            }
        },

        PasswordCompare() {
            if (this.new_password_1 === this.new_password_2) {
                this.isNewPasswordEqual = true;
            } else {
                this.isNewPasswordEqual = false;
            }
        },

        accountSettingFormSubmit() {
            const data = {
                email: this.user.email,
                password: this.new_password_2,
            };

            this.old_password = "";
            this.new_password_1 = "";
            this.new_password_2 = "";
            this.isNewPasswordEqual = false;

            const toast = useToast();

            router.put("/user-account-setting-update", data, {
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
            });
        },

        accountFeatureSettingSubmit(event) {
            const formData = new FormData(event.target);
            router.post("/user-account-feature-update", formData);
        },
    },
};
