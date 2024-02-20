import { inject } from "vue";

export function useAlerts() {
    const swal = inject("$swal");

    const alert = (title, text, icon, confirmButtonText) => {
        return swal.fire({
            title: title ?? "Are you sure?",
            text: text ?? "You won't be able to revert this!",
            icon: icon ?? "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: confirmButtonText ?? "Yes, delete it!",
        });
    };

    return {
        alert,
    };
}
