<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Table from "@/Components/Table.vue";
import { reactive, ref } from "vue";
import Pagination from "@/Components/Pagination.vue";
import moment from "moment";

const form = useForm({
  filter: "",
});
const props = defineProps({
  filter: String,
  bookings: Object,
});
const onFilter = () => {
  form.get(route("bookings"), {
    preserveScroll: true,
  });
};
const state = reactive({
  filters: [
    {
      title: "All",
      value: null,
    },
    {
      title: "Pending",
      value: "pending",
    },
    {
      title: "Accepted",
      value: "accepted",
    },
    {
      title: "Going to Pickup",
      value: "enRoute",
    },
    {
      title: "Arrived",
      value: "arrived",
    },
    {
      title: "Going to Dropoff",
      value: "progress",
    },
    {
      title: "Completed",
      value: "completed",
    },
    {
      title: "Cancelled",
      value: "cancelled",
    },
    {
      title: "Cancelled by Rider",
      value: "cancelledByRider",
    },
    {
      title: "Cancelled by Driver",
      value: "cancelledByDriver",
    },
    {
      title: "Expired By System",
      value: "expiredBySystem",
    },
    {
      title: "Expired By Rider",
      value: "expiredByRider",
    },
  ],
});
const tab = ref(null);
const scrollNext = () => {
  const tabs = document.getElementById("tabs");
  tabs.scrollBy(100, 0);
};
const scrollPrev = () => {
  const tabs = document.getElementById("tabs");
  tabs.scrollBy(-100, 0);
};
</script>

<template>
  <Head title="Bookings" />
  <BaseLayout title="Bookings">
    <div class="flex flex-row items-center relative">
      <span class="absolute left-0 z-50">
        <VBtn @click="scrollPrev()" size="small" icon="mdi-chevron-left" />
      </span>
      <!--  -->
      <span class="absolute right-0 z-50">
        <VBtn
          @click="scrollNext()"
          class="absolute"
          size="small"
          icon="mdi-chevron-right"
        />
      </span>
      <div
        id="tabs"
        ref="tabs"
        class="py-2 flex flex-row items-center space-x-2 overflow-auto max-w-5xl px-10"
      >
        <VBtn
          v-for="item in state.filters"
          :key="item.value"
          size="small"
          @click="
            () => {
              form.filter = item.value;
              onFilter();
            }
          "
          :color="filter === item.value ? '#1D1C1C' : '#F7F7F7'"
          :class="filter === item.value ? 'text-white' : 'text-black'"
          variant="flat"
          >{{ item.title }}</VBtn
        >
      </div>
    </div>
    <section class="flex flex-col">
      <Table class="border rounded mt-5">
        <thead>
          <tr class="bg-[#1D1C1C] text-white">
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Booking Id
            </th>
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Driver Name
            </th>
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Rider Name
            </th>
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Location
            </th>
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Destination
            </th>
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Status
            </th>
            <th
              class="p-2 pr-16 pl-5 font-medium font[arial] text-base text-left w-54"
            >
              Date
            </th>
          </tr>
        </thead>
        <tbody>
          <Link
            as="tr"
            :href="route('booking.detail', { id: booking.id })"
            v-for="booking in filter ? props.bookings : props.bookings.data"
            :key="booking.id"
            class="cursor-pointer"
          >
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              {{ booking.booking_nr }}
            </td>
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              {{ booking.driver?.name }}
            </td>
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              {{ booking.rider?.name }}
            </td>
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              {{ booking.pickup_address }}
            </td>
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              {{ booking.dropoff_address }}
            </td>
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              <div
                class="w-20 text-center"
                :class="[
                  'text-white px-1 rounded font-sans capitalize',
                  booking.status === 'completed'
                    ? 'bg-[#4BD28F]'
                    : booking.status === 'active'
                    ? 'bg-[#C6D610]'
                    : booking.status === 'enRoute'
                    ? 'bg-[#0194FF] w-28'
                    : booking.status === 'pending'
                    ? 'bg-[#FFAA00]'
                    : booking.status === 'arrived'
                    ? 'bg-[#996995]'
                    : booking.status === 'progress'
                    ? 'bg-[#FFAA00] w-32'
                    : booking.status === 'cancelled'
                    ? 'bg-[#FF0000]'
                    : booking?.status === 'expired' && booking?.cronjob_at
                    ? 'bg-[#ff3410] w-36'
                    : booking?.status === 'expired' && !booking?.cronjob_at
                    ? 'bg-[#FF8410] w-36'
                    : 'bg-[#FF8410]',
                ]"
              >
                {{
                  booking.status === "enRoute"
                    ? "Going to Pickup"
                    : booking.status === "progress"
                    ? "Going to Dropoff"
                    : booking.status === "expired" && booking?.cronjob_at
                    ? "EXPIRE BY SYSTEM"
                    : booking.status === "expired" && !booking?.cronjob_at
                    ? "Expire By Rider"
                    : booking.status
                }}
              </div>
            </td>
            <td
              class="p-2 pl-5 font-medium font[arial] text-base text-left border-b-2"
            >
              {{ moment(booking.created_at).calendar() }}
            </td>
          </Link>
        </tbody>
      </Table>
      <div class="py-2">
        <Pagination v-if="!filter" :links="bookings.links" />
      </div>
    </section>
  </BaseLayout>
</template>
<style scoped>
#tabs::-webkit-scrollbar {
  display: none;
}
</style>
