<template>
  <div class="mx-auto mt-20 w-11/12">
    <div class="rounded-lg">
      <button
        v-on:click="openCreateTransactionModal = true"
        class="flex mr-2 focus:cursor-pointer focus:outline-none bg-purple-400 text-white py-2 px-4 rounded-lg font-bold"
      >
        <svg
          class="w-6 h-6 bg-purple-600 text-white rounded-full"
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
        <span class="ml-2">Create Transaction</span>
      </button>
    </div>
    <div class="flex items-center mt-4">
      <div class="flex flex-1 pr-4">
        <div class="relative md:w-1/3">
          <input
            v-model="searchQuery"
            type="search"
            class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
            placeholder="Search..."
          />
          <div class="absolute top-0 left-0 inline-flex items-center p-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6 text-gray-400"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
              <circle cx="10" cy="10" r="7" />
              <line x1="21" y1="21" x2="15" y2="15" />
            </svg>
          </div>
        </div>
      </div>
      <div class="flex items-center">
        <button
          type="button"
          @click="open = !open"
          class="flex items-center text-gray-700 px-3 py-1 border font-medium rounded"
        >
          <svg
            viewBox="0 0 24 24"
            preserveAspectRatio="xMidYMid meet"
            class="w-5 h-5 mr-1"
          >
            <g class="">
              <path d="M0 0h24v24H0z" fill="none" class=""></path>
              <path
                d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"
                class=""
              ></path>
            </g>
          </svg>
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
            <svg
              class="fill-current h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            >
              <path
                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
              />
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-sm shadow overflow-y-auto relative mt-2">
      <div v-if="loading">Loading...</div>
      <div v-else>
        <table
          class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative"
        >
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
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 15l7-7 7 7"
                        ></path>
                      </svg>
                    </span>
                  </div>
                  <div
                    class="flex items-center"
                    v-if="sort.direction === 'desc'"
                  >
                    <span class="mr-2">{{ column }}</span>
                    <span>
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 9l-7 7-7-7"
                        ></path>
                      </svg>
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
                v-on:click="updateTransaction(transaction)"
              >
                <td class="border-dashed border-t border-gray-200 px-3">
                  <label
                    class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer"
                  >
                    <input
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
                <td class="border-solid border border-gray-200">
                  <div class="flex flex-col justify-center items-center">
                    <span class="">
                      <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"
                        ></path>
                      </svg>
                    </span>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
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
  </div>
</template>

<script>
import { createLogger, mapGetters } from "vuex";
const _ = require("lodash");

import createTransactionModal from "./Components/createTransactionModal";
import editTransactionModal from "./Components/editTransactionModal";

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
  }),

  components: {
    createTransactionModal,
    editTransactionModal,
  },

  mounted() {
    //console.log('hey',)
    console.log("loaded", process.env.MIX_PUSHER_APP_CLUSTER);
    this.fetchTransactions();

    // window.Echo.channel("transactions").listen(
    //   "TransactionCreated",
    //   (event) => {
    //     console.log("event", event);
    //     if(event.transaction.id) {
    //       this.fetchTransactions();
    //     }
    //   }
    // );
  },

  computed: Object.assign(
    {},
    mapGetters({
      transactions: "transactions/transactions",
    }),
    {
      transactionList() {
        if (this.searchQuery) {
          return this.transactions.data.filter((transaction) => {
            return Object.keys(transaction).some((key) => {
              return (
                String(transaction[key])
                  .toLowerCase()
                  .indexOf(this.searchQuery.toLowerCase()) > -1
              );
            });
          });
        }

        if (this.transactions.data) {
          //return this.transactions.data
          const column = this.sort.column;
          const direction = this.sort.direction;
          return _.orderBy(
            this.transactions.data.slice(),
            (transaction) => {
              return String(transaction[column]).toLowerCase();
            },
            direction
          );
        } else {
          return [];
        }
      },
    }
  ),

  methods: {
    async fetchTransactions() {
      //Fetch transactions
      const limit = this.limit
      await this.$store.dispatch("transactions/fetchTransactions", {
        limit
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

    closeModal() {
      this.openCreateTransactionModal = false;
      this.openEditTransactionModal = false;
    },

    updateTransaction(record) {
      this.openEditTransactionModal = true;
      this.transaction = record;
    },
  },
};
</script>