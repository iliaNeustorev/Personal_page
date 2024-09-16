<template>
  <form-checkbox-component @click="showModal" :form="active" :ordinal-number="id" name="check" />
  <modal-window-component ref="modal">
    <p>Вы действительно хотите изменить статус анкеты?</p>
    <template v-slot:footer>
      <div class="buttons is-centered">
        <button class="button is-warning is-light is-outlined" @click="cancelSendCheck">
          Отмена
        </button>
        <button class="button is-success is-light is-outlined" @click="sendCheck">
          OK
        </button>
      </div>
    </template>
  </modal-window-component>
</template>

<script>
import AppModalWindow from "@/components/modal/Window.vue";
import { mapActions } from "vuex";
export default {
  components: { "modal-window-component": AppModalWindow },
  emits: ["reload-info"],
  props: {
    id: { type: Number, required: true },
    currentState: { type: Boolean, required: true },
  },
  data() {
    return {
      active: this.$vform.make({
        check: this.currentState,
      }),
    };
  },
  watch: {
    currentState(newVal) {
      this.active.check = newVal;
    }
  },
  methods: {
    ...mapActions("alertModule", { addMessage: "add" }),
    showModal() {
      this.$refs.modal.show = true;
    },
    cancelSendCheck() {
      this.$refs.modal.show = false;
      this.active.check = this.currentState;
    },
    async sendCheck() {
      try {
        let result = await this.$api.home.changeActive(this.id, this.active);
        if (result.success) {
          await this.addMessage({
            text: "Активная анкета изменена",
            timeout: 3000,
            importance: "success",
          });
          this.$emit("reload-info");
        }
      } catch (e) {
        this.active.check = this.currentState;
      } finally {
        this.$refs.modal.show = false;
      }
    },
  },
};
</script>
