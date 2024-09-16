<template>
  <i :class="classRoles">{{ role.description }}</i>
</template>

<script>
export default {
  props: { role: { type: Object, required: true } },
  computed: {
    classRoles() {
      return {
        "has-text-grey": this.role.name == "user",
        "has-text-primary-dark": this.role.name == "admin",
        "has-text-info": this.role.name == "moderator",
        "has-text-primary": this.role.name == "dev",
      };
    },
  },
};
</script>
