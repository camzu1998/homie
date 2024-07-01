<script setup>

import Menu from './Components/Menu.vue'
import routes from './routes';

</script>

<template>
    <div class="container text-center">
        <h1 class="fs-1 header">I-HOMIE</h1>
    </div>
    <Menu :routes="routes"/>
    <div class="container-xl">
        <div class="row justify-content-between">
            <div class="col-2 text-center">
                <router-view class="view left-sidebar" name="LeftSidebar"></router-view>
            </div>
            <div class="col-10 row justify-content-center">
                <router-view class="view main-content"></router-view>
            </div>
<!--            <div class="col-2">-->
<!--                <router-view class="view right-sidebar" name="RightSidebar"></router-view>-->
<!--            </div>-->
        </div>
    </div>
</template>
