<script setup>
import { useCities } from "@/store/city";
import { GoogleMap, Polygon } from "vue3-google-map";
const emit = defineEmits(["onMapClicked"]);
const GOOGLE_API_KEY = "AIzaSyDzSKURg3HghZ-Jv_FfoXWVlMoGVDAvuBU";

const store = useCities();

const onClickMap = (e) => {
  if (store.editMap) {
    store.$patch({
      form: {
        ...store.form,
        coords: [...store.form.coords, { lat: e.latLng.lat(), lng: e.latLng.lng() }],
      },
    });
  }
};
</script>

<template>
  <GoogleMap
    @click="onClickMap"
    :api-key="GOOGLE_API_KEY"
    style="width: 100%; height: 500px"
    :center="store.center"
    :zoom="10"
    draggable-cursor="pointer"
  >
    <Polygon
      :options="{
        paths: store.form.coords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
      }"
    />
  </GoogleMap>
</template>
