import axios from "axios";
import createHomeApi from "@/api/home";
import createUserApi from "@/api/user";
import createImageApi from "@/api/image";
import createDocumentApi from "@/api/document";
import { inject } from "vue";

export default () => {
    const http = axios.create({
        baseURL: "/api/",
        timeout: 10000,
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    });
    const api = {
        home: createHomeApi(http),
        user: createUserApi(http),
        image: createImageApi(http),
        document: createDocumentApi(http)
    };
    function install(app) {
        app.config.globalProperties["$api"] = api;
        app.provide("$api", api);
    }
    return { http, api, install };
};

export function useApi(...names) {
    let api = inject("$api");
    return names.map((name) => api[name]);
}
