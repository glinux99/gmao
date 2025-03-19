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
                Liste des Maintenances
              </h1>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
              <!-- Toggle View Button -->
              <button
                type="button"
                class="btn btn-light btn-active-light-primary me-2"
                @click="toggleView"
              >
                <span v-if="showTableView">Vue Grille</span>
                <span v-else>Vue Liste</span>
              </button>
              <!-- End Toggle View Button -->
              <button
                type="button"
                class="btn btn-primary"
                @click="addMaintenance"
              >
                Ajouter une Maintenance
              </button>
            </div>
          </div>
        </div>

        <div v-if="isLoading">Loading...</div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <!-- Display the table view if showTableView is true -->
          <div
            v-if="showTableView"
            id="kt_app_content_container_d-none"
            class="app-container container-xxl"
          >
            <div class="card card-flush">
              <div class="card-header mt-6">
                <div class="card-title">
                  <div
                    class="d-flex align-items-center position-relative my-1 me-5"
                  >
                    <i
                      class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    <input
                      type="text"
                      data-kt-permissions-table-filter="search"
                      class="form-control form-control-solid w-250px ps-13"
                      placeholder="Rechercher une maintenance"
                      v-model="searchQuery"
                    />
                  </div>
                </div>
              </div>
              <div class="card-body pt-0 w-100">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                  id="kt_permissions_table"
                >
                  <thead>
                    <tr
                      class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                    >
                      <th class="">Description</th>
                      <th class="">Equipment</th>
                      <th class="">Status</th>
                      <th class="">Work Order</th>
                      <th class="">Date de debut</th>
                      <th class="">DeadLine</th>
                      <th class="">Technicien</th>
                      <th class="text-end">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="fw-semibold text-gray-600">
                    <tr
                      v-for="maintenance in filteredMaintenances"
                      :key="maintenance.id"
                    >
                      <td>{{ maintenance.description }}</td>
                      <td>
                        {{
                          maintenance.equipment
                            ? maintenance.equipment.name
                            : "N/A"
                        }}
                      </td>
                      <td>
                        <span
                          v-if="maintenance.status === 'pending'"
                          class="badge badge-warning"
                          >En attente</span
                        >
                        <span
                          v-else-if="maintenance.status === 'in_progress'"
                          class="badge badge-info"
                          >En cours</span
                        >
                        <span
                          v-else-if="maintenance.status === 'completed'"
                          class="badge badge-success"
                          >Terminée</span
                        >
                        <span
                          v-else-if="maintenance.status === 'canceled'"
                          class="badge badge-dark"
                          >Annulée</span
                        >
                        <span v-else class="badge badge-secondary"
                          >Inconnu</span
                        >
                      </td>
                      <td>{{ maintenance.work_order }}</td>
                      <td>{{ maintenance.start_date }}</td>
                      <td>
                        <span class="fs-8">
                          Debut : {{ maintenance.start_date }} <br />
                        </span>
                        <span class="fs-8 text-center">
                          <span class="badge badge-light-success">
                            {{
                              formatDeadline(
                                maintenance.end_date,
                                maintenance.start_date,
                                maintenance
                              )
                            }}</span
                          >
                        </span>
                      </td>
                      <td>
                        {{ maintenance.user ? maintenance.user.name : "N/A" }}
                      </td>
                      <td class="text-end">
                        <!-- <button @click="viewMaintenance(maintenance.id)"
                                                      class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                      <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                              class="path2"></span><span class="path3"></span><span
                                                              class="path4"></span><span class="path5"></span></i>
                                                  </button> -->

                        <button
                          @click="editMaintenance(maintenance)"
                          class="btn btn-icon btn-active-light-primary w-30px h-30px"
                          data-bs-toggle="modal"
                          data-bs-target="#kt_modal_update_maintenance"
                        >
                          <i class="ki-duotone ki-pencil fs-3"
                            ><span class="path1"></span
                            ><span class="path2"></span
                            ><span class="path3"></span
                            ><span class="path4"></span
                            ><span class="path5"></span
                          ></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Display the grid view if showTableView is false -->
          <div
            v-if="!showTableView"
            id="kt_app_content_container"
            class="app-container container-xxl"
          >
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
              <template
                v-for="maintenance in maintenances"
                :key="maintenance.id"
              >
                <div class="col-md-4">
                  <div class="card card-flush h-md-100">
                    <div class="card-header">
                      <div class="card-title">
                        <h2>Maintenance: {{ maintenance.id }}</h2>
                      </div>
                    </div>

                    <div class="card-body pt-1">
                      <div class="fw-bold text-gray-600 mb-5">
                        Description: {{ maintenance.description }}
                      </div>
                      <div class="fw-bold text-gray-600 mb-5">
                        Status:
                        <span
                          v-if="maintenance.status === 'pending'"
                          class="badge badge-warning"
                          >En attente</span
                        >
                        <span
                          v-else-if="maintenance.status === 'in_progress'"
                          class="badge badge-info"
                          >En cours</span
                        >
                        <span
                          v-else-if="maintenance.status === 'completed'"
                          class="badge badge-success"
                          >Terminée</span
                        >
                        <span v-else class="badge badge-secondary"
                          >Inconnu</span
                        >
                      </div>
                      <div class="fw-bold text-gray-600 mb-5">
                        Equipment :
                        {{
                          maintenance.equipment
                            ? maintenance.equipment.name
                            : "N/A"
                        }}
                      </div>

                      <div class="fw-bold text-gray-600 mb-5">
                        Work Order: {{ maintenance.work_order }}
                      </div>
                      <div class="fw-bold text-gray-600 mb-5">
                        Technicien:
                        {{ maintenance.user ? maintenance.user.name : "N/A" }}
                      </div>
                      <div class="fw-bold text-gray-600 mb-5">
                        Debut : {{ maintenance.start_date }} <br />
                        Duree :
                        <span class="fs-8 text-center">
                          <span class="badge badge-light-success">
                            {{
                              formatDeadline(
                                maintenance.end_date,
                                maintenance.start_date,
                                maintenance
                              )
                            }}</span
                          >
                        </span>
                      </div>
                    </div>

                    <div class="card-group p-4">
                      <!-- <button @click="viewMaintenance(maintenance.id)"
                                                  class="card btn btn-light btn-active-primary my-1 me-2 ">
                                                  <span>Afficher</span>
                                                  <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                          class="path2"></span><span class="path3"></span><span
                                                          class="path4"></span><span class="path5"></span></i>
                                              </button> -->

                      <button
                        @click="editMaintenance(maintenance)"
                        class="col-12 btn btn-light btn-active-light-primary my-1"
                        data-bs-toggle="modal"
                        data-bs-target="#kt_modal_update_maintenance"
                      >
                        Editer
                        <i class="ki-duotone ki-pencil fs-3 ms-5"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                        ></i>
                      </button>
                    </div>
                  </div>
                </div>
              </template>

              <div class="ol-md-4" v-if="false">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-center">
                    <button
                      type="button"
                      class="btn btn-clear d-flex flex-column flex-center"
                      @click="addMaintenance"
                      id="addMaintenance"
                    >
                      <img
                        src="/assets/media/illustrations/sketchy-1/2.png"
                        alt=""
                        class="mw-100 mh-150px mb-7"
                      />

                      <div
                        class="fw-bold fs-3 text-gray-600 text-hover-primary"
                      >
                        Ajouter une nouvelle Maintenance
                      </div>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ... -->
    <Dialog
      :id="id"
      :header="
        isEditMode ? 'Modifier une Maintenance' : 'Créer une Maintenance'
      "
      v-model:visible="visible"
      :style="{ width: '800px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <Card class="bg-secondary">
        <template #content>
          <div class="row">
            <div class="col-md-6">
              <label class="col-form-label fw-bold fs-6">
                <span class="required">Designation de la maintenance</span>
                <i
                  class="fas fa-exclamation-circle ms-1 fs-7"
                  data-bs-toggle="tooltip"
                  title="equipement"
                ></i>
              </label>
              <div class="fv-row">
                <InputText
                  type="text"
                  name="designation"
                  class="form-control mb-3 mb-lg-0"
                  placeholder="designation de la maintenance"
                  v-model="form.description"
                  required
                />
              </div>
            </div>
            <div class="col-md-6">
              <label class="col-form-label fw-bold fs-6">
                <span class="required">Equipement</span>
                <i
                  class="fas fa-exclamation-circle ms-1 fs-7"
                  data-bs-toggle="tooltip"
                  title="equipement"
                ></i>
              </label>
              <div class="fv-row">
                <Dropdown
                  v-model="form.equipment_id"
                  :options="equipments"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="Sélectionner un equipment"
                  class="w-full md:w-14rem"
                />
              </div>
            </div>
          </div>
        </template>
      </Card>
      <Card class="mt-2 bg-secondary">
        <template #title> Assigner à </template>
        <template #content>
          <div class="fv-row fv-plugins-icon-container row">
            <div class="col-md-4">
              <div class="form-check form-check-custom form-check-solid mb-3">
                <RadioButton
                  inputId="assignToUser"
                  value="user"
                  v-model="form.assignToType"
                  name="assignToType"
                />
                <label class="form-check-label" for="assignToUser">
                  Technicien
                </label>
              </div>
              <div class="form-check form-check-custom form-check-solid">
                <RadioButton
                  inputId="assignToTeam"
                  value="team"
                  v-model="form.assignToType"
                  name="assignToType"
                />
                <label class="form-check-label" for="assignToTeam">
                  Équipe
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div v-if="form.assignToType === 'user'" class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Technicien</label>
                <Dropdown
                  v-model="form.assigned_user_id"
                  :options="users"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="Sélectionner un technicien"
                  class="w-full md:w-14rem"
                />
              </div>
              <div v-else-if="form.assignToType === 'team'" class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Équipe</label>
                <Dropdown
                  v-model="form.assigned_team_id"
                  :options="teams"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="Sélectionner une équipe"
                  class="w-full md:w-14rem"
                />
              </div>
            </div>
            <div class="col-md-2">
              <label class="fw-semibold fs-6 mb-2">
                <span class="">Tacherons</span>
              </label>
              <div class="fv-row">
                <InputText
                  type="number"
                  class="w-full md:w-14rem"
                  placeholder=""
                  v-model="form.nbre_tacherons"
                    @change="addTModal"
                  required
                />
              </div>
            </div>
          </div>
          <!-- Conditional rendering for user/team selection -->
        </template>
      </Card>
      <Card class="mt-2 bg-secondary">
        <template #title> Programmation </template>
        <template #content>
          <div class="row">
            <div class="col-md-6">
              <label class="col-form-label fw-bold fs-6">
                <span>Fréquence</span>
              </label>
              <Dropdown
                v-model="form.frequency"
                :options="frequencies"
                optionLabel="label"
                optionValue="value"
                placeholder="Sélectionner la fréquence"
                class="w-full md:w-14rem"
                @change="handleFrequencyChange"
              />
            </div>
            <div class="col-md-6" v-if="form.frequency === 'weekly'">
              <label class="col-form-label fw-bold fs-6">
                <span>Jour de la semaine</span>
              </label>
              <MultiSelect
                v-model="form.daysOfWeek"
                :options="daysOfWeek"
                optionLabel="label"
                optionValue="value"
                placeholder="Sélectionner les jours"
                class="w-full md:w-14rem"
              />
            </div>

            <div class="col-md-6">
              <label class="fw-bold fs-6 col-form-label">Date de debut</label>
              <Calendar
                v-model="form.start_date"
                showTime
                hourFormat="24"
                class="w-full md:w-14rem"
                placeholder="Date de debut"
                required
              />
            </div>
            <div class="col-md-6">
              <label class="fw-bold fs-6 col-form-label">Date de fin</label>
              <Calendar
                v-model="form.end_date"
                dateFormat="yy-mm-dd"
                showTime
                hourFormat="24"
                class="w-full md:w-14rem"
                placeholder="Date de fin"
                required
              />
            </div>
          </div>
        </template>
      </Card>
      <Card class="bg-secondary mt-2">
        <template #title>Matériels à utiliser</template>
        <template #content>
          <div class="row">
            <div class="col-md-12">
              <label class="col-form-label fw-bold fs-6">Matériel</label>
              <AutoComplete
                v-model="form.materials"
                class="w-full md:w-14rem"
                placeholder="Rechercher un matériel"
                :suggestions="filteredSuggestions"
                @complete="search"
                field="designation"
                optionLabel="designation"
                optionValue="id"
                @item-select="handleMaterialSelect"
                multiple
              />
            </div>
          </div>
          <div class="mt-4">
            <label class="col-form-label fw-bold fs-6">
              Matériels ajoutés
            </label>
            <ul class="list-group">
              <li
                v-for="(material, index) in form.materials"
                :key="index"
                class="list-group-item  "
              >
                <div class="row">
                    <div class="col-md-6 ">
                    {{ getMaterialName(material.id) }}
                        </div>
                        <div class="col-md-4">
                            <InputText
                            type="text"
                            name="designation"
                            class="w-full md:w-14rem"
                            placeholder="0"
                            v-model="material.quantity"
                        />
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <span v-if="material.unity">
                            {{ material.unity.designation }}
                        </span>
                        </div>
                <div class="col-md-1">
                    <Button
                  icon="pi pi-trash"
                  severity="danger"
                  @click="handleRemoveMaterial(index)"
                />
                </div>
                </div>
              </li>
            </ul>
          </div>
        </template>
      </Card>
      <Card class="bg-secondary mt-2">
        <template #content>
          <div class="fv-row mb-7 fv-plugins-icon-container">
            <div class="d-flex justify-content-end">
              <Button
                label="Ajouter une instruction"
                icon="pi pi-plus-circle"
                @click="addInstruction"
                severity="warn"
                class="p-button-primary"
              />
            </div>
            <div
              v-for="(instruction, index) in form.instructions"
              :key="index"
              class="my-1 border rounded"
            >
              <div class="d-flex justify-content-between align-items-center">
                <label class="fw-bold">Instruction {{ index + 1 }}</label>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <InputText
                    type="text"
                    name="designation"
                    class="form-control mb-3 mb-lg-0"
                    placeholder="Description de l'instruction"
                    v-model="instruction.description"
                    @input="
                      addInstructionValue(
                        'description',
                        instruction.description,
                        index
                      )
                    "
                  />
                </div>
                <div class="col-md-3">
                  <Dropdown
                    class="w-full md:w-14rem"
                    v-model="instruction.response_type"
                    :options="['checkbox', 'text / valeur']"
                    placeholder="Type de reponse"
                    @change="
                      addInstructionValue(
                        'response_type',
                        instruction.response_type,
                        index
                      )
                    "
                  />
                </div>
                <div
                  class="col-md-1 d-flex align-items-start justify-content-start"
                  @click="removeInstruction(index)"
                >
                  <button>
                    <i class="fa fa-trash text-danger m-0 p-0 display-6"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </template>
      </Card>
      <template #footer>
        <Button
          label="Annuler"
          icon="pi pi-times"
          severity="secondary"
          variant="text"
          class="p-button-text"
          @click="visible=false"
        />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          class="p-button-primary"
          raised
          @click="submitMaintenance"
        />
      </template>
    </Dialog>
    <Dialog
      :id="id"
      :header="isEditMode ? 'Modifier une la quantité' : 'Ajouter une quantité'"
      v-model:visible="qVisible"
      :style="{ width: '400px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <div class="">
        <label class="col-form-label fw-bold fs-6">
          <span class=""
            >Quelle Quantité à utiliser pour
            <span class="text-warning">{{ selectMaterial.designation }}</span>
            ?</span
          >
        </label>
        <div class="row">
          <div :class="selectMaterial.unity ? 'col-md-8' : ''">
            <div class="fv-row">
              <InputText
                type="text"
                class="form-control mb-3 mb-lg-0"
                placeholder="0"
                v-model="selectMaterial.quantity"

              />
            </div>
          </div>
          <div :class="selectMaterial.unity ? 'col-md-4' : ''">
            <div class="fv-row">
              <InputText
                v-if="selectMaterial.unity"
                type="text"
                v-model="selectMaterial.unity.designation"
                class="form-control mb-3 mb-lg-0"
                placeholder="0"
                readOnly
              />
            </div>
          </div>
        </div>
      </div>
      <template #footer>
        <Button
          label="Annuler"
          icon="pi pi-times"
          severity="secondary"
          variant="text"
          class="p-button-text"
          @click="closeModal"
        />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          class="p-button-primary"
          raised
          @click="submitQuantity"
        />
      </template>
    </Dialog>
    <Dialog
      :id="id"
      :header="isEditMode ? 'Modifier le paiement de tacherons' : 'Ajouter un paiement de tacherons'"
      v-model:visible="tVisible"
      :style="{ width: '400px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <div class="">
        <label class="col-form-label fw-bold fs-6">
          <span class=""
            >Quelle est le montant sera donné à un tacherons par
            <span class="text-danger text-bold">heure</span>(usd)
            ?</span
          >
        </label>
        <div class="row">
          <div class="col-md-8">
            <div class="fv-row">
              <InputText
                type="text"
                class="form-control mb-3 mb-lg-0"
                placeholder="0"
                              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="fv-row">
              <InputText

                type="text"

                class="form-control mb-3 mb-lg-0"
                placeholder="0"
                readOnly
              />
            </div>
          </div>
        </div>
      </div>
      <template #footer>
        <Button
          label="Annuler"
          icon="pi pi-times"
          severity="secondary"
          variant="text"
          class="p-button-text"
          @click="tVisible=false"
        />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          class="p-button-primary"
          raised
        />
      </template>
    </Dialog>
  </div>
</template>

  <script>
import { useCookie } from "@vue-composable/cookie";
// import Tagify from '@yaireo/tagify';
import { DatePicker } from "primevue";
import { computed, onMounted, reactive, ref } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import useCategories from "../../services/categoryServices.js";
import useEquipments from "../../services/equipmentService.js";
import useInstructions from "../../services/instructionServices.js";
import useMaintenances from "../../services/maintenanceService.js";
import useUsers from "../../services/userservices.js";
export default {
  components: {
    DatePicker,
    modalComponent,
  },
  setup() {
    const {
      maintenances,
      getMaintenances,
      storeMaintenance,
      updateMaintenance,
      errors,
      isLoading,
    } = useMaintenances();
    const { getUsers, users } = useUsers();
    const { getEquipments, equipments } = useEquipments();
    const { getCategories, categories, storeCategory } = useCategories();
    const {storeInstruction,deleteInstruction,getInstructions}=useInstructions ();
    const isEditMode = ref(false);
    const searchQuery = ref("");
    const showTableView = ref(false);

    const form = reactive({
      id: null,
      description: "",
      status: "pending",
      work_order: "",
      equipment_id: null,
      user_id: null,
      start_date: null,
      nbre_tacherons: 0,
      materiels: "",
      techniciens: [],
      start_date: null,
      end_date: null,
      man_hours: null,
      delay: null,
      maintenance_cost: null,
      instructions:[]
    });

    // Set default time to 00:00 for new dates
    const setDefaultTime = (dateString) => {
      if (dateString) {
        return dateString.split("T")[0] + "T00:00";
      }
      return null;
    };

    onMounted(async () => {
      await getMaintenances();
      await getUsers();
      await getEquipments();
      showTableView.value = true;
      form.start_date = setDefaultTime(new Date().toISOString());
      form.end_date = setDefaultTime(new Date().toISOString());
      var inputx = document.getElementById("technId");
      users.value.forEach((e) => {
        userList.push({ value: e.name, id: e.id });
      });
      await getCategories();
      filteredSuggestions.value = categories.value;
    });

    const submitMaintenance = async () => {
      console.log({ ...form });
      console.log("form.value");
      let success = false;
      if (isEditMode.value) {
        success = await updateMaintenance(form.id, { ...form });
      } else {
        success = await storeMaintenance({ ...form });
      }
      if (success) {
        await getMaintenances();
        $("#maintenance-modal").modal("hide");
        resetForm();
      }
    };
    const visible = ref(false);
    const addMaintenance = () => {
      isEditMode.value = false;
      visible.value = true;
      form.start_date = setDefaultTime(new Date().toISOString());
      form.end_date = setDefaultTime(new Date().toISOString());
      //   calculateDelay();
      resetForm();
    };

    const editMaintenance = (maintenance) => {
      isEditMode.value = true;
      visible.value = true;
      form.assignToType = maintenance.assigned_user_id ? 'user' : 'team';
      form.assigned_user_id = maintenance.assigned_user_id;
            form.assigned_team_id = maintenance.assigned_team_id;
      calculateDelay();
      Object.assign(form, maintenance);
    };

    const viewMaintenance = (id) => {
      const maintenanceCookie = useCookie("maintenance");
      maintenanceCookie.setCookie(id);
      location.href = `/maintenances/${id}`;
    };

    const resetForm = () => {
      form.id = null;
      form.description = "";
      form.status = "pending";
      form.work_order = "";
      form.equipment_id = null;
      form.user_id = null;
      form.start_date = setDefaultTime(new Date().toISOString());
      form.end_date = setDefaultTime(new Date().toISOString());
      form.man_hours = null;
      form.delay = null;
      form.assignToType = 'user';
      form.assigned_user_id = null;
      form.assigned_team_id = null;
      form.maintenance_cost = null;
      form.nbre_tacherons = 0;
      form.materiels = "";
      form.techniciens = [];
      form.instructions = [];
    };

    const filteredMaintenances = computed(() => {
      return maintenances.value.filter((maintenance) => {
        return (
          maintenance.description
            .toLowerCase()
            .includes(searchQuery.value.toLowerCase()) ||
          (maintenance.equipment &&
            maintenance.equipment.name
              .toLowerCase()
              .includes(searchQuery.value.toLowerCase())) ||
          maintenance.work_order
            .toLowerCase()
            .includes(searchQuery.value.toLowerCase()) ||
          maintenance.status
            .toLowerCase()
            .includes(searchQuery.value.toLowerCase()) ||
          (maintenance.user &&
            maintenance.user.name
              .toLowerCase()
              .includes(searchQuery.value.toLowerCase()))
        );
      });
    });
    const toggleView = () => {
      showTableView.value = !showTableView.value;
    };
    // Function to calculate the delay
    const calculateDelay = () => {
      if (form.start_date && form.end_date) {
        // Combine date and time into a single Date object
        let startDate = new Date(form.start_date);
        let dueDate = new Date(form.end_date);

        // Calculate the difference in milliseconds
        const timeDifference = dueDate.getTime() - startDate.getTime();

        // Calculate days, hours, and minutes
        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
          (timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.round(
          (timeDifference % (1000 * 60 * 60)) / (1000 * 60)
        );

        // Format the delay string
        let delayString = "";

        if (days > 0) {
          delayString += `${days} jour${days > 1 ? "s" : ""} `;
        }
        if (hours > 0) {
          delayString += `${hours}h `;
        }
        if (minutes > 0) {
          delayString += `${minutes}min`;
        }
        if (days === 0 && hours === 0 && minutes === 0) {
          delayString = "0 min";
        }
        form.delay = delayString.trim();
      } else {
        form.delay = null; // Reset the delay if one of the dates is missing
      }
    };
    const formatDeadline = (end_date, start_date, task) => {
      if (start_date && end_date) {
        const startDate = new Date(start_date);
        const endDate = new Date(end_date);
        const now = new Date();

        let timeDifference;
        let isPast = false;

        if (endDate.getTime() < now && task.status != "completed") {
          //   timeDifference = endDate.getTime() - now.getTime();
          isPast = true;
        } else {
          timeDifference = endDate.getTime() - startDate.getTime();
        }
        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
          (timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.round(
          (timeDifference % (1000 * 60 * 60)) / (1000 * 60)
        );

        let delayString = `${isPast ? "DeadlineExceed" : ""}`;
        if (days > 0) {
          delayString += `${days} jour${days > 1 ? "s" : ""} `;
        }
        if (hours > 0) {
          delayString += `${hours}h `;
        }
        if (minutes > 0) {
          delayString += `${minutes}min`;
        }
        if (days === 0 && hours === 0 && minutes === 0) {
          delayString = "0 min";
        }

        if (isPast) {
          return `${delayString.trim()}`;
        } else {
          return delayString.trim();
        }
      } else {
        return null;
      }
    };
    const userList = reactive([]);
    const frequencies = ref([
      { label: "Journalière", value: "daily" },
      { label: "Hebdomadaire", value: "weekly" },
      { label: "Bimestrielle", value: "bimonthly" },
      { label: "Trimestrielle", value: "quarterly" },
      { label: "Semestrielle", value: "biannual" },
      { label: "Annuelle", value: "annual" },
      { label: "Personnalisée", value: "custom" },
    ]);

    const daysOfWeek = ref([
      { label: "Lundi", value: "monday" },
      { label: "Mardi", value: "tuesday" },
      { label: "Mercredi", value: "wednesday" },
      { label: "Jeudi", value: "thursday" },
      { label: "Vendredi", value: "friday" },
      { label: "Samedi", value: "saturday" },
      { label: "Dimanche", value: "sunday" },
    ]);

    const handleFrequencyChange = () => {
      if (form.frequency !== "weekly") {
        form.daysOfWeek = [];
      }
    };
    const selectedMaterials = ref([]);
    const filteredSuggestions = ref([]);
    const search = (event) => {
      if (event.query) {
        filteredSuggestions.value = categories.value.filter((m) =>
          m.designation.toLowerCase().includes(event.query.toLowerCase())
        );
      } else {
        filteredSuggestions.value = categories.value;
      }
    };
    const selectMaterial = reactive({
        designation: "",
        unity: null,
        id:null,
        quantity:1,
    });
    const quantity = ref(0);
    const handleMaterialSelect = (e) => {
      qVisible.value = true;
      const existingMaterial = form.materials.find(
        (m) => m.id == e.value.id
      );
      if (existingMaterial) {
        selectMaterial.quantity = existingMaterial.quantity;
      } else {
        selectMaterial.quantity = 1;
      }

      selectMaterial.designation = e.value.designation;
      selectMaterial.unity = e.value.unity;
      selectMaterial.id = e.value.id;
    };
    const addMaterialToMaintenance = () => {
      const materialId = selectMaterial.id;
      if (materialId) {
        const quantity = selectMaterial.quantity;
        const existingMaterialIndex = form.materials.findIndex(
          (m) => m.id === materialId
        );
        if (existingMaterialIndex !== -1) {
          // If material already exists, update quantity
          form.materials[existingMaterialIndex].quantity = quantity;
        } else {
          // Add material to the form
          form.materials.push({
            material_id: materialId,
            quantity: quantity,
          });
        }
        // Add the material to the chips array
        const materialToAdd = categories.value.find((cat) => cat.id === materialId);
        if (materialToAdd) {
             //check if the material is already selected
            if(!selectedMaterials.value.find((e)=>e==materialToAdd.designation)){
                 selectedMaterials.value.push(materialToAdd.designation);
            }

        }
        selectMaterial.quantity = 1;
        selectMaterial.id = null;
        selectMaterial.unity = null;
        selectMaterial.designation = "";
      }
    };
    const submitQuantity = () => {
      addMaterialToMaintenance();
      hideQuantityDialog();
    };
    const hideQuantityDialog = () => {
      qVisible.value = false;
      selectMaterial.quantity = 1;
      selectMaterial.id = null;
      selectMaterial.unity = null;
      selectMaterial.designation = "";
    };
         const handleRemoveMaterial=(e)=>{
            if (materialToRemove) {
               const index = form.materials.indexOf(materialToRemove);
                if (index > -1) {
                    form.materials.splice(index, 1);
                }
            }
           selectedMaterials.value= selectedMaterials.value.filter((m)=> m !== e.value);

        }
    const closeModal = () => {
    //   visible.value = false;
      hideQuantityDialog();
    };
    const qVisible = ref(false);
    const getMaterialName = (materialId) => {
      const material = categories.value.find((m) => m.id === materialId);
      return material ? material.designation : "Matériel inconnu";
    };
    const addInstruction=()=>{
            form.instructions.push({
                description: "",
                response_type: ""
            });
        };
        const addInstructionValue=(type,value, index)=>{
        form.instructions[index][type]=value;
        console.log(form.instructions);
      }
      const removeInstruction = (index) => {
        form.instructions.splice(index, 1);
      };

    const tVisible = ref(false);
    const addTModal=()=>{
        tVisible.value = true;
    }
    return {
        tVisible,
        addTModal,
        addInstruction,
        addInstructionValue,
        removeInstruction,
        getMaterialName,
        closeModal,
        handleRemoveMaterial,
      selectMaterial,
      handleMaterialSelect,
      selectedMaterials,
      handleFrequencyChange,
      daysOfWeek,
      frequencies,
      userList,
      search,
      // setDefaultTime,
      formatDeadline,
      calculateDelay,
      toggleView,
      equipments,
      maintenances,
      form,
      addMaintenance,
      viewMaintenance,
      submitMaintenance,
      isEditMode,
      editMaintenance,
      users,
      visible,
      filteredSuggestions,

      errors,
      isLoading,
      showTableView,
      searchQuery,
      filteredMaintenances,
      qVisible,
      submitQuantity,
    };
  },
};
</script>
