<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { LineChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import StatictsCard from "@/Components/dashboard/StatictsCard.vue";
import { reactive } from "vue";
import Table from "../Components/Table.vue";
import BookingsCard from "@/Components/dashboard/BookingsCard.vue";

Chart.register(...registerables);
defineProps({
  vehicles: String,
  drivers: String,
  riders: String,
  totalBookings: String,
  currentBookings: String,
  completedBookings: String,
  cancelledBookings: String,
});
const state = reactive({
  testData: {
    labels: ["Jan", "Feb", "5 april", "10 august", "9 september"],
    datasets: [
      {
        fill: true,
        showLine: false,
        backgroundColor: "#1D1C1C",
        pointRadius: 0,
        label: "Earning",
        data: [0, 200, 400, 800, 100],
      },
    ],
  },

  progress: {
    ads: 20,
    ticket: 30,
    sales: 50,
  },
  statusColor: {
    pending: "#FFC54D",
    success: "#2ACC71",
    error: "#FF0000",
  },
});
</script>

<template>
  <Head title="Dashboard" />
  <BaseLayout>
    <section class="flex items-center justify-between flex-wrap mt-5">
      <StatictsCard
        title="Total Vehicles"
        :subtitle="vehicles"
        icon="mdi-car"
      />
      <StatictsCard
        title="Total Drivers"
        :subtitle="drivers"
        icon="mdi-account"
      />
      <StatictsCard
        title="Total Riders"
        :subtitle="riders"
        icon="mdi-account-multiple"
      />
      <StatictsCard
        title="Total Earnings"
        subtitle="0"
        icon="mdi-chart-areaspline-variant"
      />
    </section>
    <!-- booking section dashboard -->
    <section class="flex items-center justify-between flex-wrap">
      <BookingsCard
        title="Total Bookings"
        :subtitle="totalBookings"
        icon="mdi-car"
      />
      <BookingsCard
        :color="state.statusColor.pending"
        title="Current Bookings"
        :subtitle="currentBookings"
        icon="mdi-car"
      />
      <BookingsCard
        :color="state.statusColor.success"
        title="Completed Bookings"
        :subtitle="completedBookings"
        icon="mdi-car"
      />
      <BookingsCard
        :color="state.statusColor.error"
        title="Cancel Bookings"
        :subtitle="cancelledBookings"
        icon="mdi-car"
      />
    </section>
    <LineChart :chartData="state.testData" :height="400" />
  </BaseLayout>
</template>
