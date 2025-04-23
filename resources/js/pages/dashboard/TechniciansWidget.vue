<template>
    <div class="col-xl-4">
      <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
        <div class="card-body">
          <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M3 2H10C10.6 2 11 2.4 11 3V10C11 10.6 10.6 11 10 11H3C2.4 11 2 10.6 2 10V3C2 2.4 2.4 2 3 2Z" fill="black" />
              <path opacity="0.3" d="M14 2H21C21.6 2 22 2.4 22 3V10C22 10.6 21.6 11 21 11H14C13.4 11 13 10.6 13 10V3C13 2.4 13.4 2 14 2Z" fill="black" />
              <path opacity="0.3" d="M3 13H10C10.6 13 11 13.4 11 14V21C11 21.6 10.6 22 10 22H3C2.4 22 2 21.6 2 21V14C2 13.4 2.4 13 3 13Z" fill="black" />
              <path opacity="0.3" d="M14 13H21C21.6 13 22 13.4 22 14V21C22 21.6 21.6 22 21 22H14C13.4 22 13 21.6 13 21V14C13 13.4 13.4 13 14 13Z" fill="black" />
            </svg>
          </span>
          <div class="text-white fw-bolder fs-2 mb-2 mt-5">
            <span class="fs-1">
                <vue3-autocounter ref='counter' :startAmount='0' :endAmount=' count' :duration='3' prefix='' suffix='' separator=',' decimalSeparator='.' :decimals='0' :autoinit='true' />


               </span>
            Techniciens
          </div>
          <div class="fw-bold text-white">Techniciens enregistrés</div>
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
