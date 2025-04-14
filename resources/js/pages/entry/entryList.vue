<template>
    <div class="entries-container">
      <div class="card" v-if="!isLoading">
        <div class="card-header">
          <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
              <i class="pi pi-search fs-3 position-absolute ms-5"></i>
              <InputText
                v-model="searchQuery"
                class="form-control form-control-solid w-250px ps-13"
                placeholder="Rechercher une catégorie"
                @input="filterEntries"
              />
            </div>
          </div>
          <div class="card-toolbar">
            <Button
              label="Ajouter une entrée"
              icon="pi pi-plus"
              class="p-button-primary"
              @click="showAddEntryDialog"
            />
          </div>
        </div>

        <div class="card-body">
          <DataTable
            :value="filteredEntries"
            :paginator="true"
            :rows="10"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25, 50]"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
            tableStyle="min-width: 50rem"
          >
            <Column field="category.designation" header="Désignation">
              <template #body="slotProps">
                <a
                  :href="`/entries/${slotProps.data.id}/edit`"
                  class="fw-bolder text-gray-800 text-hover-primary fs-6"
                >
                  {{ slotProps.data.category.designation }}
                </a>
                <span class="text-muted fw-bold d-block">
                  {{ slotProps.data.category.caracteristique }}
                </span>
              </template>
            </Column>
            <Column field="quantity" header="Quantité">
              <template #body="slotProps">
                <span class="fw-bolder text-warning py-1">
                  + {{ slotProps.data.quantity }}
                  {{ slotProps.data.category.unity?.abbreviation ?? "" }}
                </span>
              </template>
            </Column>
            <Column field="etat" header="État">
              <template #body="slotProps">
                <span class="fw-bolder text-success py-1">
                  {{ slotProps.data.etat }}
                </span>
              </template>
            </Column>
            <Column header="Actions">
              <template #body="slotProps">
                <Button
                  icon="pi pi-trash"
                  class="p-button-danger p-button-text"
                  @click="confirmDeleteEntry(slotProps.data)"
                />
              </template>
            </Column>
          </DataTable>
        </div>
      </div>
      <div v-else class="text-center">
        <ProgressSpinner
          style="width: 50px; height: 50px"
          strokeWidth="8"
          fill="var(--surface-ground)"
          animationDuration=".5s"
        />
      </div>

      <Dialog
        v-model:visible="visible"
        header="Ajouter une entrée"
        :style="{ width: '40vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :modal="true"
        class="p-fluid"
      >

          <div class="fv-row mb-7 fv-plugins-icon-container col-md-12">
            <label for="category" class="fw-semibold fs-6 mb-2 col-12"
              >Désignation</label
            >
            <Dropdown
              id="category"
              v-model="form.category_id"
              :options="categories"
              optionValue="id"
              :optionLabel="getCategoryLabel"
              placeholder="Sélectionner une catégorie"
              class="w-full md:w-14rem col-12"
              :filter="true"
              filterBy="designation,caracteristique"
              @change="updateUnity"
            />
            <div v-if="errors.category_id" class="text-red-500">
              {{ errors.category_id[0] }}
            </div>
          </div>
          <div class="field">
            <div class="d-flex justify-content-between">
              <div class="col-md-6">
                <label for="quantity" class="fw-semibold fs-6 mb-2 w-100"
                  >Quantité</label
                >
                <InputNumber
                  id="quantity"
                  v-model="form.quantity"
                  placeholder="0"
                  class="w-100 md:w-14rem"
                  :min="0"
                />
              </div>
              <div class="col-md-6">
                <label for="unity" class="fw-semibold fs-6 mb-2 w-100"
                  >Unité</label
                >
                <InputText
                  :value="unityAbbreviation"
                  class="w-100 md:w-14rem"
                  readonly
                />
              </div>
            </div>
            <div v-if="errors.quantity" class="text-red-500">
              {{ errors.quantity[0] }}
            </div>
          </div>
          <div class="field">
            <label for="etat" class="fw-semibold fs-6 mb-2 col-12"
              >État</label
            >
            <Dropdown
              id="etat"
              v-model="form.etat"
              :options="etats"
              placeholder="Sélectionner un état"
              class="w-full md:w-14rem col-12"
            />
            <div v-if="errors.etat" class="text-red-500">
              {{ errors.etat[0] }}
            </div>
          </div>
          <div v-if="errors.message" class="text-red-500">
            {{ errors.message }}
          </div>

          <template #footer>
            <Button label="Annuler" icon="pi pi-times"  @click="visible=false" />
            <Button label="Enregistrer" icon="pi pi-check" severity="warn" @click="submitEntry" />
    </template>
      </Dialog>
    </div>
  </template>

  <script>
import { computed, onMounted, reactive, ref } from 'vue';
import useCategories from '../../services/categoryServices';
import useEntry from '../../services/entryServices';

  export default {
    name: 'Entries',
    setup() {
      const {
        entries,
        errors,
        isLoading,
        getEntries,
        storeEntry,
        deleteEntry,
      } = useEntry();
      const { getCategories, categories } = useCategories();
      const searchQuery = ref('');
      const visible = ref(false);
      const form = reactive({
        category_id: null,
        quantity: 0,
        etat: null,
        unity: null,
      });
      const etats = ref(['Neuf', 'Bon', 'Endommage']);
      const unityAbbreviation = ref('');

      const filteredEntries = computed(() => {
        if (!searchQuery.value) {
          return entries.value;
        }
        return entries.value.filter((entry) => {
          return entry.category.designation
            .toLowerCase()
            .includes(searchQuery.value.toLowerCase());
        });
      });

      const showAddEntryDialog = () => {
        visible.value = true;
      };

      const hideAddEntryDialog = () => {
        visible.value = false;
        resetform();
      };

      const resetform = () => {
        form = {
          category_id: null,
          quantity: 0,
          etat: null,
        };
        unityAbbreviation.value = '';
      };

      const submitEntry = async () => {
        await storeEntry(form);
        visible.value=false;
        await getEntries();
        resetform();
      };

      const filterEntries = () => {
        // The filtering is done by the computed property filteredEntries
      };

      const confirmDeleteEntry = (entry) => {
        confirm.require({
          message: 'Voulez-vous supprimer cette entrée?',
          header: 'Confirmation de suppression',
          icon: 'pi pi-exclamation-triangle',
          accept: () => {
            deleteEntry(entry.id);
          },
        });
      };

      const updateUnity = () => {
        const selectedCategory = categories.value.find(
          (category) => category.id === form.category_id
        );
        unityAbbreviation.value = selectedCategory?.unity?.abbreviation || selectedCategory?.unity?.designation || "aucune";
      };

      onMounted(async () => {
        await getEntries();
        await getCategories();
      });
      const getCategoryLabel = (category) => {
  return `${category.designation} (${category.caracteristique})`;
};

      return {
        getCategoryLabel,
        entries,
        categories,
        searchQuery,
        filteredEntries,
        visible,
        form,
        etats,
        errors,
        isLoading,
        showAddEntryDialog,
        hideAddEntryDialog,
        submitEntry,
        filterEntries,
        confirmDeleteEntry,
        unityAbbreviation,
        updateUnity,
      };
    },
  };
  </script>

  <style scoped>
  .entries-container {
    padding: 20px;
  }

  .card {
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    border-bottom: 1px solid #ddd;
  }

  .card-title {
    font-weight: bold;
  }

  .card-body {
    padding: 15px;
  }
  </style>
