<template>
    <div class="document-list-page">
      <div v-if="isLoading" class="loading-overlay">
        <div class="loading-spinner">
          <span class="spinner-border text-white" role="status" aria-hidden="true"></span>
        </div>
      </div>
      <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="card flex justify-center"></div>
        <div class="d-flex flex-column flex-column-fluid">
          <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
              <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                  Liste des Documents
                </h1>
              </div>
              <div class="d-flex align-items-center gap-2 gap-lg-3">
                <div class="d-flex justify-content-end">
                  <Button label=" Ajouter un Document" icon="pi pi-plus" severity="warn" class="p-button-primary me-2"
                    @click="addDocument" />
                </div>
              </div>
            </div>
          </div>
          <div v-if="isLoading">Loading...</div>
          <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container_d-none" class="app-container">
              <div class="card card-flush">
                <div class="card-body pt-0">
                  <DataTable ref="dt" v-model:filters="filters" :value="documents" :paginator="true" :rows="10"
                    stripedRows removableSort
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25, 50]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} documents"
                    tableStyle="min-width: 50rem">
                    <template #header>
                      <div class="d-flex justify-content-end">
                        <div class="mx-1">
                          <IconField>
                            <InputText v-model="filters['global'].value" placeholder="Rechercher" />
                          </IconField>
                        </div>
                      </div>
                    </template>
                    <Column field="title" header="Title" sortable />
                    <Column field="content" header="Description" />
                    <Column header="View">
                      <template #body="slotProps">
                        <a :href="slotProps.data.path" target="_blank" class="text-primary">View</a>
                      </template>
                    </Column>
                    <Column field="taskCount" header="Tasks" />
                    <Column field="maintenanceCount" header="Maintenances" />
                    <Column header="Actions">
                      <template #body="slotProps">
                        <Button @click="editDocument(slotProps.data)"
                          class="btn btn-icon btn-active-light-primary w-30px h-30px" severity="warning">
                          <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span><span
                              class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        </Button>
                        <Button @click="confirmDeleteDocument(slotProps.data.id)" severity="danger"
                          class="btn btn-icon btn-active-light-primary w-30px h-30px">
                          <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span
                              class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        </Button>
                        <Button icon="pi pi-link" class="p-button-rounded p-button-help"
                          @click="showLinkModal(slotProps.data)" />
                      </template>
                    </Column>
                  </DataTable>
                </div>
              </div>
            </div>
            <Dialog :id="id" :header="isEditMode ? 'Modifier un Document' : 'Créer un Document'" v-model:visible="visible"
              :style="{ width: '800px' }" position="center" :modal="true" :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
              @hide="closeModal" :closable="true">
              <template #header>
                {{ isEditMode ? 'Modifier' : 'Créer' }} un Document
              </template>
              <div class="d-flex flex-column scroll-y px-3 px-lg-5 ">
                <Card class="bg-secondary">
                  <template #content>
                    <div class="row">
                      <div class="fv-row fv-plugins-icon-container col-md-12">
                        <label class="required fw-semibold fs-6 mb-2">Title</label>
                        <InputText type="text" name="title" class="form-control  mb-3 mb-lg-0" placeholder="Document Title"
                          v-model="form.title" />
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                      </div>
                      <div class="fv-row fv-plugins-icon-container col-md-12">
                        <label class="required fw-semibold fs-6 mb-2">Content</label>
                        <Textarea name="content" class="form-control  mb-3 mb-lg-0" placeholder="Document Content"
                          v-model="form.content" />
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                      </div>
                      <div class="fv-row fv-plugins-icon-container col-md-12">
                        <label class="required fw-semibold fs-6 mb-2">File</label>
                        <div class="d-flex align-items-center">
                          <Button v-if="!selectedFileName" label="Importer un fichier" icon="pi pi-upload" @click="openFileDialog" />
                          <Button v-else label="Changer de fichier" icon="pi pi-refresh" @click="openFileDialog" class="p-button-warning" />
                          <input type="file" class="d-none" name="file" ref="fileInput" @change="handleFileChange" />
                          <div v-if="selectedFileName" class="ms-3">
                            <i :class="getFileIconClass(selectedFileName)" class="me-2"></i>
                            <span>{{ selectedFileName }}</span>
                          </div>
                        </div>
                      </div>
                      <div v-if="uploadProgress > 0" class="col-md-12 mt-3">
                        <div class="progress">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                            :style="{ width: `${uploadProgress}%` }" :aria-valuenow="uploadProgress" aria-valuemin="0"
                            aria-valuemax="100">
                            {{ uploadProgress.toFixed(0) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </template>
                </Card>
              </div>
              <template #footer>
                <Button label="Annuler" icon="pi pi-times" severity="secondary" variant="text" class="p-button-text"
                  @click="visible=false" />
                <Button label="Enregistrer" icon="pi pi-check" severity="warn" class="p-button-primary" raised
                  @click="submitDocument()" :disabled="isUploading" />
              </template>
            </Dialog>
            <Dialog
:id="id"
v-model:visible="linkModalVisible"
:style="{ width: '600px' }"
position="center"
:modal="true"
:breakpoints="{ '560px': '75vw', '640px': '100vw' }"
@hide="closeModal"
:closable="true"
>
<template #header>
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <span class="me-4">
            Assigner ce document a une tache ou une maintenance
      </span>
    </div>
    <div>
      <Dropdown
        class="w-full md:w-14rem"
        :options="linkTypes"
        v-model="selectedDocumentToLink.type"
        optionLabel="label"
        optionValue="value"
        placeholder="Choisissez le type d'association"
        @change="handleChangeRegion"
      />
    </div>
  </div>
</template>
<Card>
    <template #content>
        <div class="row">
               <div  class="fv-row mb-7 col-12">
                 <label class="required fw-semibold fs-6 mb-2 d-block">Tâches</label>
                 <MultiSelect
                   v-model="selectedDocumentToLink.tasks"
                   :options="tasks"
                   optionLabel="description"
                   optionValue="id"
                   :filter="true"
                   filterBy="description"
                   placeholder="Sélectionner une ou plusieurs tâches"
                   class="w-full md:w-14rem w-100"
                 />
               </div>
               <div  class="fv-row mb-7 col-12">
                 <label class="required fw-semibold fs-6 mb-2 d-block">Maintenances</label>
                 <MultiSelect
                   v-model="selectedDocumentToLink.maintenances"
                   :options="maintenances"
                   optionLabel="description"
                   optionValue="id"
                   :filter="true"
                   filterBy="description"
                   placeholder="Sélectionner une ou plusieurs maintenances"
                   class="w-full md:w-14rem w-100"
                 />
               </div>
             </div>
       </template>
</Card>
<template #footer>
  <Button
    label="Annuler"
    icon="pi pi-times"
    severity="secondary"
    variant="text"
    class="p-button-text"
    @click="linkModalVisible = false"
  />
  <Button
    label="Enregistrer"
    icon="pi pi-check"
    severity="warn"
    class="p-button-primary"
    raised
    @click="associateDocuments"
  />
</template>
</Dialog>

            <Toast />
            <ConfirmDialog></ConfirmDialog>
          </div>
        </div>
      </div>
    </div>
    </template>
    <script>
    import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm, useToast } from 'primevue';
import { onMounted, reactive, ref, watch } from 'vue';
import useDocuments from '../../services/documentServices';
import useMaintenances from '../../services/maintenanceService';
import useTasks from '../../services/taskServices';

    export default {
      setup() {
        const { documents, getDocuments, storeDocument, updateDocument, deleteDocument, associateDocument } = useDocuments();
        const { tasks, getTasks, updateTask } = useTasks();
        const { maintenances, getMaintenances, updateMaintenance } = useMaintenances();
        const confirm = useConfirm();
        const toast = useToast();

        const documentsList = ref([]);

        const isLoading = ref(false);
        const isEditMode = ref(false);
        const visible = ref(false);
        const linkModalVisible = ref(false);
        const selectedDocumentToLink = reactive ({
            id: null,
            tasks:[],
            maintenances: [],
            document_id:null,
            type: "Associer"
        });
        const linkTypes = ref([
          { label: 'Associer', value: 'Associer' },
          { label: 'Dissocier', value: 'Dissocier' },
        ]);
        const selectedLinkType = ref(null);
        const tasksList = ref([]);
        const selectedTask = ref([]); // Changed to array
        const maintenancesList = ref([]);
        const selectedMaintenance = ref([]); // Changed to array
        const selectedFileName = ref(null);
        const fileInput = ref(null);
        const uploadProgress = ref(0);
        const isUploading = ref(false);

        const filters = ref({
          global: { value: null, matchMode: FilterMatchMode.CONTAINS },
          title: { value: null, matchMode: FilterMatchMode.CONTAINS },
        });

        const canLink = ref(false);

        const updateCanLink = () => {
          if (!selectedLinkType.value) {
            canLink.value = false;
            return;
          }
          if (selectedLinkType.value === 'task') {
            canLink.value = selectedTask.value.length > 0;
          } else if (selectedLinkType.value === 'maintenance') {
            canLink.value = selectedMaintenance.value.length > 0;
          } else {
            canLink.value = false;
          }
        };

        const fetchDocuments = async () => {
          isLoading.value = true;
          try {
            await getDocuments();
            documentsList.value = documents.value;
          } catch (error) {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Error fetching documents', life: 3000 });
            console.error('Error fetching documents:', error);
          } finally {
            isLoading.value = false;
          }
        };

        const submitDocument = async () => {
          isUploading.value = true;
          uploadProgress.value = 0;
          try {
            let success = false;
            const formData = new FormData();
            formData.append('title', form.value.title);
            formData.append('content', form.value.content);
            if (form.value.file) {
              formData.append('file', form.value.file);
            }
            const config = {
              onUploadProgress: (progressEvent) => {
                const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                uploadProgress.value = percentCompleted;
              },
            };
            if (isEditMode.value) {
              success = await updateDocument(form.value.id, formData, config);
            } else {
              success = await storeDocument(formData, config);
            }
            if (success) {
              await fetchDocuments();
              closeModal();
              toast.add({
                severity: 'success',
                summary: 'Success',
                detail: `Document ${isEditMode.value ? 'updated' : 'created'}`,
                life: 3000,
              });
            } else {
              toast.add({
                severity: 'error',
                summary: 'Error',
                detail: `Error ${isEditMode.value ? 'updating' : 'creating'} document`,
                life: 3000,
              });
            }
          } catch (error) {
            toast.add({
              severity: 'error',
              summary: 'Error',
              detail: `Error ${isEditMode.value ? 'updating' : 'creating'} document`,
              life: 3000,
            });
            console.error(`Error ${isEditMode.value ? 'updating' : 'creating'} document:`, error);
          } finally {
            isUploading.value = false;
            isLoading.value = false;
            uploadProgress.value = 0;
          }
        };
        const attachDocument = () => {
          if (!form.value.id) {
            toast.add({
              severity: 'warn',
              summary: 'Warning',
              detail: `Please save the document before attaching it.`,
              life: 3000,
            });
            return;
          }
          showLinkModal(form.value);
        };

        const addDocument = () => {
          isEditMode.value = false;

          selectedFileName.value = null;
          visible.value = true;
        };

        const editDocument = (document) => {
          isEditMode.value = true;
          form.value = { ...document };
          selectedFileName.value = null;
          visible.value = true;
        };

        const closeModal = () => {
          visible.value = false;
        };

        const confirmDeleteDocument = (documentId) => {
          confirm.require({
            message: 'Êtes-vous sûr de vouloir supprimer ce document?',
            header: 'Confirmation de suppression',
            icon: 'pi pi-exclamation-triangle',
            acceptLabel: 'Oui',
            rejectLabel: 'Non',
            acceptClass: 'p-button-danger',
            accept: async () => {
              await deleteDocument(documentId);
              await fetchDocuments();
              toast.add({ severity: 'success', summary: 'Success', detail: 'Document deleted', life: 3000 });
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

        const showLinkModal = (document) => {
            selectedDocumentToLink.document_id =document.id;
            console.log(document.maintenances);


          Object.assign(selectedDocumentToLink, document);
          linkModalVisible.value =true;
        };

        const openFileDialog = () => {
          fileInput.value.click();
        };
        const handleFileChange = (event) => {
          const file = event.target.files[0];
          form.value.file = file;
          selectedFileName.value = file ? file.name : null;
        };
        const getFileIconClass = (fileName) => {
          const extension = fileName.split('.').pop().toLowerCase();
          switch (extension) {
            case 'pdf':
              return 'pi pi-file-pdf text-danger';
            case 'doc':
            case 'docx':
              return 'pi pi-file-word text-primary';
            case 'xls':
            case 'xlsx':
              return 'pi pi-file-excel text-success';
            case 'ppt':
            case 'pptx':
              return 'pi pi-file-powerpoint text-warning';
            case 'txt':
              return 'pi pi-file-text text-secondary';
            case 'jpg':
            case 'jpeg':
            case 'png':
              return 'pi pi-file-image text-info';
            default:
              return 'pi pi-file text-secondary';
          }
        };

        onMounted(async () => {
          await fetchDocuments();
          await getTasks();
          tasksList.value = tasks.value;
          await getMaintenances();
          maintenancesList.value = maintenances.value;
        });

        watch(selectedLinkType, () => {
          updateCanLink();
        });
        watch(selectedTask, () => {
          updateCanLink();
        });
        watch(selectedMaintenance, () => {
          updateCanLink();
        });
        const selectTypes = ref([
      { title: "Associer", value: "Associer" },
      { title: "Dissocier", value: "Dissocier" },
    ]);
    const form = ref({

      id: null,
      title: "",
      content: "",
      file: null,
      maintenance: [],
      tasks: []
    });
    const handleSelectTypeChange = () => {
      selectedTask.value = [];
      selectedMaintenance.value = [];
    };

      const associateDocuments=async()=>{
        console.log(selectedDocumentToLink);
            await associateDocument(selectedDocumentToLink);
            await fetchDocuments();
          await getTasks();
          tasksList.value = tasks.value;
          await getMaintenances();
          maintenancesList.value = maintenances.value;
            linkModalVisible.value=false;
            toast.add({ severity: 'success', summary: 'Success', detail: 'Le document a été' + selectedDocumentToLink.type + " avec succes!", life: 3000 });
      }
        return {
            associateDocuments,
            selectTypes,
          documents: documentsList,
          form,
          isLoading,
          isEditMode,
          visible,
          linkModalVisible,
          selectedDocumentToLink,
          linkTypes,
          selectedLinkType,
          tasks: tasksList,
          selectedTask,
          maintenances: maintenancesList,
          selectedMaintenance,
          canLink,
          updateCanLink,
          fetchDocuments,
          submitDocument,
          addDocument,
          editDocument,
          closeModal,
          confirmDeleteDocument,
          showLinkModal,
          filters,
          openFileDialog,
          handleFileChange,
          selectedFileName,
          fileInput,
          getFileIconClass,
          attachDocument,
          uploadProgress,
          isUploading,
        };
      },
    };
    </script>

    <style>
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-spinner {
    }
    </style>
