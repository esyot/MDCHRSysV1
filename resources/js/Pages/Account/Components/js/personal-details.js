import Form1 from "@/Pages/Account/Components/Forms/Form1.vue";
import Form2 from "@/Pages/Account/Components/Forms/Form2.vue";
import Form3 from "@/Pages/Account/Components/Forms/Form3.vue";
import Form4 from "@/Pages/Account/Components/Forms/Form4.vue";
import Form5 from "@/Pages/Account/Components/Forms/Form5.vue";
import Form6 from "@/Pages/Account/Components/Forms/Form6.vue";
import Form7 from "@/Pages/Account/Components/Forms/Form7.vue";
import Form8 from "@/Pages/Account/Components/Forms/Form8.vue";
import Form9 from "@/Pages/Account/Components/Forms/Form9.vue";
import Form10 from "@/Pages/Account/Components/Forms/Form10.vue";
import Form11 from "@/Pages/Account/Components/Forms/Form11.vue";
import Form12 from "@/Pages/Account/Components/Forms/Form12.vue";
import Form13 from "@/Pages/Account/Components/Forms/Form13.vue";
import Form14 from "@/Pages/Account/Components/Forms/Form14.vue";
import Form15 from "@/Pages/Account/Components/Forms/Form15.vue";

import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

export default {
    name: "PersonalDetails",
    props: {
        personalDetails: Object,
    },

    components: {
        Form1,
        Form2,
        Form3,
        Form4,
        Form5,
        Form6,
        Form7,
        Form8,
        Form9,
        Form10,
        Form11,
        Form12,
        Form13,
        Form14,
        Form15,
        Link,
    },
    data() {
        return {
            currentPage: parseInt(localStorage.getItem("currentPage")) || 1,
            totalPages: 15,
            editMode: false,
            editModeHasChanged: false,

            userDetails: {
                personal_details: {
                    last_name: "",
                    first_name: "",
                    middle_name: "",
                    name_ext: "",
                    nickname: "",
                    DOB: "",
                    birthplace: "",
                    sex: "",
                    civil_status: "",
                    religion: "",
                    height: "",
                    weight: "",
                    blood_type: "",
                    contact_no: "",
                    citizenship: "",
                    citizenship_type: "",
                    fb_link: "",

                    date_hired: "",
                    rank: "",
                    department: "",
                },

                residential_address: {
                    house_no: "",
                    street: "",
                    subdv: "",
                    brgy: "",
                    municipality: "",
                    province: "",
                    zip_code: "",
                },

                permanent_address: {
                    house_no: "",
                    street: "",
                    subdv: "",
                    brgy: "",
                    municipality: "",
                    province: "",
                    zip_code: "",
                },

                user_job_details: {
                    date_hired: "",
                    department: "",
                    rank: "",
                },

                user_families: {
                    type: "",
                    first_name: "",
                    last_name: "",
                    middle_name: "",
                    ext: "",
                    occupation: "",
                    DOB: "",
                },

                new_user_families: {
                    type: "",
                    first_name: "",
                    last_name: "",
                    middle_name: "",
                    ext: "",
                    occupation: "",
                    DOB: "",
                },

                user_professional_examinations: {
                    title: "",
                    rating: "",
                    date: "",
                    place: "",
                    license_no: "",
                    validity: "",
                },

                user_educational_backgrounds: {
                    educLevel: "",
                    school_name: "",
                    school_address: "",
                    course: "",
                    units: "",
                    year_graduated: "",
                    acad_honors_received: "",
                },

                newChildName: "",
                selectedLevel: "",

                user_award_receives: {
                    date_received: "",
                    title: "",
                    recognition_place: "",
                    awarded_by: "",
                },

                user_admin_pos_helds: {
                    date: "",
                    title: "",
                    recognition_place: "",
                    awarded_by: "",
                },

                user_work_experiences: {
                    date_from: "",
                    date_to: "",
                    position: "",
                    company_name: "",
                    rank: "",
                    status: "",
                },

                user_studies: {
                    date_published: "",
                    research_title: "",
                    journal_name: "",
                    link: "",
                },

                user_participations: {
                    title: "",
                    date_from: "",
                    date_to: "",
                    hours_no: "",
                    position: "",
                },

                user_special_trainings: {
                    title: "",
                    attendance_from: "",
                    attendance_to: "",
                    days: "",
                    type: "",
                    conducted_by: "",
                },

                user_other_infos: {
                    skill: "",
                    recognition_title: "",
                    org_name: "",
                },

                user_school_curriculars: {
                    designation: "",
                    event_name: "",
                    title: "",
                    date: "",
                },

                user_other_details: {
                    administrative_offense: "",
                    criminal_charge: "",
                    tribunal: "",
                    service_separation: "",
                    election_candidacy: "",
                },

                user_references: {
                    name: "",
                    address_id: "",
                    contact_no: "",
                },

                seletedId: "",

                user_valid_ids: {
                    id_type: "",
                    id_no: "",
                    date_issued: "",
                    date_expiry: "",
                },
            },
        };
    },
    methods: {
        goToPage(action) {
            this.currentPage =
                parseInt(localStorage.getItem("currentPage")) || 1;

            if (action === "next") {
                if (this.currentPage >= this.totalPages) {
                    this.currentPage = 1;
                } else {
                    this.currentPage += 1;
                }
            } else if (action === "prev") {
                if (this.currentPage === 1) {
                    this.currentPage = this.totalPages;
                } else {
                    this.currentPage -= 1;
                }
            }

            localStorage.setItem("currentPage", this.currentPage);
        },
        updateUserDetails(updatedDetails) {
            this.userDetails = { ...this.userDetails, ...updatedDetails };
        },
        trackTouchedField(fieldName) {
            this.editModeHasChanged = true;
            let touchedFields =
                JSON.parse(localStorage.getItem("touchedFields")) || {};
            touchedFields[fieldName] = true;
            localStorage.setItem(
                "touchedFields",
                JSON.stringify(touchedFields),
            );
        },

        async personalDetailSubmit() {
            const touchedFields =
                JSON.parse(localStorage.getItem("touchedFields")) || {};

            if (Object.keys(touchedFields).length === 0) {
                console.log("No changes to submit.");
                return;
            }

            const modifiedFields = {};

            for (const field in touchedFields) {
                if (touchedFields[field] === true) {
                    const fieldParts = field.split(".");
                    let value = this.userDetails;

                    for (let part of fieldParts) {
                        if (value && value.hasOwnProperty(part)) {
                            value = value[part];
                        }
                    }

                    modifiedFields[field] = value;
                }
            }

            if (Object.keys(modifiedFields).length === 0) {
                console.log("No modified fields to submit.");
                return;
            }

            try {
                this.toggleConfirmationSubmitModal("close");
                this.editModeHasChanged = false;

                await router.post(
                    "/personal-details-update-submit",
                    modifiedFields,
                );

                localStorage.removeItem("touchedFields");
                this.editMode = !this.editMode;
                localStorage.setItem("editMode", JSON.stringify(this.editMode));

                this.$emit(
                    "showSuccessMessage",
                    "Personal details updated successfully!",
                );
            } catch (error) {
                console.error("Error submitting personal details:", error);
            }
        },
        toggleEditMode() {
            this.editMode = !this.editMode;
            localStorage.setItem("editMode", JSON.stringify(this.editMode));
        },
        toggleConfirmationSubmitModal(action) {
            if (action == "close") {
                document.getElementById(
                    "confirmationSubmitModal",
                ).style.display = "none";
            } else {
                document.getElementById(
                    "confirmationSubmitModal",
                ).style.display = "flex";
            }
        },
        previewDataSheet() {
            router.visit("/account/personal-data-sheet/preview");
        },
    },

    created() {
        const storedEditMode = localStorage.getItem("editMode");
        if (storedEditMode !== null) {
            this.editMode = JSON.parse(storedEditMode);
        }
    },
};
