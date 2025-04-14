<template>
    <div class="calendar-container">
      <!-- <div class="d-flex mb-3 justify-content-end">
        <div>
            <button type="button" class="btn btn-primary" @click="addTask">
                Ajouter une Tâche
              </button>
        </div>
      </div> -->

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
    </div>
  </template>

  <script>
import frLocale from '@fullcalendar/core/locales/fr';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';
import FullCalendar from '@fullcalendar/vue3';
import { onMounted, reactive, ref, watch } from 'vue';
import modalComponent from "../../components/modals/modalComponent.vue";
import useCalendar from '../../services/calendarService.js';
import useProjects from "../../services/projectServices.js";
import useTasks from '../../services/taskServices';
import useUsers from '../../services/userservices.js';

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
                    Responsable : ${info.event.extendedProps.owner} <br/>
                    Technicien : ${info.event.extendedProps.user} <br/>
                    Status : ${info.event.extendedProps.status}<br/>
                    Debut : ${info.event.start.toLocaleDateString()}<br/>
                    Fin : ${info.event}<br/>
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
                window.location.pathname = "/tasks/"+task.id2;
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
