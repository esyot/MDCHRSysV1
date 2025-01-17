<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">EDUCATIONAL BACKGROUND FORM</span>
        </div>

        <div class="form-group">
            <label for="level">SELECT LEVEL:</label>
            <select
                v-model="educLevel"
                class="form-control"
                @change="updateSelectedLevel"
            >
                <option value="">Select Type</option>
                <option value="elem">Elementary</option>
                <option value="sec">Secondary</option>
                <option value="college">College</option>
                <option value="gs">Graduate Study</option>
                <option value="pgs">Post Graduate Study</option>
            </select>
        </div>

        <div v-if="educLevel">
            <div class="form-group">
                <label for="school_name"
                    >{{ selectedLevel.toUpperCase() }} SCHOOL NAME:</label
                >
                <input
                    type="text"
                    v-model="userDetails.educDetails.school_name"
                    class="form-control"
                    placeholder="e.g. St. Paul College, University of the Philippines, etc."
                />
            </div>

            <div class="form-group">
                <label for="school_address"
                    >{{ selectedLevel.toUpperCase() }} SCHOOL ADDRESS:</label
                >
                <input
                    type="text"
                    v-model="userDetails.educDetails.school_address"
                    class="form-control"
                    placeholder="e.g. 1234, 5th Street, Brgy. San Isidro, Poblacion, Cebu City, etc."
                />
            </div>

            <div
                class="form-group"
                v-if="
                    educLevel === 'college' ||
                    educLevel === 'gs' ||
                    educLevel === 'pgs'
                "
            >
                <label for="course">COURSE:</label>
                <input
                    type="text"
                    v-model="userDetails.educDetails.course"
                    class="form-control"
                    placeholder="e.g. N/A"
                />
            </div>

            <div class="form-group">
                <label for="period_attendance_from"
                    >PERIOD ATTENDANCE FROM:</label
                >
                <input
                    type="date"
                    v-model="userDetails.educDetails.period_attendance_from"
                    class="form-control"
                    placeholder="e.g. 2020-01-01"
                />
            </div>

            <div class="form-group">
                <label for="period_attendance_to">PERIOD ATTENDANCE TO:</label>
                <input
                    type="date"
                    v-model="userDetails.educDetails.period_attendance_to"
                    class="form-control"
                    placeholder="e.g. 2020-01-01"
                />
            </div>

            <div
                class="form-group"
                v-if="
                    educLevel === 'college' ||
                    educLevel === 'gs' ||
                    educLevel === 'pgs'
                "
            >
                <label for="units">{{ educLevel.toUpperCase() }} UNITS:</label>
                <input
                    type="number"
                    v-model="userDetails.educDetails.units"
                    class="form-control"
                    placeholder="e.g. 60"
                />
            </div>

            <div class="form-group">
                <label for="year_graduated"
                    >YEAR GRADUATED FROM {{ educLevel.toUpperCase() }}:</label
                >
                <input
                    type="date"
                    v-model="userDetails.educDetails.year_graduated"
                    class="form-control"
                    placeholder="e.g. 2020"
                />
            </div>

            <div class="form-group">
                <label for="acads_honors_received"
                    >SCHOLARSHIP/ACADEMIC HONORS RECEIVED:</label
                >
                <input
                    type="text"
                    v-model="userDetails.educDetails.acads_honors_received"
                    class="form-control"
                    placeholder="e.g. Dean's Lister, etc."
                />
            </div>
        </div>
    </div>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">EDUCATIONAL BACKGROUND</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userDetails: Object, // Prop for passing userDetails to the form
    },
    data() {
        return {
            educLevel: "", // Selected educational level
        };
    },
    computed: {
        selectedLevel() {
            switch (this.educLevel) {
                case "elem":
                    return "elementary";
                case "sec":
                    return "secondary";
                case "college":
                    return "college";
                case "gs":
                    return "graduate study";
                case "pgs":
                    return "post graduate study";
                default:
                    return "";
            }
        },
    },
    watch: {
        // Watch for changes in userDetails to emit to parent component
        userDetails: {
            handler(newVal) {
                this.$emit("update-user-details", newVal);
            },
            deep: true, // Make sure nested properties are also tracked
        },
    },
};
</script>
