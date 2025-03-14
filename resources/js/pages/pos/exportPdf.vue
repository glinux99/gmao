<template>
  <div class="bg-white text-dark">
    <div class="mx-20 my-10" data-bs-theme="light">
      <div class="row justify-content-start align-items-center">
        <div class="col-md-6 d-flex justify-content-start align-items-center">
          <img
            alt="Logo"
            :src="
              enterprise.logo_light_lg
                ? `/storage/images/enterprise/${enterprise.uuid}/logo/logo_light_lg.png`
                : '/favicon.ico'
            "
            width="80"
            @error="$event.target.src = '/favicon.ico'"
          />
          <div class="text-dark fw-bold display-4">
            {{ invoices.enterprise.name }}
          </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          <div class="">
            <svg
              id="barcode-invoice"
              jsbarcode-format="upc"
              jsbarcode-value="1000000000000"
              jsbarcode-textmargin="0"
              jsbarcode-fontoptions="bold"
            ></svg>
          </div>
        </div>
      </div>
      <div class="my-3">
        <div class="text-dark fw-bold display-4 text-uppercase">
          FACTURE {{ invoices.type_facture }}
        </div>
      </div>
      <div class="bg-primary w-200px h-5px">&nbsp;</div>
      <div class="card-group bg-transparent">
        <div class="card bg-transparent">
          <div class="text-dark fw-bold">{{ invoices.enterprise.name }}</div>
          <address class="text-dark fw-bold">
            {{
              invoices.enterprise.adresse ||
              "impossible de localiser cette entreprise"
            }}
          </address>
        </div>
        <div class="card bg-transparent flex-column">
          <div class="d-flex flex-row justify-content-between">
            <div class="text-dark fw-bold text-uppercase">Numéro de Fact.</div>
            <div class="text-dark">
              #{{ invoices.id.toString().padStart(10, "0") }}
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between">
            <div class="text-dark fw-bold text-uppercase">Ordre</div>
            <div class="text-dark">
              #{{ invoices.orderId.toString().padStart(10, "0") }}
            </div>
          </div>
          <div class="d-flex flex-row justify-content-between">
            <div class="text-dark fw-bold text-uppercase">Date d'emission</div>
            <div class="text-dark">{{ convertDate(invoices.created_at) }}</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <span class="text-dark fw-bold text-uppercase">Facturé à</span>
          <div class="d-flex justify-content-between">
            <div class="pe-5">
              <div class="col">
                <div class="text-gray-700 fw-bold">Noms du client</div>
                <div
                  class="text-dark"
                  v-if="invoices.customer != null && invoices.customer.id != 1"
                >
                  {{ invoices.customer.customerName || "Anonyme" }}
                </div>
              </div>
            </div>
            <div class="">
              <div class="text-gray-700 fw-bold">Adresse</div>
              <div class="text-dark">
                <address
                  v-if="invoices.customer != null && invoices.customer.id != 1"
                >
                  {{ invoices.customer.adress || "Anonyme" }}<br />

                  {{
                    invoices.customer.phone
                      ? "Tel: " + invoices.customer.phone
                      : ""
                  }}
                </address>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6">
          <span class="text-dark fw-bold">PAYEMENT & LIVRAISON</span>
          <div class="mb-4">
            <div class="text-gray-700 fw-bold text-uppercase">
              Methode de livraison
            </div>
            <div class="text-dark">Immediate</div>
          </div>
          <div class="">
            <div class="text-gray-700 fw-bold text-uppercase">
              methode de payement
            </div>
            <div class="text-dark">{{ invoices.payment_mode }}</div>
          </div>
        </div>
      </div>
      <div class="">
        <div class="card-body py-4">
          <table class="table align-middle fs-6 gy-5" id="kt_table_users">
            <thead>
              <tr
                class="text-center text-dark fw-bold fs-7 text-uppercase gs-0 table-primary"
              >
                <th>Qte</th>
                <th class="min-w-125px">Designation</th>
                <th class="min-w-125px">Prix unit</th>
                <th class="min-w-125px">Montant</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold text-center">
              <template v-for="service in invoices.details" :key="service.id">
                <tr class="border-bottom border-2 border-primary">
                  <td>{{ service.quantity }}</td>
                  <td>{{ service.service.name }}</td>
                  <td>
                    {{
                      service.service.pricing.filter((price) => {
                        return price.principal == 1;
                      })[0].price
                    }}
                  </td>
                  <td>
                    {{
                      service.service.pricing.filter((price) => {
                        return price.principal == 1;
                      })[0].price * service.quantity
                    }}
                  </td>
                </tr>
              </template>
            </tbody>
            <tfoot>
              <tr class="border-top border-2 border-primary p-0 m-0">
                <td class="p-0 m-0"></td>
                <td class="p-0 m-0"></td>
                <td class="p-2 m-0">Montant HT</td>
                <td class="p-2 m-0">
                  {{ billsSubTotal }}
                </td>
              </tr>
              <tr class="p-0 m-0">
                <td class="p-0 m-0"></td>
                <td class="p-0 m-0"></td>
                <td class="p-2 m-0">Reduction</td>
                <td class="p-2 m-0">
                  {{ billsReduct }}
                </td>
              </tr>
              <tr class="p-0 m-0">
                <td class="p-0 m-0"></td>
                <td class="p-0 m-0"></td>
                <td class="p-2 m-0">TVA ({{ taxe }})</td>
                <td class="p-2 m-0">
                  {{ billsTaxe }}
                </td>
              </tr>
              <tr class="p-0 m-0">
                <td class="p-0 m-0"></td>
                <td class="p-0 m-0"></td>
                <td class="text-dark fw-bold p-2 m-0">Total TTC</td>
                <td class="table-primary text-dark fw-bold p-2 m-0">
                  {{ billsTotal }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <!-- {{ invoices }} -->
  </div>
</template>
<script>
import { onMounted, ref } from "vue";
import moment from "moment";
export default {
  props: {
    invoices: {
      type: Object,
    },
    enterprise: {
      type: Object,
    },
    taxe: {
      type: Number,
    },
    billsSubTotal: {
      type: Number,
    },
    billsReduct: {
      type: Number,
    },
    billsTaxe: {
      type: Number,
    },
    billsTotal: {
      type: Number,
    },
  },

  setup(props) {
    let montantHt = ref(0);

    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      JsBarcode(
        "#barcode-invoice",
        props.invoices.id.toString().padStart(10, "0"),
        {
          height: 50,
          fontSize: 50,
          background: "",
          displayValue: false,
        }
      );
      montantHt.value = props.invoices.total;
    }
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY à HH:mm:ss");
    };
    return {
      montantHt,
      convertDate,
    };
  },
};
</script>
