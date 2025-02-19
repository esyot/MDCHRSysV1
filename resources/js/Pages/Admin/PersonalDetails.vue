<template>
    <form>
        <div class="personal-details-content">
            <Form1
                v-if="currentPage === 1"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form2
                v-if="currentPage === 2"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form3
                v-if="currentPage === 3"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form4
                v-if="currentPage === 4"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form5
                v-if="currentPage === 5"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form6
                v-if="currentPage === 6"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form7
                v-if="currentPage === 7"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form8
                v-if="currentPage === 8"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form9
                v-if="currentPage === 9"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form10
                v-if="currentPage === 10"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form11
                v-if="currentPage === 11"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form12
                v-if="currentPage === 12"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form13
                v-if="currentPage === 13"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form14
                v-if="currentPage === 14"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
            <Form15
                v-if="currentPage === 15"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
            />
        </div>
        <div class="footer">
            <div class="navigation-buttons">
                <button type="button" @click="goToPage('prev')">
                    <i class="fas fa-chevron-circle-left"></i>
                </button>
                <span class="pageNum">
                    {{ currentPage }}
                </span>
                <button type="button" @click="goToPage('next')">
                    <i class="fas fa-chevron-circle-right"></i>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import Form1 from "@/Pages/Admin/Forms/Form1.vue";
import Form2 from "@/Pages/Admin/Forms/Form2.vue";
import Form3 from "@/Pages/Admin/Forms/Form3.vue";
import Form4 from "@/Pages/Admin/Forms/Form4.vue";
import Form5 from "@/Pages/Admin/Forms/Form5.vue";
import Form6 from "@/Pages/Admin/Forms/Form6.vue";
import Form7 from "@/Pages/Admin/Forms/Form7.vue";
import Form8 from "@/Pages/Admin/Forms/Form8.vue";
import Form9 from "@/Pages/Admin/Forms/Form9.vue";
import Form10 from "@/Pages/Admin/Forms/Form10.vue";
import Form11 from "@/Pages/Admin/Forms/Form11.vue";
import Form12 from "@/Pages/Admin/Forms/Form12.vue";
import Form13 from "@/Pages/Admin/Forms/Form13.vue";
import Form14 from "@/Pages/Admin/Forms/Form14.vue";
import Form15 from "@/Pages/Admin/Forms/Form15.vue";

import { Inertia } from "@inertiajs/inertia";

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
    },
    data() {
        return {
            currentPage: parseInt(localStorage.getItem("currentPage")) || 1,
            totalPages: 15,

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
                },

                new_user_families: {
                    type: "",
                    first_name: "",
                    last_name: "",
                    middle_name: "",
                    ext: "",
                    occupation: "",
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
    },
};
</script>

<style>
.modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.3);
}
.modal-content {
    background-color: #fff;
    border-top: 3px solid rgb(53, 95, 194);
    border-radius: 5px;
}

.modal-content-description {
    padding: 2px;
    margin-bottom: 10px;
    margin-top: 10px;
}

.modal-content-description label {
    font-size: 18px;
    padding: 10px;
    font-weight: bold;
}

.modal-content-btn {
    border-top: 1px solid #b9b9b9;
    background-color: #f4f4f4;
    display: flex;
    justify-content: end;
    gap: 0.2rem;
    padding: 10px;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
}

.modal-content-btn .no-btn {
    background-color: #fff;
    border: 1px solid rgb(0, 52, 224);
    border-radius: 5px;
    color: rgb(0, 52, 224);
    padding: 10px 14px 10px 14px;
    opacity: 50%;

    cursor: pointer;
}

.modal-content-btn .yes-btn {
    background-color: rgb(0, 52, 224);
    border: none;
    border-radius: 5px;
    color: rgb(255, 255, 255);
    padding: 10px;
    opacity: 50%;
    cursor: pointer;
}

.no-btn:hover,
.yes-btn:hover {
    opacity: 100%;
}

.saveChangesBtn {
    padding: 6px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.saveChangesBtn:hover {
    background-color: #0056b3;
}
.footer {
    display: flex;
    justify-content: space-between;
}
#EditModeToggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 5px;
}
#EditModeToggle span {
    color: #fff;
}

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    border-radius: 50%;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #4caf50;
}

input:checked + .slider:before {
    transform: translateX(26px);
}
.pageNum {
    color: #fff;
}
.title-container {
    border-bottom: #cecece 1px solid;
    background-color: #ebebeb;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
    position: sticky;
    top: 0;
    z-index: 1;
}

.title {
    font-size: 14px;
    padding: 10px;
    font-weight: bold;
}

.personal-details-content {
    display: flex;
    flex-wrap: wrap;
    height: 73vh;
    overflow-y: auto;
    margin-top: 5px;
    gap: 0.5rem;
}

.personal-details-items {
    flex-grow: 1;
    flex-basis: 400px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.form-group {
    margin-bottom: 15px;
    padding: 10px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 12px;
}

.form-group input {
    width: 96%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.radio-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.radio-group label {
    display: flex;
    align-items: center;
}

.form-control-radio {
    margin-right: 5px;
}
.navigation-buttons {
    display: flex;
    justify-content: center;
    padding: 10px;
    align-items: center;
    gap: 0.5rem;
}

.navigation-buttons button {
    border: none;
    background-color: transparent;
}

.navigation-buttons i {
    color: #fff;
    font-size: 25px;
    opacity: 50%;
    cursor: pointer;
}

.navigation-buttons i:hover {
    opacity: 100%;
}

.submit-btn {
    display: flex;
    justify-content: end;
}

.add-field-btn {
    margin: 10px;
}

.add-field-btn button {
    padding: 10px 14px 10px 14px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
    opacity: 75%;
    box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.3);
}

.add-field-btn button:hover {
    opacity: 100%;
    cursor: pointer;
}

.select-field {
    padding: 10px;
    border-radius: 5px;
}
</style>
