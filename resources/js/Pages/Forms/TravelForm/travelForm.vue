
<script>
import Layout from "@/Layouts/layout.vue";

export default {
    data() {
        return {
            form: {
                office: "",
                lastName: "",
                firstName: "",
                middleName: "",
            },
            travelForm: {
                dates: "",
                place: "",
                purpose: "",
                organizer: "",
                description: "",
            },
            budget: {
                registration: false,
                transportation: false,
                representation: false,
                miscellaneous: false,
                departmentalFund: false,
                officeBudget: false,
                schoolFund: false,
                others: false,
                othersReason: "",
            },
        };
    },
    methods: {
        submitForm() {
            console.log("Office details:", this.form);
        },
        submitTravelDetails() {
            console.log("Travel details:", this.travelForm);
        },
    },
    layout: Layout,
};
</script>

<template>
    <div class="forms">
        <div class="forms-container">
         <div class="forms-title">
            <span class="title">TRAVEL APPLICATION FORM</span>
        </div>
        <div class="form-group">
            <label class="section-title">Office/Department:</label>
            <select name="" id="">
                <option value=""></option>
            </select>
        </div>


        <div class="form-group">
            <label for="last_name" class="input-label">Last Name</label>
            <input
                type="text"
                id="last_name"
                v-model="form.lastName"
                class="form-control"
                placeholder="Enter last name"
                required
            />
        </div>

        <div class="form-group">
            <label for="first_name" class="input-label">First Name</label>
            <input
                type="text"
                id="first_name"
                v-model="form.firstName"
                class="form-control"
                placeholder="Enter first name"
                required
            />
        </div>

        <div class="form-group">
            <label for="middle_name" class="input-label">Middle Name</label>
            <input
                type="text"
                id="middle_name"
                v-model="form.middleName"
                class="form-control"
                placeholder="Enter middle name"
            />
        </div>

        <form @submit.prevent="submitTravelDetails" class="form">
            <div class="form-group">
                <label for="dates" class="input-label">Date(s) of Travel</label>
                <input
                    type="date"
                    id="dates"
                    v-model="travelForm.dates"
                    class="form-control"
                    required
                />
            </div>

            <div class="form-group">
                <label for="place" class="input-label">Place</label>
                <input
                    type="text"
                    id="place"
                    v-model="travelForm.place"
                    class="form-control"
                    placeholder="Enter the place of travel"
                    required
                />
            </div>

            <div class="form-group">
                <label for="purpose" class="input-label">Purpose/Event</label>
                <input
                    type="text"
                    id="purpose"
                    v-model="travelForm.purpose"
                    class="form-control"
                    placeholder="Enter the purpose or event"
                    required
                />
            </div>

            <div class="form-group">
                <label for="organizer" class="input-label"
                    >Organizer/Contact Person</label
                >
                <input
                    type="text"
                    id="organizer"
                    v-model="travelForm.organizer"
                    class="form-control"
                    placeholder="Enter the organizer or contact person"
                    required
                />
            </div>

            <div class="form-group">
                <label for="description" class="input-label"
                    >Short Description</label
                >
                <textarea
                    id="description"
                    v-model="travelForm.description"
                    class="form-control"
                    placeholder="Enter a short description of the purpose or event"
                    rows="4"
                    required
                ></textarea>

        </div>
        </form>

        <div class="form-grid">

            <div>
                <label class="section-title">Budgetary Requirements</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="registration"
                            v-model="budget.registration"
                        />
                        <label for="registration" class="checkbox-label"
                            >Registration</label
                        >
                    </div>
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="transportation"
                            v-model="budget.transportation"
                        />
                        <label for="transportation" class="checkbox-label"
                            >Transportation</label
                        >
                    </div>
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="representation"
                            v-model="budget.representation"
                        />
                        <label for="representation" class="checkbox-label"
                            >Representation Allowance</label
                        >
                    </div>
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="miscellaneous"
                            v-model="budget.miscellaneous"
                        />
                        <label for="miscellaneous" class="checkbox-label"
                            >Miscellaneous</label
                        >
                    </div>
                </div>
            </div>

            <!-- Right Side: Budget Charged To -->
            <div>
                <label class="section-title">Budget Charged To</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="departmental"
                            v-model="budget.departmentalFund"
                        />
                        <label for="departmental" class="checkbox-label"
                            >Departmental fund</label
                        >
                    </div>
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="office"
                            v-model="budget.officeBudget"
                        />
                        <label for="office" class="checkbox-label"
                            >Departmental/office budget</label
                        >
                    </div>
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="school"
                            v-model="budget.schoolFund"
                        />
                        <label for="school" class="checkbox-label"
                            >School fund</label
                        >
                    </div>
                    <div class="checkbox-item">
                        <input
                            type="checkbox"
                            id="others"
                            v-model="budget.others"
                        />
                        <label for="others" class="checkbox-label"
                            >Others, specify</label
                        >
                        <div v-if="budget.others">
                            <input
                                type="text"
                                v-model="budget.othersReason"
                                class="input-field"
                                placeholder="Specify the reason"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
</div>
    </div>
    </div>
</template>

<style>

.forms{
    background-color: #fff;
    height: 90vh;
    overflow-y: auto;
    margin: 0.5rem;
}
.forms-container{
    height: 40vh;
    flex-grow: 1;
    flex-basis: 400px;
    /* background-color: #692424; */

}

.form-group{
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
.forms-title{
    border-bottom: #dedede 1px solid;
    background-color: #fff;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1;
    padding: 10px;
}

.forms-title .title{

    font-size: 16px;
    font-weight: bold;

}

.section-title{
    font-size: 18px;
}


.table-container {
    margin: 20px 0;
    font-family: Arial, sans-serif;
}

/* Section title */
.section-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
}

/* Input container */
.input-container {
    margin-bottom: 20px;
}

.input-container label {
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
}

.input-container .input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}


.overflow-container {
    overflow-x: auto;
    margin-top: 10px;
}
</style>
