import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

export default {
    name: "Authentication",
    data() {
        return {
            password: "",
        };
    },
    methods: {
        authCheckSubmit() {
            const toast = useToast();

            router.post(
                "/authentication-check",
                {
                    password: this.password,
                },
                {
                    onSuccess: (response) => {
                        const message = response.props.success;

                        if (message) {
                            toast.success(message, {
                                position: "top-center",
                            });
                        }
                    },

                    onError: (errors) => {
                        toast.error(errors.password, {
                            position: "top-center",
                        });
                    },
                },
            );
        },
    },
};
