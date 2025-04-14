<template>
  <div>
    <div
      class="position-fixed position-absolute bottom-0 end-0 d-lg-none d-md-none d-flex align-self-end me-5 z-index-2"
      data-bs-toggle="modal"
      data-bs-target="#info-modal"
    >
      <span class="svg-icon svg-icon-5x svg-icon-primary">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          width="24px"
          height="24px"
          viewBox="0 0 24 24"
          version="1.1"
          fill="none"
        >
          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="54"></rect>
            <path
              d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
              fill="#000000"
              fill-rule="nonzero"
              opacity="0.3"
            ></path>
            <path
              d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
              fill="currentColor"
            ></path>
          </g>
        </svg>
      </span>
    </div>

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid position-relative">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
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
                POS Systeme
              </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
              <a
                href="/"
                class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary"
              >
                Historique de ventes
              </a>
              <button
                @click="editModal(null)"
                type="button"
                class="btn btn-sm btn-primary"
              >
                <i class="ki-duotone ki-plus fs-2"></i> Nouveau produit
              </button>
            </div>
          </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div
            id="kt_app_content_ontainer"
            class="app-container container-xxl"
          >
            <!-- code ici -->
            <div class="d-flex flex-column flex-xl-row">
              <div
                class="flex-row-auto mw-xl-200px card bg-secondary opacity-75 align-items-center"
              >
                <label for="" class="text-muted fw-bold my-4"
                  >Liste de depots</label
                >
                <ul class="nav nav-tabs flex-column" id="myTab" role="tablist">
                  <template
                    v-for="(deposit, index) in deposits"
                    :key="deposit.id"
                  >
                    <li
                      class="nav-item"
                      role="presentation"
                      @click="choiceDeposit(deposit.id)"
                    >
                      <button
                        :class="`nav-link w-100 ${activate(index)}`"
                        :id="`home-${deposit.id}`"
                        data-bs-toggle="tab"
                        :data-bs-target="`#home${deposit.id}`"
                        type="button"
                        role="tab"
                        :aria-controls="`home${deposit.id}`"
                        aria-selected="true"
                      >
                        {{ deposit.name }}
                      </button>
                    </li>
                  </template>
                </ul>
              </div>
              <div class="d-flex flex-row-fluid mb-10 mb-xl-0">
                <div class="card card-flush card-p-0 bg-transparent border-0">
                  <div class="card-body">
                    <template
                      v-for="(deposit, index) in deposits"
                      :key="deposit.id"
                    >
                      <div class="tab-content" id="myTabContent">
                        <div
                          :class="`tab-pane fade ${activate(index, true)}`"
                          :id="`home${deposit.id}`"
                          role="tabpanel"
                          :aria-labelledby="`home-${deposit.id}`"
                        >
                          <div class="d-flex flex-wrap d-grid gap-2 gap-xxl-9">
                            <template
                              v-for="product in productFilter"
                              :key="product.id"
                            >
                              <div
                                v-if="true"
                                @click="addCard(product)"
                                class="card card-flush p-1 pb-5 rounded hover-scale"
                              >
                                <div class="card-body">
                                  <img
                                    :src="
                                      product.remember_pic_link +
                                      product.uom_id +
                                      '-0.png'
                                    "
                                    alt="&nbsp;Erreur"
                                    class="rounded-3 mb-4 w-100 h-80px w-xxl-15px h-xxl-15px"
                                    @error="
                                      $event.target.src = '/images/no-image.png'
                                    "
                                  />
                                  <div class="mb-2">
                                    <div class="text-center">
                                      <span
                                        class="fw-bold text-gray-800 cursor-pointer text-hover-primary"
                                      >
                                        {{ product.name }}</span
                                      >

                                      <!-- <span
                                        class="text-gray-400 fw-semibold d-block mt-n1"
                                        >{{ product.description }}
                                      </span> -->
                                    </div>
                                  </div>

                                  <div
                                    class="px-3 d-flex justify-content-between"
                                  >
                                    <span
                                      class="text-primary text-start fw-bold"
                                      >{{
                                        product.pricing.filter((price) => {
                                          return price.principal == 1;
                                        }).length > 0
                                          ? product.pricing.filter((price) => {
                                              return price.principal == 1;
                                            })[0].price +
                                            " " +
                                            product.pricing.filter((price) => {
                                              return price.principal == 1;
                                            })[0].money.abreviation
                                          : 0 + " USD"
                                      }}
                                    </span>
                                    <span>
                                      {{
                                        product.store.filter(
                                          (store) =>
                                            store.deposit_id == storeActive
                                        )[0].available_qte
                                      }}
                                      <i
                                        :class="`fas fa-weight fs-7 ${
                                          product.store.filter(
                                            (store) =>
                                              store.deposit_id == storeActive
                                          )[0].available_qte > 0
                                            ? 'text-success'
                                            : 'text-warning'
                                        }`"
                                      ></i>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <!-- <div v-else-if="index == 1">
                                Aucun produit
                              </div> -->
                            </template>
                          </div>
                        </div>
                        <div
                          class="tab-pane fade"
                          id="profile"
                          role="tabpanel"
                          aria-labelledby="profile-tab"
                        >
                          lorem100333
                        </div>
                      </div>
                    </template>
                  </div>
                </div>
              </div>
              <div
                :class="
                  'flex-row-auto mw-xl-375px ' +
                  (cardList.length == 0 ? 'd-none' : '')
                "
              >
                <div class="card card-flush bg-body" id="kt_pos_form">
                  <div class="card-header pt-5">
                    <h3 class="card-title fw-bold text-gray-800 fs-xl">
                      Commande Courante
                    </h3>

                    <div
                      class="card-toolbar"
                      data-bs-toggle="tooltip"
                      title="Annuler toute la commande"
                    >
                      <div
                        @click="ClearAll"
                        class="btn btn-light-danger fs-x fw-bold py-4"
                      >
                        <i class="fas fa-trash fs-3"></i>
                      </div>
                    </div>
                  </div>

                  <div class="card-body pt-0">
                    <div class="table-responsive mb-8">
                      <table class="table align-middle gs-0 gy-4 my-0">
                        <thead>
                          <tr>
                            <th class="min-w-175px"></th>
                            <th class="w-125px"></th>
                            <th class="w-60px"></th>
                          </tr>
                        </thead>

                        <tbody>
                          <template
                            v-for="(product, i) in cardList"
                            :key="product.product.id"
                          >
                            <tr>
                              <td class="pe-0">
                                <div class="d-flex align-items-center">
                                  <img
                                    :src="
                                      product.product.remember_pic_link +
                                      product.product.uom_id +
                                      '-0.png'
                                    "
                                    alt="&nbsp;Erreur"
                                    class="w-50px h-50px rounded-3 me-3"
                                    @error="
                                      $event.target.src = '/images/no-image.png'
                                    "
                                  />
                                  <div class="d-flex flex-column">
                                    <span
                                      class="fw-bold text-gray-800 cursor-pointer text-hover-primary mh-20px overflow-hidden me-1"
                                      >{{ product.product.name }}</span
                                    >
                                    <div class="d-flex flex-row">
                                      <span
                                        class="fw-bold text-primary fs-sm-9"
                                        data-kt-pos-element="item-total"
                                      >
                                        {{
                                          product.subTotal + " " + product.money
                                        }}</span
                                      >
                                    </div>
                                  </div>
                                </div>
                              </td>

                              <td class="text-end">
                                <div
                                  class="position-relative d-flex align-items-center"
                                >
                                  <button
                                    type="button"
                                    class="btn btn-icon btn-sm btn-light btn-icon-gray-400"
                                    @click="decrease(product)"
                                  >
                                    <i class="ki-duotone ki-minus fs-2x"></i>
                                  </button>
                                  <!-- {{ product.quantity }} -->
                                  <input
                                    :id="`input${i}`"
                                    type="text"
                                    class="form-control border-0 text-center px-0 fs-3 fw-bold text-gray-800 w-30px"
                                    :value="product.quantity"
                                    min="1"
                                    readonly
                                  />

                                  <button
                                    type="button"
                                    class="btn btn-icon btn-sm btn-light btn-icon-gray-400"
                                    @click="increase(product)"
                                  >
                                    <i class="ki-duotone ki-plus fs-2x"></i>
                                  </button>
                                </div>
                              </td>
                            </tr>
                          </template>
                        </tbody>
                      </table>
                    </div>

                    <div
                      class="d-flex flex-stack bg-success rounded-3 p-6 mb-11"
                      title="Cliquez pour la reduction"
                    >
                      <div class="fs-6 fw-bold text-white">
                        <span class="d-block lh-1 mb-2">Sous-total</span>
                        <span class="d-block mb-2">Reduction</span>
                        <span class="d-block mb-9">Tax(16%)</span>
                        <span class="d-block fs-2qx lh-1">Total</span>
                      </div>

                      <div class="fs-6 fw-bold text-white text-end">
                        <span
                          class="d-block lh-1 mb-2"
                          data-kt-pos-element="total"
                          >{{ bills.subTotal }}</span
                        >

                        <span
                          class="d-block mb-2"
                          data-kt-pos-element="discount"
                          >-{{ bills.reduct }}</span
                        >
                        <span class="d-block mb-9" data-kt-pos-element="tax">{{
                          bills.taxe
                        }}</span>
                        <span
                          class="d-block fs-2qx lh-1"
                          data-kt-pos-element="grant-total"
                          >{{ bills.total }}</span
                        >
                      </div>
                    </div>

                    <div class="m-0">
                      <h1 class="fw-bold text-gray-800 mb-5">
                        Methode de paiement
                      </h1>

                      <div
                        class="d-flex flex-equal gap-5 gap-xxl-9 px-0 mb-12"
                        data-kt-buttons="true"
                        data-kt-buttons-target="[data-kt-button]"
                      >
                        <label
                          class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                          data-kt-button="true"
                        >
                          <input
                            class="btn-check"
                            type="radio"
                            name="method"
                            @click="payementMethod(0)"
                            value="0"
                          />

                          <i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0"
                            ><span class="path1"></span
                            ><span class="path2"></span
                            ><span class="path3"></span
                          ></i>

                          <span class="fs-7 fw-bold d-block">Cash</span>
                        </label>

                        <label
                          class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4 active"
                          data-kt-button="true"
                        >
                          <input
                            class="btn-check"
                            type="radio"
                            name="method"
                            @click="payementMethod(1)"
                            value="1"
                          />

                          <i class="ki-duotone ki-credit-cart fs-2hx mb-2 pe-0"
                            ><span class="path1"></span
                            ><span class="path2"></span
                          ></i>

                          <span class="fs-7 fw-bold d-block">Card</span>
                        </label>

                        <label
                          class="btn bg-light btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4"
                          data-kt-button="true"
                        >
                          <input
                            class="btn-check"
                            type="radio"
                            name="method"
                            @click="payementMethod(2)"
                            value="2"
                          />

                          <i class="ki-duotone ki-paypal fs-2hx mb-2 pe-0"
                            ><span class="path1"></span
                            ><span class="path2"></span
                          ></i>

                          <span class="fs-7 fw-bold d-block">E-Wallet</span>
                        </label>
                      </div>
                      <button
                        hidden
                        id="pdfGenerator"
                        @click="generateReport"
                      ></button>
                      <button
                        class="btn btn-primary fs-1 w-100 py-4"
                        @click="createInvoice"
                      >
                        <span class="indicator-label" v-if="isLoaging == 0">
                          Valider le payement
                        </span>

                        <span v-else-if="isLoaging == 1">
                          payement en cours...
                          <span
                            class="spinner-border spinner-border-sm align-middle ms-2"
                          ></span>
                        </span>
                        <span v-else>
                          Generation de la facture...
                          <span
                            class="spinner-border spinner-border-sm align-middle ms-2"
                          ></span>
                        </span>
                      </button>
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
      :form="form2"
      @cancel-btn="cancelBtn"
      @instance-modal="createProduct"
      activeBtn="false"
    >
      <template #title>
        {{
          updateProduct == null
            ? "Création d'un produit"
            : `Modification du produit ${updateProduct}`
        }}
      </template>
      <template #body="{ form2 }">
        <productStore
          ref="updateModalStore"
          :is-modal="true"
          @callback="productClb"
          :initial-value="initialValue"
          :cancel-btn="cancelValue"
          :form2="product.value ?? form2"
          :tags="tags"
        />
      </template>
    </modal-component>
    <vue3-html2pdf
      :show-layout="false"
      :float-layout="true"
      :enable-download="true"
      :paginate-elements-by-height="1400"
      filename="exportpdf"
      :pdf-quality="2"
      :manual-pagination="false"
      pdf-format="a4"
      :preview-modal="false"
      pdf-orientation="portrait"
      pdf-content-width="w-100"
      @progress="onProgress($event)"
      @hasStartedGeneration="hasStartedGeneration()"
      @beforeDownload="beforeDownload($event)"
      @hasGenerated="hasGenerated($event)"
      ref="html2Pdf"
    >
      <template v-slot:pdf-content>
        <!-- PDF Content Here -->

        <export-pdf
          :invoices="invoices"
          v-if="invoices.length != 0"
          :enterprise="enterprise"
          :taxe="16"
          :bills-subTotal="bills.subTotal"
          :bills-reduct="bills.reduct"
          :bills-taxe="bills.taxe"
          :bills-total="bills.total"
        />
      </template>
    </vue3-html2pdf>
  </div>
</template>
<style>
.nav-tabs .nav-link.active,
.nav-tabs .nav-item.show .nav-link {
  color: var(--bs-white);
  background-color: var(--bs-primary);
  /* border-radius: 20px 0 0 20px; */
  border: none;
}
.nav-tabs .nav-link:hover,
.nav-tabs .nav-link:focus {
  isolation: isolate;
  /* border-radius: 20px 0 0 20px; */
  border-color: var(--bs-primary);
}
.nav-tabs {
  border-bottom: 0;
}
</style>
<script>
import Vue3Html2pdf from "vue3-html2pdf";
import { useCookie } from "@vue-composable/cookie";
import exportPdf from "./exportPdf.vue";
import { onMounted, reactive, ref } from "vue";
import useCategories from "../../services/categorieservices.js";
import useProducts from "../../services/productservices.js";
import useInvoice from "../../services/invoiceservices.js";
import productStore from "../products/productStore.vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import useDeposit from "../../services/depositservices.js";
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Scrollbar, A11y } from "swiper";
// Import Swiper styles
import "swiper/css";
export default {
  components: {
    Swiper,
    SwiperSlide,
    modalComponent,
    productStore,
    Vue3Html2pdf,
    exportPdf,
  },
  setup() {
    const { categories, getCategories } = useCategories();
    const { invoices, storeInvoice } = useInvoice();
    const { deposits, getDeposits, storeDeposit } = useDeposit();
    let enterprise = reactive({});
    const { products, getProducts, storeProducts } = useProducts();
    enterprise = JSON.parse(useCookie("userAuth").cookie.value).data.enterprise
      ? JSON.parse(useCookie("userAuth").cookie.value).data.enterprise
      : {
          uuid: null,
        };
    let uuid = ref("");
    uuid.value = enterprise.uuid;
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getCategories();
      await getProducts();

      await getDeposits();
      try {
        choiceDeposit(deposits.value[0].id);
      } catch (error) {}
      ClearAll();
    }
    const isLoaging = ref(0);
    const cardList = ref([]);
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
      type_facture: "proforma",
      customer_id: 1,
      total: 1,
      money_id: 1,
      amount_paid: 0,
      payment_mode: "cash",
      discount: 0,
      vat_amount: 16,
      enterprise_id: 1,
      servant_id: 1,
      note: 1,
      table_id: 1,
      details: [
        {
          service_id: 1,
          quantity: 1,
          pos_id: 1,
          price: 1,
        },
      ],
    });
    const updateProduct = ref(null);
    const product = reactive({});
    const tags = ref([]);
    const initialValue = ref([]);
    const executeCallbackMounted = (value) => {
      updateModalStore.value.updateModalStore(value);
    };
    const editModal = (value) => {
      $("#product-modal").modal("show");
      executeCallbackMounted(value);
      try {
        updateProduct.value = value.name;
        product.value = value;
        tags.value.splice(0, tags.value.length);
        value.categories.map((item) => {
          tags.value.push(item.name);
        });

        initialValue.value.push(1);
      } catch (error) {}

      //   $("#stepOne").trigger("click");
      //   $("#finishSteppHandler").trigger("click");
    };
    const createProduct = async (data) => {
      $("#closeBtn").trigger("click");
      $("#submit").trigger("click");
      await getProducts();
    };
    const CloseModal = async () => {
      await getProducts();

      new bootstrap.Modal(element).hide();
      $("#submit").trigger("click");
    };
    const createInvoice = async () => {
      form.total = bills.value.total;
      form.discount = bills.value.reduct;
      form.amount_paid = bills.value.amount_paid;
      form.details = [];
      for (let index = 0; index < cardList.value.length; index++) {
        form.details.push({
          service_id: cardList.value[index].product.id,
          quantity: cardList.value[index].quantity,
          price:
            cardList.value[index].subTotal / cardList.value[index].quantity,
        });
      }
      isLoaging.value = 1;
      await storeInvoice({ ...form });
      ClearAll();
      isLoaging.value = 2;

      $("#pdfGenerator").click();
      isLoaging.value = 0;
    };
    const bills = ref({
      total: 0,
      reduct: 0,
      subTotal: 0,
      taxe: 0,
      amount_paid: 0,
    });

    const ClearAll = () => {
      cardList.value = [];
    };
    const addCard = (data) => {
      const price = data.pricing.filter((price) => {
        return price.principal == 1;
      });

      if (
        cardList.value.filter((product) => {
          return product.product.id == data.id;
        }).length == 0
      ) {
        cardList.value.push({
          product: data,
          quantity: 1,
          available_qte: data.store.filter(
            (el) => el.deposit_id == storeActive.value
          )[0].available_qte,
          subTotal: price.length > 0 ? price[0].price : 0,
          money: price.length > 0 ? price[0].money.abreviation : " USD",
        });
      } else {
        increase(
          cardList.value.filter((product) => {
            return product.product.id == data.id;
          })[0]
        );
      }

      Bills();
    };
    const Bills = () => {
      bills.value.taxe = (16 * bills.value.subTotal) / 100;
      bills.value.subTotal = 0;
      for (let index = 0; index < cardList.value.length; index++) {
        bills.value.subTotal += cardList.value[index].subTotal;
      }
      bills.value.total =
        bills.value.subTotal + bills.value.taxe - bills.value.reduct;
      //   bills.value.subTotal = cardList.value[0].subTotal;
    };
    const InputCreasing = (e, product) => {
      if (product.quantity > 1) {
        let quantityBefore = product.quantity;
        product.subTotal =
          (product.subTotal / quantityBefore) * product.quantity;
        Bills();
      }
    };
    const decrease = (product) => {
      if (product.quantity > 1) {
        let quantityBefore = product.quantity;
        product.quantity -= 1;
        product.subTotal =
          (product.subTotal / quantityBefore) * product.quantity;
        Bills();
      }
    };
    const increase = (product) => {
      console.log(product.available_qte);
      if (product.quantity < product.available_qte) {
        let quantityBefore = product.quantity;
        product.quantity += 1;
        product.subTotal =
          (product.subTotal / quantityBefore) * product.quantity;
        Bills();
      }
    };
    const payementMethod = (id) => {
      form.payment_mode = id == 0 ? "cash" : id == 1 ? "card" : "banque";
    };
    const activate = (index, show = null) => {
      if (index == 0 && show == null) {
        return "active";
      }
      if (index == 0 && show != null) {
        return "show active";
      }
    };
    const choiceDeposit = (id) => {
      storeActive.value = id;
      productFilter.value = products.value.filter((product) => {
        return product.store.some((store) => store.deposit_id === id);
      });
    };

    const productFilter = ref([]);
    const storeActive = ref(null);
    return {
      storeActive,
      productFilter,
      choiceDeposit,
      activate,
      deposits,
      isLoaging,
      CloseModal,
      createProduct,
      createInvoice,
      payementMethod,
      ClearAll,
      decrease,
      increase,
      addCard,
      InputCreasing,
      bills,
      cardList,
      products,
      invoices,
      form2,
      product,
      updateProduct,
      categories,
      enterprise,
      editModal,
      modules: [Navigation, Pagination, Scrollbar, A11y],
    };
  },
  methods: {
    generateReport() {
      this.$refs.html2Pdf.generatePdf();
    },
    onProgress() {},
    async beforeDownload({ html2pdf, options, pdfContent }) {
      const pdf = await html2pdf()
        .set(options)
        .from(pdfContent)
        .toPdf()
        .get("pdf");

      const totalPages = pdf.internal.getNumberOfPages();
      for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);
        pdf.setFontSize(10);
        pdf.setTextColor(150);
        pdf.setTextColor(0, 0, 0);
        pdf.text(
          "Cero 2023 | Page " + i + "/" + totalPages,
          pdf.internal.pageSize.getWidth() * 0.5,
          pdf.internal.pageSize.getHeight() - 0.3,
          { align: "center" }
        );
      }
    },
    hasStartedGeneration() {},

    hasGenerated(e) {},
  },

  data() {
    return {
      publicPath: { ...process.env },
    };
  },
};
</script>
