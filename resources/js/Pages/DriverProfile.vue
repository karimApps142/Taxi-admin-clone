<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive, onMounted } from "vue";
import StatictsCard from "@/Components/dashboard/StatictsCard.vue";
import CreditCard from "@/Components/CreditCard.vue";
import { useAlerts } from "@/hooks/useAlerts";
import { useVehicles } from "@/store/vehicle";

const { alert } = useAlerts();

const store = useVehicles();

const state = reactive({
  tab: null,
  age: "",
  date: "",
});
const props = defineProps({
  driver: Object,
  totalBookings: Number,
  currentBookings: Number,
  completedBookings: Number,
  cancelledBookings: Number,
});

const onVerify = (id) => {
  alert(null, "Are you sure you want to approve driver", null, "Yes , do it!").then(
    ({ isConfirmed }) =>
      isConfirmed
        ? store.form.put(route("user.profileStatus", { id: id }), {
            preserveScroll: true,
            onSuccess: () => {},
          })
        : null
  );
};
onMounted(() => {
  const today = new Date();
  const birthDate = new Date(props.driver?.dob);
  const difference = today - birthDate;
  if (props.driver?.dob) {
    const age = Math.floor(difference / 31557600000);
    state.age = age;
  }
});
</script>
<template>
  <Head :title="`${props.driver?.name} - Profile`" />
  <BaseLayout isBack title="Driver Profile">
    <main class="p-6 flex flex-col w-[100%]">
      <section
        class="bg-white p-4 rounded-lg flex flex-row justify-between shadow-[0_4px_10px_rgba(0,0,0,0.15)]"
      >
        <div class="flex flex-row items-center flex-wrap space-y-5 sm:space-x-5">
          <img
            :src="props.driver?.avatar"
            class="h-28 rounded-full mr-5"
            alt="driver image"
          />
          <div class="" name="name_email">
            <h1 class="text-xl sm:text-2xl">{{ driver?.name }}</h1>
            <p class="text-[#636363] text-md sm:text-lg text-normal">
              {{ driver?.email }}
            </p>
          </div>
        </div>
        <div class="flex flex-col items-end justify-center">
          <h1 class="text-lg font-[arial] text-[#234816] capitalize">
            {{ driver?.profile_status }}
          </h1>
          <p v-if="driver?.profile_status === 'complete'">
            Ride Status : <span>{{ driver.ride_status }}</span>
          </p>
          <button
            @click="onVerify(driver?.id)"
            v-if="
              driver?.profile_status === 'pending' ||
              driver?.profile_status === 'progress'
            "
            class="bg-[#161515] hover:bg-[#0e0d0d] h-10 w-28 sm:h-12 sm:w-32 rounded-lg text-white text-medium mt-2"
          >
            Approve
          </button>
        </div>
      </section>
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
      <section class="flex flex-row space-y-5 flex-wrap md:space-x-5">
        <div
          class="bg-white h-82 w-full mt-10 rounded-lg p-6 flex flex-col shadow-[0_4px_10px_rgba(0,0,0,0.15)] text-left"
        >
          <h1 class="text-semibold text-lg">Personal Detail</h1>
          <ul class="flex flex-col grid-row-2 divide-y text-[#383838] mt-2">
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-account</v-icon>
              <p><b> Name: </b>{{ driver?.name }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-account</v-icon>
              <p><b> Preffered Name: </b>{{ driver?.preferred_name }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-email</v-icon>
              <p><b> Email: </b>{{ driver?.email }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-phone</v-icon>
              <p><b> Phone: </b>{{ driver?.phone }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-account</v-icon>
              <p><b> Age: </b>{{ state.age }} {{ props.driver?.dob ? "Years" : "" }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-account</v-icon>
              <p><b> Date of Birth: </b>{{ driver?.dob }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-map-marker</v-icon>
              <p><b> Resident: </b>{{ driver?.resident }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-map-marker</v-icon>
              <p><b> Streat Address: </b>{{ driver?.street_address }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-start mt-2">
              <v-icon>mdi-account</v-icon>
              <p><b> Description: </b>{{ driver?.description }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center">
              <v-icon>mdi-account</v-icon>
              <p class="mt-2">
                <b> Push Token: </b>{{ driver.push_token ? driver.push_token : "Null" }}
              </p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-earth</v-icon>
              <p><b> Lattitude: </b>{{ driver.lat ?? "Null" }}</p>
            </li>
            <li class="flex space-x-4 flex-row items-center h-12">
              <v-icon>mdi-earth</v-icon>
              <p><b> Longitude: </b>{{ driver.lng ?? "Null" }}</p>
            </li>
          </ul>
        </div>
      </section>
      <div
        class="bg-white h-82 w-full mt-10 rounded-lg p-6 flex flex-col shadow-[0_4px_10px_rgba(0,0,0,0.15)]"
      >
        <h1 class="text-semibold text-lg">Car Detail</h1>
        <ul class="flex flex-col grid-row-2 divide-y text-[#383838] mt-2">
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-car</v-icon>
            <p><b> Vehicle Type: </b>{{ driver?.vehicle?.title }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-car</v-icon>
            <p><b> Car Company: </b>{{ driver.car_company }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-car</v-icon>
            <p><b> Vehicle No: </b>{{ driver?.vehicle_nr }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-car</v-icon>
            <p><b> Vehicle Model: </b>{{ driver?.car_model }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-car</v-icon>
            <p><b> Vehicle Color: </b>{{ driver?.car_color }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-account</v-icon>
            <p><b> Driving Licence: </b>{{ driver?.license }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-account</v-icon>
            <p><b> With Pets: </b>{{ driver?.with_pets ? "Yes" : "No" }}</p>
          </li>

          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-account</v-icon>
            <p><b> With Chair: </b>{{ driver?.chair ? "Yes" : "No" }}</p>
          </li>

          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-account</v-icon>
            <p><b> With Dog: </b>{{ driver?.dog ? "Yes" : "No" }}</p>
          </li>
          <li class="flex space-x-4 flex-row items-center h-12">
            <v-icon>mdi-account</v-icon>
            <p><b> Free rides: </b>{{ driver?.free_rides }}</p>
          </li>
        </ul>
      </div>
    </main>
  </BaseLayout>
</template>
