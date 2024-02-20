<script setup>
import BaseButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/Guest.vue";
import BaseInput from "@/Components/Input.vue";
import BaseLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />

    <BreezeValidationErrors class="mb-4" />

    <h2 class="font-bold mb-5 mt-2">Sign in</h2>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <BaseLabel for="email" value="Email" />
        <BaseInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
        />
      </div>

      <div class="mt-4">
        <BaseLabel for="password" value="Password" />
        <BaseInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
        />
        <div class="flex py-2 pb-1">
          <Link :href="route('password.request')" class="text-sm ml-auto">
            Forgot Password?
          </Link>
        </div>
      </div>

      <div class="block">
        <label class="flex items-center">
          <BreezeCheckbox name="remember" v-model:checked="form.remember" />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <BaseButton
          class="w-full flex items-center justify-center bg-[#1D1C1C] h-10 rounded-full"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </BaseButton>
      </div>
    </form>
  </GuestLayout>
</template>
