import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";

export default {
    layout: Layout,
    components: {
        ConfirmationFormModal,
    },
    props: {
        budgetTypes: Object,
        budgetCharges: Object,
        formDataToEdit: Object,
        roles: Array,
    },
    data() {
        return {
            formDataToEditCopy: this.formDataToEdit ?? null,
            formData: {
                date_start: "",
                date_end: "",
                destination: "",
                purpose: "",
                contact_person: "",
                contact_person_no: "",
                description: "",
                term: "",
                amount: "",
                budget_type: "",
                budget_charged_to: "",
                othersReason: "",
                class_alternatives_description: "",
            },

            teachingSubstitutes: [],
            days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            searchTeacher: false,
            filteredUsers: this.users,
            isConfirmation: false,
            isSubstitute: false,
            suggestions: [],
            isDisplaySuggestion: false,
            users: [],
            message: "Are you sure you want to submit?",
        };
    },
    created() {
        if (this.formDataToEditCopy) {
            const obj = this.formDataToEditCopy;
            if (obj && typeof obj === "object") {
                const {
                    user_id,
                    id,
                    status,
                    recommended_by,
                    endorsed_by,
                    disapproved_by,
                    disapproval_description,
                    created_at,
                    updated_at,
                    substitutes,
                    days_with_pay,
                    days_without_pay,
                    others,
                    ...rest
                } = obj;

                const filteredObject = { ...rest };
                this.formData = filteredObject;

                if (this.formDataToEditCopy.substitutes.length > 0) {
                    this.isSubstitute = true;
                    this.teachingSubstitutes =
                        this.formDataToEditCopy.substitutes;
                } else {
                    this.isSubstitute = false;
                }
            }
        } else if (typeof localStorage !== "undefined") {
            const savedData = JSON.parse(
                localStorage.getItem("travelFormData"),
            );
            if (savedData) {
                this.formData = savedData.formData || this.formData;
                this.teachingSubstitutes =
                    savedData.teachingSubstitutes || this.teachingSubstitutes;

                this.budget = savedData.budget || this.budget;

                this.isSubstitute = savedData.isSubstitute || this.isSubstitute;
            }
        }
    },
    methods: {
        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },
        storeToLocalStorage() {
            const dataToStore = {
                formData: this.formData,
                budget: this.budget,
                teachingSubstitutes: this.teachingSubstitutes,
                isSubstitute: this.isSubstitute,
            };
            localStorage.setItem("travelFormData", JSON.stringify(dataToStore));
        },
        addTeachingSubstitute() {
            const newSubstitute = {
                subject: "",
                user_id: "",
                teacher: "",
                days: [],
                start_time: "",
                end_time: "",
            };

            this.teachingSubstitutes.push(newSubstitute);
        },
        removeTeachingSubstitute(index) {
            this.teachingSubstitutes.splice(index, 1);
        },
        submitForm() {
            const formData = {
                form_id: this.formDataToEdit.id,
                date_start: this.formData.date_start,
                date_end: this.formData.date_end,
                description: this.formData.description,
                destination: this.formData.destination,
                purpose: this.formData.purpose,
                contact_person: this.formData.contact_person,
                contact_person_no: this.formData.contact_person_no,
                amount: this.formData.amount,
                budget_type: this.formData.budget_type,
                budget_charged_to: this.formData.budget_charged_to,
                filing_date:
                    this.formData.filing_date ??
                    new Date().toISOString().split("T")[0],
                class_alternatives_description:
                    this.formData.class_alternatives_description,
            };

            Inertia.post(
                "/forms/travel-form-submit",
                {
                    formData: formData,
                    substitutes: JSON.stringify(this.teachingSubstitutes),
                },
                {
                    onSuccess: () => {
                        this.isConfirmation = !this.isConfirmation;
                        localStorage.removeItem("formData");
                    },
                },
            );
        },
        toggleSearchTeacher(value, index) {
            this.searchTeacher = true;

            if (value) {
                fetch(`/users/search/${value}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! Status: ${response.status}`,
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (Array.isArray(data)) {
                            this.users = data.length > 0 ? data : [];
                        } else {
                            this.users = [];
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching users:", error);
                        this.users = [];
                    });

                this.teachingSubstitutes[index].user_id = "";
            } else {
                this.searchTeacher = false;
            }
        },

        selectTeacher(id, index) {
            const user = this.users.find((user) => user.id === id);
            if (user) {
                this.teachingSubstitutes[index].user_id = `${id}`;
                this.teachingSubstitutes[index].teacher =
                    `${user.last_name}, ${user.first_name}`;
            }
            this.searchTeacher = false;
        },
        fetchPlaceSuggestions(term) {
            this.isDisplaySuggestion = true;
            fetch(
                `https://nominatim.openstreetmap.org/search?q=${term}&format=json&limit=5&addressdetails=1`,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                },
            )
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! Status: ${response.status}`,
                        );
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data && Array.isArray(data)) {
                        this.suggestions = data.map(
                            (place) => place.display_name,
                        );
                    } else {
                        this.suggestions = [];
                    }
                })
                .catch((error) => {
                    console.error("Error fetching place suggestions:", error);
                    this.suggestions = [];
                });
        },
        selectedSuggestion(suggestion) {
            this.isDisplaySuggestion = false;
            this.formData.destination = suggestion;
        },
    },
    watch: {
        formData: {
            handler() {
                this.storeToLocalStorage();
            },
            deep: true,
        },
        budget: {
            handler() {
                this.storeToLocalStorage();
            },
            deep: true,
        },
        teachingSubstitutes: {
            handler() {
                this.storeToLocalStorage();
            },
            deep: true,
        },
        isSubstitute: {
            handler() {
                this.storeToLocalStorage();
            },
            deep: true,
        },
    },
};
