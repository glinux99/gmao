<template>
    <div id="contentVue">
      <div class="container-xxl" id="kt_content_container" data-select2-id="select2-data-kt_content_container">
        <div class="row g-5 g-xl-8">
          <BudgetWidget v-if="!isTechnician" :budget="maintenanceBuget" />
          <TechniciansWidget :count="techniciens" />
          <MovementsWidget :count="mouvements" />
        </div>
        <div v-if="canViewTasksGraph">
          <div class="card mb-3">
            <div class="card-header border-0 pt-5">
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Taches</span>
                <span class="text-muted mt-1 fw-bold fs-7">Informations sur les taches en cours</span>
              </h3>
            </div>
            <task-chart />
          </div>
        </div>
        <RecentMovementsTable :months="months" :weeks="weeks" :days="days" />
      </div>
    </div>
  </template>

  <script>
  import TaskChart from '../../components/charts/taskChart.vue';
import BudgetWidget from './BudgetWidget.vue';
import MovementsWidget from './MovementsWidget.vue';
import RecentMovementsTable from './RecentMovementsTable.vue';
import TechniciansWidget from './TechniciansWidget.vue';

  export default {
    components: {
      BudgetWidget,
      TechniciansWidget,
      MovementsWidget,
      RecentMovementsTable,
      TaskChart
    },
    props: {
      maintenanceBuget: {
        type: Number,
        required: true,
      },
      techniciens: {
        type: Number,
        required: true,
      },
      mouvements: {
        type: Number,
        required: true,
      },
      months: {
        type: Array,
        required: true,
      },
      weeks: {
        type: Array,
        required: true,
      },
      days: {
        type: Array,
        required: true,
      },
      isTechnician: {
        type: Boolean,
        required: true,
      },
      canViewTasksGraph: {
        type: Boolean,
        required: true,
      },
    },
  };
  </script>
