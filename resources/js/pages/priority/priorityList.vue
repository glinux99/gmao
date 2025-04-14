<template>
    <div>
      <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
          <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
              <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                  Liste des Priorités
                </h1>
              </div>

              <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button type="button" class="btn btn-primary" @click="addPriorityModal">
                  Ajouter une Priorité
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
                      <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                          class="path2"></span></i>
                      <input type="text" data-kt-permissions-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher une priorité"
                        v-model="searchQuery" />
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                    <thead>
                      <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Nom</th>
                        <th class="min-w-125px">Valeur</th>
                        <th class="min-w-125px">Badge</th>
                        <th class="text-end min-w-100px">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                      <tr v-for="priority in filteredPriorities" :key="priority.id">
                        <td>{{ priority.title }}</td>
                        <td>{{ priority.value }}</td>
                        <td>
                          <span :class="`badge ${priority.color}`" :style="`background-color:${priority.color}` ">{{ priority.color }}</span>
                        </td>
                        <td class="text-end">
                          <button @click="editPriority(priority)"
                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                            <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                class="path5"></span></i>
                          </button>
                          <button @click="deletePriority(priority)"
                            class="btn btn-icon btn-active-light-primary w-30px h-30px">
                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span><span class="path4"></span></i>
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
      <modal-component :id="'priority-modal'" positionModal="center mw-600px" :form="form"
        @instance-modal="submitPriority" @cancelBtn="closePriorityModal" :backdrop="true">
        <template #title>{{ isEditMode ? 'Modifier' : 'Ajouter' }} une Priorité</template>
        <template #body>
          <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_user_header"
            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
            <div class="mb-5">
              <div class="row">
                <div class="col-md-12">
                  <label class="form-label">Titre</label>
                  <input type="text" class="form-control" v-model="form.title" />
                </div>
                <div class="col-md-12">
                  <label class="form-label">Valeur</label>
                  <input type="text" class="form-control" v-model="form.value" />
                </div>
                <div class="col-md-12">
                  <label class="form-label">Badge</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="color" class="form-control form-control-color w-100" v-model="form.color" />
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.color" />
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </modal-component>
    </div>
  </template>

  <script>
  import { computed, onMounted, reactive, ref } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import usePriorities from "../../services/priorityServices.js";

  export default {
    components: {
      modalComponent,
    },
    setup() {
      const {
        priorities,
        getPriorities,
        storePriority,
        updatePriority,
        deletePriority: destroyPriority,
        isLoading,
      } = usePriorities();
      const searchQuery = ref("");
      const isEditMode = ref(false);
      const form = reactive({
        id: null,
        title: "",
        value: "",
        color: "badge-light-primary",
      });

      onMounted(async () => {
        await getPriorities();
      });

      const addPriorityModal = () => {
        isEditMode.value = false;
        $("#priority-modal").modal("show");
        resetForm();
      };

      const editPriority = (priority) => {
        isEditMode.value = true;
        Object.assign(form, priority);
        $("#priority-modal").modal("show");
      };

      const deletePriority = async (priority) => {
        if (confirm("Are you sure you want to delete this priority?")) {
          await destroyPriority(priority.id);
          await getPriorities();
        }
      };

      const submitPriority = async () => {
        let success = false;
        if (isEditMode.value) {
          success = await updatePriority(form.id, form);
        } else {
          success = await storePriority(form);
        }
        if (success) {
          await getPriorities();
          $("#priority-modal").modal("hide");
          resetForm();
        }
      };

      const closePriorityModal = () => {
        $("#priority-modal").modal("hide");
      };

      const resetForm = () => {
        form.id = null;
        form.title = "";
        form.value = "";
        form.color = "badge-light-primary";
      };

      const filteredPriorities = computed(() => {
        return priorities.value.filter((priority) => {
          return (
            priority.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            priority.value.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            priority.color.toLowerCase().includes(searchQuery.value.toLowerCase())
          );
        });
      });

      return {
        priorities,
        isLoading,
        searchQuery,
        filteredPriorities,
        form,
        isEditMode,
        addPriorityModal,
        editPriority,
        deletePriority,
        submitPriority,
        closePriorityModal,
      };
    },
  };
  </script>
