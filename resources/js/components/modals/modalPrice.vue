<template>
  <div>
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div :id="id" class="modal fade modal-component">
      <div :class="'modal-dialog modal-dialog-' + positionModal">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title h6">
              <slot name="title" />
            </h5>
            <div
              @click="closeBtn"
              class="btn btn-icon btn-sm btn-active-icon-primary closeBtn"
              data-bs-dismiss="modal"
              aria-label="Close"
              data-kt-users-modal-action="close"
            >
              <i class="ki-duotone ki-cross fs-1"
                ><span class="path1"></span><span class="path2"></span
              ></i>
            </div>
          </div>
          <form ref="myform" action="" method="post" @submit.prevent="actionInModal">
            <div
              class="modal-body c-scrollbar-light position-relative p-0"
              id="info-modal-content2"
            >
              <div class="c-preloader text-center absolute-center">
                <i class="las la-spinner la-spin la-3x opacity-70"></i>
              </div>
              <slot name="body" :data="form"></slot>
            </div>
            <div class="text-center mb-5" v-if="activeBtn != 'false'">
              <button
                id="annuler"
                type="reset"
                class="btn btn-light me-3"
                data-kt-users-modal-action="cancel"
                data-bs-dismiss="modal"
              >
                Annuler
              </button>

              <button
                type="submit"
                id="submit"
                class="btn btn-primary"
                data-kt-users-modal-action="submit"
              >
                <span class="indicator-label" v-if="modalfade">Envoyer</span>

                <span v-else>
                  Veuillez patienter svp...
                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from "vue";
export default {
  props: ["positionModal", "size", "form", "activeBtn", "id"],
  mounted() {},
  setup() {},
  methods: {
    actionInModal() {
      this.modalfade = false;
      this.$emit("instanceModal", { ...this.form });

      $(".closeBtn").trigger("click");
      //   $(".modal-component").on("hidden.bs.modal", function () {
      //     $(this).find("form")[0].reset();
      //   });
      this.modalfade = true;
    },
    closeBtn() {
      for (const [key, value] of Object.entries(this.form)) {
        this.form[key] =
          typeof value == "string" ? "" : typeof value == "number" ? 0 : {};
      }
    },
  },

  data() {
    return {
      modalfade: true,
    };
  },
  //   data() {
  //     return {
  //       form,
  //     };
  //   },
};
</script>
