<template>
    <slot v-if="isModerator"></slot>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters("userModule", ["isModerator"]),
    },
};
</script>
