const dashboardStore = {
    state: () => ({
            tasks: null,
            doneTasks: null,
            weekTasks: null,
    }),
    mutations: {
        setTasks(state, options) {
            state.tasks = options.tasks
            state.doneTasks = options.doneTasks
            state.weekTasks = options.week
        },
        removeDashboard(state) {
            state.tasks = null;
            state.doneTasks = null;
            state.weekTasks = null;
        },
    },
    getters: {
        getTasks(state) {
            return state.tasks ?? [];
        },
        getDoneTasks(state) {
            return state.doneTasks ?? [];
        },
        getWeekTasks(state) {
            return state.weekTasks ?? [];
        },

        getTasksCount(state, getters) {
            return getters.getTasks.length;
        },
        getDoneTasksCount(state, getters) {
            return getters.getDoneTasks.length;
        },
        getWeekTasksCount(state, getters) {
            return getters.getWeekTasks.length;
        }
    },
    actions: {
        tasksFetched({commit}, options) {
            commit('setTasks', options);
        },
    }
};

export default dashboardStore;
