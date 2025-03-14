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
                Inventaire
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
                <input
                  type="text"
                  id="data_range"
                  @change="handleInput"
                  hidden
                />
                <button id="handleInput" @click="handleInput" hidden></button>
              </div>

              <a
                href="#"
                class="btn btn-sm fw-bold btn-primary"
                @click="addProduct"
              >
                Ajouter un produit
              </a>
            </div>
          </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div
            id="kt_app_content_container"
            class="app-container container-xxl"
          >
            <div class="card">
              <div class="card-body d-flex flex-column">
                <template
                  v-for="(inventory, index) in inventories"
                  :key="inventory"
                >
                  <span class="text-uppercase fw-bold fs-4 my-2">
                    {{ inventory.deposit.name }}
                  </span>
                  <div class="row">
                    <template
                      v-for="product in inventory.services"
                      :key="product.service.id"
                    >
                      <div class="col-md-6">
                        <div
                          class="d-flex align-items-center position-relative mb-7"
                        >
                          <div
                            class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"
                          ></div>

                          <div
                            class="d-flex flex-row justify-content-between w-100"
                          >
                            <div class="fw-semibold ms-5">
                              <a
                                href="#"
                                class="fs-5 fw-bold text-dark text-hover-primary"
                                >{{ product.service.name }}</a
                              >

                              <div class="fs-7 text-muted">
                                <a href="#">
                                  {{
                                    product.service.type == "1"
                                      ? "Produit"
                                      : "Service"
                                  }}
                                </a>
                              </div>
                            </div>

                            <div>
                              {{ product.service.available_qte }}
                              {{ product.service.uom_symbol ?? "" }}
                              <button
                                type="button"
                                class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end"
                              >
                                <i class="ki-duotone ki-setting-3 fs-3"
                                  ><span class="path1"></span
                                  ><span class="path2"></span
                                  ><span class="path3"></span
                                  ><span class="path4"></span
                                  ><span class="path5"></span
                                ></i>
                              </button>
                              <div
                                class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                                data-kt-menu="true"
                                data-kt-menu-id="kt-users-tasks"
                              >
                                <div class="px-7 py-5">
                                  <div class="fs-5 text-dark fw-bold">
                                    Approvisionnement rapide
                                  </div>
                                </div>

                                <div class="separator border-gray-200"></div>

                                <form
                                  class="form px-7 py-5"
                                  data-kt-menu-id="kt-users-tasks-form"
                                >
                                  <div class="fv-row mb-10">
                                    <label class="form-label fs-6 fw-semibold"
                                      >Qte:</label
                                    >
                                    <!-- inout -->
                                  </div>

                                  <div class="d-flex justify-content-end">
                                    <button
                                      type="button"
                                      class="btn btn-sm btn-light btn-active-light-primary me-2"
                                      data-kt-users-update-task-status="reset"
                                    >
                                      Annuler
                                    </button>

                                    <button
                                      type="submit"
                                      class="btn btn-sm btn-primary"
                                      data-kt-users-update-task-status="submit"
                                    >
                                      <span class="indicator-label">
                                        valider
                                      </span>
                                    </button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </template>
                  </div>
                  <div
                    className="separator separator-dotted border-secondary"
                    v-if="index < inventories.length - 1"
                  ></div>
                </template>
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
          ref="updateModalStore"
          :is-modal="true"
          @callback="CloseModal"
          :form2="data.value ? product.value : form2"
        />
      </template>
      <template #footer>
        <div class="modal-footer">
          <div class="row col-12 p-0 m-0">
            <!-- code -->
            <div class="d-flex flex-row justify-content-end">
              <button
                id="annuler"
                type="reset"
                @click="annuler"
                class="btn btn-light me-3"
                data-kt-users-modal-action="cancel"
                data-bs-dismiss="modal"
              >
                Annuler
              </button>

              <button type="submit" @click="submitData" class="btn btn-primary">
                <span class="indicator-label">Envoyer </span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import productStore from "../products/productStore.vue";

import useCategories from "../../services/categorieservices.js";
import useProducts from "../../services/productservices.js";
export default {
  components: {
    modalComponent,
    productStore,
  },
  setup() {
    onMounted(async () => {
      await callBackMounted();
    });
    const product = reactive({});
    const productFitler = ref([]);
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

    const { getCategories, categories } = useCategories();
    const {
      products,
      productStores,
      getProductsStore,
      storeProducts,
      getInventoryEnterprise,
      getProducts,
      inventories,
    } = useProducts();

    async function callBackMounted() {
      await getInventoryEnterprise();
      await getProducts();
    }
    const addProduct = () => {
      $("#product-modal").modal("show");
    };
    const updateModalStore = ref(null);
    const createProduct = async () => {
      updateModalStore.value.createProduct();
      await getInventoryEnterprise();
      await getProducts();
    };
    return {
      updateModalStore,
      createProduct,
      categories,
      products,
      product,
      productFitler,
      form2,
      cancelBtn,
      addProduct,
      createProduct,
      addProduct,
      inventories,
      form2,

      //   facturation,
    };
  },
};
</script>
