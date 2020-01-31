export const state = () => ({
  count: 0
})

export const mutations = {
  add(state) {
    state.count++
  },
  sub(state) {
    state.count--
  }
}

export const actions = {
  add({ commit, state }) {
    if (state.count === 0) {
      commit("add")
      setTimeout(() => {
        commit("sub")
      }, 500)
    }
    commit("add")
  },
  sub({ commit }) {
    commit("sub")
  }
}
