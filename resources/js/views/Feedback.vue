<template>
<div class="container">
    <p class="title is-3 has-text-primary-dark mx-2">
        Обратная связь
    </p>
    <div class="column mt-1 mx-1">
        <form-input-component
            v-for="input in inputs"
            :key="input.name"
            :form="feedback"
            :name="input.name"
            :label="input.label"
            :placeholder="input.placeholder"
            :object-validation="input.validation"
            @validation-field="validationField($event, input.name)"
        />
        <form-textarea-component
            :form="feedback"
            name="question"
            label="Текст"
            placeholder="Введите текст"
        />
        <AppFormControls
            @click="createFeedback"
            button-name="Отправить"
            class-name="button is-primary is-rounded"
            :validation="validationForm"
            :loading="loading"
        />
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
                    name: "name",
                    label: "Имя",
                    placeholder: "Введите имя",
                    validation: {
                        required: true,
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я\d\s]+$/,
                        text: "Поле может содержать буквы и цифры",
                    },
                },
                {
                    name: "email",
                    label: "Email",
                    placeholder: "Введите email",
                    validation: {
                        required: true,
                        validValue: false,
                        rule: /^.{2,256}@.+\.[a-zA-Z]{2,256}$/,
                        text: "должен быть корректный email",
                    },
                },
                {
                    name: "question_subject",
                    label: "Тема",
                    placeholder: "Введите тему",
                    validation: {
                        required: false,
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я\d\s]*$/,
                        text: "Поле может содержать буквы и цифры",
                    },
                },
            ],
            feedback: this.$vform.make({
                name: null,
                email: null, 
                question_subject: null,
                question: null,
            }),
            loading: false,
            loadingInfo: true,
            data: [],
        };
    },
    computed: {
        ...mapGetters("mainModule", ["info"]),
        validationForm() {
            return this.inputs.every(input => input.validation.validValue);
        },
    },
    methods: {
        ...mapActions("mainModule", ["load"]),
        ...mapActions("alertModule", { addMessage: "add" }),
        async createFeedback() {
            this.loading = true;
            try {
                if (this.validationForm) {
                    let result = await this.$api.feedback.addFeedback(this.feedback);
                    if (result.success) {
                        await this.load();
                        await this.addMessage({
                            text: "Отзыв отправлен",
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
        validationField(elem, name) {
            let input = this.inputs.find((input) => input.name === name);
            if (input) {
                input.validation.validValue = elem.currentRule;
            }
        },
        validationFieldFile(elem) {
            this.validationFile.validValue = elem.currentRule;
        },
    }
}
</script>