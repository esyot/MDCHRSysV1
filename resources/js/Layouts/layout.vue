<script>
import Leftbar from "@/components/leftbar.vue";
import Topbar from "@/Components/topbar.vue";

export default {
    components: {
        Leftbar,
        Topbar,
    },
};
</script>

<template>
    <div class="container">
        <Leftbar />
        <div class="main-content">
            <Topbar />

            <slot> </slot>
        </div>
    </div>
</template>

<style>
.container {
    width: screen;
    display: flex;
    height: 100vh;
    transition: transform 0.3s ease-in-out;
}
.main-content {
    width: 100%;
    background: linear-gradient(to bottom, #2986c0, #02041d);
}
</style>
