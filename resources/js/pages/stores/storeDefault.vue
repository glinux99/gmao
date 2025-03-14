<template>
  <div>
    <div
      class="app-header-menu app-header-mobile-drawer align-items-stretch"
      data-kt-drawer="true"
      data-kt-drawer-name="app-header-menu"
      data-kt-drawer-activate="{default: true, lg: false}"
      data-kt-drawer-overlay="true"
      data-kt-drawer-width="250px"
      data-kt-drawer-direction="end"
      data-kt-drawer-toggle="#kt_app_header_menu_toggle"
      data-kt-swapper="true"
      data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
      data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}"
    >
      <div
        class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
        id="kt_app_header_menu"
        data-kt-menu="true"
      >
        <div
          data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
          data-kt-menu-placement="bottom-start"
          class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2"
        >
          <span class="menu-link"
            ><span class="menu-title fw-bold">FACTURATION</span
            ><span class="menu-arrow d-lg-none"></span
          ></span>

          <div
            class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px"
          >
            <div
              class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible"
              data-kt-menu-dismiss="true"
            >
              <div class="row">
                <div class="col-lg-8 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <div class="menu-item p-0 m-0">
                        <a href="/admin/dashboard" class="menu-link">
                          <span
                            class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                          >
                            <i class="ki-duotone ki-element-11 text-primary fs-1"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                            ></i>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fs-6 fw-bold text-gray-800">Defaut</span>
                            <span class="fs-7 fw-semibold text-muted"
                              >Rapport et statistiques</span
                            >
                          </span>
                        </a>
                      </div>
                    </div>

                    <div class="col-lg-6 mb-3">
                      <div class="menu-item p-0 m-0">
                        <a href="#" class="menu-link active">
                          <span
                            class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                          >
                            <i class="ki-duotone ki-basket text-danger fs-1"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                            ></i>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fs-6 fw-bold text-gray-800">Statistiques</span>
                            <span class="fs-7 fw-semibold text-muted"
                              >Rapports de ventes</span
                            >
                          </span>
                        </a>
                      </div>
                    </div>

                    <div class="col-lg-6 mb-3">
                      <div class="menu-item p-0 m-0">
                        <a href="#" class="menu-link">
                          <span
                            class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                          >
                            <i class="ki-duotone ki-color-swatch text-success fs-1"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                              ><span class="path5"></span><span class="path6"></span
                              ><span class="path7"></span><span class="path8"></span
                              ><span class="path9"></span><span class="path10"></span
                              ><span class="path11"></span><span class="path12"></span
                              ><span class="path13"></span><span class="path14"></span
                              ><span class="path15"></span><span class="path16"></span
                              ><span class="path17"></span><span class="path18"></span
                              ><span class="path19"></span><span class="path20"></span
                              ><span class="path21"></span
                            ></i>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fs-6 fw-bold text-gray-800"
                              >Rapport de ventes</span
                            >
                            <span class="fs-7 fw-semibold text-muted"
                              >Evolution de ventes</span
                            >
                          </span>
                        </a>
                      </div>
                    </div>

                    <div class="col-lg-6 mb-3">
                      <div class="menu-item p-0 m-0">
                        <a href="#" class="menu-link">
                          <span
                            class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                          >
                            <i class="ki-duotone ki-chart-simple text-dark fs-1"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                            ></i>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fs-6 fw-bold text-gray-800"
                              >Marketing de ventes</span
                            >
                            <span class="fs-7 fw-semibold text-muted"
                              >Conversion de la monnaie</span
                            >
                          </span>
                        </a>
                      </div>
                    </div>

                    <div class="col-lg-6 mb-3">
                      <div class="menu-item p-0 m-0">
                        <a href="/admin/pos/list" class="menu-link">
                          <span
                            class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                          >
                            <i class="ki-duotone ki-abstract-42 text-danger fs-1"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fs-6 fw-bold text-gray-800">POS Systeme</span>
                            <span class="fs-7 fw-semibold text-muted"
                              >Vente en utilisant le POS
                            </span></span
                          >
                        </a>
                      </div>
                    </div>

                    <div class="col-lg-6 mb-3">
                      <div class="menu-item p-0 m-0">
                        <a href="{{ route('admin.products')}}" class="menu-link">
                          <span
                            class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                          >
                            <i class="ki-duotone ki-call text-primary fs-1"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                              ><span class="path5"></span><span class="path6"></span
                              ><span class="path7"></span><span class="path8"></span
                            ></i>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fs-6 fw-bold text-gray-800">Nos produits</span>
                            <span class="fs-7 fw-semibold text-muted"
                              >L'ensemble de nos produits</span
                            >
                          </span>
                        </a>
                      </div>
                    </div>
                  </div>

                  <div class="separator separator-dashed mx-5 my-5"></div>

                  <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-2 mx-5">
                    <div class="d-flex flex-column me-5">
                      <div class="fs-6 fw-bold text-gray-800">Page pricipale du site</div>
                      <div class="fs-7 fw-semibold text-muted">
                        Aller sur le site et explorer nos differents offres
                      </div>
                    </div>

                    <a href="/" class="btn btn-sm btn-primary fw-bold">
                      Aller sur le site
                    </a>
                  </div>
                </div>

                <div
                  class="menu-more bg-light col-lg-4 py-3 px-3 py-lg-6 px-lg-6 rounded-end"
                >
                  <h4 class="fs-6 fs-lg-4 text-gray-800 fw-bold mt-3 mb-3 ms-4">
                    Plus encore
                  </h4>

                  <div class="menu-item p-0 m-0">
                    <a href="#" class="menu-link py-2">
                      <span class="menu-title">Logistique </span>
                    </a>
                  </div>

                  <div class="menu-item p-0 m-0">
                    <a href="#" class="menu-link py-2">
                      <span class="menu-title"> Finances</span>
                    </a>
                  </div>

                  <div class="menu-item p-0 m-0">
                    <a href="#" class="menu-link py-2">
                      <span class="menu-title"> Analyse de stocks </span>
                    </a>
                  </div>

                  <div class="menu-item p-0 m-0">
                    <a href="#" class="menu-link py-2">
                      <span class="menu-title">Livraison </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          data-kt-menu-trigger="{default: 'click'}"
          data-kt-menu-placement="bottom-start"
          class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2"
        >
          <span class="menu-link"
            ><span class="menu-title">Depot: {{ deposit.name }}</span
            ><span class="menu-arrow d-lg-none"></span
          ></span>

          <div
            class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px"
          >
            <template v-for="deposit in deposits" :key="deposit.id">
              <div class="menu-item">
                <a class="menu-link" href="#"
                  ><span class="menu-icon"><li class="fa fa-store"></li></span
                  ><span class="menu-title">{{ deposit.name }}</span></a
                >
              </div>
            </template>
          </div>
        </div>
        <div class="menu-item" @click="addModalProduct">
          <div class="btn btn-sm fw-bold btn-primary">produits</div>
        </div>
      </div>
    </div>
    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="form2"
      @instance-modal="createProduct"
      activeBtn="false"
    >
      <template #title
        >{{
          updateProduct == null
            ? "Création d'un produit"
            : `Modification du produit ${updateProduct}`
        }}
      </template>
      <template #body>
        <productStore
          ref="updateModalStore"
          :is-modal="true"
          :form2="form2"
          @callback="productStoreCallback"
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

              <button type="button" @click="createProduct" class="btn btn-primary">
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
import { useCookie } from "@vue-composable/cookie";
import ficheStore from "./ficheStore.vue";
import inventaireStore from "./inventaireStore.vue";
import ServiceStore from "./serviceStore.vue";
import UsersStore from "./usersStore.vue";
import valorisationStore from "./valorisationStore.vue";
import { onMounted, reactive, ref } from "vue";
import useCategories from "../../services/categorieservices";
import useDeposit from "../../services/depositservices";
import test from "../categories/categorieSave.js";
import modalComponent from "../../components/modals/modalComponent.vue";
import { notifications } from "../../notifications/notifications";
import { FacebookLoader } from "vue-content-loader";
import useProducts from "../../services/productservices";
import useStock from "../../services/stockservices";
import productStore from "../products/productStore.vue";

export default {
  components: {
    modalComponent,
    productStore,
  },
  setup(prop, { emit }) {
    const store = reactive({});
    const {
      deposits,
      getDeposits,
      getDeposit,
      deposit,
      storeDeposit,
      removeDeposit,
    } = useDeposit();
    const {
      categoriesListString,
      categories,
      getCategories,
      storeCategories,
    } = useCategories();
    const {
      products,
      productStores,
      getProductsStore,
      storeProducts,
      inventoryProducts,
      getInventoryStore,
    } = useProducts();
    const updateModalStore = ref(null);
    const addModalProduct = () => {
      for (const [key, value] of Object.entries(JSON.parse(initForm2))) {
        form2[key] = value;
      }
      $("#product-modal").modal("show");
      updateModalStore.value.updateModalStore(null);
    };
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
    const initForm2 = JSON.stringify(form2);
    const productStoreCallback = async () => {
      try {
        depositDefault.value = JSON.parse(useCookie("store").cookie.value);
      } catch (error) {
        depositDefault.value = deposits.value[0].id;
      }

      await getProductsStore(depositDefault.value);
    };

    const createProduct = async () => {
      // alert(111);
      await updateModalStore.value.createProduct();
      emit("updateProduct");
    };
    const authUser = reactive({});
    const { ficheStock, getStockHistoryDeposit } = useStock();

    onMounted(async () => {
      await callBackMounted();
    });
    let form = reactive({
      id: null,
      name: "",
      type: "group",
      categories: [],
      enterprise_id: 1,
      description: "",
      user_id: 1,
    });
    const { dataCreated, swal } = notifications();
    let categoriesDefault = "";
    const depositDefault = ref(1);
    async function callBackMounted() {
      await getDeposits();
      await getDeposit(true, deposits.value[0].id);
      try {
        depositDefault.value = JSON.parse(useCookie("store").cookie.value);
      } catch (error) {
        depositDefault.value = deposits.value[0].id;
      }
      emit("defaultDeposit", deposit);
      //   await getCategories();
      //   await getStockHistoryDeposit(useCookie("store").cookie.value);
      //   await getProductsStore(useCookie("store").cookie.value);
      //   await getInventoryStore();
      //   $("#SelectClick").on("change", handleSelectChange);
      //   test.initTagify(categoriesListString.value.split(","));
      //   try {
      //     await getInventoryStore(useCookie("store").cookie.value);
      //   } catch (error) {}
      //   tabsActive(1);
    }
    const categorieValue = (e) => {
      let values = JSON.parse(e.target.value);
      form.categories = [];
      values.forEach((element) => {
        form.categories.push(element.value);
      });
    };
    const handleSelectChange = (event) => {
      form.type = event.target.value;
      if (event.target.value == "group") {
        $("#categorie_tags").addClass("d-none");
      } else {
        $("#categorie_tags").removeClass("d-none");
      }
    };
    const createDeposit = async () => {
      await storeDeposit({ ...form });
      dataCreated();
      await getDeposit();
      await getCategories();
      $("#categorie_tags").addClass("d-none");
      $("#SelectClick").val("group").trigger("change");
      editing.value = false;
    };
    const editing = ref(false);

    // coe
    const editModal = (value) => {
      editing.value = true;
      $("#store-modal").modal("show");
      let defautCategories = [];
      test.initTagify(categoriesListString.value.split(","), []);
      if (value.type == "category") {
        $("#SelectClick").val("category").trigger("change");
        defautCategories = value.categories.map((el) => el.name);
        test.initTagify(categoriesListString.value.split(","), defautCategories);
      } else {
        $("#categorie_tags").addClass("d-none");
        $("#SelectClick").val("group").trigger("change");
      }
      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
    };
    const alertBtn = () => {
      swal(
        "question",
        "Question",
        "Voulez-vous supprimer ce depot?",
        "Oui, d'accord",
        "Annuler",
        () => {},
        () => {},
        "",
        "btn-danger"
      );
    };
    const callback = () => {
      callBackMounted();
    };
    const productClb = async () => {
      await getStockHistoryDeposit(useCookie("store").cookie.value);
      await getProductsStore(useCookie("store").cookie.value);
      try {
        await getInventoryStore(useCookie("store").cookie.value);
      } catch (error) {}
    };
    let json_fields = ref([]);
    const json_data = ref([]);
    const fileName = ref("");
    const worksheetName = ref("");
    const tabsActive = (tab) => {
      const local_fields = reactive({});
      switch (tab) {
        case 1:
          pushData(ficheStock, {
            "Produit/Article": "service_name",
            Type: "type",
            Depot: "deposit_name",
            "Quantite Total": "quantity",
            "Quantite d'avant": "quantity_before",
            "Type de paiement": "type_approvement",
            Motif: "motif",
            "creer par": "done_by_name",
            //   prix: "service.prices[0].price",
          });

          fileName.value = "fiche_stock.xls";
          worksheetName.value = "fiche de stock";
          break;
        case 2:
          pushData(products, {
            "Produit/Article": "service.name",
            Quantite: "service.available_qte",
            prix: "service.prices[0].price",
          });

          fileName.value = "valorisation_stock.xls";
          worksheetName.value = "Valorisation de stocks";
          break;
        case 3:
          pushData(products, {
            "Produit/Article": "service.name",
            Description: "service.description",
            "Date de création": "service.created_at",
            Qantité: "service.available_qte",
            //   prix: "service.prices[0].price",
          });

          fileName.value = "articles.xls";
          worksheetName.value = "service / articles";
          break;
        case 4:
          pushData(
            inventoryProducts,

            {
              "Produit/Article": "name",
              Quantite: "available_qte",
              "Unite de mesure": "mesure_unity.name",

              //   prix: "service.prices[0].price",
            }
          );

          fileName.value = "inventaire.xls";
          worksheetName.value = "Inventaire de stock";
          break;
        default:
          break;
      }
    };
    function pushData(data, fields) {
      json_data.value = [];
      console.log(data.value);
      for (const key in data.value) {
        json_data.value.push(data.value[key]);
      }
      if (fields != null) {
        json_fields.value = [];
        json_fields.value.push(fields);
      }
    }
    const exportFile = (type) => {
      if (type == "excel") {
        $("#excel-export").click();
      }
    };
    const fichestockchange = async (data) => {
      await getStockHistoryDeposit(data);
      pushData(ficheStock, null);
    };
    return {
      fichestockchange,
      exportFile,
      productStores,
      fileName,
      worksheetName,
      json_fields,
      json_data,
      tabsActive,
      productClb,
      callback,
      alertBtn,
      editModal,
      editing,
      store,
      deposit,
      categorieValue,
      createDeposit,
      deposits,
      form,
      addModalProduct,
      form2,
      createProduct,
      productStoreCallback,
      updateModalStore,
      categoriesDefault,
      products,
      ficheStock,
      inventoryProducts,
      categoriesListString,
    };
  },
};
</script>
