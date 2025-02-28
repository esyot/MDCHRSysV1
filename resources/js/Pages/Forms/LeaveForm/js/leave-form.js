import Layout from "@/Layouts/Layout.vue";
import { Inertia } from "@inertiajs/inertia";
import ConfirmationFormModal from "@/Modals/ConfirmationFormModal.vue";

export default {
  layout: Layout,
  components: {
    ConfirmationFormModal,
  },
  props: {
    users: Object,
    roles: Array,
  },
  data() {
    return {
      formData: {
        leave_type: "",
        leave_type_option: "",
        vacation_option: "",
        convalescence_place: "",
        address: "",
        sick_type: "",
        illness: "",
        reason: "",
        other_reason: "",
        date_start: "",
        date_end: "",
        description: "",
        medical_certificate: null,
        substitute: false,
      },
      teachingSubstitutes: [],
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      searchTeacher: false,
      filteredUsers: this.users,
     
      isConfirmation: false,
    };
  },

  created() {
    const savedData = JSON.parse(localStorage.getItem("leaveFormData"));

    if (savedData) {
      this.formData = savedData.formData || this.formData;
      this.teachingSubstitutes =
        savedData.teachingSubstitutes || this.teachingSubstitutes;
    }
  },

  watch: {
    formData: {
      handler(newData) {
        this.saveToLocalStorage();
      },
      deep: true,
    },

    teachingSubstitutes: {
      handler(newSubstitutes) {
        this.saveToLocalStorage();
      },
      deep: true,
    },
  },

  methods: {
    saveToLocalStorage() {
      const dataToSave = {
        formData: this.formData,
        teachingSubstitutes: this.teachingSubstitutes,
      };
      localStorage.setItem("leaveFormData", JSON.stringify(dataToSave));
    },

    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.formData.medical_certificate = file;
      }
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
      const form = new FormData();
      if (this.formData.medical_certificate) {
        form.append("medical_certificate", this.formData.medical_certificate);
      }

      form.append("substitutes", JSON.stringify(this.teachingSubstitutes));

      for (const key in this.formData) {
        if (this.formData.hasOwnProperty(key)) {
          form.append(key, this.formData[key]);
        }
      }

      Inertia.post("/leave-form-submit", form, {
        onSuccess: () => {
          this.toggleConfirmForm();
          localStorage.removeItem("leaveFormData");
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
    toggleConfirmForm() {
      this.isConfirmation = !this.isConfirmation;
    },
  },
};