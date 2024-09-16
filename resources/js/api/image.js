export default (http) => ({

    async saveMainInfoImage(image) {
        let response = await image.post("/image/save-main-info", {
            errorStub: {
                text: "Не удалось загрузить картинку",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },

    async deleteMainInfoImage(id) {
        let response = await http.delete(`image/${id}/delete`, {
            errorStub: {
                text: "Не удалось удалить картинку",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },

    async getPhotos() {
        let response = await http.get("image/photo/index", {
            errorStub: {
                text: "Не удалось загрузить фотографии",
                importance: "danger",
                fallback: [],
            },
        });
        return response.data;
    },

    async addPhoto(photo) {
        let response = await photo.post("image/photo/store", {
            errorStub: {
                text: "Не удалось добавить фотографию",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
    
    async deletePhoto(id) {
        let response = await http.delete(`image/photo/${id}/delete`, {
            errorStub: {
                text: "Не удалось удалить фотографию",
                importance: "danger",
                fallback: false,
            },
        });
        return response.data;
    },
});
