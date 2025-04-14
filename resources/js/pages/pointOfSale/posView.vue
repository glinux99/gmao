<template>
  <div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
      <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-10">
          <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
              <div class="me-7 mb-4">
                <div
                  class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"
                >
                  <img
                    :src="pointOfSale.logo + '-0.png'"
                    @error="$event.target.src = '/images/no-image.png'"
                    alt="image"
                  />

                  <div
                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"
                  ></div>
                </div>
              </div>

              <div class="flex-grow-1">
                <div
                  class="d-flex justify-content-between align-items-start flex-wrap mb-2"
                >
                  <div class="d-flex flex-column">
                    <div class="d-flex align-items-center mb-2">
                      <a
                        href="#"
                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"
                        >{{ pointOfSale.name }}</a
                      >
                      <a href="#"
                        ><i class="ki-duotone ki-verify fs-1 text-primary"
                          ><span class="path1"></span><span class="path2"></span></i
                      ></a>
                    </div>

                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                      <a
                        href="#"
                        class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"
                      >
                        <i class="ki-duotone ki-gift fs-4 me-1"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span
                        ></i>
                        {{ pointOfSale.type }}
                      </a>
                    </div>
                  </div>

                  <div class="card-toolbar d-flex justify-content-end">
                    <button
                      type="button"
                      class="btn btn-primary btn-sm ms-3"
                      data-kt-menu-trigger="click"
                      data-kt-menu-placement="bottom-end"
                    >
                      <i class="ki-duotone ki-cloud-download fs-2"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Exporter
                    </button>
                    <div
                      class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                      data-kt-menu="true"
                      data-kt-menu-id="kt-users-tasks"
                    >
                      <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">
                          Exporter les donnees en :
                        </div>
                      </div>

                      <div class="separator border-gray-200"></div>

                      <div class="form px-7 py-5" data-kt-menu-id="kt-users-tasks-form">
                        <div class="fv-row mb-10 d-flex">
                          <button
                            @click="exportFile('excel')"
                            class="btn btn-outline badge-success px-5 py-1 btn-light-primary"
                          >
                            <i class="fa fa-file-excel text-success fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                            Excel
                          </button>
                          <button
                            @click="exportFile('pdf')"
                            class="ms-1 btn btn-outline badge-danger px-5 py-1 btn-light-primary"
                          >
                            <i class="fa fa-file-pdf text-danger fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                            PDF
                          </button>
                          <button
                            @click="exportFile('csv')"
                            class="ms-1 btn btn-outline badge-info px-5 py-1 btn-light-primary"
                          >
                            <i class="fa fa-file-csv text-info fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                            CSV
                          </button>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-light-primary btn-sm">
                      <i class="ki-duotone ki-cloud-add fs-3"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span
                      ></i>
                      Importation
                    </button>
                  </div>
                </div>

                <div class="d-flex flex-wrap flex-stack">
                  <div class="d-flex flex-column flex-grow-1 pe-8">
                    <div class="d-flex flex-wrap">
                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            data-kt-countup-value="4500"
                          >
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">Solde</div>
                      </div>

                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          % &nbsp;

                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            :data-kt-countup-value="countElement(pointOfSale.store)"
                          >
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">
                          Nbr. Points bonus
                        </div>
                      </div>
                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          % &nbsp;

                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            :data-kt-countup-value="countElement(pointOfSale.store)"
                          >
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">TVA</div>
                      </div>
                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            :data-kt-countup-value="getAllQty(pointOfSale.store)"
                          >
                            <!-- data-kt-countup-prefix="Litre" -->
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">% main d'oeuvre</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <ul
              class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-8"
            >
              <li class="nav-item mt-2">
                <a
                  class="nav-link text-active-primary pb-4 active"
                  data-bs-toggle="tab"
                  href="#kt_product_details"
                >
                  Details
                </a>
              </li>

              <li class="nav-item mt-2">
                <a
                  class="nav-link text-active-primary pb-4"
                  data-kt-countup-tabs="true"
                  data-bs-toggle="tab"
                  href="#kt_fiche_stock"
                >
                  Depot
                </a>
              </li>

              <li class="nav-item mt-2">
                <a
                  class="nav-link text-active-primary pb-4"
                  data-kt-countup-tabs="true"
                  data-bs-toggle="tab"
                  href="#kt_agents"
                >
                  Agents
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="kt_product_details" role="tabpanel">
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
              <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                  <h3 class="fw-bold m-0">Details du point de vente</h3>
                </div>

                <div
                  @click="editModal(pointOfSale)"
                  class="btn btn-sm btn-primary align-self-center"
                >
                  Point de vente
                </div>
              </div>

              <div class="card-body p-9">
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted"
                    >Nom du point de vente</label
                  >

                  <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ pointOfSale.name }}</span>
                  </div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Type de pos</label>

                  <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{
                      pointOfSale.type
                    }}</span>
                  </div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">
                    Description

                    <span class="ms-1">
                      <i class="ki-duotone ki-information fs-7"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span
                      ></i>
                    </span>
                  </label>

                  <div class="col-lg-8 d-flex align-items-center">
                    {{ pointOfSale.description }}
                  </div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Depots</label>

                  <div class="col-lg-8">depots</div>
                </div>

                <!-- <div class="row mb-7">
              <label class="col-lg-4 fw-semibold text-muted">
                Nom de l'entreprise

                <span class="ms-1">
                  <i class="ki-duotone ki-information fs-7"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span
                  ></i>
                </span>
              </label>

              <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">Mans's</span>
              </div>
            </div> -->
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted"
                    >Nombre de ventes pour un bonus</label
                  >

                  <div class="col-lg-8">{{ pointOfSale.nb_sales_bonus }}</div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Main d'oeuvre</label>

                  <div class="col-lg-8">{{ pointOfSale.workforce_percent }} %</div>
                </div>
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">RCCM</label>

                  <div class="col-lg-8">{{ pointOfSale.rcc }}</div>
                </div>
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted"
                    >Identification National</label
                  >

                  <div class="col-lg-8">
                    {{ pointOfSale.national_identification }}
                  </div>
                </div>
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted"> Numero d'impot</label>

                  <div class="col-lg-8">
                    {{ pointOfSale.num_impot }}
                  </div>
                </div>
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Autorisations</label>

                  <div class="col-lg-8">
                    {{ pointOfSale.autorisation_fct }}
                  </div>
                </div>
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Contact</label>

                  <div class="col-lg-8">
                    {{ pointOfSale.phone }}
                  </div>
                </div>
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Adresse</label>

                  <div class="col-lg-8">{{ pointOfSale.adresse }}</div>
                </div>
                <div class="row mb-7" v-if="pointOfSale.website">
                  <label class="col-lg-4 fw-semibold text-muted">Site Web</label>

                  <div class="col-lg-8">
                    {{ pointOfSale.website }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="kt_fiche_stock" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
              <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                  <h3 class="fw-bold m-0">Depots du point de ventes</h3>
                </div>

                <div
                  @click="affectStore(true)"
                  class="btn btn-sm btn-primary align-self-center"
                >
                  Ajouter un depot
                </div>
              </div>

              <div class="card-body py-9 row">
                <template v-for="store in depositPos" :key="store.id">
                  <div class="col-md-4">
                    <label class="d-flex flex-stack cursor-pointer m-2">
                      <span class="d-flex align-items-center me-2">
                        <span class="symbol symbol-50px me-6">
                          <span class="symbol-label bg-light-primary">
                            <i class="fa fa-store fs-1 text-primary"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>
                        </span>

                        <span class="d-flex flex-column">
                          <span class="fw-bold fs-6">{{ store.name }}</span>
                          <span class="fw-bold fs-7"> {{ store.type }}</span>
                        </span>
                      </span>
                    </label>
                  </div>
                </template>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="kt_agents" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
              <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                  <h3 class="fw-bold m-0">Agent du point de ventes</h3>
                </div>

                <div
                  @click="affectStore(false)"
                  class="btn btn-sm btn-primary align-self-center"
                >
                  Ajouter un agent
                </div>
              </div>

              <div class="card-body py-9">
                <template v-for="agent in agentPos" :key="agent.id">
                  <label class="d-flex flex-stack cursor-pointer m-2">
                    <span class="d-flex align-items-center me-2">
                      <span class="symbol symbol-50px me-6">
                        <span class="symbol-label bg-light-primary">
                          <i class="ki-duotone ki-user fs-1 text-primary"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                        </span>
                      </span>
                      <span class="d-flex flex-column">
                        <span class="fw-bold fs-6">{{ agent.user_name }}</span>
                        <span class="fw-bold fs-7"> {{ agent.user_mail }}</span>
                      </span>
                    </span>
                  </label>
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal-component
      id="affect-modal"
      :positionModal="`right`"
      @instance-modal="storeAffect"
      activeBtn="false"
      :isCss="true"
    >
      <template #title>Affecter un {{ titleModal }} pos </template>
      <template #body>
        <div class="mx-5">
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            <input
              type="text"
              v-model="searchAgent"
              :class="`ps-13 form-control form-control-lg form-control-solid`"
              :placeholder="`chercher un ${titleModal}`"
            />
          </div>
          <div class="mx-5">
            <div class="card-body">
              <table
                class="table align-middle table-row-dashed fs-6 gy-5"
                id="kt_table_usersxx2"
              >
                <thead>
                  <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-180px">Item selectionner</th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                  </tr>
                </thead>

                <tbody class="fw-bold text-gray-600">
                  <template v-for="deposit in dataAffect" :key="deposit.id">
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
                              <span class="fw-bold fs-6">{{
                                deposit.name ?? deposit.user_name
                              }}</span>
                              <span class="fw-bold fs-7">{{
                                deposit.type ?? deposit.user_mail
                              }}</span>
                            </span>
                          </span>

                          <span class="form-check form-check-custom form-check-solid">
                            <input
                              @change="checkedValue(deposit)"
                              :class="`form-check-input service_${deposit.id}`"
                              type="checkbox"
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
      <template #footer>
        <div class="modal-footer">
          <div class="row col-12 p-0 m-0">
            <!-- code -->

            <div class="d-flex flex-row justify-content-between">
              <button
                id="annuler"
                type="reset"
                @click="annuler"
                class="btn btn-light me-3"
                data-kt-users-modal-action="cancel"
                data-bs-dismiss="modal"
              >
                Annuler
              </button>
              <button type="submit" class="btn btn-dark">
                <span class="indicator-label">Desacffecter </span>
              </button>
              <button type="submit" class="btn btn-primary">
                <span class="indicator-label">Affecter </span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import useProducts from "../../services/productservices";
import modalComponent from "../../components/modals/modalComponent.vue";
import productStore from "../products/productStore.vue";
import usePointOfSales from "../../services/posservices";
import useDeposit from "../../services/depositservices";
import useUsers from "../../services/userservices";
import { useCookie } from "@vue-composable/cookie";
export default {
  components: {
    modalComponent,
    productStore,
  },
  setup() {
    const updateProduct = ref(null);
    const searchAgent = ref("");
    const {
      getPointOfSale,
      pointOfSale,
      storeDepositPos,
      getAgentPos,
      agentPos,
      getDepositPos,
      depositPos,
      storeAgentPos,
    } = usePointOfSales();
    const { deposits, getDeposits, storeDeposit, removeDeposit } = useDeposit();
    const { users, getUsers } = useUsers();

    onMounted(async () => {
      await callBackMounted();
    });
    const posId = ref(null);
    async function callBackMounted() {
      await getPointOfSale();
      await getDeposits();
      posId.value = useCookie("pos").cookie.value;
      await getAgentPos(posId.value);
      await getDepositPos(posId.value);
      await getUsers();
    }
    const countElement = (value) => {
      try {
        return value.length;
      } catch (error) {}
    };
    const getAllQty = (value) => {
      try {
        var qte = 0;
        value.forEach((element) => {
          qte += element.available_qte;
        });

        return qte;
      } catch (error) {}
    };
    const dataAffect = ref([]);
    const affectedList = ref([]);
    const editModal = (value) => {};
    const titleModal = ref("depot");
    const affectStore = (type = false) => {
      affectedList.value = [];
      if (type) {
        dataAffect.value = deposits.value;
        titleModal.value = "depot";
        depositPos.value.forEach((el) => {
          $(`.service_${el.id}`).prop("checked", true);
        });
      } else {
        dataAffect.value = users.value;
        titleModal.value = "Agent";
      }
      $("#affect-modal").modal("show");
    };
    const storeAffect = async () => {
      if (titleModal == "Agent") {
        await storeAgentPos({
          users: affectedList.value,
        });
        await getAgentPos(posId.value);
      } else {
        await storeDepositPos({
          deposits: affectedList.value,
        });
        await getDepositPos(posId.value);
      }
    };
    const checkedValue = (service) => {
      const element = document.querySelector(`.service_${service.id}`);
      if (titleModal == "Agent") {
        if (element.checked) {
          affectedList.value.push({
            pos_id: 1,
            user_id: service.id,
          });
        } else {
          affectedList.value = affectedList.value.filter(
            (el) => el.user_id != service.id
          );
        }
      } else {
        if (element.checked) {
          affectedList.value.push({
            pos_id: 1,
            deposit_id: service.id,
          });
        } else {
          affectedList.value = affectedList.value.filter(
            (el) => el.deposit_id != service.id
          );
        }
      }
    };
    return {
      storeAffect,
      agentPos,
      depositPos,
      titleModal,
      checkedValue,
      dataAffect,
      users,
      affectStore,
      deposits,
      searchAgent,
      pointOfSale,
      editModal,
      updateProduct,
      getAllQty,
      countElement,
    };
  },
};
</script>
