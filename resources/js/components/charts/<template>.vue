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
            <a
              href="/admin/pos/list/"
              class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary"
            >
              Vendre
            </a>

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
          <div class="col-lg-12">
            <div class="row text-white">
              <div class="col-3">
                <div
                  class="bg-grad-2 card text-white rounded-lg mb-4 overflow-hidden"
                >
                  <div class="px-3 pt-3">
                    <div class="opacity-50">
                      <span class="fs-12 d-block">Total</span>
                      Ventes en cash
                    </div>
                    <div class="fw-700 mb-3">
                      <div
                        class="fs-2 fw-bold"
                        data-kt-countup="true"
                        :data-kt-countup-value="totalCash"
                      >
                        0
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
              <div class="col-3">
                <div
                  class="bg-grad-3 card text-white rounded-lg mb-4 overflow-hidden"
                >
                  <div class="px-3 pt-3">
                    <div class="opacity-50">
                      <span class="fs-12 d-block">Total</span>
                      Ventes en credit
                    </div>
                    <div class="fw-700 mb-3">
                      <div
                        class="fs-2 fw-bold"
                        data-kt-countup="true"
                        :data-kt-countup-value="totalCredits"
                        :data-kt-countup-suffix="defaultMonnaie.abreviation"
                      >
                        0
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
              <div class="col-3">
                <div
                  class="bg-grad-1 card text-white rounded-lg mb-4 overflow-hidden"
                >
                  <div class="px-3 pt-3">
                    <div class="opacity-50">
                      <span class="fs-12 d-block">Total</span>
                      Entrée argent
                    </div>
                    <div class="fw-700 mb-3">
                      <div
                        class="fs-2 fw-bold"
                        data-kt-countup="true"
                        :data-kt-countup-value="totalEntries + totalCash"
                        :data-kt-countup-suffix="defaultMonnaie.abreviation"
                      >
                        0
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
              <div class="col-3">
                <div
                  class="bg-grad-4 card text-white rounded-lg mb-4 overflow-hidden"
                >
                  <div class="px-3 pt-3">
                    <div class="opacity-50">
                      <span class="fs-12 d-block">Total</span>
                      Depenses
                    </div>
                    <div class="fw-700 mb-3">
                      <div
                        class="fs-2 fw-bold"
                        data-kt-countup="true"
                        :data-kt-countup-value="
                          totalCredits + totalExpenditures
                        "
                        :data-kt-countup-suffix="defaultMonnaie.abreviation"
                      >
                        0
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
import { useToastr } from "../toastr.js";

import { onMounted, onUpdated, reactive, ref } from "vue";
import { useCookie } from "@vue-composable/cookie";
import { notifications } from "../notifications/notifications";
import useUsers from "../services/userservices";

export default {
  components: {
    BarChart,
    modalComponent,
    productStore,
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
    async function callBackMounted() {
      await getDashboardData();
      dataCreated();

      await getProducts();
      await getEntreprise();
      await getDeposits();

      entryTotal.value = totalEntries.value;
      console.log(entryTotal);
    }

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
    return {
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
    };
  },
};
</script>
