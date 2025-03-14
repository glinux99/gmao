// resources/js/services/taskServices.js
import { ref } from "vue";
import axios from "axios";

export default function useTasks() {
    const tasks = ref([]);
    const task = ref({});
    const errors = ref({});
    const isLoading = ref(false);

    const getTasks = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get("/api/tasks");
            tasks.value = response.data.data;
            console.log(tasks.value);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getTask = async (id) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get(`/api/tasks/${id}`);
            task.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeTask = async (data) => {
        isLoading.value = true;
        errors.value = {};
        console.log("sssssssss");
        console.log(data);
        try {
            const response = await axios.post("/api/tasks", data);
            task.value = response.data.data;
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    const updateTask = async (id, data) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.put(`/api/tasks/${id}`, data);
            task.value = response.data.data;
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    const deleteTask = async (id) => {
        isLoading.value = true;
        errors.value = {};
        try {
            await axios.delete(`/api/tasks/${id}`);
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    // New functions for fetching related data:
    const getTaskCategories = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get("/api/tasks");
            return response.data.data;
        } catch (error) {
            errors.value = error.response.data.errors;
            return [];
        } finally {
            isLoading.value = false;
        }
    };

    const getUsers = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get("/api/users");
            return response.data.data;
        } catch (error) {
            errors.value = error.response.data.errors;
            return [];
        } finally {
            isLoading.value = false;
        }
    };

    return {
        tasks,
        task,
        getTasks,
        getTask,
        storeTask,
        updateTask,
        deleteTask,
        getTaskCategories, // Export the new functions
        getUsers, // Export the new functions
        errors,
        isLoading,
    };
}
