<template>
  <div>
    <span class="mb-8 font-bold fs-5 text-3xl ms-2 text-muted my-auto"
      >Monnaie par defaut</span
    >
    <div class="separator"></div>
    <template v-for="monnaie in money" :key="monnaie.id">
      <div class="menu-item px-3 my-0">
        <span
          @click="changeDefault(monnaie)"
          :class="`menu-link  px-3 py-2 ${monnaie.principal == 1 ? 'active' : ''}`"
        >
          <span class="menu-icon" data-kt-element="icon">
            <i class="ki-duotone ki-bill fs-2"
              ><span class="path1"></span><span class="path2"></span
              ><span class="path3"></span><span class="path4"></span
              ><span class="path5"></span><span class="path6"></span
              ><span class="path7"></span><span class="path8"></span
              ><span class="path9"></span><span class="path10"></span
            ></i>
          </span>
          <span class="menu-title"> {{ monnaie.abreviation }} </span>
        </span>
      </div>
    </template>
  </div>
</template>
<script>
import { onMounted } from "vue";
import useMoney from "../../services/moneyservices";
export default {
  setup() {
    const { money, errors, getMoney, storeMoney } = useMoney();
    onMounted(async () => {
      await callBackMounted();
    });

    async function callBackMounted() {
      await getMoney();
    }
    const changeDefault = async (data) => {
      data.principal = 1;
      await storeMoney({ ...data });
      location.reload();
    };
    return {
      money,
      changeDefault,
    };
  },
};
</script>
