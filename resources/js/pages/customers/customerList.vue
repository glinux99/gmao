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
                Liste des clients
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
                      placeholder="chercher un client"
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
                          <label class="form-label fs-6 fw-semibold"
                            >Role</label
                          >
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner un role"
                            data-allow-clear="true"
                            data-kt-user-table-filter="role"
                            data-hide-search="true"
                          >
                            <option></option>
                            <!-- <template v-for="role in roles" :key="role.id">
                                <option value="{{role.name}}">
                                  {{ role.name }}
                                </option>
                              </template> -->
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
                      @click="addModal"
                    >
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un client
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
                      @click="alertBtn"
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
                                name="role"
                                data-control="select2"
                                data-placeholder="Select a role"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              >
                                <option></option>

                                <!-- <template v-for="role in roles" :key="role.id">
                                    <option value="{{role.name}}">
                                      {{ role.name }}
                                    </option>
                                  </template> -->
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
                      class="text-center text-muted fw-bold fs-7 text-uppercase gs-0"
                    >
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
                      <th class="min-w-125px" @click="reload">Noms</th>
                      <th class="min-w-125px">Telephone / Email</th>
                      <th class="min-w-50px">Type</th>
                      <th class="min-w-125px">Employer</th>

                      <th class="min-w-100px">POS</th>

                      <th class="text-end min-w-100px">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-600 fw-semibold">
                    <!-- <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr> -->

                    <template v-for="customer in customers" :key="customer.id">
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
                          <div
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="#">
                              <div
                                class="symbol-label fs-3 bg-light-danger text-danger"
                              >
                                {{ customer.customerName[0] }}
                              </div>
                            </a>
                          </div>

                          <div class="d-flex flex-column">
                            <span class="text-gray-800 text-hover-primary mb-1">
                              {{ customer.customerName }}
                            </span>
                          </div>
                        </td>
                        <td>
                          <span>
                            {{ customer.mail }} <br />
                            {{ customer.phone }}
                          </span>
                        </td>
                        <td>
                          <div class="badge badge-light">
                            {{ customer.type }}
                          </div>
                        </td>
                        <td>
                          {{ customer.employer_name }}
                        </td>
                        <td>
                          {{ customer.pos_name }}
                        </td>

                        <td class="text-end">
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                            @click="editModal(customer)"
                          >
                            <i class="ki-duotone ki-pencil fs-3"
                              ><span class="path1"></span
                              ><span class="path2"></span
                              ><span class="path3"></span
                              ><span class="path4"></span
                              ><span class="path5"></span
                            ></i>
                          </button>
                          <button
                            @click="alertBtn(customer)"
                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                          >
                            <i class="ki-duotone ki-trash fs-3"
                              ><span class="path1"></span
                              ><span class="path2"></span
                              ><span class="path3"></span
                              ><span class="path4"></span
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
      id="customer-modal"
      :positionModal="`center mw-650px`"
      :form="form"
      :isCss="true"
      @instance-modal="createCustomer"
    >
      <template #title>
        {{
          editing == true
            ? `Modification du ${form.customerName}`
            : "Ajout d'un client"
        }}
      </template>
      <template #body>
        <div class="mx-5 mt-5">
          <div class="row">
            <div class="mb-2 fv-row col-md-6">
              <label class="required form-label">Nom du client</label>

              <input
                type="text"
                v-model="form.customerName"
                class="form-control mb-2"
                placeholder=""
              />
            </div>
            <div class="mb-2 col-md-6 fv-row">
              <label class="required form-label">Type de client</label>

              <div class="">
                <select
                  id="selectType"
                  class="form-select form-select-solid fw-bold"
                  data-placeholder="Selectionner un type"
                  data-hide-search="true"
                  data-control="select2"
                  data-dropdown-css-class="w-230px"
                >
                  <option></option>
                  <option value="physique" selected>Physique</option>
                  <option value="morale">Morale</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-2 col-md-6 fv-row">
              <label class="required form-label">Sexe</label>

              <div class="">
                <select
                  id="selectSexe"
                  class="form-select form-select-solid fw-bold"
                  data-placeholder="Selectionner un status"
                  data-hide-search="true"
                  data-control="select2"
                  data-dropdown-css-class="w-230px"
                >
                  <option></option>
                  <option value="masculin">Masculin</option>
                  <option value="feminin">Feminin</option>
                </select>
              </div>
            </div>
            <div class="mb-2 col-md-6 fv-row">
              <label class="required form-label">Statut matrimoniale</label>

              <div class="">
                <select
                  id="selectStatus"
                  class="form-select form-select-solid fw-bold"
                  data-placeholder="Selectionner un type"
                  data-hide-search="true"
                  data-control="select2"
                  data-dropdown-css-class="w-230px"
                >
                  <option></option>
                  <option value="celibataire">Celibataire</option>
                  <option value="marie">Marie</option>
                  <option value="veuf">Veuf(ve)</option>
                  <option value="divorce">Divorce</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-2 col-md-6 fv-row pt-5">
              <label class="required form-label">Telephone</label>

              <input
                type="text"
                v-model="form.phone"
                class="form-control mb-2"
                placeholder=""
              />
            </div>
            <div class="mb-2 col-md-6 fv-row pt-5">
              <label class="required form-label">Email</label>

              <input
                type="text"
                v-model="form.mail"
                class="form-control mb-2"
                placeholder=""
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-2 col-md-6 fv-row pt-5">
              <label class="required form-label">Employer</label>

              <input
                type="text"
                v-model="form.employer"
                class="form-control mb-2"
                placeholder=""
              />
            </div>
            <div class="mb-2 col-md-6 fv-row pt-5">
              <label class="required form-label">Autre contact</label>

              <input
                type="text"
                v-model="form.other_contact"
                class="form-control mb-2"
                placeholder=""
              />
            </div>
          </div>
          <div class="mb-2 fv-row">
            <label class="required form-label">Adresse</label>

            <textarea
              v-model="form.adress"
              id=""
              cols="20"
              rows="2"
              class="form-control"
            ></textarea>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import useCustomer from "../../services/customerservices.js";
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
    const { customers, getCustomers, storeCustomer, removeCustomer } =
      useCustomer();

    const form = reactive({
      id: null,
      pos_id: null,
      created_by_id: null,
      category_id: null,
      customerName: null,
      marital_status: null,
      other_contact: null,
      adress: null,
      phone: null,
      mail: null,
      employer: null,
      type: "physique",
      sex: null,
      enterprise_id: null,
    });
    onMounted(async () => {
      await callBackMounted();
    });
    const alertBtn = (name = null) => {
      swal(
        "question",
        "Question",
        name == null
          ? "Voulez-vous supprimer la liste des ces utilisateurs selectionnés"
          : `Voulez-vous supprimer l'utilisateur "${name.customerName}"?`,
        "Oui, d'accord",
        "annuller",
        () => {},
        () => {},
        "",
        "btn-dark"
      );
    };
    const handleStatus = (event) => {
      form.marital_status = event.target.value;
    };
    const handleSexe = (event) => {
      form.sex = event.target.value;
    };
    const handleType = (event) => {
      form.type = event.target.value;
    };
    const { dataCreated, swal } = notifications();
    async function callBackMounted() {
      await getCustomers();
      $("#selectStatus").on("change", handleStatus);
      $("#selectSexe").on("change", handleSexe);
      $("#selectType").on("change", handleType);
    }

    const createCustomer = async () => {
      console.log({ ...form });
      console.log("###########");
      await storeCustomer({ ...form });
      await getCustomers();
      //   dataCreated();
      editing.value = false;
    };
    const deleteCustomer = async (customerId) => {
      await removeCustomer(customerId);
      await getCustomers();
    };

    const editing = ref(false);
    const editModal = (value) => {
      editing.value = true;
      $("#selectType").val(value.type).trigger("change");
      $("#selectStatus").val(value.marital_status).trigger("change");
      $("#selectSexe").val(value.sex).trigger("change");
      $("#customer-modal").modal("show");
      for (const [key, val] of Object.entries(value)) {
        form[key] = val;
      }
    };
    const addModal = () => {
      $("#selectType").val("physique").trigger("change");
      for (const [key, value] of Object.entries(form)) {
        form[key] =
          typeof value == "string" ? "" : typeof value == "number" ? 0 : "";
      }
      form.type = "physique";
      $("#customer-modal").modal("show");
    };
    const viewModal = (store) => {
      //   const storeCookie = useCookie("store");
      //   storeCookie.setCookie(store.id);
      //   location.href = "/admin/store";
    };
    return {
      form,
      alertBtn,
      addModal,
      viewModal,
      editModal,
      customers,
      deleteCustomer,
      createCustomer,
    };
  },
};
</script>
