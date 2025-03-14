<template>
  <div>
    <div class="card mb-5 mb-xl-1">
      <div class="card-header border-0">
        <div class="card-title w-100">
          <div class="w-100 d-flex flex-row justify-content-between align-items-center">
            <div>
              <h3 class="fw-bold m-0">Utilisateurs</h3>
            </div>
            <div @click="addUser" class="btn btn-sm btn-light-primary">
              <i class="ki-duotone ki-user fs-3"
                ><span class="path1"></span><span class="path2"></span
              ></i>
              Ajouter
            </div>
          </div>
        </div>
      </div>

      <div class="card-body pt-2">
        <div class="py-2">
          <template v-for="user in depositUsers" :key="user.id">
            <div class="d-flex flex-stack">
              <div class="d-flex">
                <li class="fa fa-user display-6 me-6"></li>

                <div class="d-flex flex-column">
                  <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">
                    {{ user.user_name }}
                  </a>
                  <div
                    class="fs-6 fw-semibold text-muted cursor-pointer"
                    data-bs-toggle="tooltip"
                    title="changer le niveau de cet utilisateur"
                    @click="userLevel(user, true)"
                  >
                    {{ user.level == "chief" ? "chef de depot" : "niveau simple" }}
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end">
                <label
                  class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                >
                  <input
                    @click="checkUser(user)"
                    class="form-check-input"
                    type="checkbox"
                    checked="checked"
                  />

                  <span
                    class="form-check-label fw-semibold text-muted"
                    for="kt_modal_connected_accounts_google"
                  ></span>
                </label>
              </div>
            </div>

            <div class="separator separator-dashed my-5"></div>
          </template>
        </div>
      </div>
    </div>
    <modal-component
      :id="'user-modal'"
      positionModal="center mw-650px"
      @instance-modal="createUserDeposit"
    >
      <template #title>Ajouter un utilisateurs au dépôt</template>
      <template #body>
        <div class="card text-start">
          <div class="card-body m-0">
            <div class="w-100 bd-highlight">
              <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                  ><span class="path1"></span><span class="path2"></span
                ></i>
                <input
                  type="text"
                  v-model="search"
                  :class="`ps-13 form-control form-control-lg form-control-solid`"
                  :placeholder="`chercher un utilisateur`"
                />
              </div>
            </div>
            <table
              class="table align-middle table-row-dashed fs-6"
              id="kt_table_usersxx2"
            >
              <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                  <th class="min-w-180px">Liste d'utilisateur de l'entreprise</th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                  <th class="d-none"></th>
                </tr>
              </thead>

              <tbody class="fw-bold text-gray-600">
                <template v-for="user in users" :key="user.id">
                  <tr class="w-100">
                    <td>
                      <label class="d-flex flex-stack mb-5 cursor-pointer">
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
                              user.user_name ?? full_name
                            }}</span>

                            <span class="fs-7 text-muted"
                              >{{ user.user_mail ?? user_phone }} /
                              {{ user.type }}
                            </span>
                          </span>
                        </span>

                        <span class="form-check form-check-custom form-check-solid">
                          <div
                            v-if="user.status == 'disabled'"
                            class="badge badge-light fw-bold position-relative"
                          >
                            <span
                              :class="`bullet bullet-dot ${
                                user.status == 'disabled' ? 'bg-danger' : 'bg-success'
                              } h-6px w-6px position-absolute translate-middle top-0 start-100 animation-blink`"
                            >
                            </span>
                            Compte desactiver
                          </div>
                          <input
                            v-else
                            @change="userCheck($event, user)"
                            :class="`form-check-input user_${user.id}`"
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
        </div>
      </template>
    </modal-component>
    <modal-component
      :id="'level-modal'"
      positionModal=" modal-dialog-centered mw-350px "
      :noHeader="true"
      activeBtn="false"
    >
      <template #body>
        <div
          class="card-body d-flex flex-column align-items-center justify-content-center"
        >
          <div class="d-flex flex-column justify-content-center pt-5">
            <li class="fa fa-question display-3 align-self-center"></li>
            <span class="align-self-center">Quel est le niveau de Mr./Mme. Daniel?</span>
          </div>
          <div class="text-center mb-5 mt-10">
            <div class="btn btn-dark me-3" @click="checkLevel('simple')">
              Niveau simple
            </div>

            <div class="btn fw-bold btn-primary" @click="checkLevel('chief')">
              Chef de depot
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import { onMounted, reactive, ref, watch } from "vue";
import useDeposit from "../../services/depositservices";
import modalComponent from "../../components/modals/modalComponent.vue";
import useUsers from "../../services/userservices";
import { useCookie } from "@vue-composable/cookie";
import { notifications } from "../../notifications/notifications";

export default {
  components: {
    modalComponent,
  },
  setup() {
    const { depositUsers, getUsersDeposit, storeUserDeposit } = useDeposit();
    const { users, getUsers } = useUsers();
    const search = ref("");
    const store = ref(0);
    const level = ref("simple");
    const level2 = ref("simple");
    const serverOn = ref(false);
    const userLocal = reactive({});
    const { dataCreated, swal } = notifications();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      try {
        store.value = JSON.parse(useCookie("store").cookie.value);
      } catch (error) {}
      await getUsersDeposit({
        deposit_id: store.value,
      });
    }
    const addUser = async () => {
      await getUsers();
      $("#user-modal").modal("show");
    };
    const depositUsersLocal = ref([]);
    const userLevel = async (user, serverOnLocal = false) => {
      $("#level-modal").modal("show");
      $("#user-modal").modal("handleUpdate", false);
      for (const [key, value] of Object.entries(user)) {
        userLocal[key] = value;
      }
      serverOn.value = serverOnLocal;
    };

    const checkLevel = async (value) => {
      $("#level-modal").modal("hide");
      if (serverOn.value) {
        await storeUserDeposit(
          {
            level: value,
            deposit_id: store.value,
          },
          userLocal.id,
          1
        );
        callBackMounted();
        serverOn.value = false;
      } else {
        var element = depositUsersLocal.value.pop();
        element.level = value;
        depositUsersLocal.value.push(element);
      }
    };
    const userCheck = (_event, user) => {
      let checkedValue = _event.target.checked;

      if (checkedValue) {
        depositUsersLocal.value.push({
          deposit_id: store.value,
          user_id: user.id,
          level: "simple",
        });
        userLevel(user);
      } else {
        depositUsersLocal.value = depositUsersLocal.value.filter(
          (user) => parseInt(user.user_id) != parseInt(id)
        );
      }
    };
    const createUserDeposit = async () => {
      depositUsersLocal.value = [...new Set(depositUsersLocal.value)];
      await storeUserDeposit({ ...depositUsersLocal.value });
      callBackMounted();
    };
    const checkUser = async (user) => {
      await storeUserDeposit({}, user.id, 2);
      callBackMounted();
    };
    return {
      userCheck,
      addUser,
      depositUsers,
      checkLevel,
      userLevel,
      checkUser,
      users,
      store,
      search,
      createUserDeposit,
    };
  },
};
</script>
