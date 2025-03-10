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
                Comptes
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
                      placeholder="chercher une entrée"
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
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un compte
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

              <div class="card-body d-flex flex-column">
                <template v-for="account in accounts" :key="account.id">
                  <div class="d-flex align-items-center position-relative mb-7">
                    <div
                      class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"
                    ></div>

                    <div class="d-flex flex-row justify-content-between w-100">
                      <div class="fw-semibold ms-5">
                        <div
                          @click="editModal(account)"
                          class="fs-5 fw-bold text-dark text-hover-primary cursor-pointer"
                        >
                          {{ account.name }}
                        </div>

                        <div class="fs-7 text-muted">
                          <a href="#">
                            {{ account.description }}
                          </a>
                        </div>
                      </div>

                      <div>
                        <span class="badge badge-secondary me-5">
                          {{ account.type }}
                        </span>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal-component
      :form="form"
      @cancel-btn="cancelBtn"
      @instance-modal="createAccount"
      id="compte-modal"
      :positionModal="`center mw-650px`"
      :isCss="true"
    >
      <template #title>
        {{ "Creer un compte" }}
      </template>
      <template #body>
        <div class="mx-5 my-5">
          <div class="row">
            <div class="col-md-6">
              <div class="fv-row">
                <label class="required form-label">Nom du compte</label>
                <input
                  type="text"
                  class="form-control mb-2"
                  v-model="form.name"
                  placeholder=""
                />

                <div class="text-muted fs-7">Configurer le nom de ce compte</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="" class="form-label fw-normal fs-7">Type de compte</label>
                <select
                  id="SelectClick"
                  class="form-select form-select-solid fw-bold"
                  data-placeholder="Selectionner un type"
                  data-hide-search="true"
                  data-control="select2"
                  data-dropdown-css-class="w-230px"
                >
                  <option>Selectionner le type de compte</option>
                  <option value="gestion">Gestion</option>
                  <option value="caisse">Caisse</option>
                </select>
              </div>
            </div>
          </div>
          <div class="fv-row mt-5">
            <label class="form-label fw-normal fs-7">Description</label>
            <div class="ms-auto">
              <textarea
                id=""
                cols="20"
                rows="3"
                class="form-control bg-light"
                v-model="form.description"
              ></textarea>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      id="money-modal"
      :positionModal="`center mw-650px`"
      activeBtn="false"
      :isCss="true"
    >
      <template #title>
        {{ "Choisir une monnaie" }}
      </template>
      <template #body>
        <div class="mx-5">
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            <input
              type="text"
              v-model="searchMoney"
              :class="`ps-13 form-control form-control-lg form-control-solid`"
              :placeholder="`chercher une monnaie`"
            />
          </div>
          <div class="mx-5">
            <div class="card-body">
              <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                  <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-180px">Les monnaies</th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                  </tr>
                </thead>

                <tbody class="fw-bold text-gray-600">
                  <template v-for="monnaie in money" :key="monnaie.id">
                    <tr class="w-100">
                      <td class="">
                        <label class="d-flex flex-stack cursor-pointer">
                          <span class="d-flex align-items-center me-2">
                            <span class="symbol symbol-50px me-6">
                              <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-compass fs-1 text-primary"
                                  ><span class="path1"></span><span class="path2"></span
                                ></i>
                              </span>
                            </span>

                            <span class="d-flex flex-column">
                              <span class="fw-bold fs-6">{{ monnaie.money_name }}</span>
                              <span class="text-muted fs-7">{{
                                monnaie.abreviation
                              }}</span>
                            </span>
                          </span>

                          <span class="form-check form-check-custom form-check-solid">
                            <input
                              name="monnaie"
                              @change="checkedValue(monnaie, 'money')"
                              :class="`form-check-input monnaie_${monnaie.id}`"
                              type="radio"
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
      </template>
    </modal-component>
  </div>
</template>
<script>
import useDeposit from "../../services/depositservices.js";
import { onMounted, reactive, ref, watch } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import categoryAdd from "../categories/categoryAdd.vue";
import moment from "moment";
import test from "../categories/categorieSave.js";
import { notifications } from "../../notifications/notifications.js";
import useCategories from "../../services/categorieservices.js";
import { useCookie } from "@vue-composable/cookie";
import useAccounts from "../../services/compteservices.js";
import useMoney from "../../services/moneyservices.js";
import useOtherentries from "../../services/entrymonnaieservices.js";
export default {
  components: {
    modalComponent,
    // categoryAdd,
  },
  setup() {
    onMounted(async () => {
      await callBackMounted();
    });
    const { accounts, getAccounts, storeAccounts } = useAccounts();

    const form = reactive({
      id: null,
      name: "",
      description: "",
      type: "gestion",
      user_id: 1,
      enterprise_id: 1,
    });

    const handleSelectChange = (event) => {
      form.type = event.target.value;
    };
    async function callBackMounted() {
      await getAccounts();
      $("#SelectClick").on("change", handleSelectChange);
      $("#SelectClick").val("gestion").trigger("change");
    }

    const addModal = () => {
      $("#compte-modal").modal("show");
    };

    const checkedValue = (account, type) => {};

    const update = ref(false);
    const editModal = (value) => {
      $("#compte-modal").modal("show");
      update.value = true;

      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
      $("#SelectClick").val(form.type).trigger("change");
    };
    const createAccount = async () => {
      await storeAccounts({ ...form });
      await getAccounts();
    };
    const cancelBtn = () => {};
    return {
      editModal,
      cancelBtn,
      createAccount,
      addModal,
      update,
      checkedValue,
      accounts,
      form,
    };
  },
};
</script>
