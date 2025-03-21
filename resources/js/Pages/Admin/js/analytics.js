import Layout from "@/Layouts/Layout.vue";
export default {
    layout: Layout,
    props: {
        forms: Object,
        user: Object,
        illness: Array,
    },
    data() {
        return {
            form_type: "",
            leave_type: "",
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
            month: "",
            filter: "",
            week: "",
            search_value: "",
            illness_type: "",
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

            if (this.filter && (this.month || this.week)) {
                const monthIndex = this.months.indexOf(this.month);
                filtered = filtered.filter((item) => {
                    const startDate = new Date(item.date_start);
                    const endDate = new Date(item.date_end);
                    const startMonth = startDate.getMonth();
                    const endMonth = endDate.getMonth();
                    const startWeek = this.getWeekOfMonth(startDate);
                    const endWeek = this.getWeekOfMonth(endDate);

                    let isMonthMatch = false;
                    if (this.filter === "Month") {
                        isMonthMatch =
                            startMonth === monthIndex ||
                            endMonth === monthIndex;
                    }

                    let isWeekMatch = false;
                    if (this.filter === "Week" && this.week) {
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

            if (this.search_value) {
                filtered = filtered.filter(
                    (item) =>
                        item.user.first_name
                            .toLowerCase()
                            .includes(this.search_value.toLowerCase()) ||
                        item.user.last_name
                            .toLowerCase()
                            .includes(this.search_value.toLowerCase()) ||
                        item.user.middle_name
                            .toLowerCase()
                            .includes(this.search_value.toLowerCase()),
                );
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
        clearSearchBar() {
            this.search_value = "";
        },
    },
};
