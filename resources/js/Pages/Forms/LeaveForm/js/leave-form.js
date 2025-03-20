import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { useToast } from "vue-toastification";

export default {
    layout: Layout,
    components: {
        ConfirmationFormModal,
    },
    props: {
        roles: Array,
        formDataToEdit: Object,
    },

    data() {
        return {
            formDataToEditCopy: this.formDataToEdit ?? null,
            formData: {
                leave_type: "",
                leave_type_option: "",
                vacation_option: "",
                convalescence_place: "",
                address: "",
                sick_type: "",
                illness: "",
                reason: "",
                other_reason: "",
                description: "",
                date_start: "",
                date_end: "",
                date_of_confinement: "",
                date_of_discharge: "",
                medical_certificate: null,
                class_description: "",
            },
            teachingSubstitutes: [],
            days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            searchTeacher: false,
            filteredUsers: this.users,
            isSubstitute: false,

            isConfirmation: false,
            message: !this.formDataToEdit
                ? "Are you sure you want to submit?"
                : "Are you sure you want to re-submit your application?",
            searchTerm: "",
            suggestions: [],
            loading: false,
            suggestions: "",
            isDisplaySuggestion: false,
            users: [],
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
            const savedData = JSON.parse(localStorage.getItem("leaveFormData"));
            if (savedData) {
                this.formData = savedData.formData || this.formData;
                this.teachingSubstitutes =
                    savedData.teachingSubstitutes || this.teachingSubstitutes;
                this.isSubstitute = savedData.isSubstitute || this.isSubstitute;
            }
        }
    },

    watch: {
        formData: {
            handler(newData) {
                this.saveToLocalStorage();
            },
            deep: true,
        },

        teachingSubstitutes: {
            handler(newSubstitutes) {
                this.saveToLocalStorage();
            },
            deep: true,
        },
        isSubstitute: {
            handler(isSubstitute) {
                this.saveToLocalStorage();
            },
            deep: true,
        },
    },

    methods: {
        saveToLocalStorage() {
            const dataToSave = {
                formData: this.formData,
                teachingSubstitutes: this.teachingSubstitutes,
                isSubstitute: this.isSubstitute,
            };
            localStorage.setItem("leaveFormData", JSON.stringify(dataToSave));
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.formData.medical_certificate = file;
            }
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
            const form = new FormData();
            if (this.formData.medical_certificate) {
                form.append(
                    "medical_certificate",
                    this.formData.medical_certificate,
                );
            }

            form.append(
                "substitutes",
                JSON.stringify(this.teachingSubstitutes),
            );

            for (const key in this.formData) {
                if (this.formData.hasOwnProperty(key)) {
                    form.append(key, this.formData[key]);
                }
            }

            if (this.formDataToEditCopy) {
                form.append("form_id", this.formDataToEditCopy.id);
                form.append("user_id", this.formDataToEditCopy.user_id);
            }

            const toast = useToast();

            Inertia.post("/leave-form-submit", form, {
                onSuccess: () => {
                    toast.success("Leave form submitted successfully", {
                        position: "top-center",
                        timeout: 5000,
                    });
                    this.toggleConfirmForm();

                    localStorage.removeItem("leaveFormData");

                    Inertia.visit("/forms/tracking");
                },
            });
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
        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },

        fetchCondition(term) {
            this.isDisplaySuggestion = true;
            fetch(
                `https://clinicaltables.nlm.nih.gov/api/conditions/v3/search?terms=${term}`,
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
                    if (data && Array.isArray(data) && data[3]) {
                        this.suggestions = data[3].flat();
                    } else {
                        this.suggestions = [];
                    }
                })
                .catch((error) => {
                    console.error("Error fetching suggestions:", error);
                    this.suggestions = [];
                });
        },
        selectedSuggestion(suggestion) {
            this.formData.illness = suggestion;
            this.isDisplaySuggestion = false;
        },
    },
};
