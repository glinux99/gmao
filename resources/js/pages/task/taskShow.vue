<template>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

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
              <span class="spinner-border text-primary" role="status" aria-hidden="true"></span>
              <span class="sr-only">Loading...</span>
            </div>
            <div v-else class="card card-flush">
              <!--begin::Card header-->
              <div class="card-header mt-6">
                <div class="card-title">
                  <h2>{{ task.description }}</h2>
                </div>
                <div class="card-toolbar">
                  <button v-if="progressPercentage === 100 && task.status !== 'completed'" class="btn btn-success"
                    @click="completeTask">
                    <i class="ki-duotone ki-check fs-2"></i> Terminer
                  </button>
                  <button v-else-if="task.status === 'in_progress' && progressPercentage < 100" class="btn btn-warning"
                    @click="pauseTask">
                    <i class="ki-duotone ki-pause fs-2"></i> Mettre en Pause
                  </button>
                  <button v-else-if="task.status !== 'completed' && progressPercentage < 100" class="btn btn-info"
                    @click="updateTaskOnly">
                    <i class="ki-duotone ki-refresh fs-2"></i> Mettre à Jour la tache
                  </button>
                </div>
              </div>
              <!--end::Card header-->

              <!--begin::Card body-->
              <div class="card-body pt-0">
                <!--begin::Row-->
                <div class="row mb-10">
                  <!--begin::Col-->
                  <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                      <div class="d-flex align-items-center gap-2" v-if="task.priority">
                        <span class="fw-bold">Priorité:</span>

                        <span class="badge" :style="'background-color: '+task.priority.color">
                         <span class="text-muted mx-3">
                            {{ task.priority.title }}
                         </span>
                        </span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">Status:</span>
                        <span v-if="task.status === 'pending'" class="badge badge-warning mx-3">En attente</span>
                        <span v-else-if="task.status === 'in_progress'" class="badge badge-info mx-3">En cours</span>
                        <span v-else-if="task.status === 'completed'" class="badge badge-success mx-3">Terminée</span>
                        <span v-else-if="task.status === 'canceled'" class="badge badge-dark mx-3">Annulée</span>
                        <span v-else-if="task.status === 'delayed'" class="badge badge-danger mx-3">Delai depassé</span>
                        <span v-else class="badge badge-secondary mx-3">Inconnu</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">Responsable:</span>
                        <span>{{ task.owner_user ? task.owner_user.name : "N/A" }}</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">Projet:</span>
                        <span>{{ task.project ? task.project.name : "N/A" }}</span>
                      </div>
                    </div>
                  </div>
                  <!--end::Col-->

                  <!--begin::Col-->
                  <div class="col-md-6">
                    <div class="d-flex flex-column gap-3">
                      <div class="">
                        <span class="fw-bold">Date de début:</span>
                        <span v-if="task.status=='completed'"> &nbsp;{{ formatDate(task.start_date_user ?? task.start_date) }}</span>
                        <Calendar v-else
                            v-model="form.start_date_user"
                            showTime
                            hourFormat="24"
                            class="w-full md:w-14rem"
                            placeholder="Date de debut"
                            required
                        />
                      </div>
                      <div class="">
                        <span class="fw-bold">Date de fin:</span>
                        <span v-if="task.status=='completed'"> &nbsp;{{ formatDate(task.due_date_user ?? task.due_date) }}</span>
                        <Calendar v-else
                            v-model="form.due_date_user"
                            showTime
                            hourFormat="24"
                            class="w-full md:w-14rem"
                            placeholder="Date de debut"
                            required
                        />

                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">Durée:</span>
                        <span class="badge badge-light-success">
                          {{ formatDeadline(form.due_date_user ? form.due_date_user: task.due_date_user ?  task.due_date_user: task.due_date, form.start_date_user ? form.start_date_user : task.start_date_user ?task.start_date_user: task.start_date, task) }}

                        </span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold">Assigné à:</span>
                        <span v-if="task.assigned_user_id">
                          {{ task.assigned_user ? task.assigned_user.name : "N/A" }}
                        </span>
                        <span v-else-if="task.assigned_team_id">
                          {{ task.assigned_team ? task.assigned_team.name : "N/A" }}
                        </span>
                        <span v-else>N/A</span>
                      </div>
                    </div>
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Instructions-->
                <div class="mt-5" v-if="form.instructions.length>0">
                  <h3 class="mb-5">Instructions</h3>
                  <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" :style="{ width: progressPercentage + '%' }"
                      :aria-valuenow="progressPercentage" aria-valuemin="0" aria-valuemax="100">
                      {{ progressPercentage }}%
                    </div>
                  </div>
                  <!--begin::Instruction Item-->
                  <div v-for="(instruction) in task.instructions" :key="instruction.id"
                    class="mb-3 border rounded p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="fw-bold m-0">{{ instruction.description }}</p>
                      <button class="btn btn-sm btn-icon btn-primary" @click="toggleEditMode(instruction)">
                        <i class="ki-duotone ki-pencil fs-3">
                          <span class="path1"></span>
                          <span class="path2"></span>
                          <span class="path3"></span>
                          <span class="path4"></span>
                          <span class="path5"></span>
                        </i>
                      </button>
                    </div>

                    <!--begin::Checkbox Instruction-->
                    <div v-if="instruction.response_type === 'checkbox'" class="form-check">
                      <input class="form-check-input" type="checkbox" v-model="instruction.value"
                        :id="'instruction-' + instruction.id" @change="updateInstructionResponse(instruction)" />
                      <label class="form-check-label" :for="'instruction-' + instruction.id">
                        Cocher si fait
                      </label>
                    </div>
                    <!--end::Checkbox Instruction-->

                    <!--begin::Text/Value Instruction-->
                    <div v-else-if="instruction.response_type === 'text / valeur'">
                      <div v-if="instruction.isEditing">
                        <input type="text" v-model="instruction.value" @blur="updateInstructionResponse(instruction)"
                          class="form-control" />
                      </div>
                      <div v-else>
                        <span class="fw-bold">Valeur: </span>
                        <span>{{ instruction.value || "Non renseigné" }}</span>
                      </div>
                    </div>
                    <!--end::Text/Value Instruction-->

                    <!--begin::Number Instruction-->
                    <div v-else-if="instruction.response_type === 'number'">
                      <div v-if="instruction.isEditing">
                        <input type="number" v-model="instruction.value" @blur="updateInstructionResponse(instruction)"
                          class="form-control" />
                      </div>
                      <div v-else>
                        <span class="fw-bold">Valeur:</span>
                        <span>{{ instruction.value || "Non renseigné" }}</span>
                      </div>
                    </div>
                    <!--end::Number Instruction-->

                    <!--begin::Text Instruction-->
                    <div v-else-if="instruction.response_type === 'text'">
                      <div v-if="instruction.isEditing">
                        <input type="text" v-model="instruction.value" @blur="updateInstructionResponse(instruction)"
                          class="form-control" />
                      </div>
                      <div v-else>
                        <span class="fw-bold">Valeur:</span>
                        <span>{{ instruction.value || "Non renseigné" }}</span>
                      </div>
                    </div>
                    <!--end::Text Instruction-->
                  </div>
                  <!--end::Instruction Item-->
                </div>
                <div v-else>
                    <span class="text-muted" >
                        Aucune instruction a été configurée pour cette tâche
                    </span>
                </div>
                <!--end::Instructions-->
              </div>
              <!--end::Card body-->
            </div>
          </div>
        </div>
        <!--end::Content-->
      </div>
    </div>
  </template>

  <script>
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
        if (task.value && task.value.instructions) {
          const totalInstructions = task.value.instructions.length;
          const completedInstructions = task.value.instructions.filter(
            (instruction) => {
              if (instruction.response_type === "checkbox") {
                return instruction.value; // Checkbox: true if checked
              } else {
                return instruction.value !== null && instruction.value !== ""; // Other types: not null or empty
              }
            }
          ).length;

          progressPercentage.value =
            totalInstructions > 0
              ? Math.round((completedInstructions / totalInstructions) * 100)
              : 0;
        } else {
          progressPercentage.value = 0;
        }

      };

      const updateInstructionResponse = async (instruction) => {
        // Check if the value has changed before updating
        if (instruction.value !== instruction.originalValue) {
          await updateInstruction(instruction.id, { value: instruction.value });
          // Refresh the instruction data after update
            await getTask(taskId);
          instruction.originalValue = instruction.value;
        }
        instruction.isEditing = false;
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
        await updateTask(taskId.value, form);
        await getTask(taskId.value); // Refresh task data
      }
      const completeTask = async () => {
        try {
            form.status = "completed";
          await updateTask(taskId.value, form);
          await getTask(taskId.value); // Refresh task data
        } catch (error) {
          console.error("Error completing task:", error);
          // Handle error (e.g., show error message to user)
        }
        form.start_date_user=null;
        form.due_date_user=null;
        form.status=null;
      };

      const pauseTask = async () => {
        try {
            form.status="paused";

          await updateTask(taskId.value, form);
          await getTask(taskId.value); // Refresh task data
        } catch (error) {
          console.error("Error pausing task:", error);
          // Handle error (e.g., show error message to user)
        }
      };
      // New function to update all task instructions
      const updateTaskInstructions = async () => {
        try {
          if (task.value && task.value.instructions) {
            // Iterate over each instruction and update it
            for (const instruction of task.value.instructions) {
              // Check if the value has changed before updating
              if (instruction.value !== instruction.originalValue) {
                await updateInstruction(instruction.id, { value: instruction.value });
                // Refresh the instruction data after update
                console.log(instruction);
                await getInstruction(instruction.id);
                instruction.originalValue = instruction.value;
              }
            }
            await getTask(taskId.value); // Refresh task data
          }

        } catch (error) {
          console.error("Error updating task instructions:", error);
          // Handle error (e.g., show error message to user)
        } finally {
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
        updateTaskInstructions, // Expose the new function

      };
    },
  };
  </script>
