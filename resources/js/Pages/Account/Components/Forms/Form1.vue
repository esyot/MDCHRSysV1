<template>
    <div class="personal-details-items" v-if="editMode == true">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION (Page 1)</span>
        </div>
        <div class="form-group">
            <label for="first_name">FIRST NAME:</label>
            <input
                type="text"
                id="first_name"
                v-model="userDetails.first_name"
                class="form-control"
                @input="handleFieldFocus('first_name')"
            />
        </div>

        <div class="form-group">
            <label for="middle_name">MIDDLE NAME:</label>
            <input
                type="text"
                id="middle_name"
                v-model="userDetails.middle_name"
                class="form-control"
                @input="handleFieldFocus('middle_name')"
            />
        </div>
        <div class="form-group">
            <label for="last_name">LAST NAME</label>
            <input
                type="text"
                id="last_name"
                v-model="userDetails.last_name"
                class="form-control"
                @input="handleFieldFocus('last_name')"
            />
        </div>
        <div class="form-group">
            <label for="name_extension">NAME EXTENSION:</label>
            <input
                type="text"
                id="name_extension"
                v-model="userDetails.name_ext"
                class="form-control"
                @input="handleFieldFocus('name_ext')"
            />
        </div>
        <div class="form-group">
            <label for="nick_name">NICKNAME:</label>
            <input
                type="text"
                id="nick_name"
                v-model="userDetails.nickname"
                class="form-control"
                @input="handleFieldFocus('nickname')"
            />
        </div>
        <div class="form-group">
            <label for="date_of_birth">DATE OF BIRTH:</label>
            <input
                type="date"
                id="date_of_birth"
                v-model="userDetails.DOB"
                class="form-control"
                @input="handleFieldFocus('DOB')"
            />
        </div>
        <div class="form-group">
            <label for="place_of_birth">PLACE OF BIRTH:</label>
            <input
                type="text"
                id="place_of_birth"
                v-model="userDetails.birthplace"
                class="form-control"
                @input="handleFieldFocus('birthplace')"
            />
        </div>
        <div class="form-group">
            <label for="sex">SEX:</label>
            <div class="radio-group">
                <label for="male">
                    <input
                        type="radio"
                        id="male"
                        name="sex"
                        value="male"
                        class="form-control-radio"
                        v-model="userDetails.sex"
                        @click="handleFieldFocus('sex')"
                    />
                    Male
                </label>
                <label for="female">
                    <input
                        type="radio"
                        id="female"
                        name="sex"
                        value="female"
                        class="form-control-radio"
                        v-model="userDetails.sex"
                        @click="handleFieldFocus('sex')"
                    />
                    Female
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="civil_status">CIVIL STATUS:</label>
            <div class="radio-group">
                <label>
                    <input
                        type="radio"
                        name="civil_status"
                        value="single"
                        class="form-control-radio"
                        v-model="userDetails.civil_status"
                        @click="handleFieldFocus('civil_status')"
                    />
                    Single
                </label>
                <label>
                    <input
                        type="radio"
                        name="civil_status"
                        value="married"
                        class="form-control-radio"
                        v-model="userDetails.civil_status"
                        @click="handleFieldFocus('civil_status')"
                    />
                    Married
                </label>
                <label>
                    <input
                        type="radio"
                        name="civil_status"
                        value="widowed"
                        class="form-control-radio"
                        v-model="userDetails.civil_status"
                        @click="handleFieldFocus('civil_status')"
                    />
                    Widowed
                </label>
                <label>
                    <input
                        type="radio"
                        name="civil_status"
                        value="separated"
                        class="form-control-radio"
                        v-model="userDetails.civil_status"
                        @click="handleFieldFocus('civil_status')"
                    />
                    Separated
                </label>
                <label>
                    <input
                        type="radio"
                        name="civil_status"
                        value="divorced"
                        class="form-control-radio"
                        v-model="userDetails.civil_status"
                        @click="handleFieldFocus('civil_status')"
                    />
                    Divorced
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="religion">RELIGION:</label>
            <input
                type="text"
                name="religion"
                id="religion"
                v-model="userDetails.religion"
                class="form-control"
                @input="handleFieldFocus('religion')"
            />
        </div>
        <div class="form-group">
            <label for="height">HEIGHT:</label>
            <input
                type="text"
                name="height"
                id="height"
                v-model="userDetails.height"
                class="form-control"
                placeholder="Height in Meters"
                min="0"
                step="0.01"
                @click="handleFieldFocus('height')"
            />
        </div>
        <div class="form-group">
            <label for="weight">Weight:</label>
            <input
                type="text"
                name="weight"
                id="weight"
                v-model="userDetails.weight"
                class="form-control"
                placeholder="Weight in Kgs"
                min="0"
                @click="handleFieldFocus('weight')"
            />
        </div>
        <div class="form-group">
            <label for="blood_type">BLOOD TYPE:</label>
            <select
                name="blood_type"
                id="blood_type"
                v-model="userDetails.blood_type"
                class="form-control"
                @input="handleFieldFocus('blood_type')"
            >
                <option value="">Select Blood Type</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contact">TEL NO./MOBILE NO.:</label>
            <input
                type="text"
                name="contact"
                id="contact"
                v-model="userDetails.contact_no"
                class="form-control"
                placeholder="eg. 09123456789"
                @input="handleFieldFocus('contact_no')"
            />
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="citizenship">Citizenship:</label>
                <div class="radio-group">
                    <label for="Filipino">
                        <input
                            type="radio"
                            id="filipino"
                            name="citizenship"
                            value="filipino"
                            class="form-control-radio"
                            v-model="userDetails.citizenship"
                            @click="handleFieldFocus('citizenship')"
                        />
                        Filipino
                    </label>
                    <label for="dual_citizenship">
                        <input
                            type="radio"
                            id="dual_citizenship"
                            name="citizenship"
                            value="dual_citizenship"
                            class="form-control-radio"
                            v-model="userDetails.citizenship"
                            @click="handleFieldFocus('citizenship')"
                        />
                        Dual Citizenship
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="citizenship_type">Citizenship Type:</label>
                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            name="citizenship_type"
                            value="by_birth"
                            class="form-control-radio"
                            v-model="userDetails.citizenship_type"
                            @click="handleFieldFocus('citizenship_type')"
                        />
                        By Birth
                    </label>
                    <label>
                        <input
                            type="radio"
                            name="citizenship_type"
                            value="by_naturalization"
                            class="form-control-radio"
                            v-model="userDetails.citizenship_type"
                            @click="handleFieldFocus('citizenship_type')"
                        />
                        By Naturalization
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="messenger_acct">MESSENGER ACCT:</label>
            <input
                type="text"
                name="fb_link"
                id="fb_link"
                v-model="userDetails.fb_link"
                class="form-control"
                @input="handleFieldFocus('fb_link')"
            />
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION (Page 2)</span>
        </div>
        <div class="form-group">
            <label for="address">RESIDENTIAL ADDRESS:</label>
            <div class="address-group">
                <div class="form-group">
                    <label for="house_block_lot_no">HOUSE/BLOCK/LOT NO:</label>
                    <input
                        type="text"
                        v-model="userDetails.residential_address.house_no"
                        class="form-control"
                        placeholder="House No."
                        @input="
                            handleFieldFocus('residential_address.house_no')
                        "
                    />
                </div>
                <div class="form-group">
                    <label for="street">STREET:</label>
                    <input
                        type="text"
                        v-model="userDetails.residential_address.street"
                        class="form-control"
                        placeholder="Street Name"
                        @input="handleFieldFocus('residential_address.street')"
                    />
                </div>
                <div class="form-group">
                    <label for="sub_village">SUBDIVISION/VILLAGE:</label>
                    <input
                        type="text"
                        v-model="userDetails.residential_address.subdv"
                        class="form-control"
                        placeholder="Subdivision Name"
                        @input="handleFieldFocus('residential_address.subdv')"
                    />
                </div>
                <div class="form-group">
                    <label for="barangay">BARANGAY:</label>
                    <input
                        type="text"
                        v-model="userDetails.residential_address.brgy"
                        class="form-control"
                        placeholder="Barangay Name"
                        @input="handleFieldFocus('residential_address.brgy')"
                    />
                </div>
                <div class="form-group">
                    <label for="city_municipality">CITY/MUNICIPALITY:</label>
                    <input
                        type="text"
                        v-model="userDetails.residential_address.municipality"
                        class="form-control"
                        placeholder="City/Municipality Name"
                        @input="
                            handleFieldFocus('residential_address.municipality')
                        "
                    />
                </div>
                <div class="form-group">
                    <label for="province">PROVINCE:</label>
                    <input
                        type="text"
                        v-model="userDetails.residential_address.province"
                        class="form-control"
                        placeholder="Province Name"
                        @input="
                            handleFieldFocus('residential_address.province')
                        "
                    />
                </div>
                <div class="form-group">
                    <label for="zip_code">ZIP CODE:</label>
                    <input
                        type="text"
                        id="zip_code"
                        v-model="userDetails.residential_address.zip_code"
                        class="form-control"
                        placeholder="Zip Code"
                        @input="
                            handleFieldFocus('residential_address.zip_code')
                        "
                    />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="permanent_address">PERMANENT ADDRESS:</label>
            <div class="address-group">
                <div class="form-group">
                    <label for="house_block_lot_no">HOUSE/BLOCK/LOT NO.:</label>
                    <input
                        type="text"
                        name="house_block_lot_no"
                        id="house_block_lot_no"
                        v-model="userDetails.permanent_address.house_no"
                        class="form-control"
                        placeholder="House No."
                        @input="handleFieldFocus('permanent_address.house_no')"
                    />
                </div>
                <div class="form-group">
                    <label for="street">STREET:</label>
                    <input
                        type="text"
                        name="street"
                        id="street"
                        v-model="userDetails.permanent_address.street"
                        class="form-control"
                        placeholder="Street Name"
                        @input="handleFieldFocus('permanent_address.street')"
                    />
                </div>
                <div class="form-group">
                    <label for="sub_village">SUBDIVISION/VILLAGE:</label>
                    <input
                        type="text"
                        name="sub_village"
                        id="sub_village"
                        v-model="userDetails.permanent_address.subdv"
                        class="form-control"
                        placeholder="Subdivision Name"
                        @input="handleFieldFocus('permanent_address.subdv')"
                    />
                </div>
                <div class="form-group">
                    <label for="barangay">BARANGAY:</label>
                    <input
                        type="text"
                        name="barangay"
                        id="barangay"
                        v-model="userDetails.permanent_address.brgy"
                        class="form-control"
                        placeholder="Barangay Name"
                        @input="handleFieldFocus('permanent_address.brgy')"
                    />
                </div>
                <div class="form-group">
                    <label for="city_municipality">CITY/MUNICIPALITY:</label>
                    <input
                        type="text"
                        name="city_municipality"
                        id="city_municipality"
                        v-model="userDetails.permanent_address.municipality"
                        class="form-control"
                        placeholder="City/Municipality Name"
                        @input="
                            handleFieldFocus('permanent_address.municipality')
                        "
                    />
                </div>
                <div class="form-group">
                    <label for="province">PROVINCE:</label>
                    <input
                        type="text"
                        name="province"
                        id="province"
                        v-model="userDetails.permanent_address.province"
                        class="form-control"
                        placeholder="Province Name"
                        @input="handleFieldFocus('permanent_address.province')"
                    />
                </div>
                <div class="form-group">
                    <label for="zip_code">ZIP CODE:</label>
                    <input
                        type="text"
                        name="zip_code"
                        id="zip_code"
                        v-model="userDetails.permanent_address.zip_code"
                        class="form-control"
                        placeholder="Zip Code"
                        @input="handleFieldFocus('permanent_address.zip_code')"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION (Page 1)</span>
        </div>

        <div class="form-group">
            <label>Full Name:</label>
            <span
                >{{ personalDetails.first_name }}
                {{ personalDetails.middle_name }}
                {{ personalDetails.last_name }}
                <span
                    v-if="personalDetails.personal_details.name_ext != 'none'"
                >
                    {{ personalDetails.personal_details.name_ext }}
                </span>
            </span>

            <label>Nickname:</label>
            <span> {{ personalDetails.personal_details.nickname }} </span>

            <label>Date of Birth:</label>
            <span>{{ personalDetails.personal_details.DOB }}</span>

            <label>Place of Birth:</label>
            <span>{{ personalDetails.personal_details.birthplace }}</span>

            <label>Sex:</label>
            <span>{{ personalDetails.personal_details.sex }}</span>

            <label>Civil Status:</label>
            <span>{{ personalDetails.personal_details.civil_status }}</span>

            <label>Religion:</label>
            <span>{{ personalDetails.personal_details.religion }}</span>

            <label>Height:</label>
            <span>{{ personalDetails.personal_details.height }}</span>

            <label>Weight:</label>
            <span>{{ personalDetails.personal_details.weight }}</span>

            <label>Blood Type:</label>
            <span>{{ personalDetails.personal_details.blood_type }}</span>

            <label>Contact no:</label>
            <span>{{ personalDetails.personal_details.contact_no }}</span>

            <label>Citizenship:</label>
            <span
                >{{ personalDetails.personal_details.citizenship }}

                {{ personalDetails.personal_details.citizenship_type }}</span
            >
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION (Page 2)</span>
        </div>

        <div class="form-group">
            <label>Residential Address:</label>
            <span>
                {{
                    personalDetails.personal_details.residential_address
                        .house_no
                }},
                {{
                    personalDetails.personal_details.residential_address.street
                }},
                {{
                    personalDetails.personal_details.residential_address.subdv
                }},
                {{ personalDetails.personal_details.residential_address.brgy }},
                {{
                    personalDetails.personal_details.residential_address
                        .municipality
                }},
                {{
                    personalDetails.personal_details.residential_address
                        .province
                }},
                {{
                    personalDetails.personal_details.residential_address
                        .zip_code
                }}
            </span>

            <label>Permanent Address:</label>
            <span>
                {{
                    personalDetails.personal_details.permanent_address.house_no
                }},
                {{ personalDetails.personal_details.permanent_address.street }},
                {{ personalDetails.personal_details.permanent_address.subdv }},
                {{ personalDetails.personal_details.permanent_address.brgy }},
                {{
                    personalDetails.personal_details.permanent_address
                        .municipality
                }},
                {{
                    personalDetails.personal_details.permanent_address.province
                }},
                {{
                    personalDetails.personal_details.permanent_address.zip_code
                }}
            </span>

            <label>Messenger Account:</label>
            <span>{{ personalDetails.personal_details.fb_link }}</span>
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">Job Details</span>
        </div>
        <ul
            v-for="jobDetail in personalDetails.user_job_details"
            :key="jobDetail"
        >
            <li>Department: {{ jobDetail.department }}</li>
            <li>Current Rank: {{ jobDetail.rank }}</li>
            <li>Date Hired: {{ jobDetail.date_hired }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    emits: ["track-touched-field", "update-user-details"],
    props: {
        userDetails: Object,
        editMode: Boolean,
        personalDetails: Object,
    },
    data() {
        return {
            localUserDetails: { ...this.userDetails },
        };
    },
    methods: {
        handleFieldFocus(fieldName) {
            this.$emit("track-touched-field", fieldName);
        },

        handleFieldChange(fieldName) {
            this.$emit("update-user-details", {
                [fieldName]: this.userDetails[fieldName],
            });
        },
    },
    watch: {
        personalDetails: {
            handler(newVal) {
                this.userDetails.last_name = newVal.last_name || "";
                this.userDetails.first_name = newVal.first_name || "";
                this.userDetails.middle_name = newVal.middle_name || "";
                this.userDetails.name_ext =
                    newVal.personal_details.name_ext || "";
                this.userDetails.nickname =
                    newVal.personal_details.nickname || "";
                this.userDetails.DOB = newVal.personal_details.DOB || "";
                this.userDetails.birthplace =
                    newVal.personal_details.birthplace || "";
                this.userDetails.sex = newVal.personal_details.sex || "";
                this.userDetails.civil_status =
                    newVal.personal_details.civil_status || "";
                this.userDetails.religion =
                    newVal.personal_details.religion || "";
                this.userDetails.height = newVal.personal_details.height || "";
                this.userDetails.weight = newVal.personal_details.weight || "";
                this.userDetails.blood_type =
                    newVal.personal_details.blood_type || "";
                this.userDetails.contact_no =
                    newVal.personal_details.contact_no || "";
                this.userDetails.citizenship =
                    newVal.personal_details.citizenship || "";

                this.userDetails.citizenship_type =
                    newVal.personal_details.citizenship_type || "";

                this.userDetails.residential_address.house_no =
                    newVal.personal_details.residential_address.house_no || "";

                this.userDetails.residential_address.street =
                    newVal.personal_details.residential_address.street || "";

                this.userDetails.residential_address.subdv =
                    newVal.personal_details.residential_address.subdv || "";

                this.userDetails.residential_address.brgy =
                    newVal.personal_details.residential_address.brgy || "";

                this.userDetails.residential_address.municipality =
                    newVal.personal_details.residential_address.municipality ||
                    "";

                this.userDetails.residential_address.province =
                    newVal.personal_details.residential_address.province || "";

                this.userDetails.residential_address.zip_code =
                    newVal.personal_details.residential_address.zip_code || "";

                this.userDetails.permanent_address.house_no =
                    newVal.personal_details.permanent_address.house_no || "";

                this.userDetails.permanent_address.street =
                    newVal.personal_details.permanent_address.street || "";

                this.userDetails.permanent_address.subdv =
                    newVal.personal_details.permanent_address.subdv || "";

                this.userDetails.permanent_address.brgy =
                    newVal.personal_details.permanent_address.brgy || "";

                this.userDetails.permanent_address.municipality =
                    newVal.personal_details.permanent_address.municipality ||
                    "";

                this.userDetails.permanent_address.province =
                    newVal.personal_details.permanent_address.province || "";

                this.userDetails.permanent_address.zip_code =
                    newVal.personal_details.permanent_address.zip_code || "";

                this.userDetails.fb_link =
                    newVal.personal_details.fb_link || "";

                this.userDetails.user_job_details =
                    newVal.user_job_details || "";
            },
            immediate: true,
        },
    },
};
</script>
