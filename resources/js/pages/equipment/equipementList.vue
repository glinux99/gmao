<template>
    <div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Liste des Equipements
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
                            <button type="button" class="btn btn-primary" @click="addEquipment">
                                Ajouter un équipement
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="isLoading">Loading...</div>
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!-- Display the table view if showTableView is true -->
                    <div v-if="showTableView" id="kt_app_content_container_d-none"
                        class="app-container container-xxl">
                        <div class="card card-flush">
                            <div class="card-header mt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1 me-5">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <input type="text" data-kt-permissions-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Rechercher un équipement" v-model="searchQuery" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                                    id="kt_permissions_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Nom</th>
                                            <th class="min-w-125px">N° Série</th>
                                            <th class="min-w-125px">Status</th>
                                            <th class="min-w-125px">Projet</th>
                                            <th class="min-w-125px">Utilisateur</th>
                                            <th class="min-w-125px">Date Achat</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="equipment in filteredEquipments" :key="equipment.id">
                                            <td>{{ equipment.name }}</td>
                                            <td>{{ equipment.serial_number }}</td>
                                            <td>
                                                <span v-if="equipment.status === 'available'"
                                                    class="badge badge-success">Disponible</span>
                                                <span v-else-if="equipment.status === 'in_use'"
                                                    class="badge badge-info">En cours d'utilisation</span>
                                                <span v-else-if="equipment.status === 'under_maintenance'"
                                                    class="badge badge-warning">En maintenance</span>
                                                <span v-else-if="equipment.status === 'broken'"
                                                    class="badge badge-danger">Cassé</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </td>
                                            <td>{{ equipment.project ? equipment.project.name : 'N/A' }}</td>
                                            <td>{{ equipment.user ? equipment.user.name : 'N/A' }}</td>
                                            <td>{{ equipment.purchase_date }}</td>
                                            <td class="text-end">
                                                <button @click="viewEquipment(equipment.id)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                                    <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                            class="path2"></span><span class="path3"></span><span
                                                            class="path4"></span><span class="path5"></span></i>
                                                </button>

                                                <button @click="editEquipment(equipment)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_update_equipment">
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
                            <template v-for="equipment in equipments" :key="equipment.id">
                                <div class="col-md-4">
                                    <div class="card card-flush h-md-100">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Equipement: {{ equipment.id }}</h2>
                                            </div>
                                        </div>

                                        <div class="card-body pt-1">
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Nom: {{ equipment.name }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                N° Série: {{ equipment.serial_number }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Status:
                                                <span v-if="equipment.status === 'available'"
                                                    class="badge badge-success">Disponible</span>
                                                <span v-else-if="equipment.status === 'in_use'"
                                                    class="badge badge-info">En cours d'utilisation</span>
                                                <span v-else-if="equipment.status === 'under_maintenance'"
                                                    class="badge badge-warning">En maintenance</span>
                                                <span v-else-if="equipment.status === 'broken'"
                                                    class="badge badge-danger">Cassé</span>
                                                <span v-else class="badge badge-secondary">Inconnu</span>
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Projet : {{ equipment.project ? equipment.project.name : 'N/A' }}
                                            </div>
                                            <div class="fw-bold text-gray-600 mb-5">
                                                Utilisateur : {{ equipment.user ? equipment.user.name : 'N/A' }}
                                            </div>

                                            <div class="fw-bold text-gray-600 mb-5">
                                                Date d'achat: {{ equipment.purchase_date }}
                                            </div>
                                        </div>

                                        <div class="card-group p-4">
                                            <button @click="viewEquipment(equipment.id)"
                                                class="card btn btn-light btn-active-primary my-1 me-2 ">
                                                <span>Afficher</span>
                                                <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span><span class="path5"></span></i>
                                            </button>

                                            <button @click="editEquipment(equipment)"
                                                class="card btn btn-light btn-active-light-primary my-1"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_equipment">
                                                Editer
                                                <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
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
                                            @click="addEquipment" id="addEquipment">
                                            <img src="/assets/media/illustrations/sketchy-1/2.png" alt=""
                                                class="mw-100 mh-150px mb-7" />

                                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">
                                                Ajouter un nouvel équipement
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
        <modal-component :id="'equipment-modal'" positionModal="center mw-700px" :form="form"
            @instance-modal="submitEquipment">
            <template #title>{{ isEditMode ? 'Modifier' : 'Créer' }} un équipement</template>
            <template #body>
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                    <div class="row mb-6">
                        <div class="col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Nom</label>
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Nom de l'équipement" v-model="form.name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold fs-6 mb-2">N° Série</label>
                            <input type="text" name="serial_number"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Numéro de série" v-model="form.serial_number">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-md-6">
                            <label class="required fw-semibold fs-6 mb-2">Status</label>
                            <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Status"
                                v-model="form.status">
                                <option value="available">Disponible</option>
                                <option value="in_use">En cours d'utilisation</option>
                                <option value="under_maintenance">En maintenance</option>
                                <option value="broken">Cassé</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <input type="text" name="description"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Description" v-model="form.description">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-md-6">
                             <label class="fw-semibold fs-6 mb-2">Projet</label>
                                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="project" v-model="form.project_id">
                                <option value="">Aucun</option>
                                <option v-for="project in projects" :value="project.id" :key="project.id">
                                    {{ project.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold fs-6 mb-2">Utilisateur</label>
                                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="user" v-model="form.user_id">
                                <option value="">Aucun</option>
                                <option v-for="user in users" :value="user.id" :key="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                     <div class="row mb-6">
                        <div class="col-md-6">
                            <label class="fw-semibold fs-6 mb-2">Date d'achat</label>
                            <input type="date" name="purchase_date"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                 v-model="form.purchase_date">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold fs-6 mb-2">Prix d'achat</label>
                            <input type="number" name="purchase_price"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Prix" v-model="form.purchase_price">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-md-6">
                           <label class="fw-semibold fs-6 mb-2">Date de fin de garantie</label>
                            <input type="date" name="warranty_end_date"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                 v-model="form.warranty_end_date">
                        </div>
                    </div>

                </div>
            </template>
        </modal-component>
    </div>
</template>


<script>
import { onMounted, reactive, ref, computed } from "vue";
import useEquipments from '../../services/equipmentService.js';
import modalComponent from "../../components/modals/modalComponent.vue";
import useUsers from "../../services/userservices.js";
import useProjects from "../../services/projectServices.js";

export default {
    components: {
        modalComponent,
    },
    setup() {
        const { equipments, getEquipments, storeEquipment, updateEquipment, destroyEquipment, errors, isLoading } =
            useEquipments();


        const { getUsers, users } = useUsers();
        const { getProjects, projects } = useProjects();
        const isEditMode = ref(false);
        const searchQuery = ref('');
        const showTableView = ref(true);

        const form = reactive({
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

        onMounted(async () => {
            await getEquipments();
            await getUsers();
            await getProjects();
        });

        const filteredEquipments = computed(() => {
            return equipments.value.filter((equipment) => {
                return equipment.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                 (equipment.serial_number !== null && equipment.serial_number.toLowerCase().includes(searchQuery.value.toLowerCase()))||
                  (equipment.project !== null && equipment.project.name.toLowerCase().includes(searchQuery.value.toLowerCase()))||
                  (equipment.user !== null && equipment.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
            });
        });

        const addEquipment = () => {
            isEditMode.value = false;
            resetForm();
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('equipment-modal'));
            modal.show();
        };

        const editEquipment = (equipment) => {
            isEditMode.value = true;
            Object.assign(form, equipment);
           // Show the modal
           const modal = new bootstrap.Modal(document.getElementById('equipment-modal'));
            modal.show();
        };

        const viewEquipment = (equipmentId) => {
          // TODO : add the route to the view page
          console.log("view:", equipmentId)
        };

        const submitEquipment = async () => {
            if (isEditMode.value) {
                await updateEquipment(form.id, form);
            } else {
                await storeEquipment(form);
                console.log(form);
            }
             // Close the modal
             const modal = bootstrap.Modal.getInstance(document.getElementById('equipment-modal'));
            modal.hide();
            resetForm();
        };
        const toggleView = () => {
            showTableView.value = !showTableView.value;
        };

        const resetForm = () => {
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

        return {
            equipments,
            filteredEquipments,
            getEquipments,
            addEquipment,
            editEquipment,
            viewEquipment,
            submitEquipment,
            form,
            isEditMode,
            errors,
            isLoading,
            searchQuery,
            showTableView,
            toggleView,
            projects,
            users,
        };
    },
};
</script>
