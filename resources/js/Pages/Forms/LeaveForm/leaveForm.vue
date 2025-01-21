<template>
    <div class="forms-container">
        <div class="forms">
            <div class="forms-title">
                <span class="title">LEAVE APPLICATION</span>
            </div>
            <div class="form-details">
                <label for="departments">OFFICE/DEPARTMENT</label>
                <select
                    name="departments"
                    id="departments"
                    class="forms-controller"
                >
                    <option value="">ELEM</option>
                    <option value="">BSCRIM</option>
                    <option value="">BSN</option>
                    <option value="">BSED</option>
                    <option value="">CON</option>
                </select>
            </div>
            <div class="form-details">
                <label for="last_name">LAST NAME: </label>
                <input
                    type="text"
                    id="last_name"
                    class="forms-controller"
                    placeholder="eg., Christoper"
                />
            </div>
            <div class="form-details">
                <label for="first_name">FIRST NAME:</label>
                <input
                    type="text"
                    id="first_name"
                    class="forms-controller"
                    placeholder="eg., Sab"
                />
            </div>
            <div class="form-details">
                <label for="middle_name">MIDDLE NAME:</label>
                <input
                    type="text"
                    id="middle_name"
                    class="forms-controller"
                    placeholder="eg., Seguirel"
                />
            </div>
            <div class="form-details">
                <label for="date_filed">DATE OF FILING:</label>
                <input type="date" id="date_filed" class="forms-controller" />
            </div>
            <div class="form-details">
                <label for="position">POSITION:</label>
                <input
                    type="text"
                    id="position"
                    class="forms-controller"
                    placeholder="eg., College Dean"
                />
            </div>
            <div class="form-details">
                <label for="rank">RANK:</label>
                <input
                    type="text"
                    id="rank"
                    class="forms-controller"
                    placeholder="eg., Professor"
                />
            </div>
        </div>
        <div class="forms">
            <div class="forms-title">
                <span class="title">DETAILS OF APPLICATION</span>
            </div>
            <div class="form-details">
                <label for="leave_name">TYPE OF LEAVE:</label>
                <select
                    id="leave_name"
                    v-model="leave_type"
                    class="forms-controller"
                >
                    <option value="VACATION">VACATION</option>
                    <option value="MATERNITY">MATERNITY</option>
                    <option value="PATERNITY">PATERNITY</option>
                    <option value="SICK">SICK</option>
                    <option value="EDUCATIONAL">EDUCATIONAL</option>
                    <option value="OTHERS">OTHERS</option>
                </select>
            </div>
            <div class="form-details" v-show="leave_type === 'VACATION'">
                <label for="leave_type_vacation"
                    >In case of Vacation Leave:</label
                >
                <select id="leave_type_vacation" v-model="leave_vacation">
                    <option value="Within the Philippines">
                        Within the Philippines
                    </option>
                    <option value="Abroad">Abroad</option>
                </select>
            </div>
            <div
                class="form-details"
                v-show="leave_vacation === 'Within the Philippines'"
            >
                <label for="leave_vacation_phil"
                    >If within the Philippines, please specify:</label
                >
                <input
                    type="text"
                    id="leave_vacation_phil"
                    class="forms-controller"
                    placeholder="eg., Bohol, Tubigon"
                />
            </div>
            <div class="form-details" v-show="leave_vacation === 'Abroad'">
                <label for="leave_vacation_abroad"
                    >If Abroad, please specify:</label
                >
                <input
                    type="text"
                    id="leave_vacation_abroad"
                    class="forms-controller"
                    placeholder="eg., Tokyo, Japan"
                />
            </div>
            <div class="form-details" v-show="leave_type === 'SICK'">
                <label for="leave_type_sick">In case of Sick Leave:</label>
                <select id="leave_type_sick" v-model="leave_sick">
                    <option value="In Hospital">In Hospital</option>
                    <option value="Out Patient">Out Patient</option>
                    <option value="Home Medication">Home Medication</option>
                </select>
            </div>
            <div class="form-details" v-show="leave_sick === 'In Hospital'">
                <label for="leave_sick_hospital"
                    >If in Hospital, please specify ILLNESS:</label
                >
                <input
                    type="text"
                    id="leave_sick_hospital"
                    class="forms-controller"
                    placeholder="eg., Covid 19"
                />
            </div>
            <div class="form-details" v-show="leave_sick === 'Out Patient'">
                <label for="leave_sick_outpatient"
                    >If Out Patient, please specify ILLNESS:</label
                >
                <input
                    type="text"
                    id="leave_sick_outpatient"
                    class="forms-controller"
                    placeholder="eg., Fever"
                />
            </div>
            <div class="form-details" v-show="leave_sick === 'Home Medication'">
                <label for="leave_sick_home_medication"
                    >If Home Medication, please specify ILLNESS:</label
                >
                <input
                    type="text"
                    id="leave_sick_home_medication"
                    class="forms-controller"
                    placeholder="eg., Headache"
                />
            </div>

            <div class="form-details" v-show="leave_type === 'EDUCATIONAL'">
                <label for="leave_type_educational">
                    In case of Educational Leave:
                </label>
                <select id="leave_type_educational" v-model="leave_educ">
                    <option value="Completion of Doctor's Degree">
                        Completion of Doctor's Degree
                    </option>
                    <option value="Completion of Master's Degree">
                        Completion of Master's Degree
                    </option>
                    <option value="Board Examination Review">
                        Board Examination Review
                    </option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="form-details" v-show="leave_educ === 'Others'">
                <label for="leave_educ_others">Please specify:</label>
                <input
                    type="text"
                    id="leave_educ_others"
                    class="forms-controller"
                    placeholder="eg., Completion of Certification"
                />
            </div>

            <div class="form-details" v-show="leave_type === 'OTHERS'">
                <label for="leave_type_others"
                    >If Others, please specify:</label
                >
                <input
                    type="text"
                    id="leave_type_others"
                    class="forms-controller"
                    placeholder="Enter details..."
                />
            </div>
            <div class="forms-title">
                <span class="title">TEACHING SUBSTITUTE</span>
            </div>
            <div class="form-detials">
                <span class="italic">(For MDC Teaching Employee only)</span>
            </div>
            <div class="form-details">
                <label for="sub">SUBJECT</label>
                <input
                    type="text"
                    id="sub"
                    class="form-controller"
                    placeholder="eg., Mathematics"
                />
            </div>
            <div class="form-details">
                <label for="time">TIME</label>
                <input type="time" id="time" class="form-controller" />
            </div>

            <div class="form-details">
                <label for="subs_teacher">SUBSTITUTE TEACHER</label>
                <input
                    type="text"
                    id="subs_teacher"
                    class="form-controller"
                    placeholder="eg., John Meward"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "@/Layouts/layout.vue";

export default {
    data() {
        return {
            leave_type: "",
            leave_vacation: "",
            leave_sick: "",
            leave_educ: "",
        };
    },
    watch: {
        leave_type(newVal) {
            if (newVal !== "VACATION") {
                this.leave_vacation = "";
            }
            if (newVal !== "SICK") {
                this.leave_sick = "";
            }
            if (newVal !== "EDUCATIONAL") {
                this.leave_educ = "";
            }
        },
    },
    layout: Layout,
};
</script>

<style scoped>
.forms-container {
    display: flex;
    height: 90vh;
    overflow-y: auto;
    margin: 0.5rem;
}
.forms {
    width: 100vw;
    flex-grow: 1;
    flex-basis: 400px;
}
.forms-title {
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

.forms-container {
    display: flex;
    flex-wrap: wrap;
    max-height: 90vh;
    overflow-y: auto;
    margin-top: 5px;
    gap: 0.5rem;
}

.forms {
    flex-grow: 1;
    flex-basis: 400px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
    overflow-y: auto;
}

.form-details {
    margin-bottom: 15px;
    padding: 10px;
}

.form-details label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 12px;
}

.form-details input {
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

.forms-controller-radio {
    margin-right: 5px;
}
.italic {
    font-style: italic;
    font-size: 12px;
    margin-left: 20px;
}
</style>
