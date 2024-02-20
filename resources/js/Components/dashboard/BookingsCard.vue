<script setup>
const props = defineProps({
  title: String,
  subtitle: [String, Number],
  icon: {
    type: String,
    default: "mdi-account",
  },
  color:{
    type: String,
    default: '#1D1C1C'
  }
});
</script>

<template>
  <div
    class="bg-white rounded w-full sm:w-60 h-20 flex items-center justify-start p-2 relative mx-2 my-4 shadow"
  >
    <div class="bg-[#f3f3f3] h-12 w-12 rounded-full flex items-center justify-center">
      <v-icon size="x-large" :icon="props.icon" :color="props.color"></v-icon>
    </div>
    <div class="flex flex-col pl-2">
      <h1 class="text-base">{{ props.title }}</h1>
      <h1 class="text-lg font-medium">{{ props.subtitle }}</h1>
    </div>
  </div>
</template>
