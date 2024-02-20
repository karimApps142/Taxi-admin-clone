import { defineStore } from "pinia";

export const useStore = defineStore("main", {
    state: () => {
        return {
            // drawer: true,
            collapsed: false,
            items: [
                {
                    title: "Dashboard",
                    icon: "mdi-view-dashboard",
                    route: "dashboard",
                },
                {
                    title: "Drivers",
                    icon: "mdi-account-multiple",
                    route: "drivers",
                },
                {
                    title: "Riders",
                    icon: "mdi-account",
                    route: "riders",
                },
                {
                    title: "Packages",
                    icon: "mdi-package-variant-closed",
                    route: "packages",
                },
                {
                    title: "Countries",
                    icon: "mdi-flag",
                    route: "countries",
                },
                {
                    title: "Bookings",
                    icon: "mdi-taxi",
                    route: "bookings",
                },
                // {
                //     title: "Reports",
                //     icon: "mdi-chart-line",
                //     route: "reports",
                // },
            ],
            rail: window.innerWidth > 768 ? false : true,
        };
    },
});
