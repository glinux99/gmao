<template>
    <div class="row">
        <div class="col-xl-6" v-for="(maintenance, index) in maintenances" :key="maintenance.id">
            <div class="card h-lg-100" :style="{
                background: `linear-gradient(112.14deg, ${getBackgroundColor(
                    index
                )} 0%, ${getDarkerColor(index)} 100%)`,
            }">


                <div class="card-body">
                    <div class="mb-6">
                        <h3 class="fs-2x fw-semibold text-white">
                            Maintenance ID: {{ index + 1 }}
                        </h3>
                        <span class="fw-semibold text-white opacity-75">{{
                            maintenance.description
                            }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-sm-8 pe-0 mb-5 mb-sm-0">
                            <div class="d-flex justify-content-between h-100 flex-column pt-xl-5 pb-xl-2 ps-xl-7">
                                <div class="mb-7">
                                    <div class="d-flex align-items-center flex-wrap d-grid gap-2">
                                        <div class="d-flex align-items-center me-5 me-xl-13">
                                            <div class="symbol symbol-30px symbol-circle me-3">
                                                <span class="symbol-label"
                                                    style="background: rgba(255, 255, 255, 0.15)">
                                                    <i class="ki-duotone ki-abstract-41 fs-4 text-white"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </span>
                                            </div>

                                            <div class="m-0">
                                                <span class="text-white text-opacity-75 fs-8">Date de début</span>
                                                <span class="fw-bold text-white fs-7 d-block">{{
                                                    formatDate(maintenance.start_date)
                                                    }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center me-5 me-xl-13">
                                            <div class="symbol symbol-30px symbol-circle me-3">
                                                <span class="symbol-label"
                                                    style="background: rgba(255, 255, 255, 0.15)">
                                                    <i class="ki-duotone ki-abstract-41 fs-4 text-white"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </span>
                                            </div>

                                            <div class="m-0">
                                                <span class="text-white text-opacity-75 fs-8">Heures de travail</span>
                                                <span class="fw-bold text-white fs-7 d-block">{{
                                                    maintenance.man_hours
                                                    }} heures</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-0">
                                        <span @click="viewMaintenance(maintenance.id)"
                                            class="btn btn-color-white bg-white bg-opacity-15 bg-hover-opacity-25 fw-semibold">
                                            Plus de details
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 pe-0 mb-5 mb-sm-0 ">
                            <div class="d-flex justify-content-between  h-100 flex-column pt-xl-5 pb-xl-2 ps-xl-7">
                                <div class="mb-7">
                                    <div class="mb-6 d-flex flex-column justity-content-center">
                                        <h3 class="fs-2x text-center fw-semibold text-white opacity-75 d-block">

                                            {{
                                            maintenance.expenses.reduce(
                      (total, expense) => total + (expense.amount || 0),
                      0
                    ).toFixed(2)
                                            }} $</h3>
                                        <span class="fw-bold text-white fs-7 d-block text-center">
                                            Budget estimatif
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useCookie } from '@vue-composable/cookie';
import { onMounted } from 'vue';
import useMaintenances from '../../services/maintenanceService';

const { getMaintenances, maintenances } = useMaintenances();

// Colors array for background gradients
const colors = [
    '#ff8a00', // Orange
    '#007bff', // Blue
    '#28a745', // Green
    '#dc3545', // Red
    '#6f42c1', // Indigo
    '#fd7e14', // Yellow
    '#17a2b8', // Cyan
    '#6c757d', // Gray
    '#e83e8c', // Pink
    '#343a40', // Dark
];

// Function to get a background color based on index
const getBackgroundColor = (index) => {
    return colors[index % colors.length];
};

// Function to get a darker shade of the background color
const getDarkerColor = (index) => {
    const color = getBackgroundColor(index);
    // Convert hex to RGB
    const hex = color.replace('#', '');
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    // Darken the color
    const darkenFactor = 0.8; // Adjust this value to change how much darker it gets
    const newR = Math.round(r * darkenFactor);
    const newG = Math.round(g * darkenFactor);
    const newB = Math.round(b * darkenFactor);

    // Convert back to hex
    const newHex = `#${((1 << 24) + (newR << 16) + (newG << 8) + newB)
        .toString(16)
        .slice(1)}`;
    return newHex;
};

// Function to format the date in French
const formatDate = (dateLocal) => {
    const date = new Date(dateLocal);
    return new Intl.DateTimeFormat('fr-FR', {
        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
    }).format(date);
};
// Function to calculate the total expenses
const calculateTotalExpenses = (expenses) => {
    if (!expenses || expenses.length === 0) {
        return '0';
    }
    let total = 0;
    for (const expense of expenses) {
        total += parseFloat(expense.montant);
    }
    return total.toFixed(2); // Format to 2 decimal places
};
const {setCookie}=useCookie('maintenanceId');
const viewMaintenance = (maintenanceId) => {
    window.location.href = `/repports/${maintenanceId}`;
    setCookie(maintenanceId);
}
// Lifecycle Hooks
onMounted(async () => {
    await getMaintenances();
});
const  theFormat=(number)=> {
            return number.toFixed(2);
        };
</script>
