import createRouter from "./router";
import createStore from "./store";
import createHttpPlugin from "./plugins/http";
import createCsrfPlugin from "./plugins/csrf";
import createRedirectPlugin from "./plugins/redirect";
import createFormPlugin from "./plugins/vform";
import { createApp } from "vue";
import App from "./App.vue";
import { Form } from "vform";
import mdiVue from "mdi-vue/v3";
import * as mdijs from "@mdi/js";
import initHttpErrorsHandler from "./connectors/http-errors-handler";
import createComponentPlugin from "./plugins/init-components";

export default (context) => {
    const httpPlugin = createHttpPlugin();
    const csrfPlugin = createCsrfPlugin();
    const redirectPlugin = createRedirectPlugin(context.routes);
    const formPlugin = createFormPlugin(Form, httpPlugin.http);
    const store = createStore(httpPlugin.api);
    const router = createRouter(store);
    const globalComponentsPlugin = createComponentPlugin();
    initHttpErrorsHandler(httpPlugin.http, store);

    store.dispatch("userModule/init", context.user);
    store.dispatch("mainModule/load")

    const app = createApp(App)
        .use(store)
        .use(router)
        .use(csrfPlugin)
        .use(redirectPlugin)
        .use(formPlugin)
        .use(globalComponentsPlugin)
        .use(httpPlugin)
        .use(mdiVue, {
            icons: mdijs,
        });

    return { app, router };
};

