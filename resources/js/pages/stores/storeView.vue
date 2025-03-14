<template>
  <div>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="d-flex flex-column flex-lg-row">
              <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                <div class="card mb-5 mb-xl-8 p-0">
                  <div class="card-body p-0 m-0">
                    <div class="d-flex flex-center flex-column py-2">
                      <div class="align-self-end px-5">
                        <button
                          @click="editModal(deposit)"
                          data-bs-toggle="tooltip"
                          title="Editer le depot"
                          type="button"
                          class="btn btn-light-primary btn-sm me-1"
                        >
                          <i class="ki-duotone ki-pencil fs-3"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                        </button>
                        <span
                          @click="alertBtn"
                          data-bs-toggle="tooltip"
                          title="Supprimer le depot"
                          class="btn btn-light-danger btn-sm"
                        >
                          <i class="ki-duotone ki-trash fs-3"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                        </span>
                      </div>
                      <div class="mx-20" v-if="deposit.name == null">
                        <facebook-loader :animate="true" :speed="1"> </facebook-loader>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-5" v-else>
                        <div class="symbol symbol-100px symbol-circle mb-7 me-3">
                          <li class="fa fa-store display-5"></li>
                        </div>
                        <div class="d-flex flex-column">
                          <a
                            href="#"
                            class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3"
                          >
                            {{ deposit.name }}
                          </a>

                          <div class="mx-auto">
                            <span class="badge badge-lg badge-light-primary d-inline">
                              {{ deposit.type == "group" ? "Groupe" : "Categories" }}
                            </span>
                          </div>
                        </div>
                      </div>

                      <div class="fw-bold mb-3">
                        Status du depot

                        <span
                          class="ms-2"
                          ddata-bs-toggle="popover"
                          data-bs-trigger="hover"
                          data-bs-html="true"
                          data-bs-content="Number of support tickets assigned, closed and pending this week."
                        >
                          <i class="ki-duotone ki-information fs-7"
                            ><span class="path1"></span><span class="path2"></span
                            ><span class="path3"></span
                          ></i>
                        </span>
                      </div>

                      <div class="d-flex flex-wrap flex-center">
                        <div
                          class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3"
                        >
                          <div class="fs-4 fw-bold text-gray-700">
                            <span
                              class="w-75px"
                              id="kt_countup_1"
                              data-kt-countup="true"
                              :data-kt-countup-value="deposit.approv + deposit.destock"
                              >{{ deposit.approv + deposit.destock }}</span
                            >
                            <i class="ki-duotone ki-arrow-up fs-3 text-success"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </div>
                          <div class="fw-semibold text-muted">Total</div>
                        </div>

                        <div
                          class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3"
                        >
                          <div class="fs-4 fw-bold text-gray-700">
                            <span
                              class="w-50px"
                              id="kt_countup_1"
                              data-kt-countup="true"
                              :data-kt-countup-value="deposit.approv"
                              >{{ deposit.approv }}</span
                            >
                            <i class="ki-duotone ki-arrow-up fs-3 text-success"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </div>
                          <div class="fw-semibold text-muted">Approv.</div>
                        </div>

                        <div
                          class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3"
                        >
                          <div class="fs-4 fw-bold text-gray-700">
                            <span
                              class="w-50px"
                              id="kt_countup_1"
                              data-kt-countup="true"
                              :data-kt-countup-value="deposit.destock"
                              >{{ deposit.destock }}</span
                            >
                            <i class="ki-duotone ki-arrow-down fs-3 text-danger"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </div>
                          <div class="fw-semibold text-muted">Destock</div>
                        </div>
                      </div>
                    </div>

                    <div
                      class="menu menu-column menu-sub-indention fs-4 py-3"
                      id="#kt_app_sidebar_menu"
                      data-kt-menu="true"
                      data-kt-menu-expand="true"
                    >
                      <div
                        data-kt-menu-trigger="click"
                        class="menu-item here menu-accordion"
                      >
                        <span class="menu-link"
                          ><span class="menu-icon"
                            ><i class="ki-duotone ki-information-2 fs-2"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span
                              ><span class="path4"></span></i></span
                          ><span class="menu-title">
                            <div class="d-flex align-items-center gap-3">
                              <span class="fw-bold text-dark">Details</span>
                            </div>
                          </span>

                          <span class="menu-arrow"></span>
                          <span
                            data-bs-toggle="tooltip"
                            data-bs-trigger="hover"
                            title="Editer les details du depot"
                          >
                          </span>
                        </span>
                        <div class="menu-sub menu-sub-accordion border-top border-1">
                          <div class="menu-item mt-3">
                            <div id="kt_user_view_details" class="collapse show">
                              <div class="pb-5 fs-6">
                                <div class="fw-bold mt-5">Designation</div>
                                <div class="text-gray-600">
                                  {{ deposit.description }}
                                </div>

                                <div class="fw-bold mt-5">Type</div>
                                <div class="text-gray-600">
                                  <a href="#" class="text-gray-600 text-hover-primary">
                                    {{
                                      deposit.type == "group" ? "Groupe" : "Categories"
                                    }}</a
                                  >
                                </div>

                                <div class="fw-bold mt-5">Qte de produits /Services</div>
                                <div class="text-gray-600">12</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <users-store />
              </div>

              <div class="flex-lg-row-fluid ms-lg-15">
                <div class="card-toolbar d-flex justify-content-end">
                  <button
                    type="button"
                    class="btn btn-primary btn-sm ms-3"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end"
                  >
                    <i class="ki-duotone ki-cloud-download fs-2"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Exporter
                  </button>
                  <div
                    class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                    data-kt-menu="true"
                    data-kt-menu-id="kt-users-tasks"
                  >
                    <div class="px-7 py-5">
                      <div class="fs-5 text-dark fw-bold">Exporter les donnees en :</div>
                    </div>

                    <div class="separator border-gray-200"></div>

                    <div class="form px-7 py-5" data-kt-menu-id="kt-users-tasks-form">
                      <div class="fv-row mb-10 d-flex">
                        <button
                          @click="exportFile('excel')"
                          class="btn btn-outline badge-success px-5 py-1 btn-light-primary"
                        >
                          <i class="fa fa-file-excel text-success fs-2"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          Excel
                        </button>
                        <button
                          @click="exportFile('pdf')"
                          class="ms-1 btn btn-outline badge-danger px-5 py-1 btn-light-primary"
                        >
                          <i class="fa fa-file-pdf text-danger fs-2"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          PDF
                        </button>
                        <button
                          @click="exportFile('csv')"
                          class="ms-1 btn btn-outline badge-info px-5 py-1 btn-light-primary"
                        >
                          <i class="fa fa-file-csv text-info fs-2"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          CSV
                        </button>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-light-primary btn-sm">
                    <i class="ki-duotone ki-cloud-add fs-3"
                      ><span class="path1"></span><span class="path2"></span
                      ><span class="path3"></span
                    ></i>
                    Importation
                  </button>
                </div>
                <ul
                  class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8"
                >
                  <li class="nav-item" id="tabsActive_1">
                    <a
                      class="nav-link text-active-primary pb-4 active"
                      data-bs-toggle="tab"
                      href="#kt_user_view_overview_tab"
                      @click="tabsActive(1)"
                      >Fiche</a
                    >
                  </li>

                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-kt-countup-tabs="true"
                      data-bs-toggle="tab"
                      href="#kt_valorisation_store"
                      @click="tabsActive(2)"
                      >Valorisation</a
                    >
                  </li>

                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-bs-toggle="tab"
                      href="#kt_inventory_store"
                      @click="tabsActive(3)"
                      >Articles</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-bs-toggle="tab"
                      href="#kt_service_store"
                      @click="tabsActive(4)"
                      >Inventaire</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-bs-toggle="tab"
                      href="#kt_transfert_store"
                      @click="tabsActive(5)"
                      >Transfert</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-bs-toggle="tab"
                      href="#kt_transfert_store"
                      @click="tabsActive(6)"
                      >Demande</a
                    >
                  </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="kt_user_view_overview_tab"
                    role="tabpanel"
                  >
                    <fiche-store
                      :ficheStock="ficheStock"
                      @fichestockchange="fichestockchange"
                    />
                  </div>

                  <div class="tab-pane fade" id="kt_valorisation_store" role="tabpanel">
                    <valorisation-store :products="productStores" />
                  </div>
                  <div class="tab-pane fade" id="kt_service_store" role="tabpanel">
                    <inventaire-store
                      @callback="callback"
                      :inventoryProducts="inventoryProducts"
                    />
                  </div>
                  <div class="tab-pane fade" id="kt_inventory_store" role="tabpanel">
                    <service-store :productsProps="products" @productClb="productClb" />
                  </div>

                  <div class="tab-pane fade" id="kt_transfert_store" role="tabpanel">
                    Transfert
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <modal-component
      id="store-modal"
      :positionModal="`right`"
      :form="form"
      @instance-modal="createDeposit"
    >
      <template #title>
        {{ editing == true ? `Modification du ${form.name}` : "Création d'un dépôt" }}
      </template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div class="card-text">
              <div class="mb-5 fv-row">
                <label class="required form-label">Nom de votre dépôt</label>

                <input
                  type="text"
                  v-model="form.name"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">Configurer le nom de ce dépôt</div>
              </div>
              <div class="mb-5 fv-row">
                <label class="required form-label">Type de dépôt</label>

                <div class="">
                  <select
                    id="SelectClick"
                    class="form-select form-select-solid fw-bold"
                    data-placeholder="Selectionner un type"
                    data-hide-search="true"
                    data-control="select2"
                    data-dropdown-css-class="w-230px"
                  >
                    <option></option>
                    <option data-subtext="categories" value="group" selected>
                      Groupe
                    </option>
                    <option data-subtext="Groupe de dépôt" value="category">
                      Categorie
                    </option>
                  </select>
                  <div class="valid-feedback">Par defaut groupe</div>
                </div>
              </div>
              <div class="mb-5 fv-row d-none" id="categorie_tags">
                <label class="required form-label">Categorie</label>
                <input
                  @change="categorieValue"
                  id="add_product_categorie_tags"
                  class="form-control mb-2"
                />
                <div class="text-muted fs-7">Configurer une categorie de ce dépôt</div>
              </div>
              <div class="mb-5 fv-row">
                <label class="required form-label">Description</label>

                <textarea
                  v-model="form.description"
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
      </template>
    </modal-component>

    <export-excel
      id="excel-export"
      :data="json_data"
      :fields="json_fields[0]"
      :worksheet="worksheetName"
      :name="fileName"
      class="d-none"
    >
    </export-excel>
  </div>
</template>
<style>
.image-input-placeholder-light {
  background-image: url("~/assets/bl-img.svg");
}

.image-input-placeholder-dark {
  background-image: url("~/assets/bl-img-dark.svg");
}
</style>
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

export default {
  components: {
    FacebookLoader,
    inventaireStore,
    ServiceStore,
    ficheStore,
    valorisationStore,
    UsersStore,
    modalComponent,
  },
  setup() {
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
    async function callBackMounted() {
      await getDeposit();
      await getCategories();
      await getStockHistoryDeposit(useCookie("store").cookie.value);
      await getProductsStore(useCookie("store").cookie.value);
      //   await getInventoryStore();

      $("#SelectClick").on("change", handleSelectChange);

      test.initTagify(categoriesListString.value.split(","));

      try {
        await getInventoryStore(useCookie("store").cookie.value);
      } catch (error) {}
      tabsActive(1);
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
      categoriesDefault,
      products,
      ficheStock,
      inventoryProducts,
      categoriesListString,
    };
  },
};
</script>
