<template>
    <div class="p-6 bg-white shadow rounded-lg">
        <!-- Heading -->
        <h1 class="text-2xl font-bold mb-6">Travel Application Form</h1>

        <!-- Office/Department Form -->
        <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Office/Department -->
            <div>
                <label
                    for="office"
                    class="block text-sm font-medium text-gray-700"
                    >Office/Department</label
                >
                <input
                    type="text"
                    id="office"
                    v-model="form.office"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter office or department"
                    required
                />
            </div>

            <!-- Last Name -->
            <div>
                <label
                    for="last_name"
                    class="block text-sm font-medium text-gray-700"
                    >Last Name</label
                >
                <input
                    type="text"
                    id="last_name"
                    v-model="form.lastName"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter last name"
                    required
                />
            </div>

            <!-- First Name -->
            <div>
                <label
                    for="first_name"
                    class="block text-sm font-medium text-gray-700"
                    >First Name</label
                >
                <input
                    type="text"
                    id="first_name"
                    v-model="form.firstName"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter first name"
                    required
                />
            </div>

            <!-- Middle Name -->
            <div>
                <label
                    for="middle_name"
                    class="block text-sm font-medium text-gray-700"
                    >Middle Name</label
                >
                <input
                    type="text"
                    id="middle_name"
                    v-model="form.middleName"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter middle name"
                />
            </div>
        </form>

        <!-- Details of Official Travel -->
        <h2 class="text-xl font-bold mt-8 mb-4">Details of Official Travel</h2>
        <form @submit.prevent="submitTravelDetails" class="space-y-4">
            <div>
                <label
                    for="dates"
                    class="block text-sm font-medium text-gray-700"
                    >Date(s) of Travel</label
                >
                <input
                    type="date"
                    id="dates"
                    v-model="travelForm.dates"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
            </div>

            <div>
                <label
                    for="place"
                    class="block text-sm font-medium text-gray-700"
                    >Place</label
                >
                <input
                    type="text"
                    id="place"
                    v-model="travelForm.place"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter the place of travel"
                    required
                />
            </div>

            <div>
                <label
                    for="purpose"
                    class="block text-sm font-medium text-gray-700"
                    >Purpose/Event</label
                >
                <input
                    type="text"
                    id="purpose"
                    v-model="travelForm.purpose"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter the purpose or event"
                    required
                />
            </div>

            <div>
                <label
                    for="organizer"
                    class="block text-sm font-medium text-gray-700"
                    >Organizer/Contact Person</label
                >
                <input
                    type="text"
                    id="organizer"
                    v-model="travelForm.organizer"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter the organizer or contact person"
                    required
                />
            </div>

            <div>
                <label
                    for="description"
                    class="block text-sm font-medium text-gray-700"
                    >Short Description</label
                >
                <textarea
                    id="description"
                    v-model="travelForm.description"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter a short description of the purpose or event"
                    rows="4"
                    required
                ></textarea>
            </div>
        </form>

        <!-- Budgetary Requirements -->
        <h2 class="text-xl font-bold mt-8 mb-4">Budgetary Requirements</h2>
        <div class="grid grid-cols-2 gap-6">
            <!-- Left Side: Budget Items -->
            <div>
                <!-- <h3 class="text-lg font-semibold mb-2">Expenses:</h3> -->
                <div class="space-y-2">
                    <div>
                        <input
                            type="checkbox"
                            id="registration"
                            v-model="budget.registration"
                        />
                        <label for="registration" class="ml-2 text-gray-700"
                            >Registration</label
                        >
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            id="transportation"
                            v-model="budget.transportation"
                        />
                        <label for="transportation" class="ml-2 text-gray-700"
                            >Transportation</label
                        >
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            id="representation"
                            v-model="budget.representation"
                        />
                        <label for="representation" class="ml-2 text-gray-700"
                            >Representation Allowance</label
                        >
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            id="miscellaneous"
                            v-model="budget.miscellaneous"
                        />
                        <label for="miscellaneous" class="ml-2 text-gray-700"
                            >Miscellaneous</label
                        >
                    </div>
                </div>
            </div>

            <!-- Right Side: Budget Charged To -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Budget charged to:</h3>
                <div class="space-y-2">
                    <div>
                        <input
                            type="checkbox"
                            id="departmental"
                            v-model="budget.departmentalFund"
                        />
                        <label for="departmental" class="ml-2 text-gray-700"
                            >Departmental fund</label
                        >
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            id="office"
                            v-model="budget.officeBudget"
                        />
                        <label for="office" class="ml-2 text-gray-700"
                            >Departmental/office budget</label
                        >
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            id="school"
                            v-model="budget.schoolFund"
                        />
                        <label for="school" class="ml-2 text-gray-700"
                            >School fund</label
                        >
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            id="others"
                            v-model="budget.others"
                        />
                        <label for="others" class="ml-2 text-gray-700"
                            >Others, specify</label
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
};
</script>
