import { createStore } from "vuex";
import createUserModule from "./user";
import createAlertModule from "./alerts";
import createMainModule from "./main";

export default (api) =>
    createStore({
        modules: {
            userModule: createUserModule(api.user),
            alertModule: createAlertModule(),
            mainModule: createMainModule(api.home)
        },
        strict: process.env.NODE_ENV !== "production",
    });
