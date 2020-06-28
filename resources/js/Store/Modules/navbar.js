export default {
  namespaced: true,

  state: {
    sidebar_toggle : false
  },

  mutations: {
    setSidebarToggle(state, value){
      state.sidebar_toggle = value
    },
  },

  actions: {
    toggle({commit, state}){
      commit('setSidebarToggle', !state.sidebar_toggle);
    },
  }
}