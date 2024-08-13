<script setup>
/*
  シングルファイルコンポーネントなので、
  1つのVueファイル内でそれぞれ独立して
  <script>(JavaScript), <template>(HTML要素), <style>(CSS)
  を記述します
*/
import { ref, provide, watch, onMounted } from "vue";
import { RouterLink, RouterView } from 'vue-router'

// コンポーネントを読み込みます
import SideBar from './components/SideBar.vue';
import TrendMenu from "./components/TrendMenu.vue";

import { useDisplay } from 'vuetify/lib/framework.mjs';

// 使用したいアイコンをロード
import { mdiAccount } from '@mdi/js';

// ウィンドウを監視するためのコンポーネントです
const device = useDisplay();

// PC画面の半分以下か判定
// refプロパティは値が動的に変わった時にHTML要素に反映させることが出来ます
const isLessHalf = ref(device.smAndDown.value);

// スマホ画面か判定
const isMobile = ref(device.xs.value);

onMounted(() => {
  isLessHalf.value = device.smAndDown.value;
  isMobile.value = device.xs.value;
})

// ウィンドウサイズを常に監視します
watch(device.name, () => {
        isMobile.value = device.xs.value;
        isLessHalf.value = device.smAndDown.value;

        console.log(isMobile.value);
        console.log("xs - " + device.xs.value);
        // console.log("isMobile : " + isMobile.value + "Half : " + isLessHalf.value);
    })

// 子コンポーネントにも値を渡します
// グローバル宣言のイメージ?
provide("device", device);
provide("isLessHalf", isLessHalf);
provide("isMobile", isMobile);
</script>

<!-- 以下の内容がHTMLに挿入されます -->
<template>
  <v-layout class="rounded rounded-md">
    <!-- <v-app-bar color="surface-variant" title="Application bar"></v-app-bar> -->

    <!-- 
      App.vueが以前のファイル構成でいうindex.htmlで
      SideBar, TrendMenu, RouterViewがそれぞれ
      left.html, right.html, center.htmlみたいなイメージ? 
    -->

    <!-- 左部ナビゲーションバー -->
    <!-- PC版 -->
    <!-- SideBarコンポーネントの内容が挿入されます -->
    <!-- 直接書く事も出来ますが分割することでスッキリさせています -->
    <SideBar />

    <!-- TrendMenuコンポーネントの内容が挿入されます -->
    <TrendMenu />

    <v-main class="align-center justify-center" style="min-height: 300px;">
      <div>
        <!-- 
            アクセスするURLによって読み込まれるものが変わります
            投稿, マイページ, 設定など...
            詳しいルーティングはrouter/index.jsを見てください
        -->
        <RouterView />
      </div>
    </v-main>
  </v-layout>
</template>

<!-- CSSを記述 -->
<style scoped>

</style>