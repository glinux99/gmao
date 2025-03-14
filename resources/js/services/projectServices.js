// resources/js/services/projectServices.js
import { ref } from "vue";
import axios from "axios";

export default function useProjects() {
    const projects = ref([]);
    const project = ref({});
    const errors = ref({});
    const isLoading = ref(false);

    const getProjects = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get("/api/projects");
            projects.value = response.data.data;
            console.log(projects.value);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getProject = async (id) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get(`/api/projects/${id}`);
            project.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeProject = async (data) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.post("/api/projects", data);
            project.value = response.data.data;
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    const updateProject = async (id, data) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.put(`/api/projects/${id}`, data);
            project.value = response.data.data;
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    const deleteProject = async (id) => {
        isLoading.value = true;
        errors.value = {};
        try {
            await axios.delete(`/api/projects/${id}`);
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    // New functions for fetching related data:
    const getProjectCategories = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await axios.get("/api/projects");
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
        projects,
        project,
        getProjects,
        getProject,
        storeProject,
        updateProject,
        deleteProject,
        getProjectCategories, // Export the new functions
        getUsers, // Export the new functions
        errors,
        isLoading,
    };
}
