<template>
    <div class="container">
        <div class="box">
            <div class="column is-half">
                <form-input-component
                    v-for="input in inputs"
                    :key="input.name"
                    :form="profile"
                    :name="input.name"
                    :label="input.label"
                    :placeholder="input.placeholder"
                    :object-validation="input.validation"
                    @validation-field="validationField($event, input.name)"
                />
                <div class="buttons is-right mt-4">
                    <AppFormControls
                        @click="editProfile"
                        button-name="Принять изменения"
                        :validation="validationForm"
                        :loading="loading"
                    />
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
                    name: "last_name",
                    label: "Фамилия",
                    placeholder: "Введите фамилию",
                    validation: {
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я]{2,29}$/,
                        text: "Фамилия должно начинаться с буквы и иметь от 3 до 30 символов",
                    },
                },
                {
                    name: "first_name",
                    label: "Имя",
                    placeholder: "Введите имя",
                    validation: {
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я]{2,29}$/,
                        text: "Имя должно начинаться с буквы иметь от 3 до 30 символов",
                    },
                },
                {
                    name: "middle_name",
                    label: "Отчество",
                    placeholder: "Введите отчество",
                    validation: {
                        validValue: false,
                        rule: /^[a-zA-Zа-яА-Я]{2,29}$/,
                        text: "Имя должно начинаться с буквы и иметь от 3 до 30 символов",
                    },
                },
                {
                    name: "email",
                    label: "Email",
                    placeholder: "Введите email",
                    validation: {
                        validValue: false,
                        rule: /^.{2,256}@.+\.[a-zA-Z]{2,256}$/,
                        text: "должен быть корректный email",
                    },
                },
                {
                    name: "phone",
                    label: "Номер телефона",
                    placeholder: "Введите номер телефона",
                    validation: {
                        validValue: false,
                        rule: /^\d*$/,
                        text: "должен содержать цифры от 5 до 50 символов",
                    },
                },
            ],
            profile: this.$vform.make({
                first_name: "",
                last_name: "",
                middle_name: "",
                phone: "",
                email: "",
            }),
            loading: false,
        };
    },
    computed: {
        ...mapGetters("userModule", ["user"]),
        validationForm() {
            return this.inputs.every((input) => input.validation.validValue);
        },
    },
    methods: {
        ...mapActions("userModule", ["getFull"]),
        ...mapActions("alertModule", { addMessage: "add" }),
        async editProfile() {
            this.loading = true;
            try {
                if (this.validationForm) {
                    let codeResponse = await this.$api.user.edit(this.profile);
                    if (codeResponse === 200) {
                        await this.getFull();
                        this.addMessage({
                            text: "Изменения приняты",
                            timeout: 2000,
                            importance: "success",
                        });
                    }
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
    },
    async created() {
        await this.getFull();
        Object.assign(this.profile, {
            first_name: this.user.first_name,
            middle_name: this.user.middle_name,
            last_name: this.user.last_name,
            phone: this.user.phone,
            email: this.user.email,
        });
    },
};
</script>
