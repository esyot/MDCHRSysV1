import Layout from "@/Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";
import { useToast } from "vue-toastification";
import axios from "axios";

export default {
    layout: Layout,
    components: {
        ConfirmationFormModal,
    },
    props: {
        user: Object,
        roles: Array,
        formDataToEdit: Object,
        terms: Array,
        api_key: String,
        errors: Object,
    },
    mounted() {
        this.fetchSubjects();
    },

    data() {
        return {
            formDataToEditCopy: this.formDataToEdit ?? null,
            formData: {
                term_id: "",
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
            teachers: [],
            subjects: [],
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

        "formData.term_id"(newVal) {
            if (newVal) {
                this.fetchSubjects();
            }
        },
    },

    methods: {
        submit() {
            if (this.isSubstitute) {
                this.validateSubstitutes();
            } else {
                this.toggleConfirmForm();
            }
        },
        validateSubstitutes() {
            const toast = useToast();

            let isValidatedDays = true;
            let isValidatedUsers = true;
            let isValidatedTimeStartAndEnd = true;

            this.teachingSubstitutes.forEach((substitute) => {
                if (!substitute.user_id) {
                    isValidatedUsers = false;
                }
            });

            this.teachingSubstitutes.forEach((substitute) => {
                if (!substitute.days || substitute.days.length === 0) {
                    isValidatedDays = false;
                }
            });

            this.teachingSubstitutes.forEach((substitute) => {
                const end_time = substitute.end_time;
                const start_time = substitute.start_time;

                const convertTimeToMinutes = (time) => {
                    const [hours, minutes] = time.split(":").map(Number);
                    return hours * 60 + minutes;
                };

                const start_time_in_minutes = convertTimeToMinutes(start_time);
                const end_time_in_minutes = convertTimeToMinutes(end_time);

                if (start_time_in_minutes > end_time_in_minutes) {
                    isValidatedTimeStartAndEnd = false;
                }
            });

            if (!isValidatedDays) {
                toast.error(
                    "At least one day must be selected for each substitute!",
                    {
                        position: "top-center",
                        duration: 3000,
                    },
                );
            }

            if (!isValidatedUsers) {
                toast.error("Please select a valid teacher!", {
                    position: "top-center",
                    duration: 3000,
                });
            }

            if (!isValidatedTimeStartAndEnd) {
                toast.error(
                    "Time start must be greater than or equal to the time end!",
                    {
                        position: "top-center",
                        duration: 3000,
                    },
                );
            }

            if (
                isValidatedDays &&
                isValidatedUsers &&
                isValidatedTimeStartAndEnd
            ) {
                this.toggleConfirmForm();
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
        },

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
            const form = new FormData();

            if (this.formData.medical_certificate) {
                form.append(
                    "medical_certificate",
                    this.formData.medical_certificate,
                );
            }

            for (const key in this.formData) {
                if (this.formData.hasOwnProperty(key)) {
                    form.append(key, this.formData[key]);
                }
            }

            if (this.formDataToEditCopy) {
                form.append("form_id", this.formDataToEditCopy.id);
                form.append("user_id", this.formDataToEditCopy.user_id);
            }

            if (this.teachingSubstitutes.length > 0) {
                form.append(
                    "substitutes",
                    JSON.stringify(this.teachingSubstitutes),
                );
            }

            const toast = useToast();

            router.post("/leave-form-submit", form, {
                onSuccess: () => {
                    toast.success("Leave form submitted successfully", {
                        position: "top-center",
                        timeout: 5000,
                    });
                    this.toggleConfirmForm();

                    localStorage.removeItem("leaveFormData");

                    Inertia.visit("/forms/tracking");
                },

                onError: () => {
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
                    .get(`/teachers/search/${value}`)
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
        toggleConfirmForm() {
            this.isConfirmation = !this.isConfirmation;
        },

        fetchCondition(term) {
            this.isDisplaySuggestion = true;
            axios
                .get(
                    `https://clinicaltables.nlm.nih.gov/api/conditions/v3/search`,
                    {
                        params: { terms: term },
                    },
                )
                .then((response) => response.data[3]?.flat() || [])
                .then((data) => (this.suggestions = data))
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
