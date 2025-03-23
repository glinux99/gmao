<template>
    <div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="card flex justify-center">
    </div>
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Liste des Tâches
                            </h1>
                        </div>

                        <div class="d-flex align-items-center gap-2 gap-lg-3"><!-- Toggle View Button -->
                            <button type="button" class="btn btn-light btn-active-light-primary me-2" @click="toggleView">
                               <span v-if="showTableView">Vue Grille</span>
                               <span v-else>Vue Liste</span>
                           </button>
                           <!-- End Toggle View Button -->
                            <button type="button" class="btn btn-primary" @click="addTask">
                                Ajouter une Tâche
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="isLoading">Loading...</div>
                <div id="kt_app_content" class="app-content flex-column-fluid">
                     <!-- Display the table view if showTableView is true -->
                    <div v-if="showTableView" id="kt_app_content_container_d-none" class="app-container container-xxl">
                        <div class="card card-flush">
                            <div class="card-header mt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1 me-5">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <input type="text" data-kt-permissions-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Rechercher une tâche" v-model="searchQuery" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                                    id="kt_permissions_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Titre</th>
                                            <th class="min-w-125px">Priorité</th>
                                            <th class="min-w-125px">Status</th>
                                            <th class="min-w-125px">Projet</th>
                                            <th class="min-w-125px">Responsable</th>
                                            <th class="min-w-125px">Duree</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="task in filteredTasks" :key="task.id" >
                                            <td>
                                                <span class="text-gray-600 fs-8">
                                                    {{ task.description }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge" :style="'background-color: '+task.priority.color">
                                                    <span class="text-muted mx-3">
                                                        {{ task.priority.title }}
                                                    </span>
                                                    </span>

                                            </td>
                                            <td>
                                                <span v-if="task.status === 'pending'"
                                                    class="badge badge-warning">En attente</span>
                                                <span v-else-if="task.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="task.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                    <span v-else-if="task.status === 'canceled'"
                                                    class="badge badge-dark">Annulée</span>
                                                    <span v-else-if="task.status === 'delayed'"
                                                    class="badge badge-danger">Delai depassé</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </td>
                                            <td>{{ task.project ? task.project.name  : 'N/A' }}</td>
                                            <td><span class="badge badge-light-primary">
                                                {{ task.assigned_user? task.assigned_user.name : 'N/A'  }}
                                            </span></td>
                                            <td class="fs-9">

                                                <div class="fw-bold text-gray-600 ">
                        Debut : {{ formatDate(task.start_date) }} <br />
                        Duree :
                        <span class=" fs-8 text-center">
                          <span class="badge badge-light-success">
                            {{
                              formatDeadline(
                                task.due_date,
                                task.start_date,
                                task
                              )
                            }}</span
                          >
                        </span>
                      </div>


                                              </td>
                                            <td class="text-end">
                                                <!-- <button disabled
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                    <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                                </button> -->

                                                <button @click="editTask(task)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_update_task">
                                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                                Priorité: <span class="badge" :style="'background-color: '+task.priority.color">
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
                                                Projet : {{ task.project ? task.project.name : 'N/A' }}
                                            </div>
                                            <div class="fw-bold text-gray-600 ">
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
                            }}</span
                          >
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

                                            <button @click="editTask(task)"
                                                class="col-12 btn btn-light btn-active-light-primary my-1"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_task">
                                                Editer
                                                <i class="ki-duotone ki-pencil fs-3 ms-5"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                            </button>
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
        <Dialog
    :id="id"
    :header="isEditMode ? 'Modifier une Tâche' : 'Créer une Tâche'"
    v-model:visible="visible"
    :style="{ width: '800px' }"
    position="center"
    :modal="true"
    :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
    @hide="closeModal"
    :closable="true"
  >
    <template #header>
      {{ isEditMode ? 'Modifier' : 'Créer' }} une Tâche
    </template>
    <div
      class="d-flex flex-column scroll-y px-3 px-lg-5 "
    >
    <Card   class="bg-secondary">
       <template #content>
        <div class="row">
            <div class="fv-row fv-plugins-icon-container col-md-6 col-md-6">
          <label class="required fw-semibold fs-6 mb-2">Titre</label>
          <InputText
            type="text"
            name="designation"
            class="form-control  mb-3 mb-lg-0"
            placeholder="titre de la tâche"
            v-model="form.description"
            required
          />
          <div
            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
          ></div>
        </div>
        <div class="fv-row fv-plugins-icon-container col-md-6">
          <label class="required fw-semibold fs-6 mb-2">Responsable</label>
          <Dropdown
            v-model="form.owner"
            :options="users"
            optionLabel="name"
            optionValue="id"
            placeholder="Sélectionner un responsable"
            class="w-full md:w-14rem"
          />
          <div
            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
          ></div>
        </div>
        <div class="col-md-6 ">
          <!--begin::Label-->
          <label class="fw-semibold fs-6 mb-2">
            <span class="">Status</span>
          </label>
          <!--end::Label-->
          <!--begin::Col-->
          <div class="fv-row ">
            <Dropdown
              v-model="form.status"
              :options="[
                { name: 'En attente', value: 'pending' },
                { name: 'En cours', value: 'in_progress' },
                { name: 'Terminée', value: 'completed' },
                { name: 'Annulée', value: 'canceled' },
              ]"
              optionLabel="name"
              optionValue="value"
              placeholder="Sélectionner un status"
              class="w-full md:w-14rem"
            />
          </div>
          <!--end::Col-->
        </div>
        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
          <label class="required fw-semibold fs-6 mb-2">Priorité</label>
          <Dropdown
            v-model="form.priority_id"
            :options="priorities"
            optionLabel="title"
            optionValue="id"
            placeholder="Sélectionner une priorité"
            class="w-full md:w-14rem"
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
                v-model="form.project_id"
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
      <Card class="mt-2 bg-secondary">
        <template #title>
            Assigner à
        </template>
        <template #content>
            <div class="fv-row  fv-plugins-icon-container row">
                    <div class="col-md-6">
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
            </div>
        <!-- Conditional rendering for user/team selection -->

        </template>
      </Card>
      <div class="row mt-3">
        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
          <label class="required fw-semibold fs-6 mb-2">Date de debut</label>
          <Calendar
            v-model="form.start_date"
            dateFormat="yy-mm-dd"
            showTime
                hourFormat="24"
            class="form-control form-control-solid mb-3 mb-lg-0"
            placeholder="Date de debut"
            required
          />
          <div
            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
          ></div>
        </div>
        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
          <label class="required fw-semibold fs-6 mb-2">Date de fin</label>
          <Calendar
            v-model="form.due_date"
            dateFormat="yy-mm-dd"
            showTime
                hourFormat="24"
            class="form-control form-control-solid mb-3 mb-lg-0"
            placeholder="Date de fin"
            required
          />
          <div
            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
          ></div>
        </div>
      </div>
       <Card class="bg-secondary">
           <template #content>
            <div class="fv-row mb-7 fv-plugins-icon-container">
                <div class="d-flex justify-content-end">
                     <Button label="Ajouter une instruction" icon="pi pi-plus-circle" @click="addInstruction" severity="warn" class="p-button-primary"/>
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
                    class="form-control  mb-3 mb-lg-0"
                    placeholder="Description de l'instruction"
                    v-model="instruction.description"
                    @input="addInstructionValue('description',instruction.description, index)"
                />
                </div>
                <div class="col-md-3">
                    <Dropdown
                        class="w-full md:w-14rem"
                        v-model="instruction.response_type"
                        :options="['checkbox', 'text / valeur']"
                        placeholder="Type de reponse"
                        @change="addInstructionValue('response_type',instruction.response_type, index)"
                    />
                </div>
                <div class="col-md-1 d-flex align-items-start justify-content-start"  @click="removeInstruction(index)">
                    <button ><i class="fa fa-trash text-danger m-0 p-0 display-6"></i></button>
                </div>
            </div>
          </div>
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
        @click="closeModal"
      />
      <Button
        label="Enregistrer"
        icon="pi pi-check"
        severity="warn"
        class="p-button-primary"
        raised
        @click="submitTask"
      />
    </template>
  </Dialog>

    </div>
</template>
<script>
import { useCookie } from "@vue-composable/cookie";
import { computed, onMounted, reactive, ref } from "vue";
import useInstructions from '../../services/instructionServices.js';
import usePriorities from "../../services/priorityServices.js";
import useProjects from "../../services/projectServices.js";
import useTasks from "../../services/taskServices.js";
import useTeams from "../../services/teamServices.js"; // Import useTeams
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
            isLoading
        } = useTasks();
        const {getProjects,projects}=useProjects();
        const { getUsers, users } = useUsers();
        const { getTeams, teams } = useTeams(); // Initialize useTeams
        const taskCategories = ref([]);
        const isEditMode = ref(false);
        const searchQuery = ref('');
        const showTableView = ref(false);
        const { priorities, getPriorities } = usePriorities();
        const {storeInstruction,deleteInstruction,getInstructions}=useInstructions ();
        const form = reactive({
            id: null,
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
            start_time:null,
            assignToType: 'user', // Default to assigning to a user
            assigned_user_id: null,
            assigned_team_id: null,
            instructions:[]
        });
        const instructions = ref({})
        const visible=ref(false);
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
                    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.round((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

                    // Format the delay string
                    let delayString = "";

                    if (days > 0) {
                        delayString += `${days} jour${days > 1 ? 's' : ''} `;
                    }
                    if (hours > 0) {
                        delayString += `${hours}h `;
                    }
                    if (minutes > 0) {
                        delayString += `${minutes}min`;
                    }
                    if(days===0 && hours===0 && minutes===0){
                      delayString = "0 min"
                    }
                    form.delay = delayString.trim();

                }else {
                form.delay = null; // Reset the delay if one of the dates is missing
            }
        };
        // Set default time to 00:00 for new dates
         const setDefaultTime = (dateString) => {
            if (dateString) {
                return dateString.split('T')[0] + 'T00:00';
            }
            return null;
        };
        onMounted(async () => {
            await getTasks();
            taskCategories.value = await getTaskCategories();
            await getUsers();
            await getProjects();
            await getTeams(); // Fetch teams on component mount
            await getPriorities();
             showTableView.value=true;//add
             form.start_date = setDefaultTime(new Date().toISOString());
             form.due_date = setDefaultTime(new Date().toISOString());
        });

        const submitTask = async () => {
            let success = false;
            console.log("sddddddddddddd");
            console.log({...form});
            // Check if it's assigned to a user or a team
            if (form.assignToType === 'user') {
                form.assigned_team_id = null;
            } else if (form.assignToType === 'team') {
                form.assigned_user_id = null;
            }
            if (isEditMode.value) {
                success = await updateTask(form.id, form);
            } else {
                success = await storeTask(form);
            }
            if (success) {
                await getTasks();
                visible.value=false;
                resetForm();
            }
        };

        const addTask = () => {
            isEditMode.value = false;
            visible.value=true;
             form.start_date = setDefaultTime(new Date().toISOString());
             form.due_date = setDefaultTime(new Date().toISOString());

            resetForm();
        };

        const editTask = (task) => {
            isEditMode.value = true;
            visible.value=true;
            Object.assign(form, task);
            form.assignToType = task.assigned_user_id ? 'user' : 'team';
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
            form.priority_id = null;
            form.status = "pending";
            form.comments = "";
            form.complete = null;
            form.description = "";
            form.type = "";
            form.user_id = null;
            form.category_id = null;
            form.category=null;
            form.owner = null;
            form.task_id = null;
            form.assigned_date = null;
            form.start_date = setDefaultTime(new Date().toISOString());
            form.due_date = setDefaultTime(new Date().toISOString());
            form.delay = null;
            form.start_time=null;
            form.end_time=null;
            form.assignToType = 'user';
            form.assigned_user_id = null;
            form.assigned_team_id = null;
            form.instructions = [];
        };
        const addInstruction=()=>{
            form.instructions.push({
                description: "",
                response_type: ""
            });
        }
        const filteredTasks = computed(() => {
            return tasks.value.filter(task => {
                return task.description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       task.priority.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       task.status.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       (task.category && task.category.name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
                       (task.project && task.project.name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
                       (task.start_date.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
                       (task.due_date.toLowerCase().includes(searchQuery.value.toLowerCase()))
                       ;
            });
        });
        const toggleView = () => {
            showTableView.value = !showTableView.value;
        };
        const showTimeFieldsF=()=>{
            if(form.start_date && form.due_date){
                return false;
            }
            else return true;
        };
        const showTimeFields=reactive(showTimeFieldsF());
        const formatDeadline = (end_date, start_date, task) => {
            if (start_date && end_date) {
                const startDate = new Date(start_date);
                const endDate = new Date(end_date);
                const now = new Date();

                let timeDifference;
                let isPast = false;

                if ((endDate.getTime() < now) && task.status != 'completed') {
                    // timeDifference = Math.abs(endDate.getTime() - now.getTime());
                    isPast = true;
                } else {
                    timeDifference = endDate.getTime() - startDate.getTime();
                }
                   const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.round((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

                let delayString = `${isPast ? 'DeadlineExceed' : ''}`;

                if (days > 0) {
                    delayString += `${days} jour${days > 1 ? 's' : ''} `;
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
      const addInstructionValue=(type,value, index)=>{
        form.instructions[index][type]=value;
        console.log(form.instructions);
      }
      const removeInstruction = (index) => {
        form.instructions.splice(index, 1);
      };
      const closeModal=()=>{
        visible.value=false;
      }
      const formatDate=(dateLocal)=>{
    const date = new Date(dateLocal);
    return new Intl.DateTimeFormat('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    }).format(date);
}
        return {
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
            closeModal


        };
    },
};
</script>

