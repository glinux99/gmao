<template>
  <div>
    <form
      class="form w-100"
      novalidate="novalidate"
      data-kt-redirect-url="/"
      method="POST"
      @submit.prevent="login"
    >
      <div class="mb-5" v-if="errors != ''">
        <span class="text-danger">{{ errors }} </span>
      </div>

      <div class="fv-row mb-8">
        <input
          type="text"
          placeholder="Email"
          v-model="form.user_mail"
          autocomplete="off"
          class="form-control bg-transparent"
        />
      </div>

      <div class="fv-row mb-3" data-kt-password-meter="true">
        <div class="position-relative mb-3">
          <input
            type="password"
            placeholder="Password"
            v-model="form.password"
            autocomplete="off"
            class="form-control bg-transparent"
          />

          <span
            class="btn btn-sm btn-icon text-white position-absolute translate-middle top-50 end-0 me-n2"
            data-kt-password-meter-control="visibility"
          >
            <i class="ki-duotone ki-eye-slash fs-1"
              ><span class="path1"></span><span class="path2"></span
              ><span class="path3"></span><span class="path4"></span
            ></i>
            <i class="ki-duotone ki-eye d-none fs-1"
              ><span class="path1"></span><span class="path2"></span
              ><span class="path3"></span
            ></i>
          </span>
        </div>
      </div>

      <div class="row mb-8 d-flex align-items-stretch justify-content-between">
        <div class="col-6">
          <label class="form-check form-check-inline">
            <input
              class="form-check-input"
              type="checkbox"
              v-model="form.remember"
              value="1"
            />
            <span
              class="form-check-label fw-semibold text-gray-700 fs-base ms-1"
            >
              Se souvenir de moi
            </span>
          </label>
        </div>
        <div class="col-6 d-flex align-items-stretch justify-content-end">
          <a
            href="/forgot-password"
            class="opacity-75-hover text-primary fw-bold me-1"
            >Mot de passe oublie?</a
          >
        </div>
      </div>
      <div class="d-grid mb-10">
        <button type="submit" id="kt_login_submit" class="btn btn-primary">
          <span class="indicator-label" v-if="!isLoading">Se connecter </span>
          <span v-else>
            Svp patienter...
            <span
              class="spinner-border spinner-border-sm align-middle ms-2"
            ></span>
          </span>
        </button>
      </div>

      <div class="text-gray-500 text-center fw-semibold fs-6">
        Vous n'avez pas de compte?

        <a href="/register" class="link-primary fw-semibold"> S'inscrire </a>
      </div>
    </form>
  </div>
</template>
<script>
import { onMounted, ref } from "vue";
import { useCookie } from "@vue-composable/cookie";
export default {
  data() {
    return {
      isLoading: false,
      errors: "",
      form: {
        user_mail: "",
        password: "",
      },
    };
  },

  methods: {
    async login() {
      this.isLoading = true;
      await this.$store.dispatch("login", this.form);
      this.errors = this.$store.state.logErrors;
      this.isLoading = false;
    },
  },
};
</script>
