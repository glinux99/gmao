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
                Valorisation du stock
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
                    <div class="px-7 py-5" data-kt-user-table-filter="form">
                      <div class="d-flex flex-stack flex-wrap gap-4">
                        <div class="d-flex align-items-center fw-bold">
                          <div class="text-muted fs-7 me-2">
                            Type d'entree/Sortie
                          </div>

                          <select
                            class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                            data-control="select2"
                            data-hide-search="true"
                            data-dropdown-css-class="w-150px"
                            data-placeholder="Selectionner une option"
                            @click="submitForm"
                            @input="submitForm"
                            @change="submitForm"
                          >
                            <option></option>
                            <option value="entry">Approvisionnement</option>
                            <option value="withdraw" @select="submitForm">
                              Destockage
                            </option>
                          </select>
                        </div>

                        <a href="#" class="btn btn-light btn-sm"
                          >Voir le stock</a
                        >
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
                      class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                    >
                      <th class="min-w-150px">Item</th>
                      <th class="text-end pe-3 min-w-100px">Product ID</th>
                      <th class="text-end pe-3 min-w-150px">Date d'exp</th>
                      <th class="text-end pe-3 min-w-100px">Type d'entree</th>
                      <th class="text-end pe-3 min-w-100px">Motif</th>
                      <th class="text-end pe-3 min-w-100px">Entreprise</th>
                      <th class="text-end pe-0 min-w-75px">Qte</th>
                      <th class="text-end pe-0 min-w-75px">Qte before</th>
                    </tr>
                  </thead>
                  <tbody class="fw-bold text-gray-600">
                    <template
                      v-for="product in stockServices"
                      :key="product.id"
                    >
                      <tr>
                        <td>
                          <span class="text-dark text-hover-primary">{{
                            product.service.name
                          }}</span>
                        </td>

                        <td class="text-end">
                          {{
                            product.service.codebar ||
                            product.service.code_manuel ||
                            product.service.uom_id ||
                            product.service.id
                          }}
                        </td>

                        <td class="text-end">
                          {{ product.expiration_date || "jamais" }}
                        </td>

                        <td class="text-end">
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

                        <td class="text-end">
                          {{ product.motif }}
                        </td>
                        <td class="text-end">
                          {{ product.enterprise.name }}
                        </td>

                        <td class="text-end" data-order="58">
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
                        <td class="text-end" data-order="58">
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
    </div>
  </div>
</template>
<script>
import { onMounted } from "vue";
import useProducts from "../../services/productservices.js";
import useStock from "../../services/stockservices.js";
export default {
  setup() {
    const { products, getProducts, storeProducts } = useProducts();
    const { stockServices, getStock, storeStock } = useStock();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getStock();
    }
    const submitForm = (event) => {};

    return {
      submitForm,
      getProducts,
      products,
      stockServices,
    };
  },
};
</script>
