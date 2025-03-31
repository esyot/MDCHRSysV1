import { router } from "@inertiajs/vue3";
export default {
    data() {
        return {
            code: "",
        };
    },
    props: {
        user: Object,
        error: String,
    },

    methods: {
        verificationSubmit() {
            router.post("/verification-submit", {
                code: this.code,
            });
        },
    },
};
