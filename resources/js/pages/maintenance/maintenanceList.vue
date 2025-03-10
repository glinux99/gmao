<template>
    <div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Liste des Maintenances
                            </h1>
                        </div>

                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <!-- Toggle View Button -->
                            <button type="button" class="btn btn-light btn-active-light-primary me-2" @click="toggleView">
                                <span v-if="showTableView">Vue Grille</span>
                                <span v-else>Vue Liste</span>
                            </button>
                            <!-- End Toggle View Button -->
                            <button type="button" class="btn btn-primary" @click="addMaintenance">
                                Ajouter une Maintenance
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
                                            placeholder="Rechercher une maintenance" v-model="searchQuery" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 w-100">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                                    id="kt_permissions_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="">Description</th>
                                            <th class="">Equipment</th>
                                            <th class="">Status</th>
                                            <th class="">Work Order</th>
                                            <th class="">Date de debut</th>
                                            <th class="">DeadLine</th>
                                            <th class="">Technicien</th>
                                            <th class="text-end ">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="maintenance in filteredMaintenances" :key="maintenance.id">
                                            <td>{{ maintenance.description }}</td>
                                            <td>{{ maintenance.equipment ? maintenance.equipment.name : 'N/A' }}</td>
                                            <td>
                                                <span v-if="maintenance.status === 'pending'"
                                                    class="badge badge-warning">En attente</span>
                                                <span v-else-if="maintenance.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="maintenance.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                    <span v-else-if="maintenance.status === 'canceled'"
                                                    class="badge badge-dark">Annulée</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </td>
                                            <td>{{ maintenance.work_order }}</td>
                                            <td>{{ maintenance.start_date }}</td>
                                            <td>
                                                <span class="fs-8">
                                                   Debut : {{ maintenance.start_date }} <br>
                                                </span>
                                                <span class="fs-8 text-center">
                                                    <span class="badge badge-light-success"> {{  formatDeadline(maintenance.end_date,maintenance.start_date) }}</span>

                                            </span></td>
                                            <td>{{ maintenance.user ? maintenance.user.name : 'N/A' }}</td>
                                            <td class="text-end">
                                                <!-- <button @click="viewMaintenance(maintenance.id)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                    <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                            class="path2"></span><span class="path3"></span><span
                                                            class="path4"></span><span class="path5"></span></i>
                                                </button> -->

                                                <button @click="editMaintenance(maintenance)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_update_maintenance">
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
                            <template v-for="maintenance in maintenances" :key="maintenance.id">
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
                                                <span v-if="maintenance.status === 'pending'" class="badge badge-warning">En
                                                    attente</span>
                                                <span v-else-if="maintenance.status === 'in_progress'"
                                                    class="badge badge-info">En cours</span>
                                                <span v-else-if="maintenance.status === 'completed'"
                                                    class="badge badge-success">Terminée</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>

                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Equipment :
                                                {{ maintenance.equipment ? maintenance.equipment.name : 'N/A' }}
                                            </div>

                                            <div class="fw-bold text-gray-600 mb-5">
                                                Work Order: {{ maintenance.work_order }}
                                            </div>
                                             <div class="fw-bold text-gray-600 mb-5">
                                                Technicien: {{ maintenance.user ? maintenance.user.name : 'N/A' }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                               Debut : {{ maintenance.start_date }} <br>
                                               Duree : <span class="fs-8 text-center">
                                                <span class="badge badge-light-success"> {{  formatDeadline(maintenance.end_date,maintenance.start_date) }}</span>

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

                                            <button @click="editMaintenance(maintenance)"
                                                class="col-12 btn btn-light btn-active-light-primary my-1"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_maintenance">
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
                                            @click="addMaintenance" id="addMaintenance">
                                            <img src="/assets/media/illustrations/sketchy-1/2.png" alt=""
                                                class="mw-100 mh-150px mb-7" />

                                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">
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
        <modal-component :id="'maintenance-modal'" positionModal="center mw-700px" :form="form" @instance-modal="submitMaintenance">
            <template #title>{{ isEditMode ? 'Modifier' : 'Créer' }} une Maintenance</template>
            <template #body>
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                     <div class="row my-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span class="required">Equipement</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                title="equipement"></i>
                        </label>
                        <div class="col-lg-8 fv-row">
                            <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="equipement" v-model="form.equipment_id">
                                <option v-for="equipment in equipments" :value="equipment.id" :key="equipment.id">
                                    {{ equipment.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Description</label>
                            <input type="text" name="designation" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="description de la maintenance" v-model="form.description" >
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Work Order</label>
                             <input type="text" name="work_order" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="work_order" v-model="form.work_order" >
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
                                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Status de la maintenance" v-model="form.status">
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
                                <label class="required fw-semibold fs-6 mb-2">Technicien</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select form-select-solid mb-3 mb-lg-0"
                                aria-label="technicien" v-model="form.user_id">
                                <option value="">Selectionner un technicien</option>
                                <option v-for="user in users" :value="user.id" :key="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
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
                                placeholder="nom de la tâche" :min="form.start_date" v-model="form.end_date"  @input="calculateDelay">
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

                        <div class="fv-row mb-7 fv-plugins-icon-container">
                             <label class="required fw-semibold fs-6 mb-2">Maintenance Cost</label>
                            <input type="number" name="maintenance_cost" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="maintenance_cost" v-model="form.maintenance_cost" >
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
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
import useMaintenances from "../../services/maintenanceService.js";
import modalComponent from "../../components/modals/modalComponent.vue";
import { useCookie } from "@vue-composable/cookie";
import useUsers from "../../services/userservices.js";
import { DatePicker } from "primevue";
import useEquipments from "../../services/equipmentService.js";
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
            isLoading
        } = useMaintenances();
        const { getUsers, users} = useUsers();
        const { getEquipments, equipments } = useEquipments();
        const isEditMode = ref(false);
        const searchQuery = ref('');
        const showTableView = ref(false)

        const form = reactive({
            id: null,
            description: "",
            status: "pending",
            work_order: "",
            equipment_id: null,
            user_id: null,
            start_date: null,
            end_date:  null,
            man_hours: null,
            delay: null,
            maintenance_cost: null
        });

        // Set default time to 00:00 for new dates
         const setDefaultTime = (dateString) => {
            if (dateString) {
                return dateString.split('T')[0] + 'T00:00';
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
        });

        const submitMaintenance = async () => {
            console.log({...form});
            console.log("form.value");
            let success = false;
            if (isEditMode.value) {
                success = await updateMaintenance(form.id, {...form});
            } else {
                success = await storeMaintenance({...form});
            }
            if (success) {
                await getMaintenances();
                $("#maintenance-modal").modal("hide");
                resetForm();
            }
        };

        const addMaintenance = () => {
            isEditMode.value = false;
            $("#maintenance-modal").modal("show");
            form.start_date = setDefaultTime(new Date().toISOString());
            form.end_date = setDefaultTime(new Date().toISOString());
            calculateDelay();
            resetForm();
        };

        const editMaintenance = (maintenance) => {
            isEditMode.value = true;
            $("#maintenance-modal").modal("show");
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
            form.delay=null;
            form.maintenance_cost = null;
        };

        const filteredMaintenances = computed(() => {
            return maintenances.value.filter(maintenance => {
                return maintenance.description.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       (maintenance.equipment && maintenance.equipment.name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
                        maintenance.work_order.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       maintenance.status.toLowerCase().includes(searchQuery.value.toLowerCase())||
                       (maintenance.user && maintenance.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
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

            errors,
            isLoading,
            showTableView,
            searchQuery,
            filteredMaintenances,

        };
    },
};
</script>
