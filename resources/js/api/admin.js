export default (http) => ({

    async testRoute() {
        let response = await http.get("admin/test");
        return response.data;
    },
    
    async getUsers(params = []) {
        let response = await http.get("admin/users", {
            errorStub: {
                text: "Не удалось загрузить список пользователей",
                importance: "danger",
                fallback: [],
            },
        });
        return response.data;
    },

    async blockedUser($userid, form) {
        let response = await form.put(`admin/${$userid}/blocked-user`, {
            errorStub: {
                text: form?.check ? "Не удалось заблокировать пользователя" : "Не удалось разблокировать пользователя",
                importance: "danger",
                fallback: [],
            },
        });
        return response.data;
    },

    async updateRoles(id, form) {
        let response = await form.put(`admin/${id}/update-roles`);
        return response.data;
    },
    
    async getRoles(id) {
        let response = await http.get(`admin/${id}/get-roles`, {
          errorStub: {
            text: "Не удалось загрузить роли. Ошибка сервера",
            fallback: { AllRoles: { data: {} }, userRoles: { data: {} } },
          },
        });
        return response.data;
    },

    categories: {

        async index(params = []) {
            let response = await http.get("admin/categories", {
                errorStub: {
                    text: "Не удалось загрузить список категорий",
                    importance: "danger",
                    fallback: { categories: [], types: [] }
                },
            });
            return response.data;
        },

        async store(form) {
            let response = await form.post(`admin/categories`);
            return response.data;
        },
    }
});