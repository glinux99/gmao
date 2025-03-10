<template>
    <div class="calendar-container">
      <div class="d-flex mb-3 justify-content-end">
        <div>
            <button type="button" class="btn btn-primary" @click="addTask">
                Ajouter une Tâche
              </button>
        </div>
      </div>

      <div v-if="isLoading">Loading...</div>
      <div v-else-if="Object.keys(errors).length > 0">
        <p>An error occurred while fetching data:</p>
        <ul>
          <li v-for="(error, key) in errors" :key="key">
            {{ key }}: {{ error }}
          </li>
        </ul>
      </div>
      <FullCalendar v-else :options="calendarOptions" ref="fullCalendarRef" :events="events"/>

      <modal-component :id="'task-modal'" positionModal="center mw-700px" :form="form" @instance-modal="submitTask">
        <template #title>{{ isEditMode ? 'Modifier' : 'Créer' }} une Tâche</template>
        <template #body>
          <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
            data-kt-scroll-offset="300px">
            <div class="row my-6">
              <label class="col-lg-4 col-form-label fw-bold fs-6">
                <span class="required">Projet</span>
                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="categorie"></i>
              </label>
              <div class="col-lg-8 fv-row">
                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="project"
                  v-model="form.project_id">
                  <option v-for="project in projects" :value="project.id" :key="project.id">
                    {{ project.name }}
                  </option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">
                <label class="required fw-semibold fs-6 mb-2">Titre</label>
                <input type="text" name="designation" class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="titre de la tâche" v-model="form.description" required>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">
                <label class="required fw-semibold fs-6 mb-2">Proprietaire</label>
                <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Proprietaire de la tâche"
                  v-model="form.owner">
                  <option value="">Selectionner un propriétaire</option>

                  <option v-for="user in users" :value="user.id" :key="user.id">
                    {{ user.name }}
                  </option>
                </select>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
              </div>
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">
                  <span class="required">Status</span>
                  <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Status"></i>
                </label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                  <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Status de la tâche"
                    v-model="form.status">
                    <option value="pending">En attente</option>
                    <option value="in_progress">En cours</option>
                    <option value="completed">Terminée</option>
                  </select>
                </div>
                <!--end::Col-->
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container row">
                <div class="col-md-4">
                  <label class="required fw-semibold fs-6 mb-2">Assigne</label>
                </div>
                <div class="col-md-8">
                  <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Proprietaire de la tâche"
                    v-model="form.user_id">
                    <option value="">Selectionner un utilisateur</option>
                    <option v-for="user in users" :value="user.id" :key="user.id">
                      {{ user.name }}
                    </option>
                  </select>
                </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
              </div>
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">
                  <span class="required">Priorite</span>
                  <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Priorite"></i>
                </label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                  <select class="form-select form-select-solid mb-3 mb-lg-0" aria-label="Status de la tâche"
                    v-model="form.priority">
                    <option value="Eleve">Eleve</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Faible">Faible</option>
                  </select>
                </div>
                <!--end::Col-->
              </div>
              <div class="d-flex gap-2">
                <div class="fv-row mb-10">
                  <label class="fs-5 fw-bold form-label mb-2">
                    Date de debut
                  </label>
                  <input type="date" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0"
                    placeholder="nom de la tâche" v-model="form.start_date" @input="calculateDelay">
                </div>
                <div class="fv-row mb-10">
                  <label class="fs-5 fw-bold form-label mb-2">
                    Date de fin
                  </label>
                  <input type="date" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0"
                    placeholder="nom de la tâche" v-model="form.due_date" @input="calculateDelay">
                </div>
                <div class="fv-row mb-10">
                  <label class="fs-5 fw-bold form-label mb-2">
                    Deadline
                  </label>
                  <input type="text" name="deadline" class="form-control form-control-solid mb-3 mb-lg-0"
                    placeholder="0 jour" v-model="form.delay">
                </div>

              </div>
              <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input me-3" name="notification" type="checkbox" value="1" checked>
                <label class="form-check-label">
                  <div class="fw-bold text-gray-800">Envoyer une notification si le deadline depasse?</div>
                  <div class="text-gray-600">
                  </div>
                </label>

              </div>
            </div>

          </div>
        </template>
      </modal-component>
    </div>
  </template>

  <script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list';
import modalComponent from "../../components/modals/modalComponent.vue";
import frLocale from '@fullcalendar/core/locales/fr';
import useCalendar from '../../services/calendarService.js';
import useTasks from '../../services/taskServices';
import { ref, onMounted, reactive, watch } from 'vue';
import useUsers from '../../services/userservices.js';
import useProjects from "../../services/projectServices.js";
import axios from 'axios';

export default {
    name: 'CalendarList',
    components: {
        FullCalendar,
        modalComponent,
    },
    setup() {
        const { errors, isLoading, events,formatEvents } = useCalendar();
        const { storeTask, updateTask, tasks, getTasks } = useTasks();
        const { getUsers, users } = useUsers();
        const { getProjects, projects } = useProjects();
        const fullCalendarRef = ref(null);
        const isModalOpen = ref(false);
        const isEditMode = ref(false);
        const form = reactive({
            id: null,
            priority: "",
            status: "pending",
            comments: "",
            complete: null,
            description: "",
            type: "",
            user_id: null,
            category_id: null,
            owner: null,
            task_id: null,
            assigned_date: null,
            start_date: null,
            due_date: null,
            delay: null,
            project_id: null,
        });

        const calendarOptions = reactive({
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            editable: true, // Enable dragging and resizing
            eventResizableFromStart: true, // Allow resizing from the start of the task
            locales: [frLocale],
            locale: 'fr',
            eventClick: handleEventClick,
            dateClick: handleDateClick,
            eventMouseEnter: handleEventMouseEnter, // Add popover on hover
            eventMouseLeave: handleEventMouseLeave,
            eventDrop: (arg)=>{
                handleEventDrop(arg);
            }, // Handle event dragging
            // eventResize: handleEventResize, // Handle event resizing
            eventDidMount: (info) => {
                // Add popover content here
                const popover = new bootstrap.Popover(info.el, {
                    title: info.event.title,
                    content: `
                    Description : ${info.event.extendedProps.description}<br/>
                    Project : ${info.event.extendedProps.projectName} <br/>
                    Owner : ${info.event.extendedProps.owner} <br/>
                    User : ${info.event.extendedProps.user} <br/>
                    Status : ${info.event.extendedProps.status}<br/>
                    Debut : ${info.event.start.toLocaleDateString()}<br/>
                    Debut : ${info.event.start. toLocaleDateString()}<br/>
                    Fin : ${info.event.end ? info.event.end.toLocaleDateString() : "No end date"}
                    `,
                    html: true,
                    placement: 'top',
                    trigger: 'hover',
                });
                info.el.addEventListener('click', () => {
                    popover.hide()
                })
            },

        });


        const fetchAndFormatTasks = async () => {
            await getTasks();
            calendarOptions.events = formatEvents(tasks.value);
            // fullCalendarRef.value.getApi().refetchEvents();

        };
        watch( tasks.value, (newValue, oldValue) => {
	calendarOptions.events = newValue;
})


        onMounted(async () => {
            // await fetchProjects();
            await getUsers();
            fetchAndFormatTasks();
        });

        function handleEventClick(arg) {
            console.log('Event clicked:', arg.event);
            editTask(arg.event.extendedProps)
        }

        function handleDateClick(arg) {
            console.log('Date clicked:', arg.dateStr);
            openModal();
            form.start_date = arg.dateStr;
            form.due_date = arg.dateStr;
        }

        function handleEventMouseEnter(arg) {
            arg.el.classList.add('event-hover'); // Add class on hover
        }

        function handleEventMouseLeave(arg) {
            arg.el.classList.remove('event-hover'); // Remove class on mouse leave
        }

        const handleEventDrop = async (arg) => {
            // arg.event contains the updated event data
            console.log('Event dropped:', arg.event);
            console.log('Event dropped:', {... arg.event.extendedProps.id});

            // const success = await updateTask(arg.event.extendedProps.id, {
            //     start_date: arg.event.start.toISOString().slice(0, 10), // Extract date portion
            //     due_date: arg.event.end ? arg.event.end.toISOString().slice(0, 10) : arg.event.start.toISOString().slice(0, 10),
            // });
            // if (!success) {
            //     alert('error during the modification');
            //     arg.revert()
            // }
        };

        const handleEventResize = async (arg) => {
            console.log('Event resized:', arg.event);
            const success = await updateTask(arg.event.extendedProps.id, {
                start_date: arg.event.start.toISOString().slice(0, 10), // Extract date portion
                due_date: arg.event.end ? arg.event.end.toISOString().slice(0, 10) : arg.event.start.toISOString().slice(0, 10),
            });
            if (!success) {
                alert('error during the modification');
                arg.revert()
            }
        };
        const openModal = () => {
            isModalOpen.value = true;
            isEditMode.value = false;
            resetForm();
        };

        const closeModal = () => {
            isModalOpen.value = false;
            resetForm();
        };

        const resetForm = () => {
            form.id = null;
            form.priority = "";
            form.status = "pending";
            form.comments = "";
            form.complete = null;
            form.description = "";
            form.type = "";
            form.user_id = null;
            form.category_id = null;
            form.owner = null;
            form.task_id = null;
            form.assigned_date = null;
            form.start_date = null;
            form.due_date = null;
            form.delay = null;
            form.project_id = null;
        };

        const addTask = () => {
            isEditMode.value = false;
            $("#task-modal").modal("show");
            resetForm();
        };

        const editTask = (task) => {
            isEditMode.value = true;
            $("#task-modal").modal("show");
            Object.assign(form, task);
            calculateDelay();
        };

        const submitTask = async () => {
            let success = false;
            if (isEditMode.value) {
                success = await updateTask(form.id, form);
            } else {
                success = await storeTask(form);
            }
            if (success) {
                closeModal();
                await fetchAndFormatTasks(); // Refetch tasks after creation/update
            }
            else {
                alert('error during the creation');
            }
        };

        // Function to calculate the delay
        const calculateDelay = () => {
            if (form.start_date && form.due_date) {
                const startDate = new Date(form.start_date);
                const dueDate = new Date(form.due_date);

                // Calculate the difference in days
                const timeDifference = dueDate.getTime() - startDate.getTime();
                const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)); // Convert milliseconds to days

                // Set the delay
                form.delay = dayDifference + (dayDifference > 1 ? " jours" : " jour");
            } else {
                form.delay = null; // Reset the delay if one of the dates is missing
            }
        };

        return {
            calendarOptions,
            errors,
            isLoading,
            isModalOpen,
            openModal,
            closeModal,
            fullCalendarRef,
            projects,
            users,
            form,
            calculateDelay,
            submitTask,
            isEditMode,
            addTask,
            editTask,
            events
        };
    },
};
</script>
