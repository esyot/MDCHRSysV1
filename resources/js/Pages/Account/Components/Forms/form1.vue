<template>
    <div class="personal-details-items" v-if="editMode == true">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION</span>
        </div>
        <div class="form-group">
            <label for="last_name">SURNAME</label>
            <input
                type="text"
                id="last_name"
                v-model="userDetails.last_name"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="first_name">FIRST NAME:</label>
            <input
                type="text"
                id="first_name"
                v-model="userDetails.first_name"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="middle_name">MIDDLE NAME:</label>
            <input
                type="text"
                id="middle_name"
                v-model="userDetails.middle_name"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="name_extension">NAME EXTENSION:</label>
            <input
                type="text"
                id="name_extension"
                v-model="userDetails.name_extension"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="nick_name">NICKNAME:</label>
            <input
                type="text"
                id="nick_name"
                v-model="userDetails.nick_name"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="date_of_birth">DATE OF BIRTH:</label>
            <input
                type="date"
                id="date_of_birth"
                v-model="userDetails.date_of_birth"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="place_of_birth">PLACE OF BIRTH:</label>
            <input
                type="text"
                id="place_of_birth"
                v-model="userDetails.place_of_birth"
                class="form-control"
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
                    />
                    Separated
                </label>
                <label>
                    <input
                        type="radio"
                        name="civil_status"
                        value="others"
                        class="form-control-radio"
                        v-model="userDetails.civil_status"
                    />
                    Other/s:
                </label>
                <input
                    type="text"
                    name="others"
                    id="others"
                    v-model="userDetails.others"
                    class="form-control"
                />
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
            />
        </div>
        <div class="form-group">
            <label for="blood_type">BLOOD TYPE:</label>
            <input
                type="text"
                name="blood_type"
                id="blood_type"
                v-model="userDetails.blood_type"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="contact">TEL NO./MOBILE NO.:</label>
            <input
                type="text"
                name="contact"
                id="contact"
                v-model="userDetails.contact"
                class="form-control"
                placeholder="eg. 09123456789"
            />
        </div>
        <div class="form-group">
            <label for="citizenship">CITIZENSHIP:</label>
            <div class="select-group">
                <select
                    name="citizenship"
                    id="citizenship"
                    v-model="userDetails.citizenship"
                >
                    <option value="Select">Select Citizenship</option>
                    <option value="Filipino">Filipino</option>
                </select>
            </div>
            <div class="form-group">
                <div class="radio-group">
                    <label>
                        <input
                            type="radio"
                            name="citizenship"
                            value="by_birth"
                            class="form-control-radio"
                            v-model="userDetails.citizenship"
                        />
                        By Birth
                    </label>
                    <label>
                        <input
                            type="radio"
                            name="citizenship"
                            value="by_naturalization"
                            class="form-control-radio"
                            v-model="userDetails.citizenship"
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
                name="messenger_acct"
                id="messenger_acct"
                v-model="userDetails.messenger_acct"
                class="form-control"
            />
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION</span>
        </div>
        <div class="form-group">
            <label for="address">ADDRESS:</label>
            <div class="address-group">
                <div class="form-group">
                    <label for="house_block_lot_no">HOUSE/BLOCK/LOT NO.:</label>
                    <input
                        type="text"
                        name="house_block_lot_no"
                        id="house_block_lot_no"
                        v-model="userDetails.house_block_lot_no"
                        class="form-control"
                        placeholder="House No."
                    />
                </div>
                <div class="form-group">
                    <label for="street">STREET:</label>
                    <input
                        type="text"
                        name="street"
                        id="street"
                        v-model="userDetails.street"
                        class="form-control"
                        placeholder="Street Name"
                    />
                </div>
                <div class="form-group">
                    <label for="sub_village">SUBDIVISION/VILLAGE:</label>
                    <input
                        type="text"
                        name="sub_village"
                        id="sub_village"
                        v-model="userDetails.sub_village"
                        class="form-control"
                        placeholder="Subdivision Name"
                    />
                </div>
                <div class="form-group">
                    <label for="barangay">BARANGAY:</label>
                    <input
                        type="text"
                        name="barangay"
                        id="barangay"
                        v-model="userDetails.barangay"
                        class="form-control"
                        placeholder="Barangay Name"
                    />
                </div>
                <div class="form-group">
                    <label for="city_municipality">CITY/MUNICIPALITY:</label>
                    <input
                        type="text"
                        name="city_municipality"
                        id="city_municipality"
                        v-model="userDetails.city_municipality"
                        class="form-control"
                        placeholder="City/Municipality Name"
                    />
                </div>
                <div class="form-group">
                    <label for="province">PROVINCE:</label>
                    <input
                        type="text"
                        name="province"
                        id="province"
                        v-model="userDetails.province"
                        class="form-control"
                        placeholder="Province Name"
                    />
                </div>
                <div class="form-group">
                    <label for="zip_code">ZIP CODE:</label>
                    <input
                        type="text"
                        name="zip_code"
                        id="zip_code"
                        v-model="userDetails.zip_code"
                        class="form-control"
                        placeholder="Zip Code"
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
                        v-model="userDetails.house_block_lot_no"
                        class="form-control"
                        placeholder="House No."
                    />
                </div>
                <div class="form-group">
                    <label for="street">STREET:</label>
                    <input
                        type="text"
                        name="street"
                        id="street"
                        v-model="userDetails.street"
                        class="form-control"
                        placeholder="Street Name"
                    />
                </div>
                <div class="form-group">
                    <label for="sub_village">SUBDIVISION/VILLAGE:</label>
                    <input
                        type="text"
                        name="sub_village"
                        id="sub_village"
                        v-model="userDetails.sub_village"
                        class="form-control"
                        placeholder="Subdivision Name"
                    />
                </div>
                <div class="form-group">
                    <label for="barangay">BARANGAY:</label>
                    <input
                        type="text"
                        name="barangay"
                        id="barangay"
                        v-model="userDetails.barangay"
                        class="form-control"
                        placeholder="Barangay Name"
                    />
                </div>
                <div class="form-group">
                    <label for="city_municipality">CITY/MUNICIPALITY:</label>
                    <input
                        type="text"
                        name="city_municipality"
                        id="city_municipality"
                        v-model="userDetails.city_municipality"
                        class="form-control"
                        placeholder="City/Municipality Name"
                    />
                </div>
                <div class="form-group">
                    <label for="province">PROVINCE:</label>
                    <input
                        type="text"
                        name="province"
                        id="province"
                        v-model="userDetails.province"
                        class="form-control"
                        placeholder="Province Name"
                    />
                </div>
                <div class="form-group">
                    <label for="zip_code">ZIP CODE:</label>
                    <input
                        type="text"
                        name="zip_code"
                        id="zip_code"
                        v-model="userDetails.zip_code"
                        class="form-control"
                        placeholder="Zip Code"
                    />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="date_hired">DATE HIRED:</label>
            <input
                type="date"
                name="date_hired"
                id="date_hired"
                v-model="userDetails.date_hired"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="rank">PRESENT RANK IN MDC:</label>
            <div class="select-group">
                <select
                    name="rank"
                    id="rank"
                    v-model="userDetails.rank"
                    class="form-control"
                >
                    <option value="">Select Rank</option>
                    <option value="Dean">Dean</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="department">DEPARTMENT</label>
            <div class="select-group">
                <select
                    name="department"
                    id="department"
                    v-model="userDetails.department"
                    class="form-control"
                >
                    <option value="">Select Department</option>
                    <option value="CAST">CAST</option>
                </select>
            </div>
        </div>
    </div>

    <div class="personal-details-items" v-if="editMode == false">
        <div class="title-container">
            <span class="title">PERSONAL INFORMATION</span>
        </div>

        <div class="form-group">
            <label for="">Name:</label>
            <span>
                {{ personalDetails.first_name }}
                {{ personalDetails.last_name }}
                {{ personalDetails.middle_name }}
            </span>

            <label for="">Address:</label>
            <span>
                {{ personalDetails.house_no }}, {{ personalDetails.street }},
                {{ personalDetails.brgy }}, {{ personalDetails.brgy }},

                {{ personalDetails.municipality }},
                {{ personalDetails.province }}, {{ personalDetails.zip_code }}.
            </span>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["update-user-details"],
    props: {
        userDetails: Object,
        editMode: Boolean,
        personalDetails: Object,
    },
    watch: {
        userDetails: {
            handler(newVal) {
                this.$emit("update-user-details", newVal);
            },
            deep: true,
        },
    },
};
</script>

<style scoped></style>
