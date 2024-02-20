<script setup>
import { useCategories } from "@/store/category";
import BaseInput from "@/Components/Input.vue";
import BaseLabel from "@/Components/Label.vue";
import BaseButton from "@/Components/Button.vue";
import { reactive } from "vue";

const state = reactive({});
const store = useCategories();

const onSubmit = () => {
  store.form.post(route("categories.store"), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
    },
    onFinish: () => {
      store.form.reset();
    },
  });
};
const onUpdate = () => {
  store.form.post(route("categories.update", { id: store.form.id }), {
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
    },
    onFinish: () => {
      store.form.reset();
    },
  });
};
</script>

<template>
  <v-dialog v-model="store.dialog">
    <v-card class="w-80">
      <v-card-title>
        <span class="text-h6">New Category</span>
      </v-card-title>

      <v-container>
        <form>
          <div>
            <BaseLabel for="title" value="Title" />
            <BaseInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="store.form.title"
              autofocus
              placeholder="Category title"
            />
            <p v-if="store.form.errors.title" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.title }}
            </p>
          </div>
          <div class="flex justify-between">
            <div>
              <BaseInput
                class="mt-2 py-2 px-2 w-[140px]"
                type="text"
                v-model="store.form.min_price"
                placeholder="Min Price"
              />
              <p
                v-if="store.form.errors.min_price"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.min_price }}
              </p>
            </div>
            <!-- <p v-if="store.form.errors.min_price" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.min_price }}
            </p> -->
            <div>
              <BaseInput
                class="mt-2 py-2 px-2 w-[140px]"
                type="text"
                v-model="store.form.max_price"
                placeholder="Max Price"
              />
              <p
                v-if="store.form.errors.max_price"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.max_price }}
              </p>
            </div>
          </div>

          <div class="flex items-center justify-end mt-6">
            <BaseButton
              @click="store.dialog = false"
              type="button"
              class="w-full flex items-center justify-center bg-white mr-3"
              :class="{ 'opacity-25': store.form.processing }"
              :disabled="store.form.processing"
            >
              <p class="text-[#23df00]">Cancel</p>
            </BaseButton>
            <BaseButton
              @click="onSubmit"
              class="w-full flex items-center justify-center bg-[#23df00]"
              :class="{ 'opacity-25': store.form.processing }"
              :disabled="store.form.processing"
            >
              Submit
            </BaseButton>
          </div>
        </form>
      </v-container>
    </v-card>
  </v-dialog>
</template>
