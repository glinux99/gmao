<template>
    <div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
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
                                            <th class="min-w-125px">Categorie</th>
                                            <th class="min-w-125px">Duree</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="task in filteredTasks" :key="task.id" >
                                            <td>{{ task.description }}</td>
                                            <td>
                                                <span v-if="task.priority=='Elevé'" class="badge badge-danger">
                                                    {{ task.priority }}
                                                </span>
                                                <span v-else-if="task.priority=='Moyen'" class="badge badge-light-secondary">
                                                    {{ task.priority }}
                                                </span>
                                                <span v-else-if="task.priority=='Faible'" class="badge badge-light-info">
                                                    {{ task.priority }}
                                                </span>
                                                <span v-else class="badge badge-light-primary">
                                                    {{ task.priority }}
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
                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </td>
                                            <td>{{ task.project ? task.project.name  : 'N/A' }}</td>
                                            <td><span class="badge badge-light-primary">
                                                {{ task.category  }}
                                            </span></td>
                                            <td class="fs-7">{{  formatDeadline(task.due_date,task.start_date) }}</td>
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
                                                Priorité: {{ task.priority }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Status:
                                                <span v-if="task.status === 'pending'" class="badge badge-warning">En
                                                    attente</span>
                                                <span v-else-if="task.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="task.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>

                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Projet : {{ task.project ? task.project.name : 'N/A' }}
                                            </div>

                                            <div class="fw-bold text-gray-600 mb-5">
                                                {{  formatDeadline(task.due_date,task.start_date) }}
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
        <modal-component :id="'task-modal'" positionModal="center mw-700px" :form="form" @instance-modal="submitTask">
            <template #title>{{ isEditMode ? 'Modifier' : 'Créer' }} une Tâche</template>
            <template #body>
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="my-6">
                                <label class="col-form-label fw-bold fs-6">
                                    <span class="required">Projet</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="categorie"></i>
                                </label>
                                <div class="fv-row">
                                    <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="project" v-model="form.project_id">
                                        <option v-for="project in projects" :value="project.id" :key="project.id">
                                            {{ project.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="my-6">
                                <!--begin::Label-->
                                <label class="col-form-label fw-bold fs-6">
                                    <span class="required">Catégorie</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="catégorie de tâche"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="">
                                    <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="categorie de la tâche" v-model="form.category">
                                        <option value="Préventive">Préventive</option>
                                        <option value="Corrective">Corrective</option>
                                        <option value="Predictive">Predictive</option>
                                        <option value="Inspection">Inspection</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                    </div>
                                        <div class="row">
                        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Titre</label>
                            <input type="text" name="designation" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="titre de la tâche" v-model="form.description" required>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Proprietaire</label>
                            <select class="form-select form-select-solid mb-3 mb-lg-0"
                                aria-label="Proprietaire de la tâche" v-model="form.owner">
                                <option value="">Selectionner un propriétaire</option>

                                <option v-for="user in users" :value="user.id" :key="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                         <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="required">Status</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                    title="Status"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Status de la tâche" v-model="form.status">
                                    <option value="pending">En attente</option>
                                    <option value="in_progress">En cours</option>
                                    <option value="completed">Terminée</option>
                                    <option value="canceled">Annulée</option>
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="fv-row mb-7 fv-plugins-icon-container row">
                            <div class="col-md-4">
                                <label class="required fw-semibold fs-6 mb-2">Assigne</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select form-select-solid mb-3 mb-lg-0"
                                aria-label="Proprietaire de la tâche" v-model="form.user_id">
                                <option value="">Selectionner un utilisateur</option>
                                <option v-for="user in users" :value="user.id" :key="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="required">Priorite</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                    title="Priorite"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Status de la tâche" v-model="form.priority">
                                    <option value="Elevé">Elevé</option>
                                    <option value="Moyen">Moyen</option>
                                    <option value="Faible">Faible</option>
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="d-flex gap-2">
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    Date de debut
                                </label>
                                <input type="datetime-local" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="nom de la tâche" v-model="form.start_date" @input="calculateDelay">
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-bold form-label mb-2">
                                    Date de fin
                                </label>
                                <input type="datetime-local" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="nom de la tâche" :min="form.start_date" v-model="form.due_date"  @input="calculateDelay">
                            </div>
                            <div class="fv-row mb-10 d-flex flex-column align-items-center justify-content-center">
                                <label class="fs-5 fw-bold form-label mb-2 ">
                                    Deadline
                                </label>
                                <span class="badge-success rounded p-2">
                                    {{ form.delay? form.delay : "Immediate"}}
                                </span>
                            </div>

                        </div>

                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input me-3" name="notification"
                                type="checkbox" value="1" checked>
                            <label class="form-check-label" >
                                <div class="fw-bold text-gray-800">Envoyer une notification si le deadline depasse?</div>
                                <div class="text-gray-600">
                                </div>
                            </label>

                        </div>
                    </div>

                </div>
            </template>
        </modal-component>
    </div>
</template>

<script>
import { onMounted, reactive, ref, computed } from "vue";
import useTasks from "../../services/taskServices.js";
import modalComponent from "../../components/modals/modalComponent.vue";
import { useCookie } from "@vue-composable/cookie";
import useUsers from "../../services/userservices.js";
import { DatePicker } from "primevue";
import useProjects from "../../services/projectServices.js";
export default {
    components: {
        DatePicker,
        modalComponent,
    },
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
        const taskCategories = ref([]);
        const isEditMode = ref(false);
        const searchQuery = ref('');
        const showTableView = ref(false)

        const form = reactive({
            id: null,
            priority: "",
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
        });

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
             showTableView.value=true;//add
             form.start_date = setDefaultTime(new Date().toISOString());
             form.due_date = setDefaultTime(new Date().toISOString());
        });

        const submitTask = async () => {
            let success = false;
            if (isEditMode.value) {
                success = await updateTask(form.id, form);
            } else {
                success = await storeTask(form);
            }
            if (success) {
                await getTasks();
                $("#task-modal").modal("hide");
                resetForm();
            }
        };

        const addTask = () => {
            isEditMode.value = false;
            $("#task-modal").modal("show");
             form.start_date = setDefaultTime(new Date().toISOString());
             form.due_date = setDefaultTime(new Date().toISOString());
            resetForm();
        };

        const editTask = (task) => {
            isEditMode.value = true;
            $("#task-modal").modal("show");
            Object.assign(form, task);
            form.start_date = setDefaultTime(form.start_date);
            form.due_date = setDefaultTime(form.due_date);
            calculateDelay();
        };

        const viewTask = (id) => {
            const taskCookie = useCookie("task");
            taskCookie.setCookie(id);
            location.href = `/tasks/${id}`;
        };

        const resetForm = () => {
            form.id = null;
            form.priority = "";
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
        };

        const filteredTasks = computed(() => {
            return tasks.value.filter(task => {
                return task.description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       task.priority.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       task.status.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       (task.category && task.category.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
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
        const formatDeadline = (end_date, start_date) => {
            if (start_date && end_date) {
                const startDate = new Date(start_date);
                const endDate = new Date(end_date);
                const now = new Date();

                let timeDifference;
                let isPast = false;

                if (startDate < now) {
                    timeDifference = endDate.getTime() - now.getTime();
                    isPast = true;
                } else {
                    timeDifference = endDate.getTime() - startDate.getTime();
                }
                   const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.round((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

                let delayString = ``;

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
        return {
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

        };
    },
};
</script>
