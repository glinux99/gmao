import axios from 'axios';
import { ref } from 'vue';

export default function useInstructions() {
    const errors = ref ({});
    const isLoading = ref(false);
    const instructions = ref([]);

    const getInstructions = async (taskId = null) => {
        errors.value = {};
        isLoading.value = true;
        let url = '/api/instructions';
        if (taskId) {
            url += `?task_id=${taskId}`;
        }
        try {
            const response = await axios.get(url);
            instructions.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeInstruction = async (data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.post('/api/instructions', data);
             instructions.value.push(response.data.data);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const updateInstruction = async (id, data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.put(`/api/instructions/${id}`, data);
              const index = instructions.value.findIndex((i) => i.id === id);
            if (index !== -1) {
                instructions.value[index] = response.data.data;
            }
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };
     const deleteInstruction = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            await axios.delete(`/api/instructions/${id}`);
            instructions.value = instructions.value.filter((item) => item.id !== id);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        instructions,
        errors,
        isLoading,
        getInstructions,
        storeInstruction,
        updateInstruction,
        deleteInstruction
    };
}
