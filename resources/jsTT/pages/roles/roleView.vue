<template>
  <div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
      <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="d-flex flex-column flex-lg-row">
          <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
            <div class="card card-flush">
              <div class="card-header">
                <div class="card-title">
                  <h2 class="mb-0">{{ role.name }}</h2>
                </div>
              </div>

              <div class="card-body pt-0">
                <div class="d-flex flex-column text-gray-600">
                  <div
                    v-if="role.name === 'Root'"
                    class="d-flex align-items-center py-2 text-gray-600"
                  >
                    <span class="bullet bg-danger me-3"></span>
                    Controle total administrateur
                  </div>

                  <template v-for="permission in role.permissions" :key="permission.id">
                    <div class="d-flex align-items-center py-2">
                      <span class="bullet bg-primary me-3"></span>
                      {{ permission.name }}
                    </div>
                  </template>
                </div>
              </div>

              <div class="card-footer pt-0">
                <button
                  v-if="role.name !== 'Root'"
                  type="button"
                  class="btn btn-light btn-active-primary"
                  @click="addRole"
                >
                  Editer le role
                </button>
              </div>
            </div>
          </div>

          <div class="flex-lg-row-fluid ms-lg-10">
            <div class="card card-flush mb-6 mb-xl-9">
              <div class="card-header pt-5">
                <div class="card-title">
                  <h2 class="d-flex align-items-center">
                    Utilisateurs assignés à ce rôle<span class="text-gray-600 fs-6 ms-1"
                      >({{ usersLength }})</span
                    >
                  </h2>
                </div>

                <div class="card-toolbar">
                  <div
                    class="d-flex align-items-center position-relative my-1"
                    data-kt-view-roles-table-toolbar="base"
                  >
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    <input
                      type="text"
                      data-kt-roles-table-filter="search"
                      class="form-control form-control-solid w-250px ps-15"
                      placeholder="Search Users"
                    />
                  </div>

                  <div
                    class="d-flex justify-content-end align-items-center d-none"
                    data-kt-view-roles-table-toolbar="selected"
                  >
                    <div class="fw-bold me-5">
                      <span
                        class="me-2"
                        data-kt-view-roles-table-select="selected_count"
                      ></span>
                      Selected
                    </div>

                    <button
                      type="button"
                      class="btn btn-danger"
                      data-kt-view-roles-table-select="delete_selected"
                    >
                      Delete Selected
                    </button>
                  </div>
                </div>
              </div>

              <div class="card-body pt-0">
                <table
                  class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                  id="kt_roles_view_table"
                >
                  <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                      <th class="w-10px pe-2">
                        <div
                          class="form-check form-check-sm form-check-custom form-check-solid me-3"
                        >
                          <input
                            class="form-check-input"
                            type="checkbox"
                            data-kt-check="true"
                            data-kt-check-target="#kt_roles_view_table .form-check-input"
                            value="1"
                          />
                        </div>
                      </th>
                      <th class="min-w-50px">ID</th>
                      <th class="min-w-150px">Utilisateur</th>
                      <th class="min-w-125px">Date de creation</th>
                      <th class="text-end min-w-100px">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="fw-semibold text-gray-600">
                    <template v-for="user in role.users" :key="user.id">
                      <tr>
                        <td>
                          <div
                            class="form-check form-check-sm form-check-custom form-check-solid"
                          >
                            <input class="form-check-input" type="checkbox" value="1" />
                          </div>
                        </td>
                        <td>
                          {{ `ID${user.id.toString().padStart(5, "0")}` }}
                        </td>
                        <td class="d-flex align-items-center">
                          <div class="d-flex align-items-center">
                            <!-- {{-- Avatar --}} -->
                            <div
                              v-if="user.avatar == null"
                              class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                            >
                              <a href="#">
                                <div
                                  class="symbol-label fs-3 bg-light-danger text-danger"
                                >
                                  <!-- {{
                                                    $user->user_name[0] }} -->
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
                                    src="assets/media/avatars/300-1.jpg"
                                    alt="user-prodile"
                                    class="w-100"
                                  />
                                </div>
                              </a>
                            </div>

                            <!-- {{-- EndAvatar --}} -->
                          </div>

                          <div class="d-flex flex-column">
                            <a href="#" class="text-gray-800 text-hover-primary mb-1">{{
                              user.name
                            }}</a>
                            <span>{{ user.user_mail }}</span>
                          </div>
                        </td>
                        <td>{{ convertDate(user.created_at) }}</td>
                        <td class="text-end">
                          <a
                            href="#"
                            class="btn btn-sm btn-light btn-active-light-primary"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end"
                          >
                            Actions
                            <i class="ki-duotone ki-down fs-5 m-0"></i>
                          </a>

                          <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                            data-kt-menu="true"
                          >
                            <div class="menu-item px-3">
                              <a href="#" class="menu-link px-3"> View </a>
                            </div>

                            <div class="menu-item px-3">
                              <a
                                href="#"
                                class="menu-link px-3"
                                data-kt-roles-table-filter="delete_row"
                              >
                                Delete
                              </a>
                            </div>
                          </div>
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
      :id="'role-modal'"
      positionModal="center mw-650px"
      :form="form"
      @instance-modal="createRole"
    >
      <template #title>Création d'un role</template>
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
                  v-model="form.name"
                />
              </div>
              <div class="fv-row mb-5">
                <label class="fs-5 fw-bold form-label mb-2">
                  <span class="required">Description</span>
                </label>

                <input
                  class="form-control form-control-solid"
                  placeholder="description"
                  v-model="form.description"
                />
              </div>

              <div class="fv-row">
                <label class="fs-5 fw-bold form-label mb-2">Permissions par roles</label>

                <div class="table-responsive">
                  <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <tbody class="text-gray-600 fw-semibold">
                      <template v-for="role_one in roles" :key="role_one.id">
                        <template v-if="role_one.name.toLowerCase().trim() == 'root'">
                          <tr>
                            <td class="text-gray-800">
                              {{ role_one.name }}

                              <span
                                class="ms-1"
                                data-bs-toggle="tooltip"
                                title="Permettre un accès complet au système"
                              >
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6"
                                  ><span class="path1"></span><span class="path2"></span
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
                                  @click="checkbox($event, `0`, 'role_')"
                                />
                                <span class="form-check-label" for="kt_roles_select_all">
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
                                  v-if="role_one.id == role.id ? checked : false"
                                  :class="`form-check-input role_${role_one.id}`"
                                  type="checkbox"
                                  v-model="checked"
                                  @click="checkbox($event, `${role_one.id}`, 'role_')"
                                />
                                <input
                                  v-else
                                  :class="`form-check-input role_${role_one.id}`"
                                  type="checkbox"
                                  @click="checkbox($event, `${role_one.id}`, 'role_')"
                                />
                                <span
                                  class="text-gray-800 ms-2"
                                  for="kt_roles_select_all"
                                >
                                  {{ role_one.name }}
                                </span>
                              </label>
                            </td>

                            <td>
                              <div class="row">
                                <template
                                  v-for="permission in role_one.permissions"
                                  :key="permission.id"
                                >
                                  <div class="col-6 mb-3">
                                    <label
                                      class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20"
                                    >
                                      <input
                                        :class="`form-check-input permission_${permission.id}`"
                                        type="checkbox"
                                        @click="
                                          checkbox(
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
      </template>
    </modal-component>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import useRoles from "../../services/roleservices.js";
import modalComponent from "../../components/modals/modalComponent.vue";
import { useCookie } from "@vue-composable/cookie";
import moment from "moment";

export default {
  components: {
    modalComponent,
  },
  setup() {
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
    const usersLength = ref(0);
    async function callBackMounted() {
      await getRole();
      await getRolesPermissions();
      await getPermissions();
      usersLength.value = role.value.users.length;
    }
    const form = reactive({
      id: null,
      name: "",
      description: "",
      permissions: [],
    });
    const permissionsLocal = ref([]);
    const checkbox = (_event = null, id, type) => {
      let permissionsList = ref({});
      if (id == "0") {
        if (id == `0` && $(`#role_0`).is(":checked")) {
          checkedAll(permissions, "permission_", true);
        } else {
          checkedAll(permissions, "permission_", false);
          permissionsLocal.value = [];
        }
      } else {
        let valeurCheckbox = false;

        try {
          valeurCheckbox = _event.target.checked;

          $(`.${type}${id}`).each(function () {
            // Faites quelque chose avec chaque élément ici
            $(this).prop("checked", valeurCheckbox);
          });
        } catch (error) {}

        if (type == "role_") {
          permissionsList.value = [];
          if (valeurCheckbox) {
            permissionsList.value = roles.value.filter(
              (role) => role.id.toString() == id
            )[0].permissions;
            checkedAll(permissionsList, "permission_", true);
          } else {
            permissionsList = [];
            permissionsList.value = roles.value.filter(
              (role) => role.id.toString() == id
            )[0].permissions;
            checkedAll(permissionsList, "permission_", false);
          }
        } else {
          permissionsList.value = [];
          permissionsList.value.push(parseInt(id));

          if (valeurCheckbox) {
            permissionsLocal.value.push(parseInt(id));
          } else {
            permissionsLocal.value = [...new Set(permissionsLocal.value)];
            permissionsLocal.value = $.grep(permissionsLocal.value, function (value) {
              return parseInt(value) !== parseInt(id);
            });
          }
        }
      }
    };
    function checkedAll(array, type, status = false, id = null) {
      try {
        array.value.forEach((element) => {
          $(`.${type}${element.id}`).prop("checked", status);
          if (type == "permission_") {
            if (status) {
              permissionsLocal.value.push(element.id);
            } else {
              permissionsLocal.value = [...new Set(permissionsLocal.value)];
              permissionsLocal.value = $.grep(permissionsLocal.value, function (value) {
                return parseInt(value) !== parseInt(element.id);
              });
            }
          }
        });
      } catch (error) {
        try {
          array.forEach((element) => {
            $(`.${type}${element.id}`).prop("checked", status);

            if (type == "permission_") {
              if (status) {
                permissionsLocal.value.push(element.id);
              } else {
                permissionsLocal.value = [...new Set(permissionsLocal.value)];
                permissionsLocal.value = $.grep(permissionsLocal.value, function (value) {
                  return parseInt(value) !== parseInt(element.id);
                });
              }
            }
          });
        } catch (error) {}
      }
    }
    const createRole = async () => {
      permissionsLocal.value = [...new Set(permissionsLocal.value)];
      form.permissions = permissionsLocal.value.map((el) => el);
      await storeRoles({ ...form });
      permissionsLocal.value = [];
      count.value = false;
      await getRole();
      await getRolesPermissions();
    };
    const checked = ref(true);
    const count = ref(true);
    const addRole = () => {
      form.id = role.value.id;
      form.name = role.value.name;
      form.description = role.value.description;
      checkbox(form.id, "role_");
      $("#role-modal").modal("show");
      form.permissions = [];
      permissionsLocal.value = role.value.permissions.map((el) => el.id);
      role.value.permissions.forEach((el) =>
        $(`.permission_${el.id}`).prop("checked", true)
      );
      if (role.value.permissions.length == permissions.value.length) {
        $(`#role_0`).prop("checked", true);
      }
    };
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY à HH:mm:ss");
    };
    return {
      checkbox,
      createRole,
      roles,
      permissions,
      form,
      role,
      checked,
      convertDate,
      addRole,
      usersLength,
    };
  },
};
</script>
