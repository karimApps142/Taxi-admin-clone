<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["href", "active"]);

const classes = computed(() =>
  props.active
    ? "px-3 py-2 my-2 bg-white text-[#1D1C1C] rounded-lg flex items-center focus:outline-none  transition  duration-150 ease-in-out"
    : "px-3 py-2 my-2 text-white rounded-lg flex items-center hover:bg-gray-700 hover:border-gray-300 focus:outline-none  transition duration-150 ease-in-out"
);
</script>

<template>
  <Link :href="href" :class="classes" v-ripple>
    <slot />
  </Link>
</template>
