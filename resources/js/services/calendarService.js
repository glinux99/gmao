// resources/js/services/calendarService.js

import { ref } from "vue";
import instance from "../api/index";

export default function useCalendar() {
    const tasks = ref([]);
    const errors = ref({});
    const isLoading = ref(false);
    const events = ref([]); // Add this line

    const getTasks = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.get("/api/tasks"); // Eager load the 'project' relation
            tasks.value = response.data.data;
            events.value = formatEvents(tasks.value) // add this line
        } catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const formatEvents = (tasksToFormat) => {

        return tasksToFormat.map(task => {
            let endDate;
            let formattedEndDate;
           if (task.due_date) {
                endDate = new Date(task.due_date);
                formattedEndDate = endDate.toISOString();
              }
            else {
                endDate = new Date(task.created_at).getHours();
               formattedEndDate = endDate.toISOString();
           }
           console.log(task.assigned_team);
           const assigned_team = ref("");
           try {
             assigned_team.value =task.assigned_team.users[0].name ;
           } catch (error) {
            console.log(error);
           }
            return {
            id: task.id,
            title: task.description ? task.description + ` (${task.assigned_user ? task.assigned_user.name : assigned_team.value? assigned_team.value: "No User"})` : "Task ID : " + task.id,
            start: task.start_date ? task.start_date : task.created_at,
            end:  task.start_date ? task.start_date : task.created_at,
            color: task.priority.color ? task.priority.color : getPriorityColor(task.priority.name), // Use priority-based color
            description: task.description ? task.description : "No description",
            projectId: task.project ? task.project.id : null, // Add project id
            projectName: task.project ? task.project.name : "No Project", // Add project name
            owner: task.owner ? task.owner_user.name : "No owner",
            user: task.assigned_user ? task.assigned_user.name : assigned_team? assigned_team: "No User",
            id2:task.id,
            status: task.status,
            due_date: task.status,
            }
        });
    };

    const getPriorityColor = (priority) => {
        switch (priority) {
            case "Eleve":
                return "#FF0000"; // Red for High
            case "Moyen":
                return "#FFA500"; // Orange for Medium
            case "Faible":
                return "#008000"; // Green for Low
            default:
                return "#000000"; // Black for unknown priority
        }
    };

    return {
        tasks,
        errors,
        isLoading,
        getTasks,
        formatEvents,
        events, // Add this line
    };
}
