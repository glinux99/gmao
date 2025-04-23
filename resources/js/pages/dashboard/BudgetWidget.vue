<template>
  <div class="col-xl-4">
    <a href="#" class="card bg-body-white hoverable card-xl-stretch mb-xl-8">
      <div class="card-body">
        <i class="ki-duotone ki-chart text-muted display-3"><span class="path1"></span><span class="path2"></span></i>
        <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">Prévision bugétaire</div>
        <div class="d-flex justify-content-between align-items-center">
          <div class="col-6">
            <span class="fw-bold text-danger fs-2">
                <vue3-autocounter ref='counter' :startAmount='0' :endAmount=' budget' :duration='5' prefix='' suffix='$' separator=',' decimalSeparator='.' :decimals='2' :autoinit='true' />

               </span>
          </div>
          <div class="col-6">
            <!-- Removed commented-out Blade code -->
          </div>
        </div>
      </div>
    </a>
  </div>
</template>

<script setup>
import vue3Autocounter from 'vue3-autocounter';
defineProps({
  budget: {
    type: Number,
    required: true,
  },
});
</script>
