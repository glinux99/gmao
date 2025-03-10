<template>
  <div>
    <!-- Modal template -->
    <modal-component
      id="price-modal"
      positionModal="center mw-650px"
      :form="form"
      @instance-modal="createCategories"
    >
      <template #title>Création d'une tarification</template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div class="card-text">
              <div class="mb-5 fv-row">
                <label class="required form-label">Label</label>

                <input
                  type="text"
                  v-model="form.label"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">
                  Configurer le nom pour ce prix
                </div>
              </div>
              <div class="row">
                <div class="col-7">
                  <div class="mb-5 fv-row">
                    <label class="required form-label">Valeur</label>

                    <input
                      type="number"
                      v-model="form.price"
                      class="form-control mb-2"
                      placeholder=""
                    />

                    <div class="text-muted fs-7">(Montant de ce prix, etc)</div>
                  </div>
                </div>
                <div class="col-5">
                  <div class="mb-5">
                    <label class="form-label fs-6 fw-semibold">Monnaie</label>
                    <select
                      v-model="form.money_id"
                      class="form-select form-select-solid fw-bold"
                      data-allow-clear="true"
                      data-hide-search="true"
                    >
                      <template v-for="moneyOne in money" :key="moneyOne.id">
                        <option :value="moneyOne.id" v-if="moneyOne.principal">
                          {{
                            moneyOne.abreviation +
                            " (" +
                            moneyOne.money_name +
                            ")"
                          }}
                        </option>
                        <option :value="moneyOne" v-else>
                          {{
                            moneyOne.abreviation +
                            " (" +
                            moneyOne.money_name +
                            ")"
                          }}
                        </option>
                      </template>
                    </select>
                  </div>
                </div>
              </div>

              <div class="fv-row">
                <label class="form-label text-muted fs-7"
                  >Appliquer le calcul de taxe sur cette categorie</label
                >

                <div class="form-check form-check-custom form-check-solid mb-2">
                  <input
                    class="form-check-input"
                    v-model="form.has_vat"
                    type="checkbox"
                    value=""
                  />
                  <label class="form-check-label"> Oui </label>
                </div>

                <!-- <div class="text-muted fs-7">
                  Permettre aux clients d'acheter des produits en rupture de stock.
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <!-- End modal template  -->
  </div>
</template>
<style>
/* .image-input-placeholder {
  background-image: url("assets/bl-img.svg");
}

[data-bs-theme="dark"] .image-input-placeholder {
  background-image: url("assets/bl-img-dark.svg");
} */
</style>
<script>
import modalComponent from "../../components/modals/modalComponent.vue";
import { useCookie } from "@vue-composable/cookie";
import test from "../../pages/categories/categorieSave.js";
import useMoney from "../../services/moneyservices.js";
import { onMounted, onUpdated, ref } from "vue";
import store from "../../store";
export default {
  components: {
    modalComponent,
  },

  setup(props, { emit }) {
    const { money, errors, getMoney, storeMoney } = useMoney();
    onMounted(async () => {
      await callBackMounted();
    });

    async function callBackMounted() {
      await getMoney();
    }

    const createProduct = async (data) => {};
    const createCategories = async (data) => {
      store.commit("ServicePrices", data);

      emit("createPrice");
    };
    return {
      createCategories,
      money,
    };
  },

  data() {
    return {
      form: {
        label: "",
        price: "",
        money_id: undefined,
        // enterprise_id: useCookie("enterpriseActive").cookie.value,
      },
    };
  },
};
</script>
