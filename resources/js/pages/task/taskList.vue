<template>
    <div class="login-page">
        <div v-if="uploadProgress > 0" class="col-md-12 mt-3">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    :style="{ width: `${uploadProgress}%` }" :aria-valuenow="uploadProgress" aria-valuemin="0"
                    aria-valuemax="100">
                    {{ uploadProgress.toFixed(0) ?? 0 }}%
                </div>
            </div>
        </div>
        <div v-if="isLoading" class="loading-overlay">
            <div class="loading-spinner">
                <span class="spinner-border text-white" role="status" aria-hidden="true"></span>
            </div>
        </div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="card flex justify-center"></div>
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Liste des Tâches
                            </h1>
                        </div>
                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <!-- Toggle View Button -->
                            <button type="button" class="btn btn-light btn-active-light-primary me-2"
                                @click="toggleView">
                                <span v-if="showTableView">Vue Grille</span>
                                <span v-else>Vue Liste</span>
                            </button>
                            <!-- End Toggle View Button -->

                            <div class="d-flex justify-content-end">
                                <Button label=" Ajouter une Tâche" icon="pi pi-plus" severity="warn"
                                    class="p-button-primary me-2" @click="addTask" />

                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="selectedFileName" class="mb-3">
                    <div class="d-flex align-items-center">
                        <i class="pi pi-file me-2"></i>
                        <span class="text-muted fs-8">
                            Fichier sélectionné : {{ selectedFileName }}
                        </span>
                    </div>
                </div>
                <div v-if="isLoading">Loading...</div>
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!-- Display the table view if showTableView is true -->
                    <div v-if="showTableView" id="kt_app_content_container_d-none" class="app-container">
                        <div class="card card-flush">

                            <div class="card-body pt-0">
                                <DataTable ref="dt" v-model:filters="filters" :value="tasks" :paginator="true"
                                    :rows="10" stripedRows removableSort
                                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                    :rowsPerPageOptions="[5, 10, 25, 50]"
                                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} tâches"
                                    tableStyle="min-width: 50rem">
                                    <template #header>
                                        <div class="d-flex justify-content-end">
                                            <div class="mx-1">

                                                <IconField>

                                                    <InputText v-model="filters['global'].value"
                                                        placeholder="Rechercher" />
                                                </IconField>
                                            </div>
                                            <div class="text-end pb-4">
                                                <Button icon="pi pi-external-link" severity="warn" label="Export"
                                                    @click="exportCSV($event)" />
                                            </div>
                                            <div class="mx-1">
                                                <Button v-if="!selectedFileName" label="Importer xls"
                                                    icon="pi pi-upload" @click="openFileDialog" />
                                                <Button v-else label="Importer vers le server"
                                                    class="p-button-primary ms-3" icon="pi pi-upload"
                                                    @click="importTasksToServer" />
                                                <input type="file" class="d-none" name="file" ref="fileInput"
                                                    @change="handleFileChange" />
                                            </div>
                                        </div>
                                    </template>
                                    <Column field="description" header="Description" sortable />
                                    <Column field="region.titre" header="Region" sortable />

                                    <Column field="priority" header="Priorité" sortable>
                                        <template #body="slotProps">
                                            <span v-if="slotProps.data.priority" class="badge" :style="'background-color: ' + slotProps.data.priority.color ?? 'dark'
                                                ">
                                                <span class="text-muted mx-3">
                                                    {{ slotProps.data.priority.title }}
                                                </span>
                                            </span>
                                        </template>
                                    </Column>

                                    <Column field="status" header="Status" sortable>
                                        <template #body="slotProps">
                                            <span v-if="slotProps.data.status === 'pending'"
                                                class="badge badge-warning">En attente</span>
                                            <span v-else-if="slotProps.data.status === 'in_progress'"
                                                class="badge badge-info">En cours</span>
                                            <span v-else-if="slotProps.data.status === 'completed'"
                                                class="badge badge-success">Terminée</span>
                                            <span v-else-if="slotProps.data.status === 'canceled'"
                                                class="badge badge-dark">Annulée</span>
                                            <span v-else-if="slotProps.data.status === 'delayed'"
                                                class="badge badge-danger">Delai depassé</span>
                                            <span v-else class="badge badge-secondary">Inconnu</span>
                                        </template>
                                    </Column>

                                    <Column field="owner_user" header="Responsable" sortable>
                                        <template #body="slotProps">
                                            <span class="badge badge-light-success">
                                                {{ slotProps.data.owner_user ? slotProps.data.owner_user.name : "N/A" }}
                                            </span>
                                        </template>
                                    </Column>
                                    <Column header="Technicien" sortable>
                                        <template #body="slotProps">
                                            <template v-if="slotProps.data.assigned_user">
                                                <span class="badge badge-light-primary">
                                                    {{
                                                        slotProps.data.assigned_user
                                                            ? slotProps.data.assigned_user.name
                                                            : "N/A"
                                                    }}
                                                </span>
                                            </template>
                                            <template v-else-if="
                                                slotProps.data.assigned_team && slotProps.data.assigned_team.users
                                            ">
                                                <span v-for="team in slotProps.data.assigned_team.users" :key="team.id"
                                                    class="badge badge-light-primary">
                                                    {{ team.name }} {{ team.post_name }}
                                                </span>
                                            </template>
                                        </template>
                                    </Column>
                                    <!-- <Column  filed="start_date" header="Start Date"/>
                        <Column  filed="due_date" header="End Date"/> -->

                                    <Column header="Actions">
                                        <template #body="slotProps">
                                            <div class="d-flex">
                                                <Button @click="showTask(slotProps.data)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px d-inline-block"
                                                    severity="warn">
                                                    <i class="ki-duotone ki-eye fs-3"><span class="path1"></span><span
                                                            class="path2"></span><span class="path3"></span><span
                                                            class="path4"></span><span class="path5"></span></i>
                                                </Button>
                                                <Button @click="editTask(slotProps.data)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px d-inline-block"
                                                    severity="warning">
                                                    <i class="ki-duotone ki-pencil fs-3"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span></i>
                                                </Button>
                                                <Button @click="confirmDeleteTask(slotProps.data.id)" severity="danger"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                            class="path2"></span><span class="path3"></span><span
                                                            class="path4"></span><span class="path5"></span></i>
                                                </Button>
                                            </div>
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>
                        </div>
                    </div>
                    <!-- Display the grid view if showTableView is false -->
                    <div v-if="!showTableView" id="kt_app_content_container" class="app-container container-xxl">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                            <template v-for="task in tasks" :key="task.id">
                                <div class="col-md-4">
                                    <div class="card card-flush h-md-100">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Tache: {{ task.id }}</h2>
                                            </div>
                                        </div>

                                        <div class="card-body pt-1">
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Description: {{ task.description }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Priorité:
                                                <span class="badge" :style="'background-color: ' + task.priority.color ?? 'dark'
                                                    ">
                                                    <span class="text-muted mx-3">
                                                        {{ task.priority.title }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Status:
                                                <span v-if="task.status === 'pending'" class="badge badge-warning">En
                                                    attente</span>
                                                <span v-else-if="task.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="task.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                <span v-else-if="task.status === 'delayed'"
                                                    class="badge badge-danger">Delai depassé</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Projet : {{ task.project ? task.project.name : "N/A" }}
                                            </div>
                                            <div class="fw-bold text-gray-600">
                                                Debut : {{ formatDate(task.start_date) }} <br />
                                                Duree :
                                                <span class="fs-8 text-center">
                                                    <span class="badge badge-light-success">
                                                        {{
                                                            formatDeadline(
                                                                task.due_date,
                                                                task.start_date,
                                                                task
                                                            )
                                                        }}</span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="card-group p-4">
                                            <!-- <button @click="viewTask(task.id)"
                                                class="card btn btn-light btn-active-primary my-1 me-2 ">
                                                <span>Afficher</span>
                                                <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                            </button> -->
                                            <Button @click="editTask(task)"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                severity="warning">
                                                <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                            </Button>
                                            <Button @click="deleteTask(task)" severity="danger"
                                                class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div class="ol-md-4" v-if="false">
                                <div class="card h-md-100">
                                    <div class="card-body d-flex flex-center">
                                        <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                                            @click="addTask" id="addTask">
                                            <img src="/assets/media/illustrations/sketchy-1/2.png" alt=""
                                                class="mw-100 mh-150px mb-7" />

                                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">
                                                Ajouter une nouvelle Tâche
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
        <Dialog :id="id" :header="isEditMode ? 'Modifier une Tâche' : 'Créer une Tâche'" v-model:visible="visible"
            :style="{ width: '800px' }" position="center" :modal="true"
            :breakpoints="{ '960px': '75vw', '640px': '100vw' }" @hide="closeModal" :closable="true">
            <template #header>
                {{ isEditMode ? 'Modifier' : 'Créer' }} une Tâche
            </template>
            <div class="d-flex flex-column scroll-y px-3 px-lg-5 ">
                <Card class="bg-secondary">
                    <template #content>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row fv-plugins-icon-container">
                                    <label class="required fw-semibold fs-6 mb-2">Description</label>
                                    <FloatLabel variant="in">
                                        <Textarea id="over_label" v-model="form.description" rows="5" size="large"
                                            class="w-full md:w-14rem w-100" cols="30" style="resize: none" />
                                        <label for="in_label">Description de la tâche</label>
                                    </FloatLabel>

                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="fv-row fv-plugins-icon-container col-md-12">
                                    <label class="required fw-semibold fs-6 mb-2 d-block">Responsable</label>
                                    <Dropdown v-model="form.owner" :options="users"
                                        :optionLabel="(user) => `${user.name ?? ''} ${user.post_name ?? ''}  ${user.nickname ?? ''}`"
                                        optionValue="id" placeholder="Sélectionner un responsable"
                                        class="w-full md:w-14rem w-100" :filter="true"
                                        filterBy="name,post_name, email" />
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">
                                        <span class="">Status</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="fv-row ">
                                        <Dropdown v-model="form.status" :options="[
                                            { name: 'En attente', value: 'pending' },
                                            { name: 'En cours', value: 'in_progress' },
                                            { name: 'Terminée', value: 'completed' },
                                            { name: 'Annulée', value: 'canceled' },
                                        ]" optionLabel="name" optionValue="value" placeholder="Sélectionner un status"
                                            class="w-full md:w-14rem w-100" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="fv-row mb-7 fv-plugins-icon-container col-md-12">
                                    <label class="required fw-semibold fs-6 mb-2 d-block">Priorité</label>
                                    <Dropdown v-model="form.priority_id" :options="priorities" optionLabel="title"
                                        optionValue="id" placeholder="Sélectionner une priorité"
                                        class="w-full md:w-14rem w-100" required />
                                </div>
                            </div>

                        </div>

                    </template>
                </Card>

                <div class="row">
                    <div class="col-md-6" v-if="projects.length">
                        <div class="my-6">
                            <label class="col-form-label fw-bold fs-6">
                                <span class="required">Projet</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                    title="categorie"></i>
                            </label>
                            <div class="fv-row">
                                <Dropdown v-model="form.project_id" :options="projects" optionLabel="name"
                                    optionValue="id" placeholder="Sélectionner un projet" class="w-full md:w-14rem" />
                            </div>
                        </div>
                    </div>
                </div>
                <Card class="mt-2 bg-secondary mb-2">
                    <template #title>
                        Assigner à
                    </template>
                    <template #content>
                        <div class="fv-row  fv-plugins-icon-container row">
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-solid mb-3">
                                    <RadioButton inputId="assignToUser" value="user" v-model="form.assignToType"
                                        name="assignToType" />
                                    <label class="form-check-label" for="assignToUser">
                                        Technicien
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid">
                                    <RadioButton inputId="assignToTeam" value="team" v-model="form.assignToType"
                                        name="assignToType" />
                                    <label class="form-check-label" for="assignToTeam">
                                        Équipe
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div v-if="form.assignToType === 'user'" class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Technicien</label>
                                    <Dropdown v-model="form.assigned_user_id" :options="users"
                                        :optionLabel="(user) => `${user.name ?? ''} ${user.post_name ?? ''}  ${user.nickname ?? ''}`"
                                        optionValue="id" placeholder="Sélectionner un technicien"
                                        class="w-full md:w-14rem w-100" :filter="true"
                                        filterBy="name,post_name,email" />
                                </div>
                                <div v-else-if="form.assignToType === 'team'" class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Équipe</label>
                                    <Dropdown v-model="form.assigned_team_id" :options="teams" optionLabel="name"
                                        optionValue="id" placeholder="Sélectionner une équipe"
                                        class="w-full md:w-14rem w-100" />
                                </div>
                            </div>
                        </div>
                        <!-- Conditional rendering for user/team selection -->

                    </template>
                </Card>
                <Card class="bg-secondary my-2">
                    <template #title>
                        Planification et Récurrence
                    </template>
                    <template #content>
                        <div class="row">
                            <div class="fv-row fv-plugins-icon-container col-md-4">
                                <label class="fw-semibold fs-6 mb-2">Date de début</label>
                                <Calendar v-model="form.start_date" dateFormat="dd/mm/yy" showIcon :showTime="true"
                                    :hourFormat="'24'" class="w-full md:w-14rem w-100"
                                    placeholder="Sélectionner la date de début" />
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row fv-plugins-icon-container col-md-4">
                                <label class="fw-semibold fs-6 mb-2">Date de Fin</label>
                                <Calendar v-model="form.due_date" dateFormat="dd/mm/yy" showIcon :showTime="true"
                                    :hourFormat="'24'" class="w-full md:w-14rem w-100"
                                    placeholder="Sélectionner la date de début" />
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="fv-row fv-plugins-icon-container col-md-4">
                                <label class="fw-semibold fs-6 mb-2">Type de récurrence</label>
                                <Dropdown v-model="form.recurrence_type" :options="recurrenceOptions" optionLabel="name"
                                    optionValue="value" placeholder="Sélectionner la récurrence"
                                    class="w-full md:w-14rem w-100" />
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                    </template>
                </Card>
                <Card class="bg-secondary">
                    <template #content>
                        <div class="fv-row mb-7 fv-plugins-icon-container">
                            <div class="d-flex justify-content-end">
                                <Button label="Ajouter une instruction" icon="pi pi-plus-circle"
                                    @click="addInstructionToTask" severity="warn" class="p-button-primary" />
                            </div>
                            <div v-for="(instruction, index) in form.instructions" :key="index"
                                class="my-1 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="fw-bold">Instruction {{ index + 1 }}</label>

                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <InputText type="text" name="designation" class="form-control  mb-3 mb-lg-0"
                                            placeholder="Description de l'instruction" v-model="instruction.description"
                                            @input="addInstructionValueToTask('description', instruction.description, index)" />
                                    </div>
                                    <div class="col-md-3">
                                        <Dropdown class="w-full md:w-14rem" v-model="instruction.response_type"
                                            :options="['checkbox', 'text / valeur', 'signature']"
                                            placeholder="Type de reponse"
                                            @change="addInstructionValueToTask('response_type', instruction.response_type, index)" />
                                    </div>
                                    <div class="col-md-1 d-flex align-items-start justify-content-start"
                                        @click="removeInstructionFromTask(index)">
                                        <button><i class="fa fa-trash text-danger m-0 p-0 display-6"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                  v-model="form.engin_id"
                  :options="engins"
                  optionLabel="name"
                  optionValue="id"
                  :filter="true"
                  filterBy="name"
                  placeholder="Sélectionner un vehicule"
                  class="w-full md:w-14rem w-100"
                />
              </div>
                <div class="col-md-6">
              <label class="fw-semibold col-md-12 fs-6 mb-2">
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
            </div>
          </template>
        </Card>
                <!-- ici -->
                <Card class="bg-secondary mt-2" id="materials">
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
                                <li v-for="(material, index) in form.materials" :key="index" class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            {{ getMaterialName(material.id) }}
                                            <span v-if="material.unity" class="text-muted fs-sm">
                                                ({{ material.unity.designation }})
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <InputNumber type="text" name="designation" class="w-full md:w-14rem"
                                                placeholder="0" v-model="material.quantity" showButtons :min="1" >
                                                  <template #incrementicon></template>
                                                </InputNumber>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center" v-if="false">
                                            <span v-if="material.unity">
                                                {{ material.unity.designation }}
                                            </span>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <Button icon="pi pi-trash" severity="danger"
                                                @click="handleRemoveMaterial(material)" text rounded />
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </template>
                </Card>
            </div>
            <template #footer>
                <Button label="Annuler" icon="pi pi-times" severity="secondary" variant="text" class="p-button-text"
                    @click="visible = false" />
                <Button label="Enregistrer" icon="pi pi-check" severity="warn" class="p-button-primary" raised
                    @click="submitTask()" />
            </template>
        </Dialog>
        <Dialog header="Quantité du Matériel" v-model:visible="qVisible" :style="{ width: '400px' }" position="center"
            :modal="true" @hide="hideQuantityDialog" :closable="true">
            <div class="">
                <label class="col-form-label fw-bold fs-6">
                    <span class="">
                        Quelle Quantité à utiliser pour
                        <span class="text-warning">{{ selectMaterial.designation }}</span>?
                    </span>
                </label>
                <div class="row align-items-center">
                    <div :class="selectMaterial.unity ? 'col-md-8' : 'col-md-12'">
                        <div class="fv-row">
                            <InputNumber v-model="selectMaterial.quantity" class="w-100" placeholder="0" showButtons
                                :min="1" />
                        </div>
                    </div>
                    <div v-if="selectMaterial.unity" class="col-md-4">
                        <InputText type="text" v-model="selectMaterial.unity.designation" class="form-control"
                            readOnly />
                    </div>
                </div>
            </div>
            <template #footer>
                <Button label="Annuler" icon="pi pi-times" severity="secondary" @click="hideQuantityDialog" text />
                <Button label="Enregistrer" icon="pi pi-check" severity="warn" @click="submitQuantity" />
            </template>
        </Dialog>

        <Dialog :header="cEditMode ? 'Modifier une catégorie' : 'Ajouter une catégorie/Matériel'"
            v-model:visible="mVisible" :style="{ width: '700px' }" position="center" :modal="true"
            @hide="mVisible = false" :closable="true">
            <div class="p-fluid">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="required fw-semibold fs-6 mb-2 d-block" for="designation">Designation</label>
                        <InputText id="designation" type="text" placeholder="Designation de la catégorie"
                            v-model="mform.designation" class="w-full w-100" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold fs-6 mb-2 d-block" for="caracteristique">Caractéristiques</label>
                        <InputText id="caracteristique" type="text" placeholder="Caracteristique de la catégorie"
                            v-model="mform.caracteristique" class="w-full w-100" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold fs-6 mb-2 d-block" for="unity">Unité</label>
                        <Dropdown id="unity" v-model="mform.unity_id" :options="unities" optionLabel="designation"
                            optionValue="id" placeholder="Selectionner une unité..." class="w-full w-100" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold fs-6 mb-2 d-block" for="type">Type d'équipement</label>
                        <Dropdown id="type" v-model="mform.type" :options="typeOptions" optionLabel="label"
                            optionValue="value" placeholder="Selectionner un type..." class="w-full w-100" />
                    </div>
                    <div class="col-md-6">
                        <div class="field-checkbox my-2">
                            <Checkbox id="is_remise" v-model="mform.is_remise" :binary="true" />
                            <label for="is_remise" class="ml-2 me-3">A remettre au magasin?</label>
                        </div>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button label="Annuler" icon="pi pi-times" @click="mVisible = false" text />
                <Button label="Enregistrer" icon="pi pi-check" severity="warn" @click="submitCategory" />
            </template>
        </Dialog>

        <Toast />
        <ConfirmDialog></ConfirmDialog>
    </div>
</template>
<script>
import { FilterMatchMode } from '@primevue/core/api';
import { useCookie } from "@vue-composable/cookie";
import { useConfirm, useToast } from "primevue";
import AutoComplete from 'primevue/autocomplete';
import Calendar from 'primevue/calendar';
import Checkbox from 'primevue/checkbox';
import InputGroup from 'primevue/inputgroup';
import InputNumber from 'primevue/inputnumber';
import { computed, onMounted, reactive, ref } from "vue";
import useCategories from "../../services/categoryServices.js";
import useEngins from '../../services/enginServices';
import useInstructions from "../../services/instructionServices.js";
import usePriorities from "../../services/priorityServices.js";
import useProjects from "../../services/projectServices.js";
import useTasks from "../../services/taskServices.js";
import useTeams from "../../services/teamServices.js"; // Import useTeams
import useUnities from "../../services/unityServices.js";
import useUsers from "../../services/userservices.js";
export default {
    setup() {
        const {
            tasks,
            getTasks,
            storeTask,
            updateTask,
            getTaskCategories,
            errors,
            storeImport,
            destroyTask,

        } = useTasks();
            const { getEngins, engins } = useEngins();
        const confirm = useConfirm();
        const { getProjects, projects } = useProjects();
        const { getUsers, users } = useUsers();
        const { getTeams, teams } = useTeams(); // Initialize useTeams
        const taskCategories = ref([]);
        const { categories, getCategories, storeCategory } = useCategories();
        const { unities, getUnities } = useUnities();
        const isEditMode = ref(false);
        const searchQuery = ref("");
        const showTableView = ref(false);
        const { priorities, getPriorities, storePriority } = usePriorities();
        const { storeInstruction, deleteInstruction, getInstructions } =
            useInstructions();
        const form = reactive({
            id: null,
            nbre_tacherons: 0,
            priority: "Moyen", //set default value
            status: "pending",
            comments: "",
            complete: null,
            description: "",
            type: "",
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
            engin_id: null,
            assignToType: "user", // Default to assigning to a user
            assigned_user_id: null,
            assigned_team_id: null,
            instructions: [],
            materials: [],
            recurrence_type: 'none', // Ajout pour le type de récurrence
        });
        const instructions = ref({});
        const visible = ref(false);
        // Function to calculate the delay
        const calculateDelay = () => {
            if (form.start_date && form.due_date) {
                // Combine date and time into a single Date object
                let startDate = new Date(form.start_date);
                let dueDate = new Date(form.due_date);

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
        // Set default time to 00:00 for new dates
        const setDefaultTime = (dateString) => {
            if (dateString) {
                return dateString.split("T")[0] + "T00:00";
            }
            return null;
        };
        const syncdata = async () => {
            await getTasks();
            taskCategories.value = await getTaskCategories();
            await getUsers();
            await getProjects();
            await getTeams(); // Fetch teams on component mount
            await getPriorities();
            await getCategories();
            await getUnities();
            await getEngins();
            showTableView.value = true; //add
            form.start_date = setDefaultTime(new Date().toISOString());
            form.due_date = setDefaultTime(new Date().toISOString());
            isLoading.value = false;
        }
        const isLoading = ref(true);

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
        const materialSearchText = ref(null);
        const qVisible = ref(false);
        const qEditMode = ref(false);
        const selectMaterial = reactive({ id: null, designation: '', unity: null, quantity: 1 });

        const mVisible = ref(false);
        const cEditMode = ref(false);
        const mform = reactive({
            id: null,
            designation: "",
            caracteristique: "",
            unity_id: null,
            type: "Equipement", // Default type
            is_remise: false,
        });
        const typeOptions = ref([
            { label: "Outils de travail", value: "Outils de travail" },
            { label: "Equipement", value: "Equipement" },
            { label: "Autres", value: "Autres" },
        ]);
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
        // const handleMaterialSelect = (event) => {

        //     const selectedCategory = event.value;
        //     if (!selectedCategory) return;

        //     const existingMaterial = form.materials.find(m => m.id === selectedCategory.id);
        //     if (existingMaterial) {
        //         selectMaterial.id = existingMaterial.id;
        //         selectMaterial.designation = getMaterialName(existingMaterial.id) || selectedCategory.designation;
        //         selectMaterial.quantity = existingMaterial.quantity;
        //         selectMaterial.unity = existingMaterial.unity || selectedCategory.unity;
        //         qEditMode.value = true;
        //     } else {
        //         selectMaterial.id = selectedCategory.id;
        //         selectMaterial.designation = selectedCategory.designation;
        //         selectMaterial.quantity = 1; // Default quantity
        //         selectMaterial.unity = selectedCategory.unity;
        //         qEditMode.value = false;
        //     }
        //     qVisible.value = true;
        //     materialSearchText.value = ''; // Clear autocomplete input
        // };
  const addMaterialToTask = () => {
      const materialId = selectMaterial.id;
      if (materialId) {
        const quantity = selectMaterial.quantity;
        const existingMaterialIndex = form.materials.findIndex(
          (m) => m.id === materialId
        );
        const existingMaterialIndex2 = form.materials.findIndex(
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
          form.materials[existingMaterialIndex2].quantity = quantity;
        } else {
          // Add material to the form
          form.materials.push({
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
            // const existingMaterialIndex = form.materials.findIndex(m => m.id === selectMaterial.id);
            // if (existingMaterialIndex !== -1) {
            //     form.materials[existingMaterialIndex].quantity = selectMaterial.quantity;
            // } else {
            //     form.materials.push({
            //         id: selectMaterial.id,
            //         quantity: selectMaterial.quantity,
            //         unity: selectMaterial.unity, // Store unity object
            //     });
            // }
            addMaterialToTask();
            hideQuantityDialog();
        };

        const hideQuantityDialog = () => {
            qVisible.value = false;
            selectMaterial.id = null;
            selectMaterial.designation = '';
            selectMaterial.quantity = 1;
            selectMaterial.unity = null;
            qEditMode.value = false;
        };
        const selectedMaterials = ref([]);
        const materialToRemove = ref(null);
        const handleRemoveMaterial = (e) => {
            const index = form.materials.findIndex(m => m.id === e.id);
            if (index !== -1) {
            form.materials.splice(index, 1);
            }

        };

        const addMateriels = () => {
            cEditMode.value = false;
            // Reset mform
            mform.id = null;
            mform.designation = "";
            mform.caracteristique = "";
            mform.unity_id = null;
            mform.type = "Equipement";
            mform.is_remise = false;
            mVisible.value = true;
        };

        const submitCategory = async () => {
            isLoading.value = true;
            const success = await storeCategory({ ...mform });
            if (success) {
                await getCategories(); // Refresh categories list
                toast.add({ severity: 'success', summary: 'Succès', detail: 'Catégorie ajoutée avec succès', life: 3000 });
                mVisible.value = false;
            } else {
                toast.add({ severity: 'error', summary: 'Erreur', detail: 'Erreur lors de l\'ajout de la catégorie', life: 3000 });
            }
            isLoading.value = false;
        };

        onMounted(async () => {

            syncdata();

        });
        const submitTask = async () => {

            isLoading.value = true;
            let success = false;
            // success = await updateTask(form.id, form);
            visible.value = false;
            // Check if it's assigned to a user or a team
            if (form.assignToType === "user") {
                form.assigned_team_id = null;
            } else if (form.assignToType === "team") {
                form.assigned_user_id = null;
            }
            console.log({...form});
            if (isEditMode.value) {
                success = await updateTask(form.id, form);
                await getTasks();
            } else {
                success = await storeTask(form);
            }
            if (success) {

                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: "La tâche a été enregistrée avec succès!",
                    life: 3000,
                });
            } else {
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Une erreur s'est produite lors de l'enregistrement de la tâche!",
                    life: 3000,
                });
            }
            await syncdata();
            visible.value = false;
            isLoading.value = false; // Show loading
            resetForm();
        };

        const addTask = () => {
            resetForm();
            isEditMode.value = false;
            visible.value = true;
            form.start_date = setDefaultTime(new Date().toISOString());
            form.due_date = setDefaultTime(new Date().toISOString());

            resetForm();
        };

        const editTask = (task) => {
            resetForm();
            isEditMode.value = true;
            visible.value = true;
            Object.assign(form, task);
            form.assignToType = task.assigned_user_id ? "user" : "team";
            form.assigned_user_id = task.assigned_user_id;
            form.assigned_team_id = task.assigned_team_id;

            calculateDelay();
        };

        const viewTask = (id) => {
            const taskCookie = useCookie("task");
            taskCookie.setCookie(id);
            location.href = `/tasks/${id}`;
        };

        const resetForm = () => {
            form.id = null;
            form.engin_id=null;
            form.priority_id = null;
            form.status = "pending";
            form.comments = "";
            form.complete = null;
            form.nbre_tacherons=0;
            form.description = "";
            form.type = "";
            form.user_id = null;
            form.category_id = null;
            form.category = null;
            form.owner = null;
            form.task_id = null;
            form.assigned_date = null;
            form.start_date = setDefaultTime(new Date().toISOString());
            form.due_date = setDefaultTime(new Date().toISOString());
            form.delay = null;
            form.start_time = null;
            form.end_time = null;
            form.assignToType = "user";
            form.assigned_user_id = null;
            form.assigned_team_id = null;
            form.instructions = [];
            form.materials = [];
            form.recurrence_type = 'none'; // Réinitialiser le type de récurrence
        };
        const addInstruction = () => {
            form.instructions.push({
                description: "",
                response_type: "",
            });
        };
        const recurrenceOptions = ref([
            { name: 'Aucune', value: 'none' },
            { name: 'Journalière', value: 'daily' },
            { name: 'Hebdomadaire', value: 'weekly' },
            { name: 'Mensuelle', value: 'monthly' },
            { name: 'Trimestrielle', value: 'quarterly' },
            { name: 'Annuelle', value: 'annually' },
        ]);


        const filteredTasks = computed(() => {
            return tasks.value.filter((task) => {
                return (
                    task.description
                        .toLowerCase()
                        .includes(searchQuery.value.toLowerCase()) ||
                    task.priority.title
                        .toLowerCase()
                        .includes(searchQuery.value.toLowerCase()) ||
                    task.status.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    (task.category &&
                        task.category.name
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase())) ||
                    (task.project &&
                        task.project.name
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase())) ||
                    (task.owner_user &&
                        task.owner_user.name
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase())) ||
                    (task.assigned_user &&
                        task.assigned_user.name
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase())) ||
                    task.start_date
                        .toLowerCase()
                        .includes(searchQuery.value.toLowerCase()) ||
                    task.due_date.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            });
        });
        const toggleView = () => {
            showTableView.value = !showTableView.value;
        };
        const showTimeFieldsF = () => {
            if (form.start_date && form.due_date) {
                return false;
            } else return true;
        };
        const showTimeFields = reactive(showTimeFieldsF());
        const formatDeadline = (end_date, start_date, task) => {
            if (start_date && end_date) {
                const startDate = new Date(start_date);
                const endDate = new Date(end_date);
                const now = new Date();

                let timeDifference;
                let isPast = false;

                if (endDate.getTime() < now && task.status != "completed") {
                    // timeDifference = Math.abs(endDate.getTime() - now.getTime());
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

        const showPriorityModal = ref(false); // New: Control the priority modal visibility
        const priorityForm = reactive({});
        const addInstructionValue = (type, value, index) => {
            form.instructions[index][type] = value;
            console.log(form.instructions);
        };
        const removeInstruction = (index) => {
            form.instructions.splice(index, 1);
        };
        const closeModal = () => {
            visible.value = false;
        };
        const formatDate = (dateLocal) => {
            const date = new Date(dateLocal);
            return new Intl.DateTimeFormat("fr-FR", {
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
            }).format(date);
        };
        const toast = useToast();
        const selectedFileName = ref(null);
        const fileInput = ref(null);
        const openFileDialog = () => {
            fileInput.value.click();
        };
        const handleFileChange = (event) => {
            const file = event.target.files[0];
            selectedFileName.value = file ? file.name : null;
        };
        const uploadProgress = ref(0);
        const importTasksToServer = async () => {
            if (!selectedFileName.value) {
                toast.add({
                    severity: "warn",
                    summary: "Warning",
                    detail: "Veuillez sélectionner un fichier",
                    life: 3000,
                });
                return;
            }
            const file = fileInput.value.files[0];
            const formDataFile = new FormData();
            formDataFile.append("file", file);
            uploadProgress.value = 0;
            try {
                const config = {
                    onUploadProgress: (progressEvent) => {
                        const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        uploadProgress.value = percentCompleted;
                    },
                };
                await storeImport(formDataFile, config);

                await getTasks();
                taskCategories.value = await getTaskCategories();
                await getUsers();
                await getProjects();
                await getTeams(); // Fetch teams on component mount
                await getPriorities();
                selectedFileName.value = null;
                uploadProgress.value = 0;
                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: "Catégories importées avec succès",
                    life: 3000,
                });
            } catch (error) {
                console.error("Error importing categories:", error);
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Erreur lors de l'importation des catégories",
                    life: 3000,
                });
            }

        };
        const isNewWeek = (task, index) => {
            if (index === 0) return true; // First task is always the start of a "week"
            const currentTaskDate = new Date(task.start_date);
            const previousTaskDate = new Date(
                filteredTasks.value[index - 1].start_date
            );
            return currentTaskDate.getWeek() !== previousTaskDate.getWeek();
        };
        // Add the getWeek function outside the component setup
        Date.prototype.getWeek = function () {
            var date = new Date(this.getTime());
            date.setHours(0, 0, 0, 0);
            // Thursday in current week decides the year.
            date.setDate(date.getDate() + 3 - ((date.getDay() + 6) % 7));
            // January 4 is always in week 1.
            var week1 = new Date(date.getFullYear(), 0, 4);
            // Adjust to Thursday in week 1 and count number of weeks from date to week1.
            return (
                1 +
                Math.round(
                    ((date.getTime() - week1.getTime()) / 86400000 -
                        3 +
                        ((week1.getDay() + 6) % 7)) /
                    7
                )
            );
        };
        // const { categories, getCategories } = useCategories(); // Already defined
        const getMaterialName = (materialId) => {
            const material = categories.value.find((m) => m.id === materialId);
            return material ? material.designation : "Matériel inconnu";
        };

        const filters = ref({
            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            description: { value: null, matchMode: FilterMatchMode.CONTAINS },
            "priority.title": { value: null, matchMode: FilterMatchMode.CONTAINS },
            status: { value: null, matchMode: FilterMatchMode.EQUALS },
            "owner_user.name": { value: null, matchMode: FilterMatchMode.CONTAINS },
            "assigned_user.name": {
                value: null,
                matchMode: FilterMatchMode.CONTAINS,
            },
            "assigned_team.users.name": {
                value: null,
                matchMode: FilterMatchMode.CONTAINS,
            },
        });
        const dt = ref(null);
        const exportCSV = () => {
            const filteredData = tasks.value.map((task) => ({
                Description: task.description,
                Priorité: task.priority.title,
                Status: task.status,
                Responsable: task.owner_user ? task.owner_user.name : "N/A",
                Technicien: task.assigned_user
                    ? task.assigned_user.name
                    : task.assigned_team && task.assigned_team.users
                        ? task.assigned_team.users.map((user) => user.name).join(", ")
                        : "N/A",
            }));
            const csvContent = convertToCSV(filteredData);
            const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
            const link = document.createElement("a");
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", "Listes_de_taches_virunga_energies.csv");
                link.style.visibility = "hidden";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        };

        const convertToCSV = (objArray) => {
            const array = typeof objArray !== "object" ? JSON.parse(objArray) : objArray;
            let str = "";
            const headers = Object.keys(array[0]).join(",");
            str += headers + "\r\n";
            for (let i = 0; i < array.length; i++) {
                let line = "";
                for (let index in array[i]) {
                    if (line !== "") line += ",";
                    line += array[i][index];
                }
                str += line + "\r\n";
            }
            return str;
        };
        const deleteTask = async (taskId) => {
            await destroyTask(taskId);
            await syncdata();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "La tâche a été supprimée avec succès!",
                life: 3000,
            });
        };
        const addInstructionToTask = () => {
            form.instructions.push({
                description: "",
                response_type: "",
            });
        };
        const addInstructionValueToTask = (type, value, index) => {
            form.instructions[index][type] = value;
        };
        const removeInstructionFromTask = (index) => {
            form.instructions.splice(index, 1);
        };
        const confirmDeleteTask = (taskId) => {
            confirm.require({
                message: "Êtes-vous sûr de vouloir supprimer cette tâche?",
                header: "Confirmation de suppression",
                icon: "pi pi-exclamation-triangle",
                acceptLabel: "Oui",
                rejectLabel: "Non",
                acceptClass: "p-button-danger",
                accept: () => {
                    deleteTask(taskId);
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
        window.Echo.channel('channel-name')
            .listen('TestEvent', (e) => {
                console.log('TestEvent', e);
                toast.add({ severity: 'success', summary: 'Success', detail: e.message, life: 3000 });
            });
        const showTask = (task) => {
            window.location.pathname = "/tasks/" + task.id;
        }
        return {
            addMaterialToTask,
            showTask,
            uploadProgress,
            confirmDeleteTask,
            addInstructionValueToTask,
            removeInstructionFromTask,
            addInstructionToTask,
            search, // Added search function
            filteredSuggestions, // Added filteredSuggestions ref
            materialSearchText,
            qVisible,
            qEditMode,
            selectMaterial,
            handleMaterialSelect,
            submitQuantity,
            hideQuantityDialog,
            handleRemoveMaterial,
            mVisible,
            cEditMode,
            engins,
            mform,
            typeOptions,
            addMateriels,
            submitCategory,
            deleteTask,
            dt,
            exportCSV,
            filters,
            categories,
            getMaterialName,
            isNewWeek,
            selectedFileName,
            fileInput,
            handleFileChange,
            importTasksToServer,
            openFileDialog,
            formatDate,
            addInstruction,
            formatDeadline,
            showTimeFields,
            toggleView,
            calculateDelay,
            projects,
            tasks,
            form,
            addTask,
            viewTask,
            submitTask,
            isEditMode,
            editTask,
            taskCategories,
            users,
            errors,
            isLoading,
            showTableView, // expose
            searchQuery,
            filteredTasks,
            teams, //expose teams
            priorities, //expose priorities,
            visible,
            addInstructionValue,
            removeInstruction,
            closeModal,
            recurrenceOptions, // Exposer les options de récurrence
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
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent black background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    /* Ensure it's on top */
}

.loading-spinner {
    /* Add any styling for the spinner container if needed */
}
</style>
