"use strict";
var KTAccountSettingsSigninMethods = (function () {
    var t,
        e,
        n,
        o,
        i,
        s,
        r,
        a,
        l,
        d = function () {
            e.classList.toggle("d-none"),
                s.classList.toggle("d-none"),
                n.classList.toggle("d-none");
        },
        c = function () {
            o.classList.toggle("d-none"),
                a.classList.toggle("d-none"),
                i.classList.toggle("d-none");
        };
    return {
        init: function () {
            var m;
            (t = document.getElementById("kt_signin_change_email")),
                (e = document.getElementById("kt_signin_email")),
                (n = document.getElementById("kt_signin_email_edit")),
                (o = document.getElementById("kt_signin_password")),
                (i = document.getElementById("kt_signin_password_edit")),
                (s = document.getElementById("kt_signin_email_button")),
                (r = document.getElementById("kt_signin_cancel")),
                (a = document.getElementById("kt_signin_password_button")),
                (l = document.getElementById("kt_password_cancel")),
                e &&
                    (s
                        .querySelector("button")
                        .addEventListener("click", function () {
                            d();
                        }),
                    r.addEventListener("click", function () {
                        d();
                    }),
                    a
                        .querySelector("button")
                        .addEventListener("click", function () {
                            c();
                        }),
                    l.addEventListener("click", function () {
                        c();
                    })),
                t &&
                    ((m = FormValidation.formValidation(t, {
                        fields: {
                            emailaddress: {
                                validators: {
                                    notEmpty: { message: "Email is required" },
                                    emailAddress: {
                                        message:
                                            "The value is not a valid email address",
                                    },
                                },
                            },
                            confirmemailpassword: {
                                validators: {
                                    notEmpty: {
                                        message: "Password is required",
                                    },
                                },
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                            }),
                        },
                    })),
                    t
                        .querySelector("#kt_signin_submit")
                        .addEventListener("click", function (e) {
                            e.preventDefault(),
                                console.log("click"),
                                m.validate().then(function (e) {
                                    "Valid" == e
                                        ? swal
                                              .fire({
                                                  text: "Les demandes de mis a jour ont ete lancee!!!",
                                                  icon: "success",
                                                  buttonsStyling: !1,
                                                  confirmButtonText:
                                                      "D'accord!",
                                                  customClass: {
                                                      confirmButton:
                                                          "btn font-weight-bold btn-light-primary",
                                                  },
                                              })
                                              .then(function () {
                                                  $(
                                                      "#submitEmailChange"
                                                  ).click();
                                                  t.reset(), m.resetForm(), d();
                                              })
                                        : swal.fire({
                                              text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "D'accord!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn font-weight-bold btn-light-primary",
                                              },
                                          });
                                });
                        })),
                (function (t) {
                    var e,
                        n = document.getElementById(
                            "kt_signin_change_password"
                        );
                    n &&
                        ((e = FormValidation.formValidation(n, {
                            fields: {
                                currentpassword: {
                                    validators: {
                                        notEmpty: {
                                            message:
                                                "Current Password is required",
                                        },
                                    },
                                },
                                newpassword: {
                                    validators: {
                                        notEmpty: {
                                            message: "New Password is required",
                                        },
                                    },
                                },
                                confirmpassword: {
                                    validators: {
                                        notEmpty: {
                                            message:
                                                "Confirm Password is required",
                                        },
                                        identical: {
                                            compare: function () {
                                                return n.querySelector(
                                                    '[name="newpassword"]'
                                                ).value;
                                            },
                                            message:
                                                "The password and its confirm are not the same",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap:
                                    new FormValidation.plugins.Bootstrap5({
                                        rowSelector: ".fv-row",
                                    }),
                            },
                        })),
                        n
                            .querySelector("#kt_password_submit")
                            .addEventListener("click", function (t) {
                                t.preventDefault(),
                                    console.log("click"),
                                    e.validate().then(function (t) {
                                        "Valid" == t
                                            ? swal
                                                  .fire({
                                                      text: "Les mise a jour ont ete lancees",
                                                      icon: "success",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "D'accord!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn font-weight-bold btn-light-primary",
                                                      },
                                                  })
                                                  .then(function () {
                                                      $(
                                                          "#passwordSubmit"
                                                      ).click();
                                                      n.reset(),
                                                          e.resetForm(),
                                                          c();
                                                  })
                                            : swal.fire({
                                                  text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
                                                  icon: "error",
                                                  buttonsStyling: !1,
                                                  confirmButtonText:
                                                      "D'accord!",
                                                  customClass: {
                                                      confirmButton:
                                                          "btn font-weight-bold btn-light-primary",
                                                  },
                                              });
                                    });
                            }));
                })();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAccountSettingsSigninMethods.init();
});
