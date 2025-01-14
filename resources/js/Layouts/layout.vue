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
/* Style the scrollbar container (making it thinner) */
::-webkit-scrollbar {
    width: 6px; /* Thin vertical scrollbar */
    height: 6px; /* Thin horizontal scrollbar */
}

/* Style the scrollbar track (background) */
::-webkit-scrollbar-track {
    background: #f1f1f1; /* Track color */
    border-radius: 10px;
}

/* Style the scrollbar thumb (draggable part) */
::-webkit-scrollbar-thumb {
    background: #888; /* Thumb color */
    border-radius: 10px;
}

/* Style the scrollbar thumb on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555; /* Thumb color on hover */
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
