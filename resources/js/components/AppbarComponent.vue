<template>
  <div>
    <div id="kt_app_header" class="app-header">
      <div
        class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container"
      >
        <div
          class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2"
          title="Show sidebar menu"
        >
          <div
            class="btn btn-icon btn-active-color-primary w-35px h-35px"
            id="kt_app_sidebar_mobile_toggle"
          >
            <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1"
              ><span class="path1"></span><span class="path2"></span
            ></i>
          </div>
        </div>

        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
          <a href="#" class="d-lg-none">
            <img alt="Logo" src="assets/logo.png" class="h-30px" />
          </a>
        </div>

        <div
          class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
          id="kt_app_header_wrapper"
        >
          <div
            class="app-header-menu app-header-mobile-drawer align-items-stretch"
            data-kt-drawer="true"
            data-kt-drawer-name="app-header-menu"
            data-kt-drawer-activate="{default: true, lg: false}"
            data-kt-drawer-overlay="true"
            data-kt-drawer-width="250px"
            data-kt-drawer-direction="end"
            data-kt-drawer-toggle="#kt_app_header_menu_toggle"
            data-kt-swapper="true"
            data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
            data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}"
          >
            <div
              class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
              id="kt_app_header_menu"
              data-kt-menu="true"
            >
              <div
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="bottom-start"
                class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2"
              >
                <span class="menu-link"
                  ><span class="menu-title">Dashboards</span
                  ><span class="menu-arrow d-lg-none"></span
                ></span>

                <div
                  class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px"
                >
                  <div
                    class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible"
                    data-kt-menu-dismiss="true"
                  >
                    <div class="row">
                      <div
                        class="col-lg-8 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6"
                      >
                        <div class="row">
                          <div class="col-lg-6 mb-3">
                            <div class="menu-item p-0 m-0">
                              <a href="#" class="menu-link">
                                <span
                                  class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                                >
                                  <i
                                    class="ki-duotone ki-element-11 text-primary fs-1"
                                    ><span class="path1"></span
                                    ><span class="path2"></span
                                    ><span class="path3"></span
                                    ><span class="path4"></span
                                  ></i>
                                </span>

                                <span class="d-flex flex-column">
                                  <span class="fs-6 fw-bold text-gray-800"
                                    >Defaut</span
                                  >
                                  <span class="fs-7 fw-semibold text-muted"
                                    >Rapport et statistiques</span
                                  >
                                </span>
                              </a>
                            </div>
                          </div>

                          <div class="col-lg-6 mb-3">
                            <div class="menu-item p-0 m-0">
                              <a href="#" class="menu-link active">
                                <span
                                  class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                                >
                                  <i
                                    class="ki-duotone ki-basket text-danger fs-1"
                                    ><span class="path1"></span
                                    ><span class="path2"></span
                                    ><span class="path3"></span
                                    ><span class="path4"></span
                                  ></i>
                                </span>

                                <span class="d-flex flex-column">
                                  <span class="fs-6 fw-bold text-gray-800"
                                    >Statistiques</span
                                  >
                                  <span class="fs-7 fw-semibold text-muted"
                                    >Rapports de ventes</span
                                  >
                                </span>
                              </a>
                            </div>
                          </div>

                          <div class="col-lg-6 mb-3">
                            <div class="menu-item p-0 m-0">
                              <a href="#" class="menu-link">
                                <span
                                  class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                                >
                                  <i
                                    class="ki-duotone ki-color-swatch text-success fs-1"
                                    ><span class="path1"></span
                                    ><span class="path2"></span
                                    ><span class="path3"></span
                                    ><span class="path4"></span
                                    ><span class="path5"></span
                                    ><span class="path6"></span
                                    ><span class="path7"></span
                                    ><span class="path8"></span
                                    ><span class="path9"></span
                                    ><span class="path10"></span
                                    ><span class="path11"></span
                                    ><span class="path12"></span
                                    ><span class="path13"></span
                                    ><span class="path14"></span
                                    ><span class="path15"></span
                                    ><span class="path16"></span
                                    ><span class="path17"></span
                                    ><span class="path18"></span
                                    ><span class="path19"></span
                                    ><span class="path20"></span
                                    ><span class="path21"></span
                                  ></i>
                                </span>

                                <span class="d-flex flex-column">
                                  <span class="fs-6 fw-bold text-gray-800"
                                    >Rapport de ventes</span
                                  >
                                  <span class="fs-7 fw-semibold text-muted"
                                    >Evolution de ventes</span
                                  >
                                </span>
                              </a>
                            </div>
                          </div>

                          <div class="col-lg-6 mb-3">
                            <div class="menu-item p-0 m-0">
                              <a href="#" class="menu-link">
                                <span
                                  class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                                >
                                  <i
                                    class="ki-duotone ki-chart-simple text-dark fs-1"
                                    ><span class="path1"></span
                                    ><span class="path2"></span
                                    ><span class="path3"></span
                                    ><span class="path4"></span
                                  ></i>
                                </span>

                                <span class="d-flex flex-column">
                                  <span class="fs-6 fw-bold text-gray-800"
                                    >Marketing de ventes</span
                                  >
                                  <span class="fs-7 fw-semibold text-muted"
                                    >Conversion</span
                                  >
                                </span>
                              </a>
                            </div>
                          </div>

                          <div class="col-lg-6 mb-3">
                            <div class="menu-item p-0 m-0">
                              <a href="#" class="menu-link">
                                <span
                                  class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                                >
                                  <i
                                    class="ki-duotone ki-abstract-42 text-danger fs-1"
                                  >
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                  </i>
                                </span>

                                <span class="d-flex flex-column">
                                  <span class="fs-6 fw-bold text-gray-800"
                                    >POS Systeme</span
                                  >
                                  <span class="fs-7 fw-semibold text-muted"
                                    >Vente en utilisant le POS</span
                                  >
                                </span>
                              </a>
                            </div>
                          </div>

                          <div class="col-lg-6 mb-3">
                            <div class="menu-item p-0 m-0">
                              <a href="#" class="menu-link">
                                <span
                                  class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3"
                                >
                                  <i
                                    class="ki-duotone ki-call text-primary fs-1"
                                    ><span class="path1"></span
                                    ><span class="path2"></span
                                    ><span class="path3"></span
                                    ><span class="path4"></span
                                    ><span class="path5"></span
                                    ><span class="path6"></span
                                    ><span class="path7"></span
                                    ><span class="path8"></span
                                  ></i>
                                </span>

                                <span class="d-flex flex-column">
                                  <span class="fs-6 fw-bold text-gray-800"
                                    >Nos produits</span
                                  >
                                  <span class="fs-7 fw-semibold text-muted"
                                    >L'ensemble de nos produits</span
                                  >
                                </span>
                              </a>
                            </div>
                          </div>
                        </div>

                        <div class="separator separator-dashed mx-5 my-5"></div>

                        <div
                          class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-2 mx-5"
                        >
                          <div class="d-flex flex-column me-5">
                            <div class="fs-6 fw-bold text-gray-800">
                              Page pricipale du site
                            </div>
                            <div class="fs-7 fw-semibold text-muted">
                              Aller sur le site et explorer nos differents
                              offres
                            </div>
                          </div>

                          <a
                            href="{{ route('home')}}"
                            class="btn btn-sm btn-primary fw-bold"
                          >
                            Aller sur le site
                          </a>
                        </div>
                      </div>

                      <div
                        class="menu-more bg-light col-lg-4 py-3 px-3 py-lg-6 px-lg-6 rounded-end"
                      >
                        <h4
                          class="fs-6 fs-lg-4 text-gray-800 fw-bold mt-3 mb-3 ms-4"
                        >
                          Plus encore
                        </h4>

                        <div class="menu-item p-0 m-0">
                          <a href="#" class="menu-link py-2">
                            <span class="menu-title"> Logistique </span>
                          </a>
                        </div>

                        <div class="menu-item p-0 m-0">
                          <a href="#" class="menu-link py-2">
                            <span class="menu-title">Finances</span>
                          </a>
                        </div>

                        <div class="menu-item p-0 m-0">
                          <a href="#" class="menu-link py-2">
                            <span class="menu-title"> Analyse de stocks </span>
                          </a>
                        </div>

                        <div class="menu-item p-0 m-0">
                          <a href="#" class="menu-link py-2">
                            <span class="menu-title"> Livraison </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="bottom-start"
                class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2"
              >
                <span class="menu-link"
                  ><span class="menu-title">Utilitaires</span
                  ><span class="menu-arrow d-lg-none"></span
                ></span>

                <div
                  class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px"
                >
                  <div
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion"
                  >
                    <span class="menu-link"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-handcart fs-2"></i></span
                      ><span class="menu-title">Ventes</span
                      ><span class="menu-arrow"></span
                    ></span>

                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                    >
                      <div
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start"
                        class="menu-item menu-lg-down-accordion"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Catalogue</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div
                          class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                        >
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Produits</span></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Categories</span></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Ajouter un produit</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Editer un produit</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Ajouter une categorie</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Editer une categorie</span
                              ></a
                            >
                          </div>
                        </div>
                      </div>

                      <div
                        data-kt-menu-trigger="click"
                        class="menu-item menu-accordion menu-sub-indention"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Ventes</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div class="menu-sub menu-sub-accordion">
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Liste d'ordres</span></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Details des ordres</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Ajouter un ordre de vente</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Editer un ordre de vente</span
                              ></a
                            >
                          </div>
                        </div>
                      </div>

                      <div
                        data-kt-menu-trigger="click"
                        class="menu-item menu-accordion menu-sub-indention"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Clients</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div class="menu-sub menu-sub-accordion">
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Liste de clients</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Details du client</span
                              ></a
                            >
                          </div>
                        </div>
                      </div>

                      <div
                        data-kt-menu-trigger="click"
                        class="menu-item menu-accordion menu-sub-indention"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Rapports</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div class="menu-sub menu-sub-accordion">
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Vue sur les produits</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Ventes</span></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Retournes</span></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Ordres de clients</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Expeditions</span></a
                            >
                          </div>
                        </div>
                      </div>

                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Parametres</span></a
                        >
                      </div>
                    </div>
                  </div>

                  <div
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion"
                  >
                    <span class="menu-link"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-rocket fs-2"
                          ><span class="path1"></span
                          ><span class="path2"></span></i></span
                      ><span class="menu-title">Entreprises</span
                      ><span class="menu-arrow"></span
                    ></span>

                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                    >
                      <div class="menu-item">
                        <a class="menu-link" href="/admin/stepper"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title"
                            >Ajouter une entreprise</span
                          ></a
                        >
                      </div>

                      <div class="menu-item">
                        <a class="menu-link" href="/admin/enterprises"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Mes entreprises</span></a
                        >
                      </div>
                    </div>
                  </div>

                  <div
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion"
                  >
                    <span class="menu-link"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-shield-tick fs-2"
                          ><span class="path1"></span
                          ><span class="path2"></span></i></span
                      ><span class="menu-title">Gestion de l'equipe</span
                      ><span class="menu-arrow"></span
                    ></span>

                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                    >
                      <div
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start"
                        class="menu-item menu-lg-down-accordion"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Equipe</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div
                          class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                        >
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Liste de l'equipe</span
                              ></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Voir un membre</span></a
                            >
                          </div>
                        </div>
                      </div>

                      <div
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start"
                        class="menu-item menu-lg-down-accordion"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Roles</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div
                          class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                        >
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Liste de roles</span></a
                            >
                          </div>

                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title"
                                >Afficher les roles</span
                              ></a
                            >
                          </div>
                        </div>
                      </div>

                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Permissions</span></a
                        >
                      </div>
                    </div>
                  </div>

                  <div
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion"
                  >
                    <span class="menu-link"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-briefcase fs-2"
                          ><span class="path1"></span
                          ><span class="path2"></span></i></span
                      ><span class="menu-title">Clients</span
                      ><span class="menu-arrow"></span
                    ></span>

                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                    >
                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Liste de clients</span></a
                        >
                      </div>

                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Details de clients</span></a
                        >
                      </div>
                    </div>
                  </div>

                  <div
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion"
                  >
                    <span class="menu-link"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-basket fs-2"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span
                          ><span class="path4"></span></i></span
                      ><span class="menu-title">Mon subsciption</span
                      ><span class="menu-arrow"></span
                    ></span>

                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                    >
                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title"
                            >Changer de subscription</span
                          ></a
                        >
                      </div>

                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title"
                            >Changer mon sucription</span
                          ></a
                        >
                      </div>
                    </div>
                  </div>

                  <div
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-placement="right-start"
                    class="menu-item menu-lg-down-accordion"
                  >
                    <span class="menu-link"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-credit-cart fs-2"
                          ><span class="path1"></span
                          ><span class="path2"></span></i></span
                      ><span class="menu-title">Gestion de factures</span
                      ><span class="menu-arrow"></span
                    ></span>

                    <div
                      class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                    >
                      <div
                        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                        data-kt-menu-placement="right-start"
                        class="menu-item menu-lg-down-accordion"
                      >
                        <span class="menu-link"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Profiles</span
                          ><span class="menu-arrow"></span
                        ></span>

                        <div
                          class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px"
                        >
                          <div class="menu-item">
                            <a class="menu-link" href="#"
                              ><span class="menu-bullet"
                                ><span class="bullet bullet-dot"></span></span
                              ><span class="menu-title">Facture 1</span></a
                            >
                          </div>
                        </div>
                      </div>

                      <div class="menu-item">
                        <a class="menu-link" href="#"
                          ><span class="menu-bullet"
                            ><span class="bullet bullet-dot"></span></span
                          ><span class="menu-title">Creer une facture</span></a
                        >
                      </div>
                    </div>
                  </div>

                  <div class="menu-item">
                    <a class="menu-link" href="#"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-calendar-8 fs-2"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                          ><span class="path6"></span></i></span
                      ><span class="menu-title">Calendrier</span></a
                    >
                  </div>
                </div>
              </div>

              <div
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="bottom-start"
                class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2"
              >
                <span class="menu-link"
                  ><span class="menu-title">Aide</span
                  ><span class="menu-arrow d-lg-none"></span
                ></span>

                <div
                  class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px"
                >
                  <div class="menu-item">
                    <a
                      class="menu-link"
                      href="#"
                      target="_blank"
                      title="Essayer de lire notre documentation"
                      data-bs-toggle="tooltip"
                      data-bs-trigger="hover"
                      data-bs-dismiss="click"
                      data-bs-placement="right"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-abstract-26 fs-2"
                          ><span class="path1"></span
                          ><span class="path2"></span></i></span
                      ><span class="menu-title">Documentation</span></a
                    >
                  </div>

                  <div class="menu-item">
                    <a class="menu-link" href="#" target="_blank"
                      ><span class="menu-icon"
                        ><i class="ki-duotone ki-code fs-2"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span
                          ><span class="path4"></span></i></span
                      ><span class="menu-title">Abonnement Free</span></a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="app-navbar flex-shrink-0">
            <div class="app-navbar-item align-items-stretch ms-1 ms-md-3">
              <div
                id="kt_header_search"
                class="header-search d-flex align-items-stretch"
                data-kt-search-keypress="true"
                data-kt-search-min-length="2"
                data-kt-search-enter="enter"
                data-kt-search-layout="menu"
                data-kt-menu-trigger="auto"
                data-kt-menu-overflow="false"
                data-kt-menu-permanent="true"
                data-kt-menu-placement="bottom-end"
              >
                <div
                  class="d-flex align-items-center"
                  data-kt-search-element="toggle"
                  id="kt_header_search_toggle"
                >
                  <div
                    class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                  >
                    <i class="ki-duotone ki-magnifier fs-2 fs-lg-1"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="app-navbar-item ms-1 ms-md-3">
              <div
                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                id="kt_activities_toggle"
              >
                <i class="ki-duotone ki-notification-on fs-2 fs-lg-1"
                  ><span class="path1"></span><span class="path2"></span
                  ><span class="path3"></span><span class="path4"></span
                  ><span class="path5"></span
                ></i>
              </div>
            </div>

            <div class="app-navbar-item ms-1 ms-md-3">
              <div
                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative"
                id="kt_drawer_chat_toggle"
              >
                <i class="ki-duotone ki-message-text-2 fs-2 fs-lg-1"
                  ><span class="path1"></span><span class="path2"></span
                  ><span class="path3"></span
                ></i>
                <span
                  class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"
                >
                </span>
              </div>
            </div>
            <div class="app-navbar-item ms-1 ms-md-3">
              <div
                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end"
              >
                <i class="ki-duotone ki-element-11 fs-2 fs-lg-1"
                  ><span class="path1"></span><span class="path2"></span
                  ><span class="path3"></span><span class="path4"></span
                ></i>
              </div>

              <div
                class="menu menu-sub menu-sub-dropdown menu-column w-100 w-sm-350px"
                data-kt-menu="true"
              >
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Mes entreprises</div>

                    <div class="card-toolbar">
                      <button
                        type="button"
                        class="btn btn-sm btn-icon btn-active-light-primary me-n3"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="bottom-end"
                      >
                        <i class="ki-duotone ki-setting-3 fs-2"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span><span class="path4"></span
                          ><span class="path5"></span
                        ></i>
                      </button>

                      <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                        data-kt-menu="true"
                      >
                        <div class="menu-item px-3">
                          <div
                            class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase"
                          >
                            Entreprises
                          </div>
                        </div>

                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">
                            Creer une entreprise
                          </a>
                        </div>

                        <div class="menu-item px-3">
                          <a href="#" class="menu-link flex-stack px-3">
                            Mes entreprises

                            <span
                              class="ms-2"
                              data-bs-toggle="tooltip"
                              title="Specify a target name for future usage and reference"
                            >
                              <i class="ki-duotone ki-information fs-6"
                                ><span class="path1"></span
                                ><span class="path2"></span
                                ><span class="path3"></span
                              ></i>
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card-body py-5">
                    <div class="mh-450px scroll-y me-n5 pe-5">
                      <div class="row g-2">
                        <div class="col-6">
                          <a
                            href="#"
                            class="d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3"
                          >
                            <img
                              src="assets/favicon.ico"
                              class="w-25px h-25px mb-2"
                              alt=""
                            />
                            <span class="fw-semibold">Entreprise Name</span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="app-navbar-item ms-1 ms-md-3">
              <a
                href="#"
                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end"
              >
                <i class="ki-duotone ki-night-day theme-light-show fs-2 fs-lg-1"
                  ><span class="path1"></span><span class="path2"></span
                  ><span class="path3"></span><span class="path4"></span
                  ><span class="path5"></span><span class="path6"></span
                  ><span class="path7"></span><span class="path8"></span
                  ><span class="path9"></span><span class="path10"></span
                ></i>
                <i class="ki-duotone ki-moon theme-dark-show fs-2 fs-lg-1"
                  ><span class="path1"></span><span class="path2"></span></i
              ></a>

              <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                data-kt-menu="true"
                data-kt-element="theme-mode-menu"
              >
                <div class="menu-item px-3 my-0">
                  <a
                    href="#"
                    class="menu-link px-3 py-2"
                    data-kt-element="mode"
                    data-kt-value="light"
                  >
                    <span class="menu-icon" data-kt-element="icon">
                      <i class="ki-duotone ki-night-day fs-2"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span><span class="path4"></span
                        ><span class="path5"></span><span class="path6"></span
                        ><span class="path7"></span><span class="path8"></span
                        ><span class="path9"></span><span class="path10"></span
                      ></i>
                    </span>
                    <span class="menu-title"> Light </span>
                  </a>
                </div>

                <div class="menu-item px-3 my-0">
                  <a
                    href="#"
                    class="menu-link px-3 py-2"
                    data-kt-element="mode"
                    data-kt-value="dark"
                  >
                    <span class="menu-icon" data-kt-element="icon">
                      <i class="ki-duotone ki-moon fs-2"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                    </span>
                    <span class="menu-title"> Sombre </span>
                  </a>
                </div>

                <div class="menu-item px-3 my-0">
                  <a
                    href="#"
                    class="menu-link px-3 py-2"
                    data-kt-element="mode"
                    data-kt-value="system"
                  >
                    <span class="menu-icon" data-kt-element="icon">
                      <i class="ki-duotone ki-screen fs-2"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span><span class="path4"></span
                      ></i>
                    </span>
                    <span class="menu-title"> Systeme </span>
                  </a>
                </div>
              </div>
            </div>

            <div
              class="app-navbar-item ms-1 ms-md-3"
              id="kt_header_user_menu_toggle"
            >
              <div
                class="cursor-pointer symbol symbol-30px symbol-md-40px"
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end"
              >
                <img src="assets/media/avatars/300-1.jpg" alt="user" />
              </div>

              <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                data-kt-menu="true"
              >
                <div class="menu-item px-3">
                  <div class="menu-content d-flex align-items-center px-3">
                    <div class="symbol symbol-50px me-5">
                      <img alt="Logo" src="assets/media/avatars/300-1.jpg" />
                    </div>
                    <div class="d-flex flex-column">
                      <div class="fw-bold d-flex justify-content-between fs-5">
                        <span>Daniel KIKIMBA</span>
                        <span
                          class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"
                          >Free</span
                        >
                      </div>

                      <a
                        href="#"
                        class="fw-semibold text-muted text-hover-primary fs-7"
                      >
                        genesiskikimba@gmail.com
                      </a>
                    </div>
                  </div>
                </div>

                <div class="separator my-2"></div>

                <div class="menu-item px-5">
                  <a href="#" class="menu-link px-5"> Mon profile </a>
                </div>

                <div class="menu-item px-5">
                  <a href="#" class="menu-link px-5">
                    <span class="menu-text">Mes entreprises</span>
                    <span class="menu-badge">
                      <span
                        class="badge badge-light-danger badge-circle fw-bold fs-7"
                        >3</span
                      >
                    </span>
                  </a>
                </div>

                <div
                  class="menu-item px-5"
                  data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                  data-kt-menu-placement="left-start"
                  data-kt-menu-offset="-15px, 0"
                >
                  <a href="#" class="menu-link px-5">
                    <span class="menu-title">Mon abonnement</span>
                    <span class="menu-arrow"></span>
                  </a>

                  <div class="menu-sub menu-sub-dropdown w-175px py-4">
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-5">
                        Etat de mon abonnement
                      </a>
                    </div>

                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-5">
                        Payer un abonnement
                      </a>
                    </div>

                    <div class="separator my-2"></div>

                    <div class="menu-item px-3">
                      <div class="menu-content px-3">
                        <label
                          class="form-check form-switch form-check-custom form-check-solid"
                        >
                          <input
                            class="form-check-input w-30px h-20px"
                            type="checkbox"
                            value="1"
                            checked="checked"
                            name="notifications"
                          />
                          <span class="form-check-label text-muted fs-7">
                            Notifications
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="menu-item px-5 my-1">
                  <a href="#" class="menu-link px-5"> Parametre du compte </a>
                </div>

                <div class="separator my-2"></div>

                <div class="menu-item px-5">
                  <a
                    class="menu-link px-5"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                  >
                    <i class="las la-sign-out-alt"></i>Se deconnecter
                  </a>
                  <form
                    id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-none"
                  >
                    @csrf
                  </form>
                </div>
              </div>
            </div>

            <div
              class="app-navbar-item d-lg-none ms-2 me-n2"
              title="Show header menu"
            >
              <div
                class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                id="kt_app_header_menu_toggle"
              >
                <i class="ki-duotone ki-element-4 fs-1"
                  ><span class="path1"></span><span class="path2"></span
                ></i>
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
  props: ["data"],
  mounted() {},
};
</script>
