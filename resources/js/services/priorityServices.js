// resources/js/services/priorityServices.js

import { ref } from 'vue';
import instance from '../api/index';

export default function usePriorities() {
    const priorities = ref([]);
    const isLoading = ref(false);
    const errors = ref(null);

    const getPriorities = async () => {
        isLoading.value = true;
        errors.value = null;
        try {
            const response = await instance.get('/api/priority');
            priorities.value = response.data.data;
        } catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storePriority = async (priority) => {
        isLoading.value = true;
        errors.value = null;
        try {
            const response = await instance.post('/api/priority', priority);
            return true;
        } catch (error) {
            errors.value = error.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const updatePriority = async (id, priority) => {
        isLoading.value = true;
        errors.value = null;
        try {
            const response = await instance.put(`/api/priority/${id}`, priority);
            return true;
        } catch (error) {
            errors.value = error.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const deletePriority = async (id) => {
        isLoading.value = true;
        errors.value = null;
        try {
            await instance.delete(`/api/priority/${id}`);
        } catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        priorities,
        isLoading,
        errors,
        getPriorities,
        storePriority,
        updatePriority,
        deletePriority,
    };
}
