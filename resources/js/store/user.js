export default (userApi) => {
    return {
        namespaced: true,

        state: {
            user: {},
        },
        getters: {
            user: (state) => state.user,
            isAuth: (state) => state.user?.first_name != undefined,
            isDev: (state) => state.user?.roles.includes('dev'),
            isModerator: (state) => ['dev', 'admin', 'moderator'].some(value => state.user?.roles?.includes(value))
        },
        mutations: {
            setUser(state, payload) {
                state.user = payload;
            },
            updateUser(state, payload) {
                Object.assign(state.user, payload);
            },
        },
        actions: {
            async init(context, user) {
                context.commit("setUser", user);
            },
            async getFull({ commit }) {
                let response = await userApi.get();
                if (response) {
                    commit("updateUser", response);
                }
            },
        },
    };
};
