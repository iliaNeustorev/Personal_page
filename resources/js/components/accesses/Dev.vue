<template>
    <slot v-if="isDev"></slot>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters("userModule", ["isDev"]),
    },
};
</script>
