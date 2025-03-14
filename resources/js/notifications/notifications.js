import { useCookie } from "@vue-composable/cookie";
import { message } from "laravel-mix/src/Log.js";
import { useToastr } from "../toastr.js";
import Swal from "sweetalert2";
export function notifications() {
    const toastr = useToastr();

    const swal = (
        icon = "success",
        title,
        message,
        confirmText = "D'accord!",
        cancelText = "No, Cancel",
        callbackTrue,
        callbackFalse,
        confirmCss = "btn-primary",
        cancelCss = "btn-active-light-primary"
    ) => {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            showCancelButton: true,
            buttonsStyling: false,
            cancelButtonText: cancelText,
            confirmButtonText: confirmText,
            customClass: {
                confirmButton: `btn fw-bold btn-primary ${confirmCss}`,
                cancelButton: `btn fw-bold btn-active-light-primary ${cancelCss}`,
            },
        }).then((result) => {
            if (result.isConfirmed) {
                callbackTrue();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                callbackFalse();
            }
        });
    };
    const swalConf = (
        title,
        message,
        icon = "success",
        confirmText = "D'accord!",
        callbackTrue,
        callbackFalse
    ) => {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            showCancelButton: true,
            buttonsStyling: false,
            cancelButtonText: "No, cancel",
            confirmButtonText: confirmText,
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        }).then(async (result) => {
            if (result.isConfirmed) {
                await callbackTrue();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                await callbackFalse();
            }
        });
    };
    // after login or after register notification state logic
    const afterLogin = () => {
        const register = new useCookie("registerUser");
        const auth = new useCookie("authenticateUser");
        const user = new useCookie("userAuth");
        // auth.setCookie(false);
        if (register.cookie.value == "true" || auth.cookie.value == "true") {
            if (register.cookie.value != "true") {
                toastr.success(
                    "Nous sommes heureux de vous revoir " +
                        JSON.parse(user.cookie.value).data.user_name
                );
            } else {
                console.log(useCookie("userAuth"));
                toastr.success(
                    "Merci pour votre inscription " +
                        JSON.parse(user.cookie.value).data.user_name
                );
            }
            if (JSON.parse(user.cookie.value).stepper == true) {
                setTimeout(() => {
                    toastr.info(
                        "Veuillez configurer une entreprise pour commencer "
                    );
                }, 6000);
            }
        }
        auth.removeCookie();
        register.removeCookie();
    };
    const successRegister = (service, data, message) => {
        toastr.success(`${service} ${data} ${message}`);
    };
    const dataCreated = () => {
        const dataCreateCookie = useCookie("dataCreate");
        if (
            dataCreateCookie.cookie.value
                ? JSON.parse(dataCreateCookie.cookie.value).value == true
                : false
        ) {
            successRegister(
                JSON.parse(dataCreateCookie.cookie.value).service,
                JSON.parse(dataCreateCookie.cookie.value).name,
                "a ete enregistre avec success"
            );
            dataCreateCookie.removeCookie();
        }
    };
    const dataError = (errorService, errorName) => {
        toastr.error(
            `Une erreur est survenue lors de l'enregistrement de donnee`
        );
    };
    const dataErrorMessage = (message) => {
        toastr.error(`${message}`);
    };

    const dataActive = (service, data) => {
        const dataCreateCookie = useCookie("dataActive");
        if (
            dataCreateCookie.cookie.value
                ? JSON.parse(dataCreateCookie.cookie.value).value == true
                : false
        ) {
            let delay = 0;
            if (JSON.parse(dataCreateCookie.cookie.value).delay == true) {
                delay = 6000;
            }

            setTimeout(() => {
                successRegister(
                    JSON.parse(dataCreateCookie.cookie.value).service,
                    JSON.parse(dataCreateCookie.cookie.value).name,
                    "a ete active par defaut"
                );
                dataCreateCookie.removeCookie();
            }, delay);
        }
    };
    return {
        swal,
        swalConf,
        dataError,
        dataActive,
        afterLogin,
        dataCreated,
        successRegister,
        dataErrorMessage,
    };
}
