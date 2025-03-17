import axios from 'axios';
import { ref } from 'vue';

export default function useCategories() {
    const categories = ref([]);
    const errors = ref({});
    const isLoading = ref(false);

    const getCategories = async () => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.get('/api/categories');
             //   console.log(response.data);
            categories.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };
     const storeCategory = async (data) => {
        errors.value = {};
        isLoading.value = true;
        try {
             //console.log("store");
            const response = await axios.post('/api/categories', data);
            categories.value.push(response.data.data);
             return true;
        } catch (e) {
            errors.value = e.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };
     const updateCategory = async (id, data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await axios.put(`/api/categories/${id}`, data);
            const index = categories.value.findIndex((t) => t.id === id);
            if (index !== -1) {
                categories.value[index] = response.data.data;
            }
            return true;
        } catch (e) {
            errors.value = e.response.data.errors;
            return false;
        } finally {
            isLoading.value = false;
        }
    };
       const destroyCategory = async (id) => {
        errors.value = {};
        isLoading.value = true;
        try {
            await axios.delete(`/api/categories/${id}`);
            categories.value = categories.value.filter((task) => task.id !== id);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        categories,
        errors,
        isLoading,
        getCategories,
        storeCategory,
        updateCategory,
        destroyCategory,
    };
}
