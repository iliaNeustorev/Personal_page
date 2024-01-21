<template>
    <button @click="showModal" class="button is-danger is-fullwidth">
       Удалить
   </button>
   <modal-window-component ref="modal"
     ><p>Вы действительно хотите удалить фотографию?</p>
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
   emits: ["reload-photo"],
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
         let result = await this.$api.image.deletePhoto(this.id);
         if (result.success) {
           await this.addMessage({
                text: "Фотография успешно удалена",
                timeout: 3000,
                importance: "success",
            });
           this.$emit("reload-photo");
         }
       } catch (e) {
         
       } finally {
         this.$refs.modal.show = false;
       }
     },
   },
 };
 </script>
 