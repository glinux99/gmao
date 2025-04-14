<template>
  <div class="login-page">
    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-spinner">
        <span
          class="spinner-border text-white"
          role="status"
          aria-hidden="true"
        ></span>
      </div>
    </div>

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
          <div
            class="d-flex align-items-end justify-content-end gap-2 gap-lg-3"
          >
            <!-- Toggle View Button -->
            <button
              v-if="!showTableView"
              type="button"
              class="btn btn-light btn-active-light-primary me-2"
              @click="toggleView"
            >
              <span>Vue Liste</span>
            </button>
            <!-- End Toggle View Button -->
          </div>
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
          </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <!-- Display the table view if showTableView is true -->
          <div
            v-if="showTableView"
            id="kt_app_content_container_d-none"
            class="app-container"
          >
            <div class="card card-flush p-bg-dark">
              <div class="card-body pt-0 w-100">
                <DataTable
                  class="p-column-filter p-bg-dark"
                  :value="maintenances"
                  paginator
                  :rows="10"
                  :rowsPerPageOptions="[5, 10, 25, 50]"
                  tableStyle="min-width: 50rem"
                  v-model:filters="filters"
                  filterDisplay="menu"
                  :globalFilterFields="[
                    'description',
                    'equipment.name',
                    'status',
                    'user.name',
                  ]"
                >
                  <template #header>
                    <div
                      class="d-flex align-items-center justify-content-between position-relative my-1 me-5"
                    >
                      <div>
                        <i
                          class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                        >
                          <span class="path1"></span>
                          <span class="path2"></span>
                        </i>
                        <InputText
                          type="text"
                          v-model="filters['global'].value"
                          class="form-control form-control-solid w-250px ps-13"
                          placeholder="Rechercher une maintenance"
                        />
                      </div>

                      <div>
                        <Button
                          type="button"
                          class="btn btn-light btn-active-light-primary me-2"
                          @click="toggleView"
                        >
                          <span v-if="showTableView">Vue Grille</span>
                          <span v-else>Vue Liste</span>
                        </Button>
                        <!-- End Toggle View Button -->
                        <Button
                          label="Ajouter une maintenance"
                          icon="pi pi-check"
                          severity="warn"
                          class="p-button-primary"
                          raised
                          @click="addMaintenance"
                        />
                      </div>
                    </div>
                  </template>
                  <Column
                    field="description"
                    header="Description"
                    sortable
                  ></Column>
                  <Column field="region.titre" header="Region" sortable>
                  </Column>
                  <Column field="status" header="Status" sortable>
                    <template #body="slotProps">
                      <span
                        v-if="slotProps.data.status === 'pending'"
                        class="badge badge-warning"
                        >En attente</span
                      >
                      <span
                        v-else-if="slotProps.data.status === 'in_progress'"
                        class="badge badge-info"
                        >En cours</span
                      >
                      <span
                        v-else-if="slotProps.data.status === 'completed'"
                        class="badge badge-success"
                        >Terminée</span
                      >
                      <span
                        v-else-if="slotProps.data.status === 'canceled'"
                        class="badge badge-dark"
                        >Annulée</span
                      >
                      <span v-else class="badge badge-secondary">Inconnu</span>
                    </template>
                  </Column>
                  <Column
                    field="tasks.length"
                    header="Taches"
                    sortable
                  ></Column>
                  <Column header="Budgets" sortable>
                    <template #body="slotProps">
                      <span
                        class="fs-8 badge badge-secondary"
                        v-if="slotProps.data.type != 'quarterly'"
                        >{{
                          slotProps.data.expenses.reduce(
                            (total, expense) => total + (expense.amount || 0),
                            0
                          ) *
                          (slotProps.data.tasks.length > 0
                            ? slotProps.data.tasks.length
                            : 1
                          ).toFixed(2)
                        }}
                        USD</span
                      >
                      <span class="fs-8 badge badge-secondary" v-else>
                        {{
                          (
                            slotProps.data.expenses.reduce(
                              (total, expense) => total + (expense.amount || 0),
                              0
                            ) * 1
                          ).toFixed(2)
                        }}
                        USD
                      </span>
                    </template>
                  </Column>
                  <Column header="DeadLine" sortable>
                    <template #body="slotProps">
                      <span class="fs-8">
                        Debut : {{ formatDate(slotProps.data.start_date) }}
                        <br />
                      </span>
                      <span class="fs-8 text-center">
                        <span class="badge badge-light-success">
                          {{
                            formatDeadline(
                              slotProps.data.end_date,
                              slotProps.data.start_date,
                              slotProps.data
                            )
                          }}</span
                        >
                      </span>
                    </template>
                  </Column>
                  <Column header="Actions" class="text-end">
                    <template #body="slotProps">
                      <Button
                        @click="editMaintenance(slotProps.data)"
                        class="btn btn-icon btn-active-light-primary w-30px h-30px"
                        severity="warning"
                      >
                        <i class="ki-duotone ki-pencil fs-3"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                        ></i>
                      </Button>
                      <Button
                        @click="confirmDeleteMaintenance(slotProps.data.id)"
                        severity="danger"
                        class="btn btn-icon btn-active-light-primary w-30px h-30px"
                      >
                        <i class="ki-duotone ki-trash fs-3"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                        ></i>
                      </Button>
                    </template>
                  </Column>
                </DataTable>
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
                        Buget:
                        <span class="fs-8 badge badge-secondary"
                          >{{
                            maintenance.expenses.reduce(
                              (total, expense) => total + (expense.amount || 0),
                              0
                            ) * maintenance.tasks.length
                          }}
                          USD</span
                        >
                      </div>
                      <div class="fw-bold text-gray-600 mb-5">
                        Technicien:
                        {{ maintenance.user ? maintenance.user.name : "N/A" }}
                      </div>
                      <div class="fw-bold text-gray-600 mb-5">
                        Debut : {{ formatDate(maintenance.start_date) }} <br />
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
      v-model:visible="visible"
      :style="{ width: '900px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <template #header>
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="me-4">
              {{
                isEditMode
                  ? "Modifier une Maintenance"
                  : "Créer une Maintenance"
              }}
              pour la région de
            </span>
          </div>
          <div>
            <Dropdown
              class="w-full md:w-14rem"
              :options="regions"
              v-model="form.region_id"
              optionLabel="titre"
              optionValue="id"
              placeholder="Choisissez la region"
              @change="handleChangeRegion"
            />
          </div>
        </div>
      </template>
      <Card class="bg-secondary">
        <template #content>
          <div class="row">
            <div class="col-md-6">
              <label class="col-form-label fw-bold fs-6">
                <span class="required">Désignation de la maintenance</span>
                <i
                  class="fas fa-exclamation-circle ms-1 fs-7"
                  data-bs-toggle="tooltip"
                  title="designationn de la maintenance"
                ></i>
              </label>
              <div class="fv-row">
                <InputText
                  type="text"
                  name="designation"
                  class="form-control mb-3 mb-lg-0"
                  placeholder="maintenance du transfo de la zone 17"
                  v-model="form.description"
                  required
                />
              </div>
            </div>
            <div class="col-md-6">
              <label class="col-form-label fw-bold fs-6">
                <span class="">Type de maintenance</span>
                <i
                  class="fas fa-exclamation-circle ms-1 fs-7"
                  data-bs-toggle="tooltip"
                  title="choisir un type de maintenance"
                ></i>
              </label>
              <Dropdown
                @change="toggleTypeMaintenance"
                v-model="form.type"
                :options="typeMaintenance"
                optionLabel="label"
                optionValue="value"
                placeholder="Sélectionner le type de maintenance"
                class="w-full md:w-14rem w-100"
              />
            </div>
            <div class="col-md-6" v-if="form.type == 'equipment'">
              <label class="col-form-label fw-bold fs-6">
                <span class="required">Equipement</span>
                <i
                  class="fas fa-exclamation-circle ms-1 fs-7"
                  data-bs-toggle="tooltip"
                  title="equipement"
                ></i>
              </label>
              <div class="fv-row">
                <InputGroup>
                  <Dropdown
                    v-model="form.equipment_id"
                    :options="equipments"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Sélectionner un equipment"
                    class="w-full md:w-14rem"
                  />
                  <Button
                    icon="pi pi-plus"
                    severity="warn"
                    @click="addEquipment"
                  ></Button>
                </InputGroup>
              </div>
            </div>
          </div>
        </template>
      </Card>
      <Card class="mt-2 bg-secondary" v-if="form.type == 'equipment'">
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
                <label class="required fw-semibold fs-6 mb-2 d-block"
                  >Technicien</label
                >
                <Dropdown
                  v-model="form.assigned_user_id"
                  :options="users"
                  optionLabel="name"
                  optionValue="id"
                  :filter="true"
                  filterBy="name,post_name,nickname, email"
                  placeholder="Sélectionner un technicien"
                  class="w-full md:w-14rem w-100"
                />
              </div>
              <div v-else-if="form.assignToType === 'team'" class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2 d-block"
                  >Équipe</label
                >
                <Dropdown
                  v-model="form.assigned_team_id"
                  :options="teams"
                  :filter="true"
                  filterBy="name"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="Sélectionner une équipe"
                  class="w-full md:w-14rem w-100"
                />
              </div>
            </div>
            <div class="col-md-2">
              <label class="fw-semibold fs-6 mb-2">
                <span class="">Tâcherons</span>
              </label>
              <div class="fv-row">
                <InputText
                  type="number"
                  class="w-full md:w-14rem w-100"
                  placeholder=""
                  v-model="form.nbre_tacherons"
                  @change="addTModal"
                  required
                />
              </div>
            </div>
            <span v-if="form.nbre_tacherons" class="fw-bold">Note:</span>
            <span
              class="text-danger"
              v-if="
                form.nbre_tacherons > 0 &&
                (form.price_tacherons == 0 || form.price_tacherons == null)
              "
            >
              Vous n'avez pas encore founis le prix par heure d'un
              tâcherons!!</span
            >
            <span v-if="form.nbre_tacherons > 0 && form.price_tacherons > 0"
              >Pour ces {{ form.nbre_tacherons }} tâcherons, le prix est de
              {{ (form.nbre_tacherons * form.price_tacherons).toFixed(2) }} usd
              / heure</span
            >
          </div>
          <!-- Conditional rendering for user/team selection -->
        </template>
      </Card>
      <Card class="mt-2 bg-secondary">
        <template #title> Programmation </template>
        <template #content>
          <div class="row">
            <div class="col-md-6">
              <label class="col-form-label fw-bold fs-6 d-block">
                <span>Fréquence</span>
              </label>
              <Dropdown
                v-model="form.frequency"
                :options="frequencies"
                optionLabel="label"
                optionValue="value"
                placeholder="Sélectionner la fréquence"
                class="w-full md:w-14rem w-100"
                @change="handleFrequencyChange"
              />
            </div>
            <div class="col-md-6" v-if="form.frequency === 'weekly'">
              <label class="col-form-label fw-bold fs-6 d-block">
                <span>Jour de la semaine</span>
              </label>
              <MultiSelect
                v-model="form.daysOfWeek"
                :options="daysOfWeek"
                optionLabel="label"
                optionValue="value"
                placeholder="Sélectionner les jours"
                class="w-full md:w-14rem w-100"
              />
            </div>

            <div class="col-md-6">
              <label class="fw-bold fs-6 col-form-label d-block"
                >Date de debut</label
              >
              <Calendar
                v-model="form.start_date"
                showTime
                hourFormat="24"
                class="w-full md:w-14rem w-100"
                placeholder="Date de debut"
                required
              />
            </div>
            <div class="col-md-6">
              <label class="fw-bold fs-6 col-form-label d-block"
                >Date de fin</label
              >
              <Calendar
                v-model="form.end_date"
                dateFormat="yy-mm-dd"
                showTime
                hourFormat="24"
                class="w-full md:w-14rem w-100"
                placeholder="Date de fin"
                required
              />
            </div>
            <div class="col-md-3" v-if="form.frequency != 'daily'">
              <label class="fw-bold fs-6 col-form-label d-block"
                >Heure/jour</label
              >
              <InputText
                type="number"
                class="w-full md:w-14rem w-100"
                placeholder="0"
                v-model="form.man_hours"
                @input="updateTacheronsExpense"
              />
            </div>
            <div class="col-md-3">
              <label class="fw-bold fs-6 col-form-label d-block"
                >Rappel(jours)</label
              >
              <InputText
                type="number"
                class="w-full md:w-14rem w-100"
                placeholder="0"
                v-model="form.rappel"
                @input="updateTacheronsExpense"
              />
            </div>
          </div>
        </template>
      </Card>
      <Card class="bg-secondary mt-2" v-if="form.type == 'equipment'">
        <template #title>Matériels à utiliser</template>
        <template #content>
          <div class="row">
            <div class="col-md-12">
              <label class="col-form-label fw-bold fs-6">Matériel</label>

              <InputGroup>
                <AutoComplete
                  v-model="form.materials"
                  class="w-full md:w-14rem"
                  placeholder="Rechercher un matériel"
                  :suggestions="filteredSuggestions"
                  @complete="search"
                  field="designation"
                  :optionLabel="
                    (materiel) => {
                      const caracteristique = materiel.caracteristique
                        ? `(${materiel.caracteristique})`
                        : '';
                      return `${materiel.designation ?? ''} ${caracteristique}`;
                    }
                  "
                  optionValue="id"
                  @item-select="handleMaterialSelect"
                  multiple
                />
                <Button
                  icon="pi pi-plus-circle"
                  @click="addMateriels"
                  severity="warn"
                  class="p-button-primary"
                />
              </InputGroup>
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
                class="list-group-item"
              >
                <div class="row">
                  <div class="col-md-6">
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
      <Card class="bg-secondary mt-2" v-if="form.type == 'quarterly'">
        <template #content>
          <div class="fv-row mb-7 fv-plugins-icon-container">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold ms-5">
                {{
                  form.tasks.length > 1
                    ? `${form.tasks.length} Tâches`
                    : `${form.tasks.length} Tâche`
                }}
                à éffectuer lors de la maintenance trimestriel</span
              >
              <Button
                label="Ajouter une tâche"
                icon="pi pi-plus-circle flex"
                @click="addTask"
                severity="warn"
                class="p-button-primary"
              >
              </Button>
            </div>
            <div class="my-1 border rounded">
              <Accordion :multiple="true"
                :value="x"
                expandIcon="pi pi-plus"
                collapseIcon="pi pi-minus"
              >
                <AccordionPanel :value="index"
                  v-for="(task, index) in form.tasks"
                  :key="index"
                >
                  <AccordionHeader>
                    <div
                      class="d-flex flex-row align-items-center justify-content-between w-full w-100"
                    >
                      <span class="flex items-center gap-2">
                        <div
                          class="font-bold whitespace-nowrap"
                          v-if="task.assigned_team_id != null"
                        >
                          Equipe de
                          {{ getAssingedTeamName(task.assigned_team_id) }}
                        </div>
                        <div class="font-bold whitespace-nowrap" v-else>
                          {{ getAssingedName(task.assigned_user_id) }}
                        </div>
                        <div class="fs-9 my-2">
                          <Badge :value="task.instructions.length" class="" />
                          Instruction{{    `${task.instructions.length> 1 ? 's': ''}` }}
                        </div>
                      </span>
                      <span>
                        <Button
                          icon="pi pi-pencil"
                          @click="editTask(task)"
                          severity="warn"
                          class="me-5"
                      /></span>
                    </div>
                  </AccordionHeader>
                  <AccordionContent >
                    <div
                      v-for="(instruction, i) in task.instructions"
                      :key="i"
                      class="border rounded  py-5 ps-2"
                    >
                      <div
                        class="d-flex justify-content-between align-items-center"
                      >
                        <label class="fw-bold">Instruction {{ i + 1 }}</label>
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
                              taddInstructionValue(
                                'description',
                                instruction.description,
                                i,
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
                              taddInstructionValue(
                                'response_type',
                                instruction.response_type,
                                i,
                                index
                              )
                            "
                          />
                        </div>
                        <div
                          class="col-md-1 d-flex align-items-center justify-content-start"
                          @click="tremoveInstruction(i, index)"
                        >
                          <Button icon="pi pi-trash" severity="danger">

                          </Button>
                        </div>
                      </div>
                    </div>
                  </AccordionContent>
                </AccordionPanel>
              </Accordion>
            </div>
          </div>
        </template>
      </Card>
      <Card class="bg-secondary mt-2">
        <template #title> Dépenses </template>
        <template #content>
          <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-end">
              <Button
                label="Ajouter une dépense"
                icon="pi pi-plus-circle"
                @click="addExpense"
                severity="success"
              />
            </div>
          </div>

          <div
            v-for="(expense, index) in form.expenses"
            :key="index"
            class="row mb-3 align-items-center"
          >
            <div class="col-md-5">
              <InputText
                type="text"
                placeholder="Titre de la dépense"
                v-model="expense.title"
                @input="updateExpenseData(index, 'title', expense.title)"
                class="w-full w-100"
                :readonly="expense.readonly ? true : false"
              />
            </div>
            <div class="col-md-5">
              <InputNumber
                v-model="expense.amount"
                mode="currency"
                currency="USD"
                locale="fr-FR"
                placeholder="Montant"
                @input="updateExpenseData(index, 'amount', expense.amount)"
                class="w-full w-100"
                :readonly="expense.readonly ? true : false"
              >
                <template #incrementbuttonicon></template>
              </InputNumber>
            </div>
            <div class="col-md-2 d-flex justify-content-center">
              <Button
                v-if="!expense.readonly"
                icon="pi pi-trash"
                severity="danger"
                @click="removeExpense(index)"
              />
            </div>
          </div>

          <div class="row mt-4" v-if="form.expenses.length > 0">
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Total des dépenses:</h4>
                <span class="fs-4 text-success fw-bold"
                  >{{
                    form.expenses.reduce(
                      (total, expense) => total + (expense.amount || 0),
                      0
                    ).toFixed(2)
                  }}
                  USD</span
                >
              </div>
            </div>
          </div>
        </template>
      </Card>

      <Card class="bg-secondary mt-2" v-if="form.type == 'equipment'">
        <template #content>
          <div class="fv-row mb-7 fv-plugins-icon-container">
            <div class="d-flex justify-content-end">
              <Button
                label="Ajouter une instruction"
                icon="pi pi-plus-circle"
                @click="addInstruction"
                severity="warn"
                class="p-button-primary"
              >
              </Button>
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
                <Button icon="pi pi-trash" severity="danger">

                    </Button>
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
          @click="visible = false"
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
      :header="qEditMode ? 'Modifier une la quantité' : 'Ajouter une quantité'"
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
      :header="
        isEditMode
          ? 'Modifier le paiement de tâcherons'
          : 'Ajouter un paiement de tâcherons'
      "
      v-model:visible="ttVisible"
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
            >Quelle est le montant sera donné à un tâcheron par
            <span class="text-danger text-bold">heure</span>(usd) pour la tache
            ?</span
          >
        </label>
        <div class="row">
          <div class="col-md-8">
            <div class="fv-row">
              <InputGroup class="md:w-80">
                <InputGroupAddon>
                  <i class="pi pi-users"></i>
                </InputGroupAddon>
                <IftaLabel>
                  <InputNumber
                    v-model="selectedTask.price_tacherons"
                    inputId="Price"
                    mode="currency"
                    currency="USD"
                    locale="fr-FR"
                  />
                  <label for="price">Prix par heure</label>
                </IftaLabel>
              </InputGroup>
            </div>
          </div>
          <div class="col-md-4">
            <div class="fv-row">
              <InputGroup>
                <IftaLabel>
                  <InputText
                    class="w-100"
                    v-model="tacheronsForm"
                    readOnly
                    id="username"
                    :value="
                      selectedTask.nbre_tacherons * selectedTask.price_tacherons
                    "
                    variant="filled"
                  />
                  <label for="username">Total</label>
                </IftaLabel>
                <InputGroupAddon>USD</InputGroupAddon>
              </InputGroup>
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
          @click="ttVisible = false"
        />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          class="p-button-primary"
          @click="ttVisible = false"
          raised
        />
      </template>
    </Dialog>
    <Dialog
      :id="id"
      :header="
        isEditMode
          ? 'Modifier le paiement de tâcherons'
          : 'Ajouter un paiement de tâcherons'
      "
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
            >Quelle est le montant sera donné à un tâcheron par
            <span class="text-danger text-bold">heure</span>(usd) ?</span
          >
        </label>
        <div class="row">
          <div class="col-md-8">
            <div class="fv-row">
              <InputGroup class="md:w-80">
                <InputGroupAddon>
                  <i class="pi pi-users"></i>
                </InputGroupAddon>
                <IftaLabel>
                  <InputNumber
                    v-model="form.price_tacherons"
                    inputId="Price"
                    mode="currency"
                    currency="USD"
                    locale="fr-FR"
                  />
                  <label for="price">Prix par heure</label>
                </IftaLabel>
              </InputGroup>
            </div>
          </div>
          <div class="col-md-4">
            <div class="fv-row">
              <InputGroup>
                <IftaLabel>
                  <InputText
                    class="w-100"
                    readOnly
                    id="username"
                    :value="form.nbre_tacherons * form.price_tacherons"
                    variant="filled"
                  />
                  <label for="username">Total</label>
                </IftaLabel>
                <InputGroupAddon>USD</InputGroupAddon>
              </InputGroup>
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
          @click="tVisible = false"
        />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          class="p-button-primary"
          @click="tVisible = false"
          raised
        />
      </template>
    </Dialog>
    <Dialog
      :header="eisEditMode ? 'Modifier un équipement' : 'Créer un équipement'"
      v-model:visible="eVisible"
      :style="{ width: '700px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <div
        class="d-flex flex-column scroll-y px-5 px-lg-10"
        id="kt_modal_add_user_scroll"
        data-kt-scroll="true"
        data-kt-scroll-activate="true"
        data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_modal_add_user_header"
        data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
        data-kt-scroll-offset="300px"
      >
        <div class="row mb-6">
          <div class="col-md-6">
            <label class="required fw-semibold fs-6 mb-2">Nom</label>
            <InputText
              type="text"
              name="name"
              class="form-control mb-3 mb-lg-0"
              placeholder="Nom de l'équipement"
              v-model="eform.name"
              required
            />
          </div>
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2">N° Série</label>
            <InputText
              type="text"
              name="serial_number"
              class="form-control mb-3 mb-lg-0"
              placeholder="Numéro de série"
              v-model="eform.serial_number"
            />
          </div>
        </div>
        <div class="row mb-6">
          <div class="col-md-6">
            <label class="required fw-semibold fs-6 mb-2 d-block">Status</label>
            <Dropdown
              aria-label="Status"
              class="w-full md:w-14rem w-100"
              v-model="eform.status"
              :options="statusOptions"
              optionLabel="label"
              optionValue="value"
            />
          </div>
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2">Description</label>
            <InputText
              type="text"
              name="description"
              class="form-control mb-3 mb-lg-0"
              placeholder="Description"
              v-model="eform.description"
            />
          </div>
        </div>
        <div class="row mb-6">
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2 d-block">Projet</label>
            <Dropdown
              class="w-full md:w-14rem w-100"
              aria-label="project"
              v-model="eform.project_id"
              :options="projects"
              optionLabel="name"
              optionValue="id"
              placeholder="Sélectionner un projet"
            />
          </div>
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2 d-block">Utilisateur</label>
            <Dropdown
              class="w-full md:w-14rem w-100"
              aria-label="user"
              v-model="eform.user_id"
              :options="users"
              :optionLabel="
                (user) =>
                  `${user.name ?? ''} ${user.post_name ?? ''}  ${
                    user.nickname ?? ''
                  }`
              "
              optionValue="id"
              placeholder="Sélectionner un utilisateur"
            />
          </div>
        </div>
        <div class="row mb-6">
          <div class="col-md-3">
            <label class="fw-semibold fs-6 mb-2">Date d'achat</label>
            <Calendar
              type="date"
              name="purchase_date"
              class="w-100"
              v-model="eform.purchase_date"
            />
          </div>
          <div class="col-md-3">
            <label class="fw-semibold fs-6 mb-2">Garantie</label>
            <Calendar
              view="year"
              dateFormat="yy"
              class="w-100"
              v-model="eform.warranty_end_date"
            />
          </div>
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2">Prix d'achat</label>
            <InputGroup class="md:w-80">
              <IftaLabel>
                <InputNumber
                  ca
                  v-model="eform.purchase_price"
                  inputId="Price"
                  mode="currency"
                  currency="USD"
                  locale="fr-FR"
                />
                <label for="price">Prix d'achat</label>
              </IftaLabel>
              <InputGroupAddon>
                <i class="pi pi-shopping-cart"></i>
              </InputGroupAddon>
            </InputGroup>
          </div>
        </div>
      </div>
      <template #footer>
        <Button
          label="Annuler"
          icon="pi pi-times"
          class="p-button-text"
          @click="eVisible = false"
        />
        <Button
          label="Enregistrer"
          severity="warn"
          icon="pi pi-check"
          class="p-button-primary"
          @click="submitEquipment"
        />
      </template>
    </Dialog>
    <Dialog
      :header="cEditMode ? 'Modifier une catégorie' : 'Ajouter une catégorie'"
      v-model:visible="mVisible"
      :style="{ width: '700px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <div class="p-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="field">
              <label
                class="required fw-semibold fs-6 mb-2 d-block"
                for="designation"
                >Designation</label
              >
              <InputText
                id="designation"
                type="text"
                placeholder="Designation de la catégorie"
                v-model="mform.designation"
                class="w-full w-100"
                required
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="field">
              <label class="fw-semibold fs-6 mb-2 d-block" for="caracteristique"
                >Caractéristiques</label
              >
              <InputText
                id="caracteristique"
                type="text"
                placeholder="Caracteristique de la catégorie"
                v-model="mform.caracteristique"
                class="w-full w-100"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="field">
              <label class="fw-semibold fs-6 mb-2 d-block" for="unity"
                >Unité</label
              >
              <Dropdown
                id="unity"
                v-model="mform.unity_id"
                :options="unities"
                optionLabel="designation"
                optionValue="id"
                placeholder="Selectionner une unité..."
                class="w-full w-100"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="field">
              <label class="fw-semibold fs-6 mb-2 d-block" for="type"
                >Type d'équipement</label
              >
              <Dropdown
                id="type"
                v-model="mform.type"
                :options="typeOptions"
                optionLabel="label"
                optionValue="value"
                placeholder="Selectionner un type..."
                class="w-full w-100"
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-checkbox my-2">
              <Checkbox
                id="is_remise"
                v-model="mform.is_remise"
                :binary="true"
              />
              <label for="is_remise" class="ml-2 me-3"
                >A remettre au magasin?</label
              >
            </div>
          </div>
        </div>
      </div>
      <template #footer>
        <Button label="Annuler" icon="pi pi-times" @click="mVisible = false" />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          @click="submitCategory"
        />
      </template>
    </Dialog>
    <Dialog
      :id="id"
      :header="tEditMode ? 'Modifier une Tâche' : 'Créer une Tâche'"
      v-model:visible="taskVisible"
      :style="{ width: '800px' }"
      position="center"
      :modal="true"
      :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
      @hide="closeModal"
      :closable="true"
    >
      <template #header>
        {{ tEditMode ? "Modifier" : "Créer" }} une Tâche
      </template>
      <div class="d-flex flex-column scroll-y px-3 px-lg-5">
        <Card class="bg-secondary">
          <template #content>
            <div class="row">
              <div class="fv-row fv-plugins-icon-container col-md-6 col-md-6">
                <label class="required fw-semibold fs-6 mb-2"
                  >Description</label
                >
                <InputText
                  type="text"
                  name="designation"
                  class="form-control mb-3 mb-lg-0"
                  placeholder="Perte de puissance signalée"
                  v-model="selectedTask.description"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row fv-plugins-icon-container col-md-6">
                <label class="required fw-semibold fs-6 mb-2 d-block"
                  >Responsable</label
                >
                <Dropdown
                  v-model="selectedTask.owner"
                  :options="users"
                  :optionLabel="
                    (user) =>
                      `${user.name ?? ''} ${user.post_name ?? ''}  ${
                        user.nickname ?? ''
                      }`
                  "
                  optionValue="id"
                  placeholder="Sélectionner un responsable"
                  class="w-full md:w-14rem w-100"
                  :filter="true"
                  filterBy="name,post_name,nickname, email"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="col-md-6">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2">
                  <span class="">Status</span>
                </label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="fv-row">
                  <Dropdown
                    v-model="selectedTask.status"
                    :options="[
                      { name: 'En attente', value: 'pending' },
                      { name: 'En cours', value: 'in_progress' },
                      { name: 'Terminée', value: 'completed' },
                      { name: 'Annulée', value: 'canceled' },
                    ]"
                    optionLabel="name"
                    optionValue="value"
                    placeholder="Sélectionner un status"
                    class="w-full md:w-14rem w-100"
                  />
                </div>
                <!--end::Col-->
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                <label class="required fw-semibold fs-6 mb-2 d-block"
                  >Priorité</label
                >
                <Dropdown
                  v-model="selectedTask.priority_id"
                  :options="priorities"
                  optionLabel="title"
                  optionValue="id"
                  placeholder="Sélectionner une priorité"
                  class="w-full md:w-14rem w-100"
                  required
                />
              </div>
            </div>
          </template>
        </Card>

        <div class="row">
          <div class="col-md-6" v-if="projects.length">
            <div class="my-6">
              <label class="col-form-label fw-bold fs-6">
                <span class="required">Projet</span>
                <i
                  class="fas fa-exclamation-circle ms-1 fs-7"
                  data-bs-toggle="tooltip"
                  title="categorie"
                ></i>
              </label>
              <div class="fv-row">
                <Dropdown
                  v-model="selectedTask.project_id"
                  :options="projects"
                  optionLabel="name"
                  optionValue="id"
                  placeholder="Sélectionner un projet"
                  class="w-full md:w-14rem"
                />
              </div>
            </div>
          </div>
        </div>
        <Card class="mt-2 bg-secondary mb-2">
          <template #title> Assigner à </template>

          <template #content>
            <div class="fv-row fv-plugins-icon-container row">
              <div class="col-md-4">
                <div class="form-check form-check-custom form-check-solid mb-3">
                  <RadioButton
                    id="opt1"
                    inputId="assignToUser"
                    value="user"
                    v-model="selectedTask.assignToType"
                    name="assignToType"
                    @change="handleOptionChange(selectedTask.assignToType)"
                  />
                  <label class="form-check-label" for="assignToUser">
                    Technicien
                  </label>
                </div>
                <div class="form-check form-check-custom form-check-solid">
                  <RadioButton
                    id="opt2"
                    inputId="assignToTeam"
                    value="team"
                    v-model="selectedTask.assignToType"
                    name="assignToType"
                    @change="handleOptionChange(selectedTask.assignToType)"
                  />
                  <label class="form-check-label" for="assignToTeam">
                    Équipe
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div
                  v-if="selectedTask.assignToType === 'user'"
                  class="fv-row mb-7"
                >
                  <label class="required fw-semibold fs-6 mb-2 d-block"
                    >Technicien</label
                  >
                  <Dropdown
                    v-model="selectedTask.assigned_user_id"
                    :options="users"
                    optionLabel="name"
                    optionValue="id"
                    :filter="true"
                    filterBy="name,post_name,nickname, email"
                    placeholder="Sélectionner un technicien"
                    class="w-full md:w-14rem w-100"
                  />
                </div>
                <div
                  v-else-if="selectedTask.assignToType === 'team'"
                  class="fv-row mb-7"
                >
                  <label class="required fw-semibold fs-6 mb-2 d-block"
                    >Équipe</label
                  >
                  <Dropdown
                    v-model="selectedTask.assigned_team_id"
                    :options="teams"
                    :filter="true"
                    filterBy="name"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Sélectionner une équipe"
                    class="w-full md:w-14rem w-100"
                  />
                </div>
              </div>
              <div class="col-md-2">
                <label class="fw-semibold fs-6 mb-2">
                  <span class="">Tâcherons</span>
                </label>
                <div class="fv-row">
                  <InputText
                    type="number"
                    class="w-full md:w-14rem w-100"
                    placeholder=""
                    v-model="selectedTask.nbre_tacherons"
                    @change="taddTModal"
                    required
                  />
                </div>
              </div>
              <span v-if="selectedTask.nbre_tacherons" class="fw-bold"
                >Note:</span
              >
              <span
                class="text-danger"
                v-if="
                  selectedTask.nbre_tacherons > 0 &&
                  (selectedTask.price_tacherons == 0 ||
                    selectedTask.price_tacherons == null)
                "
              >
                Vous n'avez pas encore founis le prix par heure d'un
                tâcherons!!</span
              >
              <span
                v-if="
                  selectedTask.nbre_tacherons > 0 &&
                  selectedTask.price_tacherons > 0
                "
                >Pour ces {{ selectedTask.nbre_tacherons }} tâcherons, le prix
                est de
                {{
                  (
                    selectedTask.nbre_tacherons * selectedTask.price_tacherons
                  ).toFixed(2)
                }}
                usd / heure</span
              >
            </div>
            <!-- Conditional rendering for user/team selection -->
          </template>
        </Card>
        <Card class="mt-2 bg-secondary mb-2">
          <template #title> Assigner un vehicule à </template>

          <template #content>
            <div class="row">
              <div class="fv-row mb-7 col-md-6">
                <label class="required fw-semibold fs-6 mb-2 d-block"
                  >Choisir un engin roulant</label
                >

                <Dropdown
                  v-model="selectedTask.engin_id"
                  :options="engins"
                  optionLabel="name"
                  optionValue="id"
                  :filter="true"
                  filterBy="name"
                  placeholder="Sélectionner un vehicule"
                  class="w-full md:w-14rem w-100"
                />
              </div>
              <div class="fv-row mb-7 col-md-6">
                <label class="required fw-semibold fs-6 mb-2 d-block"
                  >Prix Unitaire par techniciens</label
                >
                <InputNumber
                  v-model="selectedTask.price_technicien"
                  mode="currency"
                  currency="USD"
                  locale="fr-FR"
                  placeholder="Montant"
                  class="w-full w-100"
                >
                  <template #incrementbuttonicon></template>
                </InputNumber>
              </div>
            </div>
          </template>
        </Card>

        <Card class="bg-secondary">
          <template #content>
            <div class="fv-row mb-7 fv-plugins-icon-container">
              <div class="d-flex justify-content-end">
                <Button
                  label="Ajouter une instruction"
                  icon="pi pi-plus-circle"
                  @click="addInstructionToTask"
                  severity="warn"
                  class="p-button-primary"
                />
              </div>
              <div
                v-for="(instruction, index) in selectedTask.instructions"
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
                        addInstructionValueToTask(
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
                        addInstructionValueToTask(
                          'response_type',
                          instruction.response_type,
                          index
                        )
                      "
                    />
                  </div>
                  <div
                    class="col-md-1 d-flex align-items-start justify-content-start"
                    @click="removeInstructionFromTask(index)"
                  >
                  <Button icon="pi pi-trash" severity="danger">
                    </Button>
                  </div>
                </div>
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

                <InputGroup>
                  <AutoComplete
                    v-model="selectedTask.materials"
                    class="w-full md:w-14rem"
                    placeholder="Rechercher un matériel"
                    :suggestions="filteredSuggestions"
                    @complete="search"
                    field="designation"
                    :optionLabel="
                      (materiel) => {
                        const caracteristique = materiel.caracteristique
                          ? `(${materiel.caracteristique})`
                          : '';
                        return `${
                          materiel.designation ?? ''
                        } ${caracteristique}`;
                      }
                    "
                    optionValue="id"
                    @item-select="handleMaterialSelect"
                    multiple
                  />
                  <Button
                    icon="pi pi-plus-circle"
                    @click="addMateriels"
                    severity="warn"
                    class="p-button-primary"
                  />
                </InputGroup>
              </div>
            </div>
            <div class="mt-4">
              <label class="col-form-label fw-bold fs-6">
                Matériels ajoutés
              </label>
              <ul class="list-group">
                <li
                  v-for="(material, index) in selectedTask.materials"
                  :key="index"
                  class="list-group-item"
                >
                  <div class="row">
                    <div class="col-md-6">
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
                        @click="thandleRemoveMaterial(index)"
                      />
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </template>
        </Card>
      </div>
      <template #footer>
        <Button
          label="Annuler"
          icon="pi pi-times"
          severity="secondary"
          variant="text"
          class="p-button-text"
          @click="taskVisible = false"
        />
        <Button
          label="Enregistrer"
          icon="pi pi-check"
          severity="warn"
          class="p-button-primary"
          raised
          @click="submitTask()"
        />
      </template>

    </Dialog>
    <Toast />
    <ConfirmDialog></ConfirmDialog>
  </div>
</template>

    <script>
import { useCookie } from "@vue-composable/cookie";
// import Tagify from '@yaireo/tagify';
import { FilterMatchMode } from "@primevue/core/api";
import { DatePicker, useConfirm } from "primevue";
import { useToast } from 'primevue/usetoast';
import { computed, onMounted, reactive, ref, watch } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import useCategories from "../../services/categoryServices.js";
import useEngins from "../../services/enginServices.js";
import useEquipments from "../../services/equipmentService.js";
import useInstructions from "../../services/instructionServices.js";
import useMaintenances from "../../services/maintenanceService.js";
import usePriorities from "../../services/priorityServices.js";
import useProjects from "../../services/projectServices.js";
import useRegion from "../../services/regionServices.js";
import useTeams from "../../services/teamServices.js";
import useUnities from "../../services/unityServices";
import useUsers from "../../services/userservices.js";
export default {
  components: {
    DatePicker,
    modalComponent,
  },
  setup() {
    const { getRegions, regions } = useRegion();
    const toast = useToast();
    const {
      maintenances,
      getMaintenances,
      storeMaintenance,
      updateMaintenance,
      destroyMaintenace,
      errors,
    } = useMaintenances();
    const { getEngins, engins } = useEngins();
    const { teams, getTeams } = useTeams();
    const { getUsers, users } = useUsers();
    const { getEquipments, equipments, storeEquipment, updateEquipment } =
      useEquipments();
    const { getCategories, categories, storeCategory } = useCategories();
    const { storeInstruction, deleteInstruction, getInstructions } =
      useInstructions();
    const isEditMode = ref(false);
    const tEditMode = ref(false);
    const cEditMode = ref(false);
    const qEditMode = ref(false);
    const eisEditMode = ref(false);
    const searchQuery = ref("");
    const showTableView = ref(false);
    const isLoading = ref(true);
    const form = reactive({
      id: null,
      description: "",
      region_id: null,
      status: "pending",
      work_order: "",
      equipment_id: null,
      user_id: null,
      start_date: null,
      nbre_tacherons: 0,
      man_hours: 8,
      price_technicien: 2.92,
      materials: [],
      techniciens: [],
      start_date: null,
      end_date: null,
      man_hours: null,
      delay: null,
      maintenance_cost: null,
      instructions: [],
      expenses: [],
      totalExpenses: 0,
      rappel: 7,
      type: "equipment",
      tasks: [],
    });

    // Set default time to 00:00 for new dates
    const setDefaultTime = (dateString) => {
      if (dateString) {
        return dateString.split("T")[0] + "T00:00";
      }
      return null;
    };
    const { getUnities, unities } = useUnities();

    onMounted(async () => {

      form.type = "equipment";
      await getMaintenances();
      await getUsers();

      await getEquipments();
      await getUnities();
      await getTeams();
      await initTask();
      await getRegions();
      await getEngins();
      showTableView.value = true;
      form.start_date = setDefaultTime(new Date().toISOString());
      form.end_date = setDefaultTime(new Date().toISOString());
      var inputx = document.getElementById("technId");
      users.value.forEach((e) => {
        userList.push({ value: e.name, id: e.id });
      });
      await getCategories();
      //   expenses.expenses=maintenances.value.expenses;
    //   console.log(maintenances);
      filteredSuggestions.value = categories.value;
      isLoading.value = false;
    });
    const confirm = useConfirm();
    const submitMaintenance = async () => {
      // form.expenses= expenses.expenses;
      isLoading.value = true; // Show loading
      const depenses=ref(0);
    //   form.tasks.forEach((e)=>{
    //         depenses.value+=e.
    //   });
    //   form.expenses=form.expenses.filter((e) => e.title != "Coût de techniciens");
    //   console.log({ ...form });
    //   console.log("form.value");
      let success = false;
      if (isEditMode.value) {
        success = await updateMaintenance(form.id, { ...form });
      } else {
        // console.log({...form});
        success = await storeMaintenance({ ...form });
      }
    //   console.log(errors.value);
      if (!success) {
        // Check if there are specific errors
        if (Object.keys(errors.value).length > 0) {
          // Display specific errors in the toast
          let errorDetails = "";
          for (const field in errors.value) {
            errorDetails += `${field} : ${errors.value[field][0]} \n`;
          }
          errorDetails = errorDetails;
          toast.add({
            severity: "error",
            summary: "Validation Error",
            detail: errorDetails,
            life: 10000,
            escape: false, // Allow HTML in the detail
          });
        } else {
          // Display a generic error message
          toast.add({
            severity: "error",
            summary: "Error",
            detail: "An unexpected error occurred!",
            life: 3000,
          });
        }
      } else {
        toast.add({
          severity: "success",
          summary: "Success",
          detail: "La maintenance a été configuré avec success!",
          life: 3000,
        });
        await getMaintenances();
        visible.value = false;
        resetForm();
      }

      isLoading.value = false; // Show loading

    };
    const visible = ref(false);
    const addMaintenance = () => {

      isEditMode.value = false;
      visible.value = true;
      form.start_date = setDefaultTime(new Date().toISOString());
      form.end_date = setDefaultTime(new Date().toISOString());
      form.tasks = [];
      regions.value.push({
        id: null,
        titre: "Toutes les regions",
      });
      //   calculateDelay();
      resetForm();
    };

    const editMaintenance = (maintenance) => {
      form.tasks = [];
      isEditMode.value = true;
      visible.value = true;
      form.assignToType = maintenance.assigned_user_id ? "user" : "team";
      form.assigned_user_id = maintenance.assigned_user_id;
      form.assigned_team_id = maintenance.assigned_team_id;

      calculateDelay();
    //   console.log({ ...form });
    //   console.log({ ...maintenance });
      Object.assign(form, maintenance);
    //   console.log({ ...form });
    };

    const viewMaintenance = (id) => {
      const maintenanceCookie = useCookie("maintenance");
      maintenanceCookie.setCookie(id);
      location.href = `/maintenances/${id}`;
    };

    const resetForm = () => {
      form.type = "equipment";
      form.id = null;
      form.price_technicien = 2.92;
      form.description = "";
      form.status = "pending";
      form.region_id = null;
      form.work_order = "";
      form.equipment_id = null;
      form.user_id = null;
      form.start_date = setDefaultTime(new Date().toISOString());
      form.end_date = setDefaultTime(new Date().toISOString());
      form.man_hours = 8;
      form.delay = null;
      form.assignToType = "user";
      form.assigned_user_id = null;
      form.assigned_team_id = null;
      form.maintenance_cost = null;
      form.nbre_tacherons = 0;
      form.materials = [];
      form.techniciens = [];
      form.instructions = [];
      form.expenses = [];
      form.totalExpenses = 0;
      form.rappel = 7;
    };

    const filteredMaintenances = computed(() => {
      return maintenances.value.filter((maintenance) => {
        return (
          (maintenance.equipment &&
            maintenance.equipment.name.includes(
              searchQuery.value.toLowerCase()
            )) ||
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
      id: null,
      quantity: 1,
    });
    const quantity = ref(0);
    const handleMaterialSelect = (e) => {
      qVisible.value = true;
      qEditMode.value = false;
      const existingMaterial = form.materials.find((m) => m.id == e.value.id);
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
        const existingMaterialIndex2 = selectedTask.materials.findIndex(
          (m) => m.id === materialId
        );
        if (existingMaterialIndex2 == -1) {
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
        }
        if (existingMaterialIndex2 !== -1) {
          // If material already exists, update quantity
          selectedTask.materials[existingMaterialIndex2].quantity = quantity;
        } else {
          // Add material to the form
          selectedTask.materials.push({
            material_id: materialId,
            quantity: quantity,
          });
        }
        // Add the material to the chips array
        const materialToAdd = categories.value.find(
          (cat) => cat.id === materialId
        );
        if (materialToAdd) {
          //check if the material is already selected
          if (
            !selectedMaterials.value.find((e) => e == materialToAdd.designation)
          ) {
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
      qEditMode.value = false;
    };
    const handleRemoveMaterial = (e) => {
      if (materialToRemove) {
        const index = form.materials.indexOf(materialToRemove);
        if (index > -1) {
          form.materials.splice(index, 1);
        }
      }
      selectedMaterials.value = selectedMaterials.value.filter(
        (m) => m !== e.value
      );
    };
    const closeModal = () => {
      //   visible.value = false;
      hideQuantityDialog();
    };
    const qVisible = ref(false);
    const getMaterialName = (materialId) => {
      const material = categories.value.find((m) => m.id === materialId);
      return material ? material.designation : "Matériel inconnu";
    };
    const addInstruction = () => {
      form.instructions.push({
        description: "",
        response_type: "",
      });
    };
    const addInstructionValue = (type, value, index) => {
      form.instructions[index][type] = value;
    //   console.log(form.instructions);
    };

    const removeInstruction = (index) => {
      form.instructions.splice(index, 1);
    };

    const tVisible = ref(false);
    const ttVisible = ref(false);
    const addTModal = () => {
      tVisible.value = true;
    };
    const taddTModal = () => {
      ttVisible.value = true;
    };
    const eVisible = ref(false);
    const addEquipment = () => {
      eVisible.value = true;
    };
    const submitEquipment = async () => {
      let success = false;
      eVisible.value = false;
      if (eisEditMode.value) {
        success = await updateEquipment(eform.id, { ...eform });
      } else {
        success = await storeEquipment({ ...eform });
      }
      if (success) {
        await getEquipments();
        eVisible.value = false;
        eresetForm();
      }
    };
    const eform = reactive({
      id: null,
      name: "",
      serial_number: "",
      status: "available",
      description: "",
      project_id: null,
      user_id: null,
      purchase_date: null,
      purchase_price: null,
      warranty_end_date: null,
    });
    const eresetForm = () => {
      form.id = null;
      form.name = "";
      form.serial_number = "";
      form.status = "available";
      form.description = "";
      form.project_id = null;
      form.user_id = null;
      form.purchase_date = null;
      form.purchase_price = null;
      form.warranty_end_date = null;
    };
    const mVisible = ref(false);
    const addMateriels = () => {
      mVisible.value = true;
    };
    const mform = reactive({
      id: null,
      designation: "",
      caracteristique: "",
      unity_id: null,
      type: "",
      is_remise: false,
    });
    const typeOptions = ref([
      { label: "Outils de travail", value: "Outils de travail" },
      { label: "Equipement", value: "Equipement" },
      { label: "Autres", value: "Autres" },
    ]);
    const submitCategory = async () => {
      mVisible.value = false;

      storeCategory({ ...mform });
      await getCategories();
    };
    const expenses = reactive({});

    const addExpense = () => {
      form.expenses.push({ title: "", amount: 0,  is_default: true });
    //   console.log("12334");
    };

    const removeExpense = (index) => {
      form.expenses.splice(index, 1);
    };

    const updateExpenseData = (index, field, value) => {
    //   console.log(index);
    //   console.log(field);
      form.expenses[index][field] = value;
    };
    const updateTacheronsExpense = () => {
      const existingTacheronsExpenseIndex = form.expenses.findIndex(
        (expense) => expense.title === "Coût de Tâcherons"
      );
      const tacheronsAmount =
        form.nbre_tacherons *
        form.price_tacherons *
        (form.man_hours > 0 ? form.man_hours : 1);

      if (existingTacheronsExpenseIndex !== -1) {
        if(!isEditMode.value){
            form.expenses[existingTacheronsExpenseIndex].amount = tacheronsAmount;
        }
      } else {
        form.expenses = form.expenses.filter((e) => e.readonly != true);
        form.expenses.push({
          title: `Coût total de ${form.nbre_tacherons} Tâcherons `,
          amount: tacheronsAmount,
          price_unity: form.price_tacherons,
          nombre: form.nbre_tacherons,
          readonly: true,
        });
      }
    };
    watch(
      () => [form.nbre_tacherons, form.price_tacherons, form.man_hours],
      ([newNbreTacherons, newPriceTacherons, newMan_hours]) => {
        // Only update if both values are valid numbers
        if (
          !isNaN(newNbreTacherons) &&
          !isNaN(newPriceTacherons) &&
          newNbreTacherons >= 0 &&
          newPriceTacherons >= 0
        ) {
          updateTacheronsExpense();
        }
      },
      { immediate: true } // Add this to trigger the watcher on component mount
    );
    //   ;
    const formatDate = (dateLocal) => {
      const date = new Date(dateLocal);
      return new Intl.DateTimeFormat("fr-FR", {
        timeZone: "Africa/Kigali",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
      }).format(date);
    };
    const statusOptions = ref([
      { label: "Disponible", value: "available" },
      { label: "En cours d'utilisation", value: "in_use" },
      { label: "En maintenance", value: "under_maintenance" },
      { label: "Endommagé", value: "broken" },
    ]);
    const typeMaintenance = ref([
      {
        label: "Maintenance sur un équipement",
        value: "equipment",
      },
      {
        label: "Autre maintenance",
        value: "quarterly",
      },
    ]);

    const initTask = async () => {
      await getProject();
      await getPriorities();
    };
    const { getProject, projects } = useProjects();
    const { getPriorities, priorities } = usePriorities();
    const taskVisible = ref(false);
    const selectedTask = reactive({
      id: null,
      priority_id: null, //set default value
      status: "pending",
      engin_id: null,
      comments: "",
      complete: null,
      price_technicien: 2.92,
      description: "",
      type: "",
      price_tacherons: 0,
      nbre_tacherons: 0,
      user_id: null,
      category_id: null,
      category: null,
      owner: null,
      task_id: null,
      assigned_date: null,
      start_date: null,
      due_date: null,
      delay: null,
      end_time: null,
      start_time: null,
      assignToType: "user", // Default to assigning to a user
      assigned_user_id: null,
      assigned_team_id: null,
      instructions: [],
      tasks: [],
      materials: [],
    });
    const resetTaskForm = () => {
      selectedTask.id = null;
      selectedTask.priority_id = null;
      selectedTask.status = "pending";
      selectedTask.engin_id = null;
      selectedTask.comments = "";
      selectedTask.complete = null;
      selectedTask.nbre_tacherons = 0;
      selectedTask.price_technicien = 2.92;
      selectedTask.price_tacherons = 0;
      selectedTask.description = "";
      selectedTask.type = "";
      selectedTask.user_id = null;
      selectedTask.category_id = null;
      selectedTask.category = null;
      selectedTask.owner = null;
      selectedTask.task_id = null;
      selectedTask.assigned_date = null;
      selectedTask.start_date = setDefaultTime(new Date().toISOString());
      selectedTask.due_date = setDefaultTime(new Date().toISOString());
      selectedTask.delay = null;
      selectedTask.start_time = null;
      selectedTask.end_time = null;
      selectedTask.assignToType = "user";
      selectedTask.assigned_user_id = null;
      selectedTask.assigned_team_id = null;
      selectedTask.instructions = [];
      selectedTask.materials = [];
    };
    const addTask = () => {
      tEditMode.value = false;
      taskVisible.value = true;
      selectedTask.description = form.description;
      selectedTask.start_date = setDefaultTime(new Date().toISOString());
      selectedTask.due_date = setDefaultTime(new Date().toISOString());
      resetTaskForm();
    };
    const editTask = (task) => {
      tEditMode.value = true;
      taskVisible.value = true;
      selectedTask.assigned_user_id = 3;
      resetTaskForm();
    //   console.log(task);
    //   console.log(task.id);
      Object.assign(selectedTask, task);
      selectedTask.assignToType = task.assigned_user_id ? "user" : "team";
      selectedTask.assigned_user_id = task.assigned_user_id;
      selectedTask.assigned_team_id = task.assigned_team_id;
    //   console.log(selectedTask);
    };
    const removeTask = (task) => {
      tEditMode.value = false;
      const index = form.tasks.indexOf(task);
      if (index > -1) {
        form.tasks.splice(index, 1);
      }
      form.expenses = form.expenses.filter(
        (e) => e.title != "Coût de Tâcherons"
      );
      form.expenses.push({
        title: "Coût de Tâcherons",
        amount: price,
        price_unity: form.price_tacherons,
        nombre: form.nbre_tacherons,
        is_default: true,
        readonly: true,
      });
    };
    const addInstructionToTask = () => {
      selectedTask.instructions.push({
        description: "",
        response_type: "",
      });
    };
    const addInstructionValueToTask = (type, value, index) => {
      selectedTask.instructions[index][type] = value;
    };
    const removeInstructionFromTask = (index) => {
      selectedTask.instructions.splice(index, 1);
    };
    const submitTask = () => {
//   console.log("selectedTask.id");
//   console.log({ ...selectedTask });
    //    selectedTask.assignToType = selectedTask.assigned_user_id ? "user" : "team";

  if (tEditMode.value) {
    const index = form.tasks.findIndex((t) => t.id === selectedTask.id);
    if (index !== -1) {
      form.tasks[index] = { ...selectedTask };
    }
  } else {
    selectedTask.id = form.tasks.length;
    form.tasks.push({ ...selectedTask });
  }
  const price = ref(0);
  const nbr_tt=ref(0);
  form.tasks.forEach((task) => {
    price.value += task.nbre_tacherons * task.price_tacherons;
    nbr_tt.value+= task.nbre_tacherons;
  });
  form.expenses = form.expenses.filter(
    (e) => e.title != "Coût de Tâcherons"
  );
  if (price.value > 0)
    form.expenses.push({
      title: "Coût de Tâcherons",
      amount: price.value* form.man_hours,
      price_unity: price.value/(nbr_tt.value ?? 1),
      nombre: nbr_tt.value,
      is_default: true,
      readonly: true
    });
  const nbr_users = ref(0);
  const price_users = ref(0);
  const price_unity=ref(0);
  console.log(form.tasks);
  console.log(selectedTask);
  form.tasks.forEach((task) => {
    // const usersCount =
    //   task.assignToType === "user" || task.assigned_user
    //     ? task.assigned_user_id
    //       ? 1
    //       : task.assigned_user_id ? 1: 0
    //     : task.assigned_team_id
    //     ? teams.value.find((e) => e.id === task.assigned_team_id)?.users
    //         ?.length || 0
    //     : 0;
    const usersCount= task.assigned_user ? 1 : task.assigned_team ? teams.value.find((e) => e.id === task.assigned_team_id)?.users
           ?.length || 0 : 0;

    nbr_users.value += usersCount;
    price_users.value += usersCount * (task.price_technicien || 2.92);
    price_unity.value= (task.price_technicien || 2.92);
});

  form.expenses = form.expenses.filter(
    (e) => e.title != "Coût de techniciens"
  );
  if (price_users.value > 0) {
    form.expenses.push({
      title: "Coût de techniciens",
      amount: price_users.value * form.man_hours,
      price_unity: price_users.value / ( nbr_users.value ?? 1),
      nombre: nbr_users.value,
      is_default: true,
    });
  }
  taskVisible.value = false;
  tEditMode.value = false;
  resetTaskForm();
};

    const getOwnerName = (ownerId) => {
      const user = users.value.find((u) => u.id === ownerId);
      return user ? user.name : "N/A";
    };
    const getPriorityName = (priorityId) => {
      const priority = priorities.value.find((p) => p.id === priorityId);
      return priority ? priority.title : "N/A";
    };
    const getProjectName = (projectId) => {
      const project = projects.value.find((p) => p.id === projectId);
      return project ? project.name : "N/A";
    };

    const taddInstructionValue = (type, value, i, index) => {
      form.tasks[index].instructions[i][type] = value;
    };
    const tremoveInstruction = (i, index) => {

      form.tasks[index].instructions.splice(i, 1);
    };
    const thandleRemoveMaterial = (e) => {
      if (materialToRemove) {
        const index = selectedTask.materials.indexOf(materialToRemove);
        if (index > -1) {
          selectedTask.materials.splice(index, 1);
        }
      }
      selectedMaterials.value = selectedMaterials.value.filter(
        (m) => m !== e.value
      );
    };
    const getAssingedName = (userId) => {
      const user = users.value.find((u) => u.id === userId);
      return user
        ? `${user.name ?? ""} ${user.post_name ?? ""} ${user.nickname ?? ""}`
        : "N/A";
    };
    const getAssingedTeamName = (teamId) => {

      const team = teams.value.find((u) => u.id === teamId);
      const user = users.value.find((u) => u.id === team.user_id);
      return user
        ? `${user.name ?? ""} ${user.post_name ?? ""} ${user.nickname ?? ""}`
        : "N/A";
    };
    const filters = ref({
      global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    });
    const deleteMaintenance = async (maintenanceId) => {
      await destroyMaintenace(maintenanceId);
      await getMaintenances();
      toast.add({
        severity: "success",
        summary: "Success",
        detail: "La maintenance a été supprimée avec succès!",
        life: 3000,
      });
    };

    const confirmDeleteMaintenance = (maintenanceId) => {
      confirm.require({
        message: "Êtes-vous sûr de vouloir supprimer cette maintenance?",
        header: "Confirmation de suppression",
        icon: "pi pi-exclamation-triangle",
        acceptLabel: "Oui",
        rejectLabel: "Non",
        acceptClass: "p-button-danger",
        accept: () => {
          deleteMaintenance(maintenanceId);
        },
        reject: () => {
          toast.add({
            severity: "info",
            summary: "Suppression annulée",
            detail: "La suppression a été annulée.",
            life: 3000,
          });
        },
      });
    };
    const handleOptionChange = (data) => {
      selectedTask.assignToType = data;
      if ((data = "team")) {
        selectedTask.assigned_user_id = null;
        selectedTask.assigned_user = null;
      } else {
        selectedTask.assigned_team_id = null;
        selectedTask.assigned_team = null;
      }
    };
    const handleChangeRegion = () => {
      if (form.region_id !== null) {
        teams.value = teams.value.filter((team) => {
          return team.region_id === form.region_id || team.region_id === null;
        });
      } else {
        // If no region is selected, reset to all users
        getTeams();
      }
      return;
      if (form.region_id !== null) {
        users.value = users.value.filter((user) => {
          return user.region_id === form.region_id || user.region_id === null;
        });
      } else {
        // If no region is selected, reset to all users
        getUsers();
      }
    };
    const handlPriceTacherons = () => {

      const price = ref(0);
      const nbr_tt=ref(0);
      form.tasks.forEach((task) => {
        price.value += task.nbre_tacherons * task.price_tacherons;
        nbr_tt.value+= task.nbre_tacherons;
      });
      form.expenses.push({
        title: "Coût de Tâcherons",
        amount: price.value,
        is_default: true,
        price_unity: price.value/(nbr_tt.value ?? 1),
        nombre: nbr_tt.value,
        readonly: true
      });
    };
    const toggleTypeMaintenance = () => {
      form.expenses = [];
    };

    const tacheronsForm = ref(0);
    watch(
      () => tacheronsForm.value,
      (newValue, oldValue) => {
        // alert(123);
        // console.log("tacheronsForm changed from:", oldValue, "to:", newValue);
        // Add your logic here to perform actions when tacheronsForm changes
      }
    );

    return {
      engins,
      tacheronsForm,
      toggleTypeMaintenance,
      handlPriceTacherons,
      ttVisible,
      taddTModal,
      handleChangeRegion,
      handleOptionChange,
      tEditMode,
      deleteMaintenance,
      filters,
      regions,
      getAssingedTeamName,
      thandleRemoveMaterial,
      tremoveInstruction,
      taddInstructionValue,
      getAssingedName,
      submitTask,
      removeTask,
      editTask,
      getOwnerName,
      getPriorityName,
      getProjectName,
      addInstructionToTask,
      addInstructionValueToTask,
      removeInstructionFromTask,
      addTask,
      taskVisible,
      selectedTask,
      projects,
      priorities,
      typeMaintenance,
      statusOptions,
      formatDate,
      expenses,
      addExpense,
      removeExpense,
      updateExpenseData,
      totalExpenses: expenses.totalExpenses,
      submitCategory,
      typeOptions,
      mform,
      mVisible,
      addMateriels,
      submitEquipment,
      eform,
      addEquipment,
      eVisible,
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
      teams,
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
      confirmDeleteMaintenance,
      errors,
      isLoading,
      showTableView,
      searchQuery,
      filteredMaintenances,
      qVisible,
      submitQuantity,
      eisEditMode,
      cEditMode,
      tEditMode,
      qEditMode,
      unities,
    };
  },
};
</script>
<style>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* Ensure it's on top */
}

.loading-spinner {
  /* Add any styling for the spinner container if needed */
}
</style>
