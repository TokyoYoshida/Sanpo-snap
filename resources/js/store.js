import Vue from 'vue'
import Vuex from 'vuex'
import router from './router'
import store from './store'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
    count: 0,
    search_result: {
      tracks: {
        items: [
          {
            album: {
              album_type: ''
            }
          }
        ]
      }
    }
  },
  mutations: {
    increment (state) {
      state.count++
    },
    setSearchSongResult(state, result) {
      state.search_result = result.result
      console.log(result)
    }
  },
  actions: {
    increment (context) {
      context.commit('increment')
    },
    searchSong (context, keyword) {
      console.log("keyword")
      console.log(keyword)
      axios
      .get('http://127.0.0.1:8000/api/test?keyword=' + keyword)
      .then(response => (
        context.commit('setSearchSongResult', response.data)
        )
      )
    }
  }
})
