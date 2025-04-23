<template>
    <div class="col-xl-4">
      <a href="#" class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
        <div class="card-body">
          <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
              <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
              <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
              <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
            </svg>
          </span>
          <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">
            <vue3-autocounter ref='counter' :startAmount='0' :endAmount=' count' :duration='3' prefix='' suffix='' separator=',' decimalSeparator='.' :decimals='0' :autoinit='true' />Mouvements</div>
          <div class="fw-bold text-gray-100">Statistiques</div>
        </div>
      </a>
    </div>
  </template>

  <script>
  export default {
    props: {
      count: {
        type: Number,
        required: true,
      },
    },
  };
  </script>
