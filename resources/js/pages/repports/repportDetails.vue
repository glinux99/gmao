<template>
    <div id="content" class="login-page">
<apexchart
      width="500"
      type="bar"
      :options="chartOptions"
      :series="series"
    ></apexchart>
        <div v-if="isLoading" class="loading-overlay">
            <div class="loading-spinner">
                <span class="spinner-border text-white" role="status" aria-hidden="true"></span>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-warning border-2">
            <a href="https://energies.virunga.org/" target="_blank">
                <img alt="Logdo" src="/assets/media/logos/custom-1.png" class="h-lg-50px w-100" />
            </a>
            <span class="warn fw-bold fs-lg-3 mb-0 me-3 me-lg-5 text-uppercase">Rapport de maintenance -
                {{ maintenance.region ? maintenance.region.titre : "Goma2" }}</span>
            <a href="https://energies.virunga.org/" target="_blank">
                <img alt="Logdo" src="/assets/media/logos/custom-1.png" class="h-lg-50px w-100" />
            </a>
        </div>
        <div class="d-flex justify-content-between" id="exportPdf">
            <div>
                <Button severity="secondary">
                    <i class="ki-duotone ki-calendar fs-2 text-dark">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    {{ formatDate(Date.now()) }}
                </Button>
            </div>
            <div>
                <Button severity="success" id="exportPdf" @click="exportToPDF">
                    <i class="ki-duotone ki-file-down fs-2 text-white">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    Exporter en PDF
                </Button>
            </div>
        </div>
        <div class="d-flex justify-content-between d-none" id="exportPdf2">
            <div>
            </div>
            <div>
                <Button severity="secondary">
                    <i class="ki-duotone ki-calendar fs-2 text-dark">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    {{ formatDate(Date.now()) }}
                </Button>
            </div>
        </div>
        <div
            class="d-flex justify-content-between align-items-center mb-3 border-bottom border-warning border-2 rounded w-100 ">
            <div class="col-9">
                <div class="card me-5">
                    <div class="m-5">
                        <h3>Statistiques des équipes</h3>
                        <hr>
                    </div>
                    <Chart type="bar" :data="chartData" :options="chartOptions" class="barGph" />

                </div>
            </div>
            <!--begin::Col-->
            <div class="col-3">
                <!--begin::Card widget 3-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-50" style="
            background-color: #ff8a00;

          ">
                    <!--begin::Header-->
                    <div class="card-header pt-5 mb-3">
                        <!--begin::Icon-->
                        <div class="d-flex flex-center rounded-circle h-80px w-80px" style="
                border: 1px dashed rgba(255, 255, 255, 0.4);
                background-color: #11111183;
              ">
                            <i class="ki-duotone ki-bank text-white fs-2qx lh-0"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                    class="path5"></span><span class="path6"></span><span class="path7"></span><span
                                    class="path8"></span></i>
                        </div>
                        <!--end::Icon-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Card body-->
                    <div class="card-body w-100 d-flex align-items-end mb-3">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx text-white fw-bold me-6">
                                {{
                                    maintenance.expenses
                                        ? maintenance.expenses
                                            .reduce((total, expense) => total + (expense.amount || 0), 0)
                                            .toFixed(2)
                                        : 0
                                }}
                            </span>

                            <div class="fw-bold fs-6 text-white">
                                <span class="d-block">USD</span>
                            </div>
                        </div>

                        <!--end::Info-->

                    </div>
                    <div class="d-flex mx-5 flex-column">
                        <span class="text-white fw-bold">
                            - {{ totalTechnicians }} techniciens
                        </span>
                        <span class="text-white fw-bold">
                            - {{ totalTacherons }} tacherons
                        </span>
                    </div>

                    <!--end::Card body-->

                    <!--begin::Card footer-->
                    <div class="card-footer" style="
              border-top: 1px solid rgba(255, 255, 255, 0.3);
              background: rgba(0, 0, 0, 0.15);
            ">
                        <!--begin::Progress-->
                        <div class="fw-bold text-white py-2 d-flex flex-row align-items-center justify-content-center">
                            <span class="fs-1 me-4">{{
                                maintenance.tasks ? maintenance.tasks.length : 0
                                }}</span>
                            <span class="opacity-50">Tâches planifiées avec
                                {{ totalIntruction(maintenance) }} instructions</span>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card widget 3-->
            </div>
            <!--end::Col-->
        </div>
        <div class="d-flex justify-content-between">

            <!--begin::Col-->
            <div class="col-xl-12 w-100">
                <div class="card my-2">
                    <div class="m-5">
                        <h3>Déplacement des équipes </h3>
                        <hr>
                    </div>
                    <Chart type="bar" :data="chartData2" :options="chartOptions" class="barGph" />

                </div>
            </div>

        </div>

        <div class="card my-2">
            <div class="m-5">
                <h3>Liste des tâches</h3>
                <hr>
            </div>
            <Accordion :multiple="true" class="w-full">
                <AccordionTab v-for="item in accordionData" :key="item.id">
                    <template #header>
                        <MeterGroup :value="getMeterGroupValue(item)" />
                    </template>
                    <div v-if="item.materials && item.materials.length > 0">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="fw-bold">Matériels utilisés :</p>
                                <ul>
                                    <li v-for="material in item.materials" :key="material.id">
                                        {{ material.designation }} (Quantité: {{ material.quantity }})
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 d-flex flex-column">
                                <p class="fw-bold">
                                    <i class="ki-duotone ki-truck fs-2 me-2">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Vehicule:
                                </p>
                                <span class="d-flex align-items-center">
                                    <i class="ki-duotone ki-abstract-26 fs-2 me-2">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Designation: {{ item.engin ? item.engin.name: "" }}
                                </span>
                                <span class="d-flex align-items-center">
                                    <i class="ki-duotone ki-notepad-edit fs-2 me-2">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Immatriculation: {{ item.engin ? item.engin.matricule : "" }}
                                </span>
                                <span class="d-flex align-items-center" >
                                    <i class="ki-duotone ki-user-square fs-2 me-2">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span>
                                    </i>
                                    Chauffeur: {{ item.engin ? item.engin.chauffeur: "" }}
                                </span>
                                <span v-if="item.engin ? item.engin.engin_details && item.engin.engin_details.length > 0 : false"
                                    class="d-flex align-items-center">
                                    <i class="ki-duotone ki-fasten fs-2 me-2">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Kilométrage Début: {{ item.engin.engin_details[0].kilometrage_debut }} kmh
                                </span>
                                <span v-if="item.engin? item.engin.engin_details && item.engin.engin_details.length > 0 : false"
                                    class="d-flex align-items-center">
                                    <i class="ki-duotone ki-fasten fs-2 me-2">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    Kilométrage Fin: {{ item.engin.engin_details[0].kilometrage_fin }} kmh
                                </span>
                            </div>

                        </div>
                    </div>
                    <div v-else>
                        <p>Aucun matériel utilisé pour cette équipes.</p>
                    </div>
                    <div v-if="item.instructions && item.instructions.length > 0">
                        <p class="fw-bold">Instructions :</p>
                        <ol>
                            <li v-for="instruction in item.instructions" :key="instruction.id">
                                {{ instruction.description }}
                            </li>
                        </ol>
                    </div>
                    <div v-else>
                        <p>Aucune instruction pour cette tâche.</p>
                    </div>
                </AccordionTab>
            </Accordion>
        </div>
        <div class="card my-2">
            <div class="m-5">
                <h3>Documents Annexes</h3>
                <hr />
            </div>
            <div class="mx-5" v-if="
                maintenance &&
                maintenance.documents &&
                maintenance.documents.length > 0
            ">
                <ul>
                    <li v-for="doc in maintenance.documents" :key="doc.id"
                        class="d-flex align-items-center justify-content-between">
                        <div>
                            <a :href="getDocLink(doc.document.path)" target="_blank">{{
                                doc.document.title
                                }}</a>
                        </div>
                        <div>
                            <Button severity="warn" @click="printIndividualDocument(doc.document.path)">
                                <i class="ki-duotone ki-printer fs-2 text-white">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                Imprimer
                            </Button>
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else>
                <p class="ms-5">Aucun document annexe disponible.</p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useCookie } from "@vue-composable/cookie";
import html2canvas from "html2canvas";
import { jsPDF } from "jspdf";
import { computed, onMounted, ref } from "vue";
import useMaintenances from "../../services/maintenanceService";
const { setCookie, cookie } = useCookie("maintenanceId");
const { getMaintenance, maintenance } = useMaintenances();
const technicianTaskData = ref([]);
onMounted(async () => {
    const maintenanceId = cookie.value;

    if (maintenanceId) {
        await getMaintenance(maintenanceId);
    } else {
        window.location.href = "/repports";
    }
    console.log(maintenance);
    console.log(maintenanceId);
    chartData.value = setChartData();
    chartData2.value = setChartData2();
    chartOptions.value = setChartOptions();

    technicianTaskData.value = getTechnicianTaskData(maintenance.value);
    cdatachar2.value = getTechnicianTaskData2(maintenance.value);
    accordionData.value = formatAccordionData(maintenance.value);
    console.log(cdatachar2.value);

});
const getDocLink = (path) => {
    return `/${path}`;
};
const formatAccordionData = (maintenance) => {
    if (!maintenance || !maintenance.tasks) {
        return [];
    }
    const accordionData = [];
    for (const task of maintenance.tasks) {
        if (task.assigned_team) {
            accordionData.push({
                team_user: `${task.assigned_team.user.name ?? ""} ${task.assigned_team.user.post_name ?? ""}  ${task.assigned_team.user.nickname ?? ""}`,
                id: task.assigned_team.id,
                name: task.assigned_team.name,
                techniciansCount: task.assigned_team.users.length,
                tacheronsCount: task.nbre_tacherons,
                instructionsCount: task.instructions.length,
                instructions: task.instructions,
                materials: task.materials,
                engin: task.engin ?? null
            });
        } else if (task.assigned_user) {
            accordionData.push({
                team_user: `${task.assigned_user.name ?? ""} ${task.assigned_user.post_name ?? ""}  ${task.assigned_user.nickname ?? ""}`,
                id: task.assigned_user.id,
                name: task.assigned_user.name,
                techniciansCount: 1,
                tacheronsCount: task.nbre_tacherons,
                instructionsCount: task.instructions.length,
                instructions: task.instructions,
                materials: task.materials,
                engin: task.engin ?? null
            });
        }
    }
    return accordionData;
};
const printIndividualDocument = (docPath) => {
    const docLink = getDocLink(docPath);
    const printWindow = window.open(docLink, '_blank');
    printWindow.onload = () => {
        printWindow.print();
    };
};
const getAccordionHeader = (item) => {
    return `${item.name} (Techniciens: ${item.techniciansCount}, Tacherons: ${item.tacheronsCount}, Instructions: ${item.instructionsCount})`;
};
const accordionData = ref([]);
const cdatachar2 = ref(0);
const instructionsLabel = [];
const instructionsLabelN = [];
const chartData = ref();
const chartData2 = ref();
const chartOptions = ref();
const labels = [];
const getTechnicianTaskData = (maintenance) => {
    if (!maintenance || !maintenance.tasks) {
        return [];
    }

    const technicianTaskData = [];

    for (const task of maintenance.tasks) {
        let technicianName = null;

        if (task.assigned_user && task.assigned_user.name) {
            technicianName = task.assigned_user.name;
        } else if (task.assigned_team && task.assigned_team.user && task.assigned_team.user.name) {
            technicianName = task.assigned_team.user.name;
        }

        if (technicianName) {
            const instructionCount = task.instructions ? task.instructions.length : 0;
const instructionCountN = ref(0);

task.instructions.forEach((e) => {
  if (task.status == "completed") {
    instructionCountN.value = 0;
  } else {
    if (e.response_type === "checkbox") {
      if (e.value !== true || e.value !== "true") {
        instructionCountN.value += 1;
      }
    } else if (e.response_type === "text / valeur") {
      if (e.value === "" || e.value === null) {
        instructionCountN.value += 1;
      }
    }
  }
});
            // instructionCountN.value+=1;


            labels.push(technicianName);
            instructionsLabel.push(instructionCount);
            instructionsLabelN.push(instructionCountN.value);
            technicianTaskData.push({
                technicianName: technicianName,
                taskDescription: task.description,
                instructionCount: instructionCount
            });
        }
    }

    return technicianTaskData;
};
const formatDate = (dateLocal) => {
    const date = new Date(dateLocal);
    return new Intl.DateTimeFormat("fr-FR", {
        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
    }).format(date);
};
const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels: labels,
        datasets: [
            {
                label: "Total de tâches",
                backgroundColor: "#ff8a00",
                borderColor: documentStyle.getPropertyValue("--p-cyan-500"),
                data: instructionsLabel,
            },
            {
                label: "Tâches non realisées",
                backgroundColor: documentStyle.getPropertyValue("--p-gray-500"),
                borderColor: documentStyle.getPropertyValue("--p-gray-500"),
                data: instructionsLabelN,
            },
        ],
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--p-text-color");
    const textColorSecondary = documentStyle.getPropertyValue("--p-text-muted-color");
    const surfaceBorder = documentStyle.getPropertyValue("--p-content-border-color");

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            legend: {
                labels: {
                    color: textColor,
                },
            },
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                    font: {
                        weight: 500,
                    },
                },
                grid: {
                    display: false,
                    drawBorder: false,
                },
            },
            y: {
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: surfaceBorder,
                    drawBorder: false,
                },
            },
        },
    };
};

const totalIntruction = (maintenanceData) => {
    if (!maintenanceData || !maintenanceData.tasks) {
        return 0; // Return 0 if maintenanceData or tasks are not available
    }

    let total = 0;
    for (const task of maintenanceData.tasks) {
        if (task.instructions) {
            total += task.instructions.length;
        }
    }
    return total;
};
const getTechnicianTaskData2 = (maintenance) => {
    if (!maintenance || !maintenance.tasks) {
        return [];
    }

    const chartData = [];

    for (const task of maintenance.tasks) {
        let label = null;
        let kilometrageDebut = null;
        let kilometrageFin = null;

        // Determine the label (engin, user, or team leader)
        if (task.engin && task.engin.name) {
            label = task.engin.name;
            // Get the latest kilometrage
            if (task.engin.engin_details && task.engin.engin_details.length > 0) {
                const latestDetails = task.engin.engin_details[0];
                kilometrageDebut = latestDetails.kilometrage_debut;
                kilometrageFin = latestDetails.kilometrage_fin;
            }
        } else if (task.assigned_user && task.assigned_user.name) {
            // label = task.assigned_user.name;
        } else if (task.assigned_team && task.assigned_team.user && task.assigned_team.user.name) {
            // label = task.assigned_team.user.name;
        }

        if (label) {
            chartData.push({
                label: label,
                kilometrageDebut: kilometrageDebut,
                kilometrageFin: kilometrageFin,
                average: 30, // Fixed average value
            });
        }
    }

    return chartData;
};

const setChartData2 = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const taskData = getTechnicianTaskData2(maintenance.value);

    const labels = taskData.map((item) => item.label);
    const kilometrageData = taskData.map((item) => item.kilometrageFin - item.kilometrageDebut);
    const kilometrageEcartMoyenne = taskData.map((item) => (item.kilometrageFin - item.kilometrageDebut) - item.average);
    const kilometrageFinData = taskData.map((item) => item.kilometrageFin);
    const averageData = taskData.map((item) => item.average);

    return {
        labels: labels,
        datasets: [
            {
                type: 'line',
                label: 'Moyenne (3Okmh)',
                borderColor: documentStyle.getPropertyValue('--p-orange-500'),
                borderWidth: 2,
                fill: false,
                tension: 0.4,
                data: averageData
            },
            {
                label: "Ecart Kilométrage",
                backgroundColor: "#ff8a00",
                borderColor: documentStyle.getPropertyValue("--p-cyan-500"),
                data: kilometrageData,
            },
        ],
    };
};
const getMeterGroupValue = (item) => {
    return [
        {
            label: `${item.name} (${item.team_user})`,
            value: (item.tacheronsCount + item.techniciansCount + item.instructionsCount),
            color: "#ff8a00",
            icon: "pi pi-users", // Icon for team/user name
        },
        {
            label: `Techniciens: ${item.techniciansCount}`,
            value: item.techniciansCount,
            color: "#695640FF",
            icon: "pi pi-user", // Icon for technicians
        },
        {
            label: `Tacherons: ${item.tacheronsCount}`,
            value: item.tacheronsCount,
            color: "#59AD32FF",
            icon: "pi pi-briefcase", // Icon for tacherons
        },
        {
            label: `Instructions: ${item.instructionsCount}`,
            value: item.instructionsCount,
            color: "#DA1F12FF",
            icon: "pi pi-list", // Icon for instructions
        },
    ];
};
const totalTacherons = computed(() => {
    if (!maintenance.value || !maintenance.value.tasks) {
        return 0;
    }
    let tacherons = 0;
    for (const task of maintenance.value.tasks) {
        if (task.assigned_team) {
            tacherons += task.nbre_tacherons || 0;
        } else if (task.assigned_user) {
            tacherons += task.nbre_tacherons || 0
        }
    }
    return tacherons;
});

const totalTechnicians = computed(() => {
    if (!maintenance.value || !maintenance.value.tasks) {
        return 0;
    }
    let technicians = 0;
    for (const task of maintenance.value.tasks) {
        if (task.assigned_team) {
            technicians += task.assigned_team.users.length || 0;
        } else if (task.assigned_user) {
            technicians += 1;
        }
    }
    return technicians;
});
const isLoading = ref(false);
const exportToPDF = () => {
    isLoading.value = true;
    document.getElementById('exportPdf').style.display = 'none';
    document.getElementById('exportPdf2').style.display = 'block';
    const content = document.getElementById("content");
    if (!content) {
        isLoading.value = false;
        return;
    };

    html2canvas(content, { scale: 2 }).then((canvas) => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF("p", "mm", "a4");
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
        pdf.save("rapport_maintenance.pdf");
    }).finally(() => {
        isLoading.value = false; // Hide loading overlay
    });
    document.getElementById('exportPdf').style.display = 'block';
    document.getElementById('exportPdf2').style.display = 'none';
    isLoading.value = false;
};
</script>
<style scoped>
.warn {
    color: #ff8a00 !important;
}

.border-warning {
    border-color: #ff8a00 !important;
}

.barGph {
    min-height: 20rem;
}

.login-page {
    position: relative;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent black background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    /* Ensure it's on top */
}

.loading-spinner {
    /* Add any styling for the spinner container if needed */
}
</style>
