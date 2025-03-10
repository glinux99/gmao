<template>
  <div>
    <div class="row g-2">
      <template v-for="(entreprise, index) in entreprises" :key="entreprise.id">
        <template v-if="index < 4">
          <div :class="'col-6 '">
            <div
              v-if="entreprise.id == enterpriseId"
              @click="activeEntrepriseOnly(entreprise.id)"
              :class="'py-5 pulse pulse-primary badge badge-light-primary d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3 '"
            >
              <img
                :src="
                  entreprise.photo == null
                    ? '/assets/favicon.ico'
                    : entreprise.photo
                "
                class="w-25px h-25px mb-2"
                alt=""
              />
              <span class="pulse-ring border-3 mb-5"></span>
              <span class="fw-semibold">{{ entreprise.name }}</span>
            </div>
            <div v-else>
              <div
                @click="activeEntrepriseOnly(entreprise)"
                :class="'d-flex flex-column flex-center text-center text-gray-800 text-hover-primary bg-hover-light rounded py-4 px-3 mb-3 '"
              >
                <img
                  :src="
                    entreprise.photo == null
                      ? '/assets/favicon.ico'
                      : entreprise.photo
                  "
                  class="w-25px h-25px mb-2"
                  alt=""
                />

                <span class="fw-semibold">{{ entreprise.name }}</span>
              </div>
            </div>
          </div>
        </template>
      </template>
      <template v-for="(entreprise, index) in entreprises" :key="entreprise.id">
        <div v-if="index == 3" class="text-center">
          <a href="/admin/enterprises" class="menu-link px-3 text-center">
            <span title="Cliquer pour voir toutes vos entreprises">
              Voir plus ({{ entreprises.length }})
            </span>
          </a>
        </div>
      </template>
    </div>
    <div v-if="entreprises.length == 0">
      <a href="/admin/stepper" class="menu-link px-3">
        <div class="card text-center">
          <!-- <img class="card-img-top" src="holder.js/100px180/" alt="Title" /> -->
          <div class="card-body">
            <p class="card-text" title="Cliquer pour creer une entreprise">
              Aucune entreprise
            </p>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>
<script>
import { onMounted } from "vue";
import useEntreprises from "../../services/enterpriseservices.js";
import { useCookie } from "@vue-composable/cookie";
import { notifications } from "../../notifications/notifications.js";
export default {
  setup() {
    let enterpriseId = 1;
    try {
      enterpriseId = useCookie("userAuth")?.cookie?.value
        ? JSON.parse(useCookie("userAuth").cookie.value).data.active_enterprise
        : 1;
    } catch (error) {}
    const {
      entreprises,
      getEntreprise,
      activeEntreprise,
      storeActiveEntreprise,
    } = useEntreprises();
    const { dataActive } = notifications();
    const activeEntrepriseOnly = async (data) => {
      await storeActiveEntreprise(data.name, data.id);
    };

    onMounted(async () => {
      dataActive();
      await getEntreprise();
    });
    // async function callBackMounted() {
    //   await getEntreprise();

    // }
    // onMounted(getEntreprise());
    return {
      entreprises,
      activeEntreprise,
      activeEntrepriseOnly,
      storeActiveEntreprise,
      getEntreprise,
      enterpriseId,
    };
  },
};
</script>
