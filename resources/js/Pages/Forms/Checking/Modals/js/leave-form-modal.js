import { Inertia } from "@inertiajs/inertia";
import ImageViewer from "@/Components/ImageViewer.vue";
export default {
  emits: ["toggleFormModal"],
  props: {
    formData: Object,
    selected_id: String,
    selected_type: String,
    roles: Array,
  },
  components: {
    ImageViewer,
  },

  data() {
    return {
      submission_type: "approval",
      disapproval_description: null,
      days_with_pay: "",
      days_without_pay: "",
      others: "",
      currentYear: new Date().getFullYear(),
      personalLeaveCount: 0,
      sickLeaveCount: 0,
      totalCurrentSickLeave: 0,
      totalCurrentPersonalLeave: 0,
      availableLeaveCount: 0,
      src: "",
      forms: [],
      fetchedDataCache: [],
      fetchInProgress: [],
      isConfirmation: false,
      action: "",
      fetchedYear: "",
    };
  },
  watch: {
    submission_type(newVal) {
      this.disapproval_description = null;
    },
    currentYear(newVal) {
      if (newVal) {
        this.fetchLeaveForm(this.formData.user_id, newVal);
      }
    },
  },

  mounted() {
    this.fetchLeaveForm(this.formData.user_id, this.currentYear);
  },

  methods: {
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
    toggleLargeImgViewer(src) {
      this.src == src ? (this.src = null) : (this.src = src);
    },

    toggleConfirmForm(action) {
      this.action === action ? (this.action = null) : (this.action = action);
      this.isConfirmation = !this.isConfirmation;
    },
    submitForm() {
      const formData = {
        id: this.selected_id,
        form_type: this.selected_type,
        submission_type: this.submission_type,
        submission_description: this.submission_description,
        disapproval_description: this.disapproval_description ?? null,
        days_with_pay: this.days_with_pay,
        days_without_pay: this.days_without_pay,
        others: this.others,
        action: this.action,
      };

      Inertia.post("/forms/checking/forward", formData);

      this.toggleConfirmForm(this.action);
      this.closeFormModal;
    },

    closeFormModal() {
      this.$emit("toggleFormModal");
    },

    fetchLeaveForm(user_id, year) {
      fetch(`/forms/find/${this.formData.form_type}/${user_id}/${year}`, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.forms = data ?? null;
          this.fetchedDataCache[user_id] = data;
          this.fetchInProgress[user_id] = false;
          this.fetchedYear = year;
        })
        .catch((error) => {
          console.error("Error fetching leave forms:", error);
          this.fetchInProgress[user_id] = false;
        });
    },

    calculateLeave(id, user_id, type, current_leave_type) {
      let leaveCount = 0;
      let totalDays = 0;

      if (type === "sick") {
        const filteredArray = this.forms.filter((item) => {
          const itemYear = new Date(item.created_at).getFullYear();
          return (
            item.user_id === user_id &&
            item.status === "approved" &&
            itemYear === this.currentYear &&
            item.leave_type === "Sick"
          );
        });

        filteredArray.forEach((item) => {
          const dateStart = new Date(item.date_start);
          const dateEnd = new Date(item.date_end);
          const daysDifference = (dateEnd - dateStart) / (1000 * 3600 * 24) + 1;
          totalDays += daysDifference;
        });

        if (type == "sick") {
          this.totalCurrentSickLeave = totalDays;
        }

        return totalDays;
      } else {
        const filteredArray = this.forms.filter((item) => {
          const itemYear = new Date(item.created_at).getFullYear();
          return (
            item.user_id === user_id &&
            item.status === "approved" &&
            itemYear === this.currentYear &&
            item.leave_type !== "Sick"
          );
        });

        filteredArray.forEach((item) => {
          const dateStart = new Date(item.date_start);
          const dateEnd = new Date(item.date_end);
          const daysDifference = (dateEnd - dateStart) / (1000 * 3600 * 24) + 1;
          totalDays += daysDifference;
        });

        if (current_leave_type != "Sick") {
          this.totalCurrentPersonalLeave = totalDays;
        }

        return totalDays;
      }
    },

    calculateDays(type, date_start, date_end) {
      const dateStart = new Date(date_start);
      const dateEnd = new Date(date_end);

      const daysDifference = (dateEnd - dateStart) / (1000 * 3600 * 24) + 1;

      if (type == "Sick") {
        this.sickLeaveCount = daysDifference;
      } else {
        this.personalLeaveCount = daysDifference;
      }
      return daysDifference;
    },

    calculateAvailablePersonalLeave(date) {
      const date_today = new Date();
      const year_today = date_today.getFullYear();
      const year_provided = new Date(date).getFullYear();
      const yearDiff = year_today - year_provided;

      return yearDiff >= 10 ? 10 : yearDiff;
    },
    calculateAvailableSickLeave(date) {
      const date_today = new Date();
      const year_today = date_today.getFullYear();
      const year_provided = new Date(date).getFullYear();
      const yearDiff = year_today - year_provided;

      return yearDiff >= 1 ? 15 : yearDiff;
    },
  },
};