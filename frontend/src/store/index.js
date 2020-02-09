import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    cities: [],
    currentCity: {},
    errors: [],
    load: false
  },
  mutations: {
  },
  actions: {
    getCity({state},id) {
      axios.get('http://45.80.71.88/cities/' + id)
        .then(response => {
          state.currentCity = response.data;
        })
        .catch(e => {
          state.errors.push(e);
        })
    },
    getData({state}) {
      if(state.cities.length > 0) {
        state.load = false;
        return; 
      } else {
        state.load = true;
        axios.get('http://45.80.71.88/cities/')
        .then(response => {
          state.cities = response.data;
          state.load = false;
        })
        .catch(e => {
          state.errors.push(e);
          state.load = false;
        })
      }
    }
  },
  getters: {
    cities: state => state.cities,
    currentCity: state => state.currentCity,
    load: state => state.load
  },
  modules: {
  }
})
