<template>
    <div class="login-page">
        <div v-if="isLoading" class="loading-overlay">
            <div class="loading-spinner">
                <span class="spinner-border text-white" role="status" aria-hidden="true"></span>
            </div>
        </div>

            <div class="text-center mb-10">
                <h1 class="text-dark fw-bold fs-2 mb-3">Connection</h1>
            </div>
            <div class="fv-row mb-3">
                <label class="form-label fs-6 fw-bold text-dark">Email</label>
                <input class="form-control form-control-lg form-control-solid" type="text" v-model="form.email"
                    placeholder="Saissez votre addresse email" :class="{ 'is-invalid': errors.email }" />
                <div v-if="errors.email" class="invalid-feedback">
                    {{ errors.email[0] }}
                </div>
            </div>
            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bold text-dark fs-6 mb-0">Mot de passe</label>
                </div>
                <div class="fv-row mb-3" data-kt-password-meter="true">
                    <div class="position-relative">
                        <input type="password" placeholder="Password" v-model="form.password" autocomplete="off"
                            class="form-control bg-transparent" :class="{ 'is-invalid': errors.password }" />

                        <span
                            class="btn btn-sm btn-icon text-white position-absolute translate-middle top-50 end-0 me-n2"
                            data-kt-password-meter-control="visibility">
                            <i class="ki-duotone ki-eye-slash fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            <i class="ki-duotone ki-eye d-none fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                    </div>
                    <div v-if="errors.password" class="invalid-feedback">
                        {{ errors.password[0] }}
                    </div>
                </div>

                <div class="row mb-8 d-flex align-items-stretch justify-content-between">
                    <div class="col-6">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" v-model="form.remember" value="1" />
                            <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                                Se souvenir de moi
                            </span>
                        </label>
                    </div>
                    <div class="col-6 d-flex align-items-stretch justify-content-end">
                        <a href="/" class="link-info fs-6 fw-bold"> Mot de passe oublie </a>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button @click="submitForm" class="btn btn-lg w-100 mb-5" style="background: #e15f14">
                    <span class="indicator-label text-white" v-if="!isLoading">
                        Se connecter
                    </span>
                    <span v-else class="text-white">
                        Svp patienter...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <Button label="Se connnecter avec Google" @click="loginWithProvider('google')" severity="contrast" class="google-button">
                    <template #icon>
                        <img src="/assets/media/svg/social-logos/google.svg" alt="Google Icon" class="google-icon" />
                    </template>
                </Button>
            </div>

    </div>
</template>

<script>
import { useCookie } from "@vue-composable/cookie";
import Button from 'primevue/button';
import { useToast } from "primevue/usetoast";
import { reactive, ref } from "vue";
import LoginService from "../../services/loginServices.js";

export default {
    name: "Login",
    components: {
        Button
    },
    setup() {
        const toast = useToast();
        const { removeCookie } = useCookie("userAuth");
        const errors = reactive({});
        const form = reactive({
            email: "",
            password: "",
            remember: false,
        });
        const isLoading = ref(false);

        const submitForm = async () => {
            isLoading.value = true; // Show loading
            console.log(form);
            try {
                const response = await LoginService.login(form);
                console.log(response);
                // const token = response.token;
                // toast.add({severity:'success', summary: 'Success', detail:'Login successful!', life: 3000});

                // Handle success (e.g., redirect, store token)
                // window.location.href = '/home'; // Example redirect
                // reload the page
                // return ;
                setTimeout(() => {
                    window.location.href = "/home";
                }, 0);

            } catch (error) {
                // Handle errors (e.g., show validation errors)
                if (error.response && error.response.status === 422) {
                    Object.assign(errors, error.response.data.errors);
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Invalid credentials!",
                        life: 3000,
                    });
                } else if (error.response && error.response.status === 401) {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: error.response.data.message,
                        life: 3000,
                    });
                } else {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "An error occurred!",
                        life: 3000,
                    });
                }
            } finally {
                isLoading.value = false; // Hide loading
            }
        };
        const error = ref();
        const loginWithProvider = (provider) => {
            isLoading.value=true;
            LoginService.loginProvider(provider);
        };
        return {
            loginWithProvider,
            toast,
            removeCookie,
            form,
            submitForm,
            error,
            errors,
            isLoading,
        };
    },
};
</script>

<style scoped>
/* Add any component-specific styles here */
.login-page {
    position: relative;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent black background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    /* Ensure it's on top */
}

.loading-spinner {
    /* Add any styling for the spinner container if needed */
}
.google-button .p-button-label {
    display: flex;
    align-items: center;
    justify-content: center;
}

.google-icon {
    width: 20px;
    height: 20px;
    margin-right: 8px;
    filter: brightness(0) invert(1); /* Make the icon white */
}
</style>
