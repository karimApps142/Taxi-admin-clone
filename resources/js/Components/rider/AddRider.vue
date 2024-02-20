<script setup>
import BaseInput from "@/Components/Input.vue";
import BaseLabel from "@/Components/Label.vue";
import BaseButton from "@/Components/Button.vue";
import { useRider } from "@/store/rider";
import { reactive } from "vue";

const store = useRider();
const state = reactive({});

const onSubmit = () => {
  store.form.post(route("riders.store"), {
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
  // console.log(store.form.data());
};
function onUpdate() {
  store.form.put(route("riders.update", { rider: store.form.id }), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
      store.isEdit = false;
    },
  });
}
</script>
<template>
  <v-dialog v-model="store.dialog" persistent max-width="290">
    <v-card class="w-80">
      <v-card-title class="">
        <span class="text-h6"> {{ store.isEdit ? "Edit Rider" : "Add Rider" }} </span>
      </v-card-title>

      <v-container>
        <form @submit.prevent="store.isEdit ? onUpdate() : onSubmit()">
          <div>
            <BaseLabel class="" for="name" value="Name" />
            <BaseInput
              id="name"
              type="text"
              class="mt-1 block w-full px-3"
              v-model="store.form.name"
              autofocus
              placeholder="Name"
            />
            <p v-if="store.form.errors.name" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.name }}
            </p>
            <BaseLabel class="mt-2" for="email" value="Email" />
            <BaseInput
              id="email"
              type="email"
              class="mt-1 block w-full px-3"
              v-model="store.form.email"
              autofocus
              placeholder="Email"
            />
            <p v-if="store.form.errors.email" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.email }}
            </p>
            <BaseLabel class="mt-2" for="phone" value="Phone" />
            <BaseInput
              id="phone"
              type="tel"
              class="mt-1 block w-full px-3"
              v-model="store.form.phone"
              autofocus
              placeholder="Phone"
            />
            <p v-if="store.form.errors.phone" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.phone }}
            </p>
          </div>
          <div v-if="!store.isEdit" class="flex flex-col mt-2">
            <BaseLabel value="Password" />
            <div class="flex items-center relative">
              <BaseInput
                class="px-2 py-2 w-full"
                placeholder="Password"
                :type="store.showPassword ? 'text' : 'password'"
                v-model="store.form.password"
              />
              <button
                type="button"
                @click="store.showPassword = !store.showPassword"
                class="absolute right-2"
              >
                <v-icon
                  color="grey-darken-1"
                  :icon="store.showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                />
              </button>
            </div>
            <p
              v-if="store.form.errors.password"
              class="text-xs mx-1 mt-1 text-red-500 w-52"
            >
              {{ store.form.errors.password }}
            </p>
          </div>
          <!--  -->
          <div v-if="!store.isEdit" class="flex flex-col mt-2">
            <BaseLabel value="Confirm Password" />
            <div class="flex items-center relative">
              <BaseInput
                class="px-2 py-2 w-full"
                placeholder="Confirm Password"
                :type="store.showPassword ? 'text' : 'password'"
                v-model="store.form.password_confirmation"
              />
              <button
                type="button"
                @click="store.showPassword = !store.showPassword"
                class="absolute right-2"
              >
                <v-icon
                  color="grey-darken-1"
                  :icon="store.showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                />
              </button>
              <p
                v-if="store.form.errors.password_confirmation"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.password_confirmation }}
              </p>
            </div>
          </div>
          <div class="flex items-center justify-end mt-8">
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
