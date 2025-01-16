<template>
    <div class="personal-details-content">
        <Form1
            v-if="currentPage === 1"
            :userDetails="userDetails"
            @update-user-details="updateUserDetails"
        />
        <Form2
            v-if="currentPage === 2"
            :userDetails="userDetails"
            @update-user-details="updateUserDetails"
        />
        <Form3
            v-if="currentPage === 3"
            :userDetails="userDetails"
            @update-user-details="updateUserDetails"
        />
        <Form4
            v-if="currentPage === 4"
            :userDetails="userDetails"
            @update-user-details="updateUserDetails"
        />
    </div>
    <div class="paging-btn">
        <footer>
            <div class="navigation-buttons">
                <button
                    @click="goToPage(currentPage - 1)"
                    :disabled="currentPage === 1"
                >
                    Previous
                </button>
                <button
                    @click="goToPage(currentPage + 1)"
                    :disabled="currentPage === totalPages"
                >
                    Next
                </button>
            </div>
        </footer>
    </div>
</template>

<script>
import Form1 from "@/Pages/Account/Components/Forms/form1.vue";
import Form2 from "@/Pages/Account/Components/Forms/form2.vue";
import Form3 from "@/Pages/Account/Components/Forms/form3.vue";
import Form4 from "@/Pages/Account/Components/Forms/form4.vue";

export default {
    name: "PersonalDetails",
    components: {
        Form1,
        Form2,
        Form3,
        Form4,
    },
    data() {
        return {
            currentPage: 4,
            totalPages: 4,

            userDetails: {
                last_name: "",
                first_name: "",
                middle_name: "",
                name_extension: "",
                nick_name: "",
                date_of_birth: "",
                place_of_birth: "",
                sex: "",
                civil_status: "",
                others: "",
                religion: "",
                height: "",
                weight: "",
                blood_type: "",
                contact: "",
                citizenship: "Select",
                messenger_acct: "",
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

                    userProfExamDetails:{
                    title:"",
                    rating:"",
                    date:"",
                    place:"",
                    license_no:"",
                    validity:"",
                },

                    educDetails: {
                    school_name: "",
                    school_address: "",
                    course: "",
                    units: "",
                    year_graduated: "",
                    acads_honors_received: "",
                },
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


        };
    },
    methods: {
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        updateSelectedLevel(event) {
            this.selectedLevel =
                event.target.options[event.target.selectedIndex].text;
        },
    },
};
</script>

<style>
.title-container {
    border-bottom: #dedede 1px solid;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
}

.title {
    font-size: 18px;
    padding: 10px;
    font-weight: bold;
}
.personal-details-content {
    display: flex;
    flex-wrap: wrap;
    height: 80vh;
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
    font-size: 14px;
}

.form-group input {
    width: 95%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
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

.paging-btn {
    display: flex;
    justify-content: center;
    gap: 1rem;
}
.submit-btn {
    display: flex;
    justify-content: end;
}
</style>
