<template>
  <div>
    <div class="d-flex">
      <span class="menu-text">
        {{ entreprises.length ? "Mes entreprises" : "Mon entreprise" }}</span
      >
      <span class="menu-badge">
        <span class="badge badge-light-danger badge-circle fw-bold fs-7">
          {{ entreprises.length }}
        </span>
      </span>
    </div>
  </div>
</template>
<script>
import { onMounted } from "vue";
import useEntreprises from "../../services/enterpriseservices.js";
export default {
  setup() {
    const { entreprises, getEntreprise } = useEntreprises();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      await getEntreprise();
    }
    return {
      entreprises,
    };
  },
};
</script>
