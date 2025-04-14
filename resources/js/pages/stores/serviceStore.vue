<template>
  <div>
    <div class="card pt-4 mb-6 mb-xl-9">
      <div class="card-header border-0">
        <div class="card-title">
          <h2>Services</h2>
        </div>

        <div class="card-toolbar">
          <div @click="affectModal" class="btn btn-sm btn-primary">
            <i class="ki-duotone ki-plus fs-2"></i> produit
          </div>
        </div>
      </div>

      <div class="card-body py-4">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
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
                    data-kt-check-target="#kt_table_users .form-check-input"
                    value="1"
                  />
                </div>
              </th>
              <th>Image</th>
              <th class="min-w-125px">Nom</th>

              <th class="min-w-100px">Description</th>

              <th class="d-none"></th>
              <th class="d-none"></th>
              <th class="d-none"></th>

              <th class="text-end min-w-100px">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 fw-semibold">
            <template v-for="product in productStores" :key="product.id">
              <tr>
                <td>
                  <div
                    class="form-check form-check-sm form-check-custom form-check-solid"
                  >
                    <input class="form-check-input" type="checkbox" value="1" />
                  </div>
                </td>
                <td class="d-flex align-items-center">
                  <!-- {{-- Avatar --}} -->
                  <div
                    v-if="product.photo == null"
                    class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                  >
                    <div>
                      <div class="symbol-label fs-3 bg-light-danger text-danger">
                        <!-- {{
                                                    $user->user_name[0] }} -->
                        {{ product.name[0] }}
                      </div>
                    </div>
                  </div>

                  <div
                    v-else
                    class="symbol symbol-circle symbol-50px overflow-hidden me-3"
                  >
                    <a href="">
                      <div class="symbol-label">
                        <img
                          :src="product.remember_pic_link + product.uom_id + '-0.png'"
                          alt="&nbsp;Erreur"
                          class="w-100"
                          @error="$event.target.src = '/images/no-image.png'"
                        />
                      </div>
                    </a>
                  </div>
                </td>
                <td @click="viewProduct(product.id)">
                  {{ product.name }}
                </td>
                <td>
                  {{ product.description ?? "" }}
                </td>

                <td class="d-none"></td>
                <td class="d-none"></td>
                <td class="d-none"></td>
                <td class="text-end">
                  <button
                    class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                    @click="editModal(product)"
                  >
                    <i class="ki-duotone ki-pencil fs-3"
                      ><span class="path1"></span><span class="path2"></span
                      ><span class="path3"></span><span class="path4"></span
                      ><span class="path5"></span
                    ></i>
                  </button>
                  <button
                    class="btn btn-icon btn-active-light-primary w-30px h-30px"
                    data-kt-permissions-table-filter="delete_row"
                  >
                    <i class="ki-duotone ki-trash fs-3"
                      ><span class="path1"></span><span class="path2"></span
                      ><span class="path3"></span><span class="path4"></span
                      ><span class="path5"></span
                    ></i>
                  </button>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="form2"
      @instance-modal="createProduct"
      activeBtn="false"
    >
      <template #title>
        {{
          updateProduct == null
            ? "Création d'un produit"
            : `Modification du produit ${updateProduct}`
        }}
      </template>
      <template #body="{ form2 }">
        <productStore
          ref="updateModalStore"
          :is-modal="true"
          @callback="productClb"
          :initial-value="initialValue"
          :form2="product.value ?? form2"
          :tags="tags"
        />
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
              <button type="submit" class="btn btn-primary">
                <span class="indicator-label">Envoyer </span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
    <modal-component
      id="affect-modal"
      :positionModal="`right`"
      @instance-modal="affectService"
      activeBtn="false"
      :isCss="true"
    >
      <template #title>Affecter de produit a ce depot </template>
      <template #body>
        <div class="mx-5">
          <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            <input
              type="text"
              v-model="searchService"
              :class="`ps-13 form-control form-control-lg form-control-solid`"
              :placeholder="`chercher un service`"
            />
          </div>
          <div class="mx-5">
            <div class="card-body">
              <table
                class="table align-middle table-row-dashed fs-6 gy-5"
                id="kt_table_usersxx2"
              >
                <thead>
                  <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-180px">Item selectionner</th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                    <th class="d-none"></th>
                  </tr>
                </thead>

                <tbody class="fw-bold text-gray-600">
                  <template v-for="service in products" :key="service.id">
                    <tr class="w-100">
                      <td class="">
                        <label class="d-flex flex-stack cursor-pointer">
                          <span class="d-flex align-items-center me-2">
                            <span class="symbol symbol-50px me-6">
                              <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-compass fs-1 text-primary"
                                  ><span class="path1"></span><span class="path2"></span
                                ></i>
                              </span>
                            </span>

                            <span class="d-flex flex-column">
                              <span class="fw-bold fs-6">{{ service.service.name }}</span>
                            </span>
                          </span>

                          <span class="form-check form-check-custom form-check-solid">
                            <input
                              @change="checkedValue(service.service)"
                              :class="`form-check-input service_${service.service.id}`"
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
        </div>
      </template>
      <template #footer>
        <div class="modal-footer">
          <div class="row col-12 p-0 m-0">
            <!-- code -->

            <div class="d-flex flex-row justify-content-between">
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
              <button type="submit" class="btn btn-dark">
                <span class="indicator-label">Desacffecter </span>
              </button>
              <button type="submit" class="btn btn-primary">
                <span class="indicator-label">Affecter </span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </modal-component>
  </div>
</template>
<style>
#info-modal-content3 {
  max-height: 75vh;
  overflow-y: auto;
}
</style>
<script>
import { computed, onMounted, reactive, ref } from "vue";
import useProducts from "../../services/productservices";
import modalComponent from "../../components/modals/modalComponent.vue";
import productStore from "../products/productStore.vue";
import moment from "moment";
import productStoreVue from "../products/productStore.vue";
import { notifications } from "../../notifications/notifications";
import { useCookie } from "@vue-composable/cookie";
import useDeposit from "../../services/depositservices";
export default {
  components: {
    modalComponent,
    productStore,
  },
  props: ["productsProps"],
  setup(props, { emit }) {
    const product = reactive({});
    const tags = ref([]);
    const initialValue = ref([]);
    const updateProduct = ref(null);
    const { dataCreated, swal } = notifications();
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
    const searchService = ref("");
    const { storeServiceDeposit } = useDeposit();
    const {
      products,
      productStores,
      getProductsStore,
      storeProducts,
      getProducts,
    } = useProducts();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getProductsStore(useCookie("store").cookie.value);
      await getProducts();
    }
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY");
    };
    const json_fields = {
      "Produit/Article": "service.name",
      Description: "service.description",
      "Date de création": "service.created_at",
      Qantité: "service.available_qte",
      //   prix: "service.prices[0].price",
    };
    const updateModalStore = ref(null);
    const executeCallbackMounted = (value) => {
      updateModalStore.value.updateModalStore(value);
    };
    const affectModal = () => {
      productStores.value.forEach((el) => {
        $(`.service_${el.id}`).prop("checked", true);
        // affectedList.value.push({
        //   service: el,
        // });
      });
      $("#affect-modal").modal("show");
    };
    const editModal = (value) => {
      $("#product-modal").modal("show");
      executeCallbackMounted(value);
      try {
        updateProduct.value = value.name;
        product.value = value;
        tags.value.splice(0, tags.value.length);
        value.categories.map((item) => {
          tags.value.push(item.name);
        });

        initialValue.value.push(1);
      } catch (error) {}

      //   $("#stepOne").trigger("click");
      //   $("#finishSteppHandler").trigger("click");
    };
    const alertBtn = (type) => {
      swal(
        "question",
        "Question",
        `Voulez-vous desaffecter ce ${type == "1" ? "article" : "service"} de ce depot?`,
        "Oui, d'accord",
        "Annuler",
        () => {},
        () => {},
        "",
        "btn-danger"
      );
    };
    const createProduct = () => {
      updateModalStore.value.createProduct();
    };
    const productClb = async () => {
      await getProductsStore(useCookie("store").cookie.value);
      emit("productClb");
    };
    const affectedList = ref([]);
    const checkedValue = (service) => {
      const element = document.querySelector(`.service_${service.id}`);
      if (element.checked) {
        affectedList.value.push({
          service: service,
          available_qte: 0,
        });
      } else {
        affectedList.value = affectedList.value.filter(
          (el) => el.service.id != service.id
        );
      }
    };
    const affectService = async () => {
      await storeServiceDeposit({
        depositId: useCookie("store").cookie.value,
        services: affectedList.value,
      });
      await getProductsStore(useCookie("store").cookie.value);
      affectedList.value = [];
      emit("productClb");
      await getProducts();
    };
    const filteredServices = computed(() => {
      if (!searchService.value) {
        return products;
      }
      const result = products.value.filter((product) =>
        product.service.name.toLowerCase().includes(searchService.value.toLowerCase())
      );
      result.sort((a, b) => a.service.name.localeCompare(b.service.name));
      console.log(1111);
      return result;
    });
    return {
      filteredServices,
      affectService,
      checkedValue,
      productStores,
      products,
      productClb,
      alertBtn,
      json_fields,
      convertDate,
      editModal,
      product,
      form2,
      createProduct,
      updateProduct,
      updateModalStore,
      initialValue,
      tags,
      affectModal,
      searchService,
    };
  },
};
</script>
