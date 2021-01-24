<template>
  <div
    class="fixed bottom-0 inset-x-0 pt-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
  >
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    <div
      class="bg-white rounded-lg pt-5 shadow-xl transform transition-all max-w-2xl"
    >
      {{ search }}
      <div class="flex items-center px-6">
        <div class="relative mb-4">
          <label class="block">
            <label for="email" class="text-sm leading-7 text-gray-600"
              >Filter By</label
            >
            <select
              v-model="search.column"
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
        <div v-if="search.column !== 'date'" class="relative mb-4 px-4">
          <label class="block">
            <label for="operator" class="text-sm leading-7 text-gray-600"
              >Operator</label
            >
            <select
              @change="transformOperator"
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
                v-model="search.fromDate"
                type="date"
                format="DD/MM/YYYY"
              ></date-picker>
            </div>
          </label>
        </div>
        <div v-if="search.column !== 'date'" class="relative mb-4">
          <label class="block">
            <label for="email" class="text-sm leading-7 text-gray-600"
              >Value</label
            >
            <input
              v-model="search.value"
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
                v-model="search.toDate"
                type="date"
                format="DD/MM/YYYY"
              ></date-picker>
            </div>
          </label>
        </div>
      </div>

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
    search: {
      fromDate: "",
      toDate: "",
      column: "date",
      operator: "=",
      value: "",
    },
  }),
  components: {
    DatePicker,
  },

  props: ["columns"],

  methods: {
    transformOperator() {
      const operator = event.target.value;

      if (operator === "equals") this.search.operator = "=";
      else if (operator === "contains") this.search.operator = "LIKE";
      else if (operator === "does not contain")
        this.search.operator = "NOT LIKE";
      else this.search.operator = operator
    },
    closeModal() {
      this.$emit("close-modal");
    },
    applyFilters() {
      this.$emit("apply-filters", {
        fromDate: this.search.fromDate
          ? new Date(this.search.fromDate).toISOString().substring(0, 10)
          : "",
        toDate: this.search.toDate
          ? new Date(this.search.toDate).toISOString().substring(0, 10)
          : "",
        column: this.search.column,
        operator: this.search.operator,
        value: this.search.value,
      });
    },
  },
};
</script>