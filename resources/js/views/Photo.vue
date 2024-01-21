<template>
    <div class="container">
        <p class="title is-3 has-text-primary-dark mx-2">
            Фотографии
        </p>
        <loading-component v-if="loading"/>
        <div v-else :class="$style.cards">
            <div v-if="!photos.length"><i>Нет фотографий</i></div>
            <div
                v-for="photo in photos"
                :key="photo.id"
                class="card p-2"
            >
                <div class="card-image">
                    <figure class="image is-square">
                        <img class="is-clickable" v-if="photo.image != null" :src="photo.image.url" alt="Фото" @click="showImageModal(photo.image.url)" title="Подробнее">
                        <img v-else src="@/assets/nopicture.jpg" alt="Фото">
                    </figure>
                </div>
                <div class="card-content">
                    <div class="content">
                        {{ photo.caption }}
                        <br>
                        <p>{{ photo.created_at }}</p>
                    </div>
                </div>
                <AppModeratorAccess>
                    <footer class="card-footer">
                        <AppDeletePhoto :id="photo.id" @reload-photo="getPhotos"/>
                    </footer>
                </AppModeratorAccess>
            </div>
        </div>
        <AppModalBulma ref="modal">
            <p class="image is-fullwidth">
                <img :src="imagePath" />
            </p>
        </AppModalBulma>
        <AppModeratorAccess>
            <div class="is-flex mt-5">
                <div class="media">
                    <div class="media-content">
                        <form-file-component
                            :form="file"
                            name="picture"
                            label="Загрузить"
                            :object-validation="validationFile"
                            @validation-field="validationFieldFile"
                        />
                        <form-textarea-component
                            :form="file"
                            name="caption"
                            label="Описание"
                            placeholder="Введите описание фотографии(если нужно)"
                        />
                        <div class="field is-grouped is-grouped-centered mt-3">
                            <AppFormControls
                                @click="sendFile"
                                button-name="Добавить фотографию"
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
import AppDeletePhoto from "@/components/admin/DeletePhoto.vue";
import AppModalBulma from "@/components/modal/Bulma.vue";
import { mapActions } from "vuex";
export default {
    components: { AppFormControls, AppDeletePhoto, AppModalBulma },
    data() {
        return {
            file: this.$vform.make({
                picture: null,
            }),
            validationFile: {
                validValue: false,
                rule: /^.+\.jpeg|jpg|png|bmp$/i,
                text: "Картинка должна иметь расширение jpeg,jpg,png,bmp",
            },
            photos: [],
            loading: false,
            imagePath: null
        };
    },
    computed: {
        validationFormFile() {
            return this.validationFile.validValue && this.file.picture != null;
        },
    },
    methods: {
        ...mapActions("alertModule", { addMessage: "add" }),
        async getPhotos() {
            this.loading = true;
            let result = await this.$api.image.getPhotos();
            if (result.success) {
                this.photos = result.photos;
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
                    let result = await this.$api.image.addPhoto(this.file);
                    if (result.success) {
                        await this.getPhotos();
                        this.addMessage({
                            text: "Фотография успешно добалена",
                            timeout: 2000,
                            importance: "success",
                        });
                    }
                    this.file.reset();
                } catch (e) {
                    this.addMessage({
                        text: "Ошибка.Фотография не добавлена",
                        timeout: 5000,
                        importance: "danger",
                    });
                } finally {
                    this.loading = false;
                }
            }
        },
        showImageModal(imagePath) {
            this.$refs.modal.show = true;
            this.imagePath = imagePath;
        },
        cancelImageModal() {
            this.$refs.modal.show = false;
        },
    },
    async created() {
        await this.getPhotos();
    },
};
</script>

<style module>
.cards {
    display: grid;
    gap: 10px;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
}
.cards a {
    color: #000;
}
</style>
