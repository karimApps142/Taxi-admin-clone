import { useForm } from "@inertiajs/inertia-vue3";
import { defineStore } from "pinia";

export const useCountries = defineStore("countries", {
    state: () => {
        return {
            dialog: false,
            isEdit: false,
            form: useForm({
                id: '',
                name: '',
                image: '',
            })
        };
    },
});