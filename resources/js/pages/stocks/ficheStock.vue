<template>
  <div>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
          <div
            id="kt_app_toolbar_container"
            class="app-container container-xxl d-flex flex-stack"
          >
            <div
              class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
            >
              <h1
                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"
              >
                Fiche de stocks
              </h1>
            </div>
          </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div
            id="kt_app_content_container"
            class="app-container container-xxl"
          >
            <div class="card">
              <div class="card-header border-0 pt-6">
                <div class="card-title">
                  <div class="d-flex align-items-center position-relative my-1">
                    <i
                      class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    <input
                      type="text"
                      data-kt-user-table-filter="search"
                      :class="`form-control form-control-solid w-250px  ps-13 ${disable}`"
                      :placeholder="`chercher dans l'historiques`"
                    />
                    <input
                      type="text"
                      v-model="search"
                      data-kt-user-table-filter="search"
                      :class="`form-control form-control-solid v-auto  ps-13 ${
                        disable == 'd-none' ? ' ' : 'd-none'
                      }`"
                      :placeholder="`chercher dans l'historiques`"
                    />
                  </div>
                </div>

                <div :class="`card-toolbar `">
                  <div
                    class="d-flex flex-stack flex-wrap gap-4"
                    data-kt-user-table-toolbar="base"
                  >
                    <div data-kt-user-table-filter="form" :class="`${disable}`">
                      <div class="d-flex align-items-center fw-bold">
                        <div class="text-muted fs-7 me-2">Filter</div>
                        <select
                          id="SelectClick"
                          class="form-select form-select-solid fw-bold"
                          data-kt-select2="true"
                          data-placeholder="type de mouvement"
                          data-allow-clear="true"
                          data-dropdown-css-class="w-230px"
                          data-kt-user-table-filter="entreprise"
                          data-hide-search="true"
                        >
                          <option></option>
                          <option value="resetFilter">afficher tout</option>
                          <option value="entree">
                            Approvissionnement &nbsp;&nbsp;&nbsp;&nbsp;
                          </option>
                          <option value="sortie">
                            Destockage &nbsp;&nbsp;&nbsp;&nbsp;
                          </option>
                        </select>
                      </div>

                      <div :class="`d-flex justify-content-end d-none`">
                        <button
                          id="resetFilter"
                          type="reset"
                          class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                          data-kt-menu-dismiss="true"
                          data-kt-user-table-filter="reset"
                        >
                          Reinitialiser
                        </button>
                        <button
                          id="filterValue"
                          type="submit"
                          class="btn btn-primary fw-semibold px-6"
                          data-kt-menu-dismiss="true"
                          data-kt-user-table-filter="filter"
                        >
                          Appliquer
                        </button>
                      </div>
                    </div>

                    <!-- code apres -->
                    <div
                      @click="alertBtn"
                      :class="`btn btn-light btn-sm ${disable}`"
                    >
                      Effectuer un mouvement
                    </div>
                  </div>

                  <div
                    :class="`d-flex justify-content-end align-items-center ${
                      disable == 'd-none' ? ' ' : 'd-none'
                    }`"
                    data-kt-user-table-toolbar="selected"
                  >
                    <button
                      type="button"
                      class="btn btn-danger"
                      data-kt-user-table-select="delete_selected"
                    >
                      Supprimer la selection
                    </button>
                  </div>

                  <div
                    class="modal fade"
                    id="kt_modal_export_users"
                    tabindex="-1"
                    aria-hidden="true"
                  >
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h2 class="fw-bold">Export Users</h2>

                          <div
                            class="btn btn-icon btn-sm btn-active-icon-primary"
                            data-kt-users-modal-action="close"
                          >
                            <i class="ki-duotone ki-cross fs-1"
                              ><span class="path1"></span
                              ><span class="path2"></span
                            ></i>
                          </div>
                        </div>

                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                          <form
                            id="kt_modal_export_users_form"
                            class="form"
                            action="#"
                          >
                            <div class="fv-row mb-10">
                              <label class="fs-6 fw-semibold form-label mb-2"
                                >Select Role:</label
                              >

                              <select
                                name="entreprise"
                                data-control="select2"
                                data-placeholder="Selectionner une entreprise"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              >
                                <option></option>

                                <option value="entrprise">"entrprise"</option>
                              </select>
                            </div>

                            <div class="fv-row mb-10">
                              <label
                                class="required fs-6 fw-semibold form-label mb-2"
                                >Select Export Format:</label
                              >

                              <select
                                name="format"
                                data-control="select2"
                                data-placeholder="Select a format"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              >
                                <option></option>
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                                <option value="cvs">CVS</option>
                                <option value="zip">ZIP</option>
                              </select>
                            </div>

                            <div class="text-center">
                              <button
                                type="reset"
                                class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel"
                              >
                                Annuler
                              </button>

                              <button
                                type="submit"
                                class="btn btn-primary"
                                data-kt-users-modal-action="submit"
                              >
                                <span class="indicator-label"> Envoyer </span>

                                <span class="indicator-progress">
                                  Svp patienter
                                  <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"
                                  ></span>
                                </span>
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body py-4">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5 text-center"
                  id="kt_table_users"
                >
                  <thead>
                    <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                      <th class="min-w-180px">Item</th>
                      <!-- <th :class="`text-end pe-3 min-w-100px ${disable}`">Product ID</th> -->
                      <!-- <th :class="`text-end pe-3 min-w-150px ${disable}`">Date d'exp</th> -->
                      <th :class="` pe-3 min-w-100px ${disable}`">Mouvement</th>
                      <th :class="`pe-3 min-w-100px ${disable}`">Motif</th>
                      <th :class="`d-none pe-3 min-w-100px ${disable}`">
                        Entreprise
                      </th>
                      <th :class="`text-end pe-3 min-w-100px ${disable}`">
                        Dépots
                      </th>
                      <th :class="`text-end pe-0 min-w-75px ${disable}`">
                        Qte ajoutee
                      </th>
                      <th :class="`text-end pe-0 min-w-75px ${disable} `">
                        Qte totale
                      </th>
                    </tr>
                  </thead>

                  <tbody class="fw-bold text-gray-600">
                    <template
                      v-for="product in stockServices"
                      :key="product.id"
                    >
                      <tr>
                        <td class="d-flex">
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid me-3"
                          >
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value="1"
                            />
                          </div>
                          <span class="text-dark text-hover-primary">{{
                            product.service_name
                          }}</span>
                        </td>

                        <!-- <td :class="`text-end ${disable}`">
                          {{
                            product.service.codebar ||
                            product.service.code_manuel ||
                            product.service.uom_id ||
                            product.service.id
                          }}
                        </td> -->

                        <!-- <td :class="`text-end ${disable}`">
                          {{ "jamais" }}
                        </td> -->

                        <td :class="`text-center ${disable}`">
                          <!-- {{ product.price }} -->

                          <span
                            :class="
                              product.type == 'entry'
                                ? 'badge py-3 px-4 fs-7 badge-light-primary'
                                : 'badge py-3 px-4 fs-7 badge-light-danger'
                            "
                          >
                            {{
                              product.type == "entry" ? "entree" : "sortie"
                            }}</span
                          >
                        </td>

                        <td :class="`text-center ${disable}`">
                          {{
                            product.type == "entry"
                              ? product.motif ?? "approvisionnement"
                              : product.motif ?? "destockage"
                          }}
                        </td>
                        <td :class="`d-none text-center ${disable}`">
                          <!-- {{ product.enterprise.name }} -->
                        </td>
                        <td :class="`text-center ${disable}`">
                          {{ product.deposit_name }}
                        </td>
                        <td :class="`text-center ${disable}`" data-order="58">
                          <span class="text-dark fw-bold">
                            {{ product.quantity || 0 }} {{ product.uom_symbol }}
                          </span>
                        </td>
                        <td :class="`text-center ${disable}`" data-order="58">
                          <span class="text-dark fw-bold">
                            <span
                              :class="
                                product.quantity + product.quantity_before > 0
                                  ? 'badge py-3 px-4 fs-7 badge-light-primary'
                                  : 'badge py-3 px-4 fs-7 badge-light-danger'
                              "
                            >
                              {{
                                product.total ??
                                product.quantity + product.quantity_before
                              }}
                              {{ product.uom_symbol }}</span
                            >
                          </span>
                        </td>
                      </tr>
                    </template>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <modal-component
      positionModal="center mw-900px "
      :form="form"
      :id="'stock-modal'"
      activeBtn="false"
      :formInput="'ok'"
      @cancel-btn="cancelBtnU"
    >
      <template #title
        >Effectuer un mouvement /
        {{
          form.type == "entry" ? "Approvisionnement" : "Destockage"
        }}</template
      >
      <template #body>
        <form
          method="POST"
          @submit.prevent="updateServiceStock(form.service_id, form.deposit_id)"
        >
          <div
            class="max-h-250px stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
            id="stepper_super_admin"
          >
            <div
              class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px"
            >
              <div class="stepper-nav ps-lg-10">
                <div class="stepper-item current" data-kt-stepper-element="nav">
                  <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                      <i class="ki-duotone ki-check stepper-check fs-2"></i>
                      <span class="stepper-number">1</span>
                    </div>

                    <div class="stepper-label">
                      <h3 class="stepper-title">Service</h3>

                      <div class="stepper-desc">rechercher le service</div>
                    </div>
                  </div>

                  <div class="stepper-line h-40px"></div>
                </div>

                <div
                  class="stepper-item mark-completed"
                  data-kt-stepper-element="nav"
                >
                  <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                      <i class="ki-duotone ki-check stepper-check fs-2"></i>
                      <span class="stepper-number">2</span>
                    </div>

                    <div class="stepper-label">
                      <h3 class="stepper-title">Mouvement</h3>

                      <div class="stepper-desc">Donnees du mouvement</div>
                    </div>
                  </div>

                  <div class="stepper-line h-40px"></div>
                </div>

                <div class="stepper-item" data-kt-stepper-element="nav">
                  <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                      <i class="ki-duotone ki-check stepper-check fs-2"></i>
                      <span class="stepper-number">3</span>
                    </div>

                    <div class="stepper-label">
                      <h3 class="stepper-title">Complet</h3>

                      <div class="stepper-desc">Donnee envoyer</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex-row-fluid py-lg-5 px-lg-15">
              <form
                class="form"
                novalidate="novalidate"
                id="kt_modal_create_app_form"
              >
                <div class="current" data-kt-stepper-element="content">
                  <div class="w-100">
                    <div class="card">
                      <div
                        class="d-flex align-items-center position-relative my-1"
                      >
                        <i
                          class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                          ><span class="path1"></span><span class="path2"></span
                        ></i>
                        <input
                          type="text"
                          id="myInput"
                          v-model="search"
                          :class="`ps-13 form-control form-control-lg form-control-solid`"
                          :placeholder="`chercher dans les ${services.length} services `"
                        />
                      </div>
                      <div :class="`card-toolbar d-none `">
                        <div
                          class="d-flex flex-stack flex-wrap gap-4"
                          data-kt-user-table-toolbar="base"
                        >
                          <div
                            data-kt-user-table-filter="form"
                            :class="`${disable}`"
                          >
                            <div class="d-flex align-items-center fw-bold">
                              <div class="text-muted fs-7 me-2">Filter</div>
                              <select
                                id="SelectClickx"
                                class="form-select form-select-solid fw-bold"
                                data-kt-select2="true"
                                data-placeholder="type de mouvement"
                                data-allow-clear="true"
                                data-dropdown-css-class="w-230px"
                                data-kt-user-table-filter="entreprise"
                                data-hide-search="true"
                              >
                                <option></option>
                                <option value="resetFilter">
                                  afficher tout
                                </option>
                                <option value="entry">
                                  Approvissionnement
                                </option>
                                <option value="withdraw">Destockage</option>
                              </select>
                            </div>

                            <div :class="`d-flex justify-content-end d-none`">
                              <button
                                id="resetFilter"
                                type="reset"
                                class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                data-kt-menu-dismiss="true"
                                data-kt-user-table-filter="reset"
                              >
                                Reinitialiser
                              </button>
                              <button
                                id="filterValue"
                                type="submit"
                                class="btn btn-primary fw-semibold px-6"
                                data-kt-menu-dismiss="true"
                                data-kt-user-table-filter="filter"
                              >
                                Appliquer
                              </button>
                            </div>
                          </div>
                        </div>

                        <div
                          :class="`d-flex justify-content-end align-items-center ${
                            disable == 'd-none' ? ' ' : 'd-none'
                          }`"
                          data-kt-user-table-toolbar="selected"
                        >
                          <button
                            type="button"
                            class="btn btn-danger"
                            data-kt-user-table-select="delete_selected"
                          >
                            Supprimer la selection
                          </button>
                        </div>

                        <div
                          class="modal fade"
                          id="kt_modal_export_users"
                          tabindex="-1"
                          aria-hidden="true"
                        >
                          <div
                            class="modal-dialog modal-dialog-centered mw-650px"
                          >
                            <div class="modal-content">
                              <div class="modal-header">
                                <h2 class="fw-bold">Export Users</h2>

                                <div
                                  class="btn btn-icon btn-sm btn-active-icon-primary"
                                  data-kt-users-modal-action="close"
                                >
                                  <i class="ki-duotone ki-cross fs-1"
                                    ><span class="path1"></span
                                    ><span class="path2"></span
                                  ></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div
                        class="card-body py-4 p-0 m-0"
                        v-if="filteredServicesDeposit.length"
                      >
                        <table
                          class="table align-middle table-row-dashed fs-6 gy-5"
                          id="kt_table_usersxxx"
                        >
                          <thead>
                            <tr
                              class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                            >
                              <th class="min-w-180px">Item</th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                            </tr>
                          </thead>

                          <tbody class="fw-bold text-gray-600">
                            <template
                              v-for="service in filteredServicesDeposit"
                              :key="service.service.id"
                            >
                              <tr class="w-100">
                                <td class="">
                                  <label
                                    class="d-flex flex-stack cursor-pointer"
                                  >
                                    <span
                                      class="d-flex align-items-center me-2"
                                    >
                                      <span class="symbol symbol-50px me-6">
                                        <span
                                          class="symbol-label bg-light-primary"
                                        >
                                          <i
                                            class="ki-duotone ki-compass fs-1 text-primary"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                          ></i>
                                        </span>
                                      </span>

                                      <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">{{
                                          service.service.name
                                        }}</span>
                                      </span>
                                    </span>

                                    <span
                                      class="form-check form-check-custom form-check-solid"
                                    >
                                      <input
                                        @change="checkedValue(service.service)"
                                        :class="`form-check-input service_${service.service.id}`"
                                        type="checkbox"
                                      />
                                    </span>
                                  </label>
                                </td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>

                                <td class="d-none"></td>
                                <td class="d-none"></td>

                                <td class="d-none"></td>
                              </tr>
                            </template>
                          </tbody>
                        </table>
                      </div>
                      <div
                        class="card-body py-4 p-0 m-0"
                        v-if="mouvementList.length"
                      >
                        <table
                          class="table align-middle table-row-dashed fs-6 gy-5"
                          id="kt_table_usersxx2"
                        >
                          <thead>
                            <tr
                              class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                            >
                              <th class="min-w-180px">Item selectionner</th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                              <th class="d-none"></th>
                            </tr>
                          </thead>

                          <tbody class="fw-bold text-gray-600">
                            <template
                              v-for="service in mouvementList"
                              :key="service.id"
                            >
                              <tr class="w-100">
                                <td class="">
                                  <label
                                    class="d-flex flex-stack cursor-pointer"
                                  >
                                    <span
                                      class="d-flex align-items-center me-2"
                                    >
                                      <span class="symbol symbol-50px me-6">
                                        <span
                                          class="symbol-label bg-light-primary"
                                        >
                                          <i
                                            class="ki-duotone ki-compass fs-1 text-primary"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                          ></i>
                                        </span>
                                      </span>

                                      <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">{{
                                          service.name
                                        }}</span>
                                      </span>
                                    </span>

                                    <span
                                      class="form-check form-check-custom form-check-solid"
                                    >
                                      <input
                                        @change="checkedValue(service)"
                                        :class="`form-check-input service_${service.id}`"
                                        type="checkbox"
                                        checked
                                      />
                                    </span>
                                  </label>
                                </td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>

                                <td class="d-none"></td>
                                <td class="d-none"></td>

                                <td class="d-none"></td>
                              </tr>
                            </template>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div data-kt-stepper-element="content" class="row mb-5">
                  <div className="accordion" id="kt_accordion_1">
                    <template
                      v-for="(prod, index) in mouvementList"
                      :key="index"
                    >
                      <div className="accordion-item">
                        <h2
                          className="accordion-header"
                          :id="`kt_accordion_1_header_${index}`"
                          @click="
                            closeCollapsed(`kt_accordion_1_body_${index}`)
                          "
                        >
                          <button
                            className="accordion-button d-flex flex-row fs-4 fw-bold collapsed p-0 px-3 m-0"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="`#kt_accordion_1_body_${index}`"
                            aria-expanded="false"
                            :aria-controls="`kt_accordion_1_body_${index}`"
                          >
                            <span class="symbol symbol-50px me-6">
                              <span class="symbol-label bg-light-primary">
                                <i
                                  class="ki-duotone ki-compass fs-1 text-primary"
                                  ><span class="path1"></span
                                  ><span class="path2"></span
                                ></i>
                              </span>
                            </span>
                            <div class="d-flex align-items-center">
                              <span class="d-flex flex-column">
                                <span class="fw-bold fs-6"
                                  >{{ prod.name }}
                                </span>
                              </span>
                            </div>
                          </button>
                        </h2>
                        <div
                          data-bs-count="0"
                          :id="`kt_accordion_1_body_${index}`"
                          className="accordion-collapse collapse"
                          :aria-labelledby="`kt_accordion_1_header_${index}`"
                          data-bs-parent="#kt_accordion_1"
                        >
                          <div className="accordion-body">
                            <div class="row g-4">
                              <div class="card mb-1">
                                <div class="row">
                                  <div class="col-7">
                                    <div class="fv-row">
                                      <label class="required form-label"
                                        >Quantité
                                      </label>

                                      <input
                                        type="number"
                                        class="form-control mb-2"
                                        @input="
                                          InputValue($event, 'quantity', prod)
                                        "
                                        placeholder=""
                                        min="0"
                                        required
                                      />
                                    </div>
                                  </div>
                                  <div class="col-5 fv-row">
                                    <label class="form-label"
                                      >Prix d'achat
                                    </label>

                                    <input
                                      type="number"
                                      class="form-control mb-2"
                                      @input="InputValue($event, 'price', prod)"
                                      placeholder=""
                                      min="0"
                                      required
                                    />

                                    <div class="text-muted fs-7">
                                      Total est {{ totalWithId(prod.id) }}
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card mb-2">
                                <div class="row">
                                  <div class="col-7">
                                    <div
                                      class="mb-5 fv-row"
                                      v-if="form.type == 'entry'"
                                    >
                                      <label class="form-label"
                                        >Date d'exp
                                      </label>

                                      <input
                                        type="date"
                                        class="form-control mb-2"
                                        placeholder=""
                                        @input="
                                          InputValue($event, 'date', prod)
                                        "
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </template>
                  </div>
                </div>

                <div data-kt-stepper-element="content">
                  <div class="w-100 text-center">
                    <h1 class="fw-bold text-dark mb-3">Approv!</h1>

                    <div class="text-muted fw-semibold fs-3">
                      Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                      Nisi, magni minus.
                    </div>

                    <div class="text-center px-4 py-15">
                      <img
                        src="/assets/media/illustrations/sketchy-1/9.png"
                        alt=""
                        class="mw-100 mh-300px"
                      />
                    </div>
                  </div>
                </div>

                <div class="d-flex flex-stack">
                  <div class="me-2">
                    <button
                      type="button"
                      class="btn btn-lg btn-light-primary me-3"
                      id="backStepper"
                      @click="backStepper"
                    >
                      <i class="ki-duotone ki-arrow-left fs-3 me-1"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Retour
                    </button>
                  </div>

                  <div>
                    <button
                      @click="updateServiceStock(form.service, form.deposit_id)"
                      type="button"
                      class="btn btn-lg btn-primary d-none"
                      id="submit"
                    >
                      <span class="indicator-label" v-if="!isLoaging">
                        Envoyer
                        <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0"
                          ><span class="path1"></span><span class="path2"></span
                        ></i>
                      </span>
                      <span v-else>
                        Veuillez patienter svp
                        <span
                          class="spinner-border spinner-border-sm align-middle ms-2"
                        ></span>
                      </span>
                    </button>

                    <button
                      type="button"
                      @click="nextStepper"
                      id="nextStepper"
                      class="btn btn-lg btn-primary"
                      data-kt-stepper-action="next"
                    >
                      Continue
                      <i class="ki-duotone ki-arrow-right fs-3 ms-1 me-0"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </form>
      </template>
      <template #footer>
        <div class="modal-footer">
          <div class="row col-12 p-0 m-0">
            <!-- code -->

            <div
              v-if="form.type != 'withdraw'"
              class="col-3 py-1 my-1 d-flex flex-column flex-center hover-scale"
            >
              <button
                @click="addFournisseur"
                type="button"
                class="btn btn-light-primary btn-sm"
              >
                <i class="ki-duotone ki-plus fs-2"></i>
                {{ providerLocal.providerName ?? "Fournisseur" }}
                <i class="fas fa-truck-moving fs-1"></i>
              </button>
            </div>
            <div
              class="col-3 my-1 py-1 d-flex flex-column flex-center hover-scale"
            >
              <button
                @click="addStore"
                type="button"
                class="btn btn-light-primary btn-sm"
              >
                <i class="ki-duotone ki-plus fs-2"></i>
                {{ storeLocal.name ?? "Depot" }}
                <i class="fas fa-store fs-1"></i>
              </button>
            </div>
            <div
              class="col-3 my-1 py-1 d-flex flex-column flex-center hover-scale"
            >
              <button
                @click="addDocument"
                type="button"
                class="btn btn-light-primary btn-sm"
              >
                <i class="ki-duotone ki-plus fs-2"></i>

                {{
                  documents.length > 1
                    ? documents.length + " Documents"
                    : documents.length == 1
                    ? "1 Document"
                    : "Document"
                }}
                <i class="fas fa-file-import fs-1"></i>
              </button>
            </div>
            <div
              class="col-3 d-flex my-1 py-1 flex-column flex-center hover-scale"
            >
              <button
                @click="addMonnaie"
                type="button"
                class="btn btn-light-primary btn-sm"
              >
                <i class="ki-duotone ki-plus fs-3"></i
                >{{ moneyLocal.abreviation ?? "Monnaie" }}
                <i class="fas fa-money-check-alt fs-1"></i>
              </button>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      :positionModal="`center mw-750px`"
      :form="providerForm"
      :id="'provider-modal'"
      activeBtn="false"
      :formInput="'ok'"
      @instance-modal="createProvider"
      @cancel-btn="cancelBtnP"
    >
      <template #title>Ajouter un Fournisseur </template>
      <template #body>
        <!-- provider -->
        <div class="d-flex bd-highlight flex-center mx-3">
          <div class="w-100 bd-highlight">
            <div class="d-flex align-items-center position-relative my-1">
              <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                ><span class="path1"></span><span class="path2"></span
              ></i>
              <input
                type="text"
                v-model="searchProvider"
                :class="`ps-13 form-control form-control-lg form-control-solid`"
                :placeholder="`chercher un fournisseur`"
              />
            </div>
          </div>
          <div
            @click="addFournisseurId"
            class="btn btn-icon btn-circle btn-light-primary mx-1"
          >
            <i class="ki-duotone ki-plus fs-2"></i>
          </div>
        </div>
        <div>
          <!-- drageur -->
          <div
            class="menu menu-column menu-sub-indention px-3 border rounded-3 py-0 px-8 fs-5"
            data-kt-menu="true"
            data-kt-menu-expand="true"
          >
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link my-0 py-0">
                <span class="menu-title" id="addFournisseur">
                  <!-- title -->
                </span>
              </span>
              <div class="menu-sub menu-sub-accordion border-top border-1">
                <div class="menu-item mt-3">
                  <!-- items -->
                  <div class="card">
                    <div class="card-header my-0 py-0">
                      Information sur le fournisseur
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="mb-4 fv-row col-md-6">
                          <label class="required form-label"
                            >Nom du fournisseur</label
                          >
                          <input
                            type="text"
                            class="form-control mb-2"
                            placeholder="nom du produit"
                            v-model="providerForm.providerName"
                            required
                          />

                          <div class="text-muted fs-7">
                            Un nom du fournisseur doit etre unique
                          </div>
                        </div>
                        <div class="mb-4 fv-row col-md-6">
                          <label class="form-label">Num Tel</label>
                          <input
                            type="tel"
                            class="form-control mb-2"
                            placeholder="nom du produit"
                            v-model="providerForm.phone"
                          />

                          <div class="text-muted fs-7">
                            Un nom du fournisseur doit etre unique
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="mb-4 fv-row col-md-6">
                          <label class="form-label">Email</label>
                          <input
                            type="email"
                            class="form-control mb-2"
                            placeholder="adresse email"
                            v-model="providerForm.mail"
                          />

                          <div class="text-muted fs-7">
                            email du fournisseur doit etre unique
                          </div>
                        </div>
                        <div class="mb-4 fv-row col-md-6">
                          <label class="required form-label"
                            >Type de fournisseur</label
                          >
                          <select
                            id="SelectedType"
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="type de fournisseur"
                            data-allow-clear="true"
                            data-dropdown-css-class="w-230px"
                            data-kt-user-table-filter="entreprise"
                            data-hide-search="true"
                          >
                            <option></option>
                            <option value="physique">Physique</option>
                            <option value="morale">Moral</option>
                          </select>
                        </div>
                      </div>
                      <div>
                        <label class="form-label fw-normal fs-7">Adresse</label>
                        <div class="ms-auto">
                          <textarea
                            v-model="providerForm.adress"
                            id=""
                            cols="20"
                            rows="3"
                            class="form-control bg-light"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center mb-5" v-if="activeBtn != 'false'">
                  <button
                    id="annulerX"
                    type="reset"
                    @click="addFournisseurId"
                    class="btn btn-light me-3"
                  >
                    Annuler
                  </button>

                  <button
                    type="submit"
                    id="submitX"
                    class="btn btn-primary"
                    data-kt-users-modal-action="submit"
                  >
                    <span class="indicator-label" v-if="!modalfade"
                      >Envoyer</span
                    >

                    <span v-else>
                      Veuillez patienter svp...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span>
                    </span>
                  </button>
                </div>
                <!-- sending data -->
              </div>
            </div>
          </div>
          <!-- list -->
          <div class="card-body py-4 px-5">
            <table
              class="table align-middle table-row-dashed fs-6 gy-5"
              id="kt_table_usersxx2"
            >
              <thead>
                <tr
                  class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                >
                  <th class="min-w-180px">Liste de fournisseurs</th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                </tr>
              </thead>

              <tbody class="fw-bold text-gray-600">
                <template v-for="provider in providerFilter" :key="provider.id">
                  <tr class="w-100">
                    <td class="">
                      <label class="d-flex flex-stack mb-5 cursor-pointer">
                        <span class="d-flex align-items-center me-2">
                          <span class="symbol symbol-50px me-6">
                            <span class="symbol-label bg-light-primary">
                              <i class="ki-duotone ki-compass fs-1 text-primary"
                                ><span class="path1"></span
                                ><span class="path2"></span
                              ></i>
                            </span>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">{{
                              provider.providerName
                            }}</span>

                            <span class="fs-7 text-muted"
                              >{{ provider.mail }}/{{ provider.type }}
                            </span>
                          </span>
                        </span>

                        <span
                          class="form-check form-check-custom form-check-solid"
                        >
                          <input
                            @change="providerCheck(null, provider)"
                            name="radioBtn"
                            :class="`form-check-input provider_${provider.id}`"
                            type="radio"
                          />
                        </span>
                      </label>
                    </td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>

                    <td class="d-none"></td>
                    <td class="d-none"></td>

                    <td class="d-none"></td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      positionModal="center mw-665px"
      :form="{}"
      :id="'document-modal'"
      activeBtn="false"
      :formInput="'ok'"
      @cancel-btn="cancelBtnD"
    >
      <template #title>Ajouter un document</template>
      <template #body>
        <!-- provider -->
        <div class="d-flex bd-highlight mx-3">
          <div class="flex-grow-1 bd-highlight">
            <div class="d-flex align-items-center position-relative my-1">
              <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                ><span class="path1"></span><span class="path2"></span
              ></i>
              <input
                type="text"
                v-model="searchDocument"
                :class="`ps-13 form-control form-control-lg form-control-solid`"
                :placeholder="`chercher un document`"
              />
            </div>
          </div>
          <div class="d-highlight">
            <div
              @click="clickFile"
              class="btn btn-icon btn-circle btn-light-primary mx-1"
            >
              <i class="ki-duotone ki-plus fs-2"></i>
            </div>
            <div
              @click="valideFile"
              class="btn btn-icon btn-circle btn-light-primary mx-1"
            >
              <i class="fas fa-check-double fs-2"></i>
            </div>
          </div>
        </div>
        <div>
          <!-- dragueur 2 -->
          <div>
            <input
              id="clickFile"
              hidden
              type="file"
              accept=".png, .jpg, .jpeg"
              @change="onFileChange($event)"
              aria-label="photo"
              multiple
            />
          </div>
          <div class="card mx-5">
            <div class="mb-2">
              <div class="d-flex justify-content-between">
                <label class="form-label fw-normal fs-7">Note</label>
              </div>
              <div class="ms-auto">
                <textarea
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control bg-light"
                ></textarea>
              </div>
              <hr />
            </div>
            <template v-for="document in documents" :key="document.id">
              <input
                :id="`clickFile2_${document.lastModified}`"
                hidden
                type="file"
                accept=".png, .jpg, .jpeg"
                @change="onFileChange($event, document)"
              />
              <label class="d-flex flex-stack mb-5 cursor-pointer">
                <span class="d-flex align-items-center me-2">
                  <span class="symbol symbol-50px me-6">
                    <span
                      class="symbol-label bg-light-primary"
                      @click="modifyFile(document)"
                    >
                      <i class="ki-duotone ki-file-added fs-1 text-primary"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                    </span>
                  </span>

                  <span class="d-flex flex-column">
                    <span class="fw-bold fs-6" @click="modifyFile(document)">
                      {{ document.name }}
                    </span>
                    <span class="fs-7 text-muted">
                      <div class="d-flex flex-row">
                        <span>Ref:</span
                        ><input
                          type="text"
                          class="form-control mb-2 border-0"
                          placeholder="tapez ici le numero de reference"
                          required
                        />
                      </div>
                    </span>
                  </span>
                </span>
                <span
                  class="form-check form-check-custom form-check-solid"
                  @click="deleteFile(document)"
                >
                  <span class="symbol-label bg-light-primary">
                    <i class="ki-duotone ki-trash-square fs-1 text-danger"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                  </span>
                </span>
              </label>
            </template>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      positionModal="center mw-665px"
      :form="depositForm"
      :id="'store-modal'"
      :formInput="'ok'"
      activeBtn="false"
      @cancel-btn="cancelBtnS"
      @instance-modal="createStore"
    >
      <template #title>Ajouter un depot</template>
      <template #body>
        <!-- provider -->
        <div class="d-flex bd-highlight flex-center mx-3">
          <div class="w-100 bd-highlight">
            <div class="d-flex align-items-center position-relative my-1">
              <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                ><span class="path1"></span><span class="path2"></span
              ></i>
              <input
                type="text"
                v-model="searchDeposit"
                :class="`ps-13 form-control form-control-lg form-control-solid`"
                :placeholder="`chercher un fournisseur`"
              />
            </div>
          </div>
          <div
            @click="addDepositId"
            class="btn btn-icon btn-circle btn-light-primary mx-1"
          >
            <i class="ki-duotone ki-plus fs-2"></i>
          </div>
        </div>
        <div>
          <!-- drageur -->
          <div
            class="menu menu-column menu-sub-indention px-3 border rounded-3 py-0 px-8 fs-5"
            data-kt-menu="true"
            data-kt-menu-expand="true"
          >
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link my-0 py-0">
                <span class="menu-title" id="addDeposit">
                  <!-- title -->
                </span>
              </span>
              <div class="menu-sub menu-sub-accordion border-top border-1">
                <div class="menu-item mt-3">
                  <!-- items -->
                  <div class="card text-start">
                    <div class="card-body">
                      <div class="card-text">
                        <div class="mb-5 fv-row">
                          <label class="required form-label"
                            >Nom de votre depot</label
                          >

                          <input
                            type="text"
                            v-model="depositForm.name"
                            class="form-control mb-2"
                            placeholder="nom du depot"
                          />

                          <div class="text-muted fs-7">
                            Configurer le nom de ce depot
                          </div>
                        </div>
                        <div class="mb-5 fv-row">
                          <label class="required form-label"
                            >Type de depot</label
                          >

                          <div class="">
                            <select
                              id="SelectClickCategorie"
                              class="form-select form-select-solid fw-bold"
                              data-placeholder="Selectionner un type"
                              data-hide-search="true"
                              data-control="select2"
                              data-dropdown-css-class="w-230px"
                            >
                              <option></option>
                              <option
                                data-subtext="categories"
                                value="group"
                                selected
                              >
                                Groupe
                              </option>
                              <option
                                data-subtext="Groupe de depot"
                                value="category"
                              >
                                Categorie
                              </option>
                            </select>
                            <div class="valid-feedback">Par defaut groupe</div>
                          </div>
                        </div>
                        <div class="mb-5 fv-row d-none" id="categorie_tags">
                          <label class="required form-label">Categorie</label>
                          <input
                            @change="categorieValue"
                            id="add_product_categorie_tags"
                            class="form-control mb-2"
                            :data-bs-categories="categoriesDefault"
                            :data-bs-whiteList="categoriesListString"
                          />
                          <div class="text-muted fs-7">
                            Configurer une categorie de ce depot
                          </div>
                        </div>
                        <div class="mb-5 fv-row">
                          <label class="required form-label">Description</label>

                          <textarea
                            v-model="depositForm.description"
                            id=""
                            cols="20"
                            rows="2"
                            class="form-control"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center mb-5" v-if="activeBtn != 'false'">
                  <button
                    id="annulerXY"
                    type="reset"
                    @click="addDepositId"
                    class="btn btn-light me-3"
                  >
                    Annuler
                  </button>

                  <button
                    type="submit"
                    id="submitXY"
                    class="btn btn-primary"
                    data-kt-users-modal-action="submit"
                  >
                    <span class="indicator-label" v-if="!modalfade"
                      >Envoyer</span
                    >

                    <span v-else>
                      Veuillez patienter svp...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span>
                    </span>
                  </button>
                </div>
                <!-- sending data -->
              </div>
            </div>
          </div>
          <!-- list -->
          <div class="card-body py-4 px-5">
            <table
              class="table align-middle table-row-dashed fs-6 gy-5"
              id="kt_table_usersxx2"
            >
              <thead>
                <tr
                  class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                >
                  <th class="min-w-180px">Liste de depots</th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                </tr>
              </thead>

              <tbody class="fw-bold text-gray-600">
                <template v-for="store in filteredDeposit" :key="store.id">
                  <tr class="w-100">
                    <td class="">
                      <label class="d-flex flex-stack mb-5 cursor-pointer">
                        <span class="d-flex align-items-center me-2">
                          <span class="symbol symbol-50px me-6">
                            <span class="symbol-label bg-light-primary">
                              <i class="ki-duotone ki-compass fs-1 text-primary"
                                ><span class="path1"></span
                                ><span class="path2"></span
                              ></i>
                            </span>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">{{ store.name }}</span>

                            <span class="fs-7 text-muted"
                              >{{ store.type }}
                            </span>
                          </span>
                        </span>

                        <span
                          class="form-check form-check-custom form-check-solid"
                        >
                          <input
                            @change="providerCheck('store', store)"
                            name="radioBtn"
                            :class="`form-check-input
                          store_${store.id}`"
                            type="radio"
                          />
                        </span>
                      </label>
                    </td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>

                    <td class="d-none"></td>
                    <td class="d-none"></td>

                    <td class="d-none"></td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      positionModal="center mw-665px"
      :form="{}"
      :id="'monnaie-modal'"
      activeBtn="false"
      :formInput="'ok'"
      @cancel-btn="cancelBtnM"
    >
      <template #title>Ajouter une monnaie</template>
      <template #body>
        <!-- provider -->
        <div class="d-flex bd-highlight flex-center mx-3">
          <div class="w-100 bd-highlight">
            <div class="d-flex align-items-center position-relative my-1">
              <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                ><span class="path1"></span><span class="path2"></span
              ></i>
              <input
                type="text"
                v-model="searchMonnaie"
                :class="`ps-13 form-control form-control-lg form-control-solid`"
                :placeholder="`chercher un fournisseur`"
              />
            </div>
          </div>
          <div
            @click="addFournisseurId"
            class="btn btn-icon btn-circle btn-light-primary mx-1"
          >
            <i class="ki-duotone ki-plus fs-2"></i>
          </div>
        </div>
        <div>
          <!-- drageur -->
          <div
            class="menu menu-column menu-sub-indention px-3 border rounded-3 py-0 px-8 fs-5"
            data-kt-menu="true"
            data-kt-menu-expand="true"
          >
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link my-0 py-0">
                <span class="menu-title" id="addFournisseur">
                  <!-- title -->
                </span>
              </span>
              <div class="menu-sub menu-sub-accordion border-top border-1">
                <div class="menu-item mt-3">
                  <!-- items -->
                  <div class="card">
                    <div class="card-header my-0 py-0">
                      Information sur la monnaie
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="mb-4 fv-row col-md-6">
                          <label class="required form-label"
                            >Label de la monnaie</label
                          >
                          <input
                            type="text"
                            class="form-control mb-2"
                            placeholder="nom du produit"
                            v-model="providerForm.providerName"
                            required
                          />

                          <div class="text-muted fs-7">
                            Un nom d'une monnaie doit etre unique
                          </div>
                        </div>
                        <div class="mb-4 fv-row col-md-6">
                          <label class="required form-label"
                            >Abbreviation</label
                          >
                          <input
                            type="tel"
                            class="form-control mb-2"
                            placeholder="nom du produit"
                            v-model="providerForm.phone"
                            required
                          />

                          <div class="text-muted fs-7">
                            Un nom du fournisseur doit etre unique
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="mb-4 fv-row col-md-6">
                          <label class="required form-label">Email</label>
                          <input
                            type="email"
                            class="form-control mb-2"
                            placeholder="adresse email"
                            v-model="providerForm.mail"
                            required
                          />

                          <div class="text-muted fs-7">
                            email du fournisseur doit etre unique
                          </div>
                        </div>
                        <div class="mb-4 fv-row col-md-6">
                          <label class="required form-label"
                            >Type de fournisseur</label
                          >
                          <select
                            id="SelectedType"
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="type de fournisseur"
                            data-allow-clear="true"
                            data-dropdown-css-class="w-230px"
                            data-kt-user-table-filter="entreprise"
                            data-hide-search="true"
                          >
                            <option></option>
                            <option value="physique">Physique</option>
                            <option value="morale">Moral</option>
                          </select>
                        </div>
                      </div>
                      <div>
                        <label class="form-label fw-normal fs-7">Adresse</label>
                        <div class="ms-auto">
                          <textarea
                            v-model="providerForm.adress"
                            id=""
                            cols="20"
                            rows="3"
                            class="form-control bg-light"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center mb-5" v-if="activeBtn != 'false'">
                  <button
                    id="annulerX"
                    type="reset"
                    @click="addFournisseurId"
                    class="btn btn-light me-3"
                  >
                    Annuler
                  </button>

                  <button
                    type="submit"
                    id="submitX"
                    class="btn btn-primary"
                    data-kt-users-modal-action="submit"
                  >
                    <span class="indicator-label" v-if="!modalfade"
                      >Envoyer</span
                    >

                    <span v-else>
                      Veuillez patienter svp...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span>
                    </span>
                  </button>
                </div>
                <!-- sending data -->
              </div>
            </div>
          </div>
          <!-- list -->
          <div class="card-body py-4 px-5">
            <table
              class="table align-middle table-row-dashed fs-6 gy-5"
              id="kt_table_usersxx2"
            >
              <thead>
                <tr
                  class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0"
                >
                  <th class="min-w-180px">Liste de monnaies</th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                </tr>
              </thead>

              <tbody class="fw-bold text-gray-600">
                <template v-for="monnaie in moneyFilter" :key="monnaie.id">
                  <tr class="w-100">
                    <td class="">
                      <label class="d-flex flex-stack mb-5 cursor-pointer">
                        <span class="d-flex align-items-center me-2">
                          <span class="symbol symbol-50px me-6">
                            <span class="symbol-label bg-light-primary">
                              <i class="ki-duotone ki-compass fs-1 text-primary"
                                ><span class="path1"></span
                                ><span class="path2"></span
                              ></i>
                            </span>
                          </span>

                          <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">{{
                              monnaie.money_name
                            }}</span>

                            <span class="fs-7 text-muted"
                              >{{ monnaie.abreviation }}
                            </span>
                          </span>
                        </span>

                        <span
                          class="form-check form-check-custom form-check-solid"
                        >
                          <input
                            @change="monnaieCheck(monnaie)"
                            name="radioBtn"
                            :class="`form-check-input monnaie_${monnaie.id}`"
                            type="radio"
                          />
                        </span>
                      </label>
                    </td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>
                    <td class="d-none"></td>

                    <td class="d-none"></td>
                    <td class="d-none"></td>

                    <td class="d-none"></td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import stockTableComponent from "./stockTableComponent.vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import { notifications } from "../../notifications/notifications";
import { computed, onMounted, reactive, ref, watch } from "vue";
import useProducts from "../../services/productservices";
import useProviders from "../../services/providerservices";
import useDeposit from "../../services/depositservices";
import useStock from "../../services/stockservices";
import { min } from "moment";
import cardTemplate from "./cardTemplate.vue";
import useCategories from "../../services/categorieservices";
import test from "../categories/categorieSave";
import useMoney from "../../services/moneyservices";
export default {
  components: {
    stockTableComponent,
    modalComponent,
    cardTemplate,
  },
  setup(props, { emit }) {
    const {
      deposit,
      servicesDeposit,
      getServicesDeposit,
      deposits,
      storeDeposit,
      getDeposits,
      getDepositAuthUser,
    } = useDeposit();
    const { money, errors, getMoney, storeMoney } = useMoney();
    const { categoriesListString, categories, getCategories, storeCategories } =
      useCategories();
    const { products, getProducts, storeProducts } = useProducts();
    const { provider, providers, getProviders, storeProviders } =
      useProviders();
    const { swal, dataErrorMessage } = notifications();
    const stepperIndex = ref(0);

    const { stockServices, getStock, storeStock } = useStock();

    const stockModal = (data) => {
      //   alert(data);

      form.type = data;
      search.value = "";
      mouvementSendList.value = [];
      mouvementList.value = [];
      document.querySelector("#nextStepper").classList.remove("d-none");
      document.querySelector("#submit").classList.add("d-none");
      StepperGoTo(1);
      $("#stock-modal").modal("show");
      stepperIndex.value = 1;
    };
    onMounted(async () => {
      await callBackMounted();
    });
    const handleSelectChangeType = (event) => {
      form.type = event.target.value;
    };
    const handleSelectChange = (event) => {
      if (event.target.value == "resetFilter") {
        $("#resetFilter").trigger("click");
      } else {
        $("#filterValue").trigger("click");
      }
    };
    async function callBackMounted() {
      await getStock();
      await getServicesDeposit();
      await getProducts();
      await getDepositAuthUser();
      await getProviders();
      getMoney(); // je n ai pas vraiment besoin d attendre le chargement des monnainepour aue la page puisse fonctionner selon moi c'est
      $("#SelectClick").on("change", handleSelectChange);
      mouvementList.value = [];
      $("#SelectClickType").on("change", handleSelectChangeType);
      services.value = servicesDeposit.value.flatMap((store) => {
        return store.services.map((service) => {
          return {
            service: service,
            store: {
              id: store.id,
              name: store.name,
            },
          };
        });
      });
      await getCategories();
      $("#SelectClickCategorie").on("change", handleSelectChangeCategorie);
      test.initTagify(categoriesListString.value.split(","));
    }
    const handleSelectChangeCategorie = (event) => {
      depositForm.type = event.target.value;
      if (event.target.value == "group") {
        $("#categorie_tags").addClass("d-none");
      } else {
        $("#categorie_tags").removeClass("d-none");
      }
    };

    const filteredproducts = computed(() => {
      if (!search.value) {
        return servicesDeposit.value;
      }
      const filteredStores = servicesDeposit.value.filter((store) => {
        return (
          store.name.includes(search.value) ||
          store.services.some((service) => service.name.includes(search.value))
        );
      });
      const sortedStores = filteredStores.sort((a, b) => {
        const aOccurrences = countOccurrences(a, search.value);
        const bOccurrences = countOccurrences(b, search.value);
        return bOccurrences - aOccurrences;
      });
      return sortedStores;
    });
    function countOccurrences(item, searchValue) {
      let count = 0;
      count += (item.name.match(new RegExp(searchValue, "gi")) || []).length;
      item.services.forEach((service) => {
        count += (service.name.match(new RegExp(searchValue, "gi")) || [])
          .length;
      });
      return count;
    }
    const cancelValue = ref(false);
    const cancelBtnU = () => {
      cancelBtn(true);
    };
    const cancelBtnS = () => {
      cancelBtn();
    };
    const cancelBtnP = () => {
      cancelBtn();
    };
    const cancelBtnM = () => {
      cancelBtn();
    };
    const cancelBtnD = () => {
      cancelBtn();
    };

    const cancelBtn = (init = false) => {
      if (init) {
        StepperGoTo(1);
        cancelValue.value = true;
        initialValue.value.splice(0, initialValue.value.length);
      }
    };
    const nextStepper = () => {
      stepperIndex.value += 1;
      const backStepperElement = document.querySelector("#backStepper");
      const nextStepperElement = document.querySelector("#nextStepper");
      const submitElement = document.querySelector("#submit");
      submitElement.classList.add("d-none");
      if (stepperIndex.value >= 1) {
        nextStepperElement.classList.add("d-none");
        submitElement.classList.remove("d-none");
      }
    };
    const backStepper = () => {
      stepperIndex.value -= 1;

      const backStepperElement = document.querySelector("#backStepper");
      const nextStepperElement = document.querySelector("#nextStepper");
      const submitElement = document.querySelector("#submit");
      submitElement.classList.add("d-none");
      nextStepperElement.classList.remove("d-none");
      if (stepperIndex.value <= 1) {
        stepperIndex.value = 1;
      }
      StepperGoTo(stepperIndex.value);
    };
    // ngsearchpipe
    const form = reactive({
      id: "",
      name: "",
      service_id: null,
      quantity: 0,
      deposit_id: null,
    });
    const providerForm = reactive({
      id: null,
      providerName: "",
      adress: "",
      phone: "",
      photo: null,
      type: "physique",
      mail: "",
      enterprise_id: 1,
    });
    const storeName = ref("");
    const mouvementList = ref([]);
    const depositForm = reactive({
      id: null,
      name: "",
      type: "group",
      categories: [],
      enterprise_id: 1,
      description: "",
      user_id: 1,
    });
    const providerLocal = reactive({});
    const storeLocal = reactive({
      id: null,
    });
    const moneyLocal = reactive({});

    const providerCheck = (service = null, provider) => {
      if (service == null) {
        providerLocal.id = provider.id;
        providerLocal.providerName = provider.providerName;
        providerLocal.photo = provider.photo;
        $("#provider-modal .closeBtn").click();
      } else {
        storeLocal.id = provider.id;
        storeLocal.name = provider.name;
        storeLocal.photo = provider.photo;
        $("#store-modal .closeBtn").click();
      }
    };
    const checkedValue = (service, store = null) => {
      if (store == null) {
        const elements = document.querySelectorAll(`.service_${service.id}`);
        elements.forEach((element) => {
          if (element.checked) {
            element.checked = true;

            mouvementList.value.push(service);
          } else {
            $(`.service_${service.id}`).prop("checked", false);
            const index = mouvementList.value.findIndex(
              (item) => item.id === service.id
            );

            mouvementList.value = mouvementList.value.filter(
              (el) => el !== service
            );
          }
        });
      } else {
        const elements = document.querySelectorAll(
          `.service_${service.id}_store_${store.deposit_id}`
        );

        elements.forEach((element) => {
          if (element.checked) {
            element.checked = true;

            mouvementList.value.push({
              service: service,
              deposit_id: store.deposit_id,
              deposit: store,
            });
          } else {
            $(`.service_${service.id}_store_${store.deposit_id}`).prop(
              "checked",
              false
            );

            mouvementList.value = mouvementList.value.filter(
              (el) =>
                el.service !== service && el.deposit_id !== store.deposit_id
            );
          }
        });
      }
      // Rest of your code
    };
    let isLoaging = ref(false);
    const updateServiceStock = async (service, deposit_id) => {
      if (storeLocal.id == null) {
        dataErrorMessage("Veuillez configurer d'abord un depot svp");
        return;
      }
      isLoaging.value = true;

      //   let sendData = reactive({
      //     services: [],
      //     deposit_id: null,
      //     type: "entry",
      //     unity: "USD",
      //     type_approvement: "cash",
      //     documents: [],
      //   });
      //   sendData.data = mouvementSendList.value.flatMap((el) => el);
      //   sendData.documents = [];
      //   sendData.deposit_id = storeLocal.id;
      //   sendData.provider_id = providerLocal.id;
      //   sendData.unity = moneyLocal.id;
      //   documents.value.forEach((el) => {
      //     sendData.documents.push(el);
      //   });
      //   sendData.type_approvement = "cash";
      //   sendData.type = form.type;
      mouvementSendList.value.flatMap((el) => {
        documents.value.forEach((el) => {
          el["documents"].push(el);
        });
        el["deposit_id"] = storeLocal.id;
        el["provider_id"] = providerLocal.id;
        el["unity"] = moneyLocal.id;

        try {
          el["quantity_before"] = el.service.store.filter(
            (store) => store.deposit_id == storeLocal.id
          )[0].available_qte;
        } catch (error) {}
        el["type_approvement"] = "cash";
        el["type"] = form.type;
      });

      console.log("#####################");
      console.log({ ...mouvementSendList });

      await storeStock({ ...mouvementSendList });
      await getStock();
      await getServicesDeposit();
      $(".closeBtn").trigger("click");
      emit("callback");
      isLoaging.value = false;
      callBackMounted();
      _init();
    };
    function _init() {
      stepperIndex.value = 1;
      filteredServicesDeposit.value = [];
      mouvementList.value = [];
      var elements = document.querySelectorAll('[class^=".service_"]');

      for (var i = 0; i < elements.length; i++) {
        elements[i].checked = false;
      }
      services.value = servicesDeposit.value.flatMap((store) => {
        return store.services.map((service) => {
          return {
            service: service,
            store: {
              id: store.id,
              name: store.name,
            },
          };
        });
      });
      moneyLocal.value = {};
      //   formLocal.value = {};
      storeLocal.value = {};
      mouvementSendList.value = [];
      mouvementList.value = [];
      mouvementType.value = "";
    }
    const CloseModal = async () => {
      initialValue.value;

      new bootstrap.Modal(element).hide();
      $("#submit").trigger("click");
    };

    // filtre de services with Search v-model
    const search = ref("");
    const filteredServicesDeposit = computed(() => {
      if (!search.value) {
        return [];
      }
      const result = products.value.filter((product) =>
        product.service.name.toLowerCase().includes(search.value.toLowerCase())
      );
      result.sort((a, b) => a.service.name.localeCompare(b.service.name));
      return result;
    });
    const filteredDeposit = computed(() => {
      if (!searchDeposit.value) {
        return deposits.value;
      }
      const result = deposits.value.filter((store) =>
        store.name.toLowerCase().includes(searchDeposit.value.toLowerCase())
      );
      result.sort((a, b) => a.name.localeCompare(b.name));
      return result;
    });
    const searchDeposit = ref("");
    const searchProvider = ref("");
    const searchMonnaie = ref("");
    const moneyFilter = computed(() => {
      if (!searchMonnaie.value) {
        return money.value;
      }
      const result = money.value.filter((monnaie) =>
        monnaie.money_name
          .toLowerCase()
          .includes(searchMonnaie.value.toLowerCase())
      );
      result.sort((a, b) => a.label.localeCompare(b.label));
      return result;
    });
    const providerFilter = computed(() => {
      if (!searchProvider.value) {
        return providers.value;
      }
      const result = providers.value.filter((provider) =>
        provider.providerName
          .toLowerCase()
          .includes(searchProvider.value.toLowerCase())
      );
      result.sort((a, b) => a.providerName.localeCompare(b.providerName));
      return result;
    });
    // watch(services, () => {
    //   filteredServicesDeposit.value;
    // });
    const services = ref([]);
    const initialValue = ref([]);
    const mouvementSendList = ref([]);
    const InputValue = (e, entry, product) => {
      modifiyParams(product, entry, e.target.value);
    };
    let mouvementType = ref("entry");
    const alertBtn = () => {
      swal(
        "question",
        "Question",
        "Veuillez choisir le type mouvement",
        "Approvisionnement",
        "Destockage",
        () => {
          mouvementType.value = "entry";
          form.type = "entry";
          stockModal("entry");
          $("#SelectClickType").val(form.type).trigger("change");
        },
        () => {
          form.type = "withdraw";
          mouvementType.value = "withdraw";
          stockModal("withdraw");
          $("#SelectClickType").val(form.type).trigger("change");
        },
        "",
        "btn-danger"
      );
    };
    const toglleCollapse = (id) => {
      $(`#${id}`).toggleClass("here show");
    };

    const selectedValue = (e, id) => {
      modifiyParams(id, "deposit_id", e.target.value, e.target.value);
    };
    const modifiyParams = (product, params, value, store_id) => {
      const searchIndex = mouvementSendList.value.findIndex(
        (item) => parseInt(item.service_id) === product.id
      );

      if (searchIndex !== -1) {
        mouvementSendList.value[searchIndex][params] = value;
      } else {
        form[params] = value;
        form["service_id"] = product.id;
        form["deposit_id"] = store_id;
        form["service"] = product;
        form["quantity_before"] = product.quantity_before;
        let formLocal = {};
        for (const [key, value] of Object.entries(form)) {
          formLocal[key] = value;
        }
        mouvementSendList.value.push(formLocal);
      }
    };
    const totalWithId = (id) => {
      const searchIndex = mouvementSendList.value.findIndex(
        (item) => item.service_id === id
      );
      let value = 0;
      if (searchIndex !== -1) {
        value =
          mouvementSendList.value[searchIndex]["quantity"] *
          mouvementSendList.value[searchIndex]["price"];
      } else {
        value = 0;
      }
      return value;
    };
    const addFournisseur = () => {
      $("#provider-modal").modal("show");
      $("#SelectedType").val("physique").trigger("change");
      $("#stock-modal").modal("handleUpdate", false);
    };
    const addDocument = () => {
      $("#document-modal").modal("show");
      //   if (documents.value.length != 0) {
      $("#clickFile").click();
      //   }
      $("#stock-modal").modal("handleUpdate", false);
    };
    const addMonnaie = () => {
      alert(stepperIndex.value);
      $("#monnaie-modal").modal("show");
      $("#stock-modal").modal("handleUpdate", false);
    };
    const addStore = () => {
      $("#store-modal").modal("show");
      $("#stock-modal").modal("handleUpdate", false);
    };
    const addFournisseurId = () => {
      try {
        $(`.provider_${2}`).prop("checked", true);
      } catch (error) {}
      $("#addFournisseur").click();
    };
    const addDepositId = () => {
      $("#addDeposit").click();
    };
    // code
    const modalfade = ref(false);
    const images = ref([]);
    const createProvider = async () => {
      modalfade.value = true;
      await storeProviders({ ...providerForm }, providerForm.id, images);
      await getProviders();

      for (const [key, value] of Object.entries(provider)) {
        providerLocal[key] = provider[key];
      }
      modalfade.value = false;
      addFournisseurId();
    };
    const createStore = async () => {
      modalfade.value = true;
      await storeDeposit({ ...depositForm });

      await getDepositAuthUser();

      for (const [key, value] of Object.entries(deposit)) {
        storeLocal[key] = deposit[key];
      }
      modalfade.value = false;
      addDepositId();
    };
    let documents = ref([]);
    const onFileChange = (event, document = null) => {
      const files = event.target.files;

      if (document != null) {
        const index = documents.value.findIndex(
          (item) => item.name === document.name
        );
        if (index !== -1) {
          documents.value.splice(index, 1, files[0]);
        }
      } else {
        for (let i = 0; i < files.length; i++) {
          try {
            documents.value.push(files[i]);
          } catch (error) {}
        }
      }
    };

    const modifyFile = (document) => {
      $(`#clickFile2_${document.lastModified}`).click();
    };

    const deleteFile = (document) => {
      const index = documents.value.indexOf(document);
      if (index !== -1) {
        documents.value.splice(index, 1);
      }
    };
    const clickFile = () => {
      $("#clickFile").click();
    };
    const monnaieCheck = (monnaie) => {
      moneyLocal.id = monnaie.id;
      moneyLocal.money_name = provider.money_name;
      moneyLocal.abreviation = monnaie.abreviation;
      $("#monnaie-modal .closeBtn").click();
    };
    const valideFile = () => {
      $("#document-modal .closeBtn").click();

      form.documents = documents.value;
    };
    document.addEventListener("keydown", (event) => {
      if (event.keyCode === 13) {
        // Empêcher la fermeture du modal
        event.preventDefault();
        nextStepper();
      }
    });
    const closeCollapsed = (id) => {
      //   alert(111);
      //   document.getElementById("kt_accordion_1_header_x").click();
      var count = document.getElementById(id).getAttribute("data-bs-count");
      count++;
      if (count == 2) {
        // $("#kt_accordion_1_header_x").click();

        count = 0;
      } else {
        // $("#kt_accordion_1_body_x").click();
      }
    };
    const categoriesDefault = [];
    const disable = "";
    var activeBtn, searchDocument;
    return {
      searchDocument,
      activeBtn,
      categoriesDefault,
      nextStepper,
      valideFile,
      moneyLocal,
      clickFile,
      deleteFile,
      modifyFile,
      documents,
      onFileChange,
      storeLocal,
      closeCollapsed,
      deposit,
      createStore,
      filteredDeposit,
      searchDeposit,
      createProvider,
      modalfade,
      addFournisseurId,
      addStore,
      addMonnaie,
      addDocument,
      addFournisseur,
      totalWithId,
      selectedValue,
      initialValue,
      depositForm,
      CloseModal,
      categoriesListString,
      services,
      updateServiceStock,
      backStepper,
      toglleCollapse,
      mouvementList,
      form,
      addDepositId,
      InputValue,
      deposits,
      search,
      alertBtn,
      filteredServicesDeposit,
      checkedValue,
      isLoaging,
      cancelBtn,
      cancelBtnU,
      cancelBtnS,
      cancelBtnP,
      cancelBtnM,
      cancelBtnD,
      stockServices,
      products,
      servicesDeposit,
      filteredproducts,
      providers,
      providerFilter,
      searchProvider,
      providerCheck,
      providerLocal,
      provider,
      providerForm,
      money,
      monnaieCheck,
      moneyFilter,
      searchMonnaie,
      moneyLocal,
      disable,
    };
  },
};
</script>
