<template>
    <div class="row">
      <div class="col-md-6">
        <h2 class="text-muted mb-3">Taches par categorie</h2>
        <canvas :id="barChartId"></canvas>
      </div>
      <div class="col-md-6 mh-200px">
        <h2 class="text-muted mb-3">Taches par status</h2>
        <canvas :id="pieChartId"></canvas>
      </div>
    </div>
  </template>

  <script>
  import Chart from "chart.js/auto";
  import { onMounted, ref, watch } from "vue";
  import useTasks from '../../services/taskServices.js';
  export default {
    name: 'TasksChart',
    props: {
      // accounts: { // remove this prop
      //     type: Array,
      //     required: false,
      //     default: [],
      // },
    },
    setup(props) {
        const {
            tasks,
            getTasks,
            storeTask,
            updateTask,
            getTaskCategories,
            errors,
            isLoading
        } = useTasks ();
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
          // console.log(taskData.value)
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

        // Create Bar Chart
        barChart.value = new Chart(document.getElementById(barChartId), {
          type: "bar",
          data: {
            labels: categoryData.labels,
            datasets: [
              {
                label: "Nombre de tâches",
                data: categoryData.data,
                backgroundColor: generateRandomColors(categoryData.data.length),
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
              position: "right", // Place legend to the right
              labels:{
                boxWidth:20
              }
            },
            tooltip: {
              enabled: true,
            },

          },
        },
          data: {
            labels: statusData.labels,
            datasets: [
              {
                label: "Nombre de tâches",
                data: statusData.data,
                backgroundColor: generateRandomColors(statusData.data.length),
              },
            ],
          },
        });
      };

      // Helper function to process data for category-based chart
      const processCategoryData = (data) => {
        const statusCounts = {};
            data.forEach((item) => {
                const status = item.category;
                if(status){
                   statusCounts[status] = (statusCounts[status] || 0) + 1;
                }

            });
            return {
                labels: Object.keys(statusCounts),
                data: Object.values(statusCounts),
            };
      };

      const processStatusData = (data) => {
            const statusCounts = {};
            data.forEach((item) => {
                const status = item.status;
                if(status){
                   statusCounts[status] = (statusCounts[status] || 0) + 1;
                }

            });
            return {
                labels: Object.keys(statusCounts),
                data: Object.values(statusCounts),
            };
        };

      // Helper function to generate random colors
      const generateRandomColors = (count) => {
        const colors = [];
        for (let i = 0; i < count; i++) {
          colors.push(getRandomColor());
        }
        return colors;
      };

      function getRandomColor() {
        var letters = "0123456789ABCDEF".split("");
        var color = "#";
        for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
      }
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
  .row{
      margin: 20px 0;
  }
  </style>
