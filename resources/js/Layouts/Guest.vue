<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
  <div class="min-h-screen w-full flex sm:justify-center items-center bg-gray-100">
    <div class="hidden sm:block" style="width: 700px">
      <img src="../../../public/taxi_ill.jpg" alt="" class="w-full h-screen" />
    </div>
    <div
      class="min-h-screen flex-1 p-6 sm:pt-0 flex flex-col items-center justify-center"
    >
      <div>
        <Link href="/">
          <div class="w-48 fill-current text-gray-500 mb-8">
            <img src="../../../public/cabbidly_logo.png" alt="logo" />
          </div>
        </Link>
      </div>

      <div
        class="w-full sm:w-96 sm:max-w-md mt-6 px-6 py-4 bg-white shadow-lg overflow-hidden sm:rounded-lg"
      >
        <slot />
      </div>
    </div>
  </div>
</template>
