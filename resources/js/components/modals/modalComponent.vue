<template>
    <div>
      <!-- Modal Body -->
      <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
      <div :id="id" class="modal fade modal-component">
        <div :class="'modal-dialog modal-dialog-' + positionModal">
          <div class="modal-content">
            <div class="modal-header" v-if="noHeader != true">
              <h2><slot name="title" /></h2>

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
                v-if="isCss != true"
                class="modal-body c-scrollbar-light position-relative p-0"
                id="info-modal-content2"
              >
                <slot name="body"></slot>
              </div>
              <div
                v-else
                class="modal-body c-scrollbar-light position-relative p-0"
                id="info-modal-content3"
              >
                <slot name="body"></slot>
              </div>
              <slot name="footer"></slot>
              <div class="row col-12 p-0 m-0">
                <!-- code -->

                <div class="d-flex flex-row justify-content-end pb-2">
                  <div class="text-center" v-if="activeBtn != 'false'">
                    <button
                      id="annuler"
                      type="reset"
                      @click="annuler"
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
                        <span
                          class="spinner-border spinner-border-sm align-middle ms-2"
                        ></span>
                      </span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  <style>
  #info-modal-content2 {
    max-height: 68vh;
    overflow-y: auto;
  }
  </style>
  <script>
  import { onMounted } from "vue";
  export default {
    props: ["positionModal", "size", "form", "activeBtn", "id", "noHeader", "isCss"],

    setup(props) {
      onMounted(async () => {
        await callBackMounted();
      });
      // let positionModal, size, form, activeBtn, id, noHeader, isCss, data;
      async function callBackMounted() {}
      // return {
      //   positionModal,
      //   size,
      //   form,
      //   activeBtn,
      //   id,
      //   noHeader,
      //   isCss,
      //   data,
      // };
    },
    methods: {
      actionInModal() {
        this.modalfade = false;
        this.$emit("instanceModal", { ...this.form });
        $(`#${this.id} .closeBtn`).trigger("click");
        $(`#${this.id}`).modal("hide");

        this.modalfade = true;
      },
      annuler() {
        try {
          for (const [key, value] of Object.entries(this.form)) {
            this.form[key] =
              typeof value == "string" ? "" : typeof value == "number" ? 0 : {};
          }
        } catch (error) {}
      },
      closeBtn() {
        try {
          for (const [key, value] of Object.entries(this.form)) {
            this.form[key] =
              typeof value == "string" ? "" : typeof value == "number" ? 0 : {};
          }
        } catch (error) {}

        this.$emit("cancelBtn", true);
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
