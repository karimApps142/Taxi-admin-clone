<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Table from "@/Components/Table.vue";
import { reactive } from "vue";
import Actions from "@/Components/Actions.vue";
import { useAlerts } from "@/hooks/useAlerts";

const props = defineProps({
  booking: Object,
  missedBy: Array,
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
const state = reactive({});
</script>

<template>
  <Head title="Bookings Detail" />
  <BaseLayout title="Bookings Detail" is-back>
    <main class="flex flex-col py-5">
      <ul
        class="bg-white shadow-[0_4px_10px_rgba(0,0,0,0.15)] p-10 w-[98%] rounded-lg block box-border space-y-5"
      >
        <div class="relative">
          <div class="flex flex-col space-y-2 absolute right-0">
            <div
              :class="[
                ' ml-auto text-center text-white px-1 rounded font-sans capitalize',
                booking.status === 'completed'
                  ? 'bg-[#4BD28F]'
                  : booking.status === 'active'
                  ? 'bg-[#C6D610]'
                  : booking.status === 'enRoute'
                  ? 'bg-[#0194FF]'
                  : booking.status === 'pending'
                  ? 'bg-[#FFAA00]'
                  : booking.status === 'arrived'
                  ? 'bg-[#996995]'
                  : booking.status === 'progress'
                  ? 'bg-[#FFAA00]'
                  : booking.status === 'cancelled'
                  ? 'bg-[#FF0000]'
                  : 'bg-[#FF8410]',
              ]"
            >
              {{
                booking.cronjob_at
                  ? "AUTO EXPIRE BY SYSTEM"
                  : booking.status === "enRoute"
                  ? "Going to Pickup"
                  : booking.status === "progress"
                  ? "Going to Dropoff"
                  : booking.status
              }}
            </div>
            <p
              v-if="booking.status === 'cancelled' || booking.status === 'accepted'"
              class="ml-auto"
            >
              by {{ booking.cancelled_by ?? booking.driver?.name }}
            </p>
          </div>
        </div>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Booking Id</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.booking_nr }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Driver Name</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.driver?.name }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Rider Name</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.rider?.name }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Pickup</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.pickup_address }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Drop Off</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">
            {{ booking.dropoff_address }}
          </li>
        </ul>
        <ul v-if="booking.date" class="flex flex-row flex-wrap">
          <li class="w-44">Date</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.date }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Start Time</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.accepted_at }}</li>
        </ul>
        <div v-show="booking.status !== 'expire'">
          <ul v-if="booking.completed_at" class="flex flex-row flex-wrap">
            <li class="w-44">End Time</li>
            <li class="w-24">:</li>
            <li class="w-[40rem]">{{ booking.completed_at }}</li>
          </ul>
          <ul v-else class="flex flex-row flex-wrap">
            <li class="w-44">Cancelled Time</li>
            <li class="w-24">:</li>
            <li class="w-[40rem]">{{ booking.cancelled_at }}</li>
          </ul>
        </div>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Vehicle Type</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.vehicle }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Wheel Chair Access</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.with_chair ? "Yes" : "No" }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Accompanied with Guide Dog</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.with_dog ? "Yes" : "No" }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Carrying Pets</li>
          <li class="w-24">:</li>
          <li class="w-[40rem]">{{ booking.with_pets ? "Yes" : "No" }}</li>
        </ul>
        <ul class="flex flex-row flex-wrap">
          <li class="w-44">Payment Method</li>
          <li class="w-24">:</li>
          <li class="w-[40rem] capitalize">{{ booking.payment_type }}</li>
        </ul>
      </ul>

      <div
        class="flex flex-col items-start justify-around p-2"
        v-for="rating in booking.ratings"
      >
        <div class="flex flex-row items-center space-x-2 py-2">
          <img :src="rating.user.avatar" class="w-10 h-10 rounded-full" />
          <div>
            <h1 class="font-medium capitalize">{{ rating.user.name }}</h1>
            <p class="capitalize text-slate-500">{{ rating.user.role }}</p>
          </div>
        </div>
        <div class="bg-[#F3F4F8] rounded-lg p-3">
          <!-- <img src="\icons\5 star.svg" alt="" /> -->
          <v-rating
            v-model="rating.stars"
            readonly
            size="18"
            color="yellow-darken-2"
          ></v-rating>
          <p class="mt-2">
            {{ rating.review }}
          </p>
        </div>
      </div>
      <v-card-title class="px-0">Missed By</v-card-title>
      <Table class="rounded border">
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
          <tr v-for="driver in props.missedBy" :key="driver.id" class="cursor-pointer">
            <td>
              <img :src="driver.avatar" class="w-10 rounded-full" alt="" />
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
            <td class="p-2 pl-5 flex flex-row">
              <Actions :isStatus="driver.status" @click="onStatusChange(driver)" />
              <Actions :isDelete="true" @click="onDelete(driver.id)" />
              <Link as="button" href="/driver" :data="{ slug: driver.slug }">
                <Actions :isView="true" />
              </Link>
            </td>
          </tr>
        </tbody>
      </Table>
    </main>
  </BaseLayout>
</template>
