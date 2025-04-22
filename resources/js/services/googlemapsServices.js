// resources/js/services/googlemapsservices.js
import { ref } from 'vue';
import instance from '../api/index';

export default function useGoogleMaps() {
    const locations = ref([]);
    const errors = ref({});
    const isLoading = ref(false);

    const getLocations = async () => {
        errors.value = {};
        isLoading.value = true;
        try {
            const response = await instance.get('/api/googlemaps'); // Replace '/api/locations' with your actual API endpoint
            locations.value = response.data.data; // Assuming the API returns an array of locations in the 'data' field
        } catch (e) {
            errors.value = e.response.data.errors;
        } finally {
            isLoading.value = false;
        }
    };

    const storeImport=async(data, config)=>{
        try{
            const res= await instance.post('/api/googlemaps/import',data,config
            )
            locations.value = res.data.data;

        }catch(e){
                console.log(e.message);
        }

    }
    // You can add more functions here if you need to fetch a single location,
    // store a new location, update an existing one, or delete a location.

    return {
        storeImport,
        locations,
        errors,
        isLoading,
        getLocations,
    };
}
