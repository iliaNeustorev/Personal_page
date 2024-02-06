<template>
   <div class="container">
    <h2 class="is-size-2">Редактирование анкеты</h2>
        <div class="box">
            <div class="column is-half">
                <form-input-component
                    v-for="input in inputs"
                    :key="input.name"
                    :form="newInfo"
                    :name="input.name"
                    :label="input.label"
                    :placeholder="input.placeholder"
                    :object-validation="input.validation"
                    @validation-field="validationField($event, input.name)"
                />
                <div class="mt-5" v-show="!showPrincipes">
                    <label class="label is-clickable" title="Показать принципы работы" @click="showPrincipes = true">Принципы работы</label>
                </div>
                <transition name="fade">
                    <div class="field mt-5" v-show="showPrincipes">
                        <div class="is-flex is-flex-direction-row is-flex-wrap-wrap is-justify-content-space-between is-align-content-center mb-2">
                            <label class="label is-clickable" title="Скрыть принципы работы" @click="showPrincipes = false">Принципы работы</label>
                            <a class="button is-info is-light" @click="addPrincipeWork">
                                Добавить новый принцип
                            </a>
                        </div>
                        <div class="control" v-if="principeWork.length">
                            <div class="field has-addons" v-for="(, key) of principeWork" :key="key">
                                <input
                                    ref="first"
                                    class="input"
                                    type="text"
                                    v-model.trim="principeWork[key]"
                                />
                                <div class="control">
                                    <a class="button is-danger" @click="deletePrincipeWork(key)" title="Удалить прицнип">
                                        X
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            Принципы не указаны
                        </div>
                    </div>
                </transition>
                <div class="mt-5" v-show="!showQualities">
                    <label class="label is-clickable" title="Показать личные качества" @click="showQualities = true">Личные качества</label>
                </div>
                <transition name="fade">
                    <div class="field mt-5" v-show="showQualities">
                        <div class="is-flex is-flex-direction-row is-flex-wrap-wrap is-justify-content-space-between is-align-content-center mb-2">
                            <label class="label is-clickable" title="Скрыть личные качества" @click="showQualities = false">Личные качества</label>
                            <a class="button is-info is-light" @click="addPersonalQuality">
                                Добавить новое личное качество
                            </a>
                        </div>
                        <div class="control" v-if="personalQuality.length">
                            <div class="field has-addons" v-for="(, key) of personalQuality" :key="key">
                                <input
                                    ref="two"
                                    class="input"
                                    type="text"
                                    v-model.trim="personalQuality[key]"
                                />
                                <div class="control">
                                    <a class="button is-danger" @click="deletePersonalQuality(key)" title="Удалить качество">
                                        X
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            Качества не указаны
                        </div>
                    </div>
                </transition>
                <div class="columns is-centered mt-4">
                    <figure class="column is-6 image is-fullwidth">
                        <img v-if="data.image != null" class="main-image" :src="data.image.url" alt="Фото" />
                        <img v-else src="@/assets/nouserpicture.png" alt="Фото" />
                    </figure>
                </div>
                <div v-if="$route.params.id != 0" class="is-flex is-justify-content-center">
                    <div class="media">
                        <div class="media-content">
                            <form-file-component
                                :form="file"
                                name="picture"
                                label="Загрузить"
                                :object-validation="validationFile"
                                @validation-field="validationFieldFile"
                            />
                            <div class="field is-grouped is-grouped-centered mt-3">
                                <AppFormControls
                                    @click="sendFile"
                                    button-name="OK"
                                    class-name="button is-primary is-rounded"
                                    :validation="validationFormFile"
                                    :loading="loading"
                                />
                                <AppFormControls
                                    @click="deleteAvatar"
                                    button-name="Удалить фото"
                                    class-name="button is-danger is-rounded"
                                    :validation="userHasPicture"
                                    :icon-show="false"
                                    :loading="loading"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buttons is-right mt-4">
                    <AppFormControls
                        @click="editInfo"
                        button-name="Сохранить"
                        :validation="validationForm && validationFormUpdate"
                        :loading="loading"
                    />
                    <AppFormControls
                        @click="createInfo"
                        class-name="is-info is-light is-medium"
                        button-name="Создать новую"
                        :validation="validationForm"
                        :loading="loading"
                    />
                    <router-link :to="{ name: 'all-profiles' }" class="button is-success is-medium">Смотреть все анкеты</router-link>
                    <AppButtonBack />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AppFormControls from "@/components/forms/buttons/Controls.vue";
import { mapGetters, mapActions } from "vuex";
export default {
    components: { AppFormControls },
    data() {
        return {
            inputs: [
                {
                    name: "education",
                    label: "Образование",
                    placeholder: "Ввести образование",
                    validation: {
                        required: true,
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я\d\s]+$/,
                        text: "Поле может содержать буквы и цифры",
                    },
                },
                {
                    name: "teaching_experience",
                    label: "Педагогический стаж",
                    placeholder: "Введите педагогический стаж",
                    validation: {
                        required: true,
                        validValue: false,
                        rule: /^[\d]{1,10000}$/,
                        text: "Поле может содержать цифры до 4000 символов",
                    },
                },
                {
                    name: "teaching_category",
                    label: "Категория",
                    placeholder: "Введите категорию",
                    validation: {
                        required: true,
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я\d]{1,10000}$/,
                        text: "Поле может содержать буквы и цифры до 4000 символов",
                    },
                },
                {
                    name: "credo",
                    label: "Кредо",
                    placeholder: "Введите жизненое кредо",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^[a-zA-Zа-яА-Я\d\s]*$/,
                        text: "Поле может содержать цифры и буквы",
                    },
                },
                {
                    name: "personal_slogan",
                    label: "Персональный слоган",
                    placeholder: "Введите профессиональный слоган",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^[a-zA-Zа-яА-Я\d\s]*$/,
                        text: "Поле может содержать цифры и буквы",
                    },
                },
                {
                    name: "quotes",
                    label: "Цитата",
                    placeholder: "Введите цитату",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^[a-zA-Zа-яА-Я\d\s]*$/,
                        text: "Поле может содержать цифры и буквы",
                    },
                },
                {
                    name: "personal_email_teacher",
                    label: "Персональный email для связи",
                    placeholder: "Введите email",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^(|[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,})$/,
                        text: "Должен быть корректный email",
                    },
                },
                {
                    name: "kindergarten_in_place_work",
                    label: "Текущее место работы (детский сад)",
                    placeholder: "Введите название детского сада",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^[a-zA-Zа-яА-Я\d\s.'"]+$/,
                        text: "Поле может содержать цифры и буквы",
                    },
                },
                {
                    name: "address_kindergarten",
                    label: "Адрес детского сада",
                    placeholder: "Введите адрес детского сада",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^[a-zA-Zа-яА-Я\d\s.'"]*$/,
                        text: "Поле может содержать цифры и буквы",
                    },
                },
                {
                    name: "phone_kindergarten",
                    label: "Телефон детского сада",
                    placeholder: "Введите телефон детского сада",
                    validation: {
                        required: false,
                        validValue: true,
                        rule: /^[\d]*$/,
                        text: "Поле может содержать цифры",
                    },
                },
            ],
            newInfo: this.$vform.make({
                quotes: null,
                education: null, 
                teaching_experience: null,
                teaching_category: null,
                personal_slogan: null,
                credo: null,
                personal_email_teacher: null,
                kindergarten_in_place_work: null,
                address_kindergarten: null, 
                phone_kindergarten: null
            }),
            file: this.$vform.make({
                id: this.$route.params.id,
                picture: null,
            }),
            validationFile: {
                validValue: false,
                rule: /^.+\.jpeg|jpg|png|bmp$/i,
                text: "Картинка должна иметь расширение jpeg,jpg,png,bmp",
            },
            loading: false,
            loadingInfo: true,
            data: [],
            principeWork: [],
            personalQuality: [],
            showPrincipes: false,
            showQualities: false
        };
    },
    computed: {
        ...mapGetters("mainModule", ["info"]),
        validationForm() {
            return this.inputs.every(input => input.validation.validValue);
        },
        validationFormUpdate() {
            return this.$route.params.id != 0;
        },
        validationFormFile() {
            return this.validationFile.validValue && this.file.picture != null && this.$route.params.id != 0;
        },
        userHasPicture() {
            return this.info.image != null;
        },
    },
    methods: {
        ...mapActions("mainModule", ["load"]),
        ...mapActions("alertModule", { addMessage: "add" }),
        async editInfo() {
            this.loading = true;
            try {
                if (this.validationForm) {
                    Object.assign(this.newInfo, {
                        working_principles: this.principeWork,
                        personal_qualities: this.personalQuality
                    });
                    let result = await this.$api.home.updateInfo(this.$route.params.id, this.newInfo);
                    await this.loadOne();
                    if (this.$route.params.id == this.info.id) {
                        await this.load();
                    }
                    if (result.success) {
                        this.addMessage({
                            text: "Анкета успешно изменена",
                            timeout: 3000,
                            importance: "success",
                        });
                    };
                }
            } catch (e) {
            } finally {
                this.loading = false;
            }
        },
        async createInfo() {
            this.loading = true;
            try {
                if (this.validationForm) {
                    if (this.principeWork.length || this.personalQuality.length) {
                        Object.assign(this.newInfo, {
                            working_principles: this.principeWork,
                            personal_qualities: this.personalQuality
                        });
                    }
                    let result = await this.$api.home.createInfo(this.newInfo);
                    if (result.success) {
                        await this.load();
                        await this.addMessage({
                            text: "Новая анкета создана",
                            timeout: 3000,
                            importance: "primary",
                        });
                    };
                }
            } catch (e) {
            } finally {
                this.loading = false;
            }
        },
        validationField(elem, name) {
            let input = this.inputs.find((input) => input.name === name);
            if (input) {
                input.validation.validValue = elem.currentRule;
            }
        },
        validationFieldFile(elem) {
            this.validationFile.validValue = elem.currentRule;
        },
        deletePrincipeWork(key) {
            this.principeWork.splice(key, 1)
        },
        addPrincipeWork() {
            this.principeWork.push('')
        },
        async loadOne() {
            if (this.$route.params.id != 0) {
                return await this.$api.home.oneInfo(this.$route.params.id)
            }
        },
        addPersonalQuality() {
            this.personalQuality.push('')
        },
        deletePersonalQuality(key) {
            this.personalQuality.splice(key, 1)
        },
        async sendFile() {
            if (this.validationFormFile) {
                this.loading = true;
                try {
                    let result = await this.$api.image.saveMainInfoImage(this.file);
                    if (result.success) {
                        let newData = await this.loadOne();
                        this.data = newData.data;
                        this.addMessage({
                            text: "Фото успешно обновлено",
                            timeout: 2000,
                            importance: "success",
                        });
                    }
                    if (this.$route.params.id == this.info.id) {
                        await this.load();
                    }
                    
                    this.file.reset();
                } catch (e) {
                    console.log(e)
                    this.addMessage({
                        text: "Ошибка.Фото не изменено",
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
                let result = await this.$api.image.deleteMainInfoImage(this.$route.params.id);
                if (result.success) {
                    let newData = await this.loadOne();
                    this.data = newData.data;
                    this.addMessage({
                        text: "Фото удалено",
                        timeout: 2000,
                        importance: "success",
                    });
                }
                if (this.$route.params.id == this.info.id) {
                    await this.load();
                }
                this.loading = false;
            }
        },
    },
    async created() {
        let result = await this.loadOne()
        if (this.$route.params.id != 0) {
            this.data = result.data;
        }
        if (this.$route.params.id != 0 && this.data != []) {
            Object.assign(this.newInfo, {
                quotes: this.data.quotes,
                education: this.data.education, 
                teaching_experience: this.data.teaching_experience,
                teaching_category: this.data.teaching_category,
                personal_slogan: this.data.personal_slogan,
                credo: this.data.credo,
                personal_email_teacher: this.data.personal_email_teacher,
                kindergarten_in_place_work: this.data.kindergarten_in_place_work,
                address_kindergarten: this.data.address_kindergarten, 
                phone_kindergarten: this.data.phone_kindergarten
            });
            this.principeWork = this.data.working_principles ?? []
            this.personalQuality = this.data.personal_qualities ?? []
        }
    },
};
</script>

<style scoped>
.main-image {
    border-radius: 20px;
}
.fade-enter-from {
    opacity: 0;
}

.fade-enter-active {
    transition: opacity 0.5s;
}
</style>