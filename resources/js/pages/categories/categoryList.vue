<template>
    <div>
      <div class="container-xxl" id="kt_content_container">
        <div class="card">
          <div class="card-header border-0 pt-6">
            <div class="card-title">
              <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                  <span class="path1"></span>
                  <span class="path2"></span>
                </i>
                <InputText v-model="filters['global'].value" type="text" class="form-control form-control-solid w-250px ps-13"
                  placeholder="Rechercher une catégorie" />
              </div>
            </div>
            <div class="card-toolbar">
              <div class="d-flex justify-content-end">
                <Button label="Ajouter une catégorie" icon="pi pi-plus" severity="warn" class="p-button-primary me-2"
                  @click="openModal" />
                <Button v-if="!selectedFileName" label="Importer xls" icon="pi pi-upload" @click="openFileDialog" />
                <Button v-else label="Importer vers le server" class="p-button-primary ms-3" icon="pi pi-upload"
                  @click="importCategoriesToServer" />
                <input type="file" class="d-none" name="file" ref="fileInput" @change="handleFileChange" />
              </div>
            </div>
          </div>
          <div class="card-body py-4">
            <div v-if="selectedFileName" class="mb-3">
              <div class="d-flex align-items-center">
                <i class="pi pi-file me-2"></i>
                <span class="text-muted fs-8">
                  Fichier sélectionné : {{ selectedFileName }}
                </span>
              </div>
            </div>
            <DataTable ref="dt" v-model:filters="filters" :value="categories" :paginator="true" :rows="10"
              stripedRows removableSort
              paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
              :rowsPerPageOptions="[5, 10, 25, 50]"
              currentPageReportTemplate="Showing {first} to {last} of {totalRecords} categories"
              tableStyle="min-width: 50rem">
              <Column field="designation" header="Catégorie" sortable>
                <template #body="slotProps">
                  <div class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                      <a href="/">
                        <div v-if="slotProps.data.avatar" class="symbol-label">
                          <img :src="slotProps.data.avatar" :alt="slotProps.data.designation" class="w-100" />
                        </div>
                        <div v-else class="symbol-label fs-3 bg-light-danger text-danger">
                          {{ slotProps.data.designation[0] }}
                        </div>
                      </a>
                    </div>
                    <div class="d-flex flex-column">
                      <a href="/" class="text-gray-800 text-hover-primary mb-1">{{ slotProps.data.designation }}</a>
                    </div>
                  </div>
                </template>
              </Column>
              <Column field="unity.designation" header="Unité" sortable>
                <template #body="slotProps">
                  {{ slotProps.data.unity ? slotProps.data.unity.designation : "-" }}
                </template>
              </Column>
              <Column field="caracteristique" header="Caractéristique" sortable />
              <Column field="type" header="Type" sortable />
              <Column header="A remettre">
                <template #body="slotProps">
                  {{ slotProps.data.is_remise ? "Oui" : "Non" }}
                </template>
              </Column>
              <Column header="Actions">
                <template #body="slotProps">
                  <Button @click="editCategory(slotProps.data)"
                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-2" severity="warning">
                    <i class="ki-duotone ki-pencil fs-3">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                      <span class="path5"></span>
                    </i>
                  </Button>
                  <Button @click="confirmDeleteCategory(slotProps.data.id)" severity="danger"
                    class="btn btn-icon btn-active-light-primary w-30px h-30px">
                    <i class="ki-duotone ki-trash fs-3">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                    </i>
                  </Button>
                </template>
              </Column>
            </DataTable>
          </div>
        </div>
      </div>

      <Dialog v-model:visible="modalVisible" :header="isEditMode ? 'Modifier une catégorie' : 'Ajouter une catégorie'"
        modal :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '640px': '100vw' }">
        <div class="fv-row mb-7">
          <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
          <div class="image-input image-input-outline" data-kt-image-input="true"
            style="background-image: url(assets/media/avatars/blank.png)">
            <div class="image-input-wrapper w-125px h-125px" :style="{
              backgroundImage: `url(${formData.avatarPreview || 'assets/media/avatars/connectors.jpeg'
                })`,
            }"></div>
            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
              <i class="bi bi-pencil-fill fs-7"></i>
              <input type="file" name="avatar" accept=".png, .jpg, .jpeg" @change="handleAvatarChange" />
              <input type="hidden" name="avatar_remove" />
            </label>
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
              <i class="bi bi-x fs-2"></i>
            </span>
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
              <i class="bi bi-x fs-2"></i>
            </span>
          </div>
          <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
        </div>
        <div class="row">
          <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
            <label class="required fw-semibold fs-6 mb-2">Designation</label>
            <InputText v-model="formData.designation" type="text" class="form-control form-control-solid mb-3 mb-lg-0"
              placeholder="Designation de la catégorie" required />
          </div>
          <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
            <label class="required fw-semibold fs-6 mb-2">Caractéristiques</label>
            <InputText v-model="formData.caracteristique" type="text"
              class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Caracteristique de la catégorie" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2">
              <span class="">Unité</span>
            </label>
            <Dropdown v-model="formData.unity_id" :options="unities" optionLabel="designation" optionValue="id"
              placeholder="Selectionner une unité" class="w-full md:w-14rem col-12" filter :showClear="true" />
          </div>
          <div class="col-md-6">
            <label class="fw-semibold fs-6 mb-2">
              <span class="">Type d'équipement</span>
            </label>
            <Dropdown v-model="formData.type" :options="equipmentTypes" placeholder="Selectionner un type"
              optionLabel="label" optionValue="value" class="w-full md:w-14rem col-12" :showClear="true" />
          </div>
        </div>
        <div class="d-flex flex-row gap-1 mt-3">
          <div class="d-flex fv-row">
            <div class="form-check form-check-custom form-check-solid">
              <input class="form-check-input me-3" type="checkbox" v-model="formData.is_remise" />
              <label class="form-check-label">
                <div class="fw-bold text-gray-800">A remettre?</div>
              </label>
            </div>
          </div>
        </div>
        <div class="text-center pt-10">
          <Button label="Annuler" severity="help" class="p-button-secondary me-3" @click="closeModal" />
          <Button label="Envoyer" @click="submitForm" severity="warn" type="submit" class="p-button-primary" />
        </div>
      </Dialog>
      <Toast />
      <ConfirmDialog></ConfirmDialog>
    </div>
  </template>

  <script>
  import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm } from 'primevue';
import { useToast } from 'primevue/usetoast';
import { onMounted, reactive, ref } from 'vue';
import useCategories from "../../services/categoryServices.js";
import useUnity from "../../services/unityServices.js";

  export default {
    setup() {
      const { getCategories, categories, storeCategory, importCategories, destroyCategory, updateCategory } = useCategories();
      const { getUnities, unities } = useUnity();
      const modalVisible = ref(false);
      const selectedFileName = ref(null);
      const fileInput = ref(null);
      const toast = useToast();
      const confirm = useConfirm();
      const isEditMode = ref(false);
      const equipmentTypes = ref([
        { label: 'Electrique', value: 'Electrique' },
        { label: 'Mecanique', value: 'Mecanique' },
        { label: 'Hydraulique', value: 'Hydraulique' },
        { label: 'Pneumatique', value: 'Pneumatique' },
        { label: 'Autre', value: 'Autre' },
      ]);

      const formData = reactive({
        id: null,
        designation: '',
        caracteristique: '',
        unity_id: null,
        type: null,
        is_remise: false,
        avatar: null,
        avatarPreview: null,
      });
      const filters = ref({
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        designation: { value: null, matchMode: FilterMatchMode.CONTAINS },
      });

      const openModal = () => {
        isEditMode.value = false;
        modalVisible.value = true;
      };

      const closeModal = () => {
        modalVisible.value = false;
        resetForm();
      };

      const resetForm = () => {
        formData.id = null;
        formData.designation = '';
        formData.caracteristique = '';
        formData.unity_id = null;
        formData.type = null;
        formData.is_remise = false;
        formData.avatar = null;
        formData.avatarPreview = null;
      };

      const submitForm = async () => {
        console.log(formData);

        try {
          let success = false;
          if (isEditMode.value) {
            success = await updateCategory(formData.id, formData);
          } else {
            success = await storeCategory(formData);
          }
          if (success) {
            await getCategories();
            closeModal();
            toast.add({
              severity: 'success',
              summary: 'Success',
              detail: `Catégorie ${isEditMode.value ? 'updated' : 'created'}`,
              life: 3000,
            });
          } else {
            toast.add({
              severity: 'error',
              summary: 'Error',
              detail: `Error ${isEditMode.value ? 'updating' : 'creating'} category`,
              life: 3000,
            });
          }
        } catch (error) {
          console.error('Error creating category:', error);
          toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Erreur lors de l\'ajout de la catégorie',
            life: 3000,
          });
        }
      };
      const editCategory = (category) => {
        isEditMode.value = true;
        formData.id = category.id;
        formData.designation = category.designation;
        formData.caracteristique = category.caracteristique;
        formData.unity_id = category.unity_id;
        formData.type = category.type;
        formData.is_remise = category.is_remise;
        formData.avatarPreview = category.avatar;
        modalVisible.value = true;
      };
      const confirmDeleteCategory = (categoryId) => {
        confirm.require({
          message: 'Êtes-vous sûr de vouloir supprimer cette catégorie?',
          header: 'Confirmation de suppression',
          icon: 'pi pi-exclamation-triangle',
          acceptLabel: 'Oui',
          rejectLabel: 'Non',
          acceptClass: 'p-button-danger',
          accept: async () => {
            await deleteCategory(categoryId);
            await getCategories();
            toast.add({ severity: 'success', summary: 'Success', detail: 'Catégorie deleted', life: 3000 });
          },
          reject: () => {
            toast.add({
              severity: 'info',
              summary: 'Suppression annulée',
              detail: 'La suppression a été annulée.',
              life: 3000,
            });
          },
        });
      };

      const handleAvatarChange = (event) => {
        const file = event.target.files[0];
        formData.avatar = file;
        formData.avatarPreview = URL.createObjectURL(file);
      };

      const openFileDialog = () => {
        fileInput.value.click();
      };

      const handleFileChange = (event) => {
        const file = event.target.files[0];
        selectedFileName.value = file ? file.name : null;
      };

      const importCategoriesToServer = async () => {
        if (!selectedFileName.value) {
          toast.add({
            severity: 'warn',
            summary: 'Warning',
            detail: 'Veuillez sélectionner un fichier',
            life: 3000,
          });
          return;
        }
        const file = fileInput.value.files[0];
        const formDataFile = new FormData();
        formDataFile.append('file', file);
        try {
          await importCategories(formDataFile);
          await getCategories();
          await getUnities();
          selectedFileName.value = null;
          toast.add({
            severity: 'success',
            summary: 'Success',
            detail: 'Catégories importées avec succès',
            life: 3000,
          });
        } catch (error) {
          console.error('Error importing categories:', error);
          toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Erreur lors de l\'importation des catégories',
            life: 3000,
          });
        }
      };

      onMounted(async () => {
        await getCategories();
        await getUnities();
      });

      return {
        categories,
        modalVisible,
        openModal,
        closeModal,
        submitForm,
        confirmDeleteCategory,
        formData,
        handleAvatarChange,
        openFileDialog,
        handleFileChange,
        selectedFileName,
        fileInput,
        importCategoriesToServer,
        unities,
        equipmentTypes,
        filters,
        editCategory,
        isEditMode,
      };
    },
  };
  </script>
