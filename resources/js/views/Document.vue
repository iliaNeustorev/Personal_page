<template>
    <div class="container">
        <p class="title is-3 has-text-primary-dark mx-2">
            Список документов
        </p>
        <loading-component v-if="loading"/>
        <ol v-else-if="documents.length">
            <li v-for="document in documents" :key="document.id">
                {{ document.name }} 
                <a :href = "document.path" download>(Скачать) </a>
                <AppModeratorAccess>
                    <AppDeleteDocument :id="document.id" @reload-documents="getDocuments" />
                </AppModeratorAccess>
            </li>
        </ol>
        <div v-else>
           <i>Документов не найдено</i>
        </div>
        <AppModeratorAccess>
            <div class="box is-flex mt-5">
                <div class="media">
                    <div class="media-content">
                        <form-input-component
                            :form="form"
                            name="name"
                            label="Название документа"
                            placeholder="Введите название"
                        />
                        <form-file-component
                            :form="form"
                            name="file"
                            label="Добавить файл"
                            :object-validation="validationFile"
                            @validation-field="validationFieldFile"
                        />
                        <div class="field is-grouped is-grouped-centered mt-3">
                            <AppFormControls
                                @click="sendFile"
                                button-name="Загрузить"
                                class-name="button is-primary is-rounded"
                                :validation="validationFormFile"
                                :loading="loading"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AppModeratorAccess>
    </div>
</template>

<script>
import AppFormControls from "@/components/forms/buttons/Controls.vue";
import AppDeleteDocument from "@/components/admin/DeleteDocument.vue";
import { mapActions } from "vuex";
export default {
    components: { AppFormControls, AppDeleteDocument},
    data() {
        return {
            form: this.$vform.make({
                file: null,
            }),
            validationFile: {
                validValue: false,
                rule: /^.+\.pdf|docx|doc|csv|xls|xlsx|docm$/i,
                text: "Документ может иметь расширение pdf,docx,doc,csv,xls,xlsx,docm",
            },
            documents: [],
            loading: false,
        };
    },
    computed: {
        validationFormFile() {
            return this.validationFile.validValue && this.form.file !== null && this.form.name !== null && this.form.name !== undefined && this.form.name !== '';
        },
    },
    methods: {
        ...mapActions("alertModule", { addMessage: "add" }),
        async getDocuments() {
            this.loading = true;
            let result = await this.$api.document.getDocuments();
            if (result.success) {
                this.documents = result.documents;
            }
            this.loading = false;
        },
        validationFieldFile(elem) {
            this.validationFile.validValue = elem.currentRule;
        },
        async sendFile() {
            if (this.validationFormFile) {
                this.loading = true;
                try {
                    let result = await this.$api.document.addDocument(this.form);
                    if (result.success) {
                        await this.getDocuments();
                        this.addMessage({
                            text: "Документ успешно добавлен",
                            timeout: 2000,
                            importance: "success",
                        });
                    }
                    this.form.reset();
                } catch (e) {
                    this.addMessage({
                        text: "Ошибка.Документ не добавлен",
                        timeout: 5000,
                        importance: "danger",
                    });
                } finally {
                    this.loading = false;
                }
            }
        },
    },
    async created() {
        await this.getDocuments();
    },
};
</script>