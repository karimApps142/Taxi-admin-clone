import { useForm } from "@inertiajs/inertia-vue3";
import { defineStore } from "pinia";

export const useCities = defineStore("cities", {
    state: () => {
        return {
            dialog: false,
            isEdit: false,
            editMap: false,
            form: useForm({
                id: "",
                name: "",
                zipcode: "",
                currency: "gbp",
                unit: "mi",
                country_id: "",
                radius: "",
                coords: [],
            }),
            center: { lat: 57.477772, lng: -4.224721 },
        };
    },
});
