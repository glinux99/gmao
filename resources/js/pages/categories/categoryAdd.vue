<template>
  <div>
    <!-- Modal template -->
    <modal-component
      :id="'categorie-modal'"
      :positionModal="`${positionModal} mw-650px`"
      :form="form"
      @instance-modal="createCategories"
    >
      <template #title>Création d'une categorie</template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div class="card-text">
              <div class="mb-5 fv-row">
                <label class="required form-label"
                  >Nom de votre categorie</label
                >

                <input
                  type="text"
                  v-model="form.name"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">
                  Configurer le nom de cette categorie
                </div>
              </div>
              <div class="mb-5 fv-row">
                <label class="required form-label">Type de conservation</label>

                <input
                  type="text"
                  v-model="form.type_conservation"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">
                  (carton, boite de conserve, sachet, etc)
                </div>
              </div>
              <div class="mb-5 fv-row">
                <label class="required form-label">Description</label>

                <textarea
                  v-model="form.description"
                  id=""
                  cols="20"
                  rows="2"
                  class="form-control"
                ></textarea>
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
import useCategories from "../../services/categorieservices.js";
import test from "./categorieSave.js";
import { onMounted, onUpdated, ref } from "vue";
import { notifications } from "../../notifications/notifications";
export default {
  components: {
    modalComponent,
  },
  props: ["positionModal"],
  setup(props, { emit }) {
    const { categoriesListString, categories, getCategories, storeCategories } =
      useCategories();
    const { dataCreated } = notifications();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      props.positionModal = " center";
      await getCategories();
      test.initTagify(categoriesListString.value.split(","));
    }
    const createProduct = async (data) => {};
    const createCategories = async (data) => {
      await storeCategories(data);

      dataCreated();
      await getCategories();
      emit("callbackCat");

      test.initTagify(categoriesListString.value.split(","));
    };
    return {
      createProduct,
      createCategories,
      categoriesListString,
      getCategories,
      categories,
    };
  },

  data() {
    return {
      form: {
        id: null,
        name: "",
        type_conservation: "",
        category: "",
        has_vat: "",
        enterprise_id: 1,
        // enterprise_id: useCookie("enterpriseActive").cookie.value,
        description: "",
      },
    };
  },
};
</script>
