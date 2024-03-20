<script setup>
const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="col-12">
        <div class="row">
            <div class="col-7">
                Date: {{ task.execution_date }}
            </div>
            <div class="col-5 text-center">
                Status <br>
                <span :class="'badge bg-' + task.color">{{ task.status }}</span>
            </div>
        </div>
        <hr>
        <div class="col-12">
            <p>{{ task.name }}</p>
        </div>
    </div>
</template>
