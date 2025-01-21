<template>
    <div class="personal-details-items">
        <!-- Heading -->
        <div class="title-container">
            <span class="title">TRAVEL APPLICATION FORM</span>
        </div>
        <div class="form-group">
            <label for="office" class="input-label">Office/Department</label>
            <input
                type="text"
                id="office"
                v-model="form.office"
                class="form-control"
                placeholder="Enter office or department"
                required
            />
        </div>

        <!-- Last Name -->
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

        <!-- First Name -->
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

        <!-- Middle Name -->
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
        <!-- </form> -->

        <!-- Details of Official Travel -->
        <h2 class="section-heading">Details of Official Travel</h2>
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

        <!-- Budgetary Requirements -->
        <h2 class="section-heading">Budgetary Requirements</h2>
        <div class="form-grid">
            <!-- Left Side: Budgetary Requirements -->
            <div>
                <h3 class="section-title">Budgetary Requirements</h3>
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
                <h3 class="section-title">Budget Charged To</h3>
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
    </div>
</template>

<style>
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
    overflow-y: auto; /* Make it scrollable */
    height: 80vh; /* Set a height to enable scrolling */
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

.form-grid {
    display: flex;
    justify-content: space-between; /* Space out the two sections */
    gap: 1rem; /* Add space between the left and right sections */
}

.form-grid > div {
    flex: 1; /* Make both the left and right sections take equal width */
}
</style>

<script>
import Layout from "@/Layouts/Layout.vue";

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
                others: false, // Checkbox state for "Others"
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
