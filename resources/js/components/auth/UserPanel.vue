<template>
    <article class="panel is-success">
        <p class="panel-heading is-flex is-justify-content-space-between">
            <span>{{ user.first_name }}</span
            ><AppStatus />
        </p>
        <p
            class="panel-tabs is-flex is-justify-content-space-around is-flex-wrap-wrap"
        >
            <router-link
                v-for="link in links"
                :key="link.name"
                :to="{ name: link.routeName }"
                exact-active-class="is-active"
                >{{ link.name }}</router-link
            >
        </p>
        <AppVerifyEmail />
        <div
            class="panel-block is-flex is-flex-wrap-wrap is-justify-content-center"
        >
            <AppLogout />
        </div>
    </article>
</template>

<script>
import { mapGetters } from "vuex";
import AppStatus from "@/components/auth/Status.vue";
import AppLogout from "@/components/auth/Logout.vue";
import AppVerifyEmail from "@/components/auth/SendVerifyEmail.vue";
export default {
    data() {
        return {
            links: [
                { routeName: "profile", name: "Профиль" },
                { routeName: "profile.password", name: "Смена пароля" },
            ],
        };
    },
    components: { AppLogout, AppVerifyEmail, AppStatus },
    computed: {
        ...mapGetters("userModule", ["user"]),
    },
};
</script>
