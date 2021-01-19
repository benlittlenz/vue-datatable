<template>
  <section class="absolute inset-y-0 pl-16 max-w-full right-0 flex">
    <div class="w-screen max-w-md">
      <div
        class="h-full divide-y divide-gray-200 flex flex-col bg-gray-50 shadow-xl px-4"
      >
        <div class="flex-1 h-0 overflow-y-auto">
          <header class="space-y-1 py-6 px-4 sm:px-6">
            <div class="flex items-center justify-between space-x-3">
              <h2 class="text-xl leading-7 font-semibold text-gray-900">
                Update Transaction
              </h2>
              <div class="h-7 flex items-center">
                <button
                  v-on:click="closeModal"
                  aria-label="Close panel"
                  class="text-indigo-200 hover:text-white transition ease-in-out duration-150"
                >
                  <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </header>

          <form @submit.prevent="update">
            <div>
              <div>
                <div class="mt-6 flex-1 flex flex-col justify-between bg-white">
                  <label
                    class="border-solid border-b border-gray-200 py-4 text-center block text-lg font-semi-bold leading-5 text-gray-400"
                  >
                    Transaction Details
                  </label>

                  <div class="px-4 divide-y divide-gray-200 sm:px-6">
                    <div class="space-y-6 pt-6 pb-5">
                      <div class="mt-6">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >
                          Date
                        </label>
                        <div class="mt-1">
                          <date-picker
                            v-model="form.date"
                            type="date"
                            format="DD/MM/YYYY"
                          ></date-picker>
                        </div>
                      </div>
                      <div class="mt-6">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >
                          Category
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                          <input
                            placeholder="e.g. Groceries"
                            v-model="form.category"
                            id="category"
                            type="text"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                          />
                        </div>
                      </div>
                      <div class="mt-6">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >
                          Payee
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                          <input
                            placeholder="e.g. Netflix"
                            v-model="form.payee"
                            id="payee"
                            type="text"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                          />
                        </div>
                      </div>
                      <div class="mt-6">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >
                          Amount
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                          <input
                            placeholder="$0.00"
                            v-model="form.amount"
                            id="amount"
                            type="decimal"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                          />
                        </div>
                      </div>
                      <div class="mt-6">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >
                          Account
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                          <input
                            placeholder="e.g. Everyday Spending"
                            v-model="form.account"
                            id="account"
                            type="text"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                          />
                        </div>
                      </div>
                      <div class="mt-6">
                        <label
                          for="password"
                          class="block text-sm font-medium leading-5 text-gray-700"
                        >
                          Notes
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                          <input
                            placeholder="Optional Notes"
                            v-model="form.notes"
                            id="notes"
                            type="text"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="absolute bottom-0 right-0 mr-6 mb-6 flex-shrink-0 px-4 py-4 space-x-4 flex justify-end"
                >
                  <span class="inline-flex rounded-md shadow-sm">
                    <button
                      v-on:click="closeModal"
                      type="button"
                      class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"
                    >
                      Cancel
                    </button>
                  </span>
                  <span class="inline-flex rounded-md shadow-sm">
                    <button
                      type="submit"
                      class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    >
                      Save
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  props: ["transaction"],
  components: {
    DatePicker,
  },
  data: () => ({
    form: {
      date: new Date(),
      category: "",
      payee: "",
      amount: "",
      notes: "",
      account: "",
    },
  }),

  created() {
    this.form.date = this.transaction.date
      ? new Date(this.transaction.date)
      : new Date();
    this.form.category = this.transaction.category;
    this.form.payee = this.transaction.payee;
    this.form.amount = this.transaction.amount;
    this.form.notes = this.transaction.notes;
    this.form.account = this.transaction.account;
  },

  methods: {
    ...mapActions({
      updateTransaction: "transactions/updateTransaction",
    }),
    closeModal() {
      this.$emit("close-modal");
    },

    async update() {
      try {
        const response = await this.updateTransaction({
          data: {
            date: this.form.date
              ? new Date(this.form.date).toISOString().substring(0, 10)
              : new Date().toISOString().substring(0, 10),
            category: this.form.category,
            payee: this.form.payee,
            amount: this.form.amount,
            notes: this.form.notes,
            account: this.form.account,
          },
          id: this.transaction.id,
        });

        console.log("RES: ", response);
        this.$emit("close-modal");
      } catch (err) {
        console.log("ERROR: ", err);
      }
    },
  },
};
</script>
