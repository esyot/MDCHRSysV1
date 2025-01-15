<template>
    <div class="personal-details-content">
        <div class="personal-details-items" v-show="currentPage === 1">
            <div class="title-container">
                <span class="title">PERSONAL INFORMATION</span>
            </div>
            <div class="form-group">
                <label for="last_name">SURNAME</label>
                <input type="text" id="last_name" v-model="last_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="first_name">FIRST NAME:</label>
                <input type="text" id="first_name" v-model="first_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="middle_name">MIDDLE NAME:</label>
                <input type="text" id="middle_name" v-model="middle_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="name_extension">NAME EXTENSION:</label>
                <input type="text" id="name_extension" v-model="name_extension" class="form-control">
            </div>
            <div class="form-group">
                <label for="nick_name">NICKNAME:</label>
                <input type="text" id="nick_name" v-model="nick_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="date_of_birth">DATE OF BIRTH:</label>
                <input type="date" id="date_of_birth" v-model="date_of_birth" class="form-control">
            </div>
            <div class="form-group">
                <label for="place_of_birth">PLACE OF BIRTH:</label>
                <input type="text" id="place_of_birth" v-model="place_of_birth" class="form-control">
            </div>
            <div class="form-group">
                <label for="sex">SEX:</label>
                    <div class="radio-group">
                        <label for="male">
                            <input type="radio" id="male" name="sex" value="male" class="form-control-radio" v-model="sex"> Male
                        </label>
                        <label for="female">
                            <input type="radio" id="female" name="sex" value="female" class="form-control-radio" v-model="sex"> Female
                        </label>
                    </div>
            </div>
            <div class="form-group">
                <label for="civil_status">CIVIL STATUS:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="civil_status" value="single" class="form-control-radio"> Single
                    </label>
                    <label>
                        <input type="radio" name="civil_status" value="married" class="form-control-radio"> Married
                    </label>
                    <label>
                        <input type="radio" name="civil_status" value="widowed" class="form-control-radio"> Widowed
                    </label>
                    <label>
                        <input type="radio" name="civil_status" value="separated" class="form-control-radio"> Separated
                    </label>
                    <label>
                        <input type="radio" name="civil_status" value="others" class="form-control-radio"> Other/s:
                    </label>
                    <input type="text" name="others" id="others" v-model="others" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="religion">RELIGION:</label>
                <input type="text" name="religion" id="religion" v-model="religion" class="form-control">
            </div>
            <div class="form-group">
                <label for="height">HEIGHT:</label>
                <input type="text" name="height" id="height" v-model="height" class="form-control" placeholder="Height in Meters" min="0" step="0.01">
            </div>
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" name="weight" id="weight" v-model="weight" class="form-control" placeholder="Weight in Kgs" min="0">
            </div>
            <div class="form-group">
                <label for="blood_type">BLOOD TYPE:</label>
                <input type="text" name="blood_type" id="blood_type" v-model="blood_type" class="form-control">
            </div>
            <div class="form-group">
                <label for="contact">TEL NO./MOBILE NO.:</label>
                <input type="text" name="contact" id="contact" v-model="contact" class="form-control" placeholder="eg. 09123456789">
            </div>
            <div class="form-group">
                <label for="citizenship">CITIZENSHIP:</label>
                <div class="select-group">
                    <select name="citizenship" id="citizenship" v-model="citizenship" >
                        <option value="Select">Select Citizenship</option>
                        <option value="Filipino">Filipino</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="citizenship" value="by_birth" class="form-control-radio"> By Birth
                        </label>
                        <label>
                            <input type="radio" name="citizenship" value="by_naturalization" class="form-control-radio"> By Naturalization
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="messenger_acct">MESSENGER ACCT:</label>
                <input type="text" name="messenger_acct" id="messenger_acct" v-model="messenger_acct" class="form-control">
            </div>

        </div>
        <div class="personal-details-items" v-show="currentPage === 1">
            <div class="title-container">
                <span class="title">PERSONAL INFORMATION</span>
            </div>
            <div class="form-group">
                <label for="address">ADDRESS:</label>
                <div class="address-group">
                    <div class="form-group">
                        <label for="house_block_lot_no">HOUSE/BLOCK/LOT NO.:</label>
                        <input type="text" name="house_block_lot_no" id="house_block_lot_no" v-model="house_block_lot_no" class="form-control" placeholder="House No.">
                    </div>
                    <div class="form-group">
                        <label for="street">STREET:</label>
                        <input type="text" name="street" id="street" v-model="street" class="form-control" placeholder="Street Name">
                    </div>
                    <div class="form-group">
                        <label for="sub_village">SUBDIVISION/VILLAGE:</label>
                        <input type="text" name="sub_village" id="sub_village" v-model="sub_village" class="form-control" placeholder="Subdivision Name">
                    </div>
                    <div class="form-group">
                        <label for="barangay">BARANGAY:</label>
                        <input type="text" name="barangay" id="barangay" v-model="barangay" class="form-control" placeholder="Barangay Name">
                    </div>
                    <div class="form-group">
                        <label for="city_municipality">CITY/MUNICIPALITY:</label>
                        <input type="text" name="city_municipality" id="city_municipality" v-model="city_municipality" class="form-control" placeholder="City/Municipality Name">
                    </div>
                    <div class="form-group">
                        <label for="province">PROVINCE:</label>
                        <input type="text" name="province" id="province" v-model="province" class="form-control" placeholder="Province Name">
                    </div>
                    <div class="form-group">
                        <label for="zip_code">ZIP CODE:</label>
                        <input type="text" name="zip_code" id="zip_code" v-model="zip_code" class="form-control" placeholder="Zip Code">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="permanent_address">PERMANENT ADDRESS:</label>
                <div class="address-group">
                    <div class="form-group">
                        <label for="house_block_lot_no">HOUSE/BLOCK/LOT NO.:</label>
                        <input type="text" name="house_block_lot_no" id="house_block_lot_no" v-model="house_block_lot_no" class="form-control" placeholder="House No.">
                    </div>
                    <div class="form-group">
                        <label for="street">STREET:</label>
                        <input type="text" name="street" id="street" v-model="street" class="form-control" placeholder="Street Name">
                    </div>
                    <div class="form-group">
                        <label for="sub_village">SUBDIVISION/VILLAGE:</label>
                        <input type="text" name="sub_village" id="sub_village" v-model="sub_village" class="form-control" placeholder="Subdivision Name">
                    </div>
                    <div class="form-group">
                        <label for="barangay">BARANGAY:</label>
                        <input type="text" name="barangay" id="barangay" v-model="barangay" class="form-control" placeholder="Barangay Name">
                    </div>
                    <div class="form-group">
                        <label for="city_municipality">CITY/MUNICIPALITY:</label>
                        <input type="text" name="city_municipality" id="city_municipality" v-model="city_municipality" class="form-control" placeholder="City/Municipality Name">
                    </div>
                    <div class="form-group">
                        <label for="province">PROVINCE:</label>
                        <input type="text" name="province" id="province" v-model="province" class="form-control" placeholder="Province Name">
                    </div>
                    <div class="form-group">
                        <label for="zip_code">ZIP CODE:</label>
                        <input type="text" name="zip_code" id="zip_code" v-model="zip_code" class="form-control" placeholder="Zip Code">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="date_hired">DATE HIRED:</label>
                <input type="date" name="date_hired" id="date_hired" v-model="date_hired" class="form-control">
            </div>
            <div class="form-group">
                <label for="rank">PRESENT RANK IN MDC:</label>
                <div class="select-group">
                    <select name="rank" id="rank" v-model="rank" class="form-control">
                        <option value="">Select Rank</option>
                        <option value="Dean">Dean</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="department">DEPARTMENT</label>
                <div class="select-group">
                    <select name="department" id="department" v-model="department" class="form-control">
                        <option value="">Select Department</option>
                        <option value="CAST">CAST</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="personal-details-items" v-show="currentPage === 2">
            <div class="title-container">
                <span class="title">FAMILY BACKGROUND</span>
            </div>

            <div class="form-group">
                <label for="type">SELECT FAMILY MEMBER:</label>
                <select v-model="familyMemberType" class="form-control">
                    <option value="">Select Type</option>
                    <option value="spouse">Spouse</option>
                    <option value="father">Father</option>
                    <option value="mother">Mother</option>
                    <option value="children">Children</option>
                </select>
            </div>

            <div v-if="familyMemberType">
                <div class="form-group">
                    <label for="last_name">{{ familyMemberType.toUpperCase() }} SURNAME:</label>
                    <input type="text" v-model="familyDetails.lastName" class="form-control" placeholder="e.g. Esteban" />
                </div>

                <div class="form-group">
                    <label for="first_name">{{ familyMemberType.toUpperCase() }} FIRST NAME:</label>
                    <input type="text" v-model="familyDetails.firstName" class="form-control" placeholder="e.g. Reinhard" />
                </div>

                <div class="form-group">
                    <label for="middle_name">{{ familyMemberType.toUpperCase() }} MIDDLE NAME:</label>
                    <input type="text" v-model="familyDetails.middleName" class="form-control" placeholder="e.g. Lanoy" />
                </div>

                <div class="form-group">
                    <label for="ext">{{ familyMemberType.toUpperCase() }} NAME EXTENSION:</label>
                    <input type="text" v-model="familyDetails.ext" class="form-control" placeholder="e.g. Jr., Sr., III, etc." />
                </div>

                <div class="form-group" v-if="familyMemberType === 'spouse'">
                    <label for="occupation">SPOUSE OCCUPATION:</label>
                    <input type="text" v-model="familyDetails.occupation" class="form-control" placeholder="e.g. Teacher, Engineer, Doctor, etc." />
                </div>
                <div class="form-group" v-if="familyMemberType === 'mother'">
                    <label for="maiden_name">MOTHER'S MAIDEN NAME:</label>
                    <input type="text" v-model="familyDetails.maidenName" class="form-control" placeholder="e.g. Caingles" />
                </div>
                <div class="form-group submit-btn">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </div>
        <div class="personal-details-items" v-show="currentPage === 2">
            <div class="title-container">
                <span class="title">FAMILY MEMBERS: </span>
            </div>
        </div>
        <div class="personal-details-items" v-show="currentPage === 3">
            <div class="title-container">
                <span class="title">EDUCATIONAL BACKGROUND</span>
            </div>
            <div class="form-group">
                <label for="level">SELECT LEVEL:</label>
                <select v-model="educLevel" class="form-control" @change="updateSelectedLevel">
                    <option value="">Select Type</option>
                    <option value="elem">Elemantary</option>
                    <option value="sec">Secondary</option>
                    <option value="college">College</option>
                    <option value="gs">Graduates Study</option>
                    <option value="pgs">Post Graduates Study</option>
                </select>
            </div>
            <div v-if="educLevel">
                <div class="form-group">
                    <label for="school_name">NAME OF {{ selectedLevel.toUpperCase() }} SCHOOL:</label>
                    <input type="text" v-model="educDetails.school_name" class="form-control" placeholder="e.g. St. Paul College, University of the Philippines, etc." />
                </div>
                <div class="form-group">
                    <label for="school_address">ADDRESS OF {{ selectedLevel.toUpperCase() }} SCHOOL:</label>
                    <input type="text" v-model="educDetails.school_address" class="form-control" placeholder="e.g. 1234, 5th Street, Brgy. San Isidro, Poblacion, Cebu City, etc." />
                </div>
                <div class="form-group" v-if="educLevel === 'college'|| educLevel === 'gs'|| educLevel === 'pgs'">
                    <label for="course" >COURSE:</label>
                    <input type="text" v-model="educDetails.course" class="form-control" placeholder="e.g. N/A" />
                </div>
                <div class="form-group">
                    <label for="period_attendance_from">PERIOD ATTENDANCE FROM:</label>
                    <input type="date" v-model="educDetails.period_attendance_from" class="form-control" placeholder="e.g. 2020-01-01" />
                </div>
                <div class="form-group">
                    <label for="period_attendance_to">PERIOD ATTENDANCE TO:</label>
                    <input type="date" v-model="educDetails.period_attendance_to" class="form-control" placeholder="e.g. 2020-01-01" />
                </div>
                <div class="form-group" v-if="educLevel === 'college'|| educLevel === 'gs'|| educLevel === 'pgs'">
                    <label for="units">{{ educLevel.toUpperCase() }} UNITS:</label>
                    <input type="number" v-model="educDetails.units" class="form-control" placeholder="eg. 60"/>
                </div>
                <div class="form-group">
                    <label for="year_graduated">YEAR GRADUATED FROM {{ educLevel.toUpperCase() }}:</label>
                    <input type="date" v-model="educDetails.year_graduated" class="form-control" placeholder="e.g. 2020" />
                </div>
                <div class="form-group">
                    <label for="acads_honors_received">SCHOLARSHIP/ACADEMIC HONORS RECEIVED:</label>
                    <input type="text" v-model="educDetails.acads_honors_received" class="form-control" placeholder="e.g. Dean's Lister, etc." />
                </div>
            </div>
        </div>

    </div>
    <div class="paging-btn">
       <footer>
            <div class="navigation-buttons">
                <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
                <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
            </div>
       </footer>
        </div>
</template>
<script>
export default {
    name: "PersonalDetails",
    data() {
        return {
            currentPage: 1,
            totalPages: 3,

            familyMemberType: '',
            familyDetails: {
                lastName: '',
                firstName: '',
                middleName: '',
                ext: '',
                occupation: '',
                maidenName: '',
                children: []
            },
            newChildName: '',

            educLevel:'',
            selectedLevel: "",
            educDetails: {
                school_name: '',
                school_address: '',
                course: '',
                units: '',
                year_graduated: '',
                acads_honors_received: ''
                },
        };
    },
    methods: {
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        updateSelectedLevel(event) {
            // Get the text of the selected option
            this.selectedLevel = event.target.options[event.target.selectedIndex].text;
        }

    }
};
</script>


<style scoped>
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

.personal-details-items{

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
.submit-btn{
    display: flex;
    justify-content: end;
}

</style>
