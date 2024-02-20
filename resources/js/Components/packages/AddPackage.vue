<script setup>
import BaseInput from "@/Components/Input.vue";
import BaseLabel from "@/Components/Label.vue";
import BaseButton from "@/Components/Button.vue";
import { usePackage } from "@/store/package";
import { reactive } from "vue";
import Select from "../Select.vue";

const store = usePackage();
defineProps({
  cities: Array,
});

const onSubmit = () => {
  store.form.post(route("packages.store"), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
    },
    onFinish: () => {
      store.form.reset();
    },
  });
  // console.log(store.form.data());
};
// const onChange = (event) => {
//   const file = event.target.files[0];
//   state.fileName = file.name;
//   store.form.image = file;
// };
const onUpdate = () => {
  store.form.post(route("packages.update", { id: store.form.id }), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
      store.isEdit = false;
    },
    onFinish: () => {
      store.form.reset();
    },
  });
};
</script>
<template>
  <v-dialog v-model="store.dialog" width="400">
    <v-card>
      <v-card-title>
        <span class="text-h6"> {{ store.isEdit ? "Edit Package" : "Add Package" }} </span>
      </v-card-title>

      <v-container>
        <form class="space-y-2" @submit.prevent="store.isEdit ? onUpdate() : onSubmit()">
          <div>
            <BaseInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="store.form.title"
              autofocus
              placeholder="Title"
            />
            <p v-if="store.form.errors.title" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.title }}
            </p>
          </div>
          <div>
            <BaseInput
              id="rides"
              type="text"
              class="mt-1 block w-full"
              v-model="store.form.rides"
              placeholder="Rides"
            />
            <p v-if="store.form.errors.rides" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.rides }}
            </p>
          </div>
          <div>
            <BaseInput
              id="price"
              type="text"
              class="mt-1 block w-full"
              v-model="store.form.price"
              placeholder="Price"
            />
            <p v-if="store.form.errors.price" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.price }}
            </p>
          </div>
          <div>
            <Select v-model="store.form.city_id">
              <option v-for="city in cities" :key="city.id" :value="city.id">
                {{ city.name }}
              </option>
            </Select>
          </div>
          <div class="flex items-center justify-end mt-6">
            <BaseButton
              @click.prevent="store.dialog = false"
              type="button"
              class="w-full flex items-center justify-center bg-white mr-3"
              :class="{ 'opacity-25': store.form.processing }"
              :disabled="store.form.processing"
            >
              <p class="text-[#161515]">Cancel</p>
            </BaseButton>
            <BaseButton
              class="w-full flex items-center justify-center bg-[#161515]"
              :class="{ 'opacity-25': store.form.processing }"
              :disabled="store.form.processing"
            >
              {{ store.isEdit ? "Update" : "Submit" }}
            </BaseButton>
          </div>
        </form>
      </v-container>
    </v-card>
  </v-dialog>
</template>
