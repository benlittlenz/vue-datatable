<template>
  <div
    class="fixed bottom-0 inset-x-0 pt-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
  >
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    <div
      class="bg-white rounded-lg pt-5 shadow-xl transform transition-all max-w-2xl"
    >
      <template v-for="(_, searchIndex) in search">
        <div :key="searchIndex" class="flex items-center px-6">
          <div class="relative mb-4">
            <label class="block">
              <label for="email" class="text-sm leading-7 text-gray-600"
                >Filter By</label
              >
              <select
                v-model="search[searchIndex].column"
                class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-lg focus:border-gray-500 focus:bg-white focus:ring-0 focus:outline-none"
              >
                <option
                  v-for="(column, index) in columns"
                  :key="index"
                  :value="column"
                >
                  {{ column.charAt(0).toUpperCase() + column.slice(1) }}
                </option>
              </select>
            </label>
          </div>
          <div
            v-if="search[searchIndex].column !== 'date'"
            class="relative mb-4 px-4"
          >
            <label class="block">
              <label for="operator" class="text-sm leading-7 text-gray-600"
                >Operator</label
              >
              <select
                v-model="search[searchIndex].operator"
                class="block w-full px-4 py-2 bg-white border border-gray-200 rounded-lg focus:border-gray-500 focus:bg-white focus:ring-0 focus:outline-none"
              >
                <option value="equals">Equals</option>
                <option value="contains">Contains</option>
                <option value="does not contain">Does Not Contain</option>
                <option value="is not blank">Not Blank</option>
                <option value="is blank">Is Blank</option>
              </select>
            </label>
          </div>
          <div v-else class="relative mb-4 px-4">
            <label class="block">
              <label for="operator" class="text-sm leading-7 text-gray-600"
                >From</label
              >
              <div class="block w-full py-1 border-transparent rounded-lg">
                <date-picker
                  v-model="search[searchIndex].fromDate"
                  type="date"
                  format="DD/MM/YYYY"
                ></date-picker>
              </div>
            </label>
          </div>
          <div
            v-if="search[searchIndex].column !== 'date'"
            class="relative mb-4"
          >
            <label class="block">
              <label for="email" class="text-sm leading-7 text-gray-600"
                >Value</label
              >
              <input
                v-model="search[searchIndex].value"
                placeholder="Search..."
                id="value"
                type="text"
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
              />
            </label>
          </div>
          <div v-else class="relative mb-4">
            <label class="block">
              <label for="operator" class="text-sm leading-7 text-gray-600"
                >To</label
              >
              <div class="block w-full py-1 border-transparent rounded-lg">
                <date-picker
                  v-model="search[searchIndex].toDate"
                  type="date"
                  format="DD/MM/YYYY"
                ></date-picker>
              </div>
            </label>
          </div>
          <div class="flex items-center mt-2 ml-2">
            <div v-if="searchIndex !== 0">
              <button
                @click="removeFilter(searchIndex)"
                class="mt-2 hover:bg-gray-200 rounded-full cursor-pointer"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </template>
        <button
          class="flex items-center mx-2 px-2 py-2 bg-gray-200 text-gray-700 text-sm shadow-md rounded-lg mt-2 hover:bg-gray-300 hover:text-gray-900 rounded-full focus:outline-none cursor-pointer"
          @click="createNewFilter"
        >
          <svg
            class="w-6 h-6 text-green-800"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            ></path>
          </svg>
          Add Filter
        </button>
      <div class="flex justify-end bg-gray-50 py-2 mt-5 px-4">
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
          <button
            v-on:click="closeModal"
            type="button"
            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5"
          >
            Cancel
          </button>
        </span>
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
          <button
            v-on:click="applyFilters"
            type="button"
            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none transition ease-in-out duration-150 sm:text-sm sm:leading-5"
          >
            Apply Filters
          </button>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
export default {
  data: () => ({
    search: [
      {
        fromDate: "",
        toDate: "",
        column: "date",
        operator: "",
        value: "",
      },
    ],
  }),
  components: {
    DatePicker,
  },

  props: ["columns"],

  methods: {
    // transformOperator(operator) {
    //   //const operator = event.target.value;
    //   console.log('op', operator);
    //   if (operator === "equals") return "=";
    //   else if (operator === "contains") return "LIKE";
    //   else if (operator === "does not contain") return "NOT LIKE";
    //   else return operator;
    // },
    closeModal() {
      this.$emit("close-modal");
    },
    applyFilters() {
      let filterArr = [];
      this.search.map((filter) => {
        filterArr.push({
          fromDate: filter.fromDate
            ? new Date(filter.fromDate).toISOString().substring(0, 10)
            : "",
          toDate: filter.toDate
            ? new Date(filter.toDate).toISOString().substring(0, 10)
            : "",
          column: filter.column,
          operatorVal: filter.operator,
          operator: filter.operator,
          value: filter.value,
        });
      });
      this.$emit("apply-filters", filterArr);
    },

    createNewFilter() {
      this.search.push({
        fromDate: "",
        toDate: "",
        column: "date",
        operator: "=",
        value: "",
      });
    },

    removeFilter(index) {
      this.search.splice(index, 1)
    }
  },
};
</script>