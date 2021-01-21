<template>
  <div class="flex items-center py-4 w-64">
    <div class="flex items-center">
      <a
        @click.prevent="changePage(meta.current_page - 1)"
        href="#"
        class="mr-4 px-2 py-2 inline-flex items-center text-sm leading-5 font-medium hover:text-gray-800 hover:bg-gray-100 rounded-lg text-gray-500 focus:outline-none transition ease-in-out duration-150"
      >
        <svg
          class="mr-3 h-5 w-5 text-gray-400"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
            clip-rule="evenodd"
          />
        </svg>
        Previous
      </a>
    </div>
    <ul class="flex pl-0 list-none rounded">
      <li v-for="page in meta.last_page" :key="page">
        <a
          @click.prevent="changePage(page)"
          href="#"
          class="px-3 py-2 text-center inline-flex items-center text-sm leading-5 font-medium hover:text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none transition ease-in-out duration-150"
          :class="{ 'bg-indigo-500 text-white': meta.current_page === page }"
        >
          {{ page }}
        </a>
      </li>
    </ul>
    <div class="flex justify-end">
      <a
        @click.prevent="changePage(meta.current_page + 1)"
        href="#"
        class="ml-4 px-2 py-2 inline-flex items-center text-sm leading-5 font-medium hover:text-gray-800 hover:bg-gray-100 rounded-lg text-gray-500 focus:outline-none transition ease-in-out duration-150"
      >
        Next
        <svg
          class="ml-3 h-5 w-5 text-gray-400"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fill-rule="evenodd"
            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
            clip-rule="evenodd"
          />
        </svg>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["meta"],

  methods: {
    changePage(page) {
      this.$emit("page-change", page);
    },
  },
};
</script>