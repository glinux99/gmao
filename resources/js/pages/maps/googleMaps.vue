<script setup>
import { computed, onMounted, ref } from 'vue';
import { GoogleMap, InfoWindow, Marker } from 'vue3-google-map';
import useGoogleMaps from '../../services/googlemapsServices';

// Default center (if user's location is not available)
const defaultCenter = { lat: 40.689247, lng: -74.044502 };
const center = ref(defaultCenter);
const zoom = ref(15);

// const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY; // Get API key from environment variable
const apiKey = "AIzaSyCPPmoxPIKE2Kdtjz1OeTjV3FdFfc1R7Ak"; // Get API key from environment variable
const error = ref(null);
const directionsResponse = ref(null);
const handleFileChange = (event) => {
    const file = event.target.files[0];
    selectedFileName.value = file ? file.name : null;
};
const selectedFileName = ref(null);
const uploadProgress = ref(0);
const importMapsPointServer = async () => {
    const file = fileInput.value.files[0];
    const formDataFile = new FormData();
    formDataFile.append("file", file);
    try {
        uploadProgress.value = 0;
        const config = {
            onUploadProgress: (progressEvent) => {
                const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                uploadProgress.value = percentCompleted;
            },
        };
        await storeImport(formDataFile, config);
        selectedFileName.value = null;
        uploadProgress.value = 0;
        window.location.href = "/googlemaps";
        await getLocations();
    } catch (error) {

    }
}
const fileInput = ref(null);
const openFileDialog = () => {
    fileInput.value.click();
};
// Array of coordinates for the markers
const markerCoordinates = ref([]);
const selectedMarker = ref(null);
const infoWindowOptions = ref({
    pixelOffset: { width: 0, height: -35 },
});
const infoWindowPosition = ref(null);
const infoWindowContent = ref('');
// Function to calculate distance between two coordinates
function calculateDistance(coord1, coord2) {
    const R = 6371e3; // Earth's radius in meters
    const lat1 = coord1.lat * Math.PI / 180;
    const lat2 = coord2.lat * Math.PI / 180;
    const deltaLat = (coord2.lat - coord1.lat) * Math.PI / 180;
    const deltaLng = (coord2.lng - coord1.lng) * Math.PI / 180;

    const a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
        Math.cos(lat1) * Math.cos(lat2) *
        Math.sin(deltaLng / 2) * Math.sin(deltaLng / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return R * c; // Distance in meters
}

// Computed property to find the nearest marker
const nearestMarker = computed(() => {
    if (!center.value || center.value === defaultCenter) return null;

    let minDistance = Infinity;
    let nearest = null;

    for (const coord of markerCoordinates.value) {
        const distance = calculateDistance(center.value, coord);
        if (distance < minDistance) {
            minDistance = distance;
            nearest = coord;
        }
    }
    return nearest;
});
const { getLocations, locations, storeImport } = useGoogleMaps();
const handleMarkerClick = (marker, location) => {

    selectedMarker.value = location;
    infoWindowPosition.value = {
        lat: location.latitude,
        lng: location.longitude,
    };
    infoWindowContent.value = `
        <div>
            <h6>Client: ${location.clientName}</h6>
            <hr>
            <p>Ve-cli: ${location.ve}</p>
            <p>phone: ${location.phone}</p>
            <p>Zone: ${location.zone}</p>
        </div>
    `;
};
const handleInfoWindowClose = () => {
    selectedMarker.value = null;
    infoWindowPosition.value = null;
};
onMounted(async () => {
    await getLocations();
    locations.value.forEach((e) => {
        markerCoordinates.value.push(
            { lat: e.latitude, lng: e.longitude, clientName: `${e.last_name} ${e.first_name}`, zone: e.zone, ve: e.client_number, phone:e.phone }
        );
    });
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                center.value = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                zoom.value = 15; // Adjust zoom level as needed

                // Calculate directions to the nearest marker
                if (nearestMarker.value) {
                    //   const directionsService = new google.maps.DirectionsService();
                    //   directionsService.route(
                    //     {
                    //       origin: center.value,
                    //       destination: nearestMarker.value,
                    //       travelMode: google.maps.TravelMode.DRIVING, // You can change this to WALKING, BICYCLING, etc.
                    //     },
                    //     (response, status) => {
                    //       if (status === 'OK') {
                    //         directionsResponse.value = response;
                    //       } else {
                    //         error.value = 'Directions request failed due to ' + status;
                    //         console.error(error.value);
                    //       }
                    //     }
                    //   );
                }
            },
            (err) => {
                error.value = 'Error getting location: ' + err.message;
                console.error(error.value);
            }
        );
    } else {
        error.value = 'Geolocation is not supported by this browser.';
        console.error(error.value);
    }
});
</script>

<template>
    <div v-if="uploadProgress > 0" class="col-md-12 mt-3">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                :style="{ width: `${uploadProgress}%` }" :aria-valuenow="uploadProgress" aria-valuemin="0"
                aria-valuemax="100">
                {{ uploadProgress.toFixed(0) ?? 0 }}%
            </div>
        </div>
    </div>
    <div v-if="selectedFileName" class="mb-3">
        <div class="d-flex align-items-center">
            <i class="pi pi-file me-2"></i>
            <span class="text-muted fs-8">
                Fichier sélectionné : {{ selectedFileName }}
            </span>
        </div>
    </div>
    <div class="d-flex justify-content-end">

        <div class="text-end pb-4">
            <Button icon="pi pi-external-link" severity="warn" label="Export" @click="exportCSV($event)" />
        </div>
        <div class="mx-1">
            <Button v-if="!selectedFileName" label="Importer xls" icon="pi pi-upload" @click="openFileDialog" />
            <Button v-else label="Importer vers le server" class="p-button-primary ms-3" icon="pi pi-upload"
                @click="importMapsPointServer" />
            <input type="file" class="d-none" name="file" ref="fileInput" @change="handleFileChange" />
        </div>
    </div>
    <div v-if="error" class="error-message">
        {{ error }}
    </div>
    <GoogleMap v-else mapTypeId="satellite" :api-key="apiKey" style="width: 100%; height: 500px" :center="center"
        :zoom="zoom">
        <!-- Single marker for the center -->
        <Marker :options="{ position: center }" />

        <!-- Multiple markers from the array -->
        <Marker v-for="(coord, index) in markerCoordinates" :key="index" :options="{ position: coord }"
            @click="handleMarkerClick($event, coord)" >
        <InfoWindow v-if="infoWindowPosition" :position="infoWindowPosition" :options="infoWindowOptions"
            @close="handleInfoWindowClose">
            <div v-html="infoWindowContent"></div>
        </InfoWindow>
        </Marker>
        <!-- Directions Renderer -->
        <!-- <DirectionsRenderer v-if="directionsResponse" :options="{ directions: directionsResponse }" /> -->
    </GoogleMap>
</template>

<style scoped>
.error-message {
    color: red;
    padding: 10px;
    border: 1px solid red;
    margin-bottom: 10px;
}
</style>
