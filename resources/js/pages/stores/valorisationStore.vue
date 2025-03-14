<template>
  <div>
    <div class="card pt-4 mb-6 mb-xl-9">
      <div class="card-header border-0">
        <div class="card-title">
          <h2>Valorisation du stock</h2>
        </div>

        <div class="card-toolbar">
          <button
            type="button"
            class="btn btn-sm btn-flex btn-light-primary"
            id="kt_modal_sign_out_sesions"
          >
            <i class="ki-duotone ki-entrance-right fs-3"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            Effectuer un mouvement
          </button>
        </div>
      </div>

      <div class="card-body pt-0 pb-5">
        <div class="table-responsive">
          <table
            class="table align-middle table-row-dashed gy-5 text-center"
            id="kt_table_users_login_session"
          >
            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
              <tr class="text-muted text-uppercase gs-0">
                <th class="min-w-100px">Nom</th>
                <th>Qte disponible</th>
                <th>Total</th>
                <th class="d-none">Date de creation</th>
                <th class="d-none">Actions</th>
              </tr>
            </thead>
            <tbody class="fs-6 fw-semibold text-gray-600">
              <template v-for="product in products" :key="product">
                <tr>
                  <td>{{ product.name }}</td>
                  <td>
                    {{ `${product.available_qte} ${product.uom_symbol ?? ""}` }}
                  </td>
                  <td>
                    {{ product.total }}
                    {{
                      product.prices.length > 0
                        ? product.prices.filter((price) => price.principal == 1)[0]
                            .abreviation ?? money_name
                        : ""
                    }}
                  </td>
                  <td class="d-none"></td>
                  <td class="d-none"></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { onMounted } from "vue";
import useProducts from "../../services/productservices";
import moment from "moment";
export default {
  props: ["products"],
  setup() {
    const { products, getProductsStore, storeProducts } = useProducts();
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      //   await getProductsStore();
    }
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY");
    };
    return {
      convertDate,
    };
  },
};
</script>
