import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import { useToast } from "vue-toastification";
import Layout from "@/Layouts/Evaluation.vue";

export default {
    layout: Layout,
    props: {
        user: Object,
        terms: Object,
        evalCategories: Object,
        template_id: Number,
        api_key: String,
        evaluations: Object,
        template: Object,
    },

    data() {
        return {
            currentDate: new Date(),
            comments: {},
            ratings: {},
            overallPoints: 0,
            overallMean: 0,
            subjects: [],
            subject_id: "",
            term_id: "",
            scrollPosition: 0,
            max: 0,
        };
    },

    mounted() {
        this.loadFromLocalStorage();
        const div = this.$refs.content;
        this.max = div.scrollHeight - window.innerHeight;
    },
    watch: {
        term_id(newVal) {
            if (newVal) {
                this.fetchSubjects();
            }
        },
    },

    computed: {
        filteredSubjects() {
            return this.subjects.filter((subject) => {
                return !this.evaluations.some(
                    (evaluation) => evaluation.subject_id === subject.id,
                );
            });
        },
    },

    methods: {
        onScroll() {
            const div = this.$refs.content;
            if (div) {
                this.scrollPosition = div.scrollTop;
            }
        },
        scroll(direction) {
            const div = this.$refs.content;
            if (div) {
                if (direction === "down") {
                    div.scrollTop = this.max;
                } else if (direction === "top") {
                    div.scrollTop = 0;
                }
            }
        },
        fetchSubjects() {
            const params = {
                code: this.api_key,
                teacher_id: this.user.teacher.id,
                term_id: this.term_id,
            };

            const queryString = new URLSearchParams(params).toString();

            try {
                axios
                    .get(
                        `https://sis.materdeicollege.com/api/hr/subject-classes/?${queryString}`,
                    )
                    .then((response) => {
                        this.subjects = response.data;
                    })
                    .catch((error) => {
                        console.error("error fetching data:", error);
                    });
            } catch (error) {
                console.error("error method:", error);
            }
        },

        goBack() {
            window.history.back();
        },

        submitForm() {
            const toast = useToast();
            Inertia.post(
                `/evaluations/evaluation-submit`,
                {
                    type: "teacher",
                    user_id: this.user.id,
                    template_id: this.template_id,
                    term_id: this.term_id,
                    subject_id: this.subject_id,
                    overallPoints: this.overallPoints,
                    overallMean: this.overallMean.toFixed(2),
                    ratings: localStorage.getItem("ratings"),
                    comments: localStorage.getItem("comments"),
                },
                {
                    onSucess: (response) => {
                        toast.success(response.props.success, {
                            position: "top-center",
                            duration: 3000,
                        });

                        this.removeFromLocalStorage();
                        this.goBack();
                    },

                    onError: (errors) => {
                        toast.error(errors.error, {
                            position: "top-center",
                            duration: 3000,
                        });
                    },
                },
            );
        },
        removeFromLocalStorage() {
            localStorage.removeItem("ratings");
            localStorage.removeItem("comments");
        },

        saveToLocalStorage() {
            localStorage.setItem("ratings", JSON.stringify(this.ratings));
            localStorage.setItem("comments", JSON.stringify(this.comments));
            this.calculateOverallPoints();
        },

        loadFromLocalStorage() {
            const savedRatings = localStorage.getItem("ratings");
            const savedComments = localStorage.getItem("comments");

            if (savedRatings) {
                this.ratings = JSON.parse(savedRatings);
            }
            if (savedComments) {
                this.comments = JSON.parse(savedComments);
            }

            this.calculateOverallPoints();
        },

        calculateOverallPoints() {
            let totalPoints = 0;
            let totalMean = 0;

            this.evalCategories.forEach((category) => {
                const categoryPoints = category.items.reduce((acc, item) => {
                    const rating = this.ratings[`c${category.id}_i${item.id}`];
                    return acc + (rating || 0);
                }, 0);

                const categoryMean =
                    category.items.length > 0
                        ? categoryPoints / category.items.length
                        : 0;

                totalPoints += categoryPoints;

                totalMean += categoryMean;
            });

            this.overallPoints = totalPoints;

            this.overallMean = totalMean / this.evalCategories.length;
        },

        calculateCategoryRating(categoryId) {
            const categoryRatings = Object.keys(this.ratings)
                .filter((key) => key.startsWith(`c${categoryId}`))
                .map((key) => this.ratings[key]);

            const categoryTotal = categoryRatings.reduce(
                (acc, rating) => acc + rating,
                0,
            );
            return categoryRatings.length > 0 ? categoryTotal : 0;
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
    },
};
