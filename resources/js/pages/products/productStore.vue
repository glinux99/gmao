<template>
  <div>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
      <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <form
            id="storeFormInput"
            action=""
            method="post"
            @submit.prevent="createProduct"
          >
            <div
              id="kt_app_content_container"
              class="app-container min-h-100 container-fluid pb-5"
            >
              <div class="d-flex flex-row gap-1">
                <div class="col-lg-6">
                  <div class="d-flex flex-column gap-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="card-title my-5 fw-bold text-dark fs-4">
                          Information sur le produit
                        </div>
                        <div>
                          <label class="required form-label">Nom du produit</label>
                          <input
                            ref="name_product"
                            type="text"
                            class="form-control mb-2"
                            placeholder="nom du produit"
                            v-model="form2.name"
                            required
                          />
                        </div>
                        <div>
                          <label class="form-label fw-normal fs-7">Description</label>
                          <div class="ms-auto">
                            <textarea
                              v-model="form2.description"
                              id=""
                              cols="20"
                              rows="3"
                              class="form-control bg-light"
                            ></textarea>
                          </div>
                        </div>

                        <div class="d-flex">
                          <div class="flex-fill mb-4">
                            <div>
                              <label class="form-label fw-normal fs-7"
                                >Reference manuelle</label
                              ><input
                                type="text"
                                v-model="form2.code_manuel"
                                class="form-control form-control-solid"
                                placeholder="##################"
                              />
                            </div>
                            <div class="d-flex flex-wrap gap-5 mb-4">
                              <div class="fv-row w-100 flex-md-root">
                                <label class="form-label">Categorie</label>
                                <input
                                  @change="categorieValue"
                                  id="add_product_categorie_tags"
                                  class="form-control mb-2"
                                  :data-bs-categories="categoriesDefault"
                                  :data-bs-whiteList="categoriesListString"
                                />

                                <button
                                  v-if="isModal != true"
                                  type="button"
                                  @click="addCategorieModal"
                                  class="btn btn-light-primary btn-sm"
                                >
                                  <i class="ki-duotone ki-plus fs-2"></i>categorie
                                </button>
                              </div>
                            </div>
                          </div>
                          <div>
                            <div class="d-flex">
                              <div class="card-body text-center">
                                <div
                                  class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                  data-kt-image-input="true"
                                  @click="openFileChangeImage('openFile1')"
                                >
                                  <div class="image-input-wrapper w-100px h-100px"></div>

                                  <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change"
                                    data-bs-toggle="tooltip"
                                    title="changer la photo"
                                    id="openFile1"
                                  >
                                    <i class="ki-duotone ki-pencil fs-7"
                                      ><span class="path1"></span
                                      ><span class="path2"></span
                                    ></i>

                                    <input
                                      type="file"
                                      @input="form2.photo"
                                      accept=".png, .jpg, .jpeg"
                                      @change="onFileChange($event)"
                                      aria-label="photo"
                                      multiple
                                    />
                                    <input type="hidden" name="avatar_remove" />
                                  </label>

                                  <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel"
                                    data-bs-toggle="tooltip"
                                    title="Annuler la photo"
                                  >
                                    <i class="ki-duotone ki-cross fs-2"
                                      ><span class="path1"></span
                                      ><span class="path2"></span
                                    ></i>
                                  </span>

                                  <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove"
                                    data-bs-toggle="tooltip"
                                    title="Supprimer la photo"
                                  >
                                    <i class="ki-duotone ki-cross fs-2"
                                      ><span class="path1"></span
                                      ><span class="path2"></span
                                    ></i>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="py-2 flex-grow-1">
                        <div class="border rounded-3 p-8">
                          <div
                            @click="barCodeGenereted"
                            class="btn btn-sm btn-primary"
                            id="generateBarcode"
                          >
                            {{
                              !barcode
                                ? "Voulez-vous ajouter les code-bares?"
                                : "generer un autre code-bares?"
                            }}
                          </div>
                          <input
                            type="text"
                            id="barcode-input"
                            v-model="form2.codebar"
                            hidden
                          />
                          <div class="w-100">
                            <svg
                              id="barcode-product"
                              class="d-none"
                              jsbarcode-format="upc"
                              jsbarcode-value="1000000000000"
                              jsbarcode-textmargin="0"
                              jsbarcode-fontoptions="bold"
                            ></svg>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="d-flex flex-column gap-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="card-title my-6 fw-bold text-dark fs-4">
                          Informations la logistique
                        </div>
                        <div :class="`row `">
                          <div class="col-6">
                            <label for="" class="form-label">Stock</label>
                            <select
                              :disabled="updateProduct"
                              class="form-select form-select-solid fw-bold"
                              data-control="select2"
                              id="selectClick3"
                              data-hide-search="true"
                              data-dropdown-css-class="w-230px"
                              data-placeholder="Selectionner un depot"
                            >
                              <option>Selectionner un depot</option>
                              <template v-for="deposit in deposits" :key="deposit.id">
                                <option :value="deposit.id">
                                  {{ deposit.name }}
                                </option>
                              </template>
                            </select>
                          </div>
                          <div class="col-6">
                            <label class="form-label">Quantite</label>
                            <input
                              type="number"
                              v-model="form2.available_qte"
                              class="form-control mb-2"
                              placeholder="quantite dans le depot"
                            />
                          </div>
                        </div>
                        <div class="d-flex align-items-center">
                          <div v-if="mesureUnity.length" class="flex-fill">
                            <div class="mb-3">
                              <label for="" class="form-label fw-normal fs-7"
                                >Unite</label
                              >
                              <select
                                id="SelectClick"
                                class="form-select form-select-solid fw-bold z-index-n1"
                                data-placeholder="Selectionner un type"
                                data-hide-search="true"
                                data-control="select2"
                                data-dropdown-css-class="w-230px"
                              >
                                <option>Selectionner unite</option>
                                <template v-for="unity in mesureUnity" :key="unity.id">
                                  <option :value="unity.id">
                                    {{ unity.name }}
                                  </option>
                                </template>
                              </select>
                            </div>
                          </div>
                          <div>
                            <button
                              type="button"
                              @click="addUnity"
                              class="btn btn-light-primary btn-sm mt-3"
                            >
                              <i class="ki-duotone ki-plus fs-2"></i>Unite
                            </button>
                          </div>
                        </div>
                        <div class="fv-row w-100 flex-md-root">
                          <label class="form-label">Montant de la TVA (%)</label>

                          <input
                            type="text"
                            class="form-control mb-2"
                            v-model="form2.has_vat"
                            placeholder="0"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="card card-body">
                      <div class="card-title my-5 fw-bold text-dark fs-4">
                        Informations la Tarification
                      </div>
                      <div class="row g-4">
                        <div class="fs-5 mb-1">Prix par defaut</div>
                        <div class="separator mb-2"></div>
                        <div class="row">
                          <template v-for="(price, i) in prices" :key="price.label">
                            <div class="col-6">
                              <div class="form-group">
                                <div class="d-flex justify-content-between">
                                  <a
                                    href="javascript:void(0)"
                                    @click="editModal(price)"
                                    class="col-lg-8 form-label"
                                  >
                                    {{ price.label }}
                                  </a>
                                  <div
                                    class="col-lg-4 d-flex justify-content-end"
                                    @click="deletePrice(price)"
                                  >
                                    <span class="menu-icon"
                                      ><i class="ki-duotone ki-trash fs-2"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                        ><span class="path3"></span
                                        ><span class="path4"></span></i
                                    ></span>
                                  </div>
                                </div>
                                <div class="input-group">
                                  <input
                                    @input="inputEnter(price, $event.target.value)"
                                    type="text"
                                    class="form-control"
                                    :value="price.price"
                                  />
                                  <div
                                    class="input-group-append"
                                    @click="editModal(price)"
                                  >
                                    <button class="btn btn-primary" type="button">
                                      {{ price.abreviation }}
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="mb-5" v-if="i % 2 != 0"></div>
                            </div>
                          </template>
                          <div
                            :class="` d-flex justify-content-end align-items-end ${
                              prices.length % 2 == 0 ? 'col-12' : 'col-6'
                            }`"
                            @click="editModal"
                          >
                            <div class="btn btn-primary btn-sm">
                              Ajouter un nouveau prix
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <a href="#kt_app_main" data-kt-scroll-toggle id="kt_app_main_scroll"></a>

              <div class="d-flex justify-content-end me-10 mt-5" v-if="!isModal">
                <button type="submit" class="btn btn-primary">
                  <span class="indicator-label" v-if="!isLoaging">Envoyer </span>
                  <span v-else>
                    Veuillez patienter svp...
                    <span
                      class="spinner-border spinner-border-sm align-middle ms-2"
                    ></span>
                  </span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <modalComponent
      :id="'price-modal'"
      positionModal="center mw-650px"
      :form="form"
      @instance-modal="createPrice"
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
                  required
                />

                <div class="text-muted fs-7">Configurer le nom pour ce prix</div>
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
                      required
                    />

                    <div class="text-muted fs-7">(Montant de ce prix, etc)</div>
                  </div>
                </div>
                <div class="col-5">
                  <div class="mb-5">
                    <label class="form-label fs-6 fw-semibold">Monnaie</label>

                    <select
                      id="SelectClick2"
                      class="form-select form-select-solid fw-bold"
                      data-placeholder="Selectionner une monnaie"
                      data-control="select2"
                      data-hide-search="true"
                      data-initialization="1"
                      data-dropdown-css-class="w-230px"
                    >
                      <template v-for="moneyOne in money" :key="moneyOne.id">
                        <option
                          :value="JSON.stringify(moneyOne)"
                          v-if="moneyOne.principal"
                        >
                          {{ moneyOne.abreviation + " (" + moneyOne.money_name + ")" }}
                        </option>
                        <option v-else :value="JSON.stringify(moneyOne)">
                          {{ moneyOne.abreviation + " (" + moneyOne.money_name + ")" }}
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
                    v-model="form2.has_vat"
                    type="checkbox"
                    value=""
                  />
                  <label class="form-check-label"> Oui </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </modalComponent>
    <!-- Modal template -->
    <modal-component
      positionModal="center mw-650px"
      :form="formUnity"
      :id="'unity-modal'"
      @instance-modal="createUnity"
      activeBtn="false"
    >
      <template #title>Création d'une unite de mesure</template>
      <template #body>
        <div class="card text-start">
          <div class="card-body">
            <div class="card-text">
              <div class="mb-5 fv-row">
                <label class="required form-label">Nom de votre unite de mesure</label>

                <input
                  type="text"
                  v-model="formUnity.name"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">
                  Configurer le nom de cette unite de mesure
                </div>
              </div>
              <div class="mb-5 fv-row">
                <label class="required form-label">Symbole</label>

                <input
                  type="text"
                  v-model="formUnity.symbol"
                  class="form-control mb-2"
                  placeholder=""
                />

                <div class="text-muted fs-7">(L=Litre, kg=Kilogramme, etc)</div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template #footer>
        <div class="modal-footer">
          <div class="row col-12 p-0 m-0">
            <!-- code -->

            <div class="d-flex flex-row justify-content-end me-10">
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
              <div @click="createUnity" class="btn btn-primary">
                <span class="indicator-label">Envoyer </span>
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
.image-input-placeholder {
  background-image: url("~/assets/bl-img.svg");
}

[data-bs-theme="dark"] .image-input-placeholder {
  background-image: url("~/assets/bl-img-dark.svg");
}
</style>
<script>
import categoryAdd from "../categories/categoryAdd.vue";
import modalPrice from "../../components/modals/modalPrice.vue";
import modalComponent from "../../components/modals/modalComponent.vue";
import useProducts from "../../services/productservices.js";
import priceAdd from "../prices/priceAdd.vue";
import useDeposit from "../../services/depositservices.js";
import useMoney from "../../services/moneyservices.js";
import test from "../categories/categorieSave.js";
import useMesureUnity from "../../services/mesureunityservices.js";
import { onMounted, onUpdated, reactive, ref, toRef, watch } from "vue";
import store from "../../store";
import instance from "../../api";
import JsBarcode from "jsbarcode";
import { notifications } from "../../notifications/notifications";
import useCategories from "../../services/categorieservices";
import { useCookie } from "@vue-composable/cookie";

export default {
  components: {
    // categoryAdd,
    modalComponent,
    modalPrice,
  },
  props: {
    initialValue: 0,
    tags: {
      type: Array,
    },
    form2: {
      type: Object,
      default: () => ({
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
        type: 1,
        pricing: [],
        available_qte: 0,
      }),
    },
    isModal: false,
  },
  setup(props, { emit }) {
    const { dataCreated } = notifications();

    let isLoaging = ref(false);
    const formUnity = reactive({
      id: null,
      name: "",
      symbol: "",
      enterprise_id: 1,
    });
    let prices = ref([]);
    const form2O = toRef(props, "form2");
    const { products, getProducts, storeProducts, enterpriseId } = useProducts();
    const { money, errors, getMoney, storeMoney } = useMoney();
    const { deposits, getDeposits, storeDeposit, removeDeposit } = useDeposit();
    const {
      mesureUnity,
      getMesureUnity,
      storeMesureUnity,
      deleteMesureUnity,
    } = useMesureUnity();
    const {
      categoriesListString,
      categories,
      getCategories,
      storeCategories,
    } = useCategories();
    const form = reactive({
      id: null,
      label: undefined,
      price: undefined,
      money_id: undefined,
      service_id: null,
      principal: null,
      abreviation: null,
    });
    const productForm = reactive({});
    const stepperIndex = ref(1);
    const nextStepper = () => {
      stepperIndex.value += 1;
      const backStepperElement = document.querySelector("#backStepper");
      const nextStepperElement = document.querySelector("#nextStepper");
      const submitElement = document.querySelector("#submit");
      const submitNextElement = document.querySelector("#submit-next");
      if (stepperIndex.value > 1 && stepperIndex.value < 4) {
        backStepperElement.classList.remove("d-none");
        submitNextElement.classList.remove("d-none");
        if (stepperIndex.value >= 3) {
          submitNextElement.classList.add("d-none");
          nextStepperElement.classList.add("d-none");
          submitElement.classList.remove("d-none");
        }
      } else {
        backStepperElement.classList.add("d-none");
        submitNextElement.classList.add("d-none");
      }

      if (stepperIndex.value >= 4) {
        stepperIndex.value = 1;

        document.querySelector("#submit-next").classList.add("d-none");
        submitElement.classList.add("d-none");
      }
    };
    const backStepper = () => {
      stepperIndex.value -= 1;

      const backStepperElement = document.querySelector("#backStepper");
      const nextStepperElement = document.querySelector("#nextStepper");
      const submitElement = document.querySelector("#submit");
      const submitNextElement = document.querySelector("#submit-next");
      if (stepperIndex.value > 1 && stepperIndex.value < 3) {
        backStepperElement.classList.remove("d-none");
        nextStepperElement.classList.remove("d-none");
        submitElement.classList.add("d-none");
      } else {
        backStepperElement.classList.add("d-none");
      }
      StepperGoTo(stepperIndex.value);
      if (stepperIndex.value < 1) {
        stepperIndex.value = 1;
      }
    };
    onMounted(async () => {
      await callBackMounted();
    });
    const handleSelectChange = (event) => {
      props.form2.uom_id = event.target.value;
    };
    const handleSelectChange2 = (event) => {
      form.money_id = JSON.parse(event.target.value);

      lastedMoney.value = form.money_id;
    };
    const lastedMoney = ref({});
    watch(props.initialValue, (data, data2) => {
      stepperIndex.value = 1;
      // Effectuez les actions souhaitées lorsque la propriété props.tags change
    });
    watch(props.tags, (newTags, oldTags) => {
      // Effectuez les actions souhaitées lorsque la propriété props.tags change
      test.initTagify(categoriesListString.value.split(","), newTags);
    });
    // cette fonction est executer lorqu on veut faire l update du produit via product list
    const updateProduct = ref(false);
    const updateModalStore = (value) => {
      let id = null;
      try {
        id = JSON.parse(useCookie("store").cookie.value);
      } catch (error) {}
      $("#selectClick3").val(id).trigger("change");
      props.form2.deposit_id = id;
      updateProduct.value = true;
      if (value != null) {
        updateProduct.value = true;
        prices.value = value.prices;
        $("#SelectClick").val(value.uom_id).trigger("change");
      } else {
        callBackMounted();
        // alert(123);
      }
    };
    // document.body.addEventListener("click", (event) => {
    //   // Vérifiez si une modal est ouverte
    //   const modal = document.querySelector(".modal");
    //   if (modal) {
    //     // Annulez l'événement `click`
    //     event.preventDefault();
    //   }
    // });

    async function callBackMounted() {
      await getDeposits();
      await getMoney();
      await getMesureUnity();
      await getCategories();

      //   document.querySelector("#choiceService").classList.add("border-primary");
      $("#SelectClick").on("change", handleSelectChange);
      $("#SelectClick2").on("change", handleSelectChange2);
      $("#selectClick3").on("change", handleSelectChange3);

      test.initTagify(categoriesListString.value.split(","), props.tags);

      inititPrices();
      form.money_id = money.value[0];
    }
    function inititPrices() {
      prices.value = [
        {
          id: 1,
          label: "Prix de vente detail",
          price: 0,
          money_id: money.value[0],
          abreviation: money.value[0].abreviation,
        },

        {
          id: 2,
          label: "Prix de vente gros",
          price: 0,
          money_id: money.value[0],
          abreviation: money.value[0].abreviation,
        },
        {
          id: 3,
          label: "Prix casse",
          price: 0,
          money_id: money.value[0],
          abreviation: money.value[0].abreviation,
        },
      ];
    }
    const choiceService = (value) => {
      if (value == "service") {
        document.querySelector("#choiceService").classList.remove("border-primary");
      } else {
        document.querySelector("#choiceService").classList.add("border-primary");
      }
      //
      props.form2.type = value;
    };
    let lastMoney = reactive({});
    const createPrice = async (data) => {
      try {
        lastMoney = prices.value[prices.value.length - 1].money_id;
      } catch {
        lastMoney = money.value[0];
      }

      if (typeof data.id == "number" && data.id != 0) {
        let index = prices.value.findIndex(
          (prices) => prices.id == data.id || prices.label == data.label
        );
        prices.value[index].label = data.label;
        prices.value[index].price = data.price;
        prices.value[index].money_id =
          typeof data.money_id == "number"
            ? money.value.filter((moneys) => (moneys.id = data.money_id))[0]
            : data.money_id;
        prices.value[index].abreviation =
          typeof data.money_id == "number"
            ? money.value.filter((moneys) => (moneys.id = data.money_id))[0].abreviation
            : data.money_id.abreviation;
        form.price = 0;
        form.label = "";
        form.abreviation = "";
        form.id = null;
      } else {
        data.id = prices.value.length + 1;
        // data.money_id = data.money_id?.id ?? lastMoney ?? money[0];
        data.money_id = form.money_id;
        data.abreviation = form.money_id.abreviation;
        prices.value.push(data);
        form.price = 0;
        form.label = "";
        form.id = null;
        form.abreviation = "";
      }
    };
    const addCategorieModal = () => {
      $("#categorie-modal").modal("show");

      $("product-modal").modal("handleUpdate", false);
    };

    const editModal = (value) => {
      //   $("#finishSteppHandler").trigger("click");
      $("#price-modal").modal("show");

      $("product-modal").modal("handleUpdate", false);
      form.label = value.label;
      form.price = value.price;
      form.money_id = Object.keys(lastedMoney.value).length
        ? lastedMoney.value
        : value.money_id;
      form.id = value.id;
    };
    const deletePrice = (value) => {
      let index = prices.value.findIndex(
        (price) => price.id == value.id || price.label == value.label
      );
      prices.value.splice(index, 1);
    };

    // watch(props.form2);
    let images = ref([]);
    const createProduct = async () => {
      try {
        props.form2.category_id = props.form2.category_id.map((item) => item.value);
      } catch (error) {}
      isLoaging.value = true;
      try {
        props.form2.pricing = JSON.parse(JSON.stringify(prices.value));
        props.form2.pricing = props.form2.pricing.forEach((elment) => {
          elment.money_id = elment.money_id.id;
        });
      } catch (error) {}
      console.log(props.form2);
      props.form2.uuid = null;
      props.form2.type = "1";
      for (const [key, value] of Object.entries(props.form2)) {
        productForm[key] = value;
      }
      productForm["pricing"] = prices.value;
      console.log({ ...productForm });
      await storeProducts({ ...productForm }, productForm.id, images);
      await getProducts();

      try {
        for (const [key, value] of Object.entries(props.form2)) {
          props.form2[key] =
            typeof value == "string" ? "" : typeof value == "number" ? null : null;
        }
        p;
        props.form2.uom_id = null;
        $("#selectClick3").val("").trigger("change");
        $("#SelectClick").val("").trigger("change");
      } catch (error) {}

      dataCreated();
      prices.value = [];

      document.getElementById("kt_app_main_scroll").click();
      emit("callback");
      inititPrices();
      $(".closeBtn").trigger("click");
      isLoaging.value = false;
    };
    const categorieValue = (e) => {
      let values = [];
      try {
        values = JSON.parse(e.target.value);
        props.form2.category_id = values[values.length - 1].value;
        props.form2.category_id = [];
        values.forEach((element) => {
          props.form2.category_id.push(element);
        });
      } catch (error) {}
    };
    const onFileChange = (event) => {
      const files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        try {
          images.value.push(files[i]);
        } catch (error) {}
      }
    };
    const barcode = ref(false);
    const barCodeGenereted = () => {
      barcode.value = true;
    };

    watch(
      () => props.form2.pricing,
      (newValue) => {
        try {
          props.form2.pricing.forEach((price) => {
            createPrice(price);
          });
        } catch (error) {}
        // props.form2.available_qte = props.form2.store[0].available_qte;
        // // deposits.Pvalue = props.form2.store;

        // Perform any additional logic when the prop changes
      }
    );
    const createUnity = async () => {
      formUnity.id = null;

      await storeMesureUnity({ ...formUnity });
      dataCreated();
      await getMesureUnity();
      $("#annuler").click();
      test.initTagify(categoriesListString.value.split(","), props.form2.category_id);
      const dernierElement = mesureUnity.value[mesureUnity.value.length - 1];
      props.form2.uom_id = dernierElement.id;
      $("#SelectClick").val(dernierElement.id).trigger("change");
    };
    const submitRapidement = async () => {
      await createProduct();
      stepperIndex.value = 1;
      document.querySelector("#submit").classList.add("d-none");
      document.querySelector("#submit-next").classList.add("d-none");
      document.querySelector("#backStepper").classList.add("d-none");
      document.querySelector("#nextStepper").classList.add("d-none");
    };
    const inputEnter = (data, value) => {
      data.price = value;
      createPrice(data);
    };
    const handleSelectChange3 = (event) => {
      props.form2.deposit_id = event.target.value;
    };
    const openFileChangeImage = (id) => {
      $(`#${id}`).click();
    };
    const categoriesDefault = "";
    const addUnity = () => {
      $("#unity-modal").modal("show");
      $("product-modal").modal("handleUpdate", false);
    };
    return {
      addUnity,
      updateProduct,
      nextStepper,
      backStepper,
      updateModalStore,
      inputEnter,
      submitRapidement,
      openFileChangeImage,
      createUnity,
      formUnity,
      addCategorieModal,
      deletePrice,
      barCodeGenereted,
      barcode,
      choiceService,
      handleSelectChange3,
      images,
      onFileChange,
      money,
      form,
      categorieValue,
      createPrice,
      createProduct,
      editModal,
      deposits,
      storeMesureUnity,
      prices,
      formUnity,
      isLoaging,
      getMesureUnity,
      mesureUnity,
      categoriesListString,
      categoriesDefault,
    };
  },
  methods: {
    clearnData() {
      //   this.form.label = "";
      alert("coucou");
    },
  },
  // data() {
  //   return {

  //   };
  // },
};
</script>
9
