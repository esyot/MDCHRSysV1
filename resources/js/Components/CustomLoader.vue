<!-- resources/js/Components/CustomLoader.vue -->
<template>
    <div class="loader">
        <img src="/public/assets/loader/loading.gif" alt="Loading..." />
    </div>
</template>

<script>
export default {
    name: "CustomLoader",
};
</script>

<style scoped>
.loader {
    user-select: none;
    display: flex;
    position: fixed;
    inset: 0;
    z-index: 50;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.3);
}

.loader img {
    height: 7vh;
}
</style>
