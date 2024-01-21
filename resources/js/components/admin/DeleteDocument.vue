<template>
    <button title="Удалить документ" @click="showModal" class="button is-small is-danger is-rounded">
       X
   </button>
   <modal-window-component ref="modal"
     ><p>Вы действительно хотите удалить документ?</p>
     <template v-slot:footer>
       <div class="buttons is-centered">
         <button
           class="button is-warning is-light is-outlined"
           @click="cancelSendCheck"
         >
           Отмена
         </button>
         <button
           class="button is-success is-light is-outlined"
           @click="sendCheck"
         >
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
   emits: ["reload-documents"],
   props: {
     id: { type: Number, required: true },
   },
   methods: {
     ...mapActions("alertModule", { addMessage: "add" }),
     showModal() {
       this.$refs.modal.show = true;
     },
     cancelSendCheck() {
       this.$refs.modal.show = false;
     },
     async sendCheck() {
       try {
         let result = await this.$api.document.deleteDocument(this.id);
         if (result.success) {
           await this.addMessage({
                text: "Документ успешно удален",
                timeout: 3000,
                importance: "success",
            });
           this.$emit("reload-documents");
         }
       } catch (e) {
         
       } finally {
         this.$refs.modal.show = false;
       }
     },
   },
 };
 </script>
 