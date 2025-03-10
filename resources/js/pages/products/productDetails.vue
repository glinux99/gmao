<template>
  <div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
      <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-10">
          <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
              <div class="me-7 mb-4">
                <div
                  class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"
                >
                  <img
                    :src="product.remember_pic_link + product.uom_id + '-0.png'"
                    @error="$event.target.src = '/images/no-image.png'"
                    alt="image"
                  />

                  <div
                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"
                  ></div>
                </div>
              </div>

              <div class="flex-grow-1">
                <div
                  class="d-flex justify-content-between align-items-start flex-wrap mb-2"
                >
                  <div class="d-flex flex-column">
                    <div class="d-flex align-items-center mb-2">
                      <a
                        href="#"
                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"
                        >{{ product.name }}</a
                      >
                      <a href="#"
                        ><i class="ki-duotone ki-verify fs-1 text-primary"
                          ><span class="path1"></span
                          ><span class="path2"></span></i
                      ></a>
                    </div>

                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                      <a
                        href="#"
                        class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"
                      >
                        <i class="ki-duotone ki-gift fs-4 me-1"
                          ><span class="path1"></span><span class="path2"></span
                          ><span class="path3"></span
                        ></i>
                        {{ product.type == "1" ? "Produit" : "Article" }}
                      </a>
                    </div>
                  </div>

                  <div class="card-toolbar d-flex justify-content-end">
                    <button
                      type="button"
                      class="btn btn-primary btn-sm ms-3"
                      data-kt-menu-trigger="click"
                      data-kt-menu-placement="bottom-end"
                    >
                      <i class="ki-duotone ki-cloud-download fs-2"
                        ><span class="path1"></span><span class="path2"></span
                      ></i>
                      Exporter
                    </button>
                    <div
                      class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                      data-kt-menu="true"
                      data-kt-menu-id="kt-users-tasks"
                    >
                      <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bold">
                          Exporter les donnees en :
                        </div>
                      </div>

                      <div class="separator border-gray-200"></div>

                      <div
                        class="form px-7 py-5"
                        data-kt-menu-id="kt-users-tasks-form"
                      >
                        <div class="fv-row mb-10 d-flex">
                          <button
                            @click="exportFile('excel')"
                            class="btn btn-outline badge-success px-5 py-1 btn-light-primary"
                          >
                            <i class="fa fa-file-excel text-success fs-2"
                              ><span class="path1"></span
                              ><span class="path2"></span
                            ></i>
                            Excel
                          </button>
                          <button
                            @click="exportFile('pdf')"
                            class="ms-1 btn btn-outline badge-danger px-5 py-1 btn-light-primary"
                          >
                            <i class="fa fa-file-pdf text-danger fs-2"
                              ><span class="path1"></span
                              ><span class="path2"></span
                            ></i>
                            PDF
                          </button>
                          <button
                            @click="exportFile('csv')"
                            class="ms-1 btn btn-outline badge-info px-5 py-1 btn-light-primary"
                          >
                            <i class="fa fa-file-csv text-info fs-2"
                              ><span class="path1"></span
                              ><span class="path2"></span
                            ></i>
                            CSV
                          </button>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-light-primary btn-sm">
                      <i class="ki-duotone ki-cloud-add fs-3"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span
                      ></i>
                      Importation
                    </button>
                  </div>
                </div>

                <div class="d-flex flex-wrap flex-stack">
                  <div class="d-flex flex-column flex-grow-1 pe-8">
                    <div class="d-flex flex-wrap">
                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          <i
                            class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                            ><span class="path1"></span
                            ><span class="path2"></span
                          ></i>
                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            data-kt-countup-value="4500"
                          >
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">
                          Val. Net Tot
                        </div>
                      </div>

                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          <li class="fa fa-store"></li>
                          &nbsp;

                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            :data-kt-countup-value="countElement(product.store)"
                          >
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">Depots</div>
                      </div>
                      <div
                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                      >
                        <div class="d-flex align-items-center">
                          <i
                            class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                            ><span class="path1"></span
                            ><span class="path2"></span
                          ></i>
                          <div
                            class="fs-2 fw-bold"
                            data-kt-countup="true"
                            :data-kt-countup-value="getAllQty(product.store)"
                          >
                            <!-- data-kt-countup-prefix="Litre" -->
                            0
                          </div>
                        </div>

                        <div class="fw-semibold fs-6 text-gray-400">
                          Qte Tot
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <ul
              class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-8"
            >
              <li class="nav-item mt-2">
                <a
                  class="nav-link text-active-primary pb-4 active"
                  data-bs-toggle="tab"
                  href="#kt_product_details"
                >
                  Details
                </a>
              </li>

              <li class="nav-item mt-2">
                <a
                  class="nav-link text-active-primary pb-4"
                  data-kt-countup-tabs="true"
                  data-bs-toggle="tab"
                  href="#kt_fiche_stock"
                >
                  Fiche de stocks
                </a>
              </li>

              <li class="nav-item mt-2">
                <a
                  class="nav-link text-active-primary pb-4"
                  data-kt-countup-tabs="true"
                  data-bs-toggle="tab"
                  href="#kt_ventes"
                >
                  Ventes
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="kt_product_details"
            role="tabpanel"
          >
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
              <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                  <h3 class="fw-bold m-0">Details du produit</h3>
                </div>

                <div
                  @click="editModal(product)"
                  class="btn btn-sm btn-primary align-self-center"
                >
                  Editer le produit
                </div>
              </div>

              <div class="card-body p-9">
                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted"
                    >Nom du produit</label
                  >

                  <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{
                      product.name
                    }}</span>
                  </div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted"
                    >Type de produit</label
                  >

                  <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{
                      product.type == "1" ? "Produit" : "Article"
                    }}</span>
                  </div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">
                    Description

                    <span class="ms-1">
                      <i class="ki-duotone ki-information fs-7"
                        ><span class="path1"></span><span class="path2"></span
                        ><span class="path3"></span
                      ></i>
                    </span>
                  </label>

                  <div class="col-lg-8 d-flex align-items-center">
                    {{ product.description }}
                  </div>
                </div>

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Depots</label>

                  <div class="col-lg-8">
                    <template
                      v-for="(deposit, i) in product.store"
                      :key="deposit.deposit_id"
                    >
                      <span class="badge badge-primary">{{
                        deposit.name
                      }}</span>
                      <template v-if="i < product.store.length - 1"
                        >&nbsp;,
                      </template>
                    </template>
                  </div>
                </div>

                <!-- <div class="row mb-7">
              <label class="col-lg-4 fw-semibold text-muted">
                Nom de l'entreprise

                <span class="ms-1">
                  <i class="ki-duotone ki-information fs-7"
                    ><span class="path1"></span><span class="path2"></span
                    ><span class="path3"></span
                  ></i>
                </span>
              </label>

              <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">Mans's</span>
              </div>
            </div> -->

                <div class="row mb-7">
                  <label class="col-lg-4 fw-semibold text-muted">Prix</label>

                  <div class="col-lg-8">
                    <template v-for="price in product.pricing" :key="price.id">
                      <span class="badge badge-secondary">
                        {{
                          `${price.label} : ${price.price} ${
                            price.money != undefined && price != ""
                              ? price.money?.abreviation
                              : " "
                          } &nbsp;`
                        }}
                      </span>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="kt_fiche_stock" role="tabpanel">
            fiche
          </div>
          <div class="tab-pane fade" id="kt_vente" role="tabpanel">ventes</div>
        </div>
      </div>
    </div>
    <modal-component
      id="product-modal"
      positionModal="center modal-fullscreen p-5 p-lg-10"
      :form="product2"
      activeBtn="false"
    >
      <template #title
        >{{
          updateProduct == null
            ? "Création d'un produit"
            : `Modification du produit ${updateProduct}`
        }}
      </template>
      <template>
        <productStore
          ref="updateModalStore"
          :is-modal="true"
          @callback="CloseModal"
          :initial-value="initialValue"
          :cancel-btn="cancelValue"
          :form2="data.value ? product2.value : form2"
          :tags="tags"
        />
      </template>
    </modal-component>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import useProducts from "../../services/productservices";
import modalComponent from "../../components/modals/modalComponent.vue";
import productStore from "./productStore.vue";
export default {
  components: {
    modalComponent,
    productStore,
  },
  setup() {
    const updateProduct = ref(null);
    const { products, getProducts, storeProducts, getProduct, product } =
      useProducts();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getProduct();
    }
    const countElement = (value) => {
      try {
        return value.length;
      } catch (error) {}
    };
    const getAllQty = (value) => {
      try {
        var qte = 0;
        value.forEach((element) => {
          qte += element.available_qte;
        });

        return qte;
      } catch (error) {}
    };
    const updateModalStore = ref(null);
    const executeCallbackMounted = (value) => {
      updateModalStore.value.updateModalStore(value);
    };
    const product2 = reactive({});
    const editModal = (value) => {
      updateProduct.value = value.name;
      console.log(updateProduct);
      executeCallbackMounted(value);

      $("#stepOne").trigger("click");
      $("#finishSteppHandler").trigger("click");

      $("#product-modal").modal("show");
      product2.value = value;
      tags.value.splice(0, tags.value.length);
      value.categories.map((item) => {
        tags.value.push(item.name);
      });

      initialValue.value.push(1);
    };
    return {
      editModal,
      updateProduct,
      getAllQty,
      product,
      product2,
      countElement,
      updateModalStore,
      executeCallbackMounted,
    };
  },
};
</script>
