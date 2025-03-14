<template>
  <div>
    <img
      alt="Logo"
      :src="`/storage/images/enterprise/${uuid}${logo.lg}`"
      class="h-65px app-sidebar-logo-default"
      @error="$event.target.src = '/assets/logo.png'"
    />
    <!-- small logo -->
    <img
      alt="Logo"
      :src="`/storage/images/enterprise/${uuid}${logo.sm}`"
      class="h-60px app-sidebar-logo-minimize"
      @error="$event.target.src = '/assets/logo.png'"
    />
  </div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import { useCookie } from "@vue-composable/cookie";
import useHistoryWebServices from "../../services/historyservices.js";
export default {
  setup() {
    const { getHistory, linkHistory } = useHistoryWebServices();
    onMounted(async () => {
      await callBackMounted();
    });
    let enterprise = reactive({});
    let uuid = ref("");

    try {
      enterprise = JSON.parse(useCookie("userAuth").cookie.value).data.enterprise
        ? JSON.parse(useCookie("userAuth").cookie.value).data.enterprise
        : {
            uuid: null,
          };
    } catch (error) {}
    uuid.value = enterprise.uuid;
    const image = reactive({
      light: {
        sm: enterprise.uuid + enterprise.logo_light_sm ? "/logo/logo_light_sm.png" : null,
        lg: enterprise.uuid + enterprise.logo_light_lg ? "/logo/logo_light_lg.png" : "",
      },
      dark: {
        sm: enterprise.uuid + enterprise.logo_dark_sm ? "/logo/logo_dark_sm.png" : "",
        lg: enterprise.uuid + enterprise.logo_dark_lg ? "/logo/logo_dark_lg.png" : "",
      },
    });

    const logo = reactive({
      sm: true ? image.light.sm : image.dark.sm,
      lg: true ? image.light.lg : image.dark.lg,
    });

    async function callBackMounted() {
      getHistory();
      //     document.documentElement.getAttribute("data-bs-theme") === "light"
      //   );
    }
    return {
      image,
      logo,
      uuid,
    };
  },
};
</script>
