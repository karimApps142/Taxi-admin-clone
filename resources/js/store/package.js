import { useForm } from "@inertiajs/inertia-vue3"
import {defineStore} from "pinia"

export const usePackage = defineStore('package', {
    state: () => {
        return{
            dialog: false,
            isEdit: false,
            form: useForm({
                id: '',
                title: '',
                rides: '',
                price: '',
                city_id: '',

            })
        }
    }
})