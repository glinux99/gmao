<template>
    <div>
      <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
          <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
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
                  Liste des Regions
                </h1>
              </div>

              <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Button
                  type="button"
                  class="btn btn-primary"
                  @click="addRegion"
                >
                  Ajouter une Region
                </Button>
              </div>
            </div>
          </div>

          <div v-if="isLoading">Loading...</div>
          <div id="kt_app_content" class="app-content flex-column-fluid">
            <div
              id="kt_app_content_container_d-none"
              class="app-container"
            >
              <div class="card card-flush">
                <div class="card-body pt-0 w-100">
                  <DataTable
                    :value="regions"
                    paginator
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 25, 50]"
                    tableStyle="min-width: 50rem"
                    v-model:filters="filters"
                    filterDisplay="menu"
                    :globalFilterFields="['id', 'titre','description']"
                  >
                    <template #header>
                      <div
                        class="d-flex align-items-center position-relative my-1 me-5"
                      >
                        <i
                          class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                          ><span class="path1"></span><span class="path2"></span
                        ></i>
                        <InputText
                          type="text"
                          v-model="filters['global'].value"
                          class="form-control form-control-solid w-250px ps-13"
                          placeholder="Rechercher une region"
                        />
                      </div>
                    </template>
                    <Column field="id" header="ID" sortable></Column>
                    <Column field="titre" header="Designation" sortable></Column>
                    <Column field="description" header="Commentaire sur la region" sortable></Column>
                    <Column header="Actions" class="text-end">
                      <template #body="slotProps">
                        <Button
                          @click="editRegion(slotProps.data)"
                          class="btn btn-icon btn-active-light-primary w-30px h-30px"
                          severity="warning"
                        >
                          <i class="ki-duotone ki-pencil fs-3"
                            ><span class="path1"></span
                            ><span class="path2"></span
                            ><span class="path3"></span
                            ><span class="path4"></span
                            ><span class="path5"></span
                          ></i>
                        </Button>
                        <Button
                          @click="deleteRegionLocal(slotProps.data.id)"
                          severity="danger"
                          class="btn btn-icon btn-active-light-primary w-30px h-30px"
                        >
                          <i class="ki-duotone ki-trash fs-3"
                            ><span class="path1"></span
                            ><span class="path2"></span
                            ><span class="path3"></span
                            ><span class="path4"></span
                            ><span class="path5"></span
                          ></i>
                        </Button>
                      </template>
                    </Column>
                  </DataTable>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- PrimeVue Dialog for adding/editing a region -->
        <Dialog
          v-model:visible="isModalOpen"
          :header="isEditMode ? 'Editer une region' : 'Ajouter une region'"
          :modal="true"
          :style="{ width: '30vw' }"
          :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
          @hide="closeModal"
        >

            <div class="form-group">
              <label for="regionName">Nom de la région:</label>
              <InputText
                type="text"
                id="regionName"
                v-model="regionForm.titre"
                required
                class="w-100 md:w-14rem"
              />
            </div>
            <div class="form-group">
              <label for="regionName">Description de la région:</label>
              <InputText
                type="text"
                v-model="regionForm.description"
                required
                class="w-100 md:w-14rem"
              />
            </div>
            <template #footer>
      <Button label="Annuler" icon="pi pi-times" severity="secondary" variant="text" class="p-button-text"
        @click="closeModal" />
      <Button label="Enregistrer" icon="pi pi-check" severity="warn" class="p-button-primary" raised
        @click="submitRegion" />
    </template>

        </Dialog>
        <Toast />
      </div>
    </div>
  </template>

  <script>
  import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from "primevue/usetoast";
import { onMounted, reactive, ref } from "vue";
import useRegion from "../../services/regionServices";

  export default {
    name: "RegionList",
    setup() {
      const {
        regions,
        getRegions,
        storeRegion,
        updateRegion,
        deleteRegion,
        isLoading,
      } = useRegion();
      const isModalOpen = ref(false);
      const isEditMode = ref(false);
      const regionForm = reactive({
        id: null,
        titre: "",
        description: "",
      });
      const filters = ref({
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
      });
      const toast = useToast();

      onMounted(async () => {
        await getRegions();
      });

      const addRegion = () => {
        isEditMode.value = false;
        regionForm.id = null;
        regionForm.titre = "";
        regionForm.description = "";
        isModalOpen.value = true;
      };

      const editRegion = (region) => {
        isEditMode.value = true;
        Object.assign(regionForm, region);
        isModalOpen.value = true;
      };

      const submitRegion = async () => {
        let success = false;
        if (isEditMode.value) {
          success = await updateRegion(regionForm.id, regionForm);
        } else {
          success = await storeRegion(regionForm);
        }
        if (success) {
          await getRegions();
          closeModal();
          toast.add({
            severity: "success",
            summary: "Success",
            detail: isEditMode.value ? "Region modifiée avec succès" : "Region ajoutée avec succès",
            life: 3000,
          });
        }
      };

      const closeModal = () => {
        isModalOpen.value = false;
      };
      const deleteRegionLocal = async (id) => {
        const success = await deleteRegion(id);
        await getRegions();
        if (success) {
          toast.add({
            severity: "success",
            summary: "Success",
            detail: "Region supprimée avec succès",
            life: 3000,
          });
          await getRegions();
        }
      };
      return {
        deleteRegionLocal,
        regions,
        isLoading,
        addRegion,
        editRegion,
        deleteRegion,
        isModalOpen,
        isEditMode,
        regionForm,
        submitRegion,
        closeModal,
        filters,
      };
    },
  };
  </script>

  <style scoped>
  /* Add any component-specific styles here */
  </style>
