import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { useToast } from "vue-toastification";
import axios from "axios";

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
        terms: Object,
        errors: Object,
    },

    data() {
        return {
            formDataToEditCopy: this.formDataToEdit ?? null,
            formData: {
                term_id: "",
                date_start: "",
                date_end: "",
                destination: "",
                purpose: "",
                contact_person: "",
                contact_person_no: "",
                description: "",
                amount: "",
                budget_type: "",
                budget_charged_to: "",
                othersReason: "",
                class_description: "",
            },

            teachingSubstitutes: [],
            days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            searchTeacher: false,
            filteredUsers: this.users,
            isConfirmation: false,
            isSubstitute: false,
            suggestions: [],
            isDisplaySuggestion: false,
            teachers: [],
            subjects: [],
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
        validateForm() {
            let isValidated = true;

            this.teachingSubstitutes.forEach((substitute) => {
                if (!substitute.days || substitute.days.length === 0) {
                    isValidated = false;
                }
            });

            if (!isValidated) {
                const toast = useToast();
                toast.error(
                    "At least one day must be selected for each substitute!",
                    {
                        position: "top-center",
                        duration: 3000,
                    },
                );
            } else {
                this.toggleConfirmForm();
            }
        },
        validateDays(index) {
            const substitute = this.teachingSubstitutes[index];
            if (!substitute.days || substitute.days.length === 0) {
                substitute.daysError = true;
            } else {
                substitute.daysError = false;
            }
        },
        isSubjectDisabled(subject_id) {
            if (
                this.teachingSubstitutes.some(
                    (substitute) => substitute.subject_id === subject_id,
                )
            ) {
                return true;
            } else {
                return false;
            }
        },
        fetchSubjects() {
            try {
                axios
                    .get(`/api/hr/subject-classes`, {
                        params: {
                            term_id: this.formData.term_id,
                        },
                    })
                    .then((response) => {
                        this.subjects = response.data;
                    })
                    .catch((error) => {
                        console.error("error fetching data:", error);
                    });
            } catch (error) {
                console.error("error method:", error);
            }
        },
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
                subject_id: "",
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
            let formData = new FormData();

            if (this.formDataToEdit) {
                formData.append("form_id", this.formDataToEdit.id);
            }

            formData.append("term_id", this.formData.term_id);
            formData.append("date_start", this.formData.date_start);
            formData.append("date_end", this.formData.date_end);
            formData.append("description", this.formData.description);
            formData.append("destination", this.formData.destination);
            formData.append("purpose", this.formData.purpose);
            formData.append("contact_person", this.formData.contact_person);
            formData.append(
                "contact_person_no",
                this.formData.contact_person_no,
            );
            formData.append("amount", this.formData.amount);
            formData.append("budget_type", this.formData.budget_type);
            formData.append(
                "budget_charged_to",
                this.formData.budget_charged_to,
            );
            formData.append(
                "filing_date",
                this.formData.filing_date ??
                    new Date().toISOString().split("T")[0],
            );
            formData.append(
                "class_description",
                this.formData.class_description,
            );

            formData.append(
                "substitutes",
                JSON.stringify(this.teachingSubstitutes),
            );

            const toast = useToast();

            Inertia.post("/forms/travel-form-submit", formData, {
                onSuccess: () => {
                    toast.success("Form submitted successfully", {
                        position: "top-center",
                    });

                    this.toggleConfirmForm();

                    localStorage.removeItem("travelFormData");

                    Inertia.visit("/forms/tracking");
                },
                onError: (errors) => {
                    this.toggleConfirmForm();
                    toast.error(
                        "There was an error submitting the form. Please check the fields.",
                        {
                            position: "top-center",
                            duration: 3000,
                        },
                    );
                },
            });
        },
        toggleSearchTeacher(value, index) {
            this.searchTeacher = true;

            if (value) {
                axios
                    .get(`/teachers/search/${value}`, {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    })
                    .then((response) => {
                        const data = response.data;
                        if (Array.isArray(data)) {
                            this.teachers = data.length > 0 ? data : [];
                        } else {
                            this.teachers = [];
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching users:", error);
                        this.teachers = [];
                    });

                this.teachingSubstitutes[index].user_id = "";
            } else {
                this.searchTeacher = false;
            }
        },
        selectTeacher(id, index) {
            const teacher = this.teachers.find((teacher) => teacher.id === id);
            if (teacher) {
                this.teachingSubstitutes[index].user_id = `${id}`;
                this.teachingSubstitutes[index].teacher =
                    `${teacher.last_name}, ${teacher.first_name}`;
            }
            this.searchTeacher = false;
        },

        fetchPlaceSuggestions(term) {
            this.isDisplaySuggestion = true;

            axios
                .get("https://nominatim.openstreetmap.org/search", {
                    params: {
                        q: term,
                        format: "json",
                        limit: 5,
                        addressdetails: 1,
                    },
                })
                .then(({ data }) => {
                    this.suggestions = Array.isArray(data)
                        ? data.map((place) => place.display_name)
                        : [];
                })
                .catch(() => {
                    console.error("Error fetching place suggestions");
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

        "formData.term_id"(newVal) {
            if (newVal) {
                this.fetchSubjects();
            }
        },
    },
};
