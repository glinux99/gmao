<template>
  <div>
    <div id="kt_app_header" class="app-header h-50px">
      <div
        class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container"
      >
        <div
          class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2"
          title="Show sidebar menu"
        >
          <div
            class="btn btn-icon btn-active-color-primary w-35px h-35px"
            id="kt_app_sidebar_mobile_toggle"
          >
            <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1"
              ><span class="path1"></span><span class="path2"></span
            ></i>
          </div>
        </div>

        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
          <a href="#" class="d-lg-none">
            <img alt="Logo" src="/assets/logo.png" class="h-30px" />
          </a>
        </div>

        <div
          class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
          id="kt_app_header_wrapper"
        >
          <store-default
            @updateProduct="updateProduct"
            @defaultDeposit="defaultDeposit"
          />
        </div>
        <div class="app-navbar flex-shrink-0">
          <div class="app-navbar-item ms-1 ms-md-3">
            <div class="menu-item mx-3" @click="addModalProduct">
              <div class="btn btn-sm fw-bold btn-secondary text-primary">
                Entree argent
              </div>
            </div>
            <div class="menu-item mx-3" @click="addModalProduct">
              <div class="btn btn-sm fw-bold btn-secondary text-primary">
                Depense
              </div>
            </div>
            <div class="menu-item mx-3" @click="addModalProduct">
              <div class="btn btn-sm fw-bold btn-secondary text-primary">
                Dettes
              </div>
            </div>
            <div class="menu-item mx-3" @click="addModalProduct">
              <div class="btn btn-sm fw-bold btn-secondary text-primary">
                Mes ventes
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import enterpriseComponent from "../entreprises/enterpriseComponent.vue";
import storeDefault from "../stores/storeDefault.vue";

export default {
  components: {
    enterpriseComponent,
    storeDefault,
  },
  setup(prop, { emit }) {
    const updateProduct = () => {
      emit("updateProduct");
    };
    const defaultDeposit = (data) => {
      emit("defaultDeposit", data);
    };
    return {
      defaultDeposit,
      updateProduct,
    };
  },
};
</script>
