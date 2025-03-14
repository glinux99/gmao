<template>
  <div>
    <div class="d-flex flex-column flex-column-fluid">
      <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">
        <div
          id="kt_app_toolbar_container"
          class="app-container container-xxl d-flex flex-stack"
        >
          <div
            class="page-title d-flex flex-column justify-content-center flex-wrap me-3"
          >
            <h1
              class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"
            >
              Configuration de l'entreprise
            </h1>
          </div>

          <!-- <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a
              href="#"
              class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary"
            >
              Vendre
            </a>

            <a href="#" class="btn btn-sm fw-bold btn-primary"> Ajouter un produit </a>
          </div> -->
        </div>
      </div>
      <div class="app-container container-xxl">
        <div class="card card-flush h-md-50 mb-5 mb-xl-10 p-5">
          <div class="stepper stepper-pills" id="stepper_super_admin">
            <div class="stepper-nav flex-center flex-wrap mb-10">
              <div class="stepper-item mx-2 my-4 current" data-kt-stepper-element="nav">
                <div class="stepper-line w-40px"></div>

                <div class="stepper-icon w-40px h-40px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">1</span>
                </div>

                <div class="stepper-label">
                  <h3 class="stepper-title">Etape 1</h3>

                  <div class="stepper-desc">Entreprise</div>
                </div>
              </div>

              <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                <div class="stepper-line w-40px"></div>

                <div class="stepper-icon w-40px h-40px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">2</span>
                </div>

                <div class="stepper-label">
                  <h3 class="stepper-title">Etape 2</h3>

                  <div class="stepper-desc">Adresse</div>
                </div>
              </div>

              <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                <div class="stepper-line w-40px"></div>

                <div class="stepper-icon w-40px h-40px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">3</span>
                </div>

                <div class="stepper-label">
                  <h3 class="stepper-title">Etape 3</h3>

                  <div class="stepper-desc">Logos</div>
                </div>
              </div>

              <div class="stepper-item mx-2 my-4" data-kt-stepper-element="nav">
                <div class="stepper-line w-40px"></div>

                <div class="stepper-icon w-40px h-40px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">4</span>
                </div>

                <div class="stepper-label">
                  <h3 class="stepper-title">Etape 4</h3>

                  <div class="stepper-desc">Social</div>
                </div>
              </div>
            </div>

            <form class="form w-lg-500px mx-auto" @submit.prevent="createEntreprise">
              <div class="mb-5">
                <div class="flex-column current" data-kt-stepper-element="content">
                  <div class="fv-row mb-10">
                    <label class="form-label">Nom de l'entreprise</label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      placeholder=" Nom associe a votre entreprise"
                      v-model="form.name"
                    />
                  </div>

                  <div class="fv-row mb-10">
                    <label class="form-label">Description de l'entreprise</label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      v-model="form.description"
                      placeholder=""
                    />
                  </div>

                  <div class="fv-row mb-10">
                    <label class="form-label">Numero RCCM</label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="rccm"
                      placeholder=""
                      v-model="form.rccm"
                    />
                  </div>
                  <div class="fv-row mb-10">
                    <label class="form-label">Identification national</label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="national_identification"
                      placeholder=""
                      v-model="form.national_identification"
                    />
                  </div>
                  <div class="fv-row mb-10">
                    <label class="form-label">Numero d'impot</label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="num_impot"
                      placeholder=""
                      v-model="form.num_impot"
                    />
                  </div>
                  <div class="fv-row mb-10">
                    <label class="form-label">Autorisation fct</label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="autorisation_fct"
                      placeholder=""
                      v-model="form.autorisation_fct"
                    />
                  </div>
                </div>

                <div class="flex-column" data-kt-stepper-element="content">
                  <address>
                    <div class="fv-row mb-10">
                      <label class="form-label">Adresse</label>

                      <textarea
                        type="text"
                        class="form-control form-control-solid"
                        rows="3"
                        placeholder=""
                        v-model="form.adresse"
                      >
                      </textarea>
                    </div>

                    <div class="fv-row mb-10">
                      <label class="form-label">Numero de Tel</label>

                      <input
                        class="form-control form-control-solid"
                        v-model="form.phone"
                        placeholder=""
                      />
                    </div>
                    <div class="fv-row mb-10">
                      <label class="form-label">Adresse email</label>

                      <input
                        type="email"
                        class="form-control form-control-solid"
                        v-model="form.email"
                        placeholder=""
                      />
                    </div>
                  </address>
                </div>

                <div class="flex-column" data-kt-stepper-element="content">
                  <div class="text-muted fs-7 mb-5">
                    Note: Définissez l'image miniature de votre entreprise. Seul *.png,
                    *.jpg et Les fichiers image *.jpeg sont acceptés
                  </div>
                  <div class="row">
                    <div class="border-bottom mb-5 border-primary border-2">
                      <label for="" class="form-label text-primary fw-bold"
                        >Logo pour l'entreprise</label
                      >
                    </div>

                    <div class="col-md-6">
                      <label for="" class="form-label text-muted">Small size</label>
                      <div class="text-center pt-0">
                        <div
                          @click="openFileChangeImage('openFile1')"
                          class="image-input image-input-empty image-input-outline image-input-placeholder-light mb-3"
                          data-kt-image-input="true"
                        >
                          <div class="image-input-wrapper w-150px h-150px"></div>

                          <label
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            title="Changer  la photo"
                            id="openFile1"
                          >
                            <i class="ki-duotone ki-pencil fs-7"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>

                            <input
                              @click="openFile"
                              type="file"
                              @change="onFileChange($event, 'logo_light_sm')"
                              accept=".png, .jpg, .jpeg"
                            />
                            <input type="hidden" name="avatar_remove" />
                          </label>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            title="Supprimer la photo"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            title="Remove avatar"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="" class="form-label text-muted">Large size</label>
                      <div class="text-center pt-0">
                        <div
                          class="image-input image-input-empty image-input-outline image-input-placeholder-light mb-3"
                          data-kt-image-input="true"
                          @click="openFileChangeImage('openFile2')"
                        >
                          <div class="image-input-wrapper w-150px h-150px"></div>

                          <label
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            title="Changer la photo"
                            id="openFile2"
                          >
                            <i class="ki-duotone ki-pencil fs-7"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>

                            <input
                              type="file"
                              @change="onFileChange($event, 'logo_light_lg')"
                              accept=".png, .jpg, .jpeg"
                            />
                            <input type="hidden" name="avatar_remove" />
                          </label>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            title="Supprimer la photo"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            title="Remove avatar"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- dark logo -->
                  <div class="row d-none">
                    <div class="border-bottom mb-5 border-dark border-2">
                      <label for="" class="form-label text-dark fw-bold"
                        >Logo pour le mode dark</label
                      >
                    </div>

                    <div class="col-md-6">
                      <label for="" class="form-label text-muted">Small size</label>
                      <div class="text-center pt-0">
                        <div
                          class="image-input image-input-empty image-input-outline image-input-placeholder-dark mb-3"
                          data-kt-image-input="true"
                        >
                          <div class="image-input-wrapper w-150px h-150px"></div>

                          <label
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            title="Changer  la photo"
                          >
                            <i class="ki-duotone ki-pencil fs-7"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>

                            <input
                              type="file"
                              @change="onFileChange($event, 'logo_dark_sm')"
                              accept=".png, .jpg, .jpeg"
                            />
                            <input type="hidden" name="avatar_remove" />
                          </label>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            title="Supprimer la photo"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            title="Remove avatar"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="" class="form-label text-muted">Large size</label>
                      <div class="text-center pt-0">
                        <div
                          class="image-input image-input-empty image-input-outline image-input-placeholder-dark mb-3"
                          data-kt-image-input="true"
                        >
                          <div class="image-input-wrapper w-150px h-150px"></div>

                          <label
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            title="Changer  la photo"
                          >
                            <i class="ki-duotone ki-pencil fs-7"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>

                            <input
                              type="file"
                              @change="onFileChange($event, 'logo_dark_lg')"
                              accept=".png, .jpg, .jpeg"
                            />
                            <input type="hidden" name="avatar_remove" />
                          </label>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            title="Supprimer la photo"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>

                          <span
                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            title="Remove avatar"
                          >
                            <i class="ki-duotone ki-cross fs-2"
                              ><span class="path1"></span><span class="path2"></span
                            ></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="flex-column" data-kt-stepper-element="content">
                  <div class="fv-row mb-10">
                    <label class="form-label d-flex align-items-center">
                      <span class="required">Linkdin</span>
                      <i
                        class="fas fa-exclamation-circle ms-2 fs-7"
                        data-bs-toggle="tooltip"
                        title="Example tooltip"
                      ></i>
                    </label>
                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="input1"
                      v-model="form.linkdin"
                    />
                  </div>
                  <div class="fv-row mb-10">
                    <label class="form-label"> Instagram </label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="input2"
                      v-model="form.instragram"
                    />
                  </div>
                  <div class="fv-row mb-10">
                    <label class="form-label"> Facebook </label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="input3"
                      v-model="form.facebook"
                    />
                  </div>
                  <div class="fv-row mb-10">
                    <label class="form-label"> Site web </label>

                    <input
                      type="text"
                      class="form-control form-control-solid"
                      name="website"
                      v-model="form.website"
                    />
                  </div>
                </div>
              </div>

              <div class="d-flex flex-stack">
                <div class="me-2">
                  <button
                    type="button"
                    class="btn btn-light btn-active-light-primary"
                    data-kt-stepper-action="previous"
                  >
                    Retrour
                  </button>
                </div>

                <div>
                  <button type="button" id="finishSteppHandler" hidden></button>
                  <button
                    type="submit"
                    class="btn btn-primary"
                    data-kt-stepper-action="submit"
                  >
                    <span class="indicator-label" v-if="!isLoaging">Envoyer </span>
                    <span v-else>
                      Veuillez patienter svp...
                      <span
                        class="spinner-border spinner-border-sm align-middle ms-2"
                      ></span>
                    </span>
                  </button>

                  <button
                    type="button"
                    class="btn btn-primary"
                    data-kt-stepper-action="next"
                  >
                    Continuer
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.image-input-placeholder-light {
  background-image: url("~/assets/bl-img.svg");
}

.image-input-placeholder-dark {
  background-image: url("~/assets/bl-img-dark.svg");
}
</style>

<script>
import { getCurrentInstance, reactive, ref, onMounted } from "vue";
import useEntreprises from "../../services/enterpriseservices.js";
import { useCookie } from "@vue-composable/cookie";
import { useToastr } from "../../toastr.js";
import { notifications } from "../../notifications/notifications.js";
export default {
  setup(props, { emit }) {
    let isLoaging = ref(false);
    const images = reactive({});
    let { cookie, setCookie } = useCookie("userAuth");
    const { afterLogin } = notifications();
    const form = reactive({
      name: "",
      description: "",
      rccm: "",
      national_identification: "",
      num_impot: "",
      autorisation_fct: "",
      adresse: "",
      phone: "",
      email: "",
      website: "",
      facebook: "",
      instagram: "",
      linkdin: "",
      logo: "",
      category: "",
      vat_rate: "",
      uuid: null,
      sync_status: "",
      user_id: 1,
      status: "",
    });
    const openFileChangeImage = (id) => {
      $(`#${id}`).click();
    };
    onMounted(async () => {
      await callBackMounted();
    });

    async function callBackMounted() {
      afterLogin();
    }
    const editModal = (value) => {
      form.value = value;
    };
    const {
      storeEntreprise,
      getEntreprise,
      storeActiveEntreprise,
      entreprises,
    } = useEntreprises();
    let formData = new FormData();
    const onFileChange = (event, name) => {
      formData.append(`${name}`, event.target.files[0]);
    };

    const createEntreprise = async () => {
      isLoaging.value = true;

      for (const [key, value] of Object.entries(form)) {
        formData.append(`${key}`, value);
      }

      await storeEntreprise(formData);

      await getEntreprise();

      if (entreprises.value.length == 1) {
        // activation de l entreprise que nous avons creer
        await storeActiveEntreprise(1, false);
        let redirectUrl = "/admin/home";
        location.href = redirectUrl;
      } else {
        emit("callback");
        let redirectUrl = "/admin/home";

        location.href = redirectUrl;
      }

      $("#closeBtn").trigger("click");
      isLoaging.value = false;
      $("#finishSteppHandler").trigger("click");
    };

    return {
      onFileChange,
      createEntreprise,
      openFileChangeImage,
      isLoaging,
      form,
    };
  },
};
</script>
