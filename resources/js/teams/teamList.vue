<template>
    <div>
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <h1
                                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                Liste des Equipes
                            </h1>
                        </div>

                        <div class="d-flex align-items-center gap-2 gap-lg-3">
                            <button type="button" class="btn btn-primary" @click="addTeam">
                                Ajouter une Equipe
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="isLoading">Loading...</div>
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <div class="card card-flush">
                            <div class="card-header mt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1 me-5">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <input type="text" data-kt-permissions-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Rechercher une équipe" v-model="searchQuery" />
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
                                            <th class="min-w-125px">Chef d'équipe</th>
                                            <th class="min-w-125px">Membres</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr v-for="team in filteredTeams" :key="team.id">
                                            <td>{{ team.name }}</td>
                                            <td>{{ team.description }}</td>
                                            <td>{{ team.user ? team.user.name : 'N/A' }}</td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li v-for="member in team.users" :key="member.id">
                                                        {{ member.name }}
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="text-end">
                                                <button @click="editTeam(team)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_update_team">
                                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                            class="path2"></span><span class="path3"></span><span
                                                            class="path4"></span><span class="path5"></span></i>
                                                </button>
                                                <button @click="configureMembers(team)"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-user-edit fs-3"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal-component :id="'team-modal'" positionModal="center mw-800px" :form="form" @instance-modal="submitTeam">
            <template #title>{{ isEditMode ? 'Modifier' : 'Créer' }} une Equipe</template>
            <template #body>
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="required fw-semibold fs-6 mb-2">Nom</label>
                        <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Nom de l'équipe" v-model="form.name" required>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="fw-semibold fs-6 mb-2">Description</label>
                        <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Description de l'équipe" v-model="form.description"></textarea>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="required fw-semibold fs-6 mb-2">Chef d'équipe</label>
                        <select class="form-select form-select-solid mb-3 mb-lg-0"
                            aria-label="Chef d'équipe" v-model="form.user_id">
                            <option value="">Selectionner un chef d'équipe</option>
                            <option v-for="user in users" :value="user.id" :key="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="fw-semibold fs-6 mb-2">Membres</label>
                        <div v-for="user in users" :key="user.id" class="form-check">
                            <input class="form-check-input" type="checkbox" :value="user.id"
                                :id="'member-' + user.id" v-model="form.members">
                            <label class="form-check-label" :for="'member-' + user.id">
                                {{ user.name }}
                            </label>
                        </div>
                    </div>
                </div>
            </template>
        </modal-component>
    </div>
</template>

<script>
import { computed, onMounted, reactive, ref } from 'vue';
import modalComponent from '../components/modals/modalComponent.vue';
import useTeams from '../services/teamServices.js';
import useUsers from '../services/userServices.js';
export default {
    components: {
        modalComponent,
    },
    setup() {
        const { teams, getTeams, storeTeam, updateTeam, isLoading } = useTeams();
        const { getUsers, users } = useUsers();
        const isEditMode = ref(false);
        const searchQuery = ref('');

        const form = reactive({
            id: null,
            name: '',
            description: '',
            user_id: null,
            members: [],
        });

        onMounted(async () => {
            await getTeams();
            await getUsers();
        });

        const submitTeam = async () => {
            let success = false;
            if (isEditMode.value) {
                success = await updateTeam(form.id, form);
            } else {
                success = await storeTeam(form);
            }
            if (success) {
                await getTeams();
                $("#team-modal").modal("hide");
                resetForm();
            }
        };

        const addTeam = () => {
            isEditMode.value = false;
            $("#team-modal").modal("show");
            resetForm();
        };

        const editTeam = (team) => {
            isEditMode.value = true;
            $("#team-modal").modal("show");
            Object.assign(form, { ...team, members: team.users.map(user => user.id) });
        };
        const configureMembers = (team) => {
            editTeam(team);
        };

        const resetForm = () => {
            form.id = null;
            form.name = '';
            form.description = '';
            form.user_id = null;
            form.members = [];
        };

        const filteredTeams = computed(() => {
            return teams.value.filter(team => {
                return team.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       (team.description && team.description.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
                       (team.user && team.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
            });
        });

        return {
            teams,
            form,
            addTeam,
            submitTeam,
            isEditMode,
            editTeam,
            users,
            isLoading,
            searchQuery,
            filteredTeams,
            configureMembers,
        };
    },
};
</script>
