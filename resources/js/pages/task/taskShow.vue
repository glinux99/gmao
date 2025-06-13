<template>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <Toast />

      <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
          <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
              <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                Détails de la Tâche
              </h1>
            </div>
          </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div id="kt_app_content_container" class="app-container container-xxl">
            <div v-if="isLoading" class="text-center">
              <ProgressSpinner />
            </div>
            <Panel v-else>
              <template #header>
                <div class="d-flex justify-content-between align-items-center w-100">
                  <h5 class="m-0">{{ task.description }}</h5>
                  <div>
                    <Button v-if="progressPercentage === 100 && task.status !== 'completed'"
                            label="Terminer" icon="pi pi-check" class="p-button-success p-button-sm me-2"
                            @click="completeTask" />
                    <Button v-else-if="task.status === 'in_progress' && progressPercentage < 100"
                            label="Mettre en Pause" icon="pi pi-pause" class="p-button-warning p-button-sm me-2"
                            @click="pauseTask" />
                    <Button v-else-if="task.status !== 'completed' && progressPercentage < 100"
                            label="Mettre à Jour" icon="pi pi-refresh" class="p-button-info p-button-sm"
                            @click="updateTaskOnly" />
                  </div>
                </div>
              </template>

              <div class="p-fluid">
                <Fieldset legend="Détails de la Tâche" :toggleable="true" class="mb-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <span class="fw-bold d-block mb-1">Priorité:</span>
                        <Tag v-if="task.priority" :style="{ 'background-color': task.priority.color, color: '#fff' }"
                             :value="task.priority.title" class="px-3 py-2"></Tag>
                        <span v-else>N/A</span>
                      </div>
                      <div class="mb-3">
                        <span class="fw-bold d-block mb-1">Status:</span>
                        <Tag v-if="task.status === 'pending'" severity="warning" value="En attente"></Tag>
                        <Tag v-else-if="task.status === 'in_progress'" severity="info" value="En cours"></Tag>
                        <Tag v-else-if="task.status === 'completed'" severity="success" value="Terminée"></Tag>
                        <Tag v-else-if="task.status === 'canceled'" severity="danger" value="Annulée"></Tag>
                        <Tag v-else-if="task.status === 'delayed'" class="p-tag-danger" value="Délai dépassé"></Tag>
                        <Tag v-else severity="secondary" value="Inconnu"></Tag>
                      </div>
                      <div class="mb-3">
                        <span class="fw-bold d-block mb-1">Responsable:</span>
                        <span>{{ task.owner_user ? task.owner_user.name : "N/A" }}</span>
                      </div>
                      <div class="mb-3">
                        <span class="fw-bold d-block mb-1">Projet:</span>
                        <span>{{ task.project ? task.project.name : "N/A" }}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="fw-bold d-block mb-1">Date de début:</label>
                        <span v-if="task.status === 'completed'">{{ formatDate(task.start_date_user ?? task.start_date) }}</span>
                        <Calendar v-else v-model="form.start_date_user" showTime hourFormat="24"
                                  class="w-100" placeholder="Date de début" dateFormat="dd/mm/yy"/>
                      </div>
                      <div class="mb-3">
                        <label class="fw-bold d-block mb-1">Date de fin:</label>
                        <span v-if="task.status === 'completed'">{{ formatDate(task.due_date_user ?? task.due_date) }}</span>
                        <Calendar v-else v-model="form.due_date_user" showTime hourFormat="24"
                                  class="w-100" placeholder="Date de fin" dateFormat="dd/mm/yy"/>
                      </div>
                      <div class="mb-3">
                        <span class="fw-bold d-block mb-1">Durée:</span>
                        <Tag severity="success" class="p-tag-light-success">
                          {{ formatDeadline(form.due_date_user ? form.due_date_user: task.due_date_user ?  task.due_date_user: task.due_date, form.start_date_user ? form.start_date_user : task.start_date_user ?task.start_date_user: task.start_date, task) }}
                        </Tag>
                      </div>
                      <div class="mb-3">
                        <span class="fw-bold d-block mb-1">Assigné à:</span>
                        <span v-if="task.assigned_user_id">{{ task.assigned_user ? task.assigned_user.name : "N/A" }}</span>
                        <span v-else-if="task.assigned_team_id">{{ task.assigned_team ? task.assigned_team.name : "N/A" }}</span>
                        <span v-else>N/A</span>
                      </div>
                    </div>
                  </div>
                </Fieldset>

                <Fieldset legend="Instructions" :toggleable="true">
                  <div v-if="form.instructions && form.instructions.length > 0">
                    <ProgressBar :value="progressPercentage" class="mb-4" :showValue="true">
                        {{ progressPercentage }}%
                    </ProgressBar>
                    <div v-for="(instruction) in form.instructions" :key="instruction.id"
                         class="mb-3 p-3 border rounded bg-light">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <p class="fw-bold m-0 fs-6">{{ instruction.description }}</p>
                        <Button icon="pi pi-pencil" class="p-button-rounded p-button-text p-button-sm"
                                @click="toggleEditMode(instruction)" v-if="task.status !== 'completed'"/>
                      </div>

                      <div v-if="instruction.response_type === 'checkbox'">
                        <Checkbox v-model="instruction.value" :binary="true"
                                  :inputId="'instruction-' + instruction.id"
                                  @change="updateInstructionResponse(instruction)"
                                  :disabled="task.status === 'completed' || instruction.isEditing === false && task.status !== 'completed' && !instruction.isEditing "/>
                        <label :for="'instruction-' + instruction.id" class="ms-2">Cocher si fait</label>
                      </div>

                      <div v-else-if="instruction.response_type === 'text / valeur' || instruction.response_type === 'text' || instruction.response_type === 'number'">
                        <div v-if="instruction.isEditing && task.status !== 'completed'">
                          <InputText :type="instruction.response_type === 'number' ? 'number' : 'text'"
                                     v-model="instruction.value"
                                     @blur="updateInstructionResponse(instruction)"
                                     class="form-control form-control-sm" />
                        </div>
                        <div v-else>
                          <span class="fw-semibold">Valeur: </span>
                          <span class="text-muted">{{ instruction.value || "Non renseigné" }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-else class="text-center text-muted p-3">
                    Aucune instruction n'a été configurée pour cette tâche.
                  </div>
                </Fieldset>
              </div>
            </Panel>
          </div>
        </div>
        <!--end::Content-->
      </div>
    </div>
  </template>

  <script>
import Calendar from 'primevue/calendar';
import Checkbox from 'primevue/checkbox';
import Fieldset from 'primevue/fieldset';
import InputText from 'primevue/inputtext';
import Panel from 'primevue/panel';
import ProgressBar from 'primevue/progressbar';
import ProgressSpinner from 'primevue/progressspinner';
import Tag from 'primevue/tag';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { onMounted, reactive, ref } from "vue";
import useInstructions from "../../services/instructionServices";
import useTasks from "../../services/taskServices";
  export default {
    setup() {
      const { getTask, task, isLoading, updateTask } = useTasks();
      const { updateInstruction, getInstruction } = useInstructions();
      const progressPercentage = ref(0);
      const taskId = ref(0);
        const form=reactive({
            start_date_user: null,
            due_date_user: null,
            status : '',
            instructions: []
        });
      const toast = useToast();
      onMounted(async () => {
        taskId.value = window.location.pathname.split("/")[2];
        await getTask(taskId.value);
        Object.assign(form, task.value);
        calculateProgress();
        if(form.instructions && form.instructions.length==0){
            progressPercentage.value=100;
        }
      });

      const calculateProgress = () => {
        if (form.instructions && form.instructions.length > 0) {
          const totalInstructions = form.instructions.length;
          const completedInstructions = form.instructions.filter(
            (instruction) => {
              if (instruction.response_type === "checkbox" ) {
                return instruction.value; // Checkbox: true if checked
              } else {
                return instruction.value !== null && instruction.value !== ""; // Other types: not null or empty
              }
            }
          ).length;

          progressPercentage.value = totalInstructions > 0 ? Math.round((completedInstructions / totalInstructions) * 100) : 0;
        } else {
          progressPercentage.value = 0;
        }
      };

      const updateInstructionResponse = async (instruction) => {
        if (task.value.status === 'completed') return;

        // For checkbox, toggle edit mode off immediately after change
        if (instruction.response_type === 'checkbox') {
            instruction.isEditing = false;
        }

        // Only update if it's not a checkbox or if it is a checkbox and editing mode was on (which it won't be due to above)
        // Or if it's another type and editing mode is being turned off
        if (instruction.response_type !== 'checkbox' || (instruction.response_type === 'checkbox' && instruction.isEditing)) {
            if (instruction.value !== instruction.originalValue) {
              await updateInstruction(instruction.id, { value: instruction.value });
              await getTask(taskId.value); // Refresh the whole task to get updated instructions
              Object.assign(form, task.value); // Re-assign to keep form reactive with new task data
              const updatedInstruction = form.instructions.find(i => i.id === instruction.id);
              if (updatedInstruction) updatedInstruction.originalValue = updatedInstruction.value;
            }
        }
        calculateProgress();
      };
      const toggleEditMode = (instruction) => {
        instruction.isEditing = !instruction.isEditing;
      };
      const formatDeadline = (end_date, start_date, task) => {
        if (start_date && end_date) {
          const startDate = new Date(start_date);
          const endDate = new Date(end_date);
          const now = new Date();

          let timeDifference;
          let isPast = false;

          if (endDate.getTime() < now && task.status != "completed") {
            //   timeDifference = endDate.getTime() - now.getTime();
            isPast = true;
          } else {
            timeDifference = endDate.getTime() - startDate.getTime();
          }
          const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
          const hours = Math.floor(
            (timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
          );
          const minutes = Math.round(
            (timeDifference % (1000 * 60 * 60)) / (1000 * 60)
          );

          let delayString = `${isPast ? "DeadlineExceed" : ""}`;
          if (days > 0) {
            delayString += `${days} jour${days > 1 ? "s" : ""} `;
          }
          if (hours > 0) {
            delayString += `${hours}h `;
          }
          if (minutes > 0) {
            delayString += `${minutes}min`;
          }
          if (days === 0 && hours === 0 && minutes === 0) {
            delayString = "0 min";
          }

          if (isPast) {
            return `${delayString.trim()}`;
          } else {
            return delayString.trim();
          }
        } else {
          return null;
        }
      };

      // New functions to handle task completion/pause
      const updateTaskOnly=async()=>{
        isLoading.value = true;
        await updateTask(taskId.value, form);
        await getTask(taskId.value); // Refresh task data
        Object.assign(form, task.value);
        isLoading.value = false;
        toast.add({severity:'success', summary: 'Succès', detail:'Tâche mise à jour', life: 3000});
      }
      const completeTask = async () => {
        try {
            form.status = "completed";
            console.log({...form});
          await updateTask(taskId.value, form);
          await getTask(taskId.value); // Refresh task data
        } catch (error) {
          toast.add({severity:'error', summary: 'Erreur', detail:'Impossible de terminer la tâche', life: 3000});
        }
        Object.assign(form, task.value);
        toast.add({severity:'success', summary: 'Succès', detail:'Tâche terminée', life: 3000});
      };

      const pauseTask = async () => {
        try {
            form.status="paused";

          await updateTask(taskId.value, form);
          await getTask(taskId.value); // Refresh task data
        } catch (error) {
          toast.add({severity:'error', summary: 'Erreur', detail:'Impossible de mettre la tâche en pause', life: 3000});
        } finally {
          Object.assign(form, task.value);
          toast.add({severity:'info', summary: 'Info', detail:'Tâche mise en pause', life: 3000});
          calculateProgress();
        }
      };
      const formatDate=(dateLocal)=>{
    const date = new Date(dateLocal);
    return new Intl .DateTimeFormat('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    }).format(date);
}
      return {
        updateTaskOnly,
        form,
        formatDate,
        task,
        isLoading,
        progressPercentage,
        updateInstructionResponse,
        toggleEditMode,
        formatDeadline,
        completeTask,
        pauseTask,
      };
    },
    components: {
      Panel,
      Button: () => import('primevue/button'), // Dynamically import Button
      Fieldset,
      Tag,
      Calendar,
      ProgressBar,
      Checkbox,
      InputText,
      ProgressSpinner,
      Toast
    }
  };
  </script>
