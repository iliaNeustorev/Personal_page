<template>
    <nav class="navbar is-light" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <router-link :to="{ name: 'home' }" class="image is-64x64" title="На главную">
                <img class="is-rounded" src="@/assets/logo.jpg" />
            </router-link>
            <a class="navbar-burger mt-2 mr-1">
                <span
                    v-for="(item, i) in 3"
                    :key="i"
                    class="burger-button"
                    aria-hidden="true"
                ></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start title is-5">
                <router-link
                    v-for="route in menu"
                    :key="route.name"
                    :to="{ name: route.name }"
                    class="navbar-item has-text-warning-dark"
                >
                    {{ route.text }}
                </router-link>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <AppAuthAccess :noAuth="true">
                        <div class="buttons">
                            <a
                                :href="$redirectRoutes.login()"
                                class="button is-primary"
                            >
                                Войти
                            </a>
                        </div>
                    </AppAuthAccess>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    components: {
      
    },
    data() {
        return {
            menu: [
                { name: "home", text: "Основная информация"},
                { name: "photos", text: "Фотографии" },
                { name: "documents", text: "Документы" },
                { name: "feedback", text: "Обратная связь" },
            ],
        };
    },
    computed: {
       
    },
};
</script>
