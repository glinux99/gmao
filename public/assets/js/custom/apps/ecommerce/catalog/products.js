"use strict";
var KTAppEcommerceProducts = (function () {
    var t,
        e,
        n = () => {
            t.querySelectorAll(
                '[data-kt-ecommerce-product-filter="delete_row"]'
            ).forEach((t) => {
                t.addEventListener("click", function (t) {
                    t.preventDefault();
                    const n = t.target.closest("tr"),
                        r = n.querySelector(
                            '[data-kt-ecommerce-product-filter="product_name"]'
                        ).innerText;
                    Swal.fire({
                        text: "Are you sure you want to delete " + r + "?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (t) {
                        t.value
                            ? Swal.fire({
                                  text: "You have deleted " + r + "!.",
                                  icon: "success",
                                  buttonsStyling: !1,
                                  confirmButtonText: "D'accord!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              }).then(function () {
                                  e.row($(n)).remove().draw();
                              })
                            : "cancel" === t.dismiss &&
                              Swal.fire({
                                  text: r + " was not deleted.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "D'accord!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                    });
                });
            });
        };
    return {
        init: function () {
            (t = document.querySelector("#kt_ecommerce_products_table")) &&
                ((e = $(t).DataTable({
                    info: !1,
                    order: [],
                    pageLength: 10,
                    columnDefs: [
                        {
                            render: DataTable.render.number(",", ".", 2),
                            targets: 4,
                        },
                        { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 7 },
                    ],
                })).on("draw", function () {
                    n();
                }),
                document
                    .querySelector(
                        '[data-kt-ecommerce-product-filter="search"]'
                    )
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                (() => {
                    const t = document.querySelector(
                        '[data-kt-ecommerce-product-filter="status"]'
                    );
                    $(t).on("change", (t) => {
                        let n = t.target.value;
                        "all" === n && (n = ""), e.column(6).search(n).draw();
                    });
                })(),
                n());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceProducts.init();
});
