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
                Liste de rôles
              </h1>
            </div>
          </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div
            id="kt_app_content_container"
            class="app-container container-xxl"
          >
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
              <template v-for="role in roles" :key="role.id">
                <div class="col-md-4">
                  <div class="card card-flush h-md-100">
                    <div class="card-header">
                      <div class="card-title">
                        <h2>{{ role.name.toUpperCase() }}</h2>
                      </div>
                    </div>

                    <div class="card-body pt-1">
                      <div class="fw-bold text-gray-600 mb-5">
                        Nombre total d'utilisateurs avec ce rôle :
                        {{ role.users.length }}
                      </div>
                      <div
                        v-if="role.name.toLowerCase().trim() == 'root'"
                        class="d-flex align-items-center py-2 text-gray-600"
                      >
                        <span class="bullet bg-danger me-3"></span>
                        Controle total administrateur
                      </div>
                      <div v-else class="d-flex flex-column text-gray-600">
                        <template
                          v-for="(permission, index) in role.permissions"
                          :key="permission.id"
                        >
                          <div
                            v-if="index < 5"
                            class="d-flex align-items-center py-2"
                          >
                            <span class="bullet bg-primary me-3"></span>

                            {{ permission.name }}
                          </div>
                        </template>

                        <div
                          class="d-flex align-items-center py-2"
                          v-if="role.permissions.length > 5"
                        >
                          <span class="bullet bg-primary me-3"></span>
                          <em
                            >et {{ role.permissions.length - 5 }} de plus...</em
                          >
                        </div>
                      </div>
                    </div>

                    <div class="card-group p-4">
                      <span
                        @click="viewRole(role.id)"
                        class="card btn btn-light btn-active-primary my-1 me-2"
                      >
                        Afficher le rôle
                      </span>

                      <button
                        type="button"
                        class="card btn btn-light btn-active-light-primary my-1"
                        data-bs-toggle="modal"
                        data-bs-target="#kt_modal_update_role"
                      >
                        Editer le rôle
                      </button>
                    </div>
                  </div>
                </div>
              </template>

              <div class="ol-md-4">
                <div class="card h-md-100">
                  <div class="card-body d-flex flex-center">
                    <button
                      type="button"
                      class="btn btn-clear d-flex flex-column flex-center"
                      @click="addRole"
                      id="addRole"
                    >
                      <img
                        src="/assets/media/illustrations/sketchy-1/2.png"
                        alt=""
                        class="mw-100 mh-150px mb-7"
                      />

                      <div
                        class="fw-bold fs-3 text-gray-600 text-hover-primary"
                      >
                        Ajouter un nouveau rôle
                      </div>
                    </button>
                  </div>
                </div>
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
      <template #title>Création d'un rôle</template>
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
                  <span class="required">Nom de rôle</span>
                </label>

                <input
                  class="form-control form-control-solid"
                  placeholder="Enter a rôle name"
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
                <label class="fs-5 fw-bold form-label mb-2"
                  >Permissions par rôles</label
                >

                <div class="table-responsive">
                  <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <tbody class="text-gray-600 fw-semibold">
                      <template v-for="role in roles" :key="role.id">
                        <template
                          v-if="role.name.toLowerCase().trim() == 'root'"
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
                                  @click="checkbox(`0`, 'role_')"
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
                                  @click="checkbox(`${role.id}`, 'role_')"
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
                                  <div class="col-6 mb-3">
                                    <label
                                      class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20"
                                    >
                                      <input
                                        :class="`form-check-input permission_${permission.id}`"
                                        type="checkbox"
                                        @click="
                                          checkbox(
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
      </template>
    </modal-component>
  </div>
</template>
<script>
import { useCookie } from "@vue-composable/cookie";
import { onMounted, reactive, ref } from "vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import useRoles from "../../services/roleservices.js";

export default {
  components: {
    modalComponent,
  },
  setup() {
    const {
      roles,
      permissions,
      getPermissions,
      getRolesPermissions,
      storeRoles,
    } = useRoles();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getRolesPermissions();
      await getPermissions();
    }
    const form = reactive({
      id: null,
      name: "",
      description: "",
      permissions: [],
    });
    const checkbox = (id, type) => {
      let permissionsList = ref({});
      if (id == "0") {
        if (id == `0` && $(`#role_0`).is(":checked")) {
          checkedAll(permissions, "permission_", true);
        } else {
          checkedAll(permissions, "permission_", false);
        }
      } else {
        if (type == "role_") {
          if ($(`.role_${id}`).is(":checked")) {
            permissionsList = roles.value.filter(
              (role) => role.id.toString() == id
            )[0].permissions;
            checkedAll(permissionsList, "permission_", true);
          } else {
            permissionsList = roles.value.filter(
              (role) => role.id.toString() == id
            )[0].permissions;
            checkedAll(permissionsList, "permission_", false);
          }
        } else {
          form.permissions.push(id);
          if ($(`.permission_${id}`).is(":checked")) {
            form.permissions.push(id);
          } else {
            var index = form.permissions.indexOf(id); // Trouve l'index de element.id dans le tableau
            if (index > -1) {
              form.permissions.splice(index, 1); // Supprime element.id du tableau form.permissions
            }
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
              form.permissions.push(element.id);
            } else {
              var index = form.permissions.indexOf(element.id); // Trouve l'index de element.id dans le tableau
              if (index > -1) {
                form.permissions.splice(index, 1); // Supprime element.id du tableau form.permissions
              }
            }
          }
        });
      } catch (error) {
        try {
          array.forEach((element) => {
            $(`.${type}${element.id}`).prop("checked", status);
            if (type == "permission_") {
              if (status) {
                form.permissions.push(element.id);
              } else {
                var index = form.permissions.indexOf(element.id); // Trouve l'index de element.id dans le tableau
                if (index > -1) {
                  form.permissions.splice(index, 1); // Supprime element.id du tableau form.permissions
                }
              }
            }
          });
        } catch (error) {}
      }
    }
    const createRole = async () => {
      form.permissions = [...new Set(form.permissions)];
      await storeRoles({ ...form });
      await getRolesPermissions();
    };
    const viewRole = (id) => {
      const roleCookie = useCookie("role");
      roleCookie.setCookie(id);
      location.href = `/roles/${id}`;
    };
    const addRole = () => {
      $("#role-modal").modal("show");
      $("user-modal").modal("handleUpdate", false);
      form.permissions = [];
    };
    return {
      checkbox,
      createRole,
      roles,
      permissions,
      form,
      addRole,
      viewRole,
    };
  },
};
</script>
