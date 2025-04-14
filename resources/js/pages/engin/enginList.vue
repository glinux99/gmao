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
                  Liste des Engins
                </h1>
              </div>
              <div class="d-flex align-items-center gap-2 gap-lg-3">
                <Dropdown
                  class="w-full md:w-14rem"
                  :options="regions"
                  v-model="selectedRegion"
                  optionLabel="titre"
                  optionValue="id"
                  placeholder="Choisissez la region"
                  @change="handleChangeRegion"
                />
                <Button
                  label="Ajouter un Engin"
                  icon="pi pi-plus"
                  severity="warn"
                  class="p-button-primary"
                  @click="addEngin"
                />
              </div>
            </div>

            <div v-if="isLoading" class="text-center">
              <ProgressSpinner
                style="width: 50px; height: 50px"
                strokeWidth="8"
                fill="var(--surface-ground)"
                animationDuration=".5s"
              />
            </div>
            <div v-else id="kt_app_content" class="app-content flex-column-fluid">
              <div
                id="kt_app_content_container"
                class="app-container container-xxl"
              >
                <div class="card card-flush">
                  <div class="card-body pt-0">
                    <DataTable
                      :value="engins"
                      removableSort
                      tableStyle="min-width: 50rem"
                      :paginator="true"
                      :rows="10"
                      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                      :rowsPerPageOptions="[5, 10, 25, 50]"
                      currentPageReportTemplate="Showing {first} to {last} of {totalRecords} engins"
                      v-model:filters="filters"
                      filterDisplay="menu"
                      :globalFilterFields="['name', 'type', 'matricule', 'description']"
                    >
                      <template #header>
                        <div
                          class="d-flex align-items-center justify-content-between position-relative my-1 me-5"
                        >
                          <div>
                            <i
                              class="pi pi-search fs-3 position-absolute ms-5"
                            ></i>
                            <InputText
                              type="text"
                              v-model="filters['global'].value"
                              class="form-control form-control-solid w-250px ps-13"
                              placeholder="Rechercher un engin"
                            />
                          </div>
                        </div>
                      </template>
                      <Column field="name" header="Nom" sortable />
                      <Column field="type" header="Type" sortable />
                      <Column field="region.titre" header="Region" sortable />
                      <Column field="matricule" header="Matricule" sortable />
                      <Column field="description" header="Description" sortable />
                        <Column header="Kilométrage Debut" >
                            <template #body="slotProps">
                                {{ lastKilometrage(slotProps.data)?.kilometrage_debut ?? '-' }} kmh
                            </template>
                        </Column>
                        <Column header="Kilométrage Fin">
                            <template #body="slotProps">

                                {{ lastKilometrage(slotProps.data)?.kilometrage_fin ?? '-' }} kmh
                            </template>
                        </Column>
                      <Column header="Actions" style="text-align: right">
                        <template #body="slotProps">
                          <Button
                            icon="pi pi-pencil"
                            class="p-button-text p-button-secondary"
                            @click="editEngin(slotProps.data)"
                          />
                          <Button
                            icon="pi pi-trash"
                            class="p-button-text p-button-secondary"
                            @click="deleteEngin(slotProps.data.id)"
                          />
                        </template>
                      </Column>
                    </DataTable>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <Dialog
            v-model:visible="enginModalVisible"
            :style="{ width: '450px' }"
            :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
            :modal="true"
            class="p-fluid"
            @hide="resetForm"
          >
            <template #header>
              {{ isEditMode ? "Modifier" : "Ajouter" }} un Engin
            </template>
            <div
              class="d-flex flex-column scroll-y px-5 px-lg-10"
              id="kt_modal_add_user_scroll"
            >
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="required fw-semibold fs-6 mb-2">Nom</label>
                <InputText
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Nom de l'engin"
                  v-model="form.name"
                  required
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-semibold fs-6 mb-2">Type</label>
                <InputText
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Type de l'engin"
                  v-model="form.type"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-semibold fs-6 mb-2">Matricule</label>
                <InputText
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Matricule de l'engin"
                  v-model="form.matricule"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-semibold fs-6 mb-2">Derniere kilometrage de debut</label>
                <InputNumber
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Matricule de l'engin"
                  v-model="form.kilometrage_debut"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-semibold fs-6 mb-2">Dernier kilomtrage de fin</label>
                <InputNumber
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Matricule de l'engin"
                  v-model="form.kilometrage_fin"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-semibold fs-6 mb-2">Description</label>
                <Textarea
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Description de l'engin"
                  v-model="form.description"
                />
                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>

              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="fw-semibold fs-6 mb-2">Region</label>
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
            <template #footer>
              <Button
                label="Annuler"
                icon="pi pi-times"
                class="p-button-text"
                @click="enginModalVisible = false"
              />
              <Button
                label="Sauvegarder"
                severity="warn"
                icon="pi pi-check"
                @click="submitEngin"
                class="p-button-primary"
              />
            </template>
          </Dialog>
        </div>
      </div>
    </div>
    </template>

    <script>
    import { FilterMatchMode } from "@primevue/core/api";
import { InputNumber } from "primevue";
import { onMounted, reactive, ref, watch } from "vue";
import useEngins from "../../services/enginServices";
import useRegion from "../../services/regionServices.js";

    export default {
      setup() {
        const { getEngins, storeEngin, updateEngin, destroyEngin } = useEngins(); // Use the composable
        const { getRegions, regions } = useRegion();
        const engins = ref([]);
        const isLoading = ref(false);
        const isEditMode = ref(false);
        const enginModalVisible = ref(false);
        const filters = ref({
          global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        });
        const selectedRegion = ref(null);

        const form = reactive({
          id: null,
          name: "",
          type: "",
          matricule: "",
          description: "",
          region_id: null,
          kilometrage_debut: 0,
          kilometrage_fin: 0,
        });

        const loadEngins = async () => {
          isLoading.value = true;
          try {
            engins.value = await getEngins();
          } catch (error) {
            // Handle error (e.g., display a message to the user)
            console.error("Error loading engins:", error);
          } finally {
            isLoading.value = false;
          }
        };

        onMounted(async () => {
          await loadEngins();
          await getRegions();
        });

        const submitEngin = async () => {
          console.log(form);

          try {
            if (isEditMode.value) {
              await updateEngin(form.id, form);
            } else {
              await storeEngin(form);
            }
            enginModalVisible.value = false;
            await loadEngins();
            resetForm();
          } catch (error) {
            // Handle error (e.g., display a message to the user)
            console.error("Error submitting engin:", error);
          }
        };

        const addEngin = () => {
          resetForm();
          isEditMode.value = false;
          enginModalVisible.value = true;
        };

        const editEngin = (engin) => {
          resetForm();
          isEditMode.value = true;
          enginModalVisible.value = true;
          Object.assign(form, engin);
        };

        const deleteEngin = async (enginId) => {
          try {
            await destroyEngin(enginId);
            await loadEngins();
          } catch (error) {
            // Handle error (e.g., display a message to the user)
            console.error("Error deleting engin:", error);
          }
        };

        const resetForm = () => {
          form.id = null;
          form.name = "";
          form.type = "";
          form.matricule = "";
          form.description = "";
          form.region_id = null;
          form.kilometrage_debut = 0;
          form.kilometrage_fin = 0;
        };
        const handleChangeRegion = () => {
          console.log(selectedRegion.value);
          if (selectedRegion.value !== null) {
            engins.value = engins.value.filter((engin) => {
              return engin.region_id === selectedRegion.value;
            });
          } else {
            // If no region is selected, reset to all engins
            loadEngins();
          }
        };
        watch (
          () => selectedRegion.value,
          (newValue, oldValue) => {

              if (selectedRegion.value !== null) {
            engins.value = engins.value.filter((engin) => {
              return engin.region_id === selectedRegion.value;
            });
          } else {
            // If no region is selected, reset to all engins
            loadEngins();
          }
            // Add your logic here to perform actions when tacheronsForm changes
          }
        );
          const lastKilometrage = (engin) => {
              if (engin.engin_details && engin.engin_details.length > 0) {
                  return engin.engin_details[engin.engin_details.length - 1];
              }
              return null;
          }

        return {
          engins,
          isLoading,
          isEditMode,
          enginModalVisible,
          form,
          submitEngin,
          addEngin,
          editEngin,
          deleteEngin,
          filters,
          regions,
          selectedRegion,
          handleChangeRegion,
            lastKilometrage,
        };
      },
    };
    </script>
