<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import Table from "@/Components/Table.vue";
import Actions from "../Components/Actions.vue";
import { useAlerts } from "@/hooks/useAlerts";
import Pagination from "@/Components/Pagination.vue";
import BaseButton from "@/Components/Button.vue";
import BaseInput from "@/Components/Input.vue";
import AddDriver from "@/Components/driver/AddDriver.vue";
import { useDriver } from "@/store/driver";
import moment from "moment";

const store = useDriver();
const props = defineProps({
  drivers: Object,
  search: Boolean,
  filter: String,
  vehicles: Array,
  cities: Array,
});
const form = useForm({});
const { alert } = useAlerts();
const onStatusChange = (driver) => {
  alert(
    null,
    `Are you sure you want to ${
      driver.status === "active" ? "block" : "unblock"
    } this driver`,
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed
      ? form.put(route("drivers.status.change", { user: driver }), {
          preserveScroll: true,
          onSuccess: () => {},
        })
      : null
  );
};
const onDelete = (id) => {
  alert(null, `Are you sure you want to delete driver`, null, "Yes , do it!").then(
    ({ isConfirmed }) =>
      isConfirmed
        ? form.delete(route("drivers.delete", { id: id }), {
            preserveScroll: true,
            onSuccess: () => {},
          })
        : null
  );
};
const searchForm = useForm({
  filter: props.filter ?? "",
  search: "",
});
const onSearch = () => {
  searchForm.get(route("drivers"));
};
const onClear = () => {
  (searchForm.search = ""), onSearch();
};
const state = reactive({
  searchBy: [
    {
      title: "Name",
      value: "name",
    },
    {
      title: "Email",
      value: "email",
    },
    {
      title: "Phone",
      value: "phone",
    },
    {
      title: "Vehicle No",
      value: "vehicle_nr",
    },
    {
      title: "Status",
      value: "status",
    },
  ],
});
</script>
<template>
  <Head title="Drivers" />
  <BaseLayout title="Drivers">
    <section class="flex flex-col">
      <div class="flex">
        <!-- search start -->
        <form @submit.prevent="onSearch()" class="py-2">
          <div class="flex space-x-2">
            <div class="flex items-center bg-slate-200 pr-2 rounded-md focus:ring-1">
              <BaseInput
                type="search"
                class="bg-slate-200 focus:ring-0"
                placeholder="Search Drivers..."
                v-model="searchForm.search"
              />
              <v-menu>
                <template v-slot:activator="{ props }">
                  <VIcon
                    icon="mdi-filter-variant"
                    class="cursor-pointer"
                    v-bind="props"
                  />
                </template>
                <v-list class="w-40">
                  <v-radio-group v-model="searchForm.filter">
                    <v-radio
                      v-for="item in state.searchBy"
                      :key="item"
                      :label="item.title"
                      :value="item.value"
                    />
                  </v-radio-group>
                </v-list>
              </v-menu>
            </div>
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
              store.isEdit = false;
              store.dialog = true;
            }
          "
          icon="mdi-plus"
          color="black"
          class="ml-auto"
        />
      </div>
      <Table class="border rounded">
        <thead>
          <tr class="bg-[#1D1C1C] text-white">
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Vehicle No</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="driver in search ? drivers : drivers.data"
            :key="driver.id"
            class="cursor-pointer"
          >
            <td class="relative">
              <div
                :class="`w-3 h-3 absolute top-1 z-10 rounded-full ${
                  driver.active_status === 'online' ? 'bg-green-700' : 'bg-red-500'
                }`"
              ></div>
              <img :src="driver.avatar" class="w-10 h-10 rounded-full" alt="" />
            </td>
            <td>
              {{ driver.name }}
            </td>
            <td>
              {{ driver.email }}
            </td>
            <td>
              {{ driver.phone }}
            </td>
            <td>
              {{ driver.vehicle_nr }}
            </td>
            <td>
              <span
                :class="[
                  'text-white px-2 rounded font-sans capitalize',
                  driver.status === 'active' && driver.profile_status === 'complete'
                    ? 'bg-green-700'
                    : driver.profile_status === 'pending' ||
                      driver.profile_status === 'progress'
                    ? 'bg-[#FFAA00]'
                    : 'bg-[#FF0000]',
                ]"
              >
                {{
                  driver.profile_status === "pending" ||
                  driver.profile_status === "progress"
                    ? driver.profile_status
                    : driver.status
                }}</span
              >
            </td>
            <td class="p-2 pl-5 border-b-2 flex flex-row">
              <Actions :isStatus="driver.status" @click="onStatusChange(driver)" />
              <Actions :isDelete="true" @click="onDelete(driver.id)" />
              <!-- 'YYYY-MM-DD',  -->
              <Actions
                :isEdit="true"
                @click="
                  () => {
                    store.form.id = driver?.id;
                    store.form.name = driver?.name;
                    store.form.preferred_name = driver?.preferred_name;
                    store.form.email = driver?.email;
                    store.form.phone = driver?.phone;
                    store.form.password = driver?.password;
                    store.form.password_confirmation = driver?.password;
                    store.form.dob = moment(driver?.dob).format('YYYY-MM-DD');
                    store.form.resident = driver?.resident;
                    store.form.street_address = driver?.street_address;
                    store.form.vehicle_id = driver?.vehicle_id;
                    store.form.city_id = driver?.city_id;
                    store.form.car_company = driver?.car_company;
                    store.form.car_model = driver?.car_model;
                    store.form.car_color = driver?.car_color;
                    store.form.vehicle_nr = driver?.vehicle_nr;
                    store.form.with_chair = driver?.with_chair;
                    store.form.with_dog = driver?.with_dog;
                    store.form.with_pets = driver?.with_pets;
                    store.isEdit = true;
                    store.dialog = true;
                  }
                "
              />
              <Link as="button" href="/driver" :data="{ slug: driver.slug }">
                <Actions :isView="true" />
              </Link>
            </td>
          </tr>
        </tbody>
      </Table>
      <Pagination v-if="!search" :links="drivers?.links" />
    </section>
    <AddDriver :vehicles="props.vehicles" :cities="props.cities" />
  </BaseLayout>
</template>
