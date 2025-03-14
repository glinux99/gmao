<template>
  <div>
    <app-bar-facturation
      @updateProduct="updateProduct"
      @defaultDeposit="defaultDeposit"
    />

    <div class="app-main flex-column flex-row-fluid mt-1" id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <!-- <nav-link-component /> -->
        <!-- <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
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
                Facturation
              </h1>
            </div>
          </div>
        </div> -->

        <div id="kt_app_content" class="app-content flex-column-fluid m-0 p-0">
          <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="px-5">
              <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                  ><span class="path1"></span><span class="path2"></span
                ></i>
                <input
                  type="text"
                  data-kt-user-table-filter="search"
                  class="form-control form-control-solid w-100 ps-13"
                  placeholder="Rechercher un Produit"
                />
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="card shadow-lg py-4 px-5 my-1">
                    <div class="d-flex flex-wrap">
                      <div class="flex-fill d-flex flex-wrap">
                        <template v-for="category in categories" :key="category.id">
                          <label
                            for=""
                            class="badge badge-secondary fs-6 me-2 cursor-pointer"
                          >
                            {{ category.name }}
                          </label>
                        </template>
                      </div>

                      <div class="app-navbar-item ms-1 ms-md-3">
                        <a
                          href="#"
                          class="btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary px-3"
                          data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                          data-kt-menu-attach="parent"
                          data-kt-menu-placement="bottom-end"
                        >
                          <i class="fa fa-ellipsis-vertical"
                            ><span class="path1"></span><span class="path2"></span></i
                        ></a>
                        <div
                          class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                          data-kt-menu="true"
                        >
                          <div class="d-flex justify-content-center flex-column">
                            <span
                              @click="addProduct"
                              class="fs-7 text-muted mx-auto cursor-pointer text-hover-primary my-2"
                              >Nouveau produit</span
                            >
                            <div class="separator"></div>
                            <div
                              for=""
                              class="fs-7 text-muted mx-auto cursor-pointer text-hover-primary my-2"
                            >
                              Filtrer par depot
                            </div>
                            <div class="separator"></div>
                            <div
                              for=""
                              class="fs-7 text-muted mx-auto cursor-pointer text-hover-primary my-2"
                            >
                              Changer l'affichage
                            </div>
                            <div class="separator"></div>
                            <div
                              for=""
                              class="fs-7 text-muted mx-auto cursor-pointer text-hover-danger my-2"
                            >
                              Annuler le filtre
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card card-flush p-5 scroll mh-400px">
                    <div class="row">
                      <template v-for="product in productFitler" :key="product.id">
                        <!-- {{ product }} -->
                        <div class="col-lg-6 col-xxl-8" @click="addCard(product)">
                          <div class="">
                            <img
                              :src="product.remember_pic_link + product.uom_id + '-0.png'"
                              alt="&nbsp;Erreur"
                              class="mb-4 w-100 h-80px w-xxl-15px h-xxl-15px"
                              @error="$event.target.src = '/images/no-image.png'"
                            />
                            <div class="mb-2">
                              <div class="text-center">
                                <span
                                  class="fw-bold text-gray-800 cursor-pointer text-hover-primary"
                                >
                                  {{ product.name }}</span
                                >

                                <span class="text-gray-400 fw-semibold d-block mt-n1">
                                  {{ product.description }}
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </template>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-lg py-4 px-5 my-1">
                    <span>Recaputilatif de la commande</span>
                  </div>
                  <div class="card card-flush p-5 scroll mh-400px">
                    <div class="col">
                      <div class="row">
                        <div
                          class="col-6 mt-3 d-flex justify-content-between fw-bold text-primary fs-7"
                        >
                          <span class="cursor-pointer">TVA</span>

                          <span class="me-2">: </span>
                        </div>
                        <div class="col-6">
                          <input
                            :id="`input_x${i}`"
                            type="text"
                            class="form-control border-0 form-control-sm text-start px-0 fw-bold text-gray-800"
                            :value="form.vat_amount"
                            min="1"
                            @input="RecaputulatifInput($event, 'tva')"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div
                          class="col-6 mt-3 d-flex justify-content-between fw-bold text-primary fs-7"
                        >
                          <span class="cursor-pointer">Reduction</span>

                          <span class="me-2">: </span>
                        </div>
                        <div class="col-6">
                          <input
                            :id="`input_x${i}`"
                            type="text"
                            class="form-control border-0 form-control-sm text-start px-0 fw-bold text-gray-800"
                            :value="form.discount"
                            @input="RecaputulatifInput($event, 'reduction')"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div
                          class="col-6 mt-3 d-flex justify-content-between fw-bold text-primary fs-7"
                        >
                          <span class="cursor-pointer">Total HT</span>

                          <span class="me-2">: </span>
                        </div>
                        <div class="col-6">
                          <input
                            :id="`input_x${i}`"
                            type="text"
                            v-model="bills.subTotal"
                            class="form-control border-0 form-control-sm text-start px-0 fw-bold text-gray-800"
                            min="1"
                          />
                        </div>
                      </div>

                      <div class="row">
                        <div
                          class="col-6 mt-3 d-flex justify-content-between fw-bold text-primary fs-7"
                        >
                          <span class="cursor-pointer">Net a payer</span>

                          <span class="me-2">: </span>
                        </div>
                        <div class="col-6">
                          <input
                            :id="`input_x${i}`"
                            type="text"
                            class="form-control border-0 form-control-sm text-start px-0 fw-bold text-gray-800"
                            v-model="bills.total"
                            min="1"
                          />
                        </div>
                      </div>
                      <div class="row">
                        <div
                          class="col-6 mt-3 d-flex justify-content-between fw-bold text-primary fs-7"
                        >
                          <span class="cursor-pointer">Retour</span>

                          <span class="me-2">: </span>
                        </div>
                        <div class="col-6">
                          <input
                            :id="`input_x${i}`"
                            type="text"
                            class="form-control border-0 form-control-sm disabled text-start px-0 fw-bold text-gray-800"
                            min="1"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="separator my-2"></div>
                    <template v-for="choice in choices" :key="choice.id">
                      <div class="card shadow-lg my-2">
                        <div class="d-flex px-5 py-4">
                          <div class="flex-fill d-flex flex-column">
                            <!-- {{ choice.product }} -->
                            <span class="fw-bold text-primary">
                              {{ choice.product.name }}
                            </span>

                            <div class="d-flex justify-content-between">
                              <span class="fs-8">
                                {{ choice.priceDefault }} {{ choice.money }}
                                {{
                                  choice.product.uom_symbol
                                    ? `/${choice.product.uom_symbol}`
                                    : ""
                                }}
                              </span>
                              <div class="position-relative d-flex align-items-center">
                                <button
                                  type="button"
                                  class="btn btn-icon btn-sm btn-light btn-icon-gray-400"
                                  @click="decrease(choice)"
                                >
                                  <i class="ki-duotone ki-minus fs-2x"></i>
                                </button>
                                <!-- {{ product.quantity }} -->
                                <input
                                  :id="`input${i}`"
                                  type="text"
                                  class="form-control border-0 text-center px-0 fs-3 fw-bold text-gray-800 w-40px"
                                  :value="choice.quantity"
                                  min="1"
                                  @input="InputChange($event, choice)"
                                />

                                <button
                                  type="button"
                                  class="btn btn-icon btn-sm btn-light btn-icon-gray-400"
                                  @click="increase(choice)"
                                >
                                  <i class="ki-duotone ki-plus fs-2x"></i>
                                </button>
                              </div>
                              <div>{{ choice.subTotal }} {{ choice.money }}</div>
                            </div>
                          </div>
                          <div @click="deleteElementToCard(choice)" class="menu-link">
                            <i class="fas fa-trash fs-3"></i>
                          </div>
                        </div>
                      </div>
                    </template>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card shadow-lg py-4 px-5 my-1">
                    <span>Operation de paiement</span>
                  </div>
                  <div class="card card-flush p-5 scroll mh-400px">
                    <div class="row">
                      <div class="col-6 fw-bold text-dark">
                        <div class="fs-3">
                          <i class="ki-duotone ki-dollar fs-3 ms-5"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          Total a payer
                        </div>
                        <div class="cursor-pointer" @click="addCustomer">
                          <i class="ki-duotone ki-user fs-3 ms-5"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          Client
                        </div>
                        <div class="cursor-pointer" @click="addTable">
                          <i class="ki-solid ki-plus fs-3 ms-5"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          Table
                        </div>
                        <div class="cursor-pointer" @click="addServer">
                          <i class="ki-duotone ki-user-tick fs-3 ms-5"
                            ><span class="path1"></span><span class="path2"></span
                          ></i>
                          Serveur
                        </div>
                      </div>
                      <div
                        class="col-6 d-flex flex-column justify-content-start fw-bold fs-7"
                      >
                        <span class="cursor-pointer fs-3"
                          >: {{ bills.total }} {{ bills.money }}</span
                        >
                        <span class="cursor-pointer text-dark" @click="addCustomer"
                          >: {{ defaultCustomer.customerName }}</span
                        >
                        <span @click="addTable">: {{ defaultTable.name }}</span>
                        <span @click="addServer">: {{ defaultServer.name }}</span>
                      </div>
                    </div>
                    <div class="separator my-2"></div>
                  </div>
                  <div class="mb-2 fv-row">
                    <textarea
                      v-model="form.note"
                      id=""
                      cols="20"
                      rows="2"
                      class="form-control"
                      placeholder="Ajouter une note"
                    ></textarea>
                  </div>

                  <div
                    class="menu menu-column menu-sub-indention fs-4 py-3"
                    id="#kt_app_sidebar_menu"
                    data-kt-menu="true"
                    data-kt-menu-expand="true"
                  >
                    <div
                      data-kt-menu-trigger="click"
                      class="menu-item here menu-accordion"
                    >
                      <span class="menu-link"
                        ><span class="menu-icon"
                          ><i class="ki-duotone ki-dollar fs-2"
                            ><span class="path1"></span><span class="path2"></span
                            ><span class="path3"></span
                            ><span class="path4"></span></i></span
                        ><span class="menu-title">
                          <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold text-dark">Methode de payement</span>
                          </div>
                        </span>

                        <span class="menu-arrow"></span>
                        <span
                          data-bs-toggle="tooltip"
                          data-bs-trigger="hover"
                          title="Methode de payement"
                        >
                        </span>
                      </span>
                      <div class="menu-sub menu-sub-accordion border-top border-1">
                        <div class="menu-item mt-3">
                          <div id="kt_user_view_details" class="collapse show">
                            <div class="pb-5 fs-6">
                              <div class="row">
                                <div class="col-md-4">
                                  <div
                                    class="p-3 d-flex flex-column align-items-center justify-content-center border border-1 border-primary text-dark rounded-1-2 card overflow-hidden"
                                  >
                                    <div
                                      class="symbol symbol-circle symbol-25px overflow-hidden"
                                    >
                                      <span class="symbol-label">
                                        <i class="ki-solid ki-bill fs-1 text-primary"></i>
                                      </span>
                                    </div>
                                    <label class="form-label fs-8">En Espece</label>
                                    <input
                                      type="number"
                                      class="form-control form-control-sm form-control-solid"
                                      placeholder=""
                                      @input="RecaputulatifInput($event, 'espece')"
                                    />
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div
                                    class="p-3 d-flex flex-column align-items-center justify-content-center border border-1 border-primary text-dark rounded-1-2 card overflow-hidden"
                                  >
                                    <div
                                      class="symbol symbol-circle symbol-25px overflow-hidden"
                                    >
                                      <span class="symbol-label">
                                        <i class="bi bi-bank fw-bold text-primary"></i>
                                      </span>
                                    </div>
                                    <label class="form-label fs-8">Banque</label>
                                    <input
                                      type="number"
                                      class="form-control form-control-sm form-control-solid"
                                      placeholder=""
                                      @input="RecaputulatifInput($event, 'banque')"
                                    />
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div
                                    class="p-3 d-flex flex-column align-items-center justify-content-center border border-1 border-primary text-dark rounded-1-2 card overflow-hidden"
                                  >
                                    <div
                                      class="symbol symbol-circle symbol-25px overflow-hidden"
                                    >
                                      <span class="symbol-label">
                                        <i
                                          class="bi bi-phone-vibrate fw-bold text-primary"
                                        ></i>
                                      </span>
                                    </div>
                                    <label
                                      class="form-label fs-8 text-no-wrap overflow-hidden"
                                      >Mobile Money</label
                                    >
                                    <input
                                      type="number"
                                      class="form-control form-control-sm form-control-solid"
                                      placeholder=""
                                      @input="RecaputulatifInput($event, 'mobile')"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-group gap-1">
                    <div class="card m-1">
                      <div
                        class="btn btn-sm fw-bold btn-primary d-block mb-1"
                        @click="factureGenerator('pause')"
                      >
                        <i class="bi bi-pause-circle"></i>
                        Pause
                      </div>
                      <div
                        class="btn btn-sm fw-bold btn-primary d-block mb-1"
                        @click="factureGenerator('diplicata')"
                      >
                        <i class="bi bi-printer"></i>
                        Diplicata
                      </div>
                      <div
                        class="btn btn-sm fw-bold btn-primary d-block"
                        @click="factureGenerator('proforma')"
                      >
                        <i class="bi bi-file-earmark-word"></i>

                        Proforma
                      </div>
                    </div>
                    <div class="card m-1">
                      <div
                        class="btn btn-sm fw-bold btn-primary d-block mb-1"
                        @click="factureGenerator('credit')"
                      >
                        <i class="bi-alarm"></i>
                        Credit
                      </div>
                      <div
                        class="btn btn-sm fw-bold btn-primary d-block flex-grow-1 fs-2"
                        type="button"
                        @click="factureGenerator('cash')"
                      >
                        <i class="bi bi-cash-coin fs-2"></i>
                        Cash
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <modal-component
          id="product-modal"
          positionModal="center modal-fullscreen p-5 p-lg-10"
          :form="product"
          @cancel-btn="cancelBtn"
          @instance-modal="createProduct"
          activeBtn="false"
        >
          <template #title>Création d'un produit</template>
          <template>
            <productStore
              ref="updateModalStore"
              :is-modal="true"
              @callback="CloseModal"
              :form2="data.value ? product.value : form2"
            />
          </template>
          <template #footer>
            <div class="modal-footer">
              <div class="row col-12 p-0 m-0">
                <!-- code -->
                <div class="d-flex flex-row justify-content-end">
                  <button
                    id="annuler"
                    type="reset"
                    @click="annuler"
                    class="btn btn-light me-3"
                    data-kt-users-modal-action="cancel"
                    data-bs-dismiss="modal"
                  >
                    Annuler
                  </button>

                  <button type="submit" @click="submitData" class="btn btn-primary">
                    <span class="indicator-label">Envoyer </span>
                  </button>
                </div>
              </div>
            </div>
          </template>
        </modal-component>

        <modal-component
          :positionModal="`center mw-750px`"
          :form="formCustomer"
          :id="'choice-customer-modal'"
          activeBtn="false"
          :formInput="'ok'"
          @cancel-btn="cancelBtn"
        >
          <template #title>Selectionner un client </template>
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
                    :class="`ps-13 form-control form-control-lg form-control-solid`"
                    :placeholder="`chercher un client`"
                  />
                </div>
              </div>
              <div
                @click="addCustomerNew"
                class="btn btn-icon btn-circle btn-light-primary mx-1"
              >
                <i class="ki-duotone ki-plus fs-2"></i>
              </div>
            </div>
            <div>
              <!-- drageur -->

              <!-- list -->
              <div class="card-body py-4 px-5">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5"
                  id="kt_table_usersxx2"
                >
                  <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                      <th class="min-w-180px">Liste de Clients</th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                    </tr>
                  </thead>

                  <tbody class="fw-bold text-gray-600">
                    <template v-for="customer in customerFilter" :key="customer.id">
                      <tr class="w-100">
                        <td class="">
                          <label class="d-flex flex-stack mb-1 cursor-pointer">
                            <span class="d-flex align-items-center me-2">
                              <span class="symbol symbol-50px me-6">
                                <span class="symbol-label bg-light-primary">
                                  <i class="ki-duotone ki-user fs-1 text-primary"
                                    ><span class="path1"></span><span class="path2"></span
                                  ></i>
                                </span>
                              </span>

                              <span class="d-flex flex-column">
                                <span class="fw-bold fs-6">{{
                                  customer.customerName
                                }}</span>

                                <span class="fs-7 text-muted"
                                  >{{ customer.mail }}/{{ customer.type }}
                                </span>
                              </span>
                            </span>

                            <span class="form-check form-check-custom form-check-solid">
                              <input
                                @change="getChoice('customer', customer)"
                                name="radioBtn"
                                :class="`form-check-input customer_${customer.id}`"
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
          id="customer-modal"
          :positionModal="`center mw-650px`"
          :form="formCustomer"
          :isCss="true"
          @instance-modal="createCustomer"
          activeBtn="false"
        >
          <template #title>
            {{
              editing == true
                ? `Modification du ${formCustomer.customerName}`
                : "Ajout d'un client"
            }}
          </template>
          <template #body>
            <div class="mx-5 mt-5">
              <div class="row">
                <div class="mb-2 fv-row col-md-6">
                  <label class="required form-label">Nom du client</label>

                  <input
                    type="text"
                    v-model="formCustomer.customerName"
                    class="form-control mb-2"
                    placeholder=""
                  />
                </div>
                <div class="mb-2 col-md-6 fv-row">
                  <label class="required form-label">Type de client</label>

                  <div class="">
                    <select
                      id="selectType"
                      class="form-select form-select-solid fw-bold"
                      data-placeholder="Selectionner un type"
                      data-hide-search="true"
                      data-control="select2"
                      data-dropdown-css-class="w-230px"
                    >
                      <option></option>
                      <option value="physique" selected>Physique</option>
                      <option value="morale">Morale</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="mb-2 col-md-6 fv-row">
                  <label class="required form-label">Sexe</label>

                  <div class="">
                    <select
                      id="selectSexe"
                      class="form-select form-select-solid fw-bold"
                      data-placeholder="Selectionner un status"
                      data-hide-search="true"
                      data-control="select2"
                      data-dropdown-css-class="w-230px"
                    >
                      <option></option>
                      <option value="masculin">Masculin</option>
                      <option value="feminin">Feminin</option>
                    </select>
                  </div>
                </div>
                <div class="mb-2 col-md-6 fv-row">
                  <label class="required form-label">Statut matrimoniale</label>

                  <div class="">
                    <select
                      id="selectStatus"
                      class="form-select form-select-solid fw-bold"
                      data-placeholder="Selectionner un type"
                      data-hide-search="true"
                      data-control="select2"
                      data-dropdown-css-class="w-230px"
                    >
                      <option></option>
                      <option value="celibataire">Celibataire</option>
                      <option value="marie">Marie</option>
                      <option value="veuf">Veuf(ve)</option>
                      <option value="divorce">Divorce</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="mb-2 col-md-6 fv-row pt-5">
                  <label class="required form-label">Telephone</label>

                  <input
                    type="text"
                    v-model="formCustomer.phone"
                    class="form-control mb-2"
                    placeholder=""
                  />
                </div>
                <div class="mb-2 col-md-6 fv-row pt-5">
                  <label class="required form-label">Email</label>

                  <input
                    type="text"
                    v-model="formCustomer.mail"
                    class="form-control mb-2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="row">
                <div class="mb-2 col-md-6 fv-row pt-5">
                  <label class="required form-label">Employer</label>

                  <input
                    type="text"
                    v-model="formCustomer.employer"
                    class="form-control mb-2"
                    placeholder=""
                  />
                </div>
                <div class="mb-2 col-md-6 fv-row pt-5">
                  <label class="required form-label">Autre contact</label>

                  <input
                    type="text"
                    v-model="formCustomer.other_contact"
                    class="form-control mb-2"
                    placeholder=""
                  />
                </div>
              </div>
              <div class="mb-2 fv-row">
                <label class="required form-label">Adresse</label>

                <textarea
                  v-model="formCustomer.adress"
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control"
                ></textarea>
              </div>
            </div>
          </template>
          <template #footer>
            <div class="modal-footer">
              <div class="row col-12 p-0 m-0">
                <!-- code -->
                <div class="d-flex flex-row justify-content-end">
                  <button
                    id="annuler"
                    type="reset"
                    @click="annuler"
                    class="btn btn-light me-3"
                    data-kt-users-modal-action="cancel"
                    data-bs-dismiss="modal"
                  >
                    Annuler
                  </button>

                  <button type="button" @click="createCustomer" class="btn btn-primary">
                    <span class="indicator-label">Envoyer </span>
                  </button>
                </div>
              </div>
            </div>
          </template>
        </modal-component>

        <modal-component
          :positionModal="`center mw-750px`"
          :form="formCustomer"
          :id="'choice-table-modal'"
          activeBtn="false"
          :formInput="'deux'"
          @cancel-btn="cancelBtn"
        >
          <template #title>Selectionner une table </template>
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
                    :class="`ps-13 form-control form-control-lg form-control-solid`"
                    :placeholder="`chercher une table`"
                  />
                </div>
              </div>
              <div
                @click="addTableNew"
                class="btn btn-icon btn-circle btn-light-primary mx-1"
              >
                <i class="ki-duotone ki-plus fs-2"></i>
              </div>
            </div>
            <div>
              <!-- drageur -->

              <!-- list -->
              <div class="card-body py-4 px-5">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5"
                  id="kt_table_usersxx2"
                >
                  <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                      <th class="min-w-180px">Liste de tables</th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                    </tr>
                  </thead>

                  <tbody class="fw-bold text-gray-600">
                    <template v-for="table in tableFilter" :key="table.id">
                      <tr class="w-100">
                        <td class="">
                          <label class="d-flex flex-stack mb-1 cursor-pointer">
                            <span class="d-flex align-items-center me-2">
                              <span class="symbol symbol-50px me-6">
                                <span class="symbol-label bg-light-primary">
                                  <i class="ki-duotone ki-user fs-1 text-primary"
                                    ><span class="path1"></span><span class="path2"></span
                                  ></i>
                                </span>
                              </span>

                              <span class="d-flex flex-column">
                                <span class="fw-bold fs-6">{{ table.name }}</span>

                                <span class="fs-7 text-muted"
                                  >{{ table.description }}
                                </span>
                              </span>
                            </span>

                            <span class="form-check form-check-custom form-check-solid">
                              <input
                                @change="getChoice('table', table)"
                                name="radioBtn"
                                :class="`form-check-input table_${table.id}`"
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
          id="table-modal"
          :positionModal="`center mw-650px`"
          :form="formCustomer"
          :isCss="true"
          activeBtn="false"
          @instance-modal="createTable"
        >
          <template #title>
            {{ "Ajout d'une table" }}
          </template>
          <template #body>
            <div class="mx-5 mt-5">
              <div class="row">
                <div class="mb-2 fv-row">
                  <label class="required form-label">Nom de la table</label>

                  <input
                    type="text"
                    v-model="formTable.name"
                    class="form-control mb-2"
                    placeholder=""
                  />
                </div>
              </div>

              <div class="mb-2 fv-row">
                <label class="required form-label">Description</label>

                <textarea
                  v-model="formTable.description"
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control"
                ></textarea>
              </div>
            </div>
          </template>
          <template #footer>
            <div class="modal-footer">
              <div class="row col-12 p-0 m-0">
                <!-- code -->
                <div class="d-flex flex-row justify-content-end">
                  <button
                    id="annuler"
                    type="reset"
                    @click="annuler"
                    class="btn btn-light me-3"
                    data-kt-users-modal-action="cancel"
                    data-bs-dismiss="modal"
                  >
                    Annuler
                  </button>

                  <button type="button" @click="createTable" class="btn btn-primary">
                    <span class="indicator-label">Envoyer </span>
                  </button>
                </div>
              </div>
            </div>
          </template>
        </modal-component>
        <modal-component
          :positionModal="`center mw-750px`"
          :form="formCustomer"
          :id="'choice-server-modal'"
          activeBtn="false"
          :formInput="'deux'"
          @cancel-btn="cancelBtn"
        >
          <template #title>Selectionner un serveur </template>
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
                    :class="`ps-13 form-control form-control-lg form-control-solid`"
                    :placeholder="`chercher un serveur`"
                  />
                </div>
              </div>
              <div
                @click="addServerNew"
                class="btn btn-icon btn-circle btn-light-primary mx-1"
              >
                <i class="ki-duotone ki-plus fs-2"></i>
              </div>
            </div>
            <div>
              <!-- drageur -->

              <!-- list -->
              <div class="card-body py-4 px-5">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5"
                  id="kt_table_usersxx2"
                >
                  <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                      <th class="min-w-180px">Liste de serveurs</th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                      <th class="d-none"></th>
                    </tr>
                  </thead>

                  <tbody class="fw-bold text-gray-600">
                    <template v-for="server in serverFilter" :key="server.id">
                      <tr class="w-100">
                        <td class="">
                          <label class="d-flex flex-stack mb-1 cursor-pointer">
                            <span class="d-flex align-items-center me-2">
                              <span class="symbol symbol-50px me-6">
                                <span class="symbol-label bg-light-primary">
                                  <i class="ki-duotone ki-user fs-1 text-primary"
                                    ><span class="path1"></span><span class="path2"></span
                                  ></i>
                                </span>
                              </span>

                              <span class="d-flex flex-column">
                                <span class="fw-bold fs-6">{{ server.name }}</span>

                                <span class="fs-7 text-muted"
                                  >{{ server.phone }} / {{ server.email }}
                                </span>
                              </span>
                            </span>

                            <span class="form-check form-check-custom form-check-solid">
                              <input
                                @change="getChoice('server', server)"
                                name="radioBtn"
                                :class="`form-check-input server_${server.id}`"
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
          id="server-modal"
          :positionModal="`center mw-650px`"
          :form="formCustomer"
          :isCss="true"
          activeBtn="false"
          @instance-modal="createServer"
        >
          <template #title>
            {{ "Ajout d'un serveur" }}
          </template>
          <template #body>
            <div class="d-flex flex-column scroll-y px-5 px-lg-10">
              <div class="fv-row mb-7">
                <label class="d-block fw-semibold fs-6 mb-5">Photo</label>

                <div
                  class="image-input image-input-outline image-input-placeholder"
                  data-kt-image-input="true"
                >
                  <div
                    class="image-input-wrapper w-125px h-125px"
                    style="background-image: url('')"
                  ></div>

                  <label
                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change"
                    data-bs-toggle="tooltip"
                    aria-label="Change avatar"
                    data-bs-original-title="Change avatar"
                    data-kt-initialized="1"
                  >
                    <i class="ki-duotone ki-pencil fs-7"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>

                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="avatar_remove" />
                  </label>

                  <span
                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel"
                    data-bs-toggle="tooltip"
                    aria-label="Cancel avatar"
                    data-bs-original-title="Cancel avatar"
                    data-kt-initialized="1"
                  >
                    <i class="ki-duotone ki-cross fs-2"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                  </span>

                  <span
                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove"
                    data-bs-toggle="tooltip"
                    aria-label="Remove avatar"
                    data-bs-original-title="Remove avatar"
                    data-kt-initialized="1"
                  >
                    <i class="ki-duotone ki-cross fs-2"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                  </span>
                </div>

                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
              </div>

              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="required fw-semibold fs-6 mb-2">Nom</label>

                <input
                  type="text"
                  v-model="formServer.name"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="name"
                />

                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="required fw-semibold fs-6 mb-2">Description</label>
                <textarea
                  v-model="formServer.description"
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                ></textarea>

                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="required fw-semibold fs-6 mb-2">Telephone</label>

                <input
                  type="tel"
                  v-model="formServer.phone"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                />

                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="fv-row mb-7 fv-plugins-icon-container">
                <label class="required fw-semibold fs-6 mb-2">Email</label>

                <input
                  type="email"
                  v-model="formServer.email"
                  class="form-control form-control-solid mb-3 mb-lg-0"
                  placeholder="example@domain.com"
                />

                <div
                  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"
                ></div>
              </div>
              <div class="mb-2 fv-row">
                <label class="required form-label">Adresse</label>

                <textarea
                  v-model="formServer.adress"
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control"
                ></textarea>
              </div>
            </div>
          </template>
          <template #footer>
            <div class="modal-footer">
              <div class="row col-12 p-0 m-0">
                <!-- code -->
                <div class="d-flex flex-row justify-content-end">
                  <button
                    id="annuler"
                    type="reset"
                    @click="annuler"
                    class="btn btn-light me-3"
                    data-kt-users-modal-action="cancel"
                    data-bs-dismiss="modal"
                  >
                    Annuler
                  </button>

                  <button type="button" @click="createServer" class="btn btn-primary">
                    <span class="indicator-label">Envoyer </span>
                  </button>
                </div>
              </div>
            </div>
          </template>
        </modal-component>
      </div>
    </div>
  </div>
</template>

<style>
.image-input-placeholder {
  background-image: url("~/assets/bl-img.svg");
}

[data-bs-theme="dark"] .image-input-placeholder {
  background-image: url("~/assets/bl-img-dark.svg");
}
</style>
<script>
import { onMounted, reactive, ref } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import productStore from "../products/productStore.vue";
import sideBar from "./sideBar.vue";
import useCategories from "../../services/categorieservices.js";
import useProducts from "../../services/productservices.js";
import AppBarFacturation from "./AppBarFacturation.vue";
import useTable from "../../services/tableservices.js";
import useServer from "../../services/serverservices.js";
import navLinkComponent from "../../components/navLinkComponent.vue";
import useCustomer from "../../services/customerservices";
import { notifications } from "../../notifications/notifications";
export default {
  components: {
    modalComponent,
    productStore,
    AppBarFacturation,
    sideBar,
    navLinkComponent,
  },
  setup() {
    onMounted(async () => {
      await callBackMounted();
    });
    const productStoreCallback = () => {
      //   alert(123);
    };
    const { swal } = notifications();
    const { customers, getCustomers, storeCustomer, removeCustomer } = useCustomer();
    const product = reactive({});
    const productFitler = ref([]);
    const cancelBtn = () => {};
    const form2 = reactive({
      id: null,
      name: "",
      description: "",
      codebar: "",
      code_manuel: "",
      images: [],
      point: 0,
      nbrgros: 0,
      bonus_applicable: false,
      has_vat: false,
      user_id: 1,
      enterprise_id: 1,
      category_id: "",
      uuid: null,
      uom_id: null,
      type: 1,
      pricing: [],
      available_qte: 0,
    });

    const formTable = reactive({
      id: null,
      name: null,
      description: null,
      user_id: null,
      enterprise_id: null,
    });
    const formServer = reactive({
      id: null,
      name: null,
      description: null,
      photo: null,
      phone: null,
      email: null,
      address: null,
      user_id: null,
      enterprise_id: null,
    });
    const { getCategories, categories } = useCategories();
    const { getProducts, products, getProductsStore, productStores } = useProducts();
    const { getTable, tables, storeTable } = useTable();
    const { getServer, servers, storeServer } = useServer();
    async function callBackMounted() {
      await getCategories();
      await getProductsStore(depositDefault.id);
      productFitler.value = productStores.value;
      await getCustomers();
      await getTable();
      await getServer();
      tableFilter.value = tables.value;
      serverFilter.value = servers.value;
      customerFilter.value = customers.value;
      const fabAppSidebarToggle = document.getElementById("kt_app_body");
      fabAppSidebarToggle.setAttribute("data-kt-app-sidebar-minimize", "on");
    }
    const addProduct = () => {
      $("#product-modal").modal("show");
    };
    const updateModalStore = ref(null);
    const createProduct = async () => {
      updateModalStore.value.createProduct();
      await getProducts();
    };
    const updateProduct = async () => {
      await callBackMounted();
    };
    const form = reactive({
      type_facture: "proforma",
      customer_id: null,
      total: 1,
      money_id: 1,
      amount_paid: 0,
      payment_mode: "cash",
      discount: 0,
      vat_amount: 0,
      enterprise_id: 1,
      servant_id: null,
      note: null,
      table_id: null,
      details: [
        {
          service_id: 1,
          quantity: 1,
          pos_id: 1,
          price: 1,
        },
      ],
    });

    const choices = ref([]);
    const storeChoice = (service) => {
      let pos_id = 1;
      let price = 100;
      choices.value.push({
        service: service,
        service_id: service.id,
        quantity: 1,
        pos_id: pos_id,
        price: price,
      });
    };
    const ClearAll = () => {
      choices.value = [];
    };
    const addCard = (data) => {
      const price = data.prices.filter((price) => {
        return price.principal == 1;
      });

      if (
        choices.value.filter((product) => {
          return product.product.id == data.id;
        }).length == 0
      ) {
        choices.value.push({
          product: data,
          quantity: 1,
          available_qte: data.available_qte,
          priceDefault: price.length > 0 ? price[0].price : 0,
          subTotal: price.length > 0 ? price[0].price : 0,
          money: price.length > 0 ? price[0].abreviation : " USD",
        });
      } else {
        increase(
          choices.value.filter((product) => {
            return product.product.id == data.id;
          })[0]
        );
      }

      Bills();
    };
    const bills = ref({
      total: 0,
      reduct: 0,
      subTotal: 0,
      taxe: 0,
      amount_paid: 0,
      money: "USD",
      totalHt: 0,
    });
    const Bills = () => {
      bills.value.subTotal = 0;
      bills.value.taxe = 0;
      for (let index = 0; index < choices.value.length; index++) {
        bills.value.subTotal += choices.value[index].subTotal;
      }
      bills.value.taxe = (form.vat_amount * bills.value.subTotal) / 100;
      bills.value.reduct = (form.discount * bills.value.subTotal) / 100;

      bills.value.total = bills.value.subTotal + bills.value.taxe - bills.value.reduct;
      //   bills.value.subTotal = choices.value[0].subTotal;
    };
    const InputCreasing = (e, product) => {
      if (product.quantity > 1) {
        let quantityBefore = product.quantity;
        product.subTotal = (product.subTotal / quantityBefore) * product.quantity;
        Bills();
      }
    };
    const decrease = (product) => {
      if (product.quantity > 1) {
        let quantityBefore = product.quantity;
        product.quantity -= 1;
        product.subTotal = (product.subTotal / quantityBefore) * product.quantity;
        Bills();
      }
    };

    const increase = (product) => {
      console.log(product.available_qte);
      if (product.quantity < product.available_qte) {
        let quantityBefore = product.quantity;
        product.quantity += 1;
        product.subTotal = (product.subTotal / quantityBefore) * product.quantity;
        Bills();
      }
    };
    const defaultDeposit = async (data) => {
      for (const [key, value] of Object.entries(data)) {
        depositDefault[key] = value;
      }
      await callBackMounted();
    };
    const depositDefault = reactive({});
    const deleteElementToCard = (choice) => {
      choices.value = choices.value.filter(
        (choix) => choix.product.id != choice.product.id
      );
      Bills();
    };
    const InputChange = (event, product) => {
      if (product.quantity < product.available_qte) {
        let quantityBefore = product.quantity;

        if (parseInt(event.target.value) >= 0) {
          product.quantity = parseInt(event.target.value);
          product.subTotal = (product.subTotal / quantityBefore) * product.quantity;
          Bills();
        }
      }
    };
    const customer = reactive({});
    const table = reactive({});
    const server = reactive({});
    const handleStatus = (event) => {
      formCustomer.marital_status = event.target.value;
    };
    const handleSexe = (event) => {
      forformCustomerm.sex = event.target.value;
    };
    const handleType = (event) => {
      formCustomer.type = event.target.value;
    };
    const editing = ref(true);
    const createCustomer = async () => {
      //   console.log({ ...form });
      console.log("###########");

      $("#selectStatus").on("change", handleStatus);
      $("#selectSexe").on("change", handleSexe);
      $("#selectType").on("change", handleType);
      await storeCustomer({ ...formCustomer });
      await getCustomers();
      customerFilter.value = customers.value;
      //   dataCreated();
      editing.value = false;
      $("#customer-modal").modal("hide");
      const customerAll = [];
      customerAll.values = customers.value;
      let data = customerAll.value.pop();
      for (const [key, value] of Object.entries(data)) {
        defaultCustomer[key] = value;
      }
      $("#choice-customer-modal").modal("hide");
    };
    const deleteCustomer = async (customerId) => {
      await removeCustomer(customerId);
      await getCustomers();
    };
    const defaultCustomer = reactive({});
    const getChoice = (type = null, data = null) => {
      if (type == "customer") {
        for (const [key, value] of Object.entries(data)) {
          defaultCustomer[key] = value;
        }
        form.customer_id = defaultCustomer.id;
      }
      if (type == "table") {
        for (const [key, value] of Object.entries(data)) {
          defaultTable[key] = value;
        }
        form.table_id = defaultTable.id;
      }
      if (type == "server") {
        for (const [key, value] of Object.entries(data)) {
          defaultServer[key] = value;
        }
        form.servant_id = defaultServer.id;
      }
      $("#choice-customer-modal").modal("hide");
      $("#choice-table-modal").modal("hide");
      $("#choice-server-modal").modal("hide");
    };
    const customerFilter = ref([]);
    const tableFilter = ref([]);
    const serverFilter = ref([]);
    const addCustomer = () => {
      $("#choice-customer-modal").modal("show");
    };
    const addCustomerNew = () => {
      $("#selectType").val("physique").trigger("change");
      for (const [key, value] of Object.entries(formCustomer)) {
        formCustomer[key] =
          typeof value == "string" ? "" : typeof value == "number" ? 0 : "";
      }
      formCustomer.type = "physique";
      $("#customer-modal").modal("show");
    };
    const addTableNew = () => {
      $("#table-modal").modal("show");
    };
    const addTable = () => {
      $("#choice-table-modal").modal("show");
    };
    const createTable = async () => {
      await storeTable({ ...formTable });
      await getTable();
      tableFilter.value = tables.value;
      //   dataCreated();

      $("#table-modal").modal("hide");
      const tableAll = [];
      tableAll.values = tables.value;
      let data = tableAll.values.pop();
      for (const [key, value] of Object.entries(data)) {
        defaultTable[key] = value;
      }
      $("#choice-table-modal").modal("hide");
    };
    const addServerNew = () => {
      $("#server-modal").modal("show");
    };
    const addServer = () => {
      $("#choice-server-modal").modal("show");
    };
    const createServer = async () => {
      await storeServer({ ...formServer });
      await getServer();
      serverFilter.value = servers.value;
      //   dataCreated();

      $("#server-modal").modal("hide");
      const serverAll = [];
      serverAll.values = servers.value;
      let data = serverAll.values.pop();
      for (const [key, value] of Object.entries(data)) {
        defaultServer[key] = value;
      }
      $("#choice-server-modal").modal("hide");
    };
    const defaultServer = reactive({});
    const defaultTable = reactive({});
    const formCustomer = reactive({
      id: null,
      pos_id: null,
      created_by_id: null,
      category_id: null,
      customerName: null,
      marital_status: null,
      other_contact: null,
      adress: null,
      phone: null,
      mail: null,
      employer: null,
      type: "physique",
      sex: null,
      enterprise_id: null,
    });
    const RecaputulatifInput = (event, type) => {
      if (parseInt(event.target.value) >= 0) {
        if (type === "tva") {
          form.vat_amount = event.target.value;
        }
        if (type == "reduction") {
          form.discount = event.target.value;
        }
        if (type == "espece") {
          form.amount_paid += event.target.value;
        }
        if ((type = "banque")) {
          form.amount_paid += event.target.value;
        }
        if ((type = "mobile")) {
          form.amount_paid += event.target.value;
        }
        addPayement(type);
        Bills();
      } else {
        if (type === "tva") {
          form.vat_amount = 0;
        }
        if (type == "reduction") {
          form.discount = 0;
        }
      }
    };
    function addPayement(method) {
      if (form.payment_mode.includes(method)) {
        return;
      } else {
        if (form.payment_mode !== "") {
          form.payment_mode += `, ${method}`;
        } else {
          const premiereLettre = method.charAt(0);

          const premiereLettreMajuscule = premiereLettre.toUpperCase();

          const chaineMajuscule = premiereLettreMajuscule + method.slice(1);
          form.payment_mode = `${chaineMajuscule}`;
        }
      }
    }
    const factureGenerator = (type) => {
      form.type_facture = type;
      if (type == "credit") {
        if (form.customer_id != null) {
          // code de traitement
        } else {
          alertBtn("client");
        }
      }
    };

    const alertBtn = () => {
      swal(
        "question",
        "Question",
        "Veuillez choisir le client",
        "Continuer",
        "Annuler",
        () => {
          addCustomer();
        },
        () => {},
        "",
        "btn-danger"
      );
    };
    return {
      factureGenerator,
      RecaputulatifInput,
      form,
      defaultTable,
      defaultServer,
      tableFilter,
      serverFilter,
      formServer,
      createServer,
      formTable,
      createTable,
      addTableNew,
      addServerNew,
      addTable,
      addServer,
      addCustomerNew,
      defaultCustomer,
      customerFilter,
      getChoice,
      customers,
      createCustomer,
      formCustomer,
      addCustomer,
      addTable,
      addServer,
      customer,
      table,
      server,
      bills,
      InputChange,
      deleteElementToCard,
      depositDefault,
      defaultDeposit,
      addCard,
      decrease,
      increase,
      InputCreasing,
      storeChoice,
      choices,
      updateProduct,
      updateModalStore,
      createProduct,
      categories,
      products,
      product,
      productFitler,
      form2,
      cancelBtn,
      addProduct,
      productStoreCallback,
      //   facturation,
    };
  },
};
</script>
