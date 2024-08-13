// import './assets/main.css'

// 必要なコンポーネントやメソッドを読み込みます

import { createApp } from 'vue'

// App.vueをこのファイル内でAppの別名をつけて使用
import App from './App.vue' 

import router from './router'

// Vuetify
import "vuetify/styles"
import { createVuetify } from 'vuetify/lib/framework.mjs'
import * as components from "vuetify/components"
import * as directives from "vuetify/directives"

// icon
import { aliases, mdi } from "vuetify/iconsets/mdi-svg"

// Vuetifyインスタンスを作成(フロントのフレームワーク)
// Vuetifyのコンポーネント, カスタムディレクティブ, アイコン画像を使うための設定
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
        aliases,
        sets: {
            mdi,
        },
    },
})

// Appコンポーネントをルートコンポーネントで
// 新しいVueアプリを作成
// vuetify, routerを使用することを宣言
// HTMLのid=appの要素にVueを埋め込む(マウントする)
const app = createApp(App).use(vuetify).use(router).mount("#app")
