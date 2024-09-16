<template>
    <slot v-if="verify"></slot>
    <p v-else>
        <i class="has-text-primary-dark">Зарегистрируйтесь и подтвердите почту</i>
    </p>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: { noAuth: { type: Boolean, default: false } },
    computed: {
        ...mapGetters("userModule", ["user"]),
        verify() {
            return this.user?.email_verified_at !== null
        },
    },
};
</script>
