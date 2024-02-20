<script setup>
const props = defineProps({
  title: String,
  subtitle: [String, Number],
  icon: {
    type: String,
    default: "mdi-account",
  },
});
</script>

<template>
  <div
    class="bg-white rounded w-full sm:w-60 h-20 flex items-end justify-end p-2 relative mx-2 my-4 shadow"
  >
    <div
      class="absolute left-2 -top-4 h-16 w-16 bg-[#1D1C1C] rounded-lg shadow flex items-center justify-center"
    >
      <v-icon size="x-large" :icon="props.icon" color="white"></v-icon>
    </div>
    <div>
      <p class="text-base text-right font-thin">{{ props.title }}</p>
      <h4 class="text-lg text-right font-semibold">{{ props.subtitle }}</h4>
    </div>
  </div>
</template>
