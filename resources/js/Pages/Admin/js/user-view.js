import Layout from "@/Layouts/Layout.vue";
import PersonalDetails from "@/Pages/Admin/PersonalDetails.vue";
import { Inertia } from "@inertiajs/inertia";
import EditUserModal from "@/Modals/EditUserModal.vue";
import EditDepartmentModal from "@/Modals/EditDepartmentModal.vue";
import EditStaffModal from "@/Modals/EditStaffModal.vue";
import EditTeacherModal from "@/Modals/EditTeacherModal.vue";

export default {
    layout: Layout,
    components: {
        PersonalDetails,
        EditUserModal,
        EditDepartmentModal,
        EditStaffModal,
        EditTeacherModal,
    },
    props: {
        userId: String,
        userRoles: Array,
        personalDetails: Object,
        userDepartment: Object,
        userPosition: String,
        forms: Object,
        roles: Array,
        roleList: Array,
        departmentList: Array,
        evaluations: Object,
        positionList: Array,
        specializationList: Array,
        teacher: Object,
        staff: Object,
        illness: Array,
    },
    data() {
        return {
            AdminActiveTab:
                localStorage.getItem("AdminActiveTab") || "overview",

            selectedFormType: "All",
            selectedFilter: "",
            form_selection: "",
            currentYear: new Date().getFullYear(),
            selected_year: new Date().getFullYear(),
            months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],

            form_type: "all",
            leave_type: "",
            illness_type: "",
            month: "",
            filter_by: "",
            week: "",
            isEditStaff: false,
            isEditTeacher: false,
            isEditUser: false,
        };
    },

    computed: {
        filteredForms() {
            let filtered = this.forms;

            if (this.form_type && this.form_type !== "all") {
                filtered = filtered.filter((item) => {
                    if (this.form_type === "travel") {
                        return item.form_type === "Travel Form";
                    } else if (this.form_type === "leave") {
                        return item.form_type === "Leave Form";
                    }
                    return true;
                });
            }

            if (this.selected_year) {
                filtered = filtered.filter((item) => {
                    const startYear = new Date(item.date_start).getFullYear();
                    const endYear = new Date(item.date_end).getFullYear();
                    return (
                        startYear === parseInt(this.selected_year) ||
                        endYear === parseInt(this.selected_year)
                    );
                });
            }

            if (this.filter_by && (this.month || this.week)) {
                const monthIndex = this.months.indexOf(this.month);
                filtered = filtered.filter((item) => {
                    const startDate = new Date(item.date_start);
                    const endDate = new Date(item.date_end);
                    const startMonth = startDate.getMonth();
                    const endMonth = endDate.getMonth();
                    const startWeek = this.getWeekOfMonth(startDate);
                    const endWeek = this.getWeekOfMonth(endDate);

                    let isMonthMatch = false;
                    if (this.filter_by === "Month") {
                        isMonthMatch =
                            startMonth === monthIndex ||
                            endMonth === monthIndex;
                    }

                    let isWeekMatch = false;
                    if (this.filter_by === "Week" && this.week) {
                        isWeekMatch =
                            (startWeek === parseInt(this.week) &&
                                startMonth === monthIndex) ||
                            (endWeek === parseInt(this.week) &&
                                endMonth === monthIndex);
                    }

                    return isMonthMatch || isWeekMatch;
                });
            }

            if (this.form_type === "leave" && this.leave_type) {
                filtered = filtered.filter((item) => {
                    if (this.leave_type === "sick") {
                        return item.leave_type === "Sick";
                    } else if (this.leave_type === "personal") {
                        return item.leave_type != "Sick";
                    }
                    return true;
                });
            }

            if (this.leave_type === "sick" && this.illness_type) {
                filtered = filtered.filter((item) => {
                    return item.illness === this.illness_type;
                });
            }

            return filtered;
        },
        years() {
            const startYear = 2025;
            const endYear = this.currentYear + 30;
            const years = [];

            for (let year = startYear; year <= endYear; year++) {
                years.push(year);
            }
            return years;
        },
    },
    methods: {
        toggleEditStaff() {
            this.isEditStaff = !this.isEditStaff;
        },
        toggleEditTeacher() {
            this.isEditTeacher = !this.isEditTeacher;
        },
        openEval(type) {
            if (type === "teacher") {
                Inertia.visit(
                    `/forms/evaluation-form/${this.personalDetails.id}/teacher`,
                );
            } else if (type === "staff") {
                Inertia.visit(
                    `/forms/evaluation-form/${this.personalDetails.id}/staff`,
                );
            }
        },
        setAdminActiveTab(tab) {
            this.AdminActiveTab = tab;
            localStorage.setItem("AdminActiveTab", tab);
        },
        toggleEditUser() {
            this.isEditUser = !this.isEditUser;
        },
        toggleEditDepartment() {
            this.isEditDepartment = !this.isEditDepartment;
        },
        getWeekNumber(date) {
            const tempDate = new Date(date.getTime());
            tempDate.setMonth(0, 1);
            tempDate.setHours(0, 0, 0, 0);

            const startOfYear = tempDate;
            const diff = date - startOfYear;

            const millisecondsInWeek = 1000 * 60 * 60 * 24 * 7;

            return Math.floor(diff / millisecondsInWeek) + 1;
        },
        formatDate(date) {
            const convertedDate = new Date(date);
            const options = {
                month: "short",
                day: "numeric",
                year: "numeric",
                hour: "numeric",
                minute: "numeric",
                hour12: true,
            };
            return convertedDate.toLocaleString("en-US", options);
        },
        getWeekOfMonth(date) {
            const tempDate = new Date(date.getTime());
            tempDate.setDate(1);
            const startOfMonth = tempDate.getDay();
            const diff = date.getDate() + startOfMonth - 1;
            return Math.ceil(diff / 7);
        },
    },
};
