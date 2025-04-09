// regionServices.js
import { ref } from 'vue';
import instance from '../api';

export default function useRegion() {
  const regions = ref([]);
  const isLoading = ref(false);
  const errors = ref(null);

  const getRegions = async () => {
    isLoading.value = true;
    errors.value = null;
    try {
      const response = await instance.get('/api/regions'); // Replace with your API endpoint
      regions.value = response.data.data; // Assuming your API returns data in a 'data' field
    } catch (err) {
      errors.value = err.response ? err.response.data : err.message;
    } finally {
      isLoading.value = false;
    }
  };

  const storeRegion = async (regionData) => {
    isLoading.value = true;
    errors.value = null;
    try {
      const response = await instance.post('/api/regions', regionData); // Replace with your API endpoint
      return response.data;
    } catch (err) {
      errors.value = err.response ? err.response.data : err.message;
    } finally {
      isLoading.value = false;
    }
  };

  const updateRegion = async (id, regionData) => {
    isLoading.value = true;
    errors.value = null;
    try {
      const response = await instance.put(`/api/regions/${id}`, regionData); // Replace with your API endpoint
      return response.data;
    } catch (err) {
      errors.value = err.response ? err.response.data : err.message;
    } finally {
      isLoading.value = false;
    }
  };

  const deleteRegion = async (id) => {
    isLoading.value = true;
    errors.value = null;
    try {
      await instance.delete(`/api/regions/${id}`); // Replace with your API endpoint
    } catch (err) {
      errors.value = err.response ? err.response.data : err.message;
    } finally {
      isLoading.value = false;
    }
  };

  return {
    regions,
    isLoading,
    errors,
    getRegions,
    storeRegion,
    updateRegion,
    deleteRegion,
  };
}
