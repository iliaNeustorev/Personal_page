<template>
  <loading-component v-if="loading" />
  <div v-else class="box">
    <form @submit.prevent="updateRole">
      <form-select-component name="roles" :form="changeUserRole" :options="roles" label="Выберите роли" :multiple="true"
        :user-size="3" :object-validation="validation" @validation-field="validationField" />
      <div class="column is-4">
        <button :disabled="!validationForm" class="button is-info is-rounded">
          Принять
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: { id: { type: Number, required: true } },
  emits: ["reload-users"],
  data() {
    return {
      loading: false,
      changeUserRole: this.$vform.make({
        roles: [],
      }),
      oldRoles: [],
      validation: {
        valid: false,
        rule: /^.+$/,
        text: "Выберите хотя бы одну роль",
      },
      roles: [],
    };
  },
  computed: {
    validationForm() {
      return (
        this.changeUserRole.roles.length != 0 &&
        JSON.stringify(this.oldRoles) !==
        JSON.stringify(this.changeUserRole.roles)
      );
    },
  },
  async created() {
    this.loading = true;
    let data = await this.$api.admin.getRoles(this.id);
    this.roles = data.AllRoles;
    this.oldRoles = data.userRoles;
    this.changeUserRole.roles = data.userRoles;
    this.loading = false;
  },
  methods: {
    ...mapActions("alertModule", { addMessage: "add" }),
    async updateRole() {
      if (this.validationForm) {
        try {
          await this.$api.admin.updateRoles(this.id, this.changeUserRole);
          this.$emit("reload-users");
        } catch (e) {
          this.addMessage({
            text: "Не удалось изменить роль. Ошибка сервера",
            timeout: 5000,
            importance: "warning",
          });
        }
      }
    },
    validationField(elem) {
      if (this.validation[elem.name] != undefined) {
        this.validation[elem.name].valid = elem.currentRule;
      }
    },
  },
};
</script>
