<template>
  <div class="mx-auto mt-20 w-11/12">
    <div class="rounded-lg">
      <button
        v-on:click="openCreateTransactionModal = true"
        class="flex mr-2 focus:cursor-pointer focus:outline-none bg-purple-400 text-white py-2 px-4 rounded-lg font-bold"
      >
        <icon name="create" />
        <span class="ml-2">Create Transaction</span>
      </button>
    </div>
    <div class="flex items-center mt-4">
      <div class="flex flex-1 items-center pr-4">
        <search v-on:search-change="applySearch" />
        <div
          v-for="(filter, index) in appliedFilters"
          :key="index"
          class="flex items-center ml-4 bg-gray-100 px-4 py-1 text-sm rounded-lg hover:bg-gray-200 cursor-pointer"
        >
          <button @click="removeFilter(index)">
            <icon name="cross" />
          </button>
          <span class="flex items-center ml-1">
            <p class="font-semibold mr-1">{{ upperCaseFirstVal(filter.column) }}</p>
            <p>
              {{
                filter.column !== "date"
                  ? filter.operatorVal.concat(" ", filter.value)
                  : filter.fromDate.concat(" ", filter.toDate)
              }}
            </p>
          </span>
        </div>
      </div>
      <div class="flex items-center">
        <div v-if="selected.length" class="mx-4">
          <button
            @click.prevent="openConfirmDeleteModal = true"
            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg inline-flex items-center"
          >
            <icon name="trash" class="text-white" />
            <span class="pl-2">Delete</span>
          </button>
        </div>
        <button
          type="button"
          @click="openFilterModal = true"
          class="flex items-center text-gray-700 px-3 py-1 border font-medium rounded focus:outline-none"
        >
          <icon name="filter" />
          Filter
        </button>
        <div class="relative ml-4">
          <select
            v-model="limit"
            @change="fetchTransactions"
            class="appearance-none h-full rounded border block appearance-none w-full bg-white text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white"
          >
            <option>25</option>
            <option>50</option>
            <option>75</option>
          </select>
          <div
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
          >
            <icon name="dropdown" />
          </div>
        </div>
      </div>
    </div>
    <div>
      <div>
        <div v-if="loading">Loading...</div>
        <div
          v-else
          class="bg-white rounded-sm shadow mt-2 overflow-auto max-h-screen"
        >
          <table class="border-collapse w-full whitespace-no-wrap bg-white">
            <thead>
              <tr class="text-left h-6">
                <th
                  class="w-8 py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100"
                >
                  <label
                    class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer"
                  >
                    <input
                      type="checkbox"
                      class="form-checkbox focus:outline-none focus:shadow-outline"
                      @change="selectAllCheckboxes"
                    />
                  </label>
                </th>
                <th
                  v-for="(column, index) in columns"
                  :key="index"
                  class="w-40 bg-gray-100 sticky top-0 border-solid border border-gray-200 cursor-pointer px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
                  @click="sortColumn(column)"
                >
                  <template v-if="sort.column === column">
                    <div
                      class="flex items-center"
                      v-if="sort.direction === 'asc'"
                    >
                      <span class="mr-2">{{ column }}</span>
                      <span>
                        <icon name="arrow-down" />
                      </span>
                    </div>
                    <div
                      class="flex items-center"
                      v-if="sort.direction === 'desc'"
                    >
                      <span class="mr-2">{{ column }}</span>
                      <span>
                        <icon name="arrow-up" />
                      </span>
                    </div>
                  </template>

                  <template v-else
                    ><span>{{ column }}</span></template
                  >
                </th>
                <th
                  class="w-4 bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
                ></th>
              </tr>
            </thead>
            <tbody>
              <template>
                <tr
                  v-for="transaction in transactionList"
                  :key="transaction.id"
                  class="max-h-2 hover:bg-gray-50 cursor-pointer"
                >
                  <td class="border-dashed border-t border-gray-200 px-3">
                    <label
                      class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer"
                    >
                      <input
                        v-model="selected"
                        :value="transaction.id"
                        type="checkbox"
                        class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline"
                      />
                    </label>
                  </td>
                  <td class="border-solid border border-gray-200">
                    <span class="text-gray-700 px-6 py-1 flex items-center">{{
                      transaction.date
                    }}</span>
                  </td>
                  <td class="border-solid border border-gray-200">
                    <span class="text-gray-700 px-6 py-1 flex items-center">{{
                      transaction.category
                    }}</span>
                  </td>
                  <td class="border-solid border border-gray-200">
                    <span class="text-gray-700 px-6 py-1 flex items-center">{{
                      transaction.payee
                    }}</span>
                  </td>
                  <td class="border-solid border border-gray-200">
                    <span class="text-gray-700 px-6 py-1 flex items-center"
                      >${{ transaction.amount }}</span
                    >
                  </td>
                  <td class="border-solid border border-gray-200">
                    <span class="text-gray-700 px-6 py-1 flex items-center">{{
                      transaction.account
                    }}</span>
                  </td>
                  <td class="border-solid border border-gray-200">
                    <span class="text-gray-700 px-6 py-1 flex items-center">{{
                      transaction.notes
                    }}</span>
                  </td>
                  <td
                    v-on:click="updateTransaction(transaction)"
                    class="border-solid border border-gray-200"
                  >
                    <div class="flex flex-col justify-center items-center">
                      <span class="">
                        <icon name="details" />
                      </span>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <div class="flex justify-end">
          <Pagination
            :meta="this.transactions.meta"
            v-on:page-change="fetchTransactions"
          />
        </div>
      </div>
    </div>

    <div v-if="openCreateTransactionModal === true">
      <createTransactionModal v-on:close-modal="closeModal" />
    </div>

    <div v-if="openEditTransactionModal === true">
      <editTransactionModal
        v-on:close-modal="closeModal"
        :transaction="transaction"
      />
    </div>
    <div v-if="openConfirmDeleteModal">
      <DeleteModal
        v-on:close-modal="closeModal"
        v-on:delete-selected="deleteRecords"
      />
    </div>
    <div v-if="openFilterModal">
      <AdvancedSearch
        :columns="columns"
        v-on:close-modal="closeModal"
        v-on:apply-filters="applyFilters"
      />
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
const _ = require("lodash");

import createTransactionModal from "./Components/createTransactionModal";
import editTransactionModal from "./Components/editTransactionModal";
import Pagination from "./Components/Pagination";
import DeleteModal from "./Components/DeleteModal";
import AdvancedSearch from "./Components/AdvancedSearch";
import Icon from './Components/Icon'
import Search from "./Components/Search";

export default {
  data: () => ({
    loading: true,
    limit: 25,
    transaction: null,
    columns: ["date", "category", "payee", "amount", "account", "notes"],
    sort: {
      column: "date",
      direction: "desc",
    },
    searchQuery: "",
    openCreateTransactionModal: false,
    openEditTransactionModal: false,
    selected: [],
    openConfirmDeleteModal: false,
    openFilterModal: false,
    appliedFilters: null,
  }),

  components: {
    createTransactionModal,
    editTransactionModal,
    Pagination,
    DeleteModal,
    AdvancedSearch,
    Icon,
    Search
  },

  mounted() {
    this.fetchTransactions();

    window.Echo.channel("transactions").listen(
      "TransactionCreated",
      (event) => {
        console.log("event", event);
        if (event.transaction.id) {
          this.fetchTransactions();
        }
      }
    );
  },

  computed: {
    ...mapGetters({
      transactions: "transactions/transactions",
    }),

    transactionList: function transactions() {
      // if (this.searchQuery) {
      //   return this.transactions.data.filter((transaction) => {
      //     return Object.values(transaction).some((value) => {
      //       console.log('value', value)
      //       return (
      //         String(value)
      //           .toLowerCase()
      //           .includes(this.searchQuery)
      //       );
      //     });
      //   });
      // }

      if (this.transactions.data) {
        const column = this.sort.column;
        const direction = this.sort.direction;

        return this.sortArray(
          this.transactions.data.slice(),
          column,
          direction
        );
      } else {
        return [];
      }
    },
  },

  methods: {
    ...mapActions({
      deleteTransactions: "transactions/deleteTransactions",
    }),
    async fetchTransactions(page = 1, filters = "") {
      //Fetch transactions
      const limit = this.limit;
      const search = this.searchQuery
      await this.$store.dispatch("transactions/fetchTransactions", {
        limit,
        page,
        search,
        filters,
      });
      this.loading = false;
    },

    sortColumn(column) {
      console.log(column);
      this.sort.column = column;
      this.sort.direction = this.sort.direction === "asc" ? "desc" : "asc";
      console.log("hu", this.transactions);
      console.log(this.sort);
    },

    sortArray(array, column, direction) {
      if (column === "amount") {
        return array.sort((a, b) => {
          console.log("type ", typeof a[column]);
          return direction === "asc"
            ? a[column] - b[column]
            : b[column] - a[column];
        });
      } else if (column === "date") {
        return array.sort((a, b) => {
          return direction === "asc"
            ? new Date(a[column]) - new Date(b[column])
            : new Date(b[column]) - new Date(a[column]);
        });
      } else {
        return array.sort((a, b) => {
          return direction === "asc"
            ? a[column].localeCompare(b[column])
            : b[column].localeCompare(a[column]);
        });
      }
    },

    closeModal() {
      this.openCreateTransactionModal = false;
      this.openEditTransactionModal = false;
      this.openConfirmDeleteModal = false;
      this.openFilterModal = false;
    },

    updateTransaction(record) {
      if (this.selected.length === 0) {
        this.openEditTransactionModal = true;
        this.transaction = record;
      }
    },

    selectAllCheckboxes() {
      if (this.selected.length > 0) {
        this.selected = [];
        return;
      }
      this.selected = this.transactionList.map((transaction) => transaction.id);
    },

    async deleteRecords() {
      await this.deleteTransactions({
        transactions: this.selected,
      });

      await this.fetchTransactions();

      this.selected = [];
      this.openConfirmDeleteModal = false;
    },

    async applyFilters(filters) {
      await this.fetchTransactions(1, '', JSON.stringify(filters));
      this.openFilterModal = false;
      //this.displayFilters(filters);
      this.appliedFilters = filters;
    },

    async applySearch(search) {
      this.searchQuery = search;
      await this.fetchTransactions();
    },

    async removeFilter(index) {
      console.log("INDEX", index);
      this.appliedFilters.splice(index, 1);
      await this.fetchTransactions(1, JSON.stringify(this.appliedFilters));
      //this.appliedFilters = {}
    },

    upperCaseFirstVal(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
  },
};
</script>