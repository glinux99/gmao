"use strict";
var KTUsersViewMain = {
    init: function () {
        document
            .getElementById("kt_modal_sign_out_sesions")
            .addEventListener("click", (t) => {
                t.preventDefault(),
                    Swal.fire({
                        text: "Are you sure you would like sign out all sessions?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, sign out!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (t) {
                        t.value
                            ? Swal.fire({
                                  text: "You have signed out all sessions!.",
                                  icon: "success",
                                  buttonsStyling: !1,
                                  confirmButtonText: "D'accord!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              })
                            : "cancel" === t.dismiss &&
                              Swal.fire({
                                  text: "Your sessions are still preserved!.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "D'accord!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              });
                    });
            }),
            document
                .querySelectorAll('[data-kt-users-sign-out="single_user"]')
                .forEach((t) => {
                    t.addEventListener("click", (n) => {
                        n.preventDefault();
                        const e = t
                            .closest("tr")
                            .querySelectorAll("td")[1].innerText;
                        Swal.fire({
                            text:
                                "Are you sure you would like sign out " +
                                e +
                                "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, sign out!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light",
                            },
                        }).then(function (n) {
                            n.value
                                ? Swal.fire({
                                      text: "You have signed out " + e + "!.",
                                      icon: "success",
                                      buttonsStyling: !1,
                                      confirmButtonText: "D'accord!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  }).then(function () {
                                      t.closest("tr").remove();
                                  })
                                : "cancel" === n.dismiss &&
                                  Swal.fire({
                                      text:
                                          e + "'s session is still preserved!.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "D'accord!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
                    });
                }),
            document
                .getElementById("kt_users_delete_two_step")
                .addEventListener("click", (t) => {
                    t.preventDefault(),
                        Swal.fire({
                            text: "Are you sure you would like remove this two-step authentication?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, remove it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light",
                            },
                        }).then(function (t) {
                            t.value
                                ? Swal.fire({
                                      text: "You have removed this two-step authentication!.",
                                      icon: "success",
                                      buttonsStyling: !1,
                                      confirmButtonText: "D'accord!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  })
                                : "cancel" === t.dismiss &&
                                  Swal.fire({
                                      text: "Your two-step authentication is still valid!.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "D'accord!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
                }),
            (() => {
                const t = document.getElementById(
                        "kt_users_email_notification_form"
                    ),
                    n = t.querySelector("#kt_users_email_notification_submit"),
                    e = t.querySelector("#kt_users_email_notification_cancel");
                n.addEventListener("click", (t) => {
                    t.preventDefault(),
                        n.setAttribute("data-kt-indicator", "on"),
                        (n.disabled = !0),
                        setTimeout(function () {
                            n.removeAttribute("data-kt-indicator"),
                                (n.disabled = !1),
                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "D'accord!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                        }, 2e3);
                }),
                    e.addEventListener("click", (n) => {
                        n.preventDefault(),
                            Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light",
                                },
                            }).then(function (n) {
                                n.value
                                    ? t.reset()
                                    : "cancel" === n.dismiss &&
                                      Swal.fire({
                                          text: "Your form has not been cancelled!.",
                                          icon: "error",
                                          buttonsStyling: !1,
                                          confirmButtonText: "D'accord!",
                                          customClass: {
                                              confirmButton: "btn btn-primary",
                                          },
                                      });
                            });
                    });
            })();
    },
};
KTUtil.onDOMContentLoaded(function () {
    KTUsersViewMain.init();
});
