<template>
    <div>
      <div class="container-xxl" id="kt_content_container">
        <div class="card">
          <div class="card-header border-0 pt-6">
            <div class="card-title">
              <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                  ><span class="path1"></span><span class="path2"></span
                ></i>
                <InputText
                  v-model="searchQuery"
                  type="text"
                  class="form-control form-control-solid w-250px ps-13"
                  placeholder="Rechercher une catégorie"
                />
              </div>
            </div>
            <div class="card-toolbar">
              <div class="d-flex justify-content-end">
                <Button
                  label="Ajouter une catégorie"
                  icon="pi pi-plus"
                  severity="warn"
                  class="p-button-primary me-2"
                  @click="openModal"
                />
                <Button v-if="!selectedFileName"
                  label="Importer xls"
                  icon="pi pi-upload"
                  @click="openFileDialog"
                />
                <Button v-else
                  label="Importer vers le server"
                  class="p-button-primary ms-3"
                  icon="pi pi-upload"
                  @click="importCategoriesToServer"
                />
                <input
                  type="file"
                  class="d-none"
                  name="file"
                  ref="fileInput"
                  @change="handleFileChange"
                />
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
            <div class="table-responsive mt-4">
              <table
                class="table align-middle table-row-dashed fs-6 gy-5"
                id="kt_table_users"
              >
                <thead>
                  <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                      <div
                        class="form-check form-check-sm form-check-custom form-check-solid me-3"
                      >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          data-kt-check="true"
                          data-kt-check-target="#kt_table_users .form-check-input"
                          value="1"
                        />
                      </div>
                    </th>
                    <th class="min-w-125px">Catégorie</th>
                    <th class="min-w-75px">Unité</th>
                    <th class="min-w-85px">Caractéristique</th>
                    <th class="min-w-85px">Type</th>
                    <th class="min-w-50px">A remettre</th>
                    <th class="text-center min-w-100px">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                  <tr v-for="(category, index) in filteredCategories" :key="index">
                    <td>
                      <div
                        class="form-check form-check-sm form-check-custom form-check-solid"
                      >
                        <input class="form-check-input" type="checkbox" value="1" />
                      </div>
                    </td>
                    <td class="d-flex align-items-center">
                      <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="/">
                          <div v-if="category.avatar" class="symbol-label">
                            <img
                              :src="category.avatar"
                              :alt="category.designation"
                              class="w-100"
                            />
                          </div>
                          <div v-else class="symbol-label fs-3 bg-light-danger text-danger">
                            {{ category.designation[0] }}
                          </div>
                        </a>
                      </div>
                      <div class="d-flex flex-column">
                        <a href="/" class="text-gray-800 text-hover-primary mb-1">{{
                          category.designation
                        }}</a>
                      </div>
                    </td>
                    <td>
                      {{ category.unity ? category.unity.designation : "-" }}
                    </td>
                    <td class="text-center">{{ category.caracteristique }}</td>
                    <td class="text-center">{{ category.type }}</td>
                    <td class="text-center">
                      {{ category.is_remise ? "Oui" : "Non" }}
                    </td>
                    <td class="text-center">
                      <a
                        :href="`/categories/${category.id}/edit`"
                        class="btn btn-icon btn-active-light-primary text-center d-none"
                      >
                        <i class="ki-duotone ki-pencil fs-3"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                        ></i>
                      </a>
                      <a
                        href="#"
                        @click="deleteCategory(category.id)"
                        class="text-center"
                      >
                        <i class="ki-duotone ki-trash fs-1 text-danger"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <Dialog
          v-model:visible="modalVisible"
          modal
          header="Ajouter une catégorie"
          :style="{ width: '50vw' }"
          :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        >

            <div class="fv-row mb-7">
              <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
              <div
                class="image-input image-input-outline"
                data-kt-image-input="true"
                style="background-image: url(assets/media/avatars/blank.png)"
              >
                <div
                  class="image-input-wrapper w-125px h-125px"
                  :style="{
                    backgroundImage: `url(${
                      formData.avatarPreview || 'assets/media/avatars/connectors.jpeg'
                    })`,
                  }"
                ></div>
                <label
                  class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="change"
                  data-bs-toggle="tooltip"
                  title="Change avatar"
                >
                  <i class="bi bi-pencil-fill fs-7"></i>
                  <input
                    type="file"
                    name="avatar"
                    accept=".png, .jpg, .jpeg"
                    @change="handleAvatarChange"
                  />
                  <input type="hidden" name="avatar_remove" />
                </label>
                <span
                  class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="cancel"
                  data-bs-toggle="tooltip"
                  title="Cancel avatar"
                >
                  <i class="bi bi-x fs-2"></i>
                </span>
                <span
                  class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                  data-kt-image-input-action="remove"
                  data-bs-toggle="tooltip"
                  title="Remove avatar"
                >
                  <i class="bi bi-x fs-2"></i>
                </span>
              </div>
              <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
            </div>
            <div class="row">
              <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                <label class="required fw-semibold fs-6 mb-2">Designation</label>
                <InputText
                  v-model="formData.designation"
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Designation de la catégorie"
                  required
                />
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                <label class="required fw-semibold fs-6 mb-2">Caractéristiques</label>
                <InputText
                  v-model="formData.caracteristique"
                  type="text"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="Caracteristique de la catégorie"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label class="fw-semibold fs-6 mb-2">
                  <span class="">Unité</span>
                </label>
                <Dropdown
                  v-model="formData.unity_id"
                  :options="unities"
                  optionLabel="designation"
                  optionValue="id"
                  placeholder="Selectionner une unité"
                  class="w-full md:w-14rem col-12"
                  filter
                  :showClear="true"
                />
              </div>
              <div class="col-md-6">
                <label class="fw-semibold fs-6 mb-2">
                  <span class="">Type d'équipement</span>
                </label>
                <Dropdown
                  v-model="formData.type"
                  :options="equipmentTypes"
                  placeholder="Selectionner un type"
                  optionLabel="label"
                    optionValue="value"
                  class="w-full md:w-14rem col-12"
                  :showClear="true"
                />
              </div>
            </div>
            <div class="d-flex flex-row gap-1 mt-3">
              <div class="d-flex fv-row">
                <div class="form-check form-check-custom form-check-solid">
                  <input
                    class="form-check-input me-3"
                    type="checkbox"
                    v-model="formData.is_remise"
                  />
                  <label class="form-check-label">
                    <div class="fw-bold text-gray-800">A remettre?</div>
                  </label>
                </div>
              </div>
            </div>
            <div class="text-center pt-10">
              <Button
                label="Annuler"
                severity="help"
                class="p-button-secondary me-3"
                @click="closeModal"
              />
              <Button label="Envoyer" @click="submitForm" severity="warn" type="submit" class="p-button-primary" />
            </div>
        </Dialog>
        <Toast />
      </div>
  </template>

  <script>
import { useToast } from 'primevue/usetoast';
import { computed, onMounted, reactive, ref } from 'vue';
import useCategories from "../../services/categoryServices.js";
import useUnity from "../../services/unityServices.js";

export default {
    setup() {
        const { getCategories, categories, storeCategory, importCategories, destroyCategory } = useCategories();
        const { getUnities, unities } = useUnity();
        const searchQuery = ref('');
        const modalVisible = ref(false);
        const selectedFileName = ref(null);
        const fileInput = ref(null);
        const toast = useToast();;
        const equipmentTypes = ref([
            { label: 'Electrique', value: 'Electrique' },
            { label: 'Mecanique', value: 'Mecanique' },
            { label: 'Hydraulique', value: 'Hydraulique' },
            { label: 'Pneumatique', value: 'Pneumatique' },
            { label: 'Autre', value: 'Autre' },
        ]);

        const formData = reactive({
            designation: '',
            caracteristique: '',
            unity_id: null,
            type: null,
            is_remise: false,
            avatar: null,
            avatarPreview: null,
        });

        const openModal = () => {
            modalVisible.value = true;
        };

        const closeModal = () => {
            modalVisible.value = false;
            resetForm();
        };

        const resetForm = () => {
            formData.designation = '';
            formData.caracteristique = '';
            formData.unity_id = null;
            formData.type = null;
            formData.is_remise = false;
            formData.avatar = null;
            formData.avatarPreview = null;
        };

        const submitForm = async () => {
            try {
                console.log(formData);

                await storeCategory(formData);
                await getCategories();
                modalVisible.value=false;
                toast.add({
                    severity: 'success',
                    summary: 'Success',
                    detail: 'Catégorie ajoutée avec succès',
                    life: 3000,
                });
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

        const deleteCategory = async (categoryId) => {
            try {
                await destroyCategory(categoryId);
                await getCategories();
                toast.add({
                    severity: 'success',
                    summary: 'Success',
                    detail: 'Catégorie supprimée avec succès',
                    life: 3000,
                });
            } catch (error) {
                console.error('Error deleting category:', error);
            }

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

        const filteredCategories = computed(() => {
            return categories.value.filter((category) => {
                return (
                    category.designation?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    category.unity?.designation?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    category.caracteristique?.toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            });

        });

        onMounted(async () => {
            await getCategories();
            await getUnities();
        });

        return {
            categories,
            searchQuery,
            modalVisible,
            openModal,
            closeModal,
            submitForm,
            deleteCategory,
            filteredCategories,
            formData,
            handleAvatarChange,
            openFileDialog,
            handleFileChange,
            selectedFileName,
            fileInput,
            importCategoriesToServer,
            unities,
            equipmentTypes,
        };
    },
};
</script>
