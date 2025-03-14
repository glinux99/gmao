<template>
  <div>
    <div id="kt_app_toolbar" class="app-toolbar">
      <div
        id="kt_app_toolbar_container"
        class="app-container container-xxl d-flex flex-column"
      >
        <div
          v-if="linkHistory.active"
          class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
        >
          <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-3">
            <li class="breadcrumb-item text-muted">
              <a :href="linkHistory.host" class="text-muted text-hover-primary back-lin">
                {{ linkHistory.name }}
              </a>
            </li>

            <li class="breadcrumb-item">
              <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>

            <li class="breadcrumb-item text-muted">{{ linkHistory.title }}</li>
          </ul>
        </div>
        <div class="card w-100 h-50px d-flex ps-5 justify-content-center my-3">
          <h1 class="fs-5 my-0">
            <span class="text-primary fw-bold"> DEMO MODE : </span>
            <span class="text-dark fw-normal"
              >Some features are disabled for this installation
            </span>
            &nbsp; - &nbsp;<a href="#"> upgrate it &nbsp;</a>
            <span>
              <span class="text-dark fw-normal"> in 30 days</span>
            </span>
          </h1>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import useHistoryWebServices from "../services/historyservices.js";
export default {
  setup() {
    const { getHistory, linkHistory } = useHistoryWebServices();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      getHistory();
      //     document.documentElement.getAttribute("data-bs-theme") === "light"
      //   );
    }
    return {
      linkHistory,
    };
  },
};
</script>
