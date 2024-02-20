<script setup>
import BreezeNavLink from "@/Components/NavLink.vue";
import { useStore } from "@/store";
import { ref, onMounted } from "vue";

const state = useStore();

const props = defineProps({
  title: String,
  isBack: {
    type: Boolean,
    default: false,
  },
});

function back() {
  window.history.back();
}
const drawer = ref(true);
</script>

<template>
  <v-app>
    <v-layout>
      <span class="md:w-0 overflow-hidden">
        <v-navigation-drawer
          v-model="drawer"
          :rail="state.rail"
          permanent
          color="#1D1C1C"
        >
          <div class="py-2 px-4 text-white">
            <v-btn
              variant="text"
              :icon="`mdi-chevron-${state.rail ? 'right' : 'left'}`"
              @click.stop="state.rail = !state.rail"
              class="ml-auto"
            ></v-btn>
          </div>

          <div
            v-if="!state.rail"
            class="flex items-center justify-center h-16 px-2 py-16 fill-current"
          >
            <img src="../../../public/full.png" alt="logo" />
          </div>
          <div
            v-else
            class="h-20 flex items-center justify-center px-2 py-16 fill-current"
          >
            <img src="../../../public/half.png" alt="logo" />
          </div>

          <v-divider></v-divider>
          <div class="p-2 mb-16">
            <BreezeNavLink
              v-for="item in state.items"
              :key="item.title"
              :href="route(item.route)"
              :active="route().current(item.route) || route().current(`${item.route}.*`)"
            >
              <v-icon :icon="item.icon"></v-icon>
              <p v-if="!state.rail" class="ml-4 font-bold">{{ item.title }}</p>
            </BreezeNavLink>
          </div>
          <div class="p-2 absolute bottom-0 w-full" style="background: #1d1c1c">
            <BreezeNavLink
              class="bg-[#FF0000] hover:bg-[#EB0000]"
              key="logout"
              :href="route('logout')"
              method="post"
              as="button"
            >
              <v-icon icon="mdi-logout"></v-icon>
              <p v-if="!state.rail" class="ml-2 font-bold">Logout</p>
            </BreezeNavLink>
          </div>
        </v-navigation-drawer>
      </span>
      <!-- mobile drawer -->
      <!--  -->
      <v-app-bar color="#1d1c1c" class="text-white">
        <v-btn
          v-if="props.isBack"
          @click="back"
          variant="text"
          icon="mdi-arrow-left"
        ></v-btn>

        <v-app-bar-title style="text-transform: capitalize; font-weight: bold">{{
          props.title ?? route().current()
        }}</v-app-bar-title>

        <v-spacer></v-spacer>

        <div class="flex items-center">
          <v-btn class="text-none" stacked>
            <v-badge content="0" color="error">
              <v-icon>mdi-bell-outline</v-icon>
            </v-badge>
          </v-btn>
          <div class="mx-5 h-10 bg-white" style="width: 1px" />
          <v-btn icon>
            <v-avatar color="brown">
              <img :src="$page.props.auth.user.avatar" />
            </v-avatar>
          </v-btn>
        </div>
      </v-app-bar>
      <v-main class="bg-white h-screen overflow-auto">
        <div class="max-w-5xl mx-auto bg-white pt-2">
          <slot />
        </div>
      </v-main>
    </v-layout>
  </v-app>
</template>
