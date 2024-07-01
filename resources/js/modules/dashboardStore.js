const dashboardStore = {
    state: () => ({
            tasks: null,
            doneTasks: null,
            weekTasks: null,
            todayDutiesCount: null,
            addedDutiesCount: null,
            addedEntriesCount: null,
            doneDutiesCount: null,
    }),
    mutations: {
        setTasks(state, options) {
            state.tasks = options.tasks
            state.doneTasks = options.doneTasks
            state.weekTasks = options.week
            state.todayDutiesCount = options.todayDutiesCount
            state.addedDutiesCount = options.addedDutiesCount
            state.addedEntriesCount = options.addedEntriesCount
            state.doneDutiesCount = options.doneDutiesCount
        },
        removeDashboard(state) {
            state.tasks = null;
            state.doneTasks = null;
            state.weekTasks = null;
            state.todayDutiesCount = null;
            state.addedDutiesCount = null;
            state.addedEntriesCount = null;
            state.doneDutiesCount = null;
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
