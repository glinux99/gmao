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
                Destockage
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
                      <div class="d-flex align-items-center fw-bold d-none">
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
                      <th :class="`text-end pe-3 min-w-100px ${disable}`">
                        Motif
                      </th>
                      <th :class="`text-end pe-3 min-w-100px ${disable}`">
                        Entreprise
                      </th>
                      <th :class="`text-end pe-0 min-w-75px ${disable}`">
                        Qte before
                      </th>
                      <th :class="`text-end pe-0 min-w-75px ${disable} `">
                        Qte
                      </th>
                    </tr>
                  </thead>

                  <tbody class="fw-bold text-gray-600">
                    <template
                      v-for="product in stockServices"
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
                            {{ product.quantity_before || 0 }}
                          </span>
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
      positionModal="center mw-900px"
      :form="form"
      :id="'stock-modal'"
      activeBtn="false"
      @cancel-btn="cancelBtn"
    >
      <template #title>Création d'une unite de mesure</template>
      <template #body>
        <form
          method="POST"
          @submit.prevent="updateServiceStock(form.service_id, form.depot_id)"
        >
          <div
            class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
            id="stepper_super_admin"
          >
            <div
              class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px"
            >
              <div class="stepper-nav ps-lg-10">
                <div class="stepper-item current" data-kt-stepper-element="nav">
                  <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                      <i class="ki-duotone ki-check stepper-check fs-2"></i>
                      <span class="stepper-number">1</span>
                    </div>

                    <div class="stepper-label">
                      <h3 class="stepper-title">Service</h3>

                      <div class="stepper-desc">rechercher le service</div>
                    </div>
                  </div>

                  <div class="stepper-line h-40px"></div>
                </div>

                <div
                  class="stepper-item mark-completed"
                  data-kt-stepper-element="nav"
                >
                  <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                      <i class="ki-duotone ki-check stepper-check fs-2"></i>
                      <span class="stepper-number">2</span>
                    </div>

                    <div class="stepper-label">
                      <h3 class="stepper-title">Mouvement</h3>

                      <div class="stepper-desc">Donnees du mouvement</div>
                    </div>
                  </div>

                  <div class="stepper-line h-40px"></div>
                </div>

                <div class="stepper-item" data-kt-stepper-element="nav">
                  <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                      <i class="ki-duotone ki-check stepper-check fs-2"></i>
                      <span class="stepper-number">3</span>
                    </div>

                    <div class="stepper-label">
                      <h3 class="stepper-title">Complet</h3>

                      <div class="stepper-desc">Donnee envoyer</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex-row-fluid py-lg-5 px-lg-15">
              <form
                class="form"
                novalidate="novalidate"
                id="kt_modal_create_app_form"
              >
                <div class="current" data-kt-stepper-element="content">
                  <div class="w-100">
                    <div class="card">
                      <div
                        class="d-flex align-items-center position-relative my-1"
                      >
                        <i
                          class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                          ><span class="path1"></span><span class="path2"></span
                        ></i>
                        <input
                          type="text"
                          v-model="search"
                          :class="`ps-13 form-control form-control-lg form-control-solid`"
                          :placeholder="`chercher dans les ${servicesDeposit.length} depots `"
                        />
                      </div>
                      <div :class="`card-toolbar d-none `">
                        <div
                          class="d-flex flex-stack flex-wrap gap-4"
                          data-kt-user-table-toolbar="base"
                        >
                          <div
                            data-kt-user-table-filter="form"
                            :class="`${disable}`"
                          >
                            <div class="d-flex align-items-center fw-bold">
                              <div class="text-muted fs-7 me-2">Filter</div>
                              <select
                                id="SelectClickx"
                                class="form-select form-select-solid fw-bold"
                                data-kt-select2="true"
                                data-placeholder="type de mouvement"
                                data-allow-clear="true"
                                data-dropdown-css-class="w-230px"
                                data-kt-user-table-filter="entreprise"
                                data-hide-search="true"
                              >
                                <option></option>
                                <option value="resetFilter">
                                  afficher tout
                                </option>
                                <option value="entry">
                                  Approvissionnement
                                </option>
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
                          <div
                            class="modal-dialog modal-dialog-centered mw-650px"
                          >
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
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="card-body py-4 p-0 m-0">
                        <table
                          class="table align-middle table-row-dashed fs-6 gy-5"
                          id="kt_table_usersxxx"
                        >
                          <thead>
                            <tr
                              class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                            >
                              <th class="min-w-180px">Item</th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                            </tr>
                          </thead>

                          <tbody class="fw-bold text-gray-600">
                            <template
                              v-for="service in filteredServicesDeposit"
                              :key="service.id"
                            >
                              <tr class="w-100">
                                <td class="">
                                  <label
                                    class="d-flex flex-stack mb-5 cursor-pointer"
                                  >
                                    <span
                                      class="d-flex align-items-center me-2"
                                    >
                                      <span class="symbol symbol-50px me-6">
                                        <span
                                          class="symbol-label bg-light-primary"
                                        >
                                          <i
                                            class="ki-duotone ki-compass fs-1 text-primary"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                          ></i>
                                        </span>
                                      </span>

                                      <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">{{
                                          service.service.name
                                        }}</span>

                                        <span class="fs-7 text-muted">{{
                                          service.store.name
                                        }}</span>
                                      </span>
                                    </span>

                                    <span
                                      class="form-check form-check-custom form-check-solid"
                                    >
                                      <input
                                        @change="
                                          checkedValue(
                                            service.service,
                                            service.store
                                          )
                                        "
                                        class="form-check-input"
                                        type="radio"
                                        name="checkedProducr"
                                        value="1"
                                      />
                                    </span>
                                  </label>
                                </td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>

                                <td class="d-none"></td>
                                <td class="d-none"></td>

                                <td class="d-none"></td>
                              </tr>
                            </template>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div data-kt-stepper-element="content">
                  <div class="w-100">
                    <div class="fv-row">
                      <label
                        class="d-flex align-items-center fs-5 fw-semibold mb-4"
                      >
                        <span class="required">Mouvement</span>

                        <span
                          class="ms-1"
                          data-bs-toggle="tooltip"
                          title="Entrer les donnees lie a votre mouvement"
                        >
                          <i
                            class="ki-duotone ki-information-5 text-gray-500 fs-6"
                            ><span class="path1"></span
                            ><span class="path2"></span
                            ><span class="path3"></span></i
                        ></span>
                      </label>

                      <label class="d-flex flex-stack mb-5 cursor-pointer">
                        <span class="d-flex align-items-center me-2">
                          <span class="symbol symbol-50px me-6">
                            <span class="symbol-label bg-light-primary">
                              <i class="ki-duotone ki-compass fs-1 text-primary"
                                ><span class="path1"></span
                                ><span class="path2"></span
                              ></i>
                            </span>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">{{
                              form.service.name
                            }}</span>

                            <span class="fs-7 text-muted">{{ storeName }}</span>
                          </span>
                        </span>

                        <span
                          class="form-check form-check-custom form-check-solid"
                        >
                          <input
                            class="form-check-input"
                            type="radio"
                            name="checkedProd"
                            checked
                          />
                        </span>
                      </label>

                      <div class="card mb-10">
                        <div class="row">
                          <div class="col-7">
                            <div class="mb-5 fv-row">
                              <label class="required form-label"
                                >Valeur (courant : {{ minValue }})</label
                              >

                              <input
                                id="inputFocuses"
                                type="number"
                                class="form-control mb-2"
                                placeholder=""
                                v-model="form.quantity"
                                min="0"
                                required
                              />

                              <div class="text-muted fs-7">
                                (valeur ajouter au stock)
                              </div>
                            </div>
                          </div>
                          <div class="col-5">
                            <div class="mb-5 fv-row">
                              <label class="required form-label"
                                >Type de mouvement</label
                              >

                              <div class="">
                                <select
                                  id="SelectClickType"
                                  class="form-select form-select-solid fw-bold"
                                  data-placeholder="Selectionner un type"
                                  data-hide-search="true"
                                  data-control="select2"
                                  data-dropdown-css-class="w-230px"
                                >
                                  <option></option>
                                  <option
                                    data-subtext="entry"
                                    value="entry"
                                    :selected="
                                      form.type === 'entry' ? true : false
                                    "
                                  >
                                    Approvisionnement
                                  </option>
                                  <option
                                    data-subtext="withdraw"
                                    value="withdraw"
                                    :selected="
                                      form.type === 'withdraw' ? true : false
                                    "
                                  >
                                    Destockage
                                  </option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div data-kt-stepper-element="content">
                  <div class="w-100 text-center">
                    <h1 class="fw-bold text-dark mb-3">Release!</h1>

                    <div class="text-muted fw-semibold fs-3">
                      Submit your app to kickstart your project.
                    </div>

                    <div class="text-center px-4 py-15">
                      <img
                        src="assets/media/illustrations/sketchy-1/9.png"
                        alt=""
                        class="mw-100 mh-300px"
                      />
                    </div>
                  </div>
                </div>

                <div class="d-flex flex-stack">
                  <div class="me-2">
                    <button
                      type="button"
                      class="btn btn-lg btn-light-primary me-3"
                      id="backStepper"
                      @click="backStepper"
                    >
                      <i class="ki-duotone ki-arrow-left fs-3 me-1"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Back
                    </button>
                  </div>

                  <div>
                    <button
                      @click="updateServiceStock(form.service, form.depot_id)"
                      type="button"
                      class="btn btn-lg btn-primary d-none"
                      id="submit"
                    >
                      <span class="indicator-label" v-if="!isLoaging">
                        Envoyer
                        <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0"
                          ><span class="path1"></span><span class="path2"></span
                        ></i>
                      </span>
                      <span v-else>
                        Veuillez patienter svp
                        <span
                          class="spinner-border spinner-border-sm align-middle ms-2"
                        ></span>
                      </span>
                    </button>

                    <button
                      type="button"
                      @click="nextStepper"
                      id="nextStepper"
                      class="btn btn-lg btn-primary"
                      data-kt-stepper-action="next"
                    >
                      Continue
                      <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </form>
      </template>
    </modal-component>
  </div>
</template>
<script>
import stockTableComponent from "./stockTableComponent.vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import { notifications } from "../../notifications/notifications";
import { computed, onMounted, reactive, ref, watch } from "vue";
import useProducts from "../../services/productservices";
import useDeposit from "../../services/depositservices";
import useStock from "../../services/stockservices";
import { min } from "moment";

export default {
  components: {
    stockTableComponent,
    modalComponent,
  },
  setup(props, { emit }) {
    const { servicesDeposit, getServicesDeposit } = useDeposit();

    const { products, getProducts, storeProducts } = useProducts();
    const { swal } = notifications();
    const stepperIndex = ref(0);

    const { stockServices, getStock, storeStock } = useStock();

    const stockModal = () => {
      StepperGoTo(1);
      $("#stock-modal").modal("show");
      stepperIndex.value = 1;
    };
    onMounted(async () => {
      await callBackMounted();
    });
    const handleSelectChangeType = (event) => {
      form.type = event.target.value;
    };
    const handleSelectChange = (event) => {
      if (event.target.value == "resetFilter") {
        $("#resetFilter").trigger("click");
      } else {
        $("#filterValue").trigger("click");
      }
    };
    async function callBackMounted() {
      await getStock();
      $("#SelectClick").on("change", handleSelectChange);
      await getServicesDeposit();
      $("#SelectClickType").on("change", handleSelectChangeType);
      stockServices.value = stockServices.value.filter(
        (store) => store.type == "withdraw"
      );
      services.value = servicesDeposit.value.flatMap((store) => {
        return store.services.map((service) => {
          return {
            service: service,
            store: {
              id: store.id,
              name: store.name,
            },
          };
        });
      });
    }

    const filteredproducts = computed(() => {
      if (!search.value) {
        return servicesDeposit.value;
      }
      const filteredStores = servicesDeposit.value.filter((store) => {
        return (
          store.name.includes(search.value) ||
          store.services.some((service) => service.name.includes(search.value))
        );
      });
      const sortedStores = filteredStores.sort((a, b) => {
        const aOccurrences = countOccurrences(a, search.value);
        const bOccurrences = countOccurrences(b, search.value);
        return bOccurrences - aOccurrences;
      });
      return sortedStores;
    });
    function countOccurrences(item, searchValue) {
      let count = 0;
      count += (item.name.match(new RegExp(searchValue, "gi")) || []).length;
      item.services.forEach((service) => {
        count += (service.name.match(new RegExp(searchValue, "gi")) || [])
          .length;
      });
      return count;
    }
    const cancelValue = ref(false);
    const cancelBtn = () => {
      StepperGoTo(1);
      cancelValue.value = true;
      initialValue.value.splice(0, initialValue.value.length);
    };
    const backStepper = () => {
      stepperIndex.value -= 1;

      const backStepperElement = document.querySelector("#backStepper");
      const nextStepperElement = document.querySelector("#nextStepper");
      const submitElement = document.querySelector("#submit");
      submitElement.classList.add("d-none");

      if (stepperIndex.value <= 1) {
        stepperIndex.value = 1;
      }
      StepperGoTo(stepperIndex.value);
    };

    const form = reactive({
      name: "",
      service: {},
      service_id: null,
      depot_id: null,
      quantity: 0,
      type: "entry",
      type_approvement: "cash",
    });
    const minValue = ref(0);
    const storeName = ref("");
    const checkedValue = (service, store) => {
      form.service_id = service.id;
      form.service = service;
      storeName.value = store.name;
      form.depot_id = store.id;
      minValue.value = service.available_qte;
      $("#nextStepper").click();
      document.querySelector("#nextStepper").classList.add("d-none");
      document.querySelector("#submit").classList.remove("d-none");
    };
    let isLoaging = ref(false);
    const updateServiceStock = async (service, deposit_id) => {
      isLoaging.value = true;
      form.name = service.name;
      form.service_id = service.service_id;
      form.type_approvement = "cash";
      await storeStock({ ...form });
      await getStock();
      await getServicesDeposit();
      $(".closeBtn").trigger("click");
      emit("callback");
      isLoaging.value = false;
      services.value = servicesDeposit.value.flatMap((store) => {
        return store.services.map((service) => {
          return {
            service: service,
            store: {
              id: store.id,
              name: store.name,
            },
          };
        });
      });
      stockServices.value = stockServices.value.filter(
        (store) => store.type == "withdraw"
      );
    };
    const CloseModal = async () => {
      initialValue.value;

      new bootstrap.Modal(element).hide();
      $("#submit").trigger("click");
    };

    // filtre de services with Search v-model
    const search = ref("");
    const filteredServicesDeposit = computed(() => {
      if (!search.value) {
        return services.value;
      }
      const result = services.value.filter(
        (store) =>
          store.service.name
            .toLowerCase()
            .includes(search.value.toLowerCase()) ||
          store.store.name.toLowerCase().includes(search.value.toLowerCase())
      );
      result.sort((a, b) => a.service.name.localeCompare(b.service.name));

      return result;
    });
    watch(services, () => {
      filteredServicesDeposit.value; // Cette ligne est utilisée uniquement pour déclencher la mise à jour réactive
    });
    const services = ref([]);
    const initialValue = ref([]);

    const alertBtn = () => {
      stockModal();
      form.type = "withdraw";
      $("#SelectClickType").val(form.type).trigger("change");
    };

    return {
      initialValue,
      CloseModal,
      services,
      updateServiceStock,
      backStepper,
      storeName,
      minValue,
      form,
      search,
      alertBtn,
      filteredServicesDeposit,
      checkedValue,
      isLoaging,
      cancelBtn,
      stockServices,
      products,
      servicesDeposit,
      filteredproducts,
    };
  },
};
</script>
