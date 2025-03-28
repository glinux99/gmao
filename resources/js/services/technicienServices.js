// resources/js/services/technicienService.js
import { ref } from "vue";
import instance from "../api";

const API_URL = '/api/techniciens'; // Base URL for user-related API endpoints

export default function useTechniens() {
       const techniciens = ref([]);
       const errors = ref([]);
    const getTechniciens = async () => {
        try {
          const response = await instance.get(API_URL);
          // Filter users with 'technicien' role
        //   response.data.filter(user => user.roles.some(role => role.name === 'technicien'));
          techniciens.value=response.data.data;
          console.log(techniciens.value);
          console.log(techniciens);
        } catch (error) {
          console.error('Error fetching techniciens:', error);
          throw error; // Re-throw to handle it in the component
        }
      };

      const deleteTechnicien = async (technicienId) => {
        try {
          const response = await instance.delete(`${API_URL}/${technicienId}`);
          return response.data; // Or a success message if your API returns one
        } catch (error) {
          console.error('Error deleting technicien:', error);
          throw error;
        }
      };

      const storeTechnicien = async (technicienData) => {
          try {
            const response = await instance.post(API_URL, technicienData);
            return response.data;
          } catch (error) {
            console.error('Error adding technicien:', error);
            throw error;
          }
        };
        const storeImportUser=async(formData)=>{
            try {
                const response = await instance.post('/api/users/import', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
               // Handle success, e.g., show a success message
               errors.value=response.data.errors;
                console.log(response.data.message);
            } catch (error) {
                // Handle error, e.g., show an error message
                console.error("Error importing file:", error);
            }
        }
        return{
            storeTechnicien,
            getTechniciens,
            techniciens,
            deleteTechnicien,storeImportUser,errors
        }
}



