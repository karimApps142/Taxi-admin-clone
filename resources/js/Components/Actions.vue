<script setup>
import { computed } from "vue";

const emit = defineEmits(["onEdit", "onStatus", "onDelete", "onView"]);

const props = defineProps({
  isEdit: Boolean,
  isDelete: Boolean,
  isView: Boolean,
  isStatus: String,
});

const renderStatusIcon = computed(() =>
  props.isStatus === "active" ? "mdi-account-cancel" : "mdi-account-check"
);

const renderStatusColor = computed(() =>
  props.isStatus === "active" ? "pink" : "green"
);
</script>

<template>
  <div class="flex justify-end items-center ml-auto">
    <v-btn @click="emit('onEdit')" dark size="x-small" class="ml-1" v-if="props.isEdit">
      <v-icon size="large" color="green">mdi-pencil</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onStatus')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isStatus"
    >
      <v-icon size="large" :color="renderStatusColor">{{ renderStatusIcon }}</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onDelete')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isDelete"
    >
      <v-icon size="large" color="red">mdi-delete</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onView')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isView"
    >
      <v-icon size="large" color="blue">mdi-eye</v-icon>
    </v-btn>
  </div>
</template>
