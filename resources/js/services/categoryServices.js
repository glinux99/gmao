import { ref } from 'vue';
import instance from '../api/index';

export default function useCategories() {
    const categories = ref([]);
    const errors = ref({});
    const isLoading = ref(false);

    const getCategories = async () => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.get('/api/categories');
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
            const response = await instance.post('/api/categories', data);
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
            const response = await instance.put(`/api/categories/${id}`, data);
            // const index = categories.value.findIndex((t) => t.id === id);
            // if (index !== -1) {
            //     categories.value[index] = response.data.data;
            // }
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
            await instance.delete(`/api/categories/${id}`);
            categories.value = categories.value.filter((task) => task.id !== id);
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const importCategories = async (data) => {
        errors.value = {};
        isLoading.value = true;
        try {
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data', // Add this header
                },
            };
            const response = await instance.post('/api/categories/import', data, config);
            // categories.value = response.data.data; // You might want to refresh the categories list after import

        } catch (e) {
            errors.value = e.response.data.errors;
            console.log("errors.value");
            console.log(errors.value);
        } finally {
            isLoading.value = false;
        }
    };

    return {
        importCategories,
        categories,
        errors,
        isLoading,
        getCategories,
        storeCategory,
        updateCategory,
        destroyCategory,
    };
}
