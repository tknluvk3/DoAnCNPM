import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save

const routes = [
  {
    path: '/',
    component: () => import('../layout/wrapper/indexView.vue'),
    meta: { layout: 'user' },
    children: [
      {
        path: 'dat-ban',
        components: {
          default: () => import('../components/user_view/user/index.vue'),
          detail: () => import('../components/user_view/user/BanDetail.vue')
        }
      },
      {
        path: 'thuc-don',
        components: {
          default: () => import('../components/user_view/user/indexThucDon.vue'),
          detail: () => import('../components/user_view/user/BanDetail.vue')
        }
      },
      // Thêm các route cho user ở đây
    ]
  },
  {
    path: '/admin',
    component: () => import('../layout/wrapper/index.vue'),
    meta: { layout: 'admin' },
    children: [
      {
        path: 'dashboard',
        component: () => import('../components/Test/index.vue')
      },
      {
        path: 'ban',
        component: () => import('../components/admin/ban/index.vue')
      },
      {
        path: 'dich-vu',
        component: () => import('../components/admin/dichvu/index.vue')
      },
      // {
      //   path: 'doanh-thu',
      //   component: () => import('../components/admin/doanhthu/index.vue')
      // }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
});

export default router