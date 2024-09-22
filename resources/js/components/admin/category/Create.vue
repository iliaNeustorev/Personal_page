<template>
    <button @click="showModal" class="button is-large is-rounded is-info is-outlined">
        Новая категория
    </button>
    <modal-window-component ref="modal">
        <p>Создать новую категорию</p>
        <template v-slot:footer>
            <div class="buttons is-centered">
                <div class="column">
                    <form-input-component v-for="input in inputs" :key="input.name" :form="category" :name="input.name"
                        :label="input.label" :placeholder="input.placeholder" :object-validation="input.validation"
                        @validation-field="validationField($event, input.name)" />
                    <div class="field is-grouped mt-4">
                        <AppFormControls @click="send" button-name="Создать" :validation="validationForm"
                            :loading="loading" />
                        <button class="button is-warning is-medium is-light is-outlined" @click="cancelSend">
                            Отмена
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </modal-window-component>
</template>

<script>
import AppModalWindow from "@/components/modal/Window.vue";
import AppFormControls from "@/components/forms/buttons/Controls.vue";
import { mapActions } from "vuex";
export default {
    components: { "modal-window-component": AppModalWindow, AppFormControls },
    emits: ["reload-categories"],
    data() {
        return {
            inputs: [
                {
                    name: "name",
                    label: "Имя",
                    placeholder: "Введите имя",
                    validation: {
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я]{2,29}$/,
                        text: "Имя должно начинаться с буквы и иметь от 3 до 30 символов",
                    },
                },
                {
                    name: "sort",
                    label: "Сортировка",
                    placeholder: "Введите сортировку",
                    validation: {
                        validValue: false,
                        rule: /^\d+$/,
                        text: "Поле должно быть числовым",
                    },
                },
                {
                    name: "type",
                    label: "Тип",
                    placeholder: "Выберите тип",
                    validation: {
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я]{2,29}$/,
                        text: "Имя должно начинаться с буквы и иметь от 3 до 30 символов",
                    },
                },
            ],
            category: this.$vform.make({
                name: null,
                sort: null,
                type: null,
            }),
            loading: false,
        };
    },
    computed: {
        validationForm() {
            return this.inputs.every((input) => input.validation.validValue);
        },
    },
    methods: {
        ...mapActions("alertModule", { addMessage: "add" }),
        showModal() {
            this.$refs.modal.show = true;
        },
        cancelSend() {
            this.$refs.modal.show = false;
        },
        async send() {
            //try {
            let result = await this.$api.admin.categories.store(this.category);
            if (result.success) {
                await this.addMessage({
                    text: "Новая категория создана",
                    timeout: 3000,
                    importance: "success",
                });
                this.$emit("reload-categories");
            }
            this.$refs.modal.show = false;
            // } catch (e) {
            //     this.$refs.modal.show = true;
            // }
        },
        validationField(elem, name) {
            let input = this.inputs.find((input) => input.name === name);
            if (input) {
                input.validation.validValue = elem.currentRule;
            }
        },
    },
};
</script>