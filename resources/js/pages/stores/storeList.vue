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
                Liste des dépôts
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
                      placeholder="chercher un dépôt"
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
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un depot
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
                      <th class="min-w-125px" @click="reload">Nom</th>
                      <th class="min-w-125px">Description</th>
                      <th class="min-w-125px">Type</th>
                      <th class="min-w-125px">Entreprise</th>

                      <th class="min-w-125px">Date de creation</th>

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

                    <template v-for="deposit in deposits" :key="deposit.id">
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
                          {{ deposit.description }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          <div v-if="deposit.type === 'category'">
                            {{
                              deposit.categories.length > 1
                                ? "Categories ("
                                : "Categorie ("
                            }}
                            <template
                              v-for="(category_deposit, i) in deposit.categories"
                              :key="category_deposit.id"
                            >
                              <span> {{ category_deposit.name }}</span>

                              <span v-if="i != deposit.categories.length - 1"> , </span>
                            </template>
                            )
                          </div>
                          <div v-else>
                            {{ deposit.type }}
                          </div>
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ deposit.enterprise.name }}
                        </td>
                        <td @click="viewModal(deposit)" class="cursor-pointer">
                          {{ convertDate(deposit.created_at) }}
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
      :positionModal="`right`"
      :form="form"
      :isCss="true"
      @instance-modal="createDeposit"
    >
      <template #title>
        {{ editing == true ? `Modification du ${form.name}` : "Création d'un dépôt" }}
      </template>
      <template #body>
        <div class="mx-5">
          <div class="mb-5 fv-row pt-5">
            <label class="required form-label">Nom de votre dépôt</label>

            <input
              type="text"
              v-model="form.name"
              class="form-control mb-2"
              placeholder=""
            />

            <div class="text-muted fs-7">Configurer le nom de ce dépôt</div>
          </div>
          <div class="mb-5 fv-row">
            <label class="required form-label">Type de dépôt</label>

            <div class="">
              <select
                id="SelectClick"
                class="form-select form-select-solid fw-bold"
                data-placeholder="Selectionner un type"
                data-hide-search="true"
                data-control="select2"
                data-dropdown-css-class="w-230px"
              >
                <option></option>
                <option data-subtext="categories" value="group" selected>Groupe</option>
                <option data-subtext="Groupe de dépôt" value="category">Categorie</option>
              </select>
              <div class="valid-feedback">Par defaut groupe</div>
            </div>
          </div>
          <div class="mb-5 fv-row d-none" id="categorie_tags">
            <label class="required form-label">Categorie</label>
            <input
              @change="categorieValue"
              id="add_product_categorie_tags"
              class="form-control mb-2"
              :data-bs-categories="categoriesDefault"
              :data-bs-whiteList="categoriesListString"
            />
            <div class="text-muted fs-7">Configurer une categorie de ce dépôt</div>
          </div>
          <!-- <div class="mb-5 fv-row">
            <label class="required form-label">Adresse</label>

            <textarea
              v-model="form.adress"
              id=""
              cols="20"
              rows="1"
              class="form-control"
            ></textarea>
          </div> -->
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
export default {
  components: {
    modalComponent,
    // categoryAdd,
  },
  setup(props, { emit }) {
    const { deposits, getDeposits, storeDeposit, removeDeposit } = useDeposit();
    const {
      categoriesListString,
      categories,
      getCategories,
      storeCategories,
    } = useCategories();
    let form = reactive({
      id: null,
      name: "",
      type: "group",
      categories: [],
      enterprise_id: 1,
      description: "",
      user_id: 1,
    });
    onMounted(async () => {
      await callBackMounted();
    });
    const alertBtn = (name) => {
      swal(
        "question",
        "Question",
        name == null
          ? "Voulez-vous supprimer la liste de dépôts selectionné"
          : `Voulez-vous supprimer le dépôt "${name}"?`,
        "Oui, d'accord",
        "annuller",
        () => {},
        () => {},
        "",
        "btn-dark"
      );
    };
    const handleSelectChange = (event) => {
      form.type = event.target.value;
      if (event.target.value == "group") {
        $("#categorie_tags").addClass("d-none");
      } else {
        $("#categorie_tags").removeClass("d-none");
      }
    };
    const { dataCreated, swal } = notifications();
    let categoriesDefault = "";
    async function callBackMounted() {
      await getDeposits();
      await getCategories();

      $("#SelectClick").on("change", handleSelectChange);
      test.initTagify(categoriesListString.value.split(","));
    }
    const categorieValue = (e) => {
      let values = JSON.parse(e.target.value);
      form.categories = [];
      values.forEach((element) => {
        form.categories.push(element.value);
      });
    };
    const createDeposit = async () => {
      console.log({ ...form });
      console.log("###########");
      await storeDeposit({ ...form });

      dataCreated();
      await getDeposits();
      await getCategories();
      $("#categorie_tags").addClass("d-none");
      $("#SelectClick").val("group").trigger("change");
      editing.value = false;
    };
    const deleteDeposit = async (depositId) => {
      await removeDeposit(depositId);
      await getDeposits();
    };

    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY à HH:mm:ss");
    };

    const editing = ref(false);
    const editModal = (value) => {
      editing.value = true;
      $("#store-modal").modal("show");

      let defautCategories = [];
      test.initTagify(categoriesListString.value.split(","), []);
      if (value.type == "category") {
        $("#SelectClick").val("category").trigger("change");
        defautCategories = value.categories.map((el) => el.name);
        test.initTagify(categoriesListString.value.split(","), defautCategories);
      } else {
        $("#categorie_tags").addClass("d-none");
        $("#SelectClick").val("group").trigger("change");
      }
      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
    };
    const instanceModal = (value) => {
      for (const [key, val] of Object.entries(value)) {
        form[key] = value[key];
      }
      createDeposit();
    };
    const addModal = () => {
      $("#categorie_tags").addClass("d-none");
      $("#SelectClick").val("group").trigger("change");
      for (const [key, value] of Object.entries(form)) {
        form[key] = typeof value == "string" ? "" : typeof value == "number" ? 0 : "";
      }
      form.type = "group";
      $("#store-modal").modal("show");
    };
    const viewModal = (store) => {
      const storeCookie = useCookie("store");
      storeCookie.setCookie(store.id);
      location.href = "/admin/store";
    };
    return {
      alertBtn,
      categorieValue,
      createDeposit,
      deposits,
      deleteDeposit,
      convertDate,
      editModal,
      viewModal,
      form,
      addModal,
      editing,
      categoriesDefault,
      instanceModal,
      categoriesListString,
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
