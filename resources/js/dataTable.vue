<template>
  <div class="mx-auto mt-20 w-11/12">
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
                class="w-40 bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
                Date
              </th>
              <th
                class="bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
                Category
              </th>
              <th
                class="text-center bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
                Payee
              </th>
              <th
                class="w-40 text-center bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
                Amount
              </th>
              <th
                class="text-center bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
                Account
              </th>
              <th
                class="text-center bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
                Notes
              </th>
              <th
                class="w-4 bg-gray-100 sticky top-0 border-solid border border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs"
              >
              </th>
            </tr>
          </thead>
          <tbody>
            <template>
              <tr
                v-for="transaction in transactions.data"
                :key="transaction.id"
                class="max-h-2 hover:bg-gray-50 cursor-pointer">
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
                  <span class="text-gray-700 px-6 py-1 flex items-center"
                    >{{transaction.date}}</span
                  >
                </td>
                <td class="border-solid border border-gray-200">
                  <span class="text-gray-700 px-6 py-1 flex items-center"
                    >{{transaction.category}}</span
                  >
                </td>
                <td class="border-solid border border-gray-200">
                  <span class="text-gray-700 px-6 py-1 flex items-center"
                    >{{transaction.payee}}</span
                  >
                </td>
                <td class="border-solid border border-gray-200">
                  <span class="text-gray-700 px-6 py-1 flex items-center"
                    >${{transaction.amount}}</span
                  >
                </td>
                <td class="border-solid border border-gray-200">
                  <span class="text-gray-700 px-6 py-1 flex items-center"
                    >{{transaction.account}}</span
                  >
                </td>
                <td class="border-solid border border-gray-200">
                  <span class="text-gray-700 px-6 py-1 flex items-center"
                    >{{transaction.notes}}</span
                  >
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
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    loading: true,
  }),

  mounted() {
    console.log("loaded");
    this.fetchTransactions();
  },

  computed: mapGetters({
    transactions: "transactions/transactions",
  }),

  methods: {
    async fetchTransactions() {
      //Fetch transactions
      await this.$store.dispatch("transactions/fetchTransactions");
      this.loading = false;
    },
  },
};
</script>