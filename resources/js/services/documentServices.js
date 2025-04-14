// documentServices.js
import { ref } from 'vue';
import instance from '../api';

const API_URL = '/api/documents'; // Define your API endpoint

const useDocuments = () => {
    const documents = ref([]);
    const document = ref({});
    const errors = ref({});
    const isLoading = ref(false);

    const getDocuments = async () => {
        isLoading.value = true;
        try {
            const response = await instance.get(API_URL);
            documents.value = response.data.data.map(doc => ({
                ...doc,
                viewLink: `/storage/${doc.path}`, // Assuming path is relative to storage
                taskCount: doc.tasks ? doc.tasks.length : 0,
                maintenanceCount: doc.maintenances ? doc.maintenances.length : 0,
            }));
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const getDocument = async (id) => {
        isLoading.value = true;
        try {
            const response = await instance.get(`${API_URL}/${id}`);
            document.value = response.data.data;
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeDocument = async (data, config = {}) => {
        try {
            const response = await instance.post(API_URL, data, config);
            return response.data;
        } catch (error) {
            console.error('Error storing document:', error);
            return false;
        }
    };
    const associateDocument = async (data, config = {}) => {
        try {
            const response = await instance.post('/api/document_maintenance_task', data, config);
            return response.data;
        } catch (error) {
            console.error('Error storing document:', error);
            return false;
        }
    };
    const uploadDocument = async (data, config = {}) => {
        try {
            const response = await instance.post(`${API_URL}/upload`, data, config);
            return response.data;
        } catch (error) {
            console.error('Error uploading document:', error);
            return false;
        }
    };

    const updateDocument = async (id, data, config = {}) => {
        try {
            const response = await instance.post(`${API_URL}/${id}`, data, config);
            return response.data;
        } catch (error) {
            console.error('Error updating document:', error);
            return false;
        }
    };

    const deleteDocument = async (id) => {
        try {
            await instance.delete(`${API_URL}/${id}`);
        } catch (e) {
            errors.value = e.response.data.errors;
        }
    };

    return {
        documents,
        document,
        errors,
        isLoading,
        getDocuments,
        getDocument,
        storeDocument,
        updateDocument,
        deleteDocument,
        uploadDocument,
        associateDocument
    };
};

export default useDocuments;
