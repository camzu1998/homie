import { createStore, createLogger } from 'vuex';
import VuexPersistence from 'vuex-persist'
import houseStore from './modules/houseStore';
import roomStore from "./modules/roomsStore";
import dutyStore from "./modules/dutyStore";
import entryStore from "./modules/entriesStore";
import dashboardStore from "./modules/dashboardStore.js";

const persist = new VuexPersistence({
    key: 'vuex',
    storage: window.localStorage,
});

const debug = process.env.NODE_ENV !== 'production';


const store = createStore({
    modules: {
        house: houseStore,
        room: roomStore,
        duty: dutyStore,
        entry: entryStore,
        dashboard: dashboardStore
    },
    state: {
            isLoggedIn: false,
            user: null,
    },
    mutations: {
        setUser(state, user) {
            state.user = Object.assign({}, state.user, user);
            state.isLoggedIn = !!user;
        },
        removeUser(state) {
            state.user = null;
            state.isLoggedIn = false;
        },
    },
    actions: {
        userLoggedIn({commit}, user) {
            commit('setUser', user);
        },
        removeAllUserData({commit}) {
            commit('removeUser');
            commit('removeHouses');
            commit('removeRooms');
            commit('removeDuties');
            commit('removeEntries');
            commit('removeDashboard');
        }
    },
    strict: debug,
    plugins: [
        persist.plugin,
        createLogger()
    ],
});

export default store;
