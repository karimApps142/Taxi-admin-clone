<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";

const state = reactive({
  users: [
    {
      name: "Diana James",
      avatar: "https://randomuser.me/api/portraits/men/10.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`,
      isFriend: false,
    },
    {
      name: "Sandra Bradley",
      avatar: "https://randomuser.me/api/portraits/men/11.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`,
      isFriend: false,
    },
    {
      name: "Adam Bennett",
      avatar: "https://randomuser.me/api/portraits/men/12.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`,
      isFriend: false,
    },
    {
      name: "Doris Simpson",
      avatar: "https://randomuser.me/api/portraits/men/13.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`,
      isFriend: false,
    },
    {
      name: "Oliver Sultzer",
      avatar: "https://randomuser.me/api/portraits/men/1.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`,
      isFriend: false,
    },
    {
      name: "Nathan Montgomery",
      avatar: "https://randomuser.me/api/portraits/men/2.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit.`,
      isFriend: true,
    },
    {
      name: "Wesley Mills",
      avatar: "https://randomuser.me/api/portraits/men/3.jpg",
      comment: `Lorem ipsum dolor.`,
      isFriend: false,
    },
    {
      name: " Mattie Ford",
      avatar: "https://randomuser.me/api/portraits/men/4.jpg",
      comment: `Lorem ipsum dolor. sit amet consectetur`,
      isFriend: true,
    },
    {
      name: "Brooklyn Curtis",
      avatar: "https://randomuser.me/api/portraits/men/5.jpg",
      comment: `Lorem ipsum`,
      isFriend: false,
    },
    {
      name: "Joann Gonzalez",
      avatar: "https://randomuser.me/api/portraits/men/6.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam`,
      isFriend: true,
    },

    {
      name: "Eli Adams",
      avatar: "https://randomuser.me/api/portraits/men/7.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur fasa.`,
      isFriend: false,
    },
  ],
});
</script>

<template>
  <Head title="Categories" />
  <BaseLayout title="Categories">
   <section class="flex flex-col items-center overflow-auto h-[90vh]">
                <div class="w-full p-5 pr-14 flex items-center justify-end">
                    <button class="w-10 h-10 rounded-full flex items-center justify-center bg-[#23DF00]">
                        <img src="\icons\add.svg" alt="">
                    </button>
                </div>
                <table class="bg-white shadow-xl mt-6">
                    <thead>
                        <tr class="bg-[#1D1C1C] text-white">
                            <th class="p-2 pr-16 pl-5 font-medium font[arial] text-lg text-left w-72">
                                Title
                            </th>
                            <th class="p-2 pr-16 pl-5 font-medium font[arial] text-lg text-left w-72">
                                Minimum Price
                            </th>
                            <th class="p-2 pr-16 pl-5 font-medium font[arial] text-lg text-left w-72">
                                Maximum Price
                            </th>
                            <th class="p-2 pr-16 pl-5 font-medium font[arial] text-lg text-left w-72">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white cursor-pointer hover:bg-[#F9F9FB]">
                            <td class="p-2 pl-5 font-normal font[arial] text-lg text-left border-b-2">
                                Economy
                            </td>
                            <td class="p-2 pl-5 font-normal font[arial] text-lg text-left border-b-2">
                                ₺ 100
                            </td>
                            <td class="p-2 pl-5 font-normal font[arial] text-lg text-left border-b-2">
                                ₺ 150
                            </td>
                            <td class="p-2 pl-5 border-b-2">
                                <div class="bg-[#F3F4F8] w-10 h-10 rounded-full flex items-center justify-center">
                                    <img src="\icons\more.svg"  class="w-5"
                                    alt="">
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-white cursor-pointer hover:bg-[#F9F9FB]">
                            <td class="p-2 pl-5 font-normal font[arial] text-lg text-left border-b-2">
                                Luxurious
                            </td>
                            <td class="p-2 pl-5 font-normal font[arial] text-lg text-left border-b-2">
                                ₺ 170
                            </td>
                            <td class="p-2 pl-5 font-normal font[arial] text-lg text-left border-b-2">
                                ₺ 200
                            </td>
                            <td class="p-2 pl-5 border-b-2">
                                <div class="bg-[#F3F4F8] w-10 h-10 rounded-full flex items-center justify-center">
                                    <img src="\icons\more.svg"  class="w-5"
                                    alt="">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
               
            </section>
  </BaseLayout>
</template>
