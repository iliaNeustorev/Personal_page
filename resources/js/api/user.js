export default (http) => ({

    async get() {
        let response = await http.get("/get", {
            errorStub: {
                text: "Ошибка при проверке аутентификации",
                fallback: { auth: false },
                importance: "warning",
            },
        });
        return response.data;
    },

    async changePassword(form) {
        let response = await form.put("/profile/changePassword");
        return response.data;
    },

    async edit(profile) {
        let response = await profile.put("/profile/edit", {
            errorStub: {
                text: "Изменения не приняты. Произошла ошибка",
                fallback: false,
                timeout: 3000,
                importance: "danger",
            },
        });
        return response.status;
    },

    async deleteProfile(id) {
        let response = await http.delete(`/profile/${id}`, {
            errorStub: {
                text: "Не удалось удалить профиль",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },

    async changeAvatar(file) {
        await file.post("/profile/changeAvatar");
    },
    
    async deleteAvatar() {
        await http.put(
            "/profile/deleteAvatar",
            {},
            {
                errorStub: {
                    text: "Ошибка.Удалить аватар не удалось",
                    fallback: false,
                    importance: "danger",
                },
            }
        );
    },
});
