<script setup>
import { ref, provide, watch, onMounted } from "vue";
import { RouterLink, RouterView } from 'vue-router'
import SideBar from './components/SideBar.vue';
import TrendMenu from "./components/TrendMenu.vue";

import { useDisplay } from 'vuetify/lib/framework.mjs';

// 使用したいアイコンをロード
import { mdiAccount } from '@mdi/js';

const device = useDisplay();

// PC画面の半分以下か判定
const isLessHalf = ref(device.smAndDown.value);

// スマホ画面か判定
const isMobile = ref(device.xs.value);

onMounted(() => {
  isLessHalf.value = device.smAndDown.value;
  isMobile.value = device.xs.value;
})

watch(device.name, () => {
        isMobile.value = device.xs.value;
        isLessHalf.value = device.smAndDown.value;

        console.log(isMobile.value);
        console.log("xs - " + device.xs.value);
        // console.log("isMobile : " + isMobile.value + "Half : " + isLessHalf.value);
    })

provide("device", device);
provide("isLessHalf", isLessHalf);
provide("isMobile", isMobile);
</script>

<template>
  <v-layout class="rounded rounded-md">
    <!-- <v-app-bar color="surface-variant" title="Application bar"></v-app-bar> -->

    <!-- 左部ナビゲーションバー -->
    <!-- PC版 -->
    <SideBar />

    <TrendMenu />

    <v-main class="align-center justify-center" style="min-height: 300px;">
      <div>
        <RouterView />
      </div>
    </v-main>
  </v-layout>
</template>

<!-- <style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style> -->

<style scoped>

</style>