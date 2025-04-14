<template>
    <div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Liste des Project
                            </h1>
                        </div>

                        <div class="d-flex align-items-center gap-2 gap-lg-3"><!-- Toggle View Button -->
                            <button type="button" class="btn btn-light btn-active-light-primary me-2" @click="toggleView">
                               <span v-if="showTableView">Vue Grille</span>
                               <span v-else>Vue Liste</span>
                           </button>
                           <!-- End Toggle View Button -->
                            <button type="button" class="btn btn-primary" @click="addProject">
                                Ajouter un project
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
                                            <th class="min-w-125px">Nom</th>
                                            <th class="min-w-125px">Description</th>
                                            <th class="min-w-125px">Status</th>
                                            <th class="min-w-125px d-none">Category</th>
                                            <th class="min-w-125px">Date</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="project in filteredProjects" :key="project.id">
                                            <td>{{ project.name }}</td>
                                            <td>{{ project.name }}</td>
                                            <td>
                                                <span v-if="project.status === 'pending'"
                                                    class="badge badge-warning">En attente</span>
                                                <span v-else-if="project.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="project.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                    <span v-else-if="project.status === 'canceled'"
                                                    class="badge badge-dark">Annulée</span>

                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </td>
                                            <td class="d-none">{{ project.category ? project.category.name : 'N/A' }}</td>
                                            <td>{{ project.created_at }}</td>
                                            <td class="text-end">
                                                <!-- <button @click="viewProject(project.id)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                    <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                                </button> -->

                                                <button @click="editProject(project)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_update_project">
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
                            <template v-for="project in projects" :key="project.id">
                                <div class="col-md-4">
                                    <div class="card card-flush h-md-100">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Projet: {{ project.id }}</h2>
                                            </div>
                                        </div>

                                        <div class="card-body pt-1">
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Code: {{ project.name }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Description: {{ project.name }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Status:
                                                <span v-if="project.status === 'pending'" class="badge badge-warning">En
                                                    attente</span>
                                                <span v-else-if="project.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="project.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                    <span v-else-if="project.status === 'canceled'"
                                                    class="badge badge-dark">Annulée</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>

                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5 d-none">
                                                Category : {{ project.category ? project.category.name : 'N/A' }}
                                            </div>

                                            <div class="fw-bold text-gray-600 mb-5">
                                                Date de creation: {{ project.created_at }}
                                            </div>

                                        </div>

                                        <div class="card-group p-4">
                                            <!-- <button @click="viewProject(project.id)"
                                                class="card btn btn-light btn-active-primary my-1 me-2 ">
                                                <span>Afficher</span>
                                                <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                            </button> -->

                                            <button @click="editProject(project)"
                                                class="col-12 btn btn-light btn-active-light-primary my-1"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_project">
                                                Editer
                                                <i class="ms-5 ki-duotone ki-pencil fs-3"><span class="path1"></span><span
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
                                            @click="addProject" id="addProject">
                                            <img src="/assets/media/illustrations/sketchy-1/2.png" alt=""
                                                class="mw-100 mh-150px mb-7" />

                                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">
                                                Ajouter un nouveau project
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
        <modal-component :id="'project-modal'" positionModal="center mw-700px" :form="form" @instance-modal="submitProject">
            <template #title>{{ isEditMode ? 'Modifier' : 'Créer' }} un projet</template>
            <template #body>
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                    <div class="row">
                        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Code du projet</label>
                            <input type="text" name="designation" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="nom du projet" v-model="form.name" required>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Responsable</label>
                            <select class="form-select form-select-solid mb-3 mb-lg-0"
                                aria-label="Proprietaire de la tâche" v-model="form.user_id">
                                <option value="">Selectionner un responsable</option>
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

                        <div class="row mb-6">
                            <div class="col-lg-4">
                                <label class="col-form-label fw-bold fs-6">
                                    <span class="required">Description</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="categorie"></i>
                                </label>
                            </div>

                            <div class="col-lg-8">
                                <textarea  id="" class="form-control col-lg-8" v-model="form.description"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </template>
        </modal-component>
    </div>
</template>

<script>
import { onMounted, reactive, ref, computed } from "vue";
import useProjects from "../../services/projectServices.js";
import modalComponent from "../../components/modals/modalComponent.vue";
import { useCookie } from "@vue-composable/cookie";
import useUsers from "../../services/userservices.js";
import { DatePicker } from "primevue";
export default {
    components: {
        DatePicker,
        modalComponent,
    },
    setup() {
        const {
            projects,
            getProjects,
            storeProject,
            updateProject,
            getProjectCategories,
            errors,
            isLoading
        } = useProjects();
        const { getUsers, users } = useUsers();
        const projectCategories = ref([]);
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
            owner: null,
            project_id: null,
            assigned_date: null,
            start_date: null,
            due_date: null,
            delay: null,
        });

          // Function to calculate the delay
        const calculateDelay = () => {
            if (form.start_date && form.due_date) {
                const startDate = new Date(form.start_date);
                const dueDate = new Date(form.due_date);

                // Calculate the difference in days
                const timeDifference = dueDate.getTime() - startDate.getTime();
                const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)); // Convert milliseconds to days

                // Set the delay
                form.delay = dayDifference + (dayDifference>1? " jours" : " jour");
            } else {
                form.delay = null; // Reset the delay if one of the dates is missing
            }
        };

        onMounted(async () => {
            await getProjects();
            projectCategories.value = await getProjectCategories();
            await getUsers();
            showTableView.value=true;//add
        });

        const submitProject = async () => {
            let success = false;
            if (isEditMode.value) {
                success = await updateProject(form.id, form);
            } else {
                success = await storeProject(form);
            }
            if (success) {
                await getProjects();
                $("#project-modal").modal("hide");
                resetForm();
            }
        };

        const addProject = () => {
            isEditMode.value = false;
            $("#project-modal").modal("show");
            resetForm();
        };

        const editProject = (project) => {
            isEditMode.value = true;
            $("#project-modal").modal("show");
            Object.assign(form, project);
            calculateDelay();
        };

        const viewProject = (id) => {
            const projectCookie = useCookie("project");
            projectCookie.setCookie(id);
            location.href = `/projects/${id}`;
        };

        const resetForm = () => {
            form.id = null;
            form.status = "pending";;
            form.name = "";
        };

        const filteredProjects = computed(() => {
            return projects.value.filter(project => {
                return project.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       project.priority.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       project.status.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       (project.category && project.category.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
            });
        });
        const toggleView = () => {
            showTableView.value = !showTableView.value;
        };

        return {
            toggleView,
             calculateDelay,
            projects,
            form,
            addProject,
            viewProject,
            submitProject,
            isEditMode,
            editProject,
            projectCategories,
            users,
            errors,
            isLoading,
            showTableView, // expose
            searchQuery,
            filteredProjects,

        };
    },
};
</script>
