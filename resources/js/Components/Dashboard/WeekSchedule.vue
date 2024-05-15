<template>
    <div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="7">{{ monthName }}</th>
            </tr>
            <tr>
                <th v-for="(day, index) in days" :key="index">{{ day }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td v-for="(day, index) in days" :key="index">
                    <div v-for="(event, eventIndex) in eventsForDay(day)" :key="eventIndex">
                        {{ event.name }}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        events: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            days: [],
            monthName: ''
        }
    },
    mounted() {
        this.initDays()
    },
    methods: {
        initDays() {
            const startDate = this.getMonday(new Date())
            const endDate = new Date(startDate.getTime() + 6 * 24 * 60 * 60 * 1000)
            this.days = []
            for (let i = 0; i < 7; i++) {
                const day = new Date(startDate.getTime() + i * 24 * 60 * 60 * 1000)
                this.days.push(day.getDate())
            }
            this.monthName = startDate.toLocaleString('default', { month: 'long' })
        },
        getMonday(date) {
            const day = date.getDay()
            const diff = date.getDate() - day + (day === 0 ? -6 : 1)
            return new Date(date.setDate(diff))
        },
        eventsForDay(day) {
            return this.events.filter(event => {
                const eventDate = new Date(event.date)
                console.log(Date.parse(event.date), eventDate.getDate(), day)
                return eventDate.getDate() === day
            })
        }
    }
}
</script>
