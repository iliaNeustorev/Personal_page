export default {
    props: {
        form: { type: Object, required: true },
        name: { type: String, required: true },
        label: { type: String, required: false },
        placeholder: { type: String, required: false },
        className: { type: String, default: "" },
        iconName: { type: String, required: false },
        objectValidation: {
            type: Object,
            default: function () {
                return {
                    validValue: true,
                    rule: /^.*$/,
                    text: "",
                };
            },
        },
    },
    emits: ["validation-field"],
    computed: {
        validation() {
            return this.objectValidation && this.form[this.name] != null ? this.objectValidation.rule.test(this.form[this.name]) : true;
        },
        text() {
            return (
                this.objectValidation.text &&
                !this.emptyFieldClass &&
                !this.validation
            );
        },
        id() {
            return `field-${this.name}`;
        },
        hasError() {
            return this.form.errors.has(this.name);
        },
        emptyFieldClass() {
            return this.emptyField && !this.hasError && !this.validation;
        },
        emptyField() {
            return this.form[this.name] === null;
        },
        inputClasses() {
            return {
                "is-danger": ! this.validation || this.hasError,
                "is-success": this.validation,
                "is-link": this.emptyFieldClass,
            };
        },
        errorText() {
            return this.hasError ? this.form.errors.get(this.name) : null;
        },
        iconClass() {
            return { "has-icons-left": this.iconName };
        },
    },
    watch: {
        validation() {
            this.validationField();
        },
    },
    mounted() {
        this.validationField();
    },
    methods: {
        validationField() {
            return this.$emit("validation-field", {
                    currentRule: this.validation,
                }
            )},
        },
};
