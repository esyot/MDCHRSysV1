import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

export default {
    emits: ["toggleFormModal"],
    props: {
        formData: Object,
        selected_id: String,
        selected_type: String,
        roles: Array,
    },
    data() {
        return {
            action: "",
            isConfirmation: false,
            currentYear: new Date().getFullYear(),
            forms: [],
            fetchedDataCache: [],
            fetchInProgress: [],
            fetchedYear: "",
            submission_type: "approval",
            disapproval_description: null,
        };
    },
    methods: {
        formatDate(date) {
            const convertedDate = new Date(date);
            const options = {
                month: "short",
                day: "numeric",
                year: "numeric",
            };
            return convertedDate.toLocaleDateString("en-US", options);
        },
        toggleFormModal() {
            this.$emit("toggleFormModal");
        },

        submitForm() {
            const formData = {
                id: this.formData.id,
                user_id: this.formData.user_id,
                form_type: this.formData.form_type,
                action: this.action,
                disapproval_description: this.disapproval_description,
            };

            const toast = useToast();

            router.put("/forms/checking/forward", formData, {
                onSuccess: (response) => {
                    toast.success(response.props.success, {
                        position: "top-center",
                        duration: 3000,
                    });

                    this.toggleConfirmForm(this.action);
                    this.toggleFormModal();
                },
                onError(erorrs) {
                    toast.error(erorrs.error, {
                        position: "top-center",
                        duration: 3000,
                    });

                    this.toggleConfirmForm(this.action);
                    this.toggleFormModal();
                },
            });
        },
        toggleConfirmForm(action) {
            this.action === action
                ? (this.action = null)
                : (this.action = action);
            this.isConfirmation = !this.isConfirmation;
        },

        calculateAvailableTravel(date) {
            const date_today = new Date();
            const year_today = date_today.getFullYear();
            const year_provided = new Date(date).getFullYear();
            const yearDiff = year_today - year_provided;

            return yearDiff >= 10 ? 10 : yearDiff;
        },

        fetchTravelForm(user_id, year) {
            fetch(`/forms/find/${this.formData.form_type}/${user_id}/${year}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    this.forms = data ?? null;
                    this.fetchedDataCache[user_id] = data;
                    this.fetchInProgress[user_id] = false;
                    this.fetchedYear = year;
                })
                .catch((error) => {
                    console.error("Error fetching leave forms:", error);
                    this.fetchInProgress[user_id] = false;
                });
        },
        fetchTraveledDays(term) {
            const currentYear = this.currentYear;
            let count = 0;

            if (term === "1st") {
                count = this.forms
                    .filter(
                        (form) =>
                            form.semister === "1st" &&
                            new Date(form.date_start).getFullYear() ===
                                currentYear,
                    )
                    .reduce(
                        (total, form) =>
                            total +
                            this.calculateDays(form.date_start, form.date_end),
                        0,
                    );
            } else if (term === "2nd") {
                count = this.forms
                    .filter(
                        (form) =>
                            form.semister === "2nd" &&
                            new Date(form.date_start).getFullYear() ===
                                currentYear,
                    )
                    .reduce(
                        (total, form) =>
                            total +
                            this.calculateDays(form.date_start, form.date_end),
                        0,
                    );
            } else if (term === "summer") {
                count = this.forms
                    .filter(
                        (form) =>
                            form.semister === "summer" &&
                            new Date(form.date_start).getFullYear() ===
                                currentYear,
                    )
                    .reduce(
                        (total, form) =>
                            total +
                            this.calculateDays(form.date_start, form.date_end),
                        0,
                    );
            }

            return count;
        },
        calculateDays(date_start, date_end) {
            const start = new Date(date_start);
            const end = new Date(date_end);
            const diff = Math.abs(end - start);
            const days = Math.ceil(diff / (1000 * 60 * 60 * 24));

            return days + 1;
        },
    },
    mounted() {
        this.fetchTravelForm(this.formData.user_id, this.currentYear);
    },
    watch: {
        submission_type(newVal) {
            this.disapproval_description = null;
        },
    },
};
