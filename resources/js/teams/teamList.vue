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
                            <Button label="Ajouter une Equipe"  icon="pi pi-plus" severity="warn" class="p-button-primary" @click="addTeam" />
                        </div>
                    </div>
                </div>

                <div v-if="isLoading" class="text-center">
                    <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="8" fill="var(--surface-ground)"
                        animationDuration=".5s" />
                </div>
                <div v-else id="kt_app_content" class="app-content flex-column-fluid">
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <div class="card card-flush">
                            <div class="card-header mt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1 me-5">
                                        <i class="pi pi-search fs-3 position-absolute ms-5"></i>
                                        <InputText type="text"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Rechercher une équipe" v-model="searchQuery" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <DataTable :value="filteredTeams" removableSort tableStyle="min-width: 50rem"  :paginator="true" :rows="10"
                                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                                    :rowsPerPageOptions="[5, 10, 25, 50]"
                                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} equipes"
                                    >
                                    <Column field="name" header="Nom" sortable />
                                    <Column field="description" sortable header="Description" />
                                        <Column field="region.titre" sortable header="Region" >
                                    </Column>
                                    <Column field="vehicule" sortable header="Véhicule" />
                                    <Column header="Chef d'équipe">
                                        <template #body="slotProps">
                                            {{ slotProps.data.user ? slotProps.data.user.name : 'N/A' }}
                                        </template>
                                    </Column>
                                    <Column header="Membres">
                                        <template #body="slotProps">
                                            <ul class="list-unstyled">
                                                <li class=" d-flex my-2" v-for="member in slotProps.data.users" :key="member.id">
                                                   <span class="badge badge-light-info" >
                                                    {{ member.name }}
                                                </span>
                                                </li>
                                            </ul>
                                        </template>
                                    </Column>
                                    <Column header="Actions" style="text-align: right">
                                        <template #body="slotProps">
                                            <Button icon="pi pi-pencil" class="p-button-text p-button-secondary"
                                                @click="editTeam(slotProps.data)" />
                                            <Button icon="pi pi-trash" class="p-button-text p-button-secondary"
                                                @click="deleteTeam(slotProps.data.id)" />
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Dialog v-model:visible="teamModalVisible"
            :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '640px': '100vw' }" :modal="true" class="p-fluid"
            @hide="resetForm">
            <template #header>
                <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="me-4 ">
                <span class="fw-bold">{{  isEditMode ? 'Modifier' : 'Créer' + ' une Equipe' }}</span>
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
              />
            </div>
          </div>
            </template>
            <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll">
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <label class="required fw-semibold fs-6 mb-2">Nom</label>
                    <InputText type="text" class="form-control form-control-solid mb-3 mb-lg-0"
                        placeholder="Nom de l'équipe" v-model="form.name" required />
                    <div
                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <label class="fw-semibold fs-6 mb-2">Description</label>
                    <Textarea class="form-control form-control-solid mb-3 mb-lg-0"
                        placeholder="Description de l'équipe" v-model="form.description" />
                    <div
                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <label class="required fw-semibold fs-6 mb-2">Chef d'équipe</label>
                    <Dropdown  class="w-full md:w-14rem col-12"
              :filter="true"
              filterBy="name,post_name, email"
                        aria-label="Chef d'équipe" v-model="form.user_id" :options="users" :optionLabel="(user) => `${user.name ?? ''} ${user.post_name ?? ''}  ${user.nickname ?? ''}`" optionValue="id"
                        placeholder="Selectionner un chef d'équipe" @change="handleChangeChiefTeam" />
                    <div
                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="fv-row mb-7 fv-plugins-icon-container">
                    <label class="fw-semibold fs-6 mb-2 d-block">Membres</label>
                        <MultiSelect
                        v-model="form.members"
                        :options="users"
                        :optionLabel="
                      (user) =>
                        `${user.name ?? ''} ${user.post_name ?? ''}  ${
                          user.nickname ?? ''
                        }`
                    "
                    :filter="true"
                    filterBy="name,post_name, email"
                        optionValue="id"
                         class="w-full md:w-14rem w-100"
                        placeholder="Selectionner les membres de l'equipes"
                        >

                        </MultiSelect>

                </div>
            </div>
             <template #footer>
                <Button label="Annuler" icon="pi pi-times" class="p-button-text" @click="teamModalVisible = false" />
                <Button label="Sauvegarder" severity="warn" icon="pi pi-check" @click="submitTeam" class="p-button-primary"/>
            </template>
        </Dialog>
    </div>
</template>

<script>

import { computed, onMounted, reactive, ref } from 'vue';
import useRegion from '../services/regionServices.js';
import useTeams from '../services/teamServices.js';
import useUsers from '../services/userServices.js';
export default {
    setup() {
        const { teams, getTeams, storeTeam,destroyTeam, updateTeam, isLoading } = useTeams();
        const { getUsers, users } = useUsers();
        const {getRegions, regions} =useRegion();
        const isEditMode = ref(false);
        const searchQuery = ref('');
        const teamModalVisible = ref(false);

        const form = reactive({
            id: null,
            name: '',
            description: '',
            user_id: null,
            members: [],
            region_id:null,
        });

        onMounted(async () => {
            await getTeams();
            await getUsers();
            await getRegions();
        });

        const submitTeam = async () => {
            let success = false;
            console.log(form);

            if (isEditMode.value) {
                success = await updateTeam(form.id, form);
            } else {
                success = await storeTeam(form);
                resetForm();
            }
            if (success) {
                await getTeams();
                 teamModalVisible.value = false;

            }
        };

        const addTeam = () => {
            resetForm();
            isEditMode.value = false;
            teamModalVisible.value = true;

        };

        const editTeam = (team) => {
            resetForm();
            isEditMode.value = true;
           teamModalVisible.value=true;
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
            form.region_id=null;
        };

        const filteredTeams = computed(() => {
            return teams.value.filter(team => {
                return team.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                       (team.description && team.description.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
                       (team.user && team.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
            });
        });
const handleChangeChiefTeam =()=>{
    // form.members.values=[1];
    // console.log(form.members);
}
const deleteTeam=async(teamId)=>{
   await destroyTeam(teamId);
    await getTeams();
}
        return {
            deleteTeam,
            handleChangeChiefTeam,
            regions,
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
            teamModalVisible
        };
    },
};
</script>
