<script setup>
import BaseInput from "@/Components/Input.vue";
import BaseLabel from "@/Components/Label.vue";
import BaseButton from "@/Components/Button.vue";
import { useVehicles } from "@/store/vehicle";
import { reactive } from "vue";

const store = useVehicles();
const state = reactive({});

const onSubmit = () => {
  store.form.post(route("vehicles.store", { id: store.form.city_id }), {
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
const onChange = (event) => {
  const file = event.target.files[0];
  store.fileName = file.name;
  store.form.image = file;
};
function onUpdate() {
  store.form.post(route("vehicles.update", { id: store.form.id }), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
    },
  });
}
</script>
<template>
  <v-dialog v-model="store.dialog" persistent max-width="290">
    <v-card class="w-80">
      <v-card-title>
        <span class="text-h6"> {{ store.isEdit ? "Edit Vehicle" : "Add Vehicle" }} </span>
      </v-card-title>

      <v-container>
        <form @submit.prevent="store.isEdit ? onUpdate() : onSubmit()">
          <div>
            <label
              for="inputTag"
              class="cursor-pointer bg-gray-200 py-2 px-2 rounded-lg flex justify-start items-center space-x-2"
            >
              <v-icon class="cursor-pointer" color="#8B8B8B">mdi-camera</v-icon>
              <!-- file name -->
              <div>
                <span v-if="store.fileName" id="imageName" class="text-black">{{
                  store.fileName
                }}</span>
                <p v-else>Select Image</p>
              </div>
              <!-- file input -->
              <input
                id="inputTag"
                type="file"
                class="hidden py-2"
                @change="(e) => onChange(e)"
              />
            </label>
            <BaseLabel class="mt-2" for="title" value="Title" />
            <BaseInput
              id="title"
              type="text"
              class="mt-1 block w-full px-3"
              v-model="store.form.title"
              autofocus
              placeholder="Vehicle title"
            />
            <p v-if="store.form.errors.title" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.title }}
            </p>

            <BaseLabel class="mt-2" for="title" value="Seats" />
            <BaseInput
              id="seats"
              type="number"
              class="mt-1 block w-full px-3"
              v-model="store.form.seats"
              autofocus
              placeholder="Vehicle seats"
            />
            <p v-if="store.form.errors.title" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.title }}
            </p>
          </div>
          <div class="flex items-center justify-end mt-6">
            <BaseButton
              @click.prevent="store.dialog = false"
              type="button"
              secondary
              class="w-full flex items-center justify-center mr-3"
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
