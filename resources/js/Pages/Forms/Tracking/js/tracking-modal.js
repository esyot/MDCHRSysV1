export default {
    emits: ["toggleFormModal"],
    props: {
      forms: Object,
      selected_id: String,
      selected_type: String,
    },
    data() {
      return {
        modal_id: this.selected_id ?? null,
        modal_type: this.selected_type ?? null,
      };
    },
    watch: {
      selected_id(newVal) {
        this.modal_id = newVal;
      },
  
      selected_type(newVal, oldVal) {
        this.modal_type = newVal ?? oldVal;
      },
      
      modal_id(newVal, oldVal) {
        if (oldVal) {
          const modalId = `modal-${this.modal_type
            .toLowerCase()
            .replace(" ", "-")}-${oldVal}`;
  
          document.getElementById(modalId).classList.add("hidden");
          document.getElementById(modalId).classList.remove("flex");
        }
  
        if (newVal) {
          const modalId = `modal-${this.modal_type
            .toLowerCase()
            .replace(" ", "-")}-${newVal}`;
  
          document.getElementById(modalId).classList.remove("hidden");
          document.getElementById(modalId).classList.add("flex");
        }
      },
    },
    methods: {
      closeFormModal() {
        this.$emit("toggleFormModal", this.selected_id, this.selected_type);
      },
    },
    computed: {
      travelForms() {
        return this.forms.filter((item) => item.form_type === "Travel Form");
      },
      leaveForms() {
        return this.forms.filter((item) => item.form_type === "Leave Form");
      },
    },
  };