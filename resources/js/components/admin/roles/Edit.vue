<template>
  <div class="dropdown is-active">
    <div class="dropdown-trigger">
      <button @click="toggle = !toggle" class="button" aria-haspopup="true" aria-controls="dropdown-menu2">
        <span>Изменить роль</span>
        <span class="icon is-small">
          <mdicon name="menu-down-outline" />
        </span>
      </button>
    </div>
  </div>
  <div v-if="toggle" id="dropdown-menu2">
    <AppUpdateRole :id="id" @reload-users="reloadUsers" />
  </div>
</template>

<script>
import AppUpdateRole from "@/components/admin/roles/Update.vue";

export default {
  components: {
    AppUpdateRole,
  },
  props: { id: { type: Number, required: true } },
  emits: ["reload-users"],
  data() {
    return {
      toggle: false,
    };
  },
  methods: {
    reloadUsers() {
      this.toggle = false;
      this.$emit("reload-users");
    },
  },
};
</script>
