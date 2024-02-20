<script setup>
import BaseInput from "@/Components/Input.vue";
import BaseButton from "@/Components/Button.vue";
import MapView from "@/Components/MapView.vue";
import Select from "@/Components/Select.vue";
import { useCities } from "@/store/city";

const store = useCities();

const props = defineProps({
  country: Object,
});
const onSubmit = () => {
  store.form.post(route("cities.store", { id: store.form.country_id }), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
    },
  });
};
const onUpdate = () => {
  store.form.post(route("cities.update", { id: store.form.id }), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
      store.isEdit = false;
    },
  });
};
</script>

<template>
  <VDialog v-model="store.dialog" persistent max-width="700">
    <VCard class="w-full">
      <VCardTitle class="pt-4">
        <span class="text-h6"> {{ store.isEdit ? "Edit City" : "Add City" }} </span>
      </VCardTitle>
      <MapView />
      <p v-if="store.form.errors.coords" class="text-xs mx-3 mt-1 text-red-500">
        {{ store.form.errors.coords }}
      </p>
      <div class="flex flex-row items-center justify-between mt-2">
        <BaseButton
          @click="
            store.$patch({
              form: {
                ...store.form,
                coords: [],
              },
            })
          "
          type="button"
          class="mx-3 bg-slate-200 hover:bg-slate-300 w-full flex items-center justify-center"
          ><p class="">Reset</p></BaseButton
        >
        <BaseButton
          @click="store.$patch({ editMap: !store.editMap })"
          type="button"
          class="mx-3 bg-red-500 hover:bg-slate-300 w-full flex items-center justify-center"
          :class="{ 'bg-green-500 ': store.editMap }"
          ><p class="text-white">
            Edit Map {{ store.editMap ? "ON" : "OFF" }}
          </p></BaseButton
        >
      </div>

      <VContainer class="pt-4">
        <form @submit.prevent="store.isEdit ? onUpdate() : onSubmit()" class="space-y-2">
          <BaseInput
            v-model="store.form.name"
            placeholder="Name"
            class="w-full py-2 px-3"
          />
          <p v-if="store.form.errors.name" class="text-xs mx-1 mt-1 text-red-500">
            {{ store.form.errors.name }}
          </p>
          <BaseInput
            v-model="store.form.zipcode"
            placeholder="Zip Code"
            class="w-full py-2 px-3"
          />
          <p v-if="store.form.errors.zipcode" class="text-xs mx-1 mt-1 text-red-500">
            {{ store.form.errors.zipcode }}
          </p>
          <Select v-model="store.form.currency" title="Currency">
            <option value="gbp">GBP</option>
            <option value="usd">USD</option>
          </Select>
          <p v-if="store.form.errors.currency" class="text-xs mx-1 mt-1 text-red-500">
            {{ store.form.errors.currency }}
          </p>
          <Select v-model="store.form.unit" title="Select Distance Unit" disabled>
            <option value="km">Kilometers</option>
            <option value="mi">Miles</option>
          </Select>
          <p v-if="store.form.errors.unit" class="text-xs mx-1 mt-1 text-red-500">
            {{ store.form.errors.unit }}
          </p>
          <BaseInput
            v-model="store.form.radius"
            placeholder="Radius"
            class="w-full py-2 px-3"
          />
          <p v-if="store.form.errors.radius" class="text-xs mx-1 mt-1 text-red-500">
            {{ store.form.errors.radius }}
          </p>
          <div class="flex space-x-4 pt-5">
            <BaseButton
              @click="store.dialog = false"
              type="button"
              secondary
              class="w-full flex items-center justify-center"
              ><p class="text-black">Cancel</p></BaseButton
            >
            <BaseButton class="w-full flex items-center justify-center">
              {{ store.isEdit ? "Update" : "Submit" }}</BaseButton
            >
          </div>
        </form>
      </VContainer>
    </VCard>
  </VDialog>
</template>
