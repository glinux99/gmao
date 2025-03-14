<template>
  <div>
    <!-- id="kt_register_form" -->
    <form
      class="form w-100"
      autocomplete="off"
      novalidate="novalidate"
      method="POST"
      @submit.prevent="singUp"
    >
      <div class="mb-5" v-if="errors.logErrors != ''">
        <span class="text-danger">{{ errors.logErrors }} </span>
      </div>
      <div class="fv-row mb-8">
        <input
          type="text"
          placeholder="Nom complet"
          v-model="form.user_name"
          autocomplete="new-password"
          class="form-control bg-transparent"
        />
        <span class="text-danger" v-if="errors.user_name"
          >Le nom complet est requis</span
        >
      </div>
      <div class="fv-row mb-8">
        <input
          type="tel"
          placeholder="Telephone"
          v-model="form.user_phone"
          class="form-control bg-transparent"
        />
        <span class="text-danger" v-if="errors.user_phone"
          >Le numero est requis</span
        >
      </div>

      <div class="fv-row mb-8">
        <input
          type="email"
          placeholder="Email"
          v-model="form.user_mail"
          class="form-control bg-transparent"
          @change="changingReaded"
        />
        <span class="text-danger" v-if="errors.user_mail"
          >L'adresse email complet est requis</span
        >
      </div>

      <div class="fv-row mb-8" data-kt-password-meter="true">
        <div class="mb-1">
          <div class="position-relative mb-3">
            <input
              class="form-control bg-transparent"
              type="password"
              placeholder="Password"
              v-model="form.password"
              autocomplete="new-password"
              @change="changingReaded"
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

          <div
            class="d-flex align-items-center mb-3"
            data-kt-password-meter-control="highlight"
          >
            <div
              class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
            ></div>
            <div
              class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
            ></div>
            <div
              class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
            ></div>
            <div
              class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"
            ></div>
          </div>
        </div>
        <div class="text-muted">
          Utilisez 8 caractères ou plus avec un mélange de lettres, de chiffres
          et de symboles.
        </div>
      </div>
      <!-- <div class="fv-row mb-8">
        <input
          placeholder="confirmer le Password"
          v-model="form.password_confirmation"
          type="password"
          class="form-control bg-transparent"
          autocomplete="new-password"
        />
      </div> -->
      <div class="fv-row mb-8" data-kt-password-meter="true">
        <div class="mb-1">
          <div class="position-relative mb-3">
            <input
              class="form-control bg-transparent"
              type="password"
              placeholder="confirmer le password"
              v-model="form.password_confirmation"
              autocomplete="new-password"
              @change="changingReaded"
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
      </div>

      <div class="fv-row mb-8">
        <label class="form-check form-check-inline">
          <input
            @click="checking"
            :class="'form-check-input'"
            type="checkbox"
            v-model="form.accepte"
            value="1"
          />
          <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
            J'accepte les <a href="#" class="ms-1 link-primary">Termes</a>
          </span>
        </label>

        <span
          class="text-danger"
          v-if="checkingValue == false && form.accepte != 'default'"
          >(Veuillez accepter nos termes svp)</span
        >
      </div>
      <div class="d-grid mb-10">
        <button type="submit" id="kt_login_form" class="btn btn-primary">
          <span class="indicator-label" v-if="!isloading"> S'inscrire</span>
          <span v-else>
            Svp patienter...
            <span
              class="spinner-border spinner-border-sm align-middle ms-2"
            ></span>
          </span>
        </button>
      </div>
      <div class="text-gray-500 text-center fw-semibold fs-6">
        Vous avez deja un compte?

        <a href="/login" class="link-primary fw-semibold"> Se connecter </a>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isloading: false,
      errors: {
        user_name: false,
        email: false,
        password: false,
        password_confirmation: false,
        validator: "",
        logErrors: "",
      },
      checkingValue: false,
      form: {
        user_name: null,
        user_mail: null,
        user_phone: null,
        password: null,
        user_type: null,
        status: null,
        permissions: null,
        note: null,
        avatar: null,
        full_name: null,
        password_confirmation: "",
        accepte: "default",
      },
    };
  },

  methods: {
    changingReaded() {
      if (this.form.accepte == false) {
        this.$store.commit("logError", "", "");
        this.errors = {
          user_name: false,
          user_mail: false,
          password: false,
          password_confirmation: false,
          validator: "",
          logErrors: "",
        };
        this.form.accepte = true;
        this.checkingValue = true;
      }
    },
    checking() {
      this.checkingValue = !this.checkingValue;
    },
    validator: function (e) {
      let validator = true;
      if (this.textInValidator(this.form.user_name)) {
        this.errors.user_name = true;
        validator = false;
      }

      if (this.textInValidator(this.form.user_mail)) {
        this.errors.user_mail = true;
        validator = false;
      }
      if (this.textInValidator(this.form.password)) {
        this.errors.password = true;
        validator = false;
      }
      if (this.textInValidator(this.form.password_confirmation)) {
        this.errors.password_confirmation = true;
        validator = false;
      }
      return validator;
    },
    textInValidator(value) {
      if (0 >= value.trim().length) {
        return true;
      } else {
        return false;
      }
    },
    async singUp() {
      if (this.validator()) {
        this.isloading = true;
        if (this.form.accepte == true && this.checkingValue == true) {
          await this.$store.dispatch("singUp", this.form);
        }
        this.form.accepte = false;
        this.errors.logErrors = this.$store.state.logErrors;
        this.isloading = false;
      } else {
      }
    },
  },
};
</script>
