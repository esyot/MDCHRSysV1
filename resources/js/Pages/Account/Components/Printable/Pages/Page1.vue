<script>
export default {
    name: "Page1",
    props: {
        personalDetails: Object,
    },
    methods: {
        getLevelDisplay(level) {
            switch (level) {
                case "elem":
                    return "Elementary";
                case "sec":
                    return "Secondary";
                case "college":
                    return "College";
                case "gs":
                    return "Graduate Studies";
                case "pgs":
                    return "Post Graduate Studies";
                default:
                    return level || "N/A";
            }
        },
    },
};
</script>
<template>
    <div class="page-content">
        <div class="header-container">
            <div class="logo">
                <img src="/public/assets/images/mdc-logo.png" alt="logo" />
            </div>
            <div class="header">
                <h3>Mater Dei College</h3>
                <p>Tubigon, Bohol</p>
            </div>
        </div>

        <div class="header">
            <h2>PERSONAL DATA SHEET</h2>
            <span>
                In compliance with DATA Privacy Act of 2012(RA 1073), I hereby
                allow Mater Dei College, Tubigon, Bohol to collect and process
                my personal information in relation to my job.
            </span>
            <span
                >Instruction: Please provide the correct information of the
                following:</span
            >
        </div>

        <div class="id-number">
            <label for="">MDC-ID No.</label>
            <input type="text" class="small-input" />
        </div>
        <div class="sub-container">
            <div class="title">I. PERSONAL INFORMATION</div>
            <div class="forms">
                <div class="form-group left">
                    <div class="items">
                        <label>Surname:</label>
                        <input type="text" :value="personalDetails.last_name" />
                    </div>

                    <div class="items">
                        <label for="">First Name: </label>
                        <div class="input-group">
                            <input
                                type="text"
                                :value="personalDetails.first_name"
                            />
                        </div>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.name_ext"
                            class="small-input"
                        />
                    </div>

                    <div class="items">
                        <label for="">Middle Name:</label>
                        <input
                            type="text"
                            :value="personalDetails.middle_name"
                        />
                        <label for="">Nickname:</label>
                        <input
                            type="text"
                            name=""
                            :value="personalDetails.personal_details.nickname"
                            id=""
                        />
                    </div>

                    <div class="items">
                        <label for="">Date of Birth:</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.DOB"
                        />
                    </div>

                    <div class="items">
                        <label for="">Place of Birth:</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.birthplace"
                        />
                    </div>

                    <div class="item">
                        <label for="">Sex:</label>
                        <div class="checkbox-group">
                            <input
                                type="checkbox"
                                :checked="
                                    personalDetails.personal_details.sex ===
                                    'male'
                                "
                            />
                            <label for="">Male</label>

                            <input
                                type="checkbox"
                                :checked="
                                    personalDetails.personal_details.sex ===
                                    'female'
                                "
                            />
                            <label for="">Female</label>
                        </div>
                    </div>

                    <div class="item">
                        <label for="">Civil Status:</label>
                        <div class="civil-status">
                            <div class="civil-group">
                                <input
                                    type="checkbox"
                                    id="single"
                                    :checked="
                                        personalDetails.personal_details
                                            .civil_status === 'single'
                                    "
                                />
                                <label for="single">Single</label>

                                <input
                                    type="checkbox"
                                    id="married"
                                    :checked="
                                        personalDetails.personal_details
                                            .civil_status === 'married'
                                    "
                                />
                                <label for="married">Married</label>
                            </div>
                            <div class="civil-group">
                                <input
                                    type="checkbox"
                                    id="widowed"
                                    :checked="
                                        personalDetails.personal_details
                                            .civil_status === 'widowed'
                                    "
                                />
                                <label for="widowed">Widowed</label>

                                <input
                                    type="checkbox"
                                    id="divorced"
                                    :checked="
                                        personalDetails.personal_details
                                            .civil_status === 'divorced'
                                    "
                                />
                                <label for="separated">Divorced</label>
                            </div>
                            <div class="civil-group">
                                <label for="other">Other:</label>
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    class="small-input"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <label for="">Religion:</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.religion"
                        />
                    </div>

                    <div class="items">
                        <label for="">Height (cm):</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.height"
                        />
                    </div>

                    <div class="items">
                        <label for="">Weight (kg):</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.weight"
                        />
                    </div>

                    <div class="items">
                        <label for="">Blood:</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.blood_type"
                        />
                    </div>

                    <div class="items">
                        <label for="">Tel No./Mobile No.:</label>
                        <input
                            type="text"
                            :value="personalDetails.personal_details.contact_no"
                        />
                    </div>
                </div>

                <div class="form-group right">
                    <div class="citizen-container">
                        <label for="">Citizenship:</label>
                        <div class="citizenship">
                            <input
                                type="checkbox"
                                :checked="
                                    personalDetails.personal_details
                                        .citizenship === 'filipino'
                                "
                            />
                            <label for="">Filipino</label>

                            <input
                                type="checkbox"
                                :checked="
                                    personalDetails.personal_details
                                        .citizenship === 'dual_citizenship'
                                "
                            />
                            <label>Dual Citizenship </label>
                        </div>
                    </div>
                    <div class="dual-option">
                        <input
                            type="checkbox"
                            :checked="
                                personalDetails.personal_details
                                    .citizenship_type === 'by_birth'
                            "
                        />
                        <label for="">by birth</label>

                        <input
                            type="checkbox"
                            :checked="
                                personalDetails.personal_details
                                    .citizenship_type === 'by_naturalization'
                            "
                        />
                        <label for="">by naturalization</label>
                    </div>

                    <div class="items">
                        <label for="">Email Address:</label>
                        <input type="text" :value="personalDetails.email" />
                    </div>

                    <div class="items">
                        <label for="">Messenger Account:</label>
                        <input type="text" />
                    </div>

                    <div class="address-container">
                        <div class="address">
                            <label for="">Residential Address:</label>
                        </div>
                        <div class="address">
                            <div class="address-input">
                                <input
                                    type="text"
                                    placeholder="House/Block/Lot No."
                                    :value="
                                        personalDetails.personal_details
                                            .residential_address.house_no
                                    "
                                />
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    :value="
                                        personalDetails.personal_details
                                            .residential_address.street
                                    "
                                    placeholder="Street"
                                />
                            </div>
                            <div class="address-input">
                                <input
                                    type="text"
                                    placeholder="Subdivision/Village"
                                    :value="
                                        personalDetails.personal_details
                                            .residential_address.subdv
                                    "
                                />
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    placeholder="Barangay"
                                    :value="
                                        personalDetails.personal_details
                                            .residential_address.brgy
                                    "
                                />
                            </div>
                            <div class="address-input">
                                <input
                                    type="text"
                                    placeholder="City/Municipality"
                                    :value="
                                        personalDetails.personal_details
                                            .residential_address.municipality
                                    "
                                />
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    placeholder="Province"
                                    :value="
                                        personalDetails.personal_details
                                            .residential_address.province
                                    "
                                />
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <label for="">Zip Code:</label>
                        <input
                            type="text"
                            :value="
                                personalDetails.personal_details
                                    .residential_address.zip_code
                            "
                        />
                    </div>
                    <div class="address-container">
                        <div class="address">
                            <label for="">Permanent Address:</label>
                        </div>
                        <div class="address">
                            <div class="address-input">
                                <input
                                    type="text"
                                    placeholder="House/Block/Lot No."
                                    :value="
                                        personalDetails.personal_details
                                            .permanent_address.house_no
                                    "
                                />
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    placeholder="Street"
                                    :value="
                                        personalDetails.personal_details
                                            .permanent_address.street
                                    "
                                />
                            </div>
                            <div class="address-input">
                                <input
                                    type="text"
                                    placeholder="Subdivision/Village"
                                    :value="
                                        personalDetails.personal_details
                                            .permanent_address.subdv
                                    "
                                />
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    placeholder="Barangay"
                                    :value="
                                        personalDetails.personal_details
                                            .permanent_address.brgy
                                    "
                                />
                            </div>
                            <div class="address-input">
                                <input
                                    type="text"
                                    placeholder="City/Municipality"
                                    :value="
                                        personalDetails.personal_details
                                            .permanent_address.municipality
                                    "
                                />
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    placeholder="Province"
                                    :value="
                                        personalDetails.personal_details
                                            .permanent_address.province
                                    "
                                />
                            </div>
                        </div>
                    </div>
                    <div class="items">
                        <label for="">Zip Code:</label>
                        <input
                            type="text"
                            :value="
                                personalDetails.personal_details
                                    .permanent_address.zip_code
                            "
                        />
                    </div>
                    <div
                        v-for="job_detail in personalDetails.user_job_details"
                        :key="job_detail.id"
                    >
                        <div class="items">
                            <label for="">Date Hired:</label>
                            <input type="text" :value="job_detail.date_hired" />
                        </div>

                        <div class="items">
                            <label for="">Present Rank in MDC:</label>
                            <input type="text" :value="job_detail.rank" />
                        </div>

                        <div class="items">
                            <label for="">Department:</label>
                            <input type="text" :value="job_detail.department" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-container">
                <div class="title">II. FAMILY BACKGROUND</div>
                <div class="forms">
                    <div class="form-group left">
                        <div
                            v-for="family in personalDetails.user_families.filter(
                                (family) => family.type !== 'child'
                            )"
                            :key="family.id"
                        >
                            <div class="family-items">
                                <div class="family-type-div">
                                    <label for=""
                                        >{{
                                            family.type
                                                .charAt(0)
                                                .toUpperCase() +
                                            family.type.slice(1)
                                        }}:</label
                                    >
                                </div>
                                <div class="family-items-div">
                                    <label for=""
                                        >First Name:<span>
                                            {{ family.first_name }}</span
                                        ></label
                                    ><br />
                                    <label for=""
                                        >Middle Name:<span>
                                            {{ family.middle_name }}</span
                                        ></label
                                    ><br />
                                    <label for=""
                                        >Last Name:<span>
                                            {{ family.last_name }}
                                        </span></label
                                    ><br />
                                    <label for=""
                                        >Birth Date:<span>{{
                                            family.DOB
                                        }}</span></label
                                    ><br />
                                    <label for=""
                                        >Occupation:
                                        <span>
                                            {{ family.occupation }}</span
                                        ></label
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group right">
                        <div
                            class="children-container"
                            v-for="family in personalDetails.user_families.filter(
                                (family) => family.type === 'child'
                            )"
                            :key="family.id"
                        >
                            <div class="family-items">
                                <div class="family-type-div">
                                    <label for=""
                                        >{{
                                            family.type
                                                .charAt(0)
                                                .toUpperCase() +
                                            family.type.slice(1)
                                        }}:</label
                                    >
                                </div>
                                <div class="family-items-div">
                                    <label for=""
                                        >First Name:<span>
                                            {{ family.first_name }}</span
                                        ></label
                                    ><br />
                                    <label for=""
                                        >Middle Name:<span>
                                            {{ family.middle_name }}</span
                                        ></label
                                    ><br />
                                    <label for=""
                                        >Last Name:<span>
                                            {{ family.last_name }}
                                        </span></label
                                    ><br />
                                    <label for=""
                                        >Birth Date:<span>{{
                                            family.DOB
                                        }}</span></label
                                    ><br />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-container">
                <div class="title">III. EDUCATIONAL BACKGROUND</div>

                <div class="education-table-container">
                    <table class="education-table">
                        <thead>
                            <tr>
                                <th rowspan="2">Level</th>
                                <th rowspan="2">Name of School</th>
                                <th rowspan="2">
                                    Degree/ <br />
                                    Course
                                </th>
                                <th colspan="2">Period of Attendance</th>
                                <th rowspan="2">
                                    Units <br />
                                    Earned
                                </th>
                                <th rowspan="2">
                                    Year <br />
                                    Graduated
                                </th>
                                <th rowspan="2">
                                    Scholarship/<br />Academic <br />
                                    Honors Received
                                </th>
                            </tr>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="education in personalDetails.user_educational_backgrounds"
                            >
                                <td>{{ getLevelDisplay(education.level) }}</td>
                                <td>{{ education.school_name || "N/A" }}</td>
                                <td>{{ education.course || "N/A" }}</td>
                                <td>
                                    {{
                                        education.period_attendance_from ||
                                        "N/A"
                                    }}
                                </td>
                                <td>
                                    {{
                                        education.period_attendance_to || "N/A"
                                    }}
                                </td>
                                <td>{{ education.units || "N/A" }}</td>
                                <td>{{ education.year_graduated || "N/A" }}</td>
                                <td>
                                    {{
                                        education.acad_honors_received || "N/A"
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="signature-container">
                    <div class="signature">
                        <label for="">SIGNATURE</label>
                        <input type="text" />
                    </div>

                    <div class="date">
                        <label for="">DATE</label>
                        <input type="date" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
::-webkit-scrollbar {
    width: 5px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.header {
    display: flex;
    flex-direction: column;
    text-align: left;
}

h3,
p,
h2 {
    text-align: center;
    margin: 0;
    padding: 0;
}
.page-content {
    background-color: #fff;
    padding: 20px;
    width: 800px;
    text-align: center;
    display: flex; /* Changed from block to flex for better alignment */
    flex-direction: column;
    margin: auto; /* Center the content */
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.main-container {
    border: 2px solid black;
    max-width: 80%;
    width: 100%;
    background-color: white;
}

.sub-container {
    font-size: 12px;
    border: 1px solid black;
    background-color: #fff;
}

.sub-container input {
    border: none;
}

.title {
    font-weight: bold;
    padding: 5px;
    background-color: blue;
    width: auto;
    color: white;
}

.id-number {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 2px;
    align-items: center;
    font-size: 12px;
}

.forms {
    display: flex;
    flex-direction: row;
    width: auto;
}

.form-group {
    padding: 5px 5px 0 5px;
    width: 50%;
    display: flex;
    flex-direction: column;
}

.checkbox-group {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: start;
}

.items {
    /* padding: 5px 5px 5px 5px; */
    display: flex;
    align-items: center;
    gap: 5px;
    width: 100%;
    max-width: 100%;
    border-bottom: 1px solid black;
    /* padding: 5px;
    margin: 0; */
}

.family-items {
    display: flex;
    align-items: start;
    gap: 5px;
    width: 100%;
    max-width: 100%;
    border-bottom: 1px solid black;
}
.family-type-div {
    width: 50px;
}
.family-items-div {
    text-align: left;
}

.item {
    /* padding: 5px 5px 5px 5px; */
    display: flex;
    gap: 30px;
    border-bottom: 1px solid black;
    /* padding: 5px;
    margin: 0; */
}

.items label {
    margin-right: 10px;
    width: 100%;
    max-width: 100%;
}
.citizen-container {
    display: flex;
    flex-direction: row;
    align-items: center;
}

.citizenship {
    display: flex;
    justify-content: center;
    align-items: center;
    width: auto;
}

.sex {
    display: flex;
    flex-direction: row;
    /* justify-content: center; */
    align-items: center;
    /* margin: auto; */
}

.civil-status {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: left;
    /* border-bottom: 1px solid black; */
}

.civil-group {
    display: flex;
    flex-direction: row;
    align-items: center;
}
.civil-status label {
    margin-right: 5px;
}
.dual-option {
    width: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-bottom: 5px;
    border-bottom: 1px solid black;
}

.address-container {
    display: flex;
    flex-direction: row;
    margin-left: -5px;
    width: auto;
    border-bottom: 1px solid black;
}
.address {
    flex-direction: column;

    padding: 5px 5px 5px 5px;
    display: flex;
    align-items: center;
    gap: 2px;
    width: auto;
    /* border-bottom: 1px solid black; */
}

.address-input {
    display: flex;
    flex-direction: row;
    width: auto;
}

.address-input input {
    width: 100%;
    max-width: 100%;
    border: none;
    border-bottom: 1px solid black;
}
.children-container {
    display: flex;
    flex-direction: row;
    display: flex;
    justify-content: center;
    align-items: center;
}

.children-container input {
    width: 100%;
    max-width: 100%;
    border-bottom: 1px solid black;
}

.children-name,
.birthdate {
    flex: 1; /* Make both sections equal width */
    padding: 5px 5px 0 0; /* Add spacing inside */
    border-right: 2px solid black; /* Creates a vertical border between sections */
}

.birthdate {
    border-right: none; /* Removes border from the last column */
}

.education-table-container {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scrolling if needed */
}

.education-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto; /* Allows columns to adjust dynamically */
}
.education-table td {
    height: 5px;
}

.education-table th,
.education-table td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
    white-space: nowrap; /* Prevents text from wrapping in headers */
}

.education-table input {
    width: 100%; /* Ensures inputs take full width */
    min-width: 80px; /* Prevents inputs from shrinking too much */
    /* padding: 4px; */
}

@media (max-width: 768px) {
    .education-table th,
    .education-table td {
        font-size: 12px;
        padding: 5px;
    }

    .education-table input {
        min-width: 60px;
    }
}

.signature-container {
    padding: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.signature-container label {
    margin-right: 5px;
    font-weight: bold;
}

.signature,
.date {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 0 5px 0 5px;
}

.form-group.left {
    border-right: 1px solid black;
}

.form-group.right {
    border-left: 1px solid black;
}

.small-input {
    margin-right: 5px;
    border: none;
    border-bottom: 1px solid black;
    width: 70px;
}
.header-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

.logo img {
    margin-right: 10px;
    width: 80px;
    height: auto;
}

span {
    font-size: 12px;
    font-weight: bold;
    padding: 0 10px 0 10px;
}
</style>
