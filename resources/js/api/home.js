export default (http) => ({
    async getMainInfo() {
        let response = await http.get("/main-info", {
            errorStub: {
                text: "Не удалось загрузить основную анкету",
                fallback: [],
            },
        });
        return response.data;
    },
    async createInfo(info) {
        let response = await info.post("/main-info/store");
        return response.data;
    },
    async updateInfo(infoId, data) {
        let response = await data.put(`/main-info/update/${infoId}`);
        return response.data;
    },
    async allProfiles() {
        let response = await http.get('/main-info/all', {
            errorStub: {
                text: "Не удалось сохранить информацию",
                fallback: false,
            },
        });
        return response.data;
    },
    async changeActive(id, active) {
        let response = await active.put(`/main-info/${id}/change-active`, {
            errorStub: {
                text: "Не удалось изменить активность",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
    async deleteProfile(id) {
        let response = await http.delete(`/main-info/${id}/delete`, {
            errorStub: {
                text: "Не удалось удалить анкету",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
    async oneInfo(id) {
        let response = await http.get(`/main-info/${id}/one`, {
            errorStub: {
                text: "Не удалось получить анкету",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
});
