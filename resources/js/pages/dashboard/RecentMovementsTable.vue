<template>
    <div class="row g-5 g-xl-8">
      <div class="col-xl-12">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
          <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bolder fs-3 mb-1">Derniers mouvements</span>
              <span class="text-muted mt-1 fw-bold fs-7">Materiels</span>
            </h3>
            <div class="card-toolbar">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark active fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_1" @click="activeTab = 'monthly'">Mensuel</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_2" @click="activeTab = 'weekly'">Semaine</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4" data-bs-toggle="tab" href="#kt_table_widget_5_tab_3" @click="activeTab = 'daily'">Journaliere</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-body py-3">
            <div class="tab-content">
              <div class="tab-pane fade show active" id="kt_table_widget_5_tab_1" v-if="activeTab === 'monthly'">
                <div class="table-responsive">
                  <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <thead>
                      <tr class="border-0">
                        <th class="p-0 w-50px"></th>
                        <th class="p-0 min-w-150px"></th>
                        <th class="p-0 min-w-140px"></th>
                        <th class="p-0 min-w-110px"></th>
                        <th class="p-0 min-w-50px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="month in months" :key="month.id">
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img :src="month.category.avatar || '/assets/media/svg/brand-logos/plurk.svg'" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{ month.category.designation }}</a>
                          <span class="text-muted fw-bold d-block">{{ month.demandeur.name }}</span>
                        </td>
                        <td class="text-end text-muted fw-bold">
                          {{ month.quantity }} {{ month.category.unity ? month.category.unity.designation : '' }}
                        </td>
                        <td class="text-end">
                          <span class="badge badge-light-success">{{ month.etat }}</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="kt_table_widget_5_tab_2" v-if="activeTab === 'weekly'">
                <div class="table-responsive">
                  <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <thead>
                      <tr class="border-0">
                        <th class="p-0 w-50px"></th>
                        <th class="p-0 min-w-150px"></th>
                        <th class="p-0 min-w-140px"></th>
                        <th class="p-0 min-w-110px"></th>
                        <th class="p-0 min-w-50px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="month in weeks" :key="month.id">
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img :src="month.category.avatar || '/assets/media/svg/brand-logos/plurk.svg'" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{ month.category.designation }}</a>
                          <span class="text-muted fw-bold d-block">{{ month.demandeur.name }}</span>
                        </td>
                        <td class="text-end text-muted fw-bold">
                          {{ month.quantity }} {{ month.category.unity ? month.category.unity.designation : '' }}
                        </td>
                        <td class="text-end">
                          <span class="badge badge-light-success">{{ month.etat }}</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="kt_table_widget_5_tab_3" v-if="activeTab === 'daily'">
                <div class="table-responsive">
                  <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <thead>
                      <tr class="border-0">
                        <th class="p-0 w-50px"></th>
                        <th class="p-0 min-w-150px"></th>
                        <th class="p-0 min-w-140px"></th>
                        <th class="p-0 min-w-110px"></th>
                        <th class="p-0 min-w-50px"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="month in days" :key="month.id">
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img :src="month.category.avatar || '/assets/media/svg/brand-logos/plurk.svg'" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{ month.category.designation }}</a>
                          <span class="text-muted fw-bold d-block">{{ month.demandeur.name }}</span>
                        </td>
                        <td class="text-end text-muted fw-bold">
                          {{ month.quantity }} {{ month.category.unity ? month.category.unity.designation : '' }}
                        </td>
                        <td class="text-end">
                          <span class="badge badge-light-success">{{ month.etat }}</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
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
    },
    data() {
      return {
        activeTab: 'monthly',
      };
    },
  };
  </script>
