<script setup>
defineProps({
  type: {
    type: String,
    default: "submit",
  },
  secondary: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <button
    v-ripple
    :type="type"
    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:[#23a100] focus:shadow-outline-gray transition ease-in-out duration-150"
    :class="
      secondary
        ? 'bg-slate-200 hover:bg-slate-300 text-[#161515]'
        : 'bg-[#161515] hover:bg-[#161515] active:bg-[#161515] text-white'
    "
  >
    <slot />
  </button>
</template>
