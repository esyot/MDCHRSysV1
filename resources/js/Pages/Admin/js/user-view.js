import Layout from "@/Layouts/Layout.vue";
import PersonalDetails from "@/Pages/Admin/PersonalDetails.vue";
import { Inertia } from "@inertiajs/inertia";
import EditRoleModal from "@/Modals/EditRoleModal.vue";
import EditDepartmentModal from "@/Modals/EditDepartmentModal.vue";
import EditStaffModal from "@/Modals/EditStaffModal.vue";
import EditTeacherModal from "@/Modals/EditTeacherModal.vue";

export default {
    layout: Layout,
    components: {
        PersonalDetails,
        EditRoleModal,
        EditDepartmentModal,
        EditStaffModal,
        EditTeacherModal,
    },
    props: {
        user_id: String,
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
    },
    data() {
        return {
            AdminActiveTab:
                localStorage.getItem("AdminActiveTab") || "overview",
            isEditRole: false,
            isEditDepartment: false,
            selectedFormType: "All",
            selectedFilter: "",
            form_selection: "",
            currentYear: new Date().getFullYear(),
            selectedYear: new Date().getFullYear(),
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
            month: "",
            date_report: "",
            week: "",
            isEditStaff: false,
            isEditTeacher: false,
        };
    },

    computed: {
        filteredForms() {
            let filtered = this.forms;

            if (this.form_selection) {
                filtered = filtered.filter((item) => {
                    if (this.form_selection === "travel") {
                        return item.form_type === "Travel Form";
                    } else if (this.form_selection === "leave") {
                        return item.form_type === "Leave Form";
                    } else {
                        return true;
                    }
                });
            }

            if (this.selectedYear) {
                filtered = filtered.filter((item) => {
                    const startYear = new Date(item.date_start).getFullYear();
                    const endYear = new Date(item.date_end).getFullYear();
                    return (
                        startYear === parseInt(this.selectedYear) ||
                        endYear === parseInt(this.selectedYear)
                    );
                });
            }

            if (this.date_report && this.month) {
                const monthIndex = this.months.indexOf(this.month);
                filtered = filtered.filter((item) => {
                    const startMonth = new Date(item.date_start).getMonth();
                    const endMonth = new Date(item.date_end).getMonth();
                    return startMonth === monthIndex || endMonth === monthIndex;
                });

                if (this.date_report === "Weekly" && this.week) {
                    filtered = filtered.filter((item) => {
                        const startDate = new Date(item.date_start);
                        const endDate = new Date(item.date_end);
                        const startWeek = this.getWeekOfMonth(startDate);
                        const endWeek = this.getWeekOfMonth(endDate);
                        const startMonth = startDate.getMonth();
                        const endMonth = endDate.getMonth();
                        return (
                            (startWeek === parseInt(this.week) &&
                                startMonth === monthIndex) ||
                            (endWeek === parseInt(this.week) &&
                                endMonth === monthIndex)
                        );
                    });
                }
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
        toggleEditRole() {
            this.isEditRole = !this.isEditRole;
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
