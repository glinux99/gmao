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
                Liste des utilisateurs
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
                      class="form-control form-control-solid w-250px ps-13"
                      placeholder="chercher un utilisateur"
                    />
                  </div>
                </div>

                <div class="card-toolbar">
                  <div
                    class="d-flex justify-content-end"
                    data-kt-user-table-toolbar="base"
                  >
                    <button
                      type="button"
                      class="btn btn-light-primary me-3 d-none"
                      data-kt-menu-trigger="click"
                      data-kt-menu-placement="bottom-end"
                    >
                      <i class="ki-duotone ki-filter fs-2"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Filtre
                    </button>

                    <div
                      class="d-none menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                      data-kt-menu="true"
                    >
                      <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                      </div>

                      <div class="separator border-gray-200"></div>

                      <div class="px-7 py-5" data-kt-user-table-filter="form">
                        <div class="mb-10">
                          <label class="form-label fs-6 fw-semibold"
                            >Role</label
                          >
                          <select
                            class="form-select form-select-solid fw-bold"
                            data-kt-select2="true"
                            data-placeholder="Selectionner un role"
                            data-allow-clear="true"
                            data-kt-user-table-filter="role"
                            data-hide-search="true"
                          >
                            <option></option>
                            <template v-for="role in roles" :key="role.id">
                              <option value="{{role.name}}">
                                {{ role.name }}
                              </option>
                            </template>
                          </select>
                        </div>

                        <div class="d-flex justify-content-end">
                          <button
                            type="reset"
                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                            data-kt-menu-dismiss="true"
                            data-kt-user-table-filter="reset"
                          >
                            Reinitialiser
                          </button>
                          <button
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

                    <button
                      type="button"
                      class="btn btn-primary"
                      @click="addUser"
                    >
                      <i class="ki-duotone ki-plus fs-2"></i> Ajouter un
                      utilisateur
                    </button>
                  </div>

                  <div
                    class="d-flex justify-content-end align-items-center d-none"
                    data-kt-user-table-toolbar="selected"
                  >
                    <div class="fw-bold me-5">
                      <span
                        class="me-2"
                        data-kt-user-table-select="selected_count"
                      ></span>
                      Selectionne(s)
                    </div>

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
                                name="role"
                                data-control="select2"
                                data-placeholder="Select a role"
                                data-hide-search="true"
                                class="form-select form-select-solid fw-bold"
                              >
                                <option></option>

                                <template v-for="role in roles" :key="role.id">
                                  <option value="{{role.name}}">
                                    {{ role.name }}
                                  </option>
                                </template>
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
                  class="table align-middle table-row-dashed fs-6 gy-5"
                  id="kt_table_users"
                >
                  <thead>
                    <tr
                      class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                    >
                      <th class="w-10px pe-2">
                        <div
                          class="form-check form-check-sm form-check-custom form-check-solid me-3"
                        >
                          <input
                            class="form-check-input"
                            type="checkbox"
                            data-kt-check="true"
                            data-kt-check-target="#kt_table_users .form-check-input"
                            value="1"
                          />
                        </div>
                      </th>
                      <th class="min-w-125px">Utilisateur</th>
                      <th class="min-w-125px">Role</th>
                      <th class="min-w-125px">Status</th>
                      <th></th>
                      <th class="min-w-125px">Date de creation</th>
                      <th class="text-center min-w-100px">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-600 fw-semibold">
                    <template v-for="user in users" :key="user.id">
                      <tr>
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input
                              class="form-check-input"
                              type="checkbox"
                              value="1"
                            />
                          </div>
                        </td>
                        <td class="d-flex align-items-center">
                          <div
                            v-if="user.avatar == null"
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="#">
                              <div
                                class="symbol-label fs-3 bg-light-danger text-danger"
                              >
                                {{ user.user_name[0] }}
                              </div>
                            </a>
                          </div>

                          <div
                            v-else
                            class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                          >
                            <a href="">
                              <div class="symbol-label">
                                <img
                                  :src="`${user.avatar}${user.uuid}-0.png`"
                                  alt="user-prodile"
                                  class="w-100"
                                  @error="
                                    $event.target.src =
                                      '/assets/media/avatars/300-1.jpg'
                                  "
                                />
                              </div>
                            </a>
                          </div>

                          <div class="d-flex flex-column">
                            <span
                              @click="userDetails(user.id)"
                              class="text-gray-800 text-hover-primary mb-1"
                            >
                              {{ user.user_name }}
                            </span>
                            <span>
                              {{ user.user_mail }}
                            </span>
                          </div>
                        </td>
                        <td>
                          <span v-if="user.roles.length > 0">
                            <template v-for="role in user.roles" :key="role.id">
                              <label class="badge badge-success">{{
                                role.name
                              }}</label>
                            </template>
                          </span>
                          <span v-else>
                            <label
                              v-if="user.id == authUser.id"
                              class="badge badge-danger"
                              >Root</label
                            >
                          </span>
                        </td>
                        <td>
                          <div
                            class="badge badge-light fw-bold position-relative"
                          >
                            <span
                              :class="`bullet bullet-dot ${
                                user.status == 'disabled'
                                  ? 'bg-danger'
                                  : 'bg-success'
                              } h-6px w-6px position-absolute translate-middle top-0 start-100 animation-blink`"
                            >
                            </span>
                            {{
                              user.status == "disabled"
                                ? "Desactiver"
                                : "Active"
                            }}
                          </div>
                        </td>
                        <td></td>
                        <td>
                          {{ convertDate(user.date) }}
                        </td>
                        <td class="text-end" v-if="user.id != authUser.id">
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                            @click="editModal(user)"
                          >
                            <i class="ki-duotone ki-pencil fs-3"
                              ><span class="path1"></span
                              ><span class="path2"></span
                              ><span class="path3"></span
                              ><span class="path4"></span
                              ><span class="path5"></span
                            ></i>
                          </button>
                          <button
                            class="btn btn-icon btn-active-light-primary w-30px h-30px"
                            data-kt-permissions-table-filter="delete_row"
                          >
                            <i class="ki-duotone ki-trash fs-3"
                              ><span class="path1"></span
                              ><span class="path2"></span
                              ><span class="path3"></span
                              ><span class="path4"></span
                              ><span class="path5"></span
                            ></i>
                          </button>
                        </td>
                        <td class="text-center" v-else>
                          <i
                            class="ki-duotone ki-setting-3 fs-3"
                            @click="authUserProfil"
                            ><span class="path1"></span
                            ><span class="path2"></span
                            ><span class="path3"></span
                            ><span class="path4"></span
                            ><span class="path5"></span
                          ></i>
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
      :id="'user-modal'"
      positionModal="center mw-800px"
      :form="form"
      formInput="user-form"
      @instance-modal="userCreate"
    >
      <template #title>
        {{
          form.full_name != "" || form.user_name != "" || form.user_mail != ""
            ? `Modification de l'utilisateur ${
                form.full_name != ""
                  ? form.full_name
                  : form.user_name != ""
                  ? form.user_name
                  : form.user_mail
              }`
            : "Création d'un utilisateur"
        }}
      </template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div
              class="d-flex flex-column scroll-y me-n7 pe-7"
              id="kt_modal_update_role_scroll"
              data-kt-scroll="true"
              data-kt-scroll-activate="{default: false, lg: true}"
              data-kt-scroll-max-height="auto"
              data-kt-scroll-dependencies="#kt_modal_update_role_header"
              data-kt-scroll-wrappers="#kt_modal_update_role_scroll"
              data-kt-scroll-offset="300px"
              data-kt-scroll-save-state="false"
            >
              <div class="d-flex flex-column flex-row-fluid gap-2 gap-lg-3">
                <ul
                  data-bs-spy="scroll"
                  data-bs-target="#kt_home_menu"
                  data-bs-offset="0"
                  class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2"
                >
                  <li class="nav-item" id="user_tabs_1">
                    <a
                      class="nav-link text-active-primary pb-4 active"
                      data-bs-toggle="tab"
                      href="#general"
                      >Information Generales</a
                    >
                  </li>

                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-bs-toggle="tab"
                      href="#role"
                      >Role</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link text-active-primary pb-4"
                      data-bs-toggle="tab"
                      href="#secu"
                      >Securite</a
                    >
                  </li>
                </ul>

                <div class="tab-content" id="kt_home_menu">
                  <div
                    class="tab-pane fade show active"
                    id="general"
                    role="tab-panel"
                  >
                    <div class="d-flex flex-column gap-3 gap-lg-5">
                      <div class="card card-flush">
                        <div class="card-body pt-2">
                          <div class="row">
                            <div class="col-lg-6 fv-row mb-7">
                              <label class="required fw-semibold fs-6 mb-2"
                                >Nom complet</label
                              >

                              <input
                                type="text"
                                v-model="form.full_name"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="Nom complet"
                              />
                            </div>
                            <div class="col-lg-6 fv-row mb-7">
                              <label class="required fw-semibold fs-6 mb-2"
                                >Nom d'utilisateur</label
                              >

                              <input
                                type="text"
                                v-model="form.user_name"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="nom d'utilisateur"
                              />
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-6 fv-row mb-7">
                              <label class="required fw-semibold fs-6 mb-2"
                                >Email</label
                              >

                              <input
                                type="email"
                                v-model="form.user_mail"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="adresse email"
                              />
                            </div>
                            <div class="col-lg-6 fv-row mb-7">
                              <label class="required fw-semibold fs-6 mb-2"
                                >Telehone</label
                              >

                              <input
                                type="tel"
                                v-model="form.user_phone"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="+243 970 9124 28"
                              />
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6 fv-row mb-7">
                              <label class="required fw-semibold fs-6 mb-2"
                                >Adresse</label
                              >

                              <input
                                type="text"
                                v-model="form.address"
                                class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="addresse de l'utilisateur"
                              />
                            </div>
                            <div class="fv-row mb-7 col-lg-6">
                              <label class="form-label fw-normal fs-7 mb-5"
                                >Note</label
                              >
                              <div class="ms-auto">
                                <textarea
                                  v-model="form.note"
                                  id=""
                                  cols="20"
                                  rows="1"
                                  class="form-control bg-light"
                                ></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="role" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                      <div class="card card-flush">
                        <div class="card-body pt-3">
                          <div class="mb-5">
                            <div
                              class="d-flex flex-row justify-content-between"
                            >
                              <label class="required fw-semibold fs-6 mb-5"
                                >Role</label
                              >
                              <button
                                type="button"
                                @click="addRole(null)"
                                class="btn btn-light-primary btn-sm mb-10"
                              >
                                <i class="ki-duotone ki-plus fs-2"></i>Ajouter
                                un role
                              </button>
                            </div>

                            <template v-for="role in roles" :key="role.id">
                              <div
                                class="d-flex fv-row justify-content-between"
                              >
                                <div
                                  class="form-check form-check-custom form-check-solid"
                                >
                                  <input
                                    :class="`form-check-input me-3 role1_${role.id}`"
                                    type="checkbox"
                                    @click="checkbox($event, role.id)"
                                  />

                                  <label class="form-check-label" for="">
                                    <div class="fw-bold text-gray-800">
                                      {{ role.name }}
                                    </div>
                                    <div class="text-gray-600">
                                      {{ role.description }}
                                    </div>
                                  </label>
                                </div>
                                <i
                                  @click="viewRole(role.id)"
                                  data-bs-toggle="tooltip"
                                  title="Afficher les details de ce role"
                                  class="bi-duotone bi-eye fs-2 text-whi"
                                ></i>
                              </div>

                              <div
                                class="separator separator-dashed my-5"
                              ></div>
                            </template>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="secu" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                      <div class="card card-flush py-4">
                        <div class="card-header">
                          <div
                            class="card-title d-flex align-items-center w-100"
                          >
                            <h2 class="flex-fill">
                              Reinitialiser le mot de passe
                            </h2>
                            <div
                              class="form-check form-check-custom form-check-solid mb-2"
                            >
                              <input
                                id="statutChecked"
                                @click="statutChecked($event)"
                                class="form-check-input"
                                type="checkbox"
                              />
                              <label class="form-check-label">
                                Activer le compte
                              </label>
                            </div>
                          </div>
                        </div>

                        <div class="card-body pt-0">
                          <div class="fv-row mb-1">
                            <label class="required fw-semibold fs-6 mb-2"
                              >Mot de passe</label
                            >

                            <div
                              class="fv-row mb-3"
                              data-kt-password-meter="true"
                            >
                              <div class="position-relative mb-3">
                                <input
                                  type="password"
                                  placeholder="Password"
                                  v-model="form.password"
                                  autocomplete="new-password"
                                  class="form-control bg-transparent"
                                />

                                <span
                                  class="btn btn-sm btn-icon text-white position-absolute translate-middle top-50 end-0 me-n2"
                                  data-kt-password-meter-control="visibility"
                                >
                                  <i class="bi-eye-slash fs-2 text-dark"></i>
                                  <i
                                    class="bi-duotone bi-eye fs-2 d-none text-dark"
                                  ></i>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-body pt-0">
                          <div class="fv-row mb-1">
                            <label class="required fw-semibold fs-6 mb-2"
                              >Confirmer le mot de passe</label
                            >

                            <div
                              class="fv-row mb-3"
                              data-kt-password-meter="true"
                            >
                              <div class="position-relative mb-3">
                                <input
                                  type="password"
                                  placeholder="confirmer le mot de passe"
                                  v-model="form.password1"
                                  autocomplete="new-password"
                                  class="form-control bg-transparent"
                                />

                                <span
                                  class="btn btn-sm btn-icon text-white position-absolute translate-middle top-50 end-0 me-n2"
                                  data-kt-password-meter-control="visibility"
                                >
                                  <i class="bi-eye-slash fs-2 text-dark"></i>
                                  <i
                                    class="bi-duotone bi-eye fs-2 d-none text-dark"
                                  ></i>
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
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      activeBtn="false"
      :id="'view-role-modal'"
      positionModal="center mw-650px"
      :form="formRole"
      @instance-modal="createRole"
    >
      <template #title>Role {{ role.name }}</template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div
              class="d-flex flex-column scroll-y me-n7 pe-7"
              id="kt_modal_update_role_scroll"
              data-kt-scroll="true"
              data-kt-scroll-activate="{default: false, lg: true}"
              data-kt-scroll-max-height="auto"
              data-kt-scroll-dependencies="#kt_modal_update_role_header"
              data-kt-scroll-wrappers="#kt_modal_update_role_scroll"
              data-kt-scroll-offset="300px"
            >
              <div class="col-12">
                <div class="card card-flush h-md-100">
                  <div class="card-header w-100">
                    <div class="card-title w-100">
                      <div
                        class="d-flex flex-row w-100 justify-content-between"
                      >
                        <h2>
                          {{ role.name }}
                          <span
                            class="small required-label"
                            v-if="
                              role.permissions != undefined &&
                              role.name != undefined &&
                              role.permissions.length <= 0 &&
                              role.name.toLowerCase().trim() != 'root'
                            "
                            >(Ce role ne comporte aucune permission)
                          </span>
                        </h2>
                        <button
                          v-if="
                            role.name != undefined &&
                            role.name.toLowerCase().trim() != 'root'
                          "
                          type="button"
                          @click="addRole(role)"
                          class="btn btn-light-primary btn-sm mb-10"
                        >
                          <i class="ki-duotone ki-pencil fs-3"
                            ><span class="path1"></span
                            ><span class="path2"></span></i
                          >Editer
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="card-body pt-1">
                    <div class="fw-bold text-gray-600 mb-5">
                      Nombre total d'utilisateurs avec ce rôle :
                      {{ roleUserLength(role) }}
                    </div>
                    <div
                      v-if="role.name == 'Root'"
                      class="d-flex align-items-center py-2 text-gray-600"
                    >
                      <span class="bullet bg-danger me-3"></span>
                      Controle total administrateur
                    </div>
                    <div v-else class="d-flex flex-column text-gray-600">
                      <template
                        v-for="(permission, index) in role['permissions']"
                        :key="permission.id"
                      >
                        <div
                          :class="`d-flex align-items-center py-2 ${
                            index > 5 ? 'col-lg-6' : ''
                          }`"
                        >
                          <span class="bullet bg-primary me-3"></span>

                          {{ permission.name }}
                        </div>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      :id="'role-modal'"
      positionModal="center mw-650px"
      :form="formRole"
      @instance-modal="createRole"
    >
      <template #title>
        {{
          formRole.name == ""
            ? "Création d'un role"
            : `Modification du role ${formRole.name}`
        }}
      </template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div
              class="d-flex flex-column scroll-y me-n7 pe-7"
              id="kt_modal_update_role_scroll"
              data-kt-scroll="true"
              data-kt-scroll-activate="{default: false, lg: true}"
              data-kt-scroll-max-height="auto"
              data-kt-scroll-dependencies="#kt_modal_update_role_header"
              data-kt-scroll-wrappers="#kt_modal_update_role_scroll"
              data-kt-scroll-offset="300px"
            >
              <div class="fv-row mb-10">
                <label class="fs-5 fw-bold form-label mb-2">
                  <span class="required">Nom de role</span>
                </label>

                <input
                  class="form-control form-control-solid"
                  placeholder="Enter a role name"
                  v-model="formRole.name"
                />
              </div>
              <div class="fv-row mb-5">
                <label class="fs-5 fw-bold form-label mb-2">
                  <span class="required">Description</span>
                </label>

                <input
                  class="form-control form-control-solid"
                  placeholder="description"
                  v-model="formRole.description"
                />
              </div>

              <div class="fv-row">
                <div class="d-flex flex-column flex-row-fluid gap-2 gap-lg-3">
                  <ul
                    class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2"
                  >
                    <li class="nav-item">
                      <a
                        class="nav-link text-active-primary pb-4 active"
                        data-bs-toggle="tab"
                        href="#permissions_roles"
                        >Permissions par roles</a
                      >
                    </li>

                    <li class="nav-item">
                      <a
                        class="nav-link text-active-primary pb-4"
                        data-bs-toggle="tab"
                        href="#permissions"
                        >Toutes les permissions</a
                      >
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div
                      class="tab-pane fade show active"
                      id="permissions_roles"
                      role="tab-panel"
                    >
                      <div class="d-flex flex-column gap-3 gap-lg-5">
                        <div class="card card-flush">
                          <div class="card-body">
                            <div class="table-responsive">
                              <table
                                class="table align-middle table-row-dashed fs-6 gy-5"
                              >
                                <tbody class="text-gray-600 fw-semibold">
                                  <template
                                    v-for="role in roles"
                                    :key="role.id"
                                  >
                                    <template
                                      v-if="
                                        role.name.toLowerCase().trim() == 'root'
                                      "
                                    >
                                      <tr>
                                        <td class="text-gray-800">
                                          {{ role.name }}

                                          <span
                                            class="ms-1"
                                            data-bs-toggle="tooltip"
                                            title="Permettre un accès complet au système"
                                          >
                                            <i
                                              class="ki-duotone ki-information-5 text-gray-500 fs-6"
                                              ><span class="path1"></span
                                              ><span class="path2"></span
                                              ><span class="path3"></span></i
                                          ></span>
                                        </td>
                                        <td>
                                          <label
                                            class="form-check form-check-sm form-check-custom form-check-solid me-9"
                                          >
                                            <input
                                              class="form-check-input"
                                              type="checkbox"
                                              id="role_0"
                                              @click="
                                                checkboxRole(
                                                  $event,
                                                  `0`,
                                                  'role_'
                                                )
                                              "
                                            />
                                            <span
                                              class="form-check-label"
                                              for="kt_roles_select_all"
                                            >
                                              Selectionner tout
                                            </span>
                                          </label>
                                        </td>
                                      </tr>
                                    </template>

                                    <template v-else>
                                      <tr>
                                        <td>
                                          <label
                                            class="form-check form-check-sm form-check-custom form-check-solid me-9"
                                          >
                                            <input
                                              :class="`form-check-input role_${role.id}`"
                                              type="checkbox"
                                              @click="
                                                checkboxRole(
                                                  $event,
                                                  `${role.id}`,
                                                  'role_'
                                                )
                                              "
                                            />
                                            <span
                                              class="text-gray-800 ms-2"
                                              for="kt_roles_select_all"
                                            >
                                              {{ role.name }}
                                            </span>
                                          </label>
                                        </td>

                                        <td>
                                          <div class="row">
                                            <template
                                              v-for="permission in role.permissions"
                                              :key="permission.id"
                                            >
                                              <div class="col-lg-6 mb-3">
                                                <label
                                                  class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20"
                                                >
                                                  <input
                                                    :class="`form-check-input permission_${permission.id}`"
                                                    type="checkbox"
                                                    @click="
                                                      checkboxRole(
                                                        $event,
                                                        `${permission.id}`,
                                                        'permission_'
                                                      )
                                                    "
                                                  />
                                                  <span
                                                    class="form-check-label text-justify"
                                                  >
                                                    {{ permission.name }}
                                                  </span>
                                                </label>
                                              </div>
                                            </template>
                                          </div>
                                        </td>
                                      </tr>
                                    </template>
                                  </template>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="permissions"
                      role="tab-panel"
                    >
                      <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush">
                          <div class="card-body pt-10">
                            <div class="row">
                              <template
                                v-for="permission in permissions"
                                :key="permission.id"
                              >
                                <div class="col-lg-6 mb-3">
                                  <label
                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20"
                                  >
                                    <input
                                      :class="`form-check-input permission_${permission.id}`"
                                      type="checkbox"
                                      @click="
                                        checkboxRole(
                                          $event,
                                          `${permission.id}`,
                                          'permission_'
                                        )
                                      "
                                    />
                                    <span class="form-check-label text-justify">
                                      {{ permission.name }}
                                    </span>
                                  </label>
                                </div>
                              </template>
                            </div>
                          </div>
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
    </modal-component>
  </div>
</template>
<style>
.image-input-placeholder-light {
  background-image: url("~/assets/bl-img.svg");
}

.image-input-placeholder-dark {
  background-image: url("~/assets/bl-img-dark.svg");
}
</style>
<script>
import { onMounted, reactive, ref } from "vue";
import useUsers from "../../services/userservices.js";
import useRoles from "../../services/roleservices.js";
import moment from "moment";
import modalComponent from "../../components/modals/modalComponent.vue";
import roleList from "../roles/roleList.vue";

import { useCookie } from "@vue-composable/cookie";
export default {
  components: {
    modalComponent,
    roleList,
  },
  setup() {
    const form = reactive({
      id: null,
      full_name: "",
      user_name: "",
      user_phone: "",
      password: null,
      //   password: "",
      address: "",
      status: null,
      note: "",
      avatar: "",
      email: "",
      role: [],
      uuid: null,
    });
    const { users, getUsers, storeUser } = useUsers();
    const {
      role,
      roles,
      getRole,
      permissions,
      getPermissions,
      getRolesPermissions,
      storeRoles,
    } = useRoles();

    onMounted(async () => {
      await callBackMounted();
    });
    const authUser = ref({});
    async function callBackMounted() {
      await getUsers();
      await getRolesPermissions();
      authUser.value = JSON.parse(useCookie("userAuth").cookie.value).data;
      $(`.role_${roles.value[0].id}`).prop("checked", true);
      await getPermissions();
    }
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY à HH:mm:ss");
    };
    const userDetails = (id) => {
      const roleCookie = useCookie("user");
      roleCookie.setCookie(id);
      location.href = "/admin/user-agent";
    };
    const statutChecked = (_event) => {
      form.status = _event.target.checked ? "enabled" : "disabled";
    };
    const userCreate = async () => {
      form.role = rolesLocal.value;
      let formData = new FormData();
      //   if (form.password == "") form.password = null;
      for (const [key, value] of Object.entries(form)) {
        formData.append(`${key}`, value);
      }
      images.value.forEach((e, i) => {
        formData.append(`${i}`, e);
      });
      console.log(images.value.length);
      console.log({ ...form });
      if (images.value.length <= 0) {
        await storeUser({ ...form }, form.id);
      } else {
        await storeUser(formData, form.id);
      }

      images.value = [];
      rolesLocal.value = [];

      await getUsers();
    };
    const addUser = () => {
      $('.nav-tabs a[href="#general"]').tab("show");
      scroll.scrollTop = 0;
      location.href = "/admin/users#general";
      $("#user_tabs li:nth-child(1) ").click();
      for (const [key, value] of Object.entries(form)) {
        form[key] =
          typeof value == "string" ? "" : typeof value == "number" ? 0 : {};
      }
      form.status = "disabled";
      checkedAll(roles, "role1_", false);
      checkedAll(permissions, "permission_", false);
      rolesLocal.value = [];
      $("#statutChecked").prop("checked", false);
      $("#user-modal").modal("show");
    };
    const rolesLocal = ref([]);
    const checkbox = (_event, id = roles.value[0].id) => {
      var valeurCheckbox = _event.target.checked;
      if (valeurCheckbox) {
        rolesLocal.value.push(id);
      } else {
        rolesLocal.value = rolesLocal.value.filter((el) => el != id);
      }

      console.log(rolesLocal.value);
    };
    let images = ref([]);
    const onFileChange = (event) => {
      const files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        try {
          images.value.push(files[i]);
        } catch (error) {}
      }
    };
    const editModal = (value) => {
      rolesLocal.value = [];
      console.log(value.roles);
      roles.value.forEach((el) => {
        $(`.role1_${el.id}`).prop("checked", false);
      });
      value.roles.forEach((el) => {
        $(`.role1_${el.id}`).prop("checked", true);
        rolesLocal.value.push(el.id);
      });

      if (value.roles.length == 0 && value.id == authUser.value.id) {
        $(`.role1_${roles.value[0].id}`).prop("checked", true);
        rolesLocal.value.push(roles.value[0].id);
      }
      //   $(`.role_${value.role.id}`).prop("checked", true);

      $("#user-modal").modal("show");

      for (const [key, val] of Object.entries(value)) {
        if (value[key] != null && value[key] != "") {
          form[key] = value[key];
        }
      }
      $("#statutChecked").prop(
        "checked",
        form.status == "disabled" ? false : true
      );
    };
    const roleLocale = reactive({});
    const viewRole = async (id) => {
      const roleCookie = useCookie("role");
      roleCookie.setCookie(id);
      await getRole();
      for (const [key, val] of Object.entries(role)) {
        if (role[key] != null && role[key] != "") {
          roleLocale[key] = role[key];
        }
      }

      $("#view-role-modal").modal("show");
      $("#user-modal").modal("handleUpdate", false);
    };
    const permissionsLocal = ref([]);

    const addRole = (role = null) => {
      //   alert(permissions.value.length);
      //   //   code de teste
      //   checkedAll(permissions, "permission_", false);
      permissions.value.forEach((el) => {
        $(`.permission_${el.id}`).prop("checked", false);
      });

      if (role == null) {
        $("#role-modal").modal("show");
        formRole.permissions = [];
      } else {
        roles.value.forEach((el) => {
          $(`.role_${el.id}`).prop("checked", false);
        });
        // checkedAll(permissions, "permission_", false);
        $(`.role_${role.id}`).prop("checked", true);
        $("#role-modal").modal("show");
        for (const [key, value] of Object.entries(role)) {
          formRole[key] = value;
        }
        formRole.permissions = [];
        permissionsLocal.value = role.permissions.map((el) => el.id);
        checkedAll(role.permissions, "permission_", true);
        try {
          if (role.permissions.length == permissions.value.length) {
            $(`#role_0`).prop("checked", true);
          }
        } catch (error) {}
        $("#view-role-modal").modal("hide");
      }
    };
    const formRole = reactive({
      id: null,
      name: "",
      description: "",
      permissions: [],
    });
    const checkboxRole = (_event = null, id, type) => {
      let valeurCheckbox = false;
      valeurCheckbox = _event.target.checked;

      let permissionsList = ref({});
      if (id == "0") {
        if (id == `0` && $(`#role_0`).is(":checked")) {
          checkedAll(permissions, "permission_", true);
        } else {
          checkedAll(permissions, "permission_", false);
        }
      } else {
        try {
          $(`.${type}${id}`).each(function () {
            // Faites quelque chose avec chaque élément ici
            $(this).prop("checked", valeurCheckbox);
          });
        } catch (error) {}
      }
      if (type == "role_") {
        permissionsList.value = [];
        if ($(`.role_${id}`).is(":checked")) {
          permissionsList = roles.value.filter(
            (role) => role.id.toString() == id
          )[0].permissions;
          checkedAll(permissionsList, "permission_", true);
        } else {
          permissionsList = [];
          permissionsList = roles.value.filter(
            (role) => role.id.toString() == id
          )[0].permissions;
          checkedAll(permissionsList, "permission_", false);
        }
      } else {
        permissionsList.value = [];
        // formRole.permissions.push(parseInt(id));
        if (valeurCheckbox) {
          formRole.permissions.push(parseInt(id));
        } else {
          formRole.permissions = formRole.permissions.filter((el) => el != id);
        }
      }
    };
    function checkedAll(array, type, status = false, id = null) {
      try {
        array.value.forEach((element) => {
          $(`.${type}${element.id}`).prop("checked", status);
          if (type == "permission_") {
            if (status) {
              try {
                formRole.permissions.push(parseInt(element.id));
              } catch (error) {
                formRole.permissions.push(parseInt(id));
              }
            } else {
              formRole.permissions = formRole.permissions.filter(
                (el) => el != element.id
              );
            }
          }
        });
      } catch (error) {
        try {
          array.forEach((element) => {
            $(`.${type}${element.id}`).prop("checked", status);
            if (type == "permission_") {
              if (status) {
                formRole.permissions.push(parseInt(element.id));
              } else {
                formRole.permissions = formRole.permissions.filter(
                  (el) => el != element.id
                );
              }
            }
          });
        } catch (error) {}
      }
    }
    const createRole = async () => {
      //   console.log({ ...roleLocale });
      //   roleLocale.permissions.forEach((el) => {
      //     formRole.permissions.push(el);
      //   });
      formRole.permissions = [...new Set(formRole.permissions)];
      formRole.permissions = formRole.permissions.map((el) => {
        if (typeof el == "object") return el.id;
        else return el;
      });
      console.log({ ...formRole });
      await storeRoles({ ...formRole });
      await getRolesPermissions();
      //   await getRoles();
    };
    const roleUserLength = (role) => {
      try {
        return role.users.length;
      } catch (error) {
        return 0;
      }
      //   return roleLocale.value.users;
    };
    const authUserProfil = () => {
      location.href = "/admin/user";
    };
    return {
      statutChecked,
      roleUserLength,
      form,
      users,
      roles,
      roleLocale,
      authUserProfil,
      role,
      formRole,
      createRole,
      addRole,
      addUser,
      viewRole,
      authUser,
      checkbox,
      editModal,
      permissions,
      checkboxRole,
      userCreate,
      userDetails,
      convertDate,
      onFileChange,
    };
  },
};
</script>
