<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import Table from "@/Components/Table.vue";
import Actions from "@/Components/Actions.vue";
import { useAlerts } from "@/hooks/useAlerts";
import BaseButton from "@/Components/Button.vue";
import BaseInput from "@/Components/Input.vue";
import { useRider } from "@/store/rider";
import AddRider from "@/Components/rider/AddRider.vue";
import Pagination from "@/Components/Pagination.vue";

const { alert } = useAlerts();
const form = useForm({});
const store = useRider();

const props = defineProps({
  riders: Array,
  search: Boolean,
  filter: String,
});

const onStatusChange = (rider) => {
  alert(
    "Are You Sure",
    `Are you sure you want to ${
      rider.status === "active" ? "block" : "unblock"
    } this rider`,
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed
      ? form.put(route("rider.status.change", { user: rider }), {
          preserveScroll: true,
          onSuccess: () => {},
        })
      : null
  );
};
const onDelete = (id) => {
  alert(
    "Are You Sure",
    "Are you sure you want to delete rider",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed
      ? form.delete(route("rider.delete", { id: id }), {
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
  searchForm.get(route("riders"));
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
      title: "Status",
      value: "status",
    },
  ],
});
</script>

<template>
  <Head title="Riders" />
  <BaseLayout>
    <section class="flex flex-col">
      <!-- search start -->
      <div class="flex">
        <form @submit.prevent="onSearch()" class="py-2">
          <div class="flex space-x-2">
            <div class="flex items-center bg-slate-200 pr-2 rounded-md focus:ring-1">
              <BaseInput
                type="search"
                class="bg-slate-200 focus:ring-0"
                placeholder="Search Riders..."
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
      <Table class="mt-2 border rounded">
        <thead>
          <tr class="bg-[#1D1C1C] text-white">
            <th>image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone No</th>

            <th>Status</th>
            <th class="w-40">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="rider in search ? riders : riders.data"
            :key="rider.sender"
            class="cursor-pointer"
          >
            <td class="p-2 pl-5 border-b-2 relative">
              <div
                :class="`w-3 h-3 absolute top-1 z-10 rounded-full ${
                  rider.active_status === 'online' ? 'bg-green-700' : 'bg-red-500'
                }`"
              ></div>
              <img :src="rider.avatar" class="w-10 h-10 rounded-full bg-gray-400" />
            </td>

            <td>
              {{ rider.name }}
            </td>
            <td>
              {{ rider.email }}
            </td>
            <td>
              {{ rider.phone }}
            </td>

            <td>
              <span
                :class="[
                  'text-white px-2 rounded font-sans capitalize',
                  rider.status === 'active' ? 'bg-green-700' : 'bg-[#FF0000]',
                ]"
              >
                {{ rider.status }}</span
              >
            </td>
            <td class="p-2 pl-5 border-b-2 flex">
              <Actions :isStatus="rider.status" @click="onStatusChange(rider)" />
              <Actions :isDelete="true" @click="onDelete(rider.id)" />
              <Actions
                :isEdit="true"
                @click="
                  () => {
                    store.form.id = rider?.id;
                    store.form.name = rider?.name;
                    store.form.email = rider?.email;
                    store.form.phone = rider?.phone;
                    store.form.password = rider?.password;
                    store.form.password_confirmation = rider?.password;
                    store.isEdit = true;
                    store.dialog = true;
                  }
                "
              />
              <Link href="/rider" :data="{ slug: rider.slug }" as="button">
                <Actions :isView="true" />
              </Link>
            </td>
          </tr>
        </tbody>
      </Table>
      <Pagination v-if="!search" :links="riders?.links" />
    </section>
    <AddRider />
  </BaseLayout>
</template>
