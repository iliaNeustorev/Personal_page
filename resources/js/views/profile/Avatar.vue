<template>
    <div class="card column is-half">
        <div class="card-image">
            <figure class="image is-square">
                <img v-if="!user.img" src="@/assets/nouserpicture.png" />
                <img v-else :src="user.img" alt="Аватар" />
            </figure>
        </div>
        <div class="card-content is-flex is-justify-content-center">
            <div class="media">
                <div class="media-content">
                    <form-file-component :form="file" name="picture" label="Загрузить" :object-validation="validation"
                        @validation-field="validationField" />
                    <div class="field is-grouped is-grouped-centered mt-3">
                        <AppFormControls @click="sendForm" button-name="OK" class-name="button is-primary is-rounded"
                            :validation="validationForm" :loading="loading" />
                        <AppFormControls @click="deleteAvatar" button-name="Удалить аватар"
                            class-name="button is-danger is-rounded" :validation="userHasPicture" :icon-show="false"
                            :loading="loading" />
                        <AppButtonBack class-name="is-info is-rounded" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import AppFormControls from "@/components/forms/buttons/Controls.vue";
export default {
    components: { AppFormControls },
    data() {
        return {
            file: this.$vform.make({
                picture: null,
            }),
            validation: {
                validValue: false,
                rule: /^.+\.jpeg|jpg|png|bmp$/,
                text: "Картинка должна иметь расширение jpeg,jpg,png,bmp",
            },
            loading: false,
        };
    },
    computed: {
        ...mapGetters("userModule", ["user"]),
        userHasPicture() {
            return this.user.img != null;
        },
        validationForm() {
            return this.validation.validValue && this.file.picture != null;
        },
    },
    methods: {
        ...mapActions("userModule", ["getFull"]),
        ...mapActions("alertModule", { addMessage: "add" }),
        validationField(elem) {
            this.validation.validValue = elem.currentRule;
        },
        async sendForm() {
            if (this.validationForm) {
                this.loading = true;
                try {
                    this.file.update({ _method: "PUT" });
                    await this.$api.user.changeAvatar(this.file);
                    this.file.reset();
                    this.getFull();
                } catch (e) {
                    this.addMessage({
                        text: "Ошибка.Аватар не изменен",
                        timeout: 5000,
                        importance: "danger",
                    });
                } finally {
                    this.loading = false;
                }
            }
        },
        async deleteAvatar() {
            if (this.userHasPicture) {
                this.loading = true;
                await this.$api.user.deleteAvatar();
                await this.addMessage({
                    text: "Аватар удален",
                    timeout: 2000,
                    importance: "success",
                });
                await this.getFull();
                this.loading = false;
            }
        },
    },
};
</script>
