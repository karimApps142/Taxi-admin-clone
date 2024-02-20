<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import Table from "@/Components/Table.vue";
import Actions from "@/Components/Actions.vue";
import AddCity from "@/Components/cities/AddCity.vue";
import { useCities } from "@/store/city";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { useAlerts } from "@/hooks/useAlerts";
import Pagination from "@/Components/Pagination.vue";
import BaseButton from "@/Components/Button.vue";
import BaseInput from "@/Components/Input.vue";

const store = useCities();
const searchForm = useForm({
  search: "",
});
const { alert } = useAlerts();
const props = defineProps({
  country: Object,
  cities: Array,
  search: Boolean,
});
const onDelete = (id) => {
  alert(
    null,
    "this action will delete city",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed ? store.form.delete(route("cities.delete", { id: id })) : null
  );
};
const onSearch = () => {
  searchForm.get(route("cities", { country: props.country.id }));
};
const onClear = () => {
  searchForm.search = "";
  onSearch();
};
</script>

<template>
  <BaseLayout isBack :title="country.name">
    <Head :title="country.name" />
    <div class="flex flex-row justify-between items-center w-full py-2 pb-5">
      '
      <!-- search start -->
      <form @submit.prevent="onSearch()">
        <div class="flex space-x-2">
          <BaseInput
            type="search"
            class="bg-slate-200"
            placeholder="Search City..."
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
      <VBtn
        @click="
          () => {
            store.form.reset();
            store.form.country_id = country.id;
            store.isEdit = false;
            store.dialog = true;
          }
        "
        icon="mdi-plus"
        color="black"
        class="ml-auto"
      />
    </div>
    <Table class="rounded border">
      <thead>
        <tr class="bg-[#1D1C1C] text-white">
          <th>Name</th>
          <th>Zip Code</th>
          <th>Currency</th>
          <th>Radius</th>
          <th>Unit Distance</th>
          <th class="w-40">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="city in search ? cities : cities.data" :key="city.id">
          <td>
            {{ city.name }}
          </td>
          <td>{{ city.zipcode }}</td>
          <td>{{ city.currency }}</td>
          <td>{{ city.radius }}</td>
          <td>{{ city.unit }}</td>
          <td class="flex flex-row w-28">
            <Actions @click="onDelete(city.id)" :isDelete="true" />
            <Actions
              @click="
                () => {
                  store.form.country_id = city.country_id;
                  store.form.radius = city.radius;
                  store.form.id = city.id;
                  store.form.name = city.name;
                  store.form.zipcode = city.zipcode;
                  store.form.currency = city.currency;
                  store.form.unit = city.unit;
                  store.form.coords = city.coords ? JSON.parse(city.coords) : [];
                  store.isEdit = true;
                  store.dialog = true;
                  store.center = city.coords
                    ? {
                        lat: JSON.parse(city.coords)[0]?.lat,
                        lng: JSON.parse(city.coords)[0]?.lng,
                      }
                    : { lat: 57.477772, lng: -4.224721 };
                }
              "
              :isEdit="true"
            />
            <Link as="button" :href="`/${city.id}/vehicles`">
              <Actions :isView="true" />
            </Link>
          </td>
        </tr>
      </tbody>
    </Table>
    <Pagination v-if="!search" :links="cities.links" />
    <AddCity :country="country" />
  </BaseLayout>
</template>
