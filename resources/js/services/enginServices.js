// enginService.js
import { ref } from "vue";
import instance from "../api";

const API_URL = '/api/engins'; // Adjust the API endpoint if needed

const useEngins = () => {
    const engins =ref([]);
    const errors = ref(null);
  const getEngins = async () => {
    try {
      const response = await instance.get(API_URL);
      engins.value=response.data.data;
      console.log(engins.value);
      return response.data.data; // Assuming your API returns data in a 'data' field
    } catch (error) {
      console.error('Error fetching engins:', error);
      throw error;
    }
  };

  const storeEngin = async (enginData) => {
    try {
      const response = await instance.post(API_URL, enginData);
      return response.data.data;
    } catch (error) {
      console.error('Error creating engin:', error);
      throw error;
    }
  };

  const updateEngin = async (enginId, enginData) => {
    try {
      const response = await instance.put(`${API_URL}/${enginId}`, enginData);
      return response.data.data;
    } catch (error) {
      console.error('Error updating engin:', error);
      throw error;
    }
  };

  const destroyEngin = async (enginId) => {
    try {
      await instance.delete(`${API_URL}/${enginId}`);
      return true;
    } catch (error) {
      console.error('Error deleting engin:', error);
      throw error;
    }
  };

  return {
    engins,
    getEngins,
    storeEngin,
    updateEngin,
    destroyEngin,
  };
};

export default useEngins;
