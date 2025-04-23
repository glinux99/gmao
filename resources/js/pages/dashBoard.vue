<template>
  <div>
    <div class="d-flex flex-column flex-column-fluid">
      <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
        <div
          id="kt_app_toolbar_container"
          class="app-container container-xxl d-flex flex-stack"
        >
          <div
            class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
          >
            <h1
              class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"
            >
              {{ $t("Dashboard", "") }}
              <div @click="changeL">langues</div>
            </h1>
          </div>

          <div class="d-flex align-items-center gap-2 gap-lg-3">
            <div>
              <input
                v-on:input="handleInput"
                class="form-control form-control-solid"
                placeholder="Choisissez une rangee"
                id="kt_dashboard_daterangepicker"
              />
              <input type="text" id="data_range" @change="handleInput" hidden />
              <button id="handleInput" @click="handleInput" hidden></button>
            </div>

            <a
              href="#"
              class="btn btn-sm fw-bold btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#product-modal"
            >
              {{ $t("Ajouter un produit", "") }}
            </a>
          </div>
        </div>
      </div>

      <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
          <div class="row">
            <div class="col-lg-9 g-1">
              <div class="row g-2">
                <div class="col-lg-3 col-md-6 bg-transparent col-6">
                  <div
                    class="border-bottom border-3 border-primary text-dark rounded-1-2 card overflow-hidden"
                  >
                    <div class="px-3 py-3">
                      <div class="opacity-50">Ventes en cash</div>
                      <div class="fw-700 mt-1 d-flex flex-wrap align-items-center">
                        <div class="symbol symbol-circle symbol-36px overflow-hidden">
                          <span class="symbol-label">
                            <i class="ki-solid ki-bill fs-1 text-success"></i>
                          </span>
                        </div>

                        <div class="fs-5 fw-bold ms-3">
                          <count-up :end-val="totalCash">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 bg-transparent col-6">
                  <div
                    class="border-bottom border-3 border-warning text-dark rounded-1-2 card overflow-hidden"
                  >
                    <div class="px-3 py-3">
                      <div class="opacity-50">
                        {{ $t("Ventes en credit", "") }}
                      </div>
                      <div class="fw-700 mt-1 d-flex flex-wrap align-items-center">
                        <div class="symbol symbol-circle symbol-36px overflow-hidden">
                          <span class="symbol-label">
                            <i class="bi bi-cart4 fw-bold fs-1 text-warning"></i>
                          </span>
                        </div>

                        <div class="fs-5 fw-bold ms-3">
                          <count-up :end-val="totalCredits">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 bg-transparent col-6">
                  <div
                    class="border-bottom border-3 border-success text-dark rounded-1-2 card overflow-hidden"
                  >
                    <div class="px-3 py-3">
                      <div class="opacity-50">
                        {{ $t("Entrée argent", "") }}
                      </div>
                      <div class="fw-700 mt-1 d-flex flex-wrap align-items-center">
                        <div class="symbol symbol-circle symbol-36px overflow-hidden">
                          <span class="symbol-label">
                            <i
                              class="ki-solid ki-arrow-down fw-bold fs-1 text-success"
                            ></i>
                          </span>
                        </div>

                        <div class="fs-5 fw-bold ms-3">
                          <count-up :end-val="totalEntries + totalCash">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 bg-transparent col-6">
                  <div
                    class="border-bottom border-3 border-danger text-dark rounded-1-2 card overflow-hidden"
                  >
                    <div class="px-3 py-3">
                      <div class="opacity-50">{{ $t("Dépenses", "") }}</div>
                      <div class="fw-700 mt-1 d-flex flex-wrap align-items-center">
                        <div class="symbol symbol-circle symbol-36px overflow-hidden">
                          <span class="symbol-label">
                            <i class="ki-solid ki-arrow-up fw-bold fs-1 text-danger"></i>
                          </span>
                        </div>

                        <div class="fs-5 fw-bold ms-3">
                          <count-up :end-val="totalCredits + totalExpenditures">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-xl-0">
                <div class="card my-2 px-9">
                  <span class="fs-6 fw-semibold text-gray-400"
                    >{{ $t("Derniere cloture", "") }}
                  </span>
                  <div>{{ $t("cloture") }}</div>
                </div>
                <div class="card">
                  <div
                    class="card-body d-flex justify-content-between flex-column pb-1 px-0"
                  >
                    <div class="px-9 mb-5">
                      <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">
                          <count-up :end-val="totalAccounts">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </span>
                      </div>

                      <span class="fs-6 fw-semibold text-gray-400"
                        >{{ $t("Balances de comptes") }}
                      </span>
                    </div>

                    <div class="d-flex">
                      <div class="flex-fill"><canvas id="bar"></canvas></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card my-2 px-5">
                <div>
                  <label class="fw-bold fs-3 px-3 my-4">Statistiques de comptes</label>
                </div>
                <div class="separator mb-3"></div>
                <div v-if="credits.length > 0">
                  <label class="fw-semibold fs-4 px-3 d-flex flex-wrap"
                    >Dettes (
                    <span class="fw-700 mb-1">
                      <span class="fs-4 fw-bold">
                        <count-up :end-val="totalCredits">
                          <template #suffix
                            >&nbsp;{{ defaultMonnaie.abreviation }}</template
                          >
                        </count-up>
                      </span>
                    </span>
                    )</label
                  >
                  <div>
                    <template v-for="credit in credits" :key="credit.id"> </template>
                  </div>
                </div>
                <div v-if="expenditures.length > 0">
                  <label class="fw-semibold fs-4 px-3 d-flex flex-wrap"
                    >Depenses (
                    <span class="fw-700 mb-1">
                      <span class="fs-4 fw-bold">
                        <count-up :end-val="totalDebts">
                          <template #suffix
                            >&nbsp;{{ defaultMonnaie.abreviation }}</template
                          >
                        </count-up>
                      </span>
                    </span>
                    )</label
                  >
                  <div>
                    <template v-for="debit in expenditures" :key="debit.id">
                      <label class="d-flex flex-stack cursor-pointer m-2">
                        <span class="d-flex align-items-center me-2">
                          <span class="symbol symbol-50px me-6">
                            <span class="symbol-label bg-light-primary">
                              <i class="ki-duotone ki-document fs-1 text-primary"
                                ><span class="path1"></span><span class="path2"></span
                              ></i>
                            </span>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">{{ debit.account_name }}</span>
                            <span class="fw-bold fs-7">Par {{ debit.user_name }}</span>
                          </span>
                        </span>

                        <span class="form-check form-check-custom form-check-solid">
                          {{ debit.amount }} {{ defaultMonnaie.abreviation }}
                        </span>
                      </label>
                    </template>
                  </div>
                </div>
                <div v-if="entries.length > 0">
                  <label class="fw-semibold fs-4 px-3 d-flex flex-wrap"
                    >Entrees argents (
                    <span class="fw-700 mb-1">
                      <span class="fs-4 fw-bold">
                        <count-up :end-val="totalEntries">
                          <template #suffix
                            >&nbsp;{{ defaultMonnaie.abreviation }}</template
                          >
                        </count-up>
                      </span>
                    </span>
                    )</label
                  >
                  <div>
                    <template v-for="entry in entries" :key="entry.id">
                      <label class="d-flex flex-stack cursor-pointer m-2">
                        <span class="d-flex align-items-center me-2">
                          <span class="symbol symbol-50px me-6">
                            <span class="symbol-label bg-light-primary">
                              <i class="ki-duotone ki-document fs-1 text-primary"
                                ><span class="path1"></span><span class="path2"></span
                              ></i>
                            </span>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">{{ entry.account_name }}</span>
                            <span class="fw-bold fs-7">Par {{ entry.user_name }}</span>
                          </span>
                        </span>

                        <span class="form-check form-check-custom form-check-solid">
                          {{ entry.amount }} {{ defaultMonnaie.abreviation }}
                        </span>
                      </label>
                    </template>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 g-0">
              <div class="row m-1 ms-md-2">
                <div
                  class="border-bottom border-3 border-primary text-dark rounded-1-2 card overflow-hidden"
                >
                  <div class="px-3 py-3">
                    <div class="opacity-50">Solde en caisse</div>
                    <div class="fw-700 mt-1 d-flex flex-wrap align-items-center">
                      <div class="symbol symbol-circle symbol-36px overflow-hidden">
                        <span class="symbol-label">
                          <i class="bi bi-bank fw-bold fs-1 text-primary"></i>
                        </span>
                      </div>

                      <div class="fs-5 fw-bold ms-3">
                        <count-up :end-val="totalEntries - totalExpenditures">
                          <template #suffix
                            >&nbsp;{{ defaultMonnaie.abreviation }}</template
                          >
                        </count-up>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <canvas id="doughnut"></canvas>
              </div>
              <div class="card my-2">
                <div class="w-100">
                  <div>
                    <label class="fw-bold fs-3 px-3 my-4">Statistiques de comptes</label>
                  </div>
                  <div
                    class="btn-group col-md-8 m-auto"
                    data-kt-buttons="true"
                    data-kt-buttons-target="[data-kt-button]"
                  >
                    <label
                      id="status_active"
                      class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                      data-kt-button="true"
                    >
                      <input
                        @click="switchCheck($event, 'tout')"
                        class="btn-check"
                        type="radio"
                        value="enabled"
                        checked
                      />

                      Tout
                    </label>

                    <label
                      class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                      data-kt-button="true"
                    >
                      <input
                        @click="switchCheck($event, 'sortie')"
                        class="btn-check"
                        type="radio"
                        value="disabled"
                      />

                      Sorties
                    </label>
                    <label
                      class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                      data-kt-button="true"
                    >
                      <input
                        @click="switchCheck($event, 'entree')"
                        class="btn-check"
                        type="radio"
                        value="disabled"
                      />

                      Entrees
                    </label>
                  </div>
                  <div class="separator separator-dashed my-5"></div>
                  <div class="d-flex justify-content-end mx-3">
                    <span class="fs-5 fw-bold"
                      >Total: {{ statisticAccountsTotal }}
                      {{ defaultMonnaie.abreviation }}</span
                    >
                  </div>
                  <div class="col">
                    <div class="">
                      <div class="ms-4">
                        <template v-for="account in statisticAccounts" :key="account.id">
                          <div class="">
                            <div class="d-flex flex-stack position-relative w-100 my-2">
                              <div
                                class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"
                              ></div>

                              <div class="fw-semibold w-100 ms-5">
                                <div
                                  class="fs-5 fw-bold text-dark text-hover-primary mb-2"
                                >
                                  {{ account.account.name }}
                                </div>
                                <div
                                  class="badge badge-secondary m-1"
                                  v-if="filter == null || filter == 'entree'"
                                >
                                  <span
                                    :class="`ki-duotone ${'ki-arrow-up text-success'} fs-2x  `"
                                  >
                                    <span class="path1"></span><span class="path2"></span>
                                  </span>
                                  {{ `${account.entries_amount ?? 0}` }}

                                  {{ defaultMonnaie.abreviation }}
                                </div>

                                <div
                                  class="badge badge-secondary"
                                  v-if="filter == null || filter == 'sortie'"
                                >
                                  <span
                                    :class="`ki-duotone ${'ki-arrow-down text-danger'} fs-2x  `"
                                  >
                                    <span class="path1"></span><span class="path2"></span>
                                  </span>
                                  {{ `${account.expenditures_amount ?? 0}` }}

                                  {{ defaultMonnaie.abreviation }}
                                </div>
                              </div>
                            </div>
                          </div>
                        </template>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="product"
      @cancel-btn="cancelBtn"
      @instance-modal="createProduct"
      activeBtn="true"
    >
      <template #title>Création d'un produit</template>
      <template>
        <productStore
          :is-modal="true"
          @callback="CloseModal"
          :form2="data.value ? product.value : form2"
        />
      </template>
    </modal-component>
  </div>
</template>
<script>
import Chart from "chart.js/auto";
import { loadLanguageAsync } from "laravel-vue-i18n";
import BarChart from "../components/charts/testChart.vue";
import modalComponent from "../components/modals/modalComponent.vue";
import useDeposit from "../services/depositservices.js";
import useEntreprises from "../services/enterpriseservices.js";
import useProducts from "../services/productservices.js";

import { useToastr } from "../toastr.js";

import { useCookie } from "@vue-composable/cookie";
import { onMounted, reactive, ref } from "vue";
import CountUp from "vue-countup-v3";
import { notifications } from "../notifications/notifications";
import { getTranslations } from "../services/getTrasnlation";
import useUsers from "../services/userservices";
export default {
  components: {
    modalComponent,
    productStore,
    BarChart,
    CountUp,
  },

  //   mounted: function () {

  //   },

  setup(props, { emit }) {
    const product = reactive({});
    const { products, getProducts, storeProducts } = useProducts();
    const { entreprises, getEntreprise } = useEntreprises();
    const { deposits, getDeposits } = useDeposit();
    const toastr = useToastr();
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
      accounts,
      credits,
      entries,
      fences,
      debts,
      cash,
    } = useUsers();
    let { cookie } = useCookie("userAuth");
    const statisticAccounts = ref([]);
    const { dataCreated } = notifications();
    onMounted(async () => {
      await callBackMounted();
    });
    const cancelBtn = () => {};
    const form2 = reactive({
      id: null,
      name: "",
      description: "",
      codebar: "",
      code_manuel: "",
      images: [],
      point: 0,
      nbrgros: 0,
      bonus_applicable: false,
      has_vat: false,
      user_id: 1,
      enterprise_id: 1,
      category_id: "",
      uuid: null,
      uom_id: null,
      type: 1,
      pricing: [],
      available_qte: 0,
    });

    const form = reactive({
      id: null,
      label: undefined,
      price: undefined,
      money_id: undefined,
      service_id: null,
      principal: null,
      // enterprise_id: useCookie("enterpriseActive").cookie.value,
    });

    // Autres configurations...
    const labels = ref([]);
    const myBarChart = ref();
    const myDougChart = ref();
    const dataSet = ref([]);
    async function initBarChar() {
      console.log("init");
      labels.value = [];
      accounts.value.forEach((el) => {
        labels.value.push(el.account.name);
        dataSet.value.push(el.entries_amount + el.expenditures_amount);
        bg_colors = dataSet.value.map((item) => getRandomColor());
      });

      statisticAccounts.value = [];
      accounts.value.forEach((el) => {
        statisticAccounts.value.push(el);
        statisticAccountsTotal.value += el.entries_amount;
        statisticAccountsTotal.value += el.expenditures_amount;
      });
      myBarChart.value = new Chart(document.getElementById("bar"), {
        type: "bar",
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
      myDougChart.value = new Chart(document.getElementById("doughnut"), {
        type: "doughnut",
        data: {
          labels: ["Sortie", "Entree"],
          datasets: [
            {
              label: "Montant",
              data: [totalExpenditures.value ?? 0, totalEntries.value ?? 1],
              backgroundColor: ["#FF0000", "#0000FF"],
            },
          ],
        },
      });

      // Créer un élément DOM pour afficher le pourcentage
      var percentageElement = document.createElement("div");
      percentageElement.style.position = "absolute";
      percentageElement.style.top = "50%";
      percentageElement.style.left = "50%";
      percentageElement.style.transform = "translate(-50%, -50%)";
      percentageElement.innerHTML = "12 %";

      // Ajouter l'élément DOM au canvas du dougnut
      var canvas = document.getElementById("doughnut");
      canvas.appendChild(percentageElement);
    }
    async function callBackMounted(data = null) {
      const translations = getTranslations();

      console.log("translations");
      console.log(translations);

      if (data != null) {
        await getDashboardData(data);
      } else {
        await getDashboardData();
      }
      initBarChar();

      dataCreated();

      //   await getProducts();
      //   await getEntreprise();
      //   await getDeposits();

      //   entryTotal.value = totalEntries.value;
      //   console.log(entryTotal);
    }
    var bg_colors = [];
    const createProduct = async (data) => {
      $("#closeBtn").trigger("click");
      $("#submit").trigger("click");
      await getProducts();
    };
    const CloseModal = async () => {
      product.value = {};

      await getProducts();

      new bootstrap.Modal(element).hide();
      $("#submit").trigger("click");
    };

    const editModal = (value) => {
      product.value = value;
    };
    const entryTotal = ref(12);
    const handleInput = async () => {
      var value = $("#data_range").val();
      value = value.split("-");
      var data = {
        from: moment(value[0], "DD/MM/YYYY").format("YYYY-MM-DD"),
        to: moment(value[1], "DD/MM/YYYY").format("YYYY-MM-DD"),
      };
      await getDashboardData(data);

      myBarChart.value.destroy();
      dataSet.value = [];
      myDougChart.value.destroy();
      accounts.value = [];
      //   initBarChar();
      await callBackMounted(data);

      //   executeCallbackMounted(data);
    };
    const updateChart = ref(null);
    const updateChart2 = ref(null);
    const executeCallbackMounted = (data) => {
      //   updateChart.value.updateChart(data);
      //   updateChart2.value.updateChart(data);
    };
    const colors = [];
    function getRandomColor() {
      var letters = "0123456789ABCDEF".split("");
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }
    const filter = ref(null);
    const switchCheck = (event, type = null) => {
      statisticAccountsTotal.value = 0;
      if (type == "tout") {
        filter.value = null;
        accounts.value.forEach((el) => {
          //   statisticAccounts.value.push(el);
          statisticAccountsTotal.value += el.entries_amount;
          statisticAccountsTotal.value += el.expenditures_amount;
        });
      }
      if (type == "sortie") {
        filter.value = "sortie";
        accounts.value.forEach((el) => {
          //   statisticAccounts.value.push(el);
          //   statisticAccountsTotal.value += el.entries_amount;
          statisticAccountsTotal.value += el.expenditures_amount;
        });
      }
      if (type == "entree") {
        filter.value = "entree";
        accounts.value.forEach((el) => {
          //   statisticAccounts.value.push(el);
          statisticAccountsTotal.value += el.entries_amount;
          //   statisticAccountsTotal.value += el.expenditures_amount;
        });
      }
    };
    const statisticAccountsTotal = ref(0);
    const changeL = () => {
      app.config.locale = "fr";
      loadLanguageAsync("fr");
    };
    return {
      changeL,
      statisticAccountsTotal,
      switchCheck,
      statisticAccounts,
      accounts,
      dataSet,
      updateChart2,
      updateChart,
      handleInput,
      labels,
      entryTotal,
      totalExpenditures,
      getDashboardData,
      defaultMonnaie,
      createProduct,
      totalAccounts,
      totalCredits,
      totalEntries,
      expenditures,
      totalFences,
      cancelBtn,
      entreprises,
      CloseModal,
      totalDebts,
      totalCash,
      editModal,
      products,
      deposits,
      accounts,
      product,
      credits,
      entries,
      fences,
      form2,
      debts,
      cash,
      filter,
    };
  },
};
</script>
