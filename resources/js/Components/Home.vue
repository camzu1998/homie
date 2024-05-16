<template>
    <div class="row">
        <div class="col-4">
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="card-title text-center">Your profile</h5>
                </div>
                <img src="/images/profile.png" class="card-img-top" alt="User Profile image">
                <div class="card-body">
                    <div class="user-info">
                        <h5 class="text-center text-primary">Hello {{ user.name }}</h5>
                        <p class="card-text">Today duties todo: {{ todayDutiesCount }}</p>
                    </div>
                    <hr class="text-primary" style="opacity: 0.75 !important;"/>
                    <div class="statistic-panel">
                        <h5 class="text-center text-primary">Your statistics</h5>
                        <p class="card-text">Added duties: {{ addedDutiesCount }}</p>
                        <p class="card-text">Executed duties: {{ doneDutiesCount }}</p>
                        <p class="card-text">Added home entries: 0</p>
                        <p class="card-text">Executed home entries: 0</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="row mb-4">
                <div class="col-6">
                    <div class="card border-info">
                        <div class="card-header border-info">
                            <h5 class="card-title text-center">Next duty</h5>
                        </div>
                        <div class="card-body">
                            <div class="row flex-column">
                                <Task v-for="task in tasks" :key="task.id" :task="task" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-info">
                        <div class="card-header border-info">
                            <h5 class="card-title text-center">Tasks done in this month</h5>
                        </div>
                        <div class="card-body">
                            <Task v-for="task in doneTasks" :key="task.id" :task="task" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-header border-info">
                            <h5 class="card-title text-center">Week preview</h5>
                        </div>
                        <div class="card-body">
                            <WeekSchedule
                                :events="week"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {ref} from "vue";
import Task from "./Partials/Dashboard/Task.vue";
import WeekSchedule from "./Dashboard/WeekSchedule.vue";

export default {
    components: {WeekSchedule, Task},
    mounted() {
        this.fetchDashboardData();
    },

    data() {
        return {
            windowWidth: ref(window.innerWidth),
            modal: ref(false),
            user:  this.$store.state.user,
            tasks:  this.$store.state.dashboard.tasks,
            doneTasks:  this.$store.state.dashboard.doneTasks,
            week:  this.$store.state.dashboard.weekTasks,
            doneDutiesCount:  this.$store.state.dashboard.doneDutiesCount,
            addedDutiesCount:  this.$store.state.dashboard.addedDutiesCount,
            todayDutiesCount:  this.$store.state.dashboard.todayDutiesCount,
        };
    },

    methods: {
        fetchDashboardData() {
            axios.get('/api/dashboard')
                .then(response => {
                    this.$store.commit('setTasks', response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        reload() {
            this.$forceUpdate();
        }
    },
};
</script>
