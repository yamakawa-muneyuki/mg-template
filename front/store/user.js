export const state = () => ({
  token: null,
  user: null
})

export const mutations = {
  setUser(state, { user, token }) {
    state.user = user
    state.token = token
  }
}

let promise = null

export const actions = {
  async login({ commit }, { name, password }) {
    const api = this.$axios.create()
    const { data } = await api.post("/api/login", { name, password })
    commit("setUser", {
      user: data.user,
      token: data.token.token
    })
    localStorage.setItem("TOKEN", data.token.token)
  },
  async relogin({ commit, state }) {
    if (state.user) {
      return true
    }
    if (promise) {
      return promise
    }
    promise = new Promise(async resolve => {
      const token = localStorage.getItem("TOKEN")
      if (!token) {
        resolve(false)
      }
      console.log("set token")
      this.$axios.setToken(token, "Bearer")
      try {
        const { data } = await this.$axios.get("/api/whoami")
        commit("setUser", {
          user: data.whoami,
          token: token
        })
        resolve(true)
      } catch (e) {
        resolve(false)
      }
    })
    return promise
  }
}
