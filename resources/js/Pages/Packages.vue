<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import Table from "@/Components/Table.vue";
import AddPackage from "@/Components/packages/AddPackage.vue";
import { usePackage } from "@/store/package";
import Actions from "@/Components/Actions.vue";
import { useAlerts } from "@/hooks/useAlerts";
import Pagination from "@/Components/Pagination.vue";
import BaseButton from "@/Components/Button.vue";
import BaseInput from "@/Components/Input.vue";

const store = usePackage();
const searchForm = useForm({
  search: "",
});
defineProps({
  packages: Array,
  cities: Array,
  search: Boolean,
});
const { alert } = useAlerts();
const onDelete = (id) => {
  alert(
    null,
    "this action will delete package",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed ? store.form.delete(route("packages.delete", { id: id })) : null
  );
};
const onStatusChange = (id) => {
  alert(
    null,
    "this action will change package status",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed ? store.form.put(route("packages.status", { package: id })) : null
  );
};
const onSearch = () => {
  searchForm.get(route("packages"));
};
const onClear = () => {
  searchForm.search = "";
  onSearch();
};
</script>

<template>
  <BaseLayout title="Packages">
    <Head title="Packages" />
    <div class="flex flex-row justify-between items-center w-full py-2 pb-5">
      <!-- search start -->
      <form @submit.prevent="onSearch()">
        <div class="flex space-x-2">
          <BaseInput
            type="search"
            class="bg-slate-200"
            placeholder="Search Packages..."
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
            class="h-10 w-10 flex items-center justify-center bg-slate-200 hover:bg-slate-300 active:bg-slate-300"
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
            store.dialog = true;
            store.isEdit = false;
          }
        "
        color="black"
        icon="mdi-plus"
        class="ml-auto my-2"
      />
    </div>
    <Table class="rounded border">
      <thead>
        <tr class="bg-[#1D1C1C] text-white">
          <th>Ttile</th>
          <th>Rides</th>
          <th>Price</th>
          <th>City</th>
          <th>Status</th>
          <th class="w-40">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in search ? packages : packages.data"
          :key="item.id"
          class="cursor-pointer"
        >
          <td>{{ item.title }}</td>
          <td>{{ item.rides }}</td>
          <td>{{ item.price }}</td>
          <td>{{ item.city.name }}</td>
          <td>
            <span
              :class="[
                'text-white px-2 rounded font-serif',
                item.status === 'active' ? 'bg-green-700' : 'bg-red-700',
              ]"
            >
              {{ item.status }}</span
            >
          </td>
          <td class="flex">
            <Actions @click="onDelete(item.id)" isDelete />
            <Actions @click="onStatusChange(item.id)" :isStatus="item.status" />
            <Actions
              @click="
                () => {
                  store.form.id = item.id;
                  store.form.title = item.title;
                  store.form.rides = item.rides;
                  store.form.price = item.price;
                  store.form.city_id = item.city_id;
                  store.isEdit = true;
                  store.dialog = true;
                }
              "
              isEdit
            />
          </td>
        </tr>
      </tbody>
    </Table>
    <Pagination v-if="!search" :links="packages?.links" />
    <AddPackage :cities="cities" />
  </BaseLayout>
</template>
