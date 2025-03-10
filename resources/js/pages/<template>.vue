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
              Dashboard
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
              Ajouter un produit
            </a>
          </div>
        </div>
      </div>

      <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
          <div class="row">
            <div class="col-lg-9">
              <div class="card-group d-flex flex-wrap gap-lg-2 gap-sm-0">
                <div class="card col-lg-2 col-md-6 bg-transparent col-6">
                  <div
                    class="bg-grad-2 m-0 p-0 card text-white rounded-lg overflow-hidden"
                  >
                    <div class="px-3 pt-1">
                      <div class="opacity-50">Ventes en cash</div>
                      <div class="fw-700 mb-1">
                        <div class="fs-2 fw-bold">
                          <count-up :end-val="totalCash">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 1440 320"
                    >
                      <path
                        fill="rgba(255,255,255,0.3)"
                        fill-opacity="1"
                        d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"
                      ></path>
                    </svg>
                  </div>
                </div>
                <div class="card col-lg-2 col-md-6 bg-transparent col-6">
                  <div
                    class="bg-grad-3 card text-white rounded-lg overflow-hidden"
                  >
                    <div class="px-3 pt-1">
                      <div class="opacity-50">Ventes en credit</div>
                      <div class="fw-700 mb-1">
                        <div class="fs-2 fw-bold">
                          <count-up :end-val="totalCredits">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 1440 320"
                    >
                      <path
                        fill="rgba(255,255,255,0.3)"
                        fill-opacity="1"
                        d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"
                      ></path>
                    </svg>
                  </div>
                </div>
                <div class="card col-lg-2 col-md-6 bg-transparent col-6">
                  <div
                    class="bg-grad-1 card text-white rounded-lg overflow-hidden"
                  >
                    <div class="px-3 pt-1">
                      <div class="opacity-50">Entrée argent</div>
                      <div class="fw-700 mb-1">
                        <div class="fs-2 fw-bold">
                          <count-up :end-val="totalEntries + totalCash">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 1440 320"
                    >
                      <path
                        fill="rgba(255,255,255,0.3)"
                        fill-opacity="1"
                        d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"
                      ></path>
                    </svg>
                  </div>
                </div>
                <div class="card col-lg-2 col-md-6 bg-transparent col-6">
                  <div
                    class="bg-grad-4 card text-white rounded-lg overflow-hidden"
                  >
                    <div class="px-3 pt-1">
                      <div class="opacity-50">Depenses</div>
                      <div class="fw-700 mb-1">
                        <div class="fs-2 fw-bold">
                          <count-up :end-val="totalCredits + totalExpenditures">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </div>
                      </div>
                    </div>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 1440 320"
                    >
                      <path
                        fill="rgba(255,255,255,0.3)"
                        fill-opacity="1"
                        d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"
                      ></path>
                    </svg>
                  </div>
                </div>
              </div>

              <div class="col-lg-12 col-xl-12 col-xxl-6 my-5 mb-xl-0">
                <div class="card my-2 px-9">
                  <span class="fs-6 fw-semibold text-gray-400"
                    >Derniere cloture
                  </span>
                  <div>cloture</div>
                </div>
                <div class="card">
                  <div
                    class="card-body d-flex justify-content-between flex-column pb-1 px-0"
                  >
                    <div class="px-9 mb-5">
                      <div class="d-flex mb-2">
                        <span
                          class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2"
                        >
                          <count-up :end-val="totalAccounts">
                            <template #suffix
                              >&nbsp;{{ defaultMonnaie.abreviation }}</template
                            >
                          </count-up>
                        </span>
                      </div>

                      <span class="fs-6 fw-semibold text-gray-400"
                        >Balances de comptes
                      </span>
                    </div>

                    <div class="">
                      <div><canvas id="bar"></canvas></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 px-0">
              <div class="bg-grad-5 card text-white rounded-lg overflow-hidden">
                <div class="px-3 pt-1">
                  <div class="opacity-50">Solde en caisse</div>
                  <div class="fw-700 mb-1">
                    <div class="fs-2 fw-bold">
                      <count-up :end-val="totalEntries - totalExpenditures">
                        <template #suffix
                          >&nbsp;{{ defaultMonnaie.abreviation }}</template
                        >
                      </count-up>
                    </div>
                  </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                  <path
                    width="100%"
                    height="100%"
                    fill="rgba(255,255,255,0.3)"
                    fill-opacity="1"
                    d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"
                  ></path>
                </svg>
              </div>
              <div class="d-flex justify-content-end">
                <canvas id="doughnut"></canvas>
              </div>
            </div>
          </div>
          <div class="card my-2">
            <div class="w-100">
              <div>
                <label class="fw-bold fs-3 px-3 my-4"
                  >Statistiques de comptes</label
                >
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
                  >Total: {{ totalAccounts }}
                  {{ defaultMonnaie.abreviation }}</span
                >
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="ms-4 row">
                    <template
                      v-for="account in statisticAccounts"
                      :key="account.id"
                    >
                      <div class="col-md-6">
                        <div
                          class="d-flex flex-stack position-relative w-100 my-2"
                        >
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
                                <span class="path1"></span
                                ><span class="path2"></span>
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
                                <span class="path1"></span
                                ><span class="path2"></span>
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
                <div class="col-md-4 px-5">
                  <div>
                    <label class="fw-bold fs-4 px-3 d-flex flex-wrap"
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
                      <template v-for="credit in credits" :key="credit.id">
                      </template>
                    </div>
                  </div>
                  <div>
                    <label class="fw-bold fs-4 px-3 d-flex flex-wrap"
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
                                <i
                                  class="ki-duotone ki-document fs-1 text-primary"
                                  ><span class="path1"></span
                                  ><span class="path2"></span
                                ></i>
                              </span>
                            </span>

                            <span class="d-flex flex-column">
                              <span class="fw-bold fs-6">{{
                                debit.account_name
                              }}</span>
                              <span class="fw-bold fs-7"
                                >Par {{ debit.user_name }}</span
                              >
                            </span>
                          </span>

                          <span
                            class="form-check form-check-custom form-check-solid"
                          >
                            {{ debit.amount }} {{ defaultMonnaie.abreviation }}
                          </span>
                        </label>
                      </template>
                    </div>
                  </div>
                  <div>
                    <label class="fw-bold fs-4 px-3 d-flex flex-wrap"
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
                                <i
                                  class="ki-duotone ki-document fs-1 text-primary"
                                  ><span class="path1"></span
                                  ><span class="path2"></span
                                ></i>
                              </span>
                            </span>

                            <span class="d-flex flex-column">
                              <span class="fw-bold fs-6">{{
                                entry.account_name
                              }}</span>
                              <span class="fw-bold fs-7"
                                >Par {{ entry.user_name }}</span
                              >
                            </span>
                          </span>

                          <span
                            class="form-check form-check-custom form-check-solid"
                          >
                            {{ entry.amount }} {{ defaultMonnaie.abreviation }}
                          </span>
                        </label>
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

    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="product"
      @cancel-btn="cancelBtn"
      @instance-modal="createProduct"
      activeBtn="false"
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
import modalComponent from "../components/modals/modalComponent.vue";
import useProducts from "../services/productservices.js";
import useEntreprises from "../services/enterpriseservices.js";
import useDeposit from "../services/depositservices.js";
import productStore from "./products/productStore.vue";
import BarChart from "../components/charts/testChart.vue";
import Chart from "chart.js/auto";

import { useToastr } from "../toastr.js";

import { onMounted, onUpdated, reactive, ref } from "vue";
import { useCookie } from "@vue-composable/cookie";
import { notifications } from "../notifications/notifications";
import useUsers from "../services/userservices";
import CountUp from "vue-countup-v3";
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
    }
    async function callBackMounted(data = null) {
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
      if (type == "tout") {
        filter.value = null;
      }
      if (type == "sortie") {
        filter.value = "sortie";
      }
      if (type == "entree") {
        filter.value = "entree";
      }
    };
    return {
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
