<template>
  <div>
    <div
      id="kt_app_sidebar"
      class="app-sidebar flex-column"
      data-kt-drawer="true"
      data-kt-drawer-name="app-sidebar"
      data-kt-drawer-activate="{default: true, lg: false}"
      data-kt-drawer-overlay="true"
      data-kt-drawer-width="225px"
      data-kt-drawer-direction="start"
      data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
    >
      <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="#">
          <logo-component />
        </a>

        <div
          id="kt_app_sidebar_toggle"
          class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
          data-kt-toggle="true"
          data-kt-toggle-state="active"
          data-kt-toggle-target="body"
          data-kt-toggle-name="app-sidebar-minimize"
        >
          <i class="ki-duotone ki-double-left fs-2 rotate-180 animation-slide-in-up"
            ><span class="path1"></span><span class="path2"></span
          ></i>
        </div>
      </div>

      <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div
          id="kt_app_sidebar_menu_wrapper"
          class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
          data-kt-scroll="true"
          data-kt-scroll-activate="true"
          data-kt-scroll-height="auto"
          data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
          data-kt-scroll-wrappers="#kt_app_sidebar_menu"
          data-kt-scroll-offset="5px"
          data-kt-scroll-save-state="true"
        >
          <!--begin::Menu-->
          <div
            class="menu menu-column menu-rounded menu-sub-indention px-3"
            id="#kt_app_sidebar_menu"
            data-kt-menu="true"
            data-kt-menu-expand="false"
          >
            <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-element-11 fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span></i></span
                ><span class="menu-title">Dashboards</span><span class="menu-arrow"></span
              ></span>

              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="/admin/home"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Defaut</span></a
                  >
                </div>

                <div class="menu-item">
                  <a class="menu-link" href="/admin/facturation/list"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Facturation</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.stocks.report')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Fiche de stocks</span></a
                  >
                </div>

                <div class="menu-item">
                  <a class="menu-link" href="#"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Rapport de ventes</span></a
                  >
                </div>

                <div
                  class="menu-inner flex-column collapse"
                  id="kt_app_sidebar_menu_dashboards_collapse"
                >
                  <div class="menu-item">
                    <a class="menu-link" href="/admin/pos/list/"
                      ><span class="menu-bullet"
                        ><span class="bullet bullet-dot"></span></span
                      ><span class="menu-title">POS System</span></a
                    >
                  </div>
                  <div class="menu-item">
                    <a class="menu-link" href="/admin/inventories"
                      ><span class="menu-bullet"
                        ><span class="bullet bullet-dot"></span></span
                      ><span class="menu-title">Inventaires</span></a
                    >
                  </div>
                  <div class="menu-item">
                    <a class="menu-link" href="{{ route('home')}}"
                      ><span class="menu-bullet"
                        ><span class="bullet bullet-dot"></span></span
                      ><span class="menu-title">site</span></a
                    >
                  </div>
                </div>
                <div class="menu-item">
                  <div class="menu-content">
                    <a
                      class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed"
                      data-bs-toggle="collapse"
                      href="#kt_app_sidebar_menu_dashboards_collapse"
                      data-kt-toggle-text=" Voir moins"
                    >
                      <span data-kt-toggle-text-target="true">Voir plus</span>
                      <i class="ki-duotone ki-minus-square toggle-on fs-2 me-0"
                        ><span class="path1"></span><span class="path2"></span></i
                      ><i class="ki-duotone ki-plus-square toggle-off fs-2 me-0"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span
                      ></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="menu-item pt-5">
              <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Utilitaires</span>
              </div>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-address-book fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span></i></span
                ><span class="menu-title">Services</span><span class="menu-arrow"></span
              ></span>

              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.products')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Catalogue</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.prodcut.add')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Ajouter un produit</span></a
                  >
                </div>

                <div class="menu-item">
                  <a class="menu-link" href=" {{ route('admin.mesure.unity')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">unite de mesures</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href=" {{ route('admin.moneys')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Monnaies</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href=" {{ route('admin.categories')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Categorie de services</span></a
                  >
                </div>
              </div>
            </div>

            <div class="menu-item">
              <a class="menu-link" href="{{ route('admin.pos.list')}}"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-element-plus fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span
                    ><span class="path5"></span><span class="path6"></span></i></span
                ><span class="menu-title">Point de ventes</span></a
              >
            </div>

            <div class="menu-item">
              <a class="menu-link" href="{{ route('admin.stores')}}"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-element-plus fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span
                    ><span class="path5"></span><span class="path6"></span></i></span
                ><span class="menu-title">Depots</span></a
              >
            </div>

            <div
              data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
              data-kt-menu-placement="right-start"
              class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention"
            >
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-element-plus fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span
                    ><span class="path5"></span></i></span
                ><span class="menu-title">Stocks</span><span class="menu-arrow"></span
              ></span>

              <div
                class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-2 py-4 w-200px mh-75 overflow-auto"
              >
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.stocks.report')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Fiche de stocks</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="/admin/approvisionnement"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Approvisionnement</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="/admin/destockage"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Destockage</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="/admin/inventoryRepport"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Inventaire</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.stocks.valory')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Valorisation du stocks</span></a
                  >
                </div>
              </div>
            </div>
            <div
              data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
              data-kt-menu-placement="right-start"
              class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention"
            >
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-chart-pie-3 fs-2"
                    ><span class="path1"></span><span class="path2"></span></i></span
                ><span class="menu-title">Entreprises</span
                ><span class="menu-arrow"></span
              ></span>

              <div
                class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-2 py-4 w-200px mh-75 overflow-auto"
              >
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.stepper')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Ajouter une entreprise</span></a
                  >
                </div>

                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.enterprise.list')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Mes entreprises</span></a
                  >
                </div>
              </div>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-bucket fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span></i></span
                ><span class="menu-title">Finance</span><span class="menu-arrow"></span
              ></span>
              <div class="menu-sub menu-sub-accordion menu-active-bg">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.accounts.money')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Comptes</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.entry.money')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Entree Argent</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.out.money')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Sortie Argent</span></a
                  >
                </div>
              </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-bucket fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span></i></span
                ><span class="menu-title">Logistique</span><span class="menu-arrow"></span
              ></span>
              <div class="menu-sub menu-sub-accordion menu-active-bg">
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.moneys')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Monnaies</span></a
                  >
                </div>
                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.prices')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Colonne de prix</span></a
                  >
                </div>
              </div>
            </div>

            <div class="menu-item pt-5">
              <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Applications</span>
              </div>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-abstract-28 fs-2"
                    ><span class="path1"></span><span class="path2"></span></i></span
                ><span class="menu-title">Gestion de l'equipe</span
                ><span class="menu-arrow"></span
              ></span>

              <div class="menu-sub menu-sub-accordion">
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1">
                  <span class="menu-link"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Equipe</span><span class="menu-arrow"></span
                  ></span>

                  <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                      <a class="menu-link" href="{{ route('admin.users')}}"
                        ><span class="menu-bullet"
                          ><span class="bullet bullet-dot"></span></span
                        ><span class="menu-title">liste de l'equipe</span></a
                      >
                    </div>

                    <div class="menu-item">
                      <a class="menu-link" href="{{ route('admin.user')}}"
                        ><span class="menu-bullet"
                          ><span class="bullet bullet-dot"></span></span
                        ><span class="menu-title">Voir un membre</span></a
                      >
                    </div>
                  </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                  <span class="menu-link"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Role</span><span class="menu-arrow"></span
                  ></span>

                  <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                      <a class="menu-link" href="{{ route('admin.roles')}}"
                        ><span class="menu-bullet"
                          ><span class="bullet bullet-dot"></span></span
                        ><span class="menu-title">Liste de roles</span></a
                      >
                    </div>

                    <div class="menu-item">
                      <a class="menu-link" href="{{ route('admin.role')}}"
                        ><span class="menu-bullet"
                          ><span class="bullet bullet-dot"></span></span
                        ><span class="menu-title">Voir un role</span></a
                      >
                    </div>
                  </div>
                </div>

                <div class="menu-item">
                  <a class="menu-link" href="{{ route('admin.permissions')}}"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Permissions</span></a
                  >
                </div>
              </div>
            </div>

            <div class="menu-item">
              <a class="menu-link" href="/admin/customers"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-element-plus fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span
                    ><span class="path5"></span><span class="path6"></span></i></span
                ><span class="menu-title">Clients</span></a
              >
            </div>
            <div class="menu-item">
              <a class="menu-link" href="/admin/providers"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-element-plus fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span
                    ><span class="path5"></span><span class="path6"></span></i></span
                ><span class="menu-title">Fournisseurs</span></a
              >
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-map fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span></i></span
                ><span class="menu-title">Mon subscription</span
                ><span class="menu-arrow"></span
              ></span>

              <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                  <a class="menu-link" href="#"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Changer de subscription</span></a
                  >
                </div>

                <div class="menu-item">
                  <a class="menu-link" href="#"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Voir mon subscription</span></a
                  >
                </div>
              </div>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
              <span class="menu-link"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-credit-cart fs-2"
                    ><span class="path1"></span><span class="path2"></span></i></span
                ><span class="menu-title">Gestion de factures</span
                ><span class="menu-arrow"></span
              ></span>

              <div class="menu-sub menu-sub-accordion">
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                  <span class="menu-link"
                    ><span class="menu-bullet"
                      ><span class="bullet bullet-dot"></span></span
                    ><span class="menu-title">Afficher les factures</span
                    ><span class="menu-arrow"></span
                  ></span>

                  <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <div class="menu-item">
                      <a class="menu-link" href="#l"
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
                    ><span class="path5"></span><span class="path6"></span></i></span
                ><span class="menu-title">Calendrier</span></a
              >
            </div>

            <div class="menu-item pt-5">
              <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">Aides</span>
              </div>
            </div>

            <div class="menu-item">
              <a class="menu-link" href="#" target="_blank"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-abstract-26 fs-2"
                    ><span class="path1"></span><span class="path2"></span></i></span
                ><span class="menu-title">Documentation</span></a
              >
            </div>

            <div class="menu-item">
              <a class="menu-link" href="#" target="_blank"
                ><span class="menu-icon"
                  ><i class="ki-duotone ki-code fs-2"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span></i></span
                ><span class="menu-title">Abonement Free</span></a
              >
            </div>
          </div>
        </div>
      </div>

      <div
        class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6"
        id="kt_app_sidebar_footer"
      >
        <a
          href="#"
          class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
          data-bs-toggle="tooltip"
          data-bs-trigger="hover"
          data-bs-dismiss-="click"
          title=" Voir la facon dont vous
        pouvez utiliser facilement votre systeme"
        >
          <span class="btn-label"> Documentation</span>

          <i class="ki-duotone ki-document btn-icon fs-2 m-0"
            ><span class="path1"></span><span class="path2"></span
          ></i>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
import logoLgComponentVue from "../../components/logo/logoLgComponent.vue";
import logoComponent from "../../components/logo/logoComponent.vue";

export default {
  components: {
    logoComponent,
  },
  setup() {},
};
</script>
