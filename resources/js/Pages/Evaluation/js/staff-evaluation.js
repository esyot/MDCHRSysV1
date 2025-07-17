import axios from "axios";

export default {
    props: {
        user: Object,
        terms: Object,
        evalCategories: Object,
        template_id: Number,
        api_key: String,
        evaluations: Object,
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
        };
    },

    mounted() {
        this.loadFromLocalStorage();
    },

    methods: {
        goBack() {
            window.history.back();
        },

        submitForm(event) {
            event.preventDefault();

            axios.post(`/evaluations/evaluation-submit`, {
                type: "teacher",
                user_id: this.user.id,
                template_id: this.template_id,
                term_id: this.term_id,
                subject_id: this.subject_id,
                overallPoints: this.overallPoints,
                overallMean: this.overallMean.toFixed(2),
            });

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
