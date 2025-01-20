<template>
    <!-- Confirmation Modal -->
    <div id="confirmationSubmitModal" class="modal modal-hide">
        <div class="modal-content">
            <h3>Are you sure to save all changes?</h3>
            <footer>
                <button
                    type="button"
                    class="no-btn"
                    @click="toggleConfirmationSubmitModal('close')"
                >
                    No
                </button>
                <button
                    type="button"
                    @click="personalDetailSubmit"
                    class="yes-btn"
                >
                    Yes
                </button>
            </footer>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <form @submit.prevent="personalDetailSubmit" @keydown.enter.prevent>
        <div class="personal-details-content">
            <Form1
                v-if="currentPage === 1"
                :editMode="editMode"
                :userDetails="userDetails"
                :personalDetails="personalDetails"
                @update-user-details="updateUserDetails"
                @track-touched-field="trackTouchedField"
            />
            <Form2
                v-if="currentPage === 2"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form3
                v-if="currentPage === 3"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form4
                v-if="currentPage === 4"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form5
                v-if="currentPage === 5"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form6
                v-if="currentPage === 6"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form7
                v-if="currentPage === 7"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form8
                v-if="currentPage === 8"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form9
                v-if="currentPage === 9"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form10
                v-if="currentPage === 10"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form11
                v-if="currentPage === 11"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form12
                v-if="currentPage === 12"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form13
                v-if="currentPage === 13"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form14
                v-if="currentPage === 14"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
            <Form15
                v-if="currentPage === 15"
                :editMode="editMode"
                :userDetails="userDetails"
                @update-user-details="updateUserDetails"
            />
        </div>
        <div class="footer">
            <div id="EditModeToggle">
                <span id="modeText">Edit Mode</span>
                <label class="switch">
                    <input
                        type="checkbox"
                        id="toggleButton"
                        @click="toggleEditMode"
                        :checked="editMode == true"
                    />
                    <span class="slider"></span>
                </label>

                <button
                    type="button"
                    @click="toggleConfirmationSubmitModal('open')"
                    class="saveChangesBtn"
                    v-if="editModeHasChanged && editMode"
                >
                    Save Changes
                </button>
            </div>

            <div class="navigation-buttons">
                <button @click="goToPage('prev')">
                    <i class="fas fa-chevron-circle-left"></i>
                </button>
                <span class="pageNum">
                    {{ currentPage }}
                </span>
                <button @click="goToPage('next')">
                    <i class="fas fa-chevron-circle-right"></i>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import Form1 from "@/Pages/Account/Components/Forms/form1.vue";
import Form2 from "@/Pages/Account/Components/Forms/form2.vue";
import Form3 from "@/Pages/Account/Components/Forms/form3.vue";
import Form4 from "@/Pages/Account/Components/Forms/form4.vue";
import Form5 from "@/Pages/Account/Components/Forms/form5.vue";
import Form6 from "@/Pages/Account/Components/Forms/form6.vue";
import Form7 from "@/Pages/Account/Components/Forms/form7.vue";
import Form8 from "@/Pages/Account/Components/Forms/form8.vue";
import Form9 from "@/Pages/Account/Components/Forms/form9.vue";
import Form10 from "@/Pages/Account/Components/Forms/form10.vue";
import Form11 from "@/Pages/Account/Components/Forms/form11.vue";
import Form12 from "@/Pages/Account/Components/Forms/form12.vue";
import Form13 from "@/Pages/Account/Components/Forms/form13.vue";
import Form14 from "@/Pages/Account/Components/Forms/form14.vue";
import Form15 from "@/Pages/Account/Components/Forms/form15.vue";

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
            currentPage: 1,
            totalPages: 15,
            editMode: false,
            editModeHasChanged: false,

            userDetails: {
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
                house_block_lot_no: "",
                street: "",
                sub_village: "",
                barangay: "",
                city_municipality: "",
                province: "",
                zip_code: "",
                date_hired: "",
                rank: "",
                department: "",

                userProfExamDetails: {
                    title: "",
                    rating: "",
                    date: "",
                    place: "",
                    license_no: "",
                    validity: "",
                },

                educDetails: {
                    school_name: "",
                    school_address: "",
                    course: "",
                    units: "",
                    year_graduated: "",
                    acads_honors_received: "",
                },
                familyMemberType: "",
                familyDetails: {
                    lastName: "",
                    firstName: "",
                    middleName: "",
                    ext: "",
                    occupation: "",
                    maidenName: "",
                    children: [],
                },
                newChildName: "",
                educLevel: "",
                selectedLevel: "",

                userAwardDetails: {
                    date_recieved: "",
                    title: "",
                    recognition_place: "",
                    awarded_by: "",
                },

                userAdministrativeAwardDetails: {
                    date: "",
                    title: "",
                    recognition_place: "",
                    awarded_by: "",
                },

                userWorkExpDetails: {
                    date_from: "",
                    date_to: "",
                    position: "",
                    company_name: "",
                    rank: "",
                    status: "",
                },

                userStudiesDetails: {
                    date_published: "",
                    research_title: "",
                    journal_name: "",
                    link: "",
                },

                userParticipationDetails: {
                    title: "",
                    date_from: "",
                    date_to: "",
                    hours_no: "",
                    position: "",
                },

                userSpecialTrainingDetails: {
                    title: "",
                    attendance_from: "",
                    attendance_to: "",
                    days: "",
                    type: "",
                    conducted_by: "",
                },

                userOtherInfo: {
                    skill: "",
                    recognition_title: "",
                    org_name: "",
                },

                userCurAssignDetails: {
                    designation: "",
                    event_name: "",
                    title: "",
                    date: "",
                },

                userOtherDetails: {
                    administrative_offense: "",
                    criminal_charge: "",
                    tribunal: "",
                    service_separation: "",
                    election_candidacy: "",
                },

                userRefDetails: {
                    name: "",
                    address_id: "",
                    contact_no: "",
                },

                seletedId: "",

                userValidId: {
                    id_no: "",
                    date_issued: "",
                    date_expiry: "",
                },
            },
        };
    },
    methods: {
        trackTouchedField(fieldName) {
            this.editModeHasChanged = true;
            let touchedFields =
                JSON.parse(localStorage.getItem("touchedFields")) || {};

            touchedFields[fieldName] = true;
            localStorage.setItem(
                "touchedFields",
                JSON.stringify(touchedFields)
            );
        },

        updateUserDetails(updatedDetails) {
            this.userDetails = { ...this.userDetails, ...updatedDetails };
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
                    modifiedFields[field] = this.userDetails[field];
                }
            }

            if (Object.keys(modifiedFields).length === 0) {
                console.log("No modified fields to submit.");
                return;
            }

            try {
                this.toggleConfirmationSubmitModal("close");
                this.editModeHasChanged = false;

                await Inertia.post(
                    "/personal-details-update-submit",
                    modifiedFields
                );

                localStorage.removeItem("touchedFields");
                this.editMode = !this.editMode;
                localStorage.setItem("editMode", JSON.stringify(this.editMode));

                this.$emit(
                    "showSuccessMessage",
                    "Personal details updated successfully!"
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
                    "confirmationSubmitModal"
                ).style.display = "none";
            } else {
                document.getElementById(
                    "confirmationSubmitModal"
                ).style.display = "flex";
            }
        },
    },

    created() {
        const storedEditMode = localStorage.getItem("editMode");
        if (storedEditMode !== null) {
            this.editMode = JSON.parse(storedEditMode);
        }
    },
};
</script>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 50;
    inset: 0;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.3);
}
.modal-content {
    background-color: #fff;
    padding: 5px;
    border-radius: 5px;
}
.modal-content footer {
    display: flex;
    justify-content: end;
    gap: 0.3rem;
}

.modal-content h3 {
    font-size: 16px;
    font-weight: bold;
    padding: 0px 10px 0px 10px;
}

.modal-content footer button {
    border: none;
    cursor: pointer;
    opacity: 60%;
}

.modal-content footer button:hover {
    opacity: 100%;
}

.yes-btn {
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border-radius: 5px;
}

.no-btn {
    padding: 0px 14px 0px 14px;
    background-color: #b7b7b7;
    color: #fff;
    border-radius: 5px;
}
.saveChangesBtn {
    padding: 6px;
    color: #fff;
    background-color: #007bff; /* Blue color */
    border: none;
    border-radius: 5px;
    cursor: pointer; /* Adds a pointer on hover */
    transition: background-color 0.3s ease; /* Smooth background color transition */
}

.saveChangesBtn:hover {
    background-color: #0056b3; /* Darker blue on hover */
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
    border-bottom: #dedede 1px solid;
    background-color: #fff;
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
    height: 78vh;
    overflow-y: auto;
    margin-top: 5px;
    gap: 0.5rem;
}

.personal-details-items {
    flex-grow: 1;
    flex-basis: 400px;
    background-color: #ffffff;
    border-radius: 8px;
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
    width: 95%;
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
</style>
