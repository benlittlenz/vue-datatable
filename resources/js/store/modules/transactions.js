import axios from 'axios'
import * as types from '../mutation-types'

export const state = {
    transactions: []
}

//getters
export const getters = {
    transactions: state => state.transactions,
}

// mutations
export const mutations = {
    [types.FETCH_TRANSACTIONS](state, { transactions }) {
        state.transactions = transactions
    },

    [types.CREATE_TRANSACTION](state, { data }) {
        state.transactions.data.push({ data })
    },

    // [types.DELETE_TRANSACTION](state, { transactions }) {
    //     console.log('data:', transactions);
    //     console.log(state.transactions.data);

    //     transactions.map(transaction => {
    //         let index = state.transactions.data.findIndex(item => transaction === item.id)
    //         console.log('index: ', index);
    //         state.transactions.data.splice(index, 1);
    //     })

    // },

    [types.UPDATE_TRANSACTION] (state, data ) {
        console.log('state', state)
        console.log('data', data)
        state.transactions.data = state.transactions.data.map(transaction => {
            if (transaction.id === data.id) {
              return Object.assign({}, transaction, data)
            }
            return transaction
          })
    },
}

// actions
export const actions = {
    async fetchTransactions({ commit }, { limit, page, search, filters }) {
        try {
            const { data } = await axios.get(`/api/transactions?limit=${limit}&page=${page}&search=${search}&filters=${filters}`)

            commit(types.FETCH_TRANSACTIONS, { transactions: data })
        } catch (e) {
            console.log("ERROR", e)
        }
    },

    async createTransaction({ commit }, { data }) {
        console.log("DATA", data)
        commit(types.CREATE_TRANSACTION, { data })

        return await axios.post('/api/transactions', data)
    },

    async updateTransaction({ commit }, payload) {
        const transactionID = payload.id
        console.log("ID: ", transactionID)
        console.log(payload)
        commit(types.UPDATE_TRANSACTION, payload)
        return await axios.patch(`/api/transactions/${transactionID}`, payload.data)
    },

    async deleteTransactions({ commit }, { transactions }) {
        return await axios.delete(`/api/transactions/${transactions}`)
    },
}