<script setup>
const props = defineProps({
  card_holder: String,
  card_no: Number,
  icon: String,
});
</script>
<template>
  <div
    class="bg-[#EFEFF4] h-38 rounded-xl p-4 flex flex-col items-start justify-around mt-4 sm:h-48"
  >
    <img class="w-12" :src="props.icon" alt="" />
    <pre class="text-xl sm:text-2xl">{{ props.card_no }}</pre>
    <h2 class="mt-2">{{ props.card_holder }}</h2>
  </div>
</template>
