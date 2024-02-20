import { useForm } from "@inertiajs/inertia-vue3";
import { defineStore } from "pinia";

export const useCategories = defineStore("categories", {
    state: () => {
        return {
            dialog: false,
            mode:"add",
            form: useForm({
                id:"",
                title: "",
                min_price: "",
                max_price: "",
            }),
        };
    },
});

