<template>
    <div class="row">
        <div class="col-md-6">
            <h2 class="text-muted mb-3">Tâches par priorité</h2>
            <canvas :id="barChartId"></canvas>
        </div>
        <div class="col-md-6 mh-200px" >
            <h2 class="text-muted mb-3">Tâches par status</h2>
            <canvas :id="pieChartId"></canvas>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { onMounted, ref } from "vue";
import useTasks from '../../services/taskServices.js';

export default {
    name: 'TasksChart',
    setup(props) {
        const {
            tasks,
            getTasks,
            // storeTask,
            // updateTask,
            // getTaskCategories,
            // errors,
            // isLoading
        } = useTasks();
        const barChart = ref(null);
        const pieChart = ref(null);
        const barChartId = `bar-chart-${Math.random()}`;
        const pieChartId = `pie-chart-${Math.random()}`;
        const taskData = ref(null);

        // Function to fetch and process data
        const fetchAndProcessData = async () => {
            try {
                await getTasks();
                taskData.value = tasks.value;
                createCharts();
            } catch (error) {
                console.error("Error fetching tasks:", error);
            }
        };

        // Function to create the charts
        const createCharts = () => {
            if (taskData.value === null) return;

            // Process data for Bar Chart (by Category)
            const categoryData = processCategoryData(taskData.value);
            // Process data for Pie Chart (by Status)
            const statusData = processStatusData(taskData.value);
            const totalTasks = statusData.data.reduce((a, b) => a + b, 0); // Calculate total tasks

            // Create Bar Chart
            barChart.value = new Chart(document.getElementById(barChartId), {
                type: "bar",
                data: {
                    labels: categoryData.labels,
                    datasets: [
                        {
                            label: "Nombre de tâches",
                            data: categoryData.data,
                            backgroundColor: colors.value,
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Create Pie Chart
            pieChart.value = new Chart(document.getElementById(pieChartId), {
                type: "doughnut",
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: "right",
                            labels: {
                                boxWidth: 20
                            }
                        },
                        tooltip: {
                            enabled: true,
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                statusData.data.forEach((e) => {
                                    sum += e;
                                });

                                let percentage = (value * 100 / sum).toFixed(2) + "%";
                                return percentage;
                            },

                            color: 'white',
                            font: {
                                weight: 'bold'
                            }
                        },
                        // Add annotation for total tasks in the center
                        annotation: {
                            annotations: {
                                centerText: {
                                    type: 'label',
                                    content: [`Total de taches `, totalTasks.toString()], //total number in the center
                                    color: 'black',
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    },
                                    xValue: '50%',
                                    yValue: '50%'
                                }
                            }
                        }
                    }
                },
                data: {
                    labels: statusData.labels,
                    datasets: [
                        {
                            label: "Nombre de tâches",
                            data: statusData.data,
                            backgroundColor: colorsSatus.value,
                        },
                    ],
                },
                plugins: [ChartDataLabels, {
                    id: 'annotation',
                    beforeDraw(chart) {
                        if (chart.config.options.plugins.annotation && chart.config.options.plugins.annotation.annotations.centerText) {
                            const { ctx } = chart;
                            const centerText = chart.config.options.plugins.annotation.annotations.centerText;
                            const centerX = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
                            const centerY = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;
                            const lines = Array.isArray(centerText.content) ? centerText.content : [centerText.content];
                            const lineHeight = centerText.font.size * 1.2; // Adjust as needed for line spacing
                            const startY = centerY - (lines.length - 1) * lineHeight / 2; // Calculate starting y-coordinate

                            ctx.save();
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.font = centerText.font.weight + ' ' + centerText.font.size + 'px sans-serif';
                            ctx.fillStyle = centerText.color;
                            for (let i = 0; i < lines.length; i++) {
                                ctx.fillText(lines[i], centerX, startY + i * lineHeight);
                            }
                            ctx.restore();
                        }
                    }
                }]
            });
        };

        // Helper function to process data for category-based chart
        const colors = ref([]);
        const processCategoryData = (data) => {
            const statusCounts = {};

            data.forEach((item) => {
                const status = item.priority ? item.priority.title : "";
                if (status) {
                    statusCounts[status] = (statusCounts[status] || 0) + 1;
                    if (statusCounts[status] == 1) {
                        colors.value.push(item.priority.color);
                    }
                }
            });
            return {
                labels: Object.keys(statusCounts),
                data: Object.values(statusCounts),
                colors: colors.value
            };
        };
        const colorsSatus = ref([]);
        const processStatusData = (data) => {
            const statusCounts = {};
            data.forEach((item) => {
                const status = item.status;
                if (status) {
                    statusCounts[status] = (statusCounts[status] || 0) + 1;
                    if (statusCounts[status] == 1) {
                        switch (status) {
                            case "pending":
                                colorsSatus.value.push('#F79306FF');
                                break;
                            case "in_progress":
                                colorsSatus.value.push('#417E45FF');
                                break;
                            case "completed":
                                colorsSatus.value.push('#03C503FF');
                                break;
                            case "planned":
                                colorsSatus.value.push('#7C8508FF');
                                break;
                            case "canceled":
                                colorsSatus.value.push('#000000FF');
                                break;
                            case "paused":
                                colorsSatus.value.push('#382F2FA4');
                                break;
                        }
                    }
                }
            });
            return {
                labels: Object.keys(statusCounts),
                data: Object.values(statusCounts),
                color: colorsSatus.value
            };
        };

        // Fetch data on mount
        onMounted(async () => {
            await fetchAndProcessData();
        });

        return {
            barChartId,
            pieChartId,
            taskData,
        };
    },
};
</script>

<style scoped>
.row {
    margin: 20px 0;
}
</style>
