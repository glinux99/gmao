<template>
  <div>
    <slot name="content" :data="data"></slot>
  </div>
</template>
<script>
import { useCookie } from "@vue-composable/cookie";
import { onMounted, reactive } from "vue";
export default {
  props: {
    data: {
      type: Object,
    },
    roles: {
      type: Object,
    },
  },
  setup(props) {
    let { cookie, setCookie, removeCookie } = useCookie("userAuth");
    onMounted(async () => {
      await callBackMounted();
    });
    const form = reactive({
      email: "",
      password: "",
    });
    async function callBackMounted() {
      form.user_mail = props.data.user_mail;
      form.password = props.data.password;
      props.data.roles = props.roles;
      if (props.data.active_enterprise != null) {
        location.href = "/admin/home";
      } else {
        location.href = "/admin/stepper";
      }
      setCookie(
        JSON.stringify({
          data: props.data,
          token: props.data.remember_token,
          stepper: props.data.active_enterprise != null ? false : true,
          status: true,
        })
      );
    }
  },

  data() {
    return {
      isLoading: false,
      errors: "",
    };
  },
};
</script>
