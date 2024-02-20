import { useForm } from '@inertiajs/inertia-vue3';
import {defineStore} from 'pinia';

export const useDriver = defineStore('drivers', {
    state: () => {
        return {
            dialog: false,
            isEdit: false,
            showPassword: false,
            form: useForm({
                id: '',
                name: '',
                preferred_name: '',
                email: '', 
                phone: '', 
                password: '',
                password_confirmation: '',
                dob: '',
                resident: '',
                street_address: '',
                vehicle_id: '',
                city_id: '',
                car_company: '',
                car_model: '',
                car_color: '',
                vehicle_nr: '',
                with_chair: '',
                with_dog: '',
                with_pets: '',
            })
        }
    }
})