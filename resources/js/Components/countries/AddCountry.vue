<script setup>
import { useCountries } from "@/store/country";
import BaseInput from "@/Components/Input.vue";
import BaseButton from "@/Components/Button.vue";
import { ref } from "vue";
const store = useCountries();
const fileName = ref("");
const onChange = (event) => {
  const file = event.target.files[0];
  fileName.value = file.name;
  store.form.image = file;
};
const onSubmit = () => {
  store.form.post(route("countries.store"), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
    },
    onFinish: () => {
      store.form.reset();
      fileName.value = "";
    },
  });
};
const onUpdate = () => {
  store.form.post(route("countries.update", { id: store.form.id }), {
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
  <VDialog v-model="store.dialog" persistent max-width="290">
    <VCard class="w-80">
      <VCardTitle>
        <span class="text-h6"> {{ store.isEdit ? "Edit Country" : "Add Country" }} </span>
      </VCardTitle>
      <VContainer>
        <form @submit.prevent="store.isEdit ? onUpdate() : onSubmit()" class="space-y-2">
          <label
            for="inputTag"
            class="cursor-pointer bg-gray-200 py-2 px-2 rounded-lg flex justify-start items-center space-x-2"
          >
            <v-icon class="cursor-pointer" color="#8B8B8B">mdi-camera</v-icon>
            <div>
              <span v-if="fileName" id="imageName" class="text-black">
                {{ fileName }}
              </span>
              <p v-else>Select Image</p>
            </div>
            <input
              id="inputTag"
              type="file"
              class="hidden py-2"
              @change="(e) => onChange(e)"
            />
          </label>
          <BaseInput
            placeholder="Name"
            class="w-full py-2 px-3"
            v-model="store.form.name"
          />
          <p v-if="store.form.errors.name" class="text-xs mx-1 mt-1 text-red-500">
            {{ store.form.errors.name }}
          </p>
          <div class="flex space-x-4 pt-5">
            <BaseButton
              @click.prevent="store.dialog = false"
              secondary
              type="button"
              class="w-full flex items-center justify-center"
              ><p class="text-black">Cancel</p></BaseButton
            >
            <BaseButton
              :class="{ 'opacity-25': store.form.processing }"
              :disabled="store.form.processing"
              class="w-full flex items-center justify-center"
              >{{ store.isEdit ? "Update" : "Submit" }}</BaseButton
            >
          </div>
        </form>
      </VContainer>
    </VCard>
  </VDialog>
</template>
