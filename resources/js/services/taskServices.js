import axios from 'axios';
import { ref } from 'vue';

export default function useTasks() {
    const tasks = ref([]);
    const task = ref({});
    const errors = ref({});
    const isLoading = ref(false);

    const getTasks = async () => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.get('/api/tasks');
            tasks.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getTask = async (id) => {
        errors.value = {};
        isLoading.value = true;
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
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.post('/api/tasks', data);
            tasks.value.push(response.data.data);
             return true;
        } catch (e) {
            errors.value = e.response.data.error;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const updateTask = async (id, data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.put(`/api/tasks/${id}`, data);
            const index = tasks.value.findIndex((t) => t.id === id);
            if (index !== -1) {
                tasks.value[index] = response.data.data;
            }
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const destroyTask = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            await axios.delete(`/api/tasks/${id}`);
            tasks.value = tasks.value.filter((task) => task.id !== id);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getTaskCategories = async () => {
        return [
           {"name":  "Préventive"},
           {"name":  "Corrective"},
            {"name": "Predictive"},
           {"name": "Inspection"}
        ];
    }

    return {
        tasks,
        task,
        errors,
        isLoading,
        getTasks,
        getTask,
        storeTask,
        updateTask,
        destroyTask,
        getTaskCategories
    };
}
