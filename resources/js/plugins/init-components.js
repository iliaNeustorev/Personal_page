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
import Pagination from "@/components/support/Pagination.vue";
import BlockAccess from "@/components/accesses/Blocked.vue";
import VerifyAccess from "@/components/accesses/Verify.vue";
import FormSelect from "@/components/forms/FormSelect.vue";

export default () => ({
    install(app) {
        app.component("form-input-component", FormInput);
        app.component("form-radio-component", FormRadio);
        app.component("form-checkbox-component", FormCheckbox);
        app.component("form-file-component", FormFile);
        app.component("form-textarea-component", FormTextarea);
        app.component("form-select-component", FormSelect);
        app.component("AppAuthAccess", AuthAccess);
        app.component("AppDevAccess", DevAccess);
        app.component("AppModeratorAccess", ModeratorAccess);
        app.component("AppNotification", Notification);
        app.component("AppButtonBack", ButtonBack);
        app.component("loading-component", Loading);
        app.component("pagination-component", Pagination);
        app.component("AppBlockAccess", BlockAccess);
        app.component("AppVerifyAccess", VerifyAccess);
    },
});
