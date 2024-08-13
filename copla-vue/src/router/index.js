import { createRouter, createWebHistory } from 'vue-router'

// コンポーネントの読み込み
import HomeContent from '@/components/HomeContent.vue'
import EventPage from '@/components/EventPage.vue'
import ArticlesContent from '@/components/ArticlesContent.vue'
import MyPage from '@/components/MyPage.vue'
import SettingsPage from '@/components/SettingsPage.vue'
import FocusPost from '@/components/FocusPost.vue'
import NotFound from '@/components/NotFound.vue'
import BusPage from '@/components/BusPage.vue'

// ルーティング制御のファイルです
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      // トップページにアクセスした場合
      path: '/',
      // 以下はvueで名前を指定してアクセスするための別名です
      // hrefとかでURLを書かなくても homeを指定すれば飛べます
      name: 'home',

      // HomeContentコンポーネントを読み込みます
      // HomeContentはimportしたHomeContent.vueのことです
      component: HomeContent
    },
    {
      path: "/event",
      name: "event",
      component: EventPage
    },
    {
      path: "/bus",
      name: "bus",
      component: BusPage
    },
    {
      path: '/articles',
      name: 'articles',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      // component: () => import('../views/AboutView.vue')
      component: ArticlesContent
    },
    {
      path: "/mypage",
      name: "mypage",
      component: MyPage
    },
    {
      path: "/settings",
      name: "settings",
      component: SettingsPage
    },
    {
      // シングルポストのルートです
      path: "/post/:id",

      // path: "/post",
      name: "focusPost",
      component: FocusPost,

      // FocusPostコンポーネントにクエリの値を渡します
      // まだ上手く使いきれてないのでもう少し勉強します
      props: (route) => ({
        post: String(route.query.post)
      }),
    },
    {
      // 上記以外のURLにアクセスした場合はNot Foundページに遷移します
      path: `/:pathMatch(.*)*`,
      component: NotFound
    }
  ]
})

export default router
