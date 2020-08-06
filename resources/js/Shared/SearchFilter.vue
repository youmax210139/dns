<template>
  <div class="flex items-center">
    <div class="flex w-full bg-white shadow rounded">
      <dropdown
        :auto-close="false"
        class="px-4 md:px-6 rounded-l border-r hover:bg-gray-100 focus:border-white focus:shadow-outline focus:z-10"
        placement="bottom-start"
      >
        <div class="flex items-baseline">
          <span class="text-gray-700 hidden md:inline">
            Filter
            <i class="fas fa-caret-down"></i>
          </span>
        </div>
        <div
          slot="dropdown"
          class="mt-2 px-4 py-6 w-screen shadow-xl bg-white rounded"
          :style="{ maxWidth: `${maxWidth}px` }"
        >
          <slot />
        </div>
      </dropdown>
      <input
        class="relative w-full px-6 py-3 rounded-r focus:shadow-outline"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Search…"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
    </div>
    <button
      class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500"
      type="button"
      @click="$emit('reset')"
    >Reset</button>
  </div>
</template>

<script>
import Dropdown from "@/Shared/Dropdown";

export default {
  components: {
    Dropdown,
  },
  props: {
    value: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
};
</script>
