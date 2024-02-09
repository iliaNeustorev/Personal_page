<template>
    <div class="columns mt-1 mx-1">
        <div class="column is-3">
            <figure class="image is-fullwidth">
                <img v-if="info.image != null" :class="$style['main-image']" :src="info.image.url" alt="Фото" />
                <img v-else src="@/assets/nouserpicture.png" alt="Фото" />
            </figure>
        </div>
        <div class="column">
            <div class="content">
                <div class="is-flex is-justify-content-space-between is-flex-wrap-wrap mb-1">
                    <h1 class="is-italic is-family-sans-serif">Меня зовут <span>Език Елена Борисовна</span></h1>
                    <AppModeratorAccess>
                        <router-link :to="{ name: 'edit-main', params: { id: info.id ?? 0 } }" class="button is-success is-medium" :class="$style['button-edit']">
                            Редактировать
                        </router-link>
                    </AppModeratorAccess>
                </div>
                <blockquote v-if="info.quotes">{{ info.quotes }}</blockquote>
                <div class="box">
                    <p class="is-size-4 mb-0 has-text-weight-bold has-text-primary" :class="$style['color-p']">Образование: <span class="is-size-5 has-text-weight-normal has-text-dark"><span v-if="info.education">{{ info.education }}</span><span v-else> - </span></span></p>
                    <p class="is-size-4 mb-0 has-text-weight-bold" :class="$style['color-p']">Педагогический стаж: <span class="is-size-5 has-text-weight-normal has-text-dark"><span v-if="info.teaching_experience">{{ info.teaching_experience }}</span><span v-else> - </span></span></p>
                    <p class="is-size-4 mb-0 has-text-weight-bold" :class="$style['color-p']">Категория: <span class="is-size-5 has-text-weight-normal has-text-dark"><span v-if="info.teaching_category">{{ info.teaching_category }}</span><span v-else> - </span></span></p>
                    <p class="is-size-4 mb-0 has-text-weight-bold" :class="$style['color-p']">Кредо: <span class="is-size-5 has-text-weight-normal has-text-dark"><span v-if="info.credo">{{ info.credo }}</span><span v-else> - </span></span></p>
                    <p class="is-size-4 mb-0 has-text-weight-bold" :class="$style['color-p']">Личный профессиональный девиз: <span class="is-size-5 has-text-weight-normal has-text-dark"><span v-if="info.personal_slogan">{{ info.personal_slogan }}</span><span v-else> - </span></span></p>
                    <h3 class="is-size-4 mt-1" :class="$style['color-list-name']">Принципы работы:<span v-if="! checkPrinciples" class="is-size-5 has-text-weight-normal has-text-dark"> - </span></h3>
                    <ul v-if="checkPrinciples">
                        <li v-for="princip in info.working_principles">{{ princip }}</li>
                    </ul>
                    <h3 class="is-size-4 mt-1" :class="$style['color-list-name']">Личные качества:<span v-if="! checkPersonalQuality" class="is-size-5 has-text-weight-normal has-text-dark"> - </span></h3>
                    <ul v-if="checkPersonalQuality">
                        <li v-for="quality in info.personal_qualities">{{ quality }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters} from "vuex";
export default {
    data() {
        return {
        };
    },
    computed: {
        ...mapGetters("mainModule", ["info"]),
        checkPrinciples() {
            return this.info.working_principles && this.info.working_principles.length
        },
        checkPersonalQuality() {
            return this.info.personal_qualities && this.info.working_principles.length
        }
    },
    methods: {
    },
};
</script>

<style module>
.container {
    margin: 0, 30px;
}
.main-image {
    border-radius: 20px;
}
.color-p {
	color: hsl(171.1, 85.9%, 27.8%) !important;
}
.color-list-name {
    color: hsl(109.9, 44.7%, 31.2%) !important;
}
@media (min-width: 200px) and (max-width: 1300px) {
    .button-edit {
        flex-grow: 1
    }
}
</style>
