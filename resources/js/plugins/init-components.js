import FormInput from "@/components/forms/FormInput.vue";
import FormRadio from "@/components/forms/FormRadio.vue";
import FormCheckbox from "@/components/forms/FormCheckbox.vue";
import FormFile from "@/components/forms/FormFile.vue";
import Loading from "@/components/support/Loading.vue";
import AuthAccess from "@/components/accesses/Auth.vue";
import DevAccess from "@/components/accesses/Dev.vue";
import ModeratorAccess from "@/components/accesses/Moderator.vue";
import Notification from "@/components/support/Notification.vue";
import ButtonBack from "@/components/forms/buttons/Back.vue";
import FormTextarea from "@/components/forms/FormTextarea.vue";

export default () => ({
    install(app) {
        app.component("form-input-component", FormInput);
        app.component("form-radio-component", FormRadio);
        app.component("form-checkbox-component", FormCheckbox);
        app.component("form-file-component", FormFile);
        app.component("form-textarea-component", FormTextarea);
        app.component("AppAuthAccess", AuthAccess);
        app.component("AppDevAccess", DevAccess);
        app.component("AppModeratorAccess", ModeratorAccess);
        app.component("AppNotification", Notification);
        app.component("AppButtonBack", ButtonBack);
        app.component("loading-component", Loading);
    },
});
