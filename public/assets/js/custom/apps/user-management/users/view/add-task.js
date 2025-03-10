"use strict";
var KTUsersAddTask = (function () {
    const t = document.getElementById("kt_modal_add_task"),
        e = t.querySelector("#kt_modal_add_task_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                $("#kt_modal_add_task_datepicker").flatpickr({
                    dateFormat: "Y-m-d",
                });
                var o = FormValidation.formValidation(e, {
                    fields: {
                        task_duedate: {
                            validators: {
                                notEmpty: {
                                    message: "Task due date is required",
                                },
                            },
                        },
                        task_name: {
                            validators: {
                                notEmpty: { message: "Task name is required" },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                });
                t
                    .querySelector('[data-kt-users-modal-action="close"]')
                    .addEventListener("click", (t) => {
                        t.preventDefault(),
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
                            }).then(function (t) {
                                t.value
                                    ? (e.reset(), n.hide())
                                    : "cancel" === t.dismiss &&
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
                    }),
                    t
                        .querySelector('[data-kt-users-modal-action="cancel"]')
                        .addEventListener("click", (t) => {
                            t.preventDefault(),
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
                                }).then(function (t) {
                                    t.value
                                        ? (e.reset(), n.hide())
                                        : "cancel" === t.dismiss &&
                                          Swal.fire({
                                              text: "Your form has not been cancelled!.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "D'accord!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          });
                                });
                        });
                const a = t.querySelector(
                    '[data-kt-users-modal-action="submit"]'
                );
                a.addEventListener("click", function (t) {
                    t.preventDefault(),
                        o &&
                            o.validate().then(function (t) {
                                console.log("validated!"),
                                    "Valid" == t
                                        ? (a.setAttribute(
                                              "data-kt-indicator",
                                              "on"
                                          ),
                                          (a.disabled = !0),
                                          setTimeout(function () {
                                              a.removeAttribute(
                                                  "data-kt-indicator"
                                              ),
                                                  (a.disabled = !1),
                                                  Swal.fire({
                                                      text: "Form has been successfully submitted!",
                                                      icon: "success",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "D'accord!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn btn-primary",
                                                      },
                                                  }).then(function (t) {
                                                      t.isConfirmed && n.hide();
                                                  });
                                          }, 2e3))
                                        : Swal.fire({
                                              text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "D'accord!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          });
                            });
                });
            })(),
                document
                    .querySelectorAll('[data-kt-menu-id="kt-users-tasks"]')
                    .forEach((t) => {
                        const e = t.querySelector(
                                '[data-kt-users-update-task-status="reset"]'
                            ),
                            n = t.querySelector(
                                '[data-kt-users-update-task-status="submit"]'
                            ),
                            o = t.querySelector(
                                '[data-kt-menu-id="kt-users-tasks-form"]'
                            );
                        var a = FormValidation.formValidation(o, {
                            fields: {
                                task_status: {
                                    validators: {
                                        notEmpty: {
                                            message:
                                                "Task due date is required",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap:
                                    new FormValidation.plugins.Bootstrap5({
                                        rowSelector: ".fv-row",
                                        eleInvalidClass: "",
                                        eleValidClass: "",
                                    }),
                            },
                        });
                        $(o.querySelector('[name="task_status"]')).on(
                            "change",
                            function () {
                                a.revalidateField("task_status");
                            }
                        ),
                            e.addEventListener("click", (e) => {
                                e.preventDefault(),
                                    Swal.fire({
                                        text: "Are you sure you would like to reset?",
                                        icon: "warning",
                                        showCancelButton: !0,
                                        buttonsStyling: !1,
                                        confirmButtonText: "Yes, reset it!",
                                        cancelButtonText: "No, return",
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                            cancelButton:
                                                "btn btn-active-light",
                                        },
                                    }).then(function (e) {
                                        e.value
                                            ? (o.reset(), t.hide())
                                            : "cancel" === e.dismiss &&
                                              Swal.fire({
                                                  text: "Your form was not reset!.",
                                                  icon: "error",
                                                  buttonsStyling: !1,
                                                  confirmButtonText:
                                                      "D'accord!",
                                                  customClass: {
                                                      confirmButton:
                                                          "btn btn-primary",
                                                  },
                                              });
                                    });
                            }),
                            n.addEventListener("click", (e) => {
                                e.preventDefault(),
                                    a &&
                                        a.validate().then(function (e) {
                                            console.log("validated!"),
                                                "Valid" == e
                                                    ? (n.setAttribute(
                                                          "data-kt-indicator",
                                                          "on"
                                                      ),
                                                      (n.disabled = !0),
                                                      setTimeout(function () {
                                                          n.removeAttribute(
                                                              "data-kt-indicator"
                                                          ),
                                                              (n.disabled = !1),
                                                              Swal.fire({
                                                                  text: "Form has been successfully submitted!",
                                                                  icon: "success",
                                                                  buttonsStyling:
                                                                      !1,
                                                                  confirmButtonText:
                                                                      "D'accord!",
                                                                  customClass: {
                                                                      confirmButton:
                                                                          "btn btn-primary",
                                                                  },
                                                              }).then(function (
                                                                  e
                                                              ) {
                                                                  e.isConfirmed &&
                                                                      t.hide();
                                                              });
                                                      }, 2e3))
                                                    : Swal.fire({
                                                          text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
                                                          icon: "error",
                                                          buttonsStyling: !1,
                                                          confirmButtonText:
                                                              "D'accord!",
                                                          customClass: {
                                                              confirmButton:
                                                                  "btn btn-primary",
                                                          },
                                                      }).then(function () {});
                                        });
                            });
                    });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddTask.init();
});
