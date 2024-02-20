<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import Table from "@/Components/Table.vue";
import Actions from "@/Components/Actions.vue";
import { reactive } from "vue";
import AddVehicle from "../Components/VehicleTypes/AddVehicle.vue";
import { useVehicles } from "@/store/vehicle";
import { useAlerts } from "@/hooks/useAlerts";
import { computed } from "vue";
import Pagination from "@/Components/Pagination.vue";
import BaseButton from "@/Components/Button.vue";
import BaseInput from "@/Components/Input.vue";

const state = reactive({
  dialog: false,
});
const searchForm = useForm({
  search: "",
});
const store = useVehicles();
const props = defineProps({
  city: Array,
  vehicles: Array,
  search: Boolean,
});
const onStatusChange = (id) => {
  alert(null, "this action will change vehicle status", null, "Yes , do it!").then(
    ({ isConfirmed }) =>
      isConfirmed
        ? store.form.put(route("vehicles.status", { vehicle: id }), {
            preserveScroll: true,
            onSuccess: () => {},
          })
        : null
  );
};
const renderStatusColor = computed((status) =>
  status === "active" ? "text-green-400" : "text-red-400"
);
const { alert } = useAlerts();
const onDelete = (id) => {
  alert(
    null,
    "this action will delete vehicle",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed ? store.form.delete(route("vehicles.delete", { id: id })) : null
  );
};

const onChange = (event) => {
  const file = event.target.files[0];
  store.form.image = file;
};
const onSearch = () => {
  searchForm.get(route("vehicles", { city: props.city.id }));
};
const onClear = () => {
  searchForm.search = "";
  onSearch();
};
</script>
<template>
  <Head :title="`${city.name} Vehicles`" />
  <BaseLayout isBack :title="`${city.name} Vehicles`">
    <section class="flex flex-col">
      <div class="flex flex-row justify-between items-center w-full py-2 pb-5">
        <!-- search start -->
        <form @submit.prevent="onSearch()">
          <div class="flex space-x-2">
            <BaseInput
              type="search"
              class="bg-slate-200"
              placeholder="Search Vehicle..."
              v-model="searchForm.search"
            />
            <div class="">
              <BaseButton
                type="submit"
                class="h-10 w-10 flex items-center justify-center"
              >
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
        <v-btn
          @click="
            () => {
              store.form.reset();
              store.form.clearErrors();
              store.fileName = '';
              store.form.title = '';
              store.form.image = '';
              store.form.seats = '';
              store.form.city_id = city.id;
              store.dialog = true;
              store.isEdit = false;
            }
          "
          color="#1D1C1C"
          icon="mdi-plus"
          class="text-white"
        ></v-btn>
      </div>
      <Table class="border rounded">
        <thead class="bg-[#2e2c2b] text-white">
          <tr>
            <th class="">Image</th>
            <th class="">Title</th>
            <th class="">Status</th>
            <th class="w-28">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in search ? vehicles : vehicles.data"
            :key="item.id"
            class="cursor-pointer"
          >
            <td>
              <img class="w-12" :src="item.image" alt="" />
            </td>
            <td>{{ item.title }}</td>
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
            <td class="flex flex-row">
              <Actions
                :isEdit="true"
                @click="
                  () => {
                    store.form.id = item?.id;
                    store.form.title = item?.title;
                    store.form.seats = item?.seats;
                    store.form.image = item?.image;
                    store.dialog = true;
                    store.isEdit = true;
                  }
                "
              />
              <Actions :isStatus="item.status" @on-status="onStatusChange(item.id)" />
              <Actions :isDelete="true" @click="onDelete(item.id)" />
            </td>
          </tr>
        </tbody>
      </Table>
      <Pagination v-if="!search" :links="vehicles.links" />
    </section>
    <AddVehicle />
  </BaseLayout>
</template>
