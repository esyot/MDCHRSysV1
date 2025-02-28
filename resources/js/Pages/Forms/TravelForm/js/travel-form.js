import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";

export default {
  layout: Layout,
  components: {
    ConfirmationFormModal,
  },
  props: {
    budgetTypes: Object,
    budgetCharges: Object,
    formData: Object,
    roles: Array,
    users: Object,
  },
  data() {
    return {
      travelForm: {
        date_start: this.formData.date_start ?? "",
        date_end: this.formData.date_end ?? "",
        place: this.formData.place ?? "",
        purpose: this.formData.purpose ?? "",
        contact_person: this.formData.contact_person ?? "",
        contact_person_no: this.formData.contact_person_no ?? "",
        description: this.formData.description ?? "",
        semister: this.formData.semister ?? "",
      },
      budget: {
        amount: this.formData.amount ?? "",
        selectedChargedTo: this.formData.budget_charged_to ?? "",
        selectedBudgetType: this.formData.budget_type ?? "",
        othersReason: "",
      },

      teachingSubstitutes: [],
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      searchTeacher: false,
      filteredUsers: this.users,
      isConfirmation: false,
      isSubstitute: false,
     
    };
  },
  methods: {
    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
    storeToLocalStorage() {
      const dataToStore = {
        travelForm: this.travelForm,
        budget: this.budget,
        teachingSubstitutes: this.teachingSubstitutes,
        isSubstitute: this.isSubstitute,
      };
      localStorage.setItem("travelForm", JSON.stringify(dataToStore));
    },
    addTeachingSubstitute() {
      const newSubstitute = {
        subject: "",
        user_id: "",
        teacher: "",
        days: [],
        start_time: "",
        end_time: "",
      };

      this.teachingSubstitutes.push(newSubstitute);
    },
    removeTeachingSubstitute(index) {
      this.teachingSubstitutes.splice(index, 1);
    },
    submitForm() {
      const formData = {
        date_start: this.travelForm.date_start,
        date_end: this.travelForm.date_end,
        description: this.travelForm.description,
        place: this.travelForm.place,
        purpose: this.travelForm.purpose,
        contact_person: this.travelForm.contact_person,
        contact_person_no: this.travelForm.contact_person_no,
        amount: this.budget.amount,
        budget_type: this.budget.selectedBudgetType,
        budget_charged_to: this.budget.selectedChargedTo,
        filing_date: this.formData.filing_date ?? new Date().toISOString().split("T")[0],
      };

      Inertia.post("/forms/travel-form-submit", {
        formData: formData,
        substitutes: JSON.stringify(this.teachingSubstitutes),
      }, {
        onSuccess: () => {
          this.isConfirmation = !this.isConfirmation;
          localStorage.removeItem("travelForm");
        },
      });
    },
    toggleSearchTeacher(value) {
      if (value) {
        this.searchTeacher = true;

        const searchValue = value.toLowerCase();

        this.filteredUsers = this.users.filter(
          (user) =>
            user.first_name.toLowerCase().includes(searchValue) ||
            user.last_name.toLowerCase().includes(searchValue)
        );
      } else {
        this.searchTeacher = false;
        this.filteredUsers = [...this.users];
      }
    },
    selectTeacher(id, index) {
      const user = this.users.find((user) => user.id === id);
      if (user) {
        this.teachingSubstitutes[index].user_id = `${id}`;
        this.teachingSubstitutes[index].teacher = `${user.last_name}, ${user.first_name}`;
      }
      this.searchTeacher = false;
    },
  },
  watch: {
    travelForm: {
      handler() {
        this.storeToLocalStorage();
      },
      deep: true,
    },
    budget: {
      handler() {
        this.storeToLocalStorage();
      },
      deep: true,
    },
    teachingSubstitutes: {
      handler() {
        this.storeToLocalStorage();
      },
      deep: true,
    },
    isSubstitute: {
      handler() {
        this.storeToLocalStorage();
      },
      deep: true,
    },
  },
  created() {
    const storedData = localStorage.getItem("travelForm");
    if (storedData) {
      const parsedData = JSON.parse(storedData);
      this.travelForm = parsedData.travelForm;
      this.budget = parsedData.budget;
      this.teachingSubstitutes = parsedData.teachingSubstitutes || [];
      this.isSubstitute = parsedData.isSubstitute || false;
    }
  },
};