// resources/js/services/maintenanceService.js
import { ref } from "vue";
import instance from "../api/index";

export default function useMaintenances() {
    const maintenances = ref([]);
    const maintenance = ref({});
    const errors = ref({});
    const isLoading = ref(false);

    const getMaintenances = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.get("/api/maintenances");
            maintenances.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getMaintenance = async (id) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.get(`/api/maintenances/${id}`);
            maintenance.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeMaintenance = async (data) => {
        isLoading.value = true;
        errors.value = {};

            try {
                const response = await instance.post("/api/maintenances", data);
                maintenance.value = response.data.data;
                return true; // Success
            } catch (error) {
                errors.value = error.response.data.errors;
                return false; // Failure
            } finally {
                isLoading.value = false;
            }
    };

    const updateMaintenance = async (id, data) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.put(`/api/maintenances/${id}`, data);
            maintenance.value = response.data.data;
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };

    const destroyMaintenace = async (id) => {
        isLoading.value = true;
        errors.value = {};
        try {
            await instance.delete(`/api/maintenances/${id}`);
            return true; // Success
        } catch (error) {
            errors.value = error.response.data.errors;
            return false; // Failure
        } finally {
            isLoading.value = false;
        }
    };
      /**
   * search and filter maintenances.
   * @param {string} searchQuery the query for searching.
   * @returns {Promise<Array>} An array of maintenance objects.
   */
    const searchAndFilter = async (searchQuery) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await instance.get(`/api/maintenances?search=${searchQuery}`);
            maintenances.value = response.data.data;
        } catch (error) {
            errors.value = error.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        maintenances,
        maintenance,
        getMaintenances,
        getMaintenance,
        storeMaintenance,
        updateMaintenance,
        destroyMaintenace,
        errors,
        isLoading,
         searchAndFilter,
    };
}
