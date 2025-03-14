<template>
  <div>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
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
                Catalogue
              </h1>
            </div>
          </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div
            id="kt_app_content_container"
            class="app-container container-xxl"
          >
            <div class="card">
              <div class="card-header border-0 pt-6">
                <div class="card-title">
                  <div class="d-flex align-items-center position-relative my-1">
                    <i
                      class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    <input
                      type="text"
                      data-kt-user-table-filter="search"
                      class="form-control form-control-solid w-250px ps-13"
                      placeholder="Rechercher un Produit"
                    />
                  </div>
                </div>

                <div class="card-toolbar">
                  <div
                    class="d-flex justify-content-end"
                    data-kt-user-table-toolbar="base"
                  >
                    <button
                      type="button"
                      class="btn btn-light-primary me-3"
                      data-kt-menu-trigger="click"
                      data-kt-menu-placement="bottom-end"
                    >
                      <i class="ki-duotone ki-filter fs-2"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Filtre
                    </button>

                    <div
                      class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                      data-kt-menu="true"
                    >
                      <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                      </div>

                      <div class="separator border-gray-200"></div>

                      <div class="px-7 py-5" data-kt-user-table-filter="form">
                        <div class="mb-5">
                          <label class="form-label fs-6 fw-semibold"
                            >Depot</label
                          >
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner un depot"
                            data-allow-clear="true"
                            data-kt-user-table-filter="depot"
                            data-hide-search="true"
                          >
                            <option></option>
                            <template
                              v-for="deposit in deposits"
                              :key="deposit.id"
                            >
                              <option :value="deposit.name">
                                {{ deposit.name }}
                              </option>
                            </template>
                          </select>
                        </div>
                        <div class="mb-10">
                          <label class="form-label fs-6 fw-semibold"
                            >Entreprise</label
                          >
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner une entreprise"
                            data-allow-clear="true"
                            data-kt-user-table-filter="entreprise"
                            data-hide-search="true"
                          >
                            <option></option>
                            <template
                              v-for="entreprise in entreprises"
                              :key="entreprise.id"
                            >
                              <option :value="entreprise.name">
                                {{ entreprise.name }}
                              </option>
                            </template>
                          </select>
                        </div>

                        <div class="d-flex justify-content-end">
                          <button
                            type="reset"
                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                            data-kt-menu-dismiss="true"
                            data-kt-user-table-filter="reset"
                          >
                            Reinitialiser
                          </button>
                          <button
                            type="submit"
                            class="btn btn-primary fw-semibold px-6"
                            data-kt-menu-dismiss="true"
                            data-kt-user-table-filter="filter"
                          >
                            Appliquer
                          </button>
                        </div>
                      </div>
                    </div>

                    <button
                      type="button"
                      class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#product-modal"
                    >
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un Produit
                    </button>
                  </div>

                  <div
                    class="d-flex justify-content-end align-items-center d-none"
                    data-kt-user-table-toolbar="selected"
                  >
                    <div class="fw-bold me-5">
                      <span
                        class="me-2"
                        data-kt-user-table-select="selected_count"
                      ></span>
                      Selectionne(s)
                    </div>

                    <button
                      type="button"
                      class="btn btn-danger"
                      data-kt-user-table-select="delete_selected"
                    >
                      Supprimer la selection
                    </button>
                  </div>

                  <div
                    class="modal fade"
                    id="kt_modal_export_users"
                    tabindex="-1"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2 class="fw-bold">Export Users</h2>

                          <div
                            class="btn btn-icon btn-sm btn-active-icon-primary"
                            data-kt-users-modal-action="close"
                          >
                            <i class="ki-duotone ki-cross fs-1"
                              ><span class="path1"></span
                              ><span class="path2"></span
                            ></i>
                          </div>
                        </div>

                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                          <form
                            id="kt_modal_export_users_form"
                            class="form"
                            action="#"
                          >
                            <div class="fv-row mb-10">
                              <label class="fs-6 fw-semibold form-label mb-2"
                                >Selectionner un role:</label
                              >

                              <!-- <select
                                name="entreprise"
                                data-control="select2"
                                data-placeholder="Selectionner une entreprise"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              >
                                <option></option>
                                <template
                                  v-for="entreprise in entreprises"
                                  :key="entreprise.id"
                                >
                                  <option :value="enterprise.name">
                                    {{ enterprise.name }}
                                  </option>
                                </template>
                              </select> -->
                            </div>

                            <div class="text-center">
                              <button
                                type="reset"
                                class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel"
                              >
                                Annuler
                              </button>

                              <button
                                type="submit"
                                class="btn btn-primary"
                                data-kt-users-modal-action="submit"
                              >
                                <span class="indicator-label"> Envoyer </span>
                                <span class="indicator-progress">
                                  Svp patienter
                                  <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"
                                  ></span>
                                </span>
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body py-4">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5"
                  id="kt_table_users"
                >
                  <thead>
                    <tr
                      class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                    >
                      <th class="w-10px pe-2">
                        <div
                          class="form-check form-check-sm form-check-custom form-check-solid me-3"
                        >
                          <input
                            class="form-check-input"
                            type="checkbox"
                            data-kt-check="true"
                            data-kt-check-target="#kt_table_users .form-check-input"
                            value="1"
                          />
                        </div>
                      </th>
                      <th>Image</th>
                      <th class="min-w-125px">Nom</th>
                      <th class="min-w-125px">Description</th>

                      <th class="min-w-125px">Type</th>

                      <th class="min-w-125px">Date de creation</th>

                      <th class="text-center">Prix</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-600 fw-semtext-centeribold">
                    <template v-for="product in products" :key="product.id">
                      <tr>
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value="1"
                            />
                          </div>
                        </td>
                        <td class="d-flex align-items-center">
                          <!-- {{-- Avatar --}} -->
                          <div
                            v-if="product.photo == null"
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="#">
                              <div
                                class="symbol-label fs-3 bg-light-danger text-danger"
                              >
                                <!-- {{
                                                    $user->user_name[0] }} -->
                                {{ product.name[0] }}
                              </div>
                            </a>
                          </div>

                          <div
                            v-else
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="">
                              <div class="symbol-label">
                                <img
                                  :src="
                                    product.remember_pic_link +
                                    product.uom_id +
                                    '-0.png'
                                  "
                                  alt="&nbsp;Erreur"
                                  class="w-100"
                                  @error="
                                    $event.target.src = '/images/no-image.png'
                                  "
                                />
                              </div>
                            </a>
                          </div>
                        </td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.description }}</td>

                        <td>
                          {{ product.type == "1" ? "Article" : "Service" }}
                        </td>
                        <td>{{ convertDate(product.created_at) }}</td>

                        <td>
                          <template
                            v-for="price in product.pricing"
                            :key="price.id"
                          >
                            <span class="badge badge-secondary">
                              {{
                                `${price.label} : ${price.price} ${
                                  price.money?.abreviation != undefined
                                    ? price.money?.abreviation
                                    : ""
                                } &nbsp;`
                              }}
                            </span>
                          </template>
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
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
          :initialValue="calling"
          :form2="data.value ? product.value : form2"
        />
      </template>
    </modal-component>
  </div>
</template>
<script>
import useProducts from "../../services/productservices.js";
import useEntreprises from "../../services/enterpriseservices.js";
import useDeposit from "../../services/depositservices.js";
import productStore from "./productStore.vue";
import modalComponent from "../../components/modals/modalComponent.vue";

import { onMounted, onUpdated, reactive, ref } from "vue";
import moment from "moment";
export default {
  components: {
    modalComponent,
    productStore,
  },
  setup(props, { emit }) {
    const product = reactive({});
    const tags = ref([]);
    const initialValue = ref([]);

    const { products, getProducts, storeProducts } = useProducts();
    const { entreprises, getEntreprise } = useEntreprises();
    const { deposits, getDeposits } = useDeposit();
    onMounted(async () => {
      await callBackMounted();
    });
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
    async function callBackMounted() {
      await getProducts();
      await getEntreprise();
      await getDeposits();
    }

    const createProduct = async (data) => {
      $("#closeBtn").trigger("click");
      $("#submit").trigger("click");
      await getProducts();
    };
    const CloseModal = async () => {
      initialValue.value;

      product.value = {};

      await getProducts();

      new bootstrap.Modal(element).hide();
      $("#submit").trigger("click");
    };

    const editModal = (value) => {
      $("#stepOne").trigger("click");
      $("#finishSteppHandler").trigger("click");

      $("#product-modal").modal("show");
      document.querySelector("#backStepper").classList.add("d-none");
      document.querySelector("#nextStepper").classList.remove("d-none");
      document.querySelector("#submit-next").classList.add("d-none");
      document.querySelector("#submit").classList.add("d-none");
      product.value = value;

      tags.value.splice(0, tags.value.length);
      value.categories.map((item) => {
        tags.value.push(item.name);
      });

      initialValue.value.push(1);
    };

    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY");
    };
    const cancelBtn = () => {
      $("#stepOne").trigger("click");
      cancelValue.value = true;
      initialValue.value.splice(0, initialValue.value.length);
    };
    const cancelValue = ref(false);
    return {
      initialValue,
      tags,
      cancelValue,
      cancelBtn,
      convertDate,
      CloseModal,
      createProduct,
      products,
      editModal,
      product,
      form2,
      entreprises,
      deposits,
    };
  },
};
</script>
