<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";

const state = reactive({
  comments: [
    {
      name: "Oliver Sultzer",
      avatar: "https://randomuser.me/api/portraits/men/1.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam repellendus.`,
    },
    {
      name: "Nathan Montgomery",
      avatar: "https://randomuser.me/api/portraits/men/2.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit.`,
    },
    {
      name: "Wesley Mills",
      avatar: "https://randomuser.me/api/portraits/men/3.jpg",
      comment: `Lorem ipsum dolor.`,
    },
    {
      name: " Mattie Ford",
      avatar: "https://randomuser.me/api/portraits/men/4.jpg",
      comment: `Lorem ipsum dolor. sit amet consectetur`,
    },
    {
      name: "Brooklyn Curtis",
      avatar: "https://randomuser.me/api/portraits/men/5.jpg",
      comment: `Lorem ipsum`,
    },
    {
      name: "Joann Gonzalez",
      avatar: "https://randomuser.me/api/portraits/men/6.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum natus libero
            facilis velit recusandae iure voluptatum aliquam`,
    },

    {
      name: "Eli Adams",
      avatar: "https://randomuser.me/api/portraits/men/7.jpg",
      comment: `Lorem ipsum dolor, sit amet consectetur fasa.`,
    },
  ],
});
</script>

<template>
  <Head title="Reports" />
  <BaseLayout isBack title="Story Details">
    <section class="sm:flex">
      <div class="flex-1 mx-1 my-2 px-2 py-3 rounded">
        <v-img
          :src="`https://picsum.photos/500/300?image=${4 * 5 + 10}`"
          :lazy-src="`https://picsum.photos/10/6?image=${2 * 5 + 10}`"
        ></v-img>
      </div>

      <div>
        <!-- post views  -->
        <div
          class="m-1 p-3 rounded border sm:w-60 overflow-auto"
          style="height: calc(100vh - 90px)"
        >
          <p class="font-bold mb-2">Views list</p>
          <div class="flex mb-2" v-for="user in state.comments" :key="user.name">
            <div class="flex items-center pb-1 border-b w-full">
              <v-avatar size="30px">
                <v-img alt="Avatar" :src="user.avatar"></v-img>
              </v-avatar>
              <p class="ml-2 font-bold text-xs">{{ user.name }}</p>
            </div>
          </div>
        </div>
      </div>

      <div>
        <!-- post commnets  -->
        <div
          class="m-1 p-3 rounded border sm:w-80 overflow-auto"
          style="max-height: calc(100vh - 90px)"
        >
          <p class="font-bold mb-2 pb-2 border-b">Replies</p>
          <div class="flex mb-2" v-for="user in state.comments" :key="user.name">
            <div class="mr-2 mt-1">
              <v-avatar size="36px">
                <v-img alt="Avatar" :src="user.avatar"></v-img>
              </v-avatar>
            </div>
            <div class="bg-slate-200 p-3 rounded-lg">
              <p class="font-bold text-sm">{{ user.name }}</p>
              <p class="text-sm">{{ user.comment }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </BaseLayout>
</template>
