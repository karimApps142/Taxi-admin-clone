<script setup>
import { useDriver } from "@/store/driver";
import BaseInput from "@/Components/Input.vue";
import BaseButton from "@/Components/Button.vue";
import BaseSelect from "@/Components/Select.vue";
import Checkbox from "../Checkbox.vue";
import Label from "../Label.vue";
import {computed, onMounted, ref} from 'vue';
import moment from "moment";

const store = useDriver();
const props = defineProps({
  vehicles: Array,
  cities: Array,
  // dob_moment: String
});
const onSubmit = () => {
  store.form.post(route("drivers.store"), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
      store.isEdit = false;
    },
  });
};
const onUpdate = () => {
  store.form.put(route("drivers.update", { driver: store.form.id }), {
    preserveScroll: true,
    onSuccess: () => {
      store.form.reset();
      store.dialog = false;
      store.isEdit = false;
    },
  });
};
const vehicles = computed(() => props.vehicles.filter((i) => i?.city_id == store.form.city_id));
// const onDobChange = () => {
// document.getElementById('dob').removeAttribute('value')
// }
const onUpdateDob = (value) => {
  store.form.old_dob = '';
  store.form.dob = value
}

const maxDate = ref();

onMounted(() => {
  const today = new Date();
  const maxDOB = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate() + 1);
  const yyyy = maxDOB.getFullYear();
  let mm = maxDOB.getMonth() + 1;
  let dd = maxDOB.getDate();
  if (mm < 10) {
    mm = `0${mm}`;
  }
  if (dd < 10) {
    dd = `0${dd}`;
  }
  maxDate.value = `${yyyy}-${mm}-${dd}`;
})
</script>

<template>
  <v-dialog v-model="store.dialog" persistent max-width="560">
    <!-- <div class="flex justify-center items-center"> -->
    <v-card class="">
      <v-card-title>{{ store.isEdit ? "Edit" : "Add" }} Driver</v-card-title>
      <form @submit.prevent="store.isEdit ? onUpdate() : onSubmit()">
        <v-container class="flex flex-col justify-center space-y-3 pt-2 pl-2">
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Name" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Full Name"
                v-model="store.form.name"
              />
              <p v-if="store.form.errors.name" class="text-xs mx-1 mt-1 text-red-500">
                {{ store.form.errors.name }}
              </p>
            </div>
            <div class="flex flex-col">
              <Label value="Prefered Name" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Prefered Name"
                v-model="store.form.preferred_name"
              />
              <p
                v-if="store.form.errors.preferred_name"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.preferred_name }}
              </p>
            </div>
          </div>
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Email" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Email"
                type="email"
                autocomplete="username"
                v-model="store.form.email"
              />
              <p v-if="store.form.errors.email" class="text-xs mx-1 mt-1 text-red-500">
                {{ store.form.errors.email }}
              </p>
            </div>
            <div class="flex flex-col">
              <Label value="Phone" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Phone"
                type="tel"
                autocomplete="phone"
                v-model="store.form.phone"
              />
              <p v-if="store.form.errors.phone" class="text-xs mx-1 mt-1 text-red-500">
                {{ store.form.errors.phone }}
              </p>
            </div>
          </div>
          <!--  -->
          <div v-if="!store.isEdit" class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Password" />
              <div class="flex items-center relative">
                <BaseInput
                  class="px-2 py-2 w-52"
                  placeholder="Password"
                  :type="store.showPassword ? 'text' : 'password'"
                  v-model="store.form.password"
                />
                <button
                  @click="store.showPassword = !store.showPassword"
                  class="absolute right-2"
                >
                  <v-icon
                    color="grey-darken-1"
                    :icon="store.showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                  />
                </button>
              </div>
              <p
                v-if="store.form.errors.password"
                class="text-xs mx-1 mt-1 text-red-500 w-52"
              >
                {{ store.form.errors.password }}
              </p>
            </div>
            <!--  -->
            <div class="flex flex-col">
              <Label value="Confirm Password" />
              <div class="flex items-center relative">
                <BaseInput
                  class="px-2 py-2 w-52"
                  placeholder="Confirm Password"
                  :type="store.showPassword ? 'text' : 'password'"
                  v-model="store.form.password_confirmation"
                />
                <button
                  @click="store.showPassword = !store.showPassword"
                  class="absolute right-2"
                >
                  <v-icon
                    color="grey-darken-1"
                    :icon="store.showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                  />
                </button>
                <p
                  v-if="store.form.errors.password_confirmation"
                  class="text-xs mx-1 mt-1 text-red-500"
                >
                  {{ store.form.errors.password_confirmation }}
                </p>
              </div>
            </div>
          </div>
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Date of Birth" />
              <BaseInput class="px-2 py-2 w-52" type="date" id="dob" v-model="store.form.dob" :max="maxDate" />
              <!-- {{ store.form.dob }} -->
              <p v-if="store.form.errors.dob" class="text-xs mx-1 mt-1 text-red-500">
                {{ store.form.errors.dob }}
              </p>
            </div>
            <div class="flex flex-col">
              <Label value="Resident" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Resident"
                v-model="store.form.resident"
              />
              <p v-if="store.form.errors.resident" class="text-xs mx-1 mt-1 text-red-500">
                {{ store.form.errors.resident }}
              </p>
            </div>
          </div>
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Streat Address" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Streat Address"
                v-model="store.form.street_address"
              />
              <p
                v-if="store.form.errors.street_address"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.street_address }}
              </p>
            </div>
            <div class="flex flex-col">
              <Label value="Select City" />
              <BaseSelect v-model="store.form.city_id" class="px-2 py-2 w-52">
                <option v-for="city in props.cities" :key="city.id" :value="city.id">
                  {{ city.name }}
                </option>
              </BaseSelect>
              <p v-if="store.form.errors.city_id" class="text-xs mx-1 mt-1 text-red-500">
                {{ store.form.errors.city_id }}
              </p>
            </div>
          </div>
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Select Vehicle" />
              <BaseSelect v-model="store.form.vehicle_id" class="px-2 py-2 w-52">
                <option
                  v-for="vehicle in vehicles"
                  :key="vehicle.id"
                  :value="vehicle.id"
                >
                  {{ vehicle.title }}
                </option>
              </BaseSelect>
              <p
                v-if="store.form.errors.vehicle_id"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.vehicle_id }}
              </p>
            </div>
            <div class="flex flex-col">
              <Label value="Car Company" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Car Company"
                v-model="store.form.car_company"
              />
              <p
                v-if="store.form.errors.car_company"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.car_company }}
              </p>
            </div>
          </div>
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Car Model" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Car Model"
                v-model="store.form.car_model"
              />
              <p
                v-if="store.form.errors.car_model"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.car_model }}
              </p>
            </div>
            <div class="flex flex-col">
              <Label value="Car Color" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Car Color"
                v-model="store.form.car_color"
              />
              <p
                v-if="store.form.errors.car_color"
                class="text-xs mx-1 mt-1 text-red-500"
              >
                {{ store.form.errors.car_color }}
              </p>
            </div>
          </div>
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <div class="flex flex-col ml-3">
              <Label value="Vehicle No" />
              <BaseInput
                class="px-2 py-2 w-52"
                placeholder="Vehicle No"
                v-model="store.form.vehicle_nr"
              />
            </div>
            <Label class="flex items-center px-2 py-2 w-52 bg-gray-200 rounded-mds">
              <Checkbox v-model="store.form.with_chair" />
              Wheel Chair Accessible
            </Label>
          </div>
          <!--  -->
          <div class="flex flex-row flex-wrap space-x-3">
            <Label class="flex items-center px-2 py-2 w-52 bg-gray-200 rounded-md ml-3">
              <Checkbox v-model="store.form.with_dog" />
              Allow Guide Dogs
            </Label>
            <Label class="flex items-center px-2 py-2 w-52 bg-gray-200 rounded-md">
              <Checkbox v-model="store.form.with_pets" />
              Allow Pets
            </Label>
          </div>
          <div class="flex items-center justify-end mt-6">
            <div class="flex items-center px-2">
              <BaseButton
                @click.prevent="store.dialog = false"
                type="button"
                secondary
                class="w-full flex items-center justify-center mr-3"
                :class="{ 'opacity-25': store.form.processing }"
                :disabled="store.form.processing"
              >
                Cancel
              </BaseButton>
              <BaseButton
                class="w-full flex items-center justify-center"
                :class="{ 'opacity-25': store.form.processing }"
                :disabled="store.form.processing"
              >
                {{ store.isEdit ? "Update" : "Submit" }}
              </BaseButton>
            </div>
          </div>
        </v-container>
      </form>
    </v-card>
    <!-- </div> -->
  </v-dialog>
</template>
