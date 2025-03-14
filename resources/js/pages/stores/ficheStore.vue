<template>
  <div>
    <div class="card card-flush mb-6 mb-xl-9">
      <div class="card-header mt-6">
        <div class="card-title flex-column">
          <h2 class="mb-1">Fiche de stock</h2>

          <div class="fs-6 fw-semibold text-muted">
            {{
              ficheStock.length > 1
                ? `${ficheStock.length} mouvements de stock`
                : `${ficheStock.length == 0 ? "aucun" : 1} mouvement de stock`
            }}
          </div>
        </div>

        <div class="card-toolbar">
          <button
            type="button"
            class="btn btn-light-primary btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#kt_modal_add_schedule"
          >
            <i class="ki-duotone ki-brush fs-3"
              ><span class="path1"></span><span class="path2"></span
            ></i>
            Effectuer un mouvement
          </button>
        </div>
      </div>

      <div class="card-body p-9 pt-4">
        <input
          v-on:input="handleInput"
          class="form-control form-control-solid"
          placeholder="Choisissez une rangee"
          id="kt_dashboard_daterangepicker"
        />
        <input type="text" id="data_range" @change="handleInput" hidden />
        <button id="handleInput" @click="handleInput" hidden></button>
        <!-- <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">
          <li class="nav-item me-1">
            <a
              class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary active"
              data-bs-toggle="tab"
              href="#kt_schedule_day_0"
            >
              <span class="opacity-50 fs-7 fw-semibold">Vend</span>
              <span class="fs-6 fw-bolder">15</span>
            </a>
          </li>
        </ul> -->

        <div class="tab-content">
          <div id="kt_schedule_day_0" class="tab-pane fade show">
            <!-- <div class="d-flex flex-stack position-relative mt-6">
              <div
                class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"
              ></div>

              <div class="fw-semibold ms-5">
                <div class="fs-7 mb-1">
                  12:00 - 13:00
                  <span class="fs-7 text-muted text-uppercase"> pm </span>
                </div>

                <a
                  href="#"
                  class="fs-5 fw-bold text-dark text-hover-primary mb-2"
                >
                  Sales Pitch Proposal
                </a>

                <div class="fs-7 text-muted">
                  Lead by <a href="#">Kendell Trevor</a>
                </div>
              </div>

              <a href="#" class="btn btn-light bnt-active-light-primary btn-sm"
                >View</a
              >
            </div> -->
          </div>
          <div id="kt_schedule_day_1" class="tab-pane fade show active">
            <template v-for="fiche in ficheStock" :key="fiche.id">
              <div class="d-flex flex-stack position-relative mt-6">
                <div
                  class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"
                ></div>

                <div class="fw-semibold ms-5">
                  <div class="fs-7 mb-1">
                    {{ convertDate(fiche.created_at) }}
                    <span class="fs-7 text-muted text-uppercase"> </span>
                  </div>

                  <div class="d-flex flex-column">
                    <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                      {{ fiche.service_name }}
                    </a>
                    <span class="ms-5 text-muted"
                      >Stock initial: {{ fiche.quantity_before ?? 0 }}
                      {{ fiche.uom_symbol ?? "" }}</span
                    >
                    <span class="ms-5 text-muted"
                      >Solde: {{ fiche.total }} {{ fiche.uom_symbol ?? "" }}</span
                    >
                  </div>

                  <div class="fs-7 text-muted">
                    Créer par <a href="#">{{ fiche.done_by_name }}</a>
                  </div>
                </div>

                <div>
                  <a
                    href="#"
                    class="btn btn-light bnt-active-light-primary btn-sm position-relative"
                    >{{ `${fiche.quantity} ${fiche.uom_symbol ?? ""}` }}

                    <span
                      class="position-absolute top-100 start-75 translate-middle badge badge-success"
                      >{{ fiche.type_approvement }}</span
                    >
                  </a>
                  <span
                    :class="`ki-duotone ${
                      fiche.type == 'entry'
                        ? 'ki-arrow-up text-success'
                        : 'ki-arrow-down text-danger'
                    } fs-2x  `"
                  >
                    <span class="path1"></span><span class="path2"></span>
                  </span>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { onMounted, ref } from "vue";
import useStock from "../../services/stockservices";
import moment from "moment";
import { notifications } from "../../notifications/notifications";
export default {
  props: ["ficheStock"],
  setup(props, { emit }) {
    const { ficheStock, getStockHistoryUser } = useStock();
    const { swal } = notifications();
    const search = ref("");
    onMounted(async () => {
      await callBackMounted();
    });
    async function callBackMounted() {
      //   await getStockHistoryUser();
    }
    const convertDate = (dateString) => {
      return moment(dateString).format("DD/MM/YYYY");
    };
    const pickerDateRange = () => {
      //   alert(111);
    };
    const handleInput = async () => {
      var value = $("#data_range").val();
      value = value.split("-");
      var data = {
        from: moment(value[0], "DD/MM/YYYY").format("YYYY-MM-DD"),
        to: moment(value[1], "DD/MM/YYYY").format("YYYY-MM-DD"),
      };
      emit("fichestockchange", data);
    };
    const alertBtn = () => {
      swal(
        "question",
        "Question",
        "Voulez-vous supprimer ce depot?",
        "Oui, d'accord",
        "Annuler",
        () => {},
        () => {},
        "",
        "btn-danger"
      );
    };
    const stockModal = () => {
      search.value = "";
      mouvementSendList.value = [];
      document.querySelector("#nextStepper").classList.remove("d-none");
      document.querySelector("#submit").classList.add("d-none");
      StepperGoTo(1);
      $("#stock-modal").modal("show");
      stepperIndex.value = 1;
    };
    return {
      alertBtn,
      convertDate,
      pickerDateRange,
      handleInput,
    };
  },
  methods: {},
};
</script>
