<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import StatictsCard from "@/Components/dashboard/StatictsCard.vue";
import CreditCard from "@/Components/CreditCard.vue";

const state = reactive({
  tab: null,
});
const props = defineProps({
  rider: Object,
  totalBookings: String,
  currentBookings: String,
  completedBookings: String,
  cancelledBookings: String,
});
const currentBooking = [props.rider?.rider_active_booking];
</script>

<template>
  <Head title="Profile" />
  <BaseLayout isBack title="Rider Profile">
    <main class="p-6 flex flex-col">
      <section
        class="bg-white p-4 rounded-lg flex space-x-2 flex-row items-center shadow-[0_4px_10px_rgba(0,0,0,0.15)] justify-between"
      >
        <div class="flex flex-row items-center">
          <img :src="rider?.avatar" class="h-28 rounded-full" alt="driver image" />
          <div class="ml-5" name="name_email">
            <h1 class="text-xl sm:text-2xl">{{ rider?.name }}</h1>
            <p class="text-[#636363] text-md sm:text-lg text-normal">
              {{ rider?.email }}
            </p>
          </div>
        </div>
        <p>
          Ride Status : <span>{{ rider.ride_status }}</span>
        </p>
      </section>
      <!-- booking staticts -->
      <section class="flex flex-row items-center justify-start space-x-0 flex-wrap mt-5">
        <StatictsCard title="Total Bookings" :subtitle="totalBookings" icon="mdi-car" />
        <StatictsCard
          title="Current Bookings"
          :subtitle="currentBookings"
          icon="mdi-car"
        />
        <StatictsCard
          title="Completed Bookings"
          :subtitle="completedBookings"
          icon="mdi-car"
        />
        <StatictsCard
          title="Cancelled Bookings"
          :subtitle="cancelledBookings"
          icon="mdi-car"
        />
      </section>
      <section class="flex flex-col space-y-5">
        <div
          class="bg-white w-full mt-10 rounded-lg p-6 flex flex-col shadow-[0_4px_10px_rgba(0,0,0,0.15)] text-left"
        >
          <h1 class="text-semibold text-lg">Personal Detail</h1>
          <ul class="flex flex-col grid-row-2 divide-y text-[#383838] mt-2">
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-account</v-icon>
              <p><b> Name: </b>{{ rider.name }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-email</v-icon>
              <p><b> Email: </b>{{ rider.email }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-phone</v-icon>
              <p><b> Phone: </b>{{ rider.phone ?? "Null" }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center">
              <v-icon>mdi-account</v-icon>
              <p class="mt-2">
                <b> Push Token: </b>{{ rider.push_token ? rider.push_token : "Null" }}
              </p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-earth</v-icon>
              <p><b> Lattitude: </b>{{ rider.lat ?? "Null" }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-earth</v-icon>
              <p><b> Longitude: </b>{{ rider.lng ?? "Null" }}</p>
            </li>
          </ul>
        </div>
      </section>
    </main>
  </BaseLayout>
</template>
