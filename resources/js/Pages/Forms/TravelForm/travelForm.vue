
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
                dateOfFiling: "",
                position: "",
                rank: "",
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
    <select name="office" id="office">
        <option value="CAST">CAST</option>
        <option value="CCJ">CCJ</option>
        <option value="COE">COE</option>
        <option value="CON">CON</option>
        <option value="CABM-B">CABM-B</option>
        <option value="CABM-H">CABM-H</option>
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

        <div class="form-group">
            <label for="date_of_filing" class="input-label">Date of filing</label>
            <input
                type="date"
                id="date_of_filing"
                v-model="form.dateOfFiling"
                class="form-control"
                required
            />
        </div>

        <div class="form-group">
            <label for="position" class="input-label">Position</label>
            <input
                type="text"
                id="position"
                v-model="form.position"
                class="form-control"
                placeholder="Enter position"
            />
        </div>

        <div class="form-group">
            <label for="rank" class="input-label">Rank</label>
            <input
                type="text"
                id="rank"
                v-model="form.rank"
                class="form-control"
                placeholder="Enter rank"
            />
        </div>

        <form @submit.prevent="submitTravelDetails" class="form">
            <!-- <label class="budget-title">Details of Official Travel</label> -->
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

        <label class="budget-title">Budgetary Requirements</label>
        <div class="form-grid">

            <div>

                <div class="budget-group">
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
                <label class="section-title">Budget charged to:</label>
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
                    <div class="checkbos-item">
                        <input
                            type="checkbox"
                            id="others"
                            v-model="budget.others"
                        />
                        <label for="others" class="checkbos-label"
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
.forms {
    background-color: #fff;
    height: 90vh;
    overflow-y: auto;
    margin: 0.5rem;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.forms-container {
    height: auto;
    flex-grow: 1;
    flex-basis: 400px;
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

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #4a90e2;
    outline: none;
}

.forms-title {
    border-bottom: 1px solid #dedede;
    background-color: #fff;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1;
    padding: 10px;
    border-radius: 8px 8px 0 0;
}

.forms-title .title {
    font-size: 16px;
    font-weight: bold;
}

.budget-title {
    font-size: 18px;
    font-weight: bold;
}
.section-title {
    font-size: 14px;
    padding: 5px 5px 20px 5px;
    color: #010000;
    font-weight: bold;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
    margin-bottom: 10px;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 5px;
}
.budget-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.checkbox-item {
    display: flex;
    align-items: center;
}

.checkbox-item input {
    margin-right: 8px;
}

.checkbox-label {
    font-size: 14px;
}

.input-field {
    width: 90%; /* Makes the input field take the full width of its container */
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s;
    margin-top: 8px; /* Adds spacing between the checkbox and input field */
}

.checkbos-item {
    margin-bottom: 15px; /* Adds some space below the checkbox item */
}

.checkbos-label {
    display: inline-block; /* Ensures the label and checkbox align properly */
    margin-left: 5px; /* Optional: adds space between the checkbox and label */
}


.input-field:focus {
    border-color: #4a90e2;
    outline: none;
}

</style>
