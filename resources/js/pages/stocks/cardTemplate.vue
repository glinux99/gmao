<template>
  <div>
    <div class="py-2 flex-grow-1">
      <div class="d-flex flex-column">
        <div
          class="menu menu-column menu-sub-indention px-3 border rounded-3 py-4 px-8 fs-5"
          data-kt-menu="true"
          data-kt-menu-expand="true"
        >
          <div
            data-kt-menu-trigger="click"
            class="menu-item here show menu-accordion"
          >
            <span class="menu-link"
              ><span class="menu-icon">
                <span class="symbol symbol-50px me-6">
                  <span class="symbol-label bg-light-primary">
                    <i class="ki-duotone ki-compass fs-1 text-primary"
                      ><span class="path1"></span><span class="path2"></span
                    ></i>
                  </span>
                </span> </span
              ><span class="menu-title">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex flex-column">
                    <span class="fw-bold fs-6">code</span>
                  </span>
                </div></span
              ><span class="menu-arrow"></span
            ></span>

            <div class="menu-sub menu-sub-accordion border-top border-1">
              <div class="menu-item mt-3">
                <div class="row g-4">
                  <div class="card mb-10">
                    <div class="row">
                      <div class="col-7">
                        <div class="mb-5 fv-row">
                          <label class="required form-label">Valeur </label>

                          <input
                            type="number"
                            class="form-control mb-2"
                            placeholder=""
                            min="0"
                            required
                          />

                          <div class="text-muted fs-7">
                            (valeur ajouter au stock)
                          </div>
                        </div>
                      </div>
                      <div class="col-5">
                        <div class="mb-5 fv-row">
                          <label class="required form-label"
                            >Type de mouvement</label
                          >

                          <div class="">
                            <select
                              class="form-select form-select-solid fw-bold"
                              data-placeholder="Selectionner un type"
                              data-hide-search="true"
                              data-control="select2"
                              data-dropdown-css-class="w-230px"
                            >
                              <option></option>
                              <option data-subtext="entry" value="entry">
                                Approvisionnement
                              </option>
                              <option data-subtext="withdraw" value="withdraw">
                                Destockage
                              </option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
