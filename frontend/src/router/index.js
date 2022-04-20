import { createRouter, createWebHashHistory, RouterView } from "vue-router";

import NProgress from "nprogress/nprogress.js";

// Main layout variations
import LayoutSimple from "@/layouts/variations/Simple.vue";
import LayoutBackend from "@/layouts/variations/Backend.vue";
const StockRequestPage = () =>
  import("@/views/ResponsiveView.vue");
  const DetailSRPage = () =>
  import("@/views/DetailSRView.vue");
// Backend: Generic Pages
const DashboardPage = () =>
  import("@/views/backend/pages/generic/ResponsiveView.vue");
const ProfilePage = () =>
  import("@/views/backend/pages/generic/ProfileView.vue");

  // Auth
const AuthSignIn = () => import("@/views/auth/SignInView.vue");
const AuthSignIn2 = () => import("@/views/auth/SignIn2View.vue");
const AuthSignIn3 = () => import("@/views/auth/SignIn3View.vue");
const AuthSignUp = () => import("@/views/auth/SignUpView.vue");
const AuthSignUp2 = () => import("@/views/auth/SignUp2View.vue");
const AuthSignUp3 = () => import("@/views/auth/SignUp3View.vue");
const AuthLock = () => import("@/views/auth/LockView.vue");
const AuthLock2 = () => import("@/views/auth/Lock2View.vue");
const AuthLock3 = () => import("@/views/auth/Lock3View.vue");
const AuthReminder = () => import("@/views/auth/ReminderView.vue");
const AuthReminder2 = () => import("@/views/auth/Reminder2View.vue");
const AuthReminder3 = () => import("@/views/auth/Reminder3View.vue");

// Set all routes
const routes = [
  /*
  |
  |--------------------------------------------------------------------------
  | Landing Routes
  |--------------------------------------------------------------------------
  |
  */
  {
    path: "/",
    component: LayoutBackend,
    children: [
      {
        path: ".",
        name: "landing",
        component: DashboardPage,
      },
      {
        path: "stock-request",
        name: "stock-request",
        component: StockRequestPage,
      },
      {
        path: "stock-request-detail/:id",
        name: "stock-request-detail",
        component: DetailSRPage,
        props: true
      },
      {
        path: "profile",
        name: "backend-pages-generic-profile",
        component: ProfilePage,
      },
    ],
  },

  /*
  |
  |--------------------------------------------------------------------------
  | Auth Routes
  |--------------------------------------------------------------------------
  |
  */
  {
    path: "/auth",
    component: LayoutSimple,
    children: [
      {
        path: "signin",
        name: "auth-signin",
        component: AuthSignIn,
      },
      {
        path: "signin2",
        name: "auth-signin2",
        component: AuthSignIn2,
      },
      {
        path: "signin3",
        name: "auth-signin3",
        component: AuthSignIn3,
      },
      {
        path: "signup",
        name: "auth-signup",
        component: AuthSignUp,
      },
      {
        path: "signup2",
        name: "auth-signup2",
        component: AuthSignUp2,
      },
      {
        path: "signup3",
        name: "auth-signup3",
        component: AuthSignUp3,
      },
      {
        path: "lock",
        name: "auth-lock",
        component: AuthLock,
      },
      {
        path: "lock2",
        name: "auth-lock2",
        component: AuthLock2,
      },
      {
        path: "lock3",
        name: "auth-lock3",
        component: AuthLock3,
      },
      {
        path: "reminder",
        name: "auth-reminder",
        component: AuthReminder,
      },
      {
        path: "reminder2",
        name: "auth-reminder2",
        component: AuthReminder2,
      },
      {
        path: "reminder3",
        name: "auth-reminder3",
        component: AuthReminder3,
      },
    ],
  },

];

// Create Router
const router = createRouter({
  history: createWebHashHistory(),
  linkActiveClass: "active",
  linkExactActiveClass: "",
  scrollBehavior() {
    return { left: 0, top: 0 };
  },
  routes,
});

// NProgress
/*eslint-disable no-unused-vars*/
NProgress.configure({ showSpinner: false });

router.beforeResolve((to, from, next) => {
  NProgress.start();
  next();
});

router.afterEach((to, from) => {
  NProgress.done();
});
/*eslint-enable no-unused-vars*/

export default router;
