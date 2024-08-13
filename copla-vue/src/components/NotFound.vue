<script setup>
    import { mdiBusStopUncovered } from '@mdi/js';
</script>

<template>
    <div class="center mt-10">
        <h1 class="big-text">404</h1>
        <v-icon size="200">{{ mdiBusStopUncovered }}</v-icon>
        <h1 class="big-text">Not Found</h1>
        <p class="middle-text">Sorry, Page Not Found</p>
        <v-btn to="/">Return to Top</v-btn>

    </div>
</template>

<style scoped>
.center {
    text-align: center;
}

.big-text {
    font-size: 2.5rem;
}

.middle-text {
    font-size: 1.2rem;
}
</style>