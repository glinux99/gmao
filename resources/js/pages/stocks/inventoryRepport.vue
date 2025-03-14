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
                Inventaire
              </h1>
            </div>
          </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
          <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
              <div class="card-header border-0 pt-6">
                <div class="card-title">
                  <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                    <input
                      type="text"
                      data-kt-user-table-filter="search"
                      :class="`form-control form-control-solid w-250px  ps-13 ${disable}`"
                      :placeholder="`chercher dans l'historiques `"
                    />
                    <input
                      type="text"
                      v-model="search"
                      data-kt-user-table-filter="search"
                      :class="`form-control form-control-solid v-auto  ps-13 ${
                        disable == 'd-none' ? ' ' : 'd-none'
                      }`"
                      :placeholder="`chercher dans l'historiques`"
                    />
                  </div>
                </div>
              </div>

              <div class="card-body py-4">
                <inventaire-store
                  @callback="callback"
                  :inventoryProducts="inventoryProducts"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { notifications } from "../../notifications/notifications";
import { computed, onMounted, reactive, ref, watch } from "vue";
import inventaireStore from "../stores/inventaireStore.vue";
import useProducts from "../../services/productservices";

export default {
  components: {
    inventaireStore,
  },
  setup(props, { emit }) {
    const {
      products,
      productStores,
      getProductsStore,
      storeProducts,
      inventoryProducts,
      getInventoryStore,
    } = useProducts();
    onMounted(async () => {
      await callBackMounted();
    });

    async function callBackMounted() {}
    const callback = () => {};
    return {
      callback,
      inventoryProducts,
    };
  },
};
</script>
