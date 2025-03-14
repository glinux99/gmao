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
                Entrée argent
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
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter une entree
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
                      <th class="min-w-125px">Nom</th>
                      <th class="min-w-125px">Compte</th>
                      <th class="min-w-125px">OpId</th>
                      <th class="min-w-125px">MOntant</th>

                      <th class="d-none"></th>

                      <th class="">Actions</th>
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
                    <template v-for="otherentrie in otherentries" :key="otherentrie.id">
                      <tr>
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input class="form-check-input" type="checkbox" value="1" />
                          </div>
                        </td>
                        <td class="cursor-pointer">
                          {{ otherentrie.user_name }}
                        </td>
                        <td class="cursor-pointer">
                          {{ otherentrie.account_name }}
                        </td>
                        <td class="cursor-pointer">
                          {{ otherentrie.uuid }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ `${otherentrie.amount} ${otherentrie.abreviation}` }}
                        </td>
                        <td class="d-none"></td>

                        <td class="text-end">
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                            @click="editModal(otherentrie)"
                          >
                            <i class="ki-duotone ki-pencil fs-3"
                              ><span class="path1"></span><span class="path2"></span
                              ><span class="path3"></span><span class="path4"></span
                              ><span class="path5"></span
                            ></i>
                          </button>
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                            data-kt-permissions-table-filter="delete_row"
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
      id="entry-modal"
      :positionModal="`center mw-650px`"
      :form="form"
      @instance-modal="createEntryMoney"
      :isCss="true"
    >
      <template #title>
        {{ `${update == true ? "Mis a jour d'une" : "Nouvelle"} entree argent` }}
      </template>
      <template #body>
        <div class="row mx-5 mb-5">
          <div class="col-md-6 fv-row mt-5">
            <label class="required form-label">Montant de l'entree</label>
            <input
              type="number"
              class="form-control mb-2"
              v-model="form.amount"
              placeholder=""
            />

            <div class="text-muted fs-7">Configurer le montant de votre entree</div>
            <div class="d-flex gap-1 mt-1">
              <button
                data-bs-toggle="tooltip"
                title="Changer le type de compte"
                type="button"
                @click="addCompte"
                class="btn btn-light-primary btn-sm mt-3 col-lg-6"
              >
                <i v-if="accountLocal.name == null" class="ki-duotone ki-plus fs-2"></i>
                {{ accountLocal.name ?? "Compte" }}
              </button>
              <button
                data-bs-toggle="tooltip"
                title="Changer la monnaie"
                type="button"
                @click="addMonnaie"
                class="btn btn-light-primary btn-sm mt-3 col-lg-6"
              >
                <i v-if="monnaieLocal.name == null" class="ki-duotone ki-plus fs-2"></i>
                {{ monnaieLocal.name ?? "Monnaie" }}
              </button>
            </div>
          </div>
          <div class="col-md-6 fv-row mt-5">
            <label class="form-label fw-normal fs-7">Motif</label>
            <div class="ms-auto">
              <textarea
                id=""
                cols="20"
                rows="5"
                class="form-control bg-light"
                v-model="form.motif"
              ></textarea>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      id="compte-modal"
      :positionModal="`center mw-650px`"
      activeBtn="false"
      :isCss="true"
    >
      <template #title>
        {{ "Choisir un compte" }}
      </template>
      <template #body>
        <div class="mx-5">
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            <input
              type="text"
              v-model="searchCompte"
              :class="`ps-13 form-control form-control-lg form-control-solid`"
              :placeholder="`chercher un compte`"
            />
          </div>
          <div class="mx-5">
            <div class="card-body">
              <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                  <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-180px">Les comptes</th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                  </tr>
                </thead>

                <tbody class="fw-bold text-gray-600">
                  <template v-for="account in accounts" :key="account.id">
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
                              <span class="fw-bold fs-6">{{ account.name }}</span>
                              <span class="text-muted fs-7">{{
                                account.description
                              }}</span>
                            </span>
                          </span>

                          <span class="form-check form-check-custom form-check-solid">
                            <span class="badge badge-secondary me-5">
                              {{ account.type }}
                            </span>
                            <input
                              name="radio"
                              @change="checkedValue(account)"
                              :class="`form-check-input account_${account.id}`"
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
    const { accounts, getAccounts } = useAccounts();
    const { getOtherentries, storeOtherentries, otherentries } = useOtherentries();
    const { money, getMoney } = useMoney();
    const searchCompte = ref("");
    const searchMoney = ref("");
    const form = reactive({
      id: null,
      pos_id: 0,
      user_id: null,
      money_id: null,
      amount: null,
      origin: 0,
      motif: "",
      account_id: null,
      is_validate: false,
      uuid: null,
      sync_status: 1,
      enterprise_id: 1,
    });
    const accountLocal = reactive({
      id: null,
      name: null,
    });
    const monnaieLocal = reactive({
      id: null,
      name: null,
    });
    const handleSelectChange2 = (event) => {
      alert(111);
    };
    async function callBackMounted() {
      await getOtherentries();
      await getAccounts();
      await getMoney();
      $("#SelectClick2").on("change", handleSelectChange2);
    }
    const addCompte = () => {
      $("#compte-modal").modal("show");
      $("#entry-modal").modal("handleUpdate", false);
    };
    const addModal = () => {
      $("#entry-modal").modal("show");
    };
    const addMonnaie = () => {
      $("#money-modal").modal("show");
      $("#entry-modal").modal("handleUpdate", false);
    };
    const checkedValue = (account, type) => {
      if (type == "money") {
        $("#money-modal").modal("hide");
        $("#entry-modal").modal("handleUpdate", false);
        monnaieLocal.id = account.id;
        monnaieLocal.name = account.abreviation;
        form.money_id = account.id;
      } else {
        $("#compte-modal").modal("hide");
        $("#entry-modal").modal("handleUpdate", false);
        accountLocal.id = account.id;
        accountLocal.name = account.name;
        form.account_id = account.id;
      }
    };
    const createEntryMoney = async () => {
      //   form.uuid = Date.now();
      console.log({ ...form });
      await storeOtherentries({ ...form });
      await getOtherentries();
      form.pos_id = 0;
      form.origin = 0;
      form.is_validate = false;
      form.money_id = monnaieLocal.id;
      form.account_id = accountLocal.id;
    };
    const update = ref(false);
    const editModal = (value) => {
      $("#entry-modal").modal("show");
      update.value = true;

      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
      accountLocal.id = value.id;
      accountLocal.name = value.account_name;
      form.account_id = value.account_id;
      monnaieLocal.id = value.money_id;
      monnaieLocal.name = value.abreviation;
      form.money_id = value.money_id;
    };
    return {
      update,
      editModal,
      createEntryMoney,
      otherentries,
      money,
      searchMoney,
      addMonnaie,
      monnaieLocal,
      accountLocal,
      checkedValue,
      accounts,
      form,
      searchCompte,
      addModal,
      addCompte,
    };
  },
};
</script>
