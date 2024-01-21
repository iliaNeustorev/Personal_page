export default (homeApi) => {
    return {
        namespaced: true,

        state: {
            info: {},
        },
        getters: {
            info: (state) => state.info,
        },
        mutations: {
            setInfo(state, payload) {
                state.info = payload;
            },
        },
        actions: {
            async init(context, info) {
                context.commit("setInfo", info);
            },
            async load({ commit }) {
                let response = await homeApi.getMainInfo();
                if (response.info) {
                    commit("setInfo", response.info);
                }
            },
        },
    };
};
