html
<template>
  <div>
    <div
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#modalParent"
    >
      xxxxxxxxxxxxx
    </div>
    <!-- Modal Parent -->
    <div
      class="modal fade"
      id="modalParent"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalParentLabel"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalParentLabel">Modal Parent</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Contenu du Modal Parent
            <div
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#modalParent2"
            >
              xxxxxxxxxxxxx
            </div>
            <button
              type="button"
              class="btn btn-primary"
              @click="openModalChild"
            >
              Ouvrir Modal Enfant
            </button>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fermer
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="modalChild"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalParentLabel"
      aria-hidden="true"
      data-backdrop="static"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalParentLabel">Modal Parent</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Contenu du Modal Parent
            <button
              type="button"
              class="btn btn-primary"
              @click="openModalChild"
            >
              Ouvrir Modal Enfant
            </button>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Fermer
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
 <script>
//  code
export default {
  methods: {
    openModalChild() {
      // Ouvrir le modal enfant
      $("#modalChild").modal("show");
      // Empêcher la fermeture du modal parent
      $("#modalParent").modal("handleUpdate", false);
    },
  },
};
</script>
