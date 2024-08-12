import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import HomeContent from '@/components/HomeContent.vue'
import EventPage from '@/components/EventPage.vue'
import ArticlesContent from '@/components/ArticlesContent.vue'
import MyPage from '@/components/MyPage.vue'
import SettingsPage from '@/components/SettingsPage.vue'
import FocusPost from '@/components/FocusPost.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeContent
    },
    {
      path: "/event",
      name: "event",
      component: EventPage
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
      path: "/post/:id",
      // path: "/post",
      name: "focusPost",
      component: FocusPost,
      props: (route) => ({
        post: String(route.query.post)
      }),
    }
  ]
})

export default router
