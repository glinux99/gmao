import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';
import instance from '../api/index';

export default function useInstructions() {
    const errors = ref({});
    const isLoading = ref(false);
    const instructions = ref([]);
    const toast = useToast();

    const getInstructions = async (taskId = null) => {
        errors.value = {};
        isLoading.value = true;
        let url = '/api/instructions';
        if (taskId) {
            url += `?task_id=${taskId}`;
        }
        try {
            const response = await instance.get(url);
            instructions.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
            toast.add({ severity: 'error', summary: 'Error', detail: 'Erreur lors de la récupération des instructions', life: 3000 });
        } finally {
            isLoading.value = false;
        }
    };

    const storeInstruction = async (data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.post('/api/instructions', data);
            instructions.value.push(response.data.data);
            toast.add({ severity: 'success', summary: 'Success', detail: 'Instruction ajoutée', life: 3000 });
        } catch (e) {
            errors.value = e.response.data.errors;
            toast.add({ severity: 'error', summary: 'Error', detail: 'Erreur lors de l\'ajout de l\'instruction', life: 3000 });
        } finally {
            isLoading.value = false;
        }
    };

    const updateInstruction = async (id, data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.put(`/api/instructions/${id}`, data);
            const index = instructions.value.findIndex((i) => i.id === id);
            if (index !== -1) {
                instructions.value[index] = response.data.data;
            }
            toast.add({ severity: 'success', summary: 'Success', detail: 'Instruction a été modifiée', life: 3000 });
        } catch (e) {
            errors.value = e.response.data.errors;
            toast.add({ severity: 'error', summary: 'Error', detail: 'Erreur lors de la modification de l\'instruction', life: 3000 });
        } finally {
            isLoading.value = false;
        }
    };

    const deleteInstruction = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            await instance.delete(`/api/instructions/${id}`);
            instructions.value = instructions.value.filter((item) => item.id !== id);
            toast.add({ severity: 'warn', summary: 'Warn', detail: 'Instruction supprimée', life: 3000 });
        } catch (e) {
            errors.value = e.response.data.errors;
            toast.add({ severity: 'error', summary: 'Error', detail: 'Erreur lors de la suppression de l\'instruction', life: 3000 });
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
        deleteInstruction,
    };
}
