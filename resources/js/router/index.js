import { createRouter, createWebHistory } from "vue-router";
import createRoutes from "./routes";

export default (store, redirect) => {
    const routes = createRoutes();

    const router = createRouter({
        history: createWebHistory(),
        routes,
    });
    router.beforeEach((to, from, next) => {
        let go;
        if (to.meta.auth || to.meta.guest) {
            let isLogin = store.getters["userModule/isAuth"];
            if (to.meta.auth && ! isLogin) {
                document.location = "/auth/login";
            } else if (to.meta.guest && isLogin) {
                go = {
                    name: "home",
                };
            }
           
        }
        if (to.meta.dev || to.meta.moderator) {
            let isDev = store.getters["userModule/isDev"];
            let isModerator = store.getters["userModule/isModerator"]
            if (to.meta.dev && ! isDev) {
                go = { name: "home" };
            }
            if (to.meta.moderator && ! isModerator) {
                go = { name: "home" };
            }
        }
        next(go);
    });

    return router;
};
