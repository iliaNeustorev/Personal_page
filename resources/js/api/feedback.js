export default (http) => ({
    
    async index() {
        let response = await http.get("feedback", {
            errorStub: {
                text: "Не удалось загрузить отзывы",
                fallback: [],
            },
        });
        return response.data;
    },
    async addFeedback(feedback) {
        let response = await feedback.post("feedback/store");
        return response.data;
    },
});