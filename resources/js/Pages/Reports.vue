<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { LineChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import StatictsCard from "@/Components/dashboard/StatictsCard.vue";
import { reactive, ref } from "vue";
Chart.register(...registerables);

const state = reactive({
  picker: true,
  start: "",
  end: "",
  testData: {
    labels: ["28 may", "30 may", "5 april", "10 august", "9 september"],
    datasets: [
      {
        fill: true,
        showLine: false,
        backgroundColor: "#1d3fb0",
        pointRadius: 0,
        label: "Report",
        data: [0, 200, 400, 800, 100],
      },
    ],
  },
});
</script>

<template>
  <Head title="Reports" />
  <BaseLayout>
    <section class="p-2">
      <p class="font-bold capitalize">earning reports overview</p>

      <p class="font-semibold text-sm capitalize my-3">show data by date range</p>
      <div class="my-2 flex flex-wrap items-center">
        <div
          @click="$refs.startDate.showPicker()"
          class="bg-white w-60 h-10 rounded shadow flex items-center px-2 border relative mr-2 cursor-pointer mb-2"
        >
          <p class="flex-1 mr-2 text-sm font-bold tracking-widest text-gray-500">
            {{ state.start ? state.start : "First Date" }}
          </p>
          <v-icon icon="mdi-calendar-clock"></v-icon>
          <input
            v-model="state.start"
            type="date"
            id="birthday"
            name="birthday"
            class="absolute bottom-0 invisible"
            ref="startDate"
          />
        </div>

        <div
          @click="$refs.endDate.showPicker()"
          class="bg-white w-60 h-10 rounded shadow flex items-center px-2 border relative cursor-pointer"
        >
          <p class="flex-1 mr-2 text-sm font-bold tracking-widest text-gray-500">
            {{ state.end ? state.end : "End Date" }}
          </p>
          <v-icon icon="mdi-calendar-clock"></v-icon>
          <input
            v-model="state.end"
            type="date"
            id="birthday"
            name="birthday"
            class="absolute bottom-0 invisible"
            ref="endDate"
          />
        </div>
        <v-btn size="small" rounded color="success" class="m-2" dark> Genrate </v-btn>
      </div>
      <div class="flex items-center justify-between flex-wrap mt-5">
        <StatictsCard
          title="Total Earning"
          subtitle="1320k"
          icon="mdi-chart-bell-curve-cumulative"
        />
      </div>
      <div class="p-2 rounded shadow mb-4 bg-white">
        <LineChart :chartData="state.testData" :height="400" />
      </div>
    </section>
  </BaseLayout>
</template>
