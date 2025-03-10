<template>
  <div></div>
</template>
<script>
import { onMounted } from "vue";
import useRoles from "../../services/roleservices.js";

export default {
  setup() {
    const { roles, getRolesPermissions } = useRoles();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getRolesPermissions();
    }
    // addRole(){
    //   $('#myModal').modal('show');
    // }
    return {
      roles,
    };
  },
};
</script>
