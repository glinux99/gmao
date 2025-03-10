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
              Catalogue
            </h1>
          </div>
        </div>
      </div>

      <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
          <div class="card">
            <div class="card-header border-0 pt-6">
              <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                  <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
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
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                  <a href="/admin/product" type="button" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i> Ajouter un Produit
                  </a>
                  <button
                    type="button"
                    class="btn btn-light-primary ms-3"
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
                  <div @click="importFile" class="btn btn-light-primary ms-3">
                    <i class="ki-duotone ki-cloud fs-2"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Importer
                  </div>
                  <input
                    id="fileInput"
                    type="file"
                    accept=".csv"
                    @change="onFileChange($event)"
                    aria-label="photo"
                    multiple
                    hidden
                  />
                  <a
                    data-bs-toggle="tooltip"
                    title="Telecharger le model d'importation de produits"
                    href="/files/products_model.csv"
                    class="btn btn-light-primary ms-3"
                    download=""
                  >
                    <i class="fa fa-file-csv fs-2"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                  </a>
                </div>

                <div
                  class="d-flex justify-content-end align-items-center d-none"
                  data-kt-user-table-toolbar="selected"
                >
                  <div class="fw-bold me-5">
                    <span class="me-2" data-kt-user-table-select="selected_count"></span>
                    Selectionne(s)
                  </div>

                  <button type="button" class="btn btn-danger">
                    Supprimer la selection
                  </button>
                </div>
              </div>
            </div>

            <div class="card-body py-4">
              <table
                class="table align-middle table-row-dashed fs-6 gy-5"
                id="kt_table_users"
              >
                <thead>
                  <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
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

                    <th class="min-w-125px">Categorie</th>

                    <th class="min-w-125px">Prix</th>
                    <th class="min-w-100px">Type</th>
                    <th
                      class="min-w-100px"
                      data-bs-toggle="tooltip"
                      title="Unite de mesure"
                    >
                      UM
                    </th>

                    <th class="text-end min-w-100px">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                  <template v-for="product in products" :key="product.id">
                    <tr>
                      <td>
                        <div
                          class="form-check form-check-sm form-check-custom form-check-solid"
                        >
                          <input class="form-check-input" type="checkbox" value="1" />
                        </div>
                      </td>
                      <td class="d-flex align-items-center">
                        <!-- {{-- Avatar --}} -->
                        <div
                          v-if="product.service.photo == null"
                          class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                        >
                          <div>
                            <div class="symbol-label fs-3 bg-light-danger text-danger">
                              <!-- {{
                                                    $user->user_name[0] }} -->
                              {{ product.service.name[0] }}
                            </div>
                          </div>
                        </div>

                        <div
                          v-else
                          class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                        >
                          <a href="">
                            <div class="symbol-label">
                              <img
                                :src="
                                  product.service.remember_pic_link +
                                  product.service.uom_id +
                                  '-0.png'
                                "
                                alt="&nbsp;Erreur"
                                class="w-100"
                                @error="$event.target.src = '/images/no-image.png'"
                              />
                            </div>
                          </a>
                        </div>
                      </td>
                      <td @click="viewProduct(product.service.id)" class="cursor-pointer">
                        {{ product.service.name }}
                      </td>
                      <td>
                        {{ product.service.category_name ?? "" }}
                      </td>

                      <td>
                        <template v-for="price in product.prices" :key="price.id">
                          <span class="badge badge-secondary">
                            {{ `${price.label} : ${price.price} ${price.abreviation}` }}
                          </span>
                        </template>
                      </td>
                      <td>
                        {{ product.service.type == "1" ? "Service" : "Article" }}
                      </td>
                      <td>
                        {{ product.service.uom_name ?? "-" }}
                        <small v-if="product.service.uom_symbol != null"
                          >({{ product.service.uom_symbol ?? "" }})</small
                        >
                      </td>
                      <td class="text-end">
                        <button
                          class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                          @click="editModal(product.service)"
                        >
                          <i class="ki-duotone ki-pencil fs-3"
                            ><span class="path1"></span><span class="path2"></span
                            ><span class="path3"></span><span class="path4"></span
                            ><span class="path5"></span
                          ></i>
                        </button>
                        <button
                          class="btn btn-icon btn-active-light-primary w-30px h-30px"
                        >
                          <i class="ki-duotone ki-trash fs-3"
                            ><span class="path1"></span><span class="path2"></span
                            ><span class="path3"></span><span class="path4"></span
                            ><span class="path5"></span
                          ></i>
                        </button>
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

    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="product"
      @cancel-btn="cancelBtn"
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
      <template>
        <productStore
          ref="updateModalStore"
          :is-modal="true"
          @callback="CloseModal"
          :initial-value="initialValue"
          :cancel-btn="cancelValue"
          :form2="data.value ? product.value : form2"
          :tags="tags"
        />
      </template>
    </modal-component>
    <export-excel
      type="pdf"
      class="d-none"
      id="excel-export"
      :data="products"
      :fields="json_fields"
      worksheet="Liste de mes produits/articles"
      name="articles.xls"
    >
    </export-excel>
    <modal-component
      id="import-modal"
      :positionModal="`center mw-800px`"
      activeBtn="false"
      :isCss="true"
    >
      <template #title>
        {{ "Importation de donnee" }}
      </template>
      <template #body>
        <div class="mx-5">
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            <input
              type="text"
              :class="`ps-13 form-control form-control-lg form-control-solid`"
              :placeholder="`chercher un service`"
            />
          </div>
          <div class="mx-5">
            <div class="my-5 fw-bold text-muted">
              Importation de donnee ({{ importData.length }})
            </div>
            <div class="card-body d-flex flex-column">
              <template v-for="service in importData" :key="service.id">
                <div class="d-flex align-items-center position-relative mb-7">
                  <div
                    class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"
                  ></div>

                  <div class="d-flex flex-row justify-content-between w-100">
                    <div class="fw-semibold ms-5">
                      <div
                        class="fs-5 fw-bold text-dark text-hover-primary cursor-pointer"
                      >
                        {{ service.name }}
                      </div>

                      <div class="fs-7 text-muted">
                        <a href="#">
                          Prix:
                          {{
                            `${service.prix_detail} | ${service.prix_gros} | ${service.prix_detail}`
                          }}
                        </a>
                      </div>
                    </div>

                    <div>
                      <span
                        class="badge badge-secondary me-5"
                        v-if="service.available_qte != '\r'"
                      >
                        Qte
                        {{ service.available_qte != "\r" ? service.available_qte : 0 }}
                      </span>
                      <div
                        @click="deleteImport(service)"
                        class="btn btn-icon btn-active-light-primary w-30px h-30px"
                      >
                        <i class="ki-duotone ki-trash fs-3"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                        ></i>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
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
import { export as exportExcel } from "vue-excel-export";

import { onMounted, onUpdated, reactive, ref } from "vue";
import moment from "moment";
import { useCookie } from "@vue-composable/cookie";
import useHistoryWebServices from "../../services/historyservices.js";
export default {
  components: {
    modalComponent,
    productStore,
  },
  setup(props, { emit }) {
    const product = reactive({});
    const tags = ref([]);
    const initialValue = ref([]);
    const updateProduct = ref(null);
    const { getHistory, linkHistory } = useHistoryWebServices();
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
    const backLink = ref("");
    async function callBackMounted() {
      await getProducts();
      await getEntreprise();
      await getDeposits();
      getHistory();
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
    const updateModalStore = ref(null);
    const executeCallbackMounted = (value) => {
      updateModalStore.value.updateModalStore(value);
    };
    const editModal = (value) => {
      updateProduct.value = value.name;
      console.log(updateProduct);
      executeCallbackMounted(value);

      $("#stepOne").trigger("click");
      $("#finishSteppHandler").trigger("click");

      $("#product-modal").modal("show");
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
    const exportFile = (type) => {
      if (type == "excel") {
        $("#excel-export").click();
      }
    };

    const json_fields = {
      "Produit/Article": "service.name",
      Description: "service.description",
      "Code manuelle": "service.code_manuel",
      point: "service.point",
      nbrgros: "service.nbrgros",
      "Bonus Applicable": "service.bonus_applicable",
      "Date de création": "created_at",
      //   prix: "service.prices[0].price",
    };

    const viewProduct = (id) => {
      const productCookie = useCookie("product");
      productCookie.setCookie(JSON.stringify(id));
      location.href = "/admin/product/details";
    };
    const importFile = () => {
      $("#fileInput").click();
    };
    const onFileChange = (event) => {
      const file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = (e) => {
        const data = e.target.result;

        importData.value = csvJSON(data);
      };
      reader.readAsText(file);
      $("#import-modal").modal("show");
    };
    function csvJSON(csv) {
      var lines = csv.split("\n");

      var result = [];

      var headers = lines[0].split(",");
      headers = headers.map((el) => el.replace("\r", ""));
      for (var i = 1; i < lines.length - 1; i++) {
        var obj = {};
        var currentline = lines[i].split(",");

        for (var j = 0; j < headers.length; j++) {
          obj[headers[j]] = currentline[j];
        }

        result.push(obj);
      }
      return result;
    }
    const importData = ref([]);
    const deleteImport = (service) => {
      importData.value = importData.value.filter((serv) => serv != service);
    };
    return {
      deleteImport,
      importData,
      onFileChange,
      importFile,
      linkHistory,
      viewProduct,
      backLink,
      json_fields,
      exportFile,
      updateProduct,
      updateModalStore,
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
