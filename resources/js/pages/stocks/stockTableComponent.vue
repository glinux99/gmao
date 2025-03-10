<template>
  <div>
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
                  :class="`form-control form-control-solid w-250px  ps-13 ${disable}`"
                  :placeholder="`chercher dans l'historiques `"
                />
                <input
                  type="text"
                  v-model="search"
                  data-kt-user-table-filter="search"
                  :class="`form-control form-control-solid v-auto  ps-13 ${
                    disable == 'd-none' ? ' ' : 'd-none'
                  }`"
                  :placeholder="`chercher dans l'historiques`"
                />
              </div>
            </div>

            <div :class="`card-toolbar `">
              <div
                class="d-flex flex-stack flex-wrap gap-4"
                data-kt-user-table-toolbar="base"
              >
                <div data-kt-user-table-filter="form" :class="`${disable}`">
                  <div class="d-flex align-items-center fw-bold">
                    <div class="text-muted fs-7 me-2">Filter</div>
                    <select
                      id="SelectClick"
                      class="form-select form-select-solid fw-bold"
                      data-kt-select2="true"
                      data-placeholder="type de mouvement"
                      data-allow-clear="true"
                      data-dropdown-css-class="w-230px"
                      data-kt-user-table-filter="entreprise"
                      data-hide-search="true"
                    >
                      <option></option>
                      <option value="resetFilter">afficher tout</option>
                      <option value="entry">Approvissionnement</option>
                      <option value="withdraw">Destockage</option>
                    </select>
                  </div>

                  <div :class="`d-flex justify-content-end d-none`">
                    <button
                      id="resetFilter"
                      type="reset"
                      class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                      data-kt-menu-dismiss="true"
                      data-kt-user-table-filter="reset"
                    >
                      Reinitialiser
                    </button>
                    <button
                      id="filterValue"
                      type="submit"
                      class="btn btn-primary fw-semibold px-6"
                      data-kt-menu-dismiss="true"
                      data-kt-user-table-filter="filter"
                    >
                      Appliquer
                    </button>
                  </div>
                </div>

                <!-- code apres -->
                <div
                  @click="alertBtn"
                  :class="`btn btn-light btn-sm ${disable}`"
                >
                  Effectuer un mouvement
                </div>
              </div>

              <div
                :class="`d-flex justify-content-end align-items-center ${
                  disable == 'd-none' ? ' ' : 'd-none'
                }`"
                data-kt-user-table-toolbar="selected"
              >
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
                          ><span class="path1"></span><span class="path2"></span
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
                            >Select Role:</label
                          >

                          <select
                            name="entreprise"
                            data-control="select2"
                            data-placeholder="Selectionner une entreprise"
                            data-hide-search="true"
                            class="form-select form-select-solid fw-bold"
                          >
                            <option></option>

                            <option value="entrprise">"entrprise"</option>
                          </select>
                        </div>

                        <div class="fv-row mb-10">
                          <label
                            class="required fs-6 fw-semibold form-label mb-2"
                            >Select Export Format:</label
                          >

                          <select
                            name="format"
                            data-control="select2"
                            data-placeholder="Select a format"
                            data-hide-search="true"
                            class="form-select form-select-solid fw-bold"
                          >
                            <option></option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="cvs">CVS</option>
                            <option value="zip">ZIP</option>
                          </select>
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
                  class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                >
                  <th class="min-w-180px">Item</th>
                  <th :class="`text-end pe-3 min-w-100px ${disable}`">
                    Product ID
                  </th>
                  <th :class="`text-end pe-3 min-w-150px ${disable}`">
                    Date d'exp
                  </th>
                  <th :class="`text-end pe-3 min-w-100px ${disable}`">
                    Type d'entree
                  </th>
                  <th :class="`text-end pe-3 min-w-100px ${disable}`">Motif</th>
                  <th :class="`text-end pe-3 min-w-100px ${disable}`">
                    Entreprise
                  </th>
                  <th :class="`text-end pe-0 min-w-75px ${disable} `">Qte</th>
                  <th :class="`text-end pe-0 min-w-75px ${disable}`">
                    Qte before
                  </th>
                </tr>
              </thead>

              <tbody class="fw-bold text-gray-600">
                <template
                  v-for="product in filteredStockServices"
                  :key="product.id"
                >
                  <tr>
                    <td class="d-flex">
                      <div
                        class="form-check form-check-sm form-check-custom form-check-solid me-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          value="1"
                        />
                      </div>
                      <span class="text-dark text-hover-primary">{{
                        product.service.name
                      }}</span>
                    </td>

                    <td :class="`text-end ${disable}`">
                      {{
                        product.service.codebar ||
                        product.service.code_manuel ||
                        product.service.uom_id ||
                        product.service.id
                      }}
                    </td>

                    <td :class="`text-end ${disable}`">
                      {{ product.expiration_date || "jamais" }}
                    </td>

                    <td :class="`text-end ${disable}`">
                      <!-- {{ product.price }} -->

                      <span
                        :class="
                          product.type == 'entry'
                            ? 'badge py-3 px-4 fs-7 badge-light-primary'
                            : 'badge py-3 px-4 fs-7 badge-light-danger'
                        "
                      >
                        {{ product.type }}</span
                      >
                    </td>

                    <td :class="`text-end ${disable}`">
                      {{ product.motif }}
                    </td>
                    <td :class="`text-end ${disable}`">
                      {{ product.enterprise.name }}
                    </td>

                    <td :class="`text-end ${disable}`" data-order="58">
                      <span class="text-dark fw-bold">
                        <span
                          :class="
                            product.quantity > 0
                              ? 'badge py-3 px-4 fs-7 badge-light-primary'
                              : 'badge py-3 px-4 fs-7 badge-light-danger'
                          "
                        >
                          {{ product.quantity }}</span
                        >
                      </span>
                    </td>
                    <td :class="`text-end ${disable}`" data-order="58">
                      <span class="text-dark fw-bold">
                        {{ product.quantity_before || 0 }}
                      </span>
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
</template>
<script>
import { computed, onMounted, ref, watch } from "vue";
import useProducts from "../../services/productservices.js";
import useStock from "../../services/stockservices.js";
import Swal from "sweetalert2";

import modalComponent from "../../components/modals/modalComponent.vue";
import { notifications } from "../../notifications/notifications.js";
export default {
  components: {
    modalComponent,
  },
  props: {
    disable: {
      type: String,
    },
    idStock: {
      type: String,
      default: "kt_table_users",
    },
    initialValue: 0,
  },
  setup(props) {
    const { products, getProducts, storeProducts } = useProducts();
    const { stockServices, getStock, storeStock } = useStock();
    const { swal } = notifications();
    const search = ref("");
    watch(props.initialValue, async (data, data2) => {
      await getStock();
      // Effectuez les actions souhaitées lorsque la propriété props.tags change
    });
    onMounted(async () => {
      await callBackMounted();
    });
    const filteredStockServices = computed(() => {
      if (!search.value) {
        return stockServices.value;
      }
      return stockServices.value.filter(
        (product) => product.service.name.includes(search.value)
        //   product.service.codebar.includes(search.value) ||
        //   product.service.code_manuel.includes(search.value) ||
        //   product.service.uom_id.includes(search.value) ||
        //   product.service.id.includes(search.value)
      );
    });
    async function callBackMounted() {
      props.idStock = "kt_table_users";
      await getStock();
      $("#SelectClick").on("change", handleSelectChange);
    }
    const handleSelectChange = (event) => {
      if (event.target.value == "resetFilter") {
        $("#resetFilter").trigger("click");
      } else {
        $("#filterValue").trigger("click");
      }
    };
    const alertBtn = () => {
      swal(
        "question",
        "Question",
        "Veuillez choisir le type mouvement",
        "Approvisionnement",
        "Destockage",
        () => {
          stockModal();
          form.type = "entry";
          $("#SelectClickType").val(form.type).trigger("change");
        },
        () => {
          stockModal();
          form.type = "withdraw";
          $("#SelectClickType").val(form.type).trigger("change");
        },
        "",
        "btn-danger"
      );
    };
    const stockModal = () => {
      $("#stock-modal").modal("show");
    };
    return {
      alertBtn,
      getProducts,
      products,
      stockModal,
      stockServices,
      search,
      filteredStockServices,
    };
  },
};
</script>

