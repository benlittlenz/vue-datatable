<template>
  <div>
    <div v-if="meta.length === 0">Loading..</div>
    <div v-else class="flex items-center">
      <div class="flex items-center">
        <a
          @click.prevent="changePage(meta.current_page - 1)"
          href="#"
          class="mr-2 py-2 inline-flex items-center text-sm leading-5 font-medium rounded-lg text-gray-500 focus:outline-none transition ease-in-out duration-150"
          :class="
            meta.current_page === 1
              ? 'cursor-not-allowed'
              : 'hover:text-gray-800 hover:bg-gray-100'
          "
        >
          <svg
            class="mr-1 h-5 w-5 text-gray-400"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
              clip-rule="evenodd"
            />
          </svg>
          Prev
        </a>
      </div>
      <ul class="flex pl-0 list-none rounded">
        <template v-if="currentSection > 1">
          <a
            @click.prevent="changePage(1)"
            href="#"
            class="px-2 py-1 text-center inline-flex items-center text-sm leading-5 font-medium hover:text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none"
          >
            1
          </a>
          <a
            @click.prevent="navigateSection('prev')"
            class="px-2 py-1 text-center inline-flex items-center text-sm leading-5 font-medium rounded-lg focus:outline-none cursor-pointer"
          >
            ...
          </a>
        </template>
        <li v-for="page in pages" :key="page">
          <a
            @click.prevent="changePage(page)"
            href="#"
            class="px-2 py-1 text-center inline-flex items-center text-sm leading-5 font-medium hover:text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none"
            :class="{ 'bg-indigo-500 text-white': meta.current_page === page }"
          >
            {{ page }}
          </a>
        </li>
        <template v-if="currentSection < numberOfSections">
          <a
            @click.prevent="navigateSection('next')"
            class="px-2 py-1 text-center inline-flex items-center text-sm leading-5 font-medium rounded-lg focus:outline-none cursor-pointer"
          >
            ...
          </a>
          <a
            @click.prevent="changePage(meta.last_page)"
            href="#"
            class="px-2 py-1 text-center inline-flex items-center text-sm leading-5 font-medium hover:text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none"
          >
            {{ meta.last_page }}
          </a>
        </template>
      </ul>
      <div class="flex justify-end">
        <a
          @click.prevent="changePage(meta.current_page + 1)"
          href="#"
          class="ml-2 py-1 inline-flex items-center text-sm leading-5 font-medium rounded-lg text-gray-500 focus:outline-none"
          :class="
            meta.current_page === meta.last_page
              ? 'cursor-not-allowed'
              : 'hover:text-gray-800 hover:bg-gray-100'
          "
        >
          Next
          <svg
            class="ml-1 h-5 w-5 text-gray-400"
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
    <p>currentSection {{ currentSection }}</p>
    <p>current: {{ numberOfSections }}</p>
    <p>getLastPage: {{ getLastPage }}</p>
  </div>
</template>
<script>
export default {
  data: () => ({
    pagesPerSection: 4,
  }),

  props: ["meta"],

  computed: {
    currentSection() {
      //Work out which section user is currently on.
      // If we're on page
      return Math.ceil(this.meta.current_page / this.pagesPerSection);
    },

    numberOfSections() {
      // Divide # of pages by number of sections
      //Grab the last page and divide by # per section and round up
      return Math.ceil(this.meta.last_page / this.pagesPerSection);
    },

    getLastPage() {
      // Check if current section is equal to total count of sections
      // Set the last page from our meta data to the lastPage
      if (this.currentSection === this.numberOfSections) {
        return this.meta.last_page;
      }

      return (this.currentSection - 1) * this.numberOfSections + this.pagesPerSection;
    },

    pages() {
      const currentPage = (this.currentSection - 1) * this.pagesPerSection + 1;
      console.log('CURRENT SECTION: ', this.currentSection);
      return this.calcPageRange(currentPage, this.getLastPage + 1);
    },
  },

  methods: {
    changePage(page) {
      // Add out of bounds check
      if (page <= 0 || page > this.meta.last_page) {
        return;
      }
      this.$emit("page-change", page);
    },

    calcPageRange(start, end) {
      return new Array(end - start).fill().map((_, index) => index + start);
    },

    navigateSection(direction) {
      const value = direction === "next" ? +1 : -1;
      const section = this.currentSection + value;
      console.log('SECTION: ', section);
      const firstPageOfSection = (section - 1) * this.pagesPerSection + 1;

      this.changePage(firstPageOfSection);
    },
  },
};
</script>