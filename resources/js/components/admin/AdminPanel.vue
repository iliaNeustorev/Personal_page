<template>
    <article class="panel is-dark">
        <p class="panel-heading is-flex is-justify-content-space-between">
            <span>Админ панель</span>
        </p>
        <p class="panel-tabs is-flex is-justify-content-space-around is-flex-wrap-wrap">
            <router-link v-for="link in links" :key="link.name" :to="{ name: link.routeName }"
                exact-active-class="is-active">{{ link.name }}</router-link>
            <AppDevAccess>
                <router-link v-for="link in linksForDev" :key="link.name" :to="{ name: link.routeName }"
                    exact-active-class="is-active">{{ link.name }}</router-link>
            </AppDevAccess>
        </p>
    </article>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            links: [
                { routeName: "all-profiles", name: "Смотреть все анкеты" },
                { routeName: "all-feedback", name: "Смотреть отзывы пользователей" },
            ],
            linksForDev: [
                { routeName: "test", name: "Тестовый роут" },
                { routeName: "all-users", name: "Список пользователей" },
                { routeName: "all-categories", name: "Список категорий" }
            ]
        };
    },
    computed: {
        ...mapGetters("userModule", ["user"]),
    },
};
</script>
