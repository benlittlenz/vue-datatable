<template>
  <div class="relative md:w-1/3">
    <input
      type="search"
      v-model="value"
      class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
      placeholder="Search..."
    />
    <div class="absolute top-0 left-0 inline-flex items-center p-2">
      <icon name="search" />
    </div>
  </div>
</template>
<script>
import debounce from '../lib/debounce';
import Icon from "./Icon";
export default {
  components: {
      Icon
  },

  data: () => ({
    value: ''
  }),

  watch: {
    value: debounce(function (search) {
        this.$emit("search-change", search);
    }, 500)

  }
};
</script>
