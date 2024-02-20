<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
  links: Array,
});
</script>
<template>
  <div v-if="links.length > 3" class="flex items-center justify-center">
    <div class="flex flex-wrap mt-2">
      <template v-for="(link, key) in links" :key="key">
        <div
          v-if="link.url === null"
          class="mr-1 mb-1 px-3 py-2 text-xs leading-4 text-gray-400 border rounded"
          v-html="link.label"
        />
        <Link
          v-ripple
          v-else
          class="mr-1 mb-1 px-3 py-2 text-xs leading-4 border rounded hover:opacity-75  focus:border-gray-800 focus:text-gray-800"
          :class="link.active  ? 'bg-gray-800 text-white':  'bg-slate-200' "
          :href="link.url"
          v-html="link.label"
        />
      </template>
    </div>
  </div>
</template>