export default (http) => ({

    async getDocuments() {
        let response = await http.get("document/index", {
            errorStub: {
                text: "Не удалось загрузить документы",
                importance: "danger",
                fallback: [],
            },
        });
        return response.data;
    },

    async addDocument(document) {
        let response = await document.post("document/store", {
            errorStub: {
                text: "Не удалось добавить документ",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
    
    async deleteDocument(id) {
        let response = await http.delete(`document/${id}/destroy`, {
            errorStub: {
                text: "Не удалось удалить документ",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
});