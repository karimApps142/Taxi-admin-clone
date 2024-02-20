<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import AddCountry from "@/Components/countries/AddCountry.vue";
import { useCountries } from "@/store/country";
import { reactive, ref } from "vue";
import { useAlerts } from "@/hooks/useAlerts";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import BaseButton from "@/Components/Button.vue";
import BaseInput from "@/Components/Input.vue";

const store = useCountries();
const searchForm = useForm({
  search: "",
});
const { alert } = useAlerts();
const state = reactive({});
const dialog = ref(true);

defineProps({
  countries: Object,
});
const onDelete = (id) => {
  alert(
    null,
    "this action will delete country",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed ? store.form.delete(route("countries.delete", { id: id })) : null
  );
};
const onSearch = () => {
  searchForm.get(route("countries"));
};
const onClear = () => {
  (searchForm.search = ""), onSearch();
};
</script>

<template>
  <BaseLayout>
    <Head title="Countries" />
    <div class="flex flex-row justify-between items-center w-full py-2 pb-5">
      <form @submit.prevent="onSearch()">
        <div class="flex space-x-2">
          <BaseInput
            type="search"
            class="bg-slate-200"
            placeholder="Search Country..."
            v-model="searchForm.search"
          />
          <div class="">
            <BaseButton type="submit" class="h-10 w-10 flex items-center justify-center">
              <VIcon icon="mdi-magnify" />
            </BaseButton>
          </div>
          <BaseButton
            type="submit"
            @click="onClear()"
            class="h-10 w-10 flex items-center justify-center active:bg-slate-300"
            secondary
          >
            <VIcon color="black" icon="mdi-close" />
          </BaseButton>
        </div>
      </form>
      <!-- search end -->
      <div class="py-2">
        <VBtn
          @click="
            () => {
              store.form.reset();
              store.dialog = true;
            }
          "
          icon="mdi-plus"
          color="black"
          class="ml-auto"
        />
      </div>
    </div>
    <div class="flex grid-col-4 gap-4 cursor-pointer flex-wrap">
      <VCard class="w-64 hover:shadow-xl" v-for="country in countries" :key="country.id">
        <Link :href="`/${country.id}/cities`">
          <div class="w-64 h-36 flex justify-center items-center overflow-hidden">
            <img class="min-w-full min-h-full" :src="country.image" />
          </div>
        </Link>
        <div class="flex justify-between">
          <Link :href="`/${country.id}/cities`">
            <h1 class="py-3 px-2 text-lg">{{ country.name }}</h1>
          </Link>
          <VCardActions>
            <VBtn @click="onDelete(country.id)" text icon="mdi-delete" />
            <VBtn
              @click="
                () => {
                  store.form.id = country.id;
                  store.form.name = country.name;
                  store.form.image = country.image;
                  store.dialog = true;
                  store.isEdit = true;
                }
              "
              text
              icon="mdi-pencil"
            />
          </VCardActions>
        </div>
      </VCard>
    </div>
    <AddCountry />
  </BaseLayout>
</template>
