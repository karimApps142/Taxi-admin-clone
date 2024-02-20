<script setup>
import BaseLayout from "@/Layouts/Authenticated.vue";
import BaseInput from "@/Components/Input.vue";
import BaseLabel from "@/Components/Label.vue";
import BaseButton from "@/Components/Button.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Actions from "@/Components/Actions.vue";
import Table from "@/Components/Table.vue";
import AddCategory from "@/Components/categories/AddCategory.vue";
import { useCategories } from "@/store/category";
import { useAlerts } from "@/hooks/useAlerts";
import { computed } from "vue";
import { reactive } from "vue";
import Pagination from "@/Components/Pagination.vue";

const state = reactive({
  dailog: false,
});
const store = useCategories();

const { alert } = useAlerts();

defineProps({
  categories: Object,
});
const onStatusChange = (id) => {
  alert(null, "this action will change category status", null, "Yes , do it!").then(
    ({ isConfirmed }) =>
      isConfirmed
        ? store.form.put(route("categories.status", { category: id }), {
            preserveScroll: true,
            onSuccess: () => {},
          })
        : null
  );
};

const renderStatusColor = computed((status) =>
  status === "active" ? "text-green-400" : "text-red-400"
);
const onDelete = (id) => {
  alert(
    null,
    "this action will delete category",
    null,
    "Yes , do it!"
  ).then(({ isConfirmed }) =>
    isConfirmed ? store.form.delete(route("categories.delete", { id: id })) : null
  );
};
const onUpdate = () => {
  store.form.post(route("categories.update", { id: store.form.id }), {
    onSuccess: () => {
      store.form.reset();
      state.dialog = false;
    },
    onFinish: () => {
      store.form.reset();
    },
  });
};
</script>

<template>
  <Head title="Categories" />

  <BaseLayout>
    <v-btn
      @click="
        () => {
          //state.mode = 'add';
          store.form.reset();
          store.form.clearErrors();
          store.dialog = true;
        }
      "
      color="#23df00"
      icon="mdi-plus"
      class="ml-auto mr-2 text-white"
    ></v-btn>
    <div class="mt-3">
      <Table class="border rounded">
        <thead class="bg-[#2e2c2b] text-white">
          <tr>
            <th class="text-left">Title</th>
            <th class="text-left">Minimum Price</th>
            <th class="text-left">Maximum Price</th>
            <th class="text-left">Status</th>
            <th class="text-right w-20">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in categories.data" :key="item.id" class="cursor-pointer">
            <td>
              {{ item.title }}
            </td>
            <td>
              {{ item.min_price }}
            </td>
            <td>
              {{ item.max_price }}
            </td>
            <td>
              <span
                :class="[
                  'text-white px-2 rounded font-serif',
                  item.status === 'active' ? 'bg-green-700' : 'bg-red-700',
                ]"
              >
                {{ item.status }}</span
              >
            </td>
            <td class="flex flex-row">
              <Actions
                :isEdit="true"
                @click="
                  () => {
                    store.form.id = item?.id;
                    store.form.title = item?.title;
                    store.form.min_price = item?.min_price;
                    store.form.max_price = item?.max_price;
                    state.dialog = true;
                  }
                "
              />
              <Actions :isStatus="item.status" @on-status="onStatusChange(item.id)" />
              <Actions :isDelete="true" @on-delete="onDelete(item.id)" />
            </td>
          </tr>
        </tbody>
      </Table>
      <Pagination :links="categories.links" />
      <AddCategory />
    </div>
    <template>
      <v-dialog v-model="state.dialog">
        <v-card class="w-80">
          <v-card-title>
            <span class="text-h6">Edit Category</span>
          </v-card-title>

          <v-container>
            <form>
              <div>
                <BaseLabel for="title" value="Title" />
                <BaseInput
                  id="title"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="store.form.title"
                  autofocus
                  placeholder="Category title"
                />
                <p v-if="store.form.errors.title" class="text-xs mx-1 mt-1 text-red-500">
                  {{ store.form.errors.title }}
                </p>
              </div>
              <div class="flex justify-between">
                <div>
                  <BaseInput
                    class="mt-2 py-2 px-2 w-[140px]"
                    type="text"
                    v-model="store.form.min_price"
                    placeholder="Min Price"
                  />
                  <p
                    v-if="store.form.errors.min_price"
                    class="text-xs mx-1 mt-1 text-red-500"
                  >
                    {{ store.form.errors.min_price }}
                  </p>
                </div>
                <!-- <p v-if="store.form.errors.min_price" class="text-xs mx-1 mt-1 text-red-500">
              {{ store.form.errors.min_price }}
            </p> -->
                <div>
                  <BaseInput
                    class="mt-2 py-2 px-2 w-[140px]"
                    type="text"
                    v-model="store.form.max_price"
                    placeholder="Max Price"
                  />
                  <p
                    v-if="store.form.errors.max_price"
                    class="text-xs mx-1 mt-1 text-red-500"
                  >
                    {{ store.form.errors.max_price }}
                  </p>
                </div>
              </div>

              <div class="flex items-center justify-end mt-6">
                <BaseButton
                  @click="state.dialog = false"
                  type="button"
                  class="w-full flex items-center justify-center bg-white mr-3"
                  :class="{ 'opacity-25': store.form.processing }"
                  :disabled="store.form.processing"
                >
                  <p class="text-[#23df00]">Cancel</p>
                </BaseButton>
                <BaseButton
                  @click="onUpdate"
                  class="w-full flex items-center justify-center bg-[#23df00]"
                  :class="{ 'opacity-25': store.form.processing }"
                  :disabled="store.form.processing"
                >
                  Update
                </BaseButton>
              </div>
            </form>
          </v-container>
        </v-card>
      </v-dialog>
    </template>
  </BaseLayout>
</template>
