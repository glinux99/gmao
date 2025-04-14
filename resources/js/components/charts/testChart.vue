<template>
  {{ accounts }}
  <div><canvas :id="id"></canvas></div>
</template>

<script>
import Chart from "chart.js/auto";
import { onMounted, watch, ref } from "vue";
import useUsers from "../../services/userservices";
export default {
  props: {
    Bar: {
      type: Boolean,
      required: false,
      default: true,
    },
    accounts: {
      type: Array,
      required: false,
      default: [],
    },
  },
  setup(props) {
    const myLineChart = ref();
    const {
      totalExpenditures,
      getDashboardData,
      defaultMonnaie,
      totalAccounts,
      totalCredits,
      totalEntries,
      expenditures,
      totalFences,
      totalDebts,
      totalCash,
      //   accounts,
      credits,
      entries,
      fences,
      debts,
      cash,
    } = useUsers();
    onMounted(async () => {
      await callBackMounted();
    });
    const labels = ref([]);
    const dataSet = ref([]);
    const colors = [];
    function getRandomColor() {
      var letters = "0123456789ABCDEF".split("");
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    var bg_colors = [];
    const id = `my-chart_${Math.random()}`;
    async function callBackMounted() {
    //   await getDashboardData();
      props.accounts.forEach((el) => {
        labels.value.push(el.account.name);
        dataSet.value.push(el.entries_amount + el.expenditures_amount);
        bg_colors = dataSet.value.map((item) => getRandomColor());
      });
      myLineChart.value = new Chart(document.getElementById(id), {
        type: props.Bar === true ? "bar" : "doughnut",
        options: {
          interaction: {
            mode: "nearest",
          },

          animation: true,
          plugins: {
            title: {
              display: true,
              text: "Etat des comptes disponibles",
            },

            legend: {
              display: false,
              labels: {
                color: "rgb(255, 99, 132)",
              },
              position: "bottom",
            },
            tooltip: {
              callbacks: {
                labelColor: function (context) {
                  return {
                    borderColor: "rgb(0, 0, 255)",
                    // backgroundColor: "rgb(0, 153, 255)",
                    // var(--bs-card-color)
                    borderWidth: 2,
                    borderDash: [2, 2],
                    borderRadius: 2,
                  };
                },
                labelTextColor: function (context) {
                  return "white";
                },
              },
            },
          },
        },
        data: {
          labels: labels.value,
          datasets: [
            {
              label: "",
              data: dataSet.value,
              backgroundColor: bg_colors,
            },
          ],
        },
      });
    }
    const updateChart = async (data) => {
      //   callBackMounted();
      await getDashboardData(data);
      myLineChart.value.destroy();
      labels.value = [];
      dataSet.value = [];
      props.accounts.values.forEach((el) => {
        labels.value.push(el.account.name);
        dataSet.value.push(el.entries_amount + el.expenditures_amount);
        bg_colors = dataSet.value.map((item) => getRandomColor());
      });

      myLineChart.value = new Chart(document.getElementById(id), {
        type: props.Bar === true ? "bar" : "doughnut",
        options: {
          interaction: {
            mode: "nearest",
          },

          animation: true,
          plugins: {
            title: {
              display: props.Bar === true ? true : false,
              text: "Etat des comptes disponibles",
            },

            legend: {
              display: true,
              labels: {
                color: "rgb(255, 99, 132)",
              },
              position: "bottom",
            },
            tooltip: {
              callbacks: {
                labelColor: function (context) {
                  return {
                    borderColor: "rgb(0, 0, 255)",
                    // backgroundColor: "rgb(0, 153, 255)",
                    // var(--bs-card-color)
                    borderWidth: 2,
                    borderDash: [2, 2],
                    borderRadius: 2,
                  };
                },
                labelTextColor: function (context) {
                  return "white";
                },
              },
            },
          },
        },
        data: {
          labels: labels.value,
          datasets: [
            {
              label: "",
              data: dataSet.value,
              backgroundColor: bg_colors,
            },
          ],
        },
      });
    };
    return {
      updateChart,
      id,
      //   accounts,
      dataSet,

      myLineChart,
    };
  },
};
</script>
