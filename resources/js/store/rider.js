import { useForm } from '@inertiajs/inertia-vue3';
import {defineStore} from 'pinia';

export const useRider = defineStore('riders', {
    state: () => {
        return {
            dialog: false,
            isEdit: false,
            showPassword: false,
            form: useForm({
                id: '',
                name: '',
                email: '', 
                phone: '', 
                password: '',
                password_confirmation: '',
            })
        }
    }
})