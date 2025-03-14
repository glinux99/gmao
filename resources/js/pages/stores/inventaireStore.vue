<template>
  <div>
    <div class="card card-flush mb-6 mb-xl-9">
      <div class="card-header mt-6">
        <div class="card-title flex-column">
          <h2 class="mb-1">Inventaire</h2>

          <div class="fs-6 fw-semibold text-muted">
            {{ inventoryProducts.length }} article(s) par defaut
          </div>
        </div>

        <div class="card-toolbar">
          <button
            type="button"
            class="btn btn-light-primary btn-sm"
            @click="productModal"
          >
            <i class="ki-duotone ki-add-files fs-3"
              ><span class="path1"></span><span class="path2"></span
              ><span class="path3"></span
            ></i>
            Ajouter un service
          </button>
        </div>
      </div>

      <div class="card-body d-flex flex-column">
        <template v-for="product in inventoryProducts" :key="product.id">
          <div class="d-flex align-items-center position-relative mb-7">
            <div
              class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"
            ></div>

            <div class="d-flex flex-row justify-content-between w-100">
              <div class="fw-semibold ms-5">
                <a href="#" class="fs-5 fw-bold text-dark text-hover-primary">{{
                  product.name
                }}</a>

                <div class="fs-7 text-muted">
                  <a href="#">
                    {{ product.type == "1" ? "Produit" : "Service" }}
                  </a>
                </div>
              </div>

              <div>
                {{ product.available_qte }}
                {{ product.uom_symbol ?? "" }}
                <button
                  type="button"
                  class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                  data-kt-menu-trigger="click"
                  data-kt-menu-placement="bottom-end"
                >
                  <i class="ki-duotone ki-setting-3 fs-3"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span><span class="path4"></span
                    ><span class="path5"></span
                  ></i>
                </button>
                <div
                  class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                  data-kt-menu="true"
                  data-kt-menu-id="kt-users-tasks"
                >
                  <div class="px-7 py-5">
                    <div class="fs-5 text-dark fw-bold">Approvisionnement rapide</div>
                  </div>

                  <div class="separator border-gray-200"></div>

                  <form class="form px-7 py-5" data-kt-menu-id="kt-users-tasks-form">
                    <div class="fv-row mb-10">
                      <label class="form-label fs-6 fw-semibold">Qte:</label>
                      <!-- inout -->
                    </div>

                    <div class="d-flex justify-content-end">
                      <button
                        type="button"
                        class="btn btn-sm btn-light btn-active-light-primary me-2"
                        data-kt-users-update-task-status="reset"
                      >
                        Annuler
                      </button>

                      <button
                        type="submit"
                        class="btn btn-sm btn-primary"
                        data-kt-users-update-task-status="submit"
                      >
                        <span class="indicator-label"> valider </span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="form2"
      @cancel-btn="cancelBtn"
      @instance-modal="createProduct"
      activeBtn="false"
    >
      <template #title
        >{{
          updateProduct == null
            ? "Création d'un produit"
            : `Modification du produit ${updateProduct}`
        }}
      </template>
      <template #body>
        <productStore
          ref="updateModalStore"
          :is-modal="true"
          :form2="form2 ?? product.value"
        />
      </template>
      <template #footer>
        <div class="modal-footer">
          <div class="row col-12 p-0 m-0">
            <!-- code -->
            <div class="d-flex flex-row justify-content-end">
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

              <button type="button" @click="createProduct" class="btn btn-primary">
                <span class="indicator-label">Envoyer </span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import useProducts from "../../services/productservices";
import modalComponent from "../../components/modals/modalComponent.vue";
import productStore from "../products/productStore.vue";
import { useCookie } from "@vue-composable/cookie";
import useStock from "../../services/stockservices";
export default {
  components: {
    modalComponent,
    productStore,
  },
  props: ["inventoryProducts"],
  setup(props, { emit }) {
    const { inventoryProducts, getInventoryStore } = useProducts();
    const { ficheStock, getStockHistoryUser } = useStock();
    const authUser = reactive({});
    const store = reactive({});
    const product = reactive({});
    const tags = ref([]);
    const initialValue = ref([]);
    const updateProduct = ref(null);
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {}
    const productModal = () => {
      $("#product-modal").modal("show");
      updateModalStore.value.updateModalStore(null);
    };
    const form2 = reactive({
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
      uom_id: null,
      type: 1,
      pricing: [],
      available_qte: 0,
    });
    const initForm2 = JSON.stringify(form2);
    const CloseModal = async () => {
      await getInventoryStore(authUser.id);
      emit("callback");
    };
    const cancelBtn = () => {
      //   alert(111);
    };
    const updateModalStore = ref(null);
    const createProduct = async () => {
      updateModalStore.value.createProduct();
      form2.value = JSON.parse(initForm2);
      emit("callback");
    };
    return {
      createProduct,
      updateModalStore,
      cancelBtn,
      CloseModal,
      productModal,
      reactive,
      product,
      updateProduct,
      form2,
    };
  },
};
</script>
