<template>
    <div class="container-body">
        <div class="content-container">
            <!-- Cards Section -->
            <section class="cards">
                <div class="card">
                    <i class="fas fa-users fa-2x"></i>
                    <span>Users:</span>
                    <span>2000</span>
                </div>

                <div class="card">
                    <i class="fas fa-hiking fa-2x"></i>
                    <span>Users on Leave:</span>
                    <span>23</span>
                </div>

                <div class="card">
                    <i class="fas fa-plane-departure fa-2x"></i>
                    <span>Users on Travel:</span>
                    <span>2</span>
                </div>

                <div class="card">
                    <i class="fas fa-hourglass-half fa-2x"></i>
                    <span>Leave Requests:</span>
                    <span>5</span>
                </div>

                <div class="card">
                    <i class="fas fa-hourglass-half fa-2x"></i>
                    <span>Travel Requests:</span>
                    <span>7</span>
                </div>
            </section>
            <section class="charts">
                <div class="chart">
                    <BarChart :data="chartData" :options="chartOptions" />
                </div>

                <div class="chart">
                    <PieChart :data="pieChartData" :options="pieChartOptions" />
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import Layout from "@/Layouts/layout.vue";
import { defineComponent } from "vue";
import { Bar } from "vue-chartjs";
import { Pie } from "vue-chartjs";

import {
    Chart as ChartJS,
    CategoryScale,
    ArcElement,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";

ChartJS.register(
    ArcElement,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

export default defineComponent({
    name: "BarChartComponent",
    layout: Layout,
    components: {
        BarChart: Bar,
        PieChart: Pie,
    },
    data() {
        return {
            chartData: {
                labels: ["users", "on leave", "on travel"],
                datasets: [
                    {
                        label: "Count",
                        data: [400, 450, 300],
                        backgroundColor: "#42A5F5",
                        borderColor: "#1E88E5",
                        borderWidth: 1,
                        textColor: "#fff",
                    },
                ],
            },

            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 2,
                plugins: {
                    title: {
                        display: true,
                        text: "Bar Chart",
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.raw;
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },

            pieChartData: {
                labels: ["On Leave", "On Travel", "Active Users", "Requests"],
                datasets: [
                    {
                        label: "User Status Overview",
                        data: [23, 2, 10, 12],
                        backgroundColor: [
                            "#FFB74D",
                            "#42A5F5",
                            "#66BB6A",
                            "#FF7043",
                        ],
                        hoverOffset: 4,
                    },
                ],
            },

            pieChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 2,
                plugins: {
                    title: {
                        display: true,
                        text: "User Status Overview",
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return (
                                    tooltipItem.label +
                                    ": " +
                                    tooltipItem.raw +
                                    " users"
                                );
                            },
                        },
                    },
                },
            },
        };
    },
});
</script>

<style scoped>
.content-container {
    margin: 0.5rem;
}

.content-container .cards {
    display: flex;
    flex: 1;
    background-color: #fff;
}

.content-container .card {
    display: flex;
    flex-basis: 200px;
    flex-direction: column;
    align-items: center;
    margin: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
    background-color: #59abe3;
    color: #fff;
    cursor: pointer;
}

.content-container .card:hover {
    scale: 110%;
    transition-duration: 300ms;
    transition-property: all;
}

.content-container .card span {
    font-size: 24px;
}

.charts {
    display: flex;
    margin-top: 0.5rem;
    gap: 0.5rem;
    justify-content: space-between;
}

.chart {
    width: 48%;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height: auto;
    padding: 1rem;
}
</style>
