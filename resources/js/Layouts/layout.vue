<script>
import Leftbar from "@/components/leftbar.vue";
import Topbar from "@/Components/topbar.vue";

export default {
    components: {
        Leftbar,
        Topbar,
    },
    props: {
        user: Object,
        roles: Object,
    },
};
</script>

<template>
    <div class="container">
        <Leftbar :roles="roles" />
        <div class="main-content">
            <Topbar :user="user" />

            <slot> </slot>
        </div>
    </div>
</template>

<style>
.link {
    color: currentColor;
    text-decoration: none;
}
::-webkit-scrollbar {
    width: 3px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.container {
    width: screen;
    display: flex;
    height: 100vh;
    transition: transform 0.3s ease-in-out;
}
.main-content {
    overflow-y: hidden;
    overflow-x: hidden;
    width: 100%;
    background: linear-gradient(to bottom, #2986c0, #02041d);
}
</style>
