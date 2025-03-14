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
                Liste de prix de services
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
                      placeholder="Rechercher un prix"
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
                          <label class="form-label fs-6 fw-semibold">Service</label>
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner un service"
                            data-allow-clear="true"
                            data-kt-user-table-filter="depot"
                            data-hide-search="true"
                          >
                            <option></option>
                            <option value="depot">depot</option>
                          </select>
                        </div>
                        <div class="mb-10">
                          <label class="form-label fs-6 fw-semibold">Entreprise</label>
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner une entreprise"
                            data-allow-clear="true"
                            data-kt-user-table-filter="entreprise"
                            data-hide-search="true"
                          >
                            <option></option>
                            <option value="ddd">cfff</option>
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
                      data-bs-target="#info-modal"
                    >
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un prix
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
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </div>
                        </div>

                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                          <form id="kt_modal_export_users_form" class="form" action="#">
                            <div class="fv-row mb-10">
                              <label class="fs-6 fw-semibold form-label mb-2"
                                >Selectionner un role:</label
                              >

                              <select
                                name="entreprise"
                                data-control="select2"
                                data-placeholder="Selectionner une entreprise"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              >
                                <option></option>
                                <option value="ddd">fffff</option>
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
                      <th class="min-w-125px">Label</th>
                      <th class="min-w-125px">Price</th>
                      <th class="min-w-125px">Monnais</th>
                      <th class="min-w-125px">Status</th>
                      <th class="min-w-125px">services</th>

                      <th class="text-end min-w-100px">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-600 fw-semibold">
                    <tr>
                      <!-- <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td> -->
                    </tr>
                    <template v-for="mesure in priceCategorie" :key="mesure.id">
                      <tr>
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input class="form-check-input" type="checkbox" value="1" />
                          </div>
                        </td>

                        <td>
                          <div
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="#">
                              <div class="symbol-label fs-3 bg-light-danger text-danger">
                                {{ mesure.price }}
                              </div>
                            </a>
                          </div>
                        </td>
                        <td>{{ mesure.label }}</td>
                        <td>{{ mesure.label }}</td>
                        <td></td>
                        <td>{{ convertDate(mesure.created_at) }}</td>
                        <td class="text-end">
                          <a
                            href="#"
                            class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end"
                          >
                            Actions
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                          </a>

                          <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true"
                          >
                            <div class="menu-item px-3">
                              <a href="#" class="menu-link px-3">
                                <i class="ki-duotone ki-information-2 fs-3"
                                  ><span class="path1"></span><span class="path2"></span
                                ></i>
                                Infos
                              </a>
                            </div>
                            <div class="menu-item px-3">
                              <a href="#" class="menu-link px-3">
                                <i class="ki-duotone ki-information-2 fs-3"
                                  ><span class="path1"></span><span class="path2"></span
                                ></i>
                                Editer
                              </a>
                            </div>

                            <div class="menu-item px-3">
                              <a
                                href="#"
                                class="menu-link px-3"
                                data-kt-users-table-filter="delete_row"
                              >
                                <i class="ki-duotone ki-trash-square fs-3"
                                  ><span class="path1"></span><span class="path2"></span
                                ></i>
                                Supprimer
                              </a>
                            </div>
                          </div>
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
    <!-- Modal template -->
    <modal-component
      positionModal="center mw-650px"
      :form="form"
      @instance-modal="createUnity"
    >
      <template #title>Création d'un prix</template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div class="card-text">
              <div class="mb-5 fv-row">
                <label class="required form-label">Label de votre prix</label>

                <input
                  type="text"
                  v-model="form.label"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">Configurer le label de votre prix</div>
              </div>
              <div class="mb-5 fv-row">
                <label class="required form-label">Prix</label>

                <input
                  type="number"
                  v-model="form.price"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">(en dollars)</div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <!-- End modal template  -->
  </div>
</template>
<script>
import usePriceCategorie from "../../services/pricescategorieservices.js";

import modalComponent from "../../components/modals/modalComponent.vue";

import { onMounted, onUpdated, reactive, ref } from "vue";
import moment from "moment";
import useHistoryWebServices from "../../services/historyservices.js";

export default {
  components: {
    modalComponent,
  },
  setup() {
    const { getHistory, linkHistory } = useHistoryWebServices();

    const {
      priceCategorie,
      getPriceCategorie,
      storePriceCategorie,
    } = usePriceCategorie();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getPriceCategorie();
      getHistory();
    }
    const createUnity = async (data) => {
      await storePriceCategorie(data);

      await getPriceCategorie();
    };
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY à HH:mm:ss");
    };
    return {
      getPriceCategorie,
      priceCategorie,
      createUnity,
      convertDate,
    };
  },
  data() {
    return {
      form: {
        label: "",
        price: "",
        enterprise_id: 1,
      },
    };
  },
};
</script>
