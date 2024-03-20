const dashboardStore = {
    state: () => ({
            tasks: null,
    }),
    mutations: {
        setTasks(state, tasks) {
            state.tasks = tasks
        },
        removeDashboard(state) {
            state.tasks = null;
        },
    },
    getters: {
        getTasks(state) {
            return state.tasks ?? [];
        },

        getTasksCount(state, getters) {
            return getters.getTasks.length;
        }
    },
    actions: {
        tasksFetched({commit}, options) {
            commit('setTasks', options);
        },
    }
};

export default dashboardStore;
