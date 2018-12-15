import Vue from 'vue'
import Vuex from 'vuex'
import router from './router'
import store from './store'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';
const GET_USER_INFO = 'GET_USER_INFO';
const SET_LOADING = 'SET_LOADING';
const SET_CURRENT_PHOTO = 'SET_CURRENT_PHOTO';

export default new Vuex.Store({
    state: {
        loading: false,
        authUser: null,
        currentPhoto: null,
        count: 100 + 100,
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
        [GET_USER_INFO](state, authUser) {
            state.authUser = authUser;
        },
        [SET_LOADING](state, loading) {
            state.loading = loading;
        },
        [SET_CURRENT_PHOTO](state, photo) {
            state.currentPhoto = photo;
        },
        increment(state) {
            state.count++
        },
        setSearchSongResult(state, result) {
            state.search_result = result.result
        }
    },
    actions: {
        getUserInfo(context) {
            context.commit(SET_LOADING, true);
            axios.get('/api/users/me')
                .then(response => {
                    context.commit(GET_USER_INFO, response.data);
                    context.commit(SET_LOADING, false);
                });
        },
        getCurrentPhoto(context, id) {
            context.commit(SET_CURRENT_PHOTO, null);
            axios("/api/photos/" + id, {
            }).then(response => {
                context.commit(SET_CURRENT_PHOTO, response.data);
            });
        },
        increment(context) {
            context.commit('increment')
        },
        searchSong(context, keyword) {
            axios
                .get('http://127.0.0.1:8000/api/test?keyword=' + keyword)
                .then(response => (
                        context.commit('setSearchSongResult', response.data)
                    )
                )
        }
    }
})
