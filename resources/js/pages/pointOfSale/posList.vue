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
                Liste des points de ventes
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
                      placeholder="chercher un point de vente"
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
                      class="btn btn-light-primary me-3 d-none"
                      data-kt-menu-trigger="click"
                      data-kt-menu-placement="bottom-end"
                    >
                      <i class="ki-duotone ki-filter fs-2"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Filtre
                    </button>

                    <div
                      class="d-none menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                      data-kt-menu="true"
                    >
                      <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                      </div>

                      <div class="separator border-gray-200"></div>

                      <div class="px-7 py-5" data-kt-user-table-filter="form">
                        <div class="mb-10">
                          <label class="form-label fs-6 fw-semibold">Role</label>
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner un role"
                            data-allow-clear="true"
                            data-kt-user-table-filter="role"
                            data-hide-search="true"
                          ></select>
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

                    <button type="button" class="btn btn-primary" @click="addModal">
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un pos
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
                                >Select Role:</label
                              >

                              <select
                                name="role"
                                data-control="select2"
                                data-placeholder="Select a role"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              ></select>
                            </div>

                            <div class="fv-row mb-10">
                              <label class="required fs-6 fw-semibold form-label mb-2"
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
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                      <th class="w-10px pe-2">
                        <div
                          class="form-check form-check-sm form-check-custom form-check-solid me-3"
                        >
                          <input
                            class="form-check-input"
                            type="checkbox"
                            data-kt-check="true"
                            data-kt-check-target="#kt_stores .form-check-input"
                            value="1"
                          />
                        </div>
                      </th>
                      <th class="min-w-125px" @click="reload">Nom</th>
                      <th class="min-w-125px">Identification</th>
                      <th class="min-w-125px">Type</th>
                      <th class="min-w-125px">Solde</th>

                      <th class="min-w-125px">status</th>

                      <th class="text-end min-w-100px">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-600 fw-semibold">
                    <template v-for="deposit in pointOfSales" :key="deposit.id">
                      <tr>
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input class="form-check-input" type="checkbox" value="1" />
                          </div>
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ deposit.name }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ deposit.uuid }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ deposit.type }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ deposit.sold }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          <div class="badge badge-light fw-bold position-relative">
                            <span
                              :class="`bullet bullet-dot ${
                                deposit.status == 'disabled' ? 'bg-danger' : 'bg-success'
                              } h-6px w-6px position-absolute translate-middle top-0 start-100 animation-blink`"
                            >
                            </span>
                            {{ deposit.status == "disabled" ? "Desactiver" : "Active" }}
                          </div>
                        </td>

                        <td class="text-end">
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                            @click="editModal(deposit)"
                          >
                            <i class="ki-duotone ki-pencil fs-3"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                              ><span class="path5"></span
                            ></i>
                          </button>
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                            @click="alertBtn(deposit.name)"
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
    </div>
    <modal-component
      id="store-modal"
      :positionModal="`center mw-800px`"
      :form="form"
      :isCss="true"
      @instance-modal="createPointOfSale"
    >
      <template #title>
        {{
          editing == true
            ? `Modification du ${form.name}`
            : "Création d'un point de vente"
        }}
      </template>
      <template #body>
        <div class="mx-5">
          <div class="row">
            <div class="col-md-6 d-flex flex-column">
              <label class="required form-label">Status</label>
              <div
                class="btn-group w-100 w-lg-50"
                data-kt-buttons="true"
                data-kt-buttons-target="[data-kt-button]"
              >
                <label
                  id="status_active"
                  class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                  data-kt-button="true"
                >
                  <input
                    @click="switchCheck($event, 'status')"
                    class="btn-check"
                    type="radio"
                    v-model="form.status"
                    value="enabled"
                    checked
                  />

                  Active
                </label>

                <label
                  class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                  data-kt-button="true"
                >
                  <input
                    @click="switchCheck($event, 'status')"
                    class="btn-check"
                    type="radio"
                    v-model="form.status"
                    value="disabled"
                  />

                  Desactive
                </label>
              </div>
            </div>
            <div class="col-md-6 d-flex flex-column">
              <label class="required form-label">Type</label>
              <div
                class="btn-group w-100 w-lg-50"
                data-kt-buttons="true"
                data-kt-buttons-target="[data-kt-button]"
              >
                <label
                  id="type_bonus"
                  class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                  data-kt-button="true"
                >
                  <input
                    @click="switchCheck($event, 'type')"
                    class="btn-check"
                    type="radio"
                    v-model="form.type"
                    value="bonus"
                    checked="checked"
                  />

                  Bonus
                </label>

                <label
                  class="btn btn-outline-secondary text-muted text-hover-white text-active-primary btn-outline btn-active-success"
                  data-kt-button="true"
                >
                  <input
                    @click="switchCheck($event, 'type')"
                    class="btn-check"
                    type="radio"
                    v-model="form.type"
                    value="point"
                  />

                  Point
                </label>
              </div>
            </div>
          </div>

          <div class="my-5 fs-3 fw-bold text-gray-800 me-2 lh-1 ls-n2">
            Informations de base
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Nom de votre pos</label>

                <input
                  type="text"
                  v-model="form.name"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">Configurer le nom de ce dépôt</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Description</label>

                <input
                  type="text"
                  v-model="form.description"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Contact</label>

                <input
                  type="number"
                  v-model="form.phone"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Email</label>

                <input
                  type="email"
                  v-model="form.mail"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Adresse</label>

                <input
                  type="text"
                  v-model="form.adresse"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">RCCM</label>

                <input
                  type="text"
                  v-model="form.rccm"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">ID</label>

                <input
                  type="text"
                  v-model="form.national_identification"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Num Impot</label>

                <input
                  type="text"
                  v-model="form.num_impot"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Autorisation de fonctionnement</label>

                <input
                  type="text"
                  v-model="form.autorisation_fct"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Site du site</label>

                <input
                  type="text"
                  v-model="form.website"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>

            <div class="col-md-4">
              <div class="fv-row">
                <label class="required form-label">TVA (%)</label>

                <input
                  type="text"
                  v-model="form.vat_rate"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>

            <div class="col-md-4">
              <div class="fv-row">
                <label class="required form-label"
                  >N. d'achat pour beneficier de bonus</label
                >

                <input
                  type="text"
                  v-model="form.nb_sales_bonus"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-4">
              <div class="fv-row">
                <label class="required form-label">% mains d'oeuvres</label>

                <input
                  type="text"
                  v-model="form.workforce_percent"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col-md-12">
              <div class="fv-row">
                <label class="required form-label"
                  >Note de pied de page sur la facture</label
                >

                <input
                  type="text"
                  v-model="form.note"
                  class="form-control mb-2"
                  placeholder=""
                />
              </div>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import usePointOfSale from "../../services/posservices.js";
import { onMounted, reactive, ref, watch } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import categoryAdd from "../categories/categoryAdd.vue";
import moment from "moment";
import test from "../categories/categorieSave.js";
import { notifications } from "../../notifications/notifications.js";
import useCategories from "../../services/categorieservices.js";
import { useCookie } from "@vue-composable/cookie";
export default {
  components: {
    modalComponent,
    // categoryAdd,
  },
  setup(props, { emit }) {
    const { getPointOfSales, storePointOfSales, pointOfSales } = usePointOfSale();

    let form = reactive({
      id: null,
      user_id: "",
      name: "",
      description: "",
      type: "bonus",
      sold: 0,
      nb_sales_bonus: "",
      bonus_percentage: "",
      workforce_percent: "",
      rccm: "",
      national_identification: "",
      num_impot: "",
      autorisation_fct: "",
      adresse: "",
      phone: "",
      mail: "",
      website: "",
      logo: "",
      category: "",
      vat_rate: "",
      uuid: null,
      status: "enabled",
      enterprise_id: "",
    });
    onMounted(async () => {
      await callBackMounted();
    });
    const alertBtn = (name) => {
      swal(
        "question",
        "Question",
        name == null
          ? "Voulez-vous supprimer la liste de points de ventes selectionné"
          : `Voulez-vous supprimer le point de vente "${name}"?`,
        "Oui, d'accord",
        "annuller",
        () => {},
        () => {},
        "",
        "btn-dark"
      );
    };

    const { dataCreated, swal } = notifications();
    let categoriesDefault = "";
    async function callBackMounted() {
      await getPointOfSales();
    }
    const createPointOfSale = async () => {
      await storePointOfSales({ ...form });
      dataCreated();
      await getPointOfSales();
      editing.value = false;
    };
    const deletePointOfSale = async (depositId) => {
      await getPointOfSales();
    };

    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY à HH:mm:ss");
    };

    const editing = ref(false);
    const editModal = (value) => {
      editing.value = true;
      $("#store-modal").modal("show");
      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
    };
    const instanceModal = (value) => {
      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
      form.id = null;
      createPointOfSale();
    };
    const addModal = () => {
      $("#status_active").click();
      $("#type_bonus").click();

      for (const [key, value] of Object.entries(form)) {
        form[key] = typeof value == "string" ? "" : typeof value == "number" ? 0 : "";
      }
      form.id = null;
      form.type = "bonus";
      form.status = "enabled";
      $("#store-modal").modal("show");
    };
    const viewModal = (store) => {
      const storeCookie = useCookie("pos");
      storeCookie.setCookie(store.id);
      location.href = "/admin/pos";
    };
    const switchCheck = (event, value) => {
      if (value == "type") {
        form.type = event.target.value;
      } else {
        form.status = event.target.value;
      }
    };
    return {
      alertBtn,
      switchCheck,
      createPointOfSale,
      pointOfSales,
      deletePointOfSale,
      convertDate,
      editModal,
      viewModal,
      form,
      addModal,
      editing,
      instanceModal,
    };
  },
  methods: {
    reload() {
      //   $("#kt_stores").DataTable("reload");
      $(document).ready(function () {});
    },
  },
  data() {
    return {};
  },
};
</script>
