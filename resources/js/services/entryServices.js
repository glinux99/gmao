import { ref } from 'vue';
import instance from '../api';
// import routes from "../router/index.js"; // If you use vue router, use this line.
// import instance from "../api/index.js"; // if you use instance instead of axios, use this line.

export default function useEntry() {
  const entries = ref([]);
  const errors = ref({});
  const loading = ref(false);

  const getEntries = async () => {
    loading.value = true;
    try {
      const response = await instance.get('/api/entries');
      entries.value = response.data.data;
    } catch (error) {
      console.error('Error fetching entries:', error);
    } finally {
      loading.value = false;
    }
  };

  const storeEntry = async (entryData) => {
    loading.value = true;
    errors.value = {};
    try {
      const response = await instance.post('/api/entries', entryData);
    } catch (error) {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        console.error('Error creating entry:', error);
      }
    } finally {
        loading.value = false;
    }
  };

  const updateEntry = async (entryId, entryData) => {
    loading.value = true;
    errors.value = {};
    try {

      const response = await instance.put(`/api/entries/${entryId}`, entryData);
      const index = entries.value.findIndex(entry => entry.id === entryId);
      if (index !== -1) {
        entries.value[index] = response.data.data;
      }
    } catch (error) {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        console.error('Error updating entry:', error);
      }
    } finally {
      loading.value = false;
    }
  };

  const deleteEntry = async (entryId) => {
      loading.value = true;
    try {
      await instance.delete(`/api/entries/${entryId}`);
      entries.value = entries.value.filter(entry => entry.id !== entryId);
    } catch (error) {
      console.error('Error deleting entry:', error);
    } finally {
      loading.value = false;
    }
  };

  return {
    entries,
    errors,
    loading,
    getEntries,
    storeEntry,
    updateEntry,
    deleteEntry,
  };
}
