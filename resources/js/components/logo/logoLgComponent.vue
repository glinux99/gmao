<template>
  <div>xxxx</div>
</template>
<script>
import { onMounted, reactive, ref } from "vue";
import { useCookie } from "@vue-composable/cookie";
export default {
  setup() {
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
      sm:
        document.documentElement.getAttribute("data-bs-theme-mode") == "light"
          ? image.light.sm
          : image.dark.sm,
      lg:
        document.documentElement.getAttribute("data-bs-theme-mode") == "light"
          ? image.light.lg
          : image.dark.lg,
    });

    return {
      image,
      logo,
      uuid,
    };
  },
};
</script>
