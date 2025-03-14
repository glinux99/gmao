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
                Liste des fournisseurs
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
                      placeholder="chercher un fournisseur"
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

                    <button type="button" class="btn btn-primary" @click="addModal">
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un fournisseur
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

                    <button type="button" class="btn btn-danger" @click="alertBtn">
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
                    <tr class="text-center text-muted fw-bold fs-7 text-uppercase gs-0">
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
                      <th class="d-none"></th>

                      <th class="d-none"></th>

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

                    <template v-for="provider in providers" :key="provider.id">
                      <tr class="text-center">
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input class="form-check-input" type="checkbox" value="1" />
                          </div>
                        </td>
                        <td class="d-flex align-items-center justify-content-center">
                          <div
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="#">
                              <div class="symbol-label fs-3 bg-light-danger text-danger">
                                {{ provider.providerName[0] }}
                              </div>
                            </a>
                          </div>

                          <div class="d-flex flex-column">
                            <span class="text-gray-800 text-hover-primary mb-1">
                              {{ provider.providerName }}
                            </span>
                          </div>
                        </td>
                        <td>
                          <span>
                            {{ provider.mail }} <br />
                            {{ provider.phone }}
                          </span>
                        </td>
                        <td>
                          <div class="badge badge-light">
                            {{ provider.type }}
                          </div>
                        </td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>

                        <td class="text-end">
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                            @click="editModal(provider)"
                          >
                            <i class="ki-duotone ki-pencil fs-3"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                              ><span class="path5"></span
                            ></i>
                          </button>
                          <button
                            @click="alertBtn(provider)"
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
    </div>
    <modal-component
      id="provider-modal"
      :positionModal="`center mw-650px`"
      :form="form"
      :isCss="true"
      @instance-modal="createProvider"
    >
      <template #title>
        {{
          editing == true ? `Modification du ${form.providerName}` : "Ajout d'un client"
        }}
      </template>
      <template #body>
        <div class="card">
          <div class="card-header my-0 py-0">Information sur le fournisseur</div>
          <div class="card-body">
            <div class="row">
              <div class="mb-4 fv-row col-md-6">
                <label class="required form-label">Nom du fournisseur</label>
                <input
                  type="text"
                  class="form-control mb-2"
                  placeholder="nom du produit"
                  v-model="form.providerName"
                  required
                />

                <div class="text-muted fs-7">Un nom du fournisseur doit etre unique</div>
              </div>
              <div class="mb-4 fv-row col-md-6">
                <label class="form-label">Num Tel</label>
                <input
                  type="tel"
                  class="form-control mb-2"
                  placeholder="nom du produit"
                  v-model="form.phone"
                />

                <div class="text-muted fs-7">Un nom du fournisseur doit etre unique</div>
              </div>
            </div>
            <div class="row">
              <div class="mb-4 fv-row col-md-6">
                <label class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control mb-2"
                  placeholder="adresse email"
                  v-model="form.mail"
                />

                <div class="text-muted fs-7">email du fournisseur doit etre unique</div>
              </div>
              <div class="mb-4 fv-row col-md-6">
                <label class="required form-label">Type de fournisseur</label>
                <select
                  id="selectType"
                  class="form-select form-select-solid fw-bold"
                  data-kt-select2="true"
                  data-placeholder="type de fournisseur"
                  data-allow-clear="true"
                  data-dropdown-css-class="w-230px"
                  data-kt-user-table-filter="entreprise"
                  data-hide-search="true"
                >
                  <option></option>
                  <option value="physique">Physique</option>
                  <option value="morale">Moral</option>
                </select>
              </div>
            </div>
            <div>
              <label class="form-label fw-normal fs-7">Adresse</label>
              <div class="ms-auto">
                <textarea
                  v-model="form.adress"
                  id=""
                  cols="20"
                  rows="3"
                  class="form-control bg-light"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import useProvider from "../../services/providerservices.js";
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
    const { providers, getProviders, storeProviders } = useProvider();

    const form = reactive({
      id: null,
      providerName: null,
      adress: null,
      phone: null,
      photo: null,
      type: null,
      mail: null,
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
          ? "Voulez-vous supprimer la liste des ces fournisseurs selectionnés"
          : `Voulez-vous supprimer l'fournisseur "${name.providerName}"?`,
        "Oui, d'accord",
        "annuller",
        () => {},
        () => {},
        "",
        "btn-dark"
      );
    };
    const handleType = (event) => {
      form.type = event.target.value;
    };
    const { dataCreated, swal } = notifications();
    async function callBackMounted() {
      await getProviders();

      $("#selectType").on("change", handleType);
    }

    const createProvider = async () => {
      console.log({ ...form });
      console.log("###########");
      const images = ref([]);
      await storeProviders({ ...form }, form.id, images);
      await getProviders();
      //   dataCreated();
      editing.value = false;
    };
    const deleteProvider = async (providerId) => {
      await removeProvider(providerId);
      await getProviders();
    };

    const editing = ref(false);
    const editModal = (value) => {
      editing.value = true;
      $("#selectType").val(value.type).trigger("change");
      $("#provider-modal").modal("show");
      for (const [key, val] of Object.entries(value)) {
        form[key] = val;
      }
    };
    const addModal = () => {
      $("#selectType").val("physique").trigger("change");
      for (const [key, value] of Object.entries(form)) {
        form[key] = typeof value == "string" ? "" : typeof value == "number" ? 0 : "";
      }
      form.type = "physique";
      $("#provider-modal").modal("show");
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
      providers,
      deleteProvider,
      createProvider,
    };
  },
};
</script>
