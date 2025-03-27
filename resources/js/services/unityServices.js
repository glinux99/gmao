import { ref } from 'vue';
import instance from '../api/index';

export default function useUnities() {
    const unities = ref([]);
    const errors = ref({});
    const isLoading = ref(false);

    const getUnities = async () => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.get('/api/unities');
            unities.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeUnity = async (data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.post('/api/unities', data);
            unities.value.push(response.data.data);
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const updateUnity = async (id, data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.put(`/api/unities/${id}`, data);
            const index = unities.value.findIndex((u) => u.id === id);
            if (index !== -1) {
                unities.value[index] = response.data.data;
            }
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const destroyUnity = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            await instance.delete(`/api/unities/${id}`);
            unities.value = unities.value.filter((unity) => unity.id !== id);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        unities,
        errors,
        isLoading,
        getUnities,
        storeUnity,
        updateUnity,
        destroyUnity,
    };
}
