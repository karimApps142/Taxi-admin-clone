import { useForm } from "@inertiajs/inertia-vue3";
import { defineStore } from "pinia";

export const useVehicles = defineStore("vehicles", {
    state: () => {
        return {
            dialog: false,
            isEdit: false,
            fileName: "",
            form: useForm({
                id: "",
                title: "",
                image: "",
                seats: "",
                city_id: "",
            }),
        };
    },
});
