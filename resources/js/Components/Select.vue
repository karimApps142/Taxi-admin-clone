<script setup>
const props = defineProps({
  modelValue: String,
});
defineEmits(["update:modelValue"]);
</script>

<template>
  <select
    v-model="props.modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    class="w-full py-2 px-3 bg-gray-200 border-gray-300 focus:outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
  >
    <slot />
  </select>
</template>
