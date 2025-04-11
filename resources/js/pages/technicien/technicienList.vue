<template>
    <div class="techniciens-container  login-page">
      <div v-if="isLoading" class="loading-overlay">
        <div class="loading-spinner">
          <span class="spinner-border text-white" role="status" aria-hidden="true"></span>
        </div>
      </div>
        <div class="card" >
            <div class="card-header">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="pi pi-search fs-3 position-absolute ms-5"></i>
                        <InputText v-model="searchQuery" class="form-control form-control-solid w-250px ps-13"
                            placeholder="Rechercher un technicien" @input="filterTechniciens" />
                    </div>
                </div>
                <div class="card-toolbar">
                    <Button label="Ajouter un technicien" icon="pi pi-plus" class="p-button-primary" severity="warn"
                        @click="showAddTechnicienDialog" />
                    <Button label="importer un fichier" icon="pi pi-upload" class="p-button-info"
                        @click="showImportDialog = true" />
                </div>
            </div>

            <div class="card-body">
                <DataTable :value="filteredTechniciens" :paginator="true" :rows="10"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25, 50]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} techniciens"
                    tableStyle="min-width: 50rem">
                    <Column field="name" header="Nom">
                        <template #body="slotProps">
                            <a :href="`/technicians/${slotProps.data.id}/edit`"
                                class="fw-bolder text-gray-800 text-hover-primary fs-6">
                                {{ slotProps.data.name }} {{ slotProps.data.post_name }}  {{ slotProps.data.nickname }}
                            </a>
                            <span class="text-muted fw-bold d-block">
                                {{ slotProps.data.email }}
                            </span>
                        </template>
                    </Column>
                    <Column header="Matricule" field="mat"></Column>
                    <Column header="Region" field="region.titre"></Column>
                    <Column field="roles" header="Fonction">
                        <template #body="slotProps">
                            <template v-for="role in slotProps.data.roles" :key="role.id">
                                <label class="badge badge-success">
                                    {{ role.name }} - {{ slotProps.data.category }}
                                </label>
                            </template>
                            <label class="badge badge-primary">
                                {{ slotProps.data.level }}
                            </label>
                        </template>
                    </Column>
                    <Column field="pointure" header="Pointure / Size">
                        <template #body="slotProps">
                            {{ slotProps.data.size }} / {{ slotProps.data.pointure }}
                        </template>
                    </Column>
                    <Column field="number" header="Contact" />
                    <Column header="Actions">
                        <template #body="slotProps">
                            <a  class="p-button-text p-button-secondary"
                                :href="`/technicians/${slotProps.data.id}/edit`" >
                                <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                            class="path2"></span><span class="path3"></span><span
                                                            class="path4"></span><span class="path5"></span></i>
                                </a>

                            <Button icon="pi pi-trash" class="p-button-danger p-button-text"
                                @click="confirmDeleteTechnicien(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>


        <Dialog v-model:visible="visible" :style="{ width: '50vw' }"
            :breakpoints="{ '960px': '75vw', '640px': '100vw' }" :modal="true" class="p-fluid">
            <template #header>
                <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="me-4 ">
                <span class="fw-bold">Ajouter un technicien</span>
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
                <div class="row">
                    <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                        <label class="required fw-semibold fs-6 mb-2">Nom</label>
                        <InputText v-model="form.name" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="name" />
                        <div v-if="errors.name" class="text-red-500">
                            {{ errors.name[0] }}
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                        <label class="required fw-semibold fs-6 mb-2">Prenom</label>
                        <InputText v-model="form.post_name" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="name" />
                        <div v-if="errors.post_name" class="text-red-500">
                            {{ errors.post_name[0] }}
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                        <label class="required fw-semibold fs-6 mb-2">Telephone</label>
                        <InputText v-model="form.number" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="+243970912428" />
                        <div v-if="errors.number" class="text-red-500">
                            {{ errors.number[0] }}
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <InputText v-model="form.email" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="example@domain.com" />
                        <div v-if="errors.email" class="text-red-500">
                            {{ errors.email[0] }}
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                        <label class="required fw-semibold fs-6 mb-2 col-12">Mot de passe</label>
                        <Password v-model="form.password"
                            class="col-12 w-100" :toggleMask="true"/>

                    </div>
                    <div class="d-flex justify-content-between col-md-6">
                        <div class="mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Size</label>
                        <InputText v-model="form.size" class="w-100"
                            placeholder="XL" />
                        <div v-if="errors.size" class="text-red-500">
                            {{ errors.size[0] }}
                        </div>
                    </div>
                    <div class="mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Pointure</label>
                        <InputNumber v-model="form.pointure" class="w-100"
                            placeholder="41" :min="0" />
                        <div v-if="errors.pointure" class="text-red-500">
                            {{ errors.pointure[0] }}
                        </div>
                    </div>
                    </div>
                    <div class="mb-5 col-md-6 me-1">
                        <label class="required fw-semibold fs-6 mb-5">Categorie</label>
                        <div class="d-flex fv-row">
                            <div class="form-check form-check-custom form-check-solid">
                                <RadioButton name="category" value="Raccordement" inputId="racco" v-model="form.category" />
                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                    <div class="fw-bold text-gray-800">Raccordement</div>
                                    <div class="text-gray-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex fv-row">
                            <div class="form-check form-check-custom form-check-solid">
                                <RadioButton name="category" value="Maintenance" inputId="mainte" v-model="form.category" />
                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                    <div class="fw-bold text-gray-800">Maintenance</div>
                                    <div class="text-gray-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex fv-row">
                            <div class="form-check form-check-custom form-check-solid">
                                <RadioButton name="category" value="Intervention" inputId="inter" v-model="form.category" />
                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                    <div class="fw-bold text-gray-800">Intervention</div>
                                    <div class="text-gray-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5 col-md-5">
                        <label class="required fw-semibold fs-6 mb-5">Niveau d'habilitation</label>
                        <div class="d-flex fv-row">
                            <div class="form-check form-check-custom form-check-solid">
                                <RadioButton name="level" inputId="chef" value="Chef d'equipe" v-model="form.level" />
                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                    <div class="fw-bold text-gray-800">Chef d'equipe</div>
                                    <div class="text-gray-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="d-flex fv-row">
                            <div class="form-check form-check-custom form-check-solid">
                                <RadioButton name="level"  inputId="level" value="Simple technicien" v-model="form.level" />
                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                    <div class="fw-bold text-gray-800">Simple technicien</div>
                                    <div class="text-gray-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="errors.message" class="text-red-500">
                    {{ errors.message }}
                </div>
                <template #footer>
                    <div class="d-flex justify-content-end">
                    <Button label="Annuler" icon="pi pi-times" class="p-button-text"
                        @click="hideAddTechnicienDialog" />
                    <Button label="Envoyer" severity="warn" @click="submitTechnicien" icon="pi pi-check" class="p-button-primary" type="submit" />
                </div>
                </template>

        </Dialog>
        <!-- Import dialog -->
        <Dialog v-model:visible="showImportDialog" header="Importer un fichier" :style="{ width: '50vw' }"
            :breakpoints="{ '960px': '75vw', '640px': '100vw' }" :modal="true">
            <form @submit.prevent="submitImport">
                <div class="mb-3">
                    <label for="file" class="form-label">Sélectionner un fichier Excel</label>
                    <input type="file" id="file" ref="fileInput" accept=".xls, .xlsx" class="form-control">
                    <div v-if="errors.file" class="text-red-500">
                        {{ errors.file[0] }}
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <Button label="Annuler" class="p-button-text" @click="showImportDialog = false" />
                    <Button label="Importer" class="p-button-primary" type="submit" />
                </div>
            </form>
        </Dialog>

        <Toast />
    </div>
</template>

<script>
  import { useToast } from 'primevue';
import { onMounted, reactive, ref } from 'vue';
import useTechniens from '../../../js/services/technicienServices';
import useRegion from '../../services/regionServices';

export default {

    name: 'TechnicienList',
    setup() {
        const {
            storeTechnicien,
            getTechniciens,
            techniciens,
            deleteTechnicien, storeImportUser, errors
        } = useTechniens();
        const filteredTechniciens = ref([]);
        const searchQuery = ref('');
        const isLoading = ref(true);
        const filters = ref({

        });
        const visible = ref(false);
        const showImportDialog = ref(false);
        const fileInput = ref(null);

        const form = reactive({
            name: "",
            post_name: "",
            email: "",
            password: "",
            number: "",
            size: "",
            pointure: null,
            category: "",
            level: ""
        });

        const fetchTechniciens = async () => {
            isLoading.value = true;
            try {
                await getTechniciens();
                filteredTechniciens.value = [...techniciens.value];
            } catch (error) {
                console.error('Error fetching techniciens:', error);
            } finally {
                isLoading.value = false;
            }
        };

         onMounted(async()=>{
            await getTechniciens();
            fetchTechniciens();
            await getRegions();
         });

        const filterTechniciens = () => {
            if (!searchQuery.value) {
                filteredTechniciens.value = [...techniciens.value];
                return;
            }
            const query = searchQuery.value.toLowerCase();
            filteredTechniciens.value = techniciens.value.filter((technicien) => {
                return (
                    technicien.name.toLowerCase().includes(query) ||
                    technicien.email.toLowerCase().includes(query) || technicien.post_name.toLowerCase().includes(query)

                );
            });
        };

        const confirmDeleteTechnicien = async (technicien) => {
            if (confirm(`Voulez-vous vraiment supprimer ${technicien.name} ?`)) {
                try {
                    await deleteTechnicien(technicien.id);
                    await getTechniciens();
                  await  fetchTechniciens();
                } catch (error) {
                    console.error('Error deleting technicien:', error);
                    errors.value = error.response?.data?.errors || {};
                }
            }
        };

        const showAddTechnicienDialog = () => {
            visible.value = true;
        };

        const hideAddTechnicienDialog = () => {
            visible.value = false;
            form = {
                name: "",
                post_name: "",
                email: "",
                password: "",
                number: "",
                size: "",
                pointure: null,
                category: "",
                level: ""
            };
            errors.value = {}
        };
        const submitTechnicien = async () => {
            try {
                await storeTechnicien(form);
                visible.value=false;
                await fetchTechniciens();
                await getTechniciens();
            } catch (error) {
                errors.value = error.response?.data?.errors || {};
            }
        };

        // Import logic
        const toast=useToast();
        const submitImport = async () => {
            isLoading.value=true;
            const file = fileInput.value.files[0];
            const formData = new FormData();
            formData.append('file', file);
           await storeImportUser(formData);
           await getTechniciens();
           fetchTechniciens();
            showImportDialog.value=false;
            // errors.value.forEach((e)=>{
            //     toast.add({
            //         severity: 'error',
            //         summary: 'Error',
            //         detail: e,
            //         life: 3000,
            //     });
            // })
            isLoading.value=false;

        };
        const {getRegions, regions}=useRegion();
        return {
            regions,
            filteredTechniciens,
            searchQuery,
            isLoading,
            filters,
            visible,
            showImportDialog,
            errors,
            fileInput,
            form,
            fetchTechniciens,
            filterTechniciens,
            confirmDeleteTechnicien,
            showAddTechnicienDialog,
            hideAddTechnicienDialog,
            submitTechnicien,
            submitImport
        }
    }
}
</script>
<style scoped>
/* Add any component-specific styles here */
.login-page {
  position: relative;
}
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
