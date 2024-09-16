<template>
    <slot v-if="noBlocked"></slot>
    <p v-else>
        <i class="has-text-danger-dark">Вы заблокированы и не можете оставлять отзывы</i>
    </p>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: { noAuth: { type: Boolean, default: false } },
    computed: {
        ...mapGetters("userModule", ["user"]),
        noBlocked() {
            return this.user?.block == false
        }
    },
};
</script>
