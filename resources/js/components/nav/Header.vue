<template>
    <section class="hero is-small is-light">
        <div class="hero-body">
            <p class="subtitle is-3">Личная страница воспитателя детского сада <span class="is-italic" v-if="info.kindergarten_in_place_work">'{{ info.kindergarten_in_place_work  }}'</span></p>
            <p class="title has-text-success is-2">Език Елены Борисовны</p>
        </div>
    </section>
</template>

<script>
import { mapGetters} from "vuex";
export default {
    computed: {
        ...mapGetters("mainModule", ["info"]),
    },
};
</script>

<style></style>
