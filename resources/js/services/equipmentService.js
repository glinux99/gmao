import { ref } from 'vue';
import instance from '../api/index';

export default function useEquipments() {
    const equipments = ref([]);
    const equipment = ref({});
    const errors = ref({});
    const isLoading = ref(false);

    const getEquipments = async () => {
        isLoading.value = true;
        try {
            const response = await instance.get('/api/equipments');
            equipments.value = response.data.data;
            errors.value = {};
        } catch (e) {
            errors.value = e.response.data.errors || {};
        } finally {
            isLoading.value = false;
        }
    };

    const getEquipment = async (id) => {
        isLoading.value = true;
        try {
            const response = await instance.get(`/api/equipments/${id}`);
            equipment.value = response.data.data;
            errors.value = {};
        } catch (e) {
            errors.value = e.response.data.errors || {};
        } finally {
            isLoading.value = false;
        }
    };

    const storeEquipment = async (data) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.post('/api/equipments', data);
            equipment.value = response.data.data;
             errors.value = {};
             await getEquipments();
        } catch (e) {
            errors.value = e.response.data.errors || {};
        } finally {
            isLoading.value = false;
        }
    };

    const updateEquipment = async (id, data) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.put(`/api/equipments/${id}`, data);
            equipment.value = response.data.data;
            errors.value = {};
            await getEquipments();
        } catch (e) {
            errors.value = e.response.data.errors || {};
        } finally {
            isLoading.value = false;
        }
    };

    const destroyEquipment = async (id) => {
        isLoading.value = true;
        try {
            await instance.delete(`/api/equipments/${id}`);
            await getEquipments();
            errors.value = {};
        } catch (e) {
            errors.value = e.response.data.errors || {};
        } finally {
            isLoading.value = false;
        }
    };

    return {
        equipments,
        equipment,
        errors,
        isLoading,
        getEquipments,
        getEquipment,
        storeEquipment,
        updateEquipment,
        destroyEquipment,
    };
}
