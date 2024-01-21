<template>
  <div v-if="show" class="modal addModal" @click="closeModal">
    <div class="modal-background"></div>
    <div class="modal-content mt-5">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
    };
  },
  methods: {
    closeModal() {
      this.show = false;
    },
  },
};
</script>

<style scoped>
.addModal {
  display: block;
}
</style>
