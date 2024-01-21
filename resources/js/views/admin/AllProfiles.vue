<template>
    <div class="container">
        <h1 class="is-size-2 mb-1 has-text-centered">Все анкеты</h1>
        <AppTable
            class-table="is-bordered is-fullwidth"
            :name-titles="nameTitles"
        >
            <tr v-if="loading">
                <loading-component />
            </tr>
            <template v-else-if="profiles.length > 0"
                ><tr
                    class="has-text-centered"
                    v-for="profile in profiles"
                    :key="profile.id"
                >
                    <td>{{ profile.education }}</td>
                    <td>{{ profile.teaching_experience }}</td>
                    <td>{{ profile.teaching_category }}</td>
                    <td>{{ profile.kindergarten_in_place_work }}</td>
                    <td>{{ profile.address_kindergarten }}</td>
                    <td>
                        <span v-if="profile.phone_kindergarten != null">
                            {{ profile.phone_kindergarten }}
                        </span>
                        <span v-else>
                            не указан
                        </span>
                    </td>
                    <td>
                        <span v-if="profile.working_principles != null">
                           <span v-for="(princip, key) of profile.working_principles" :key="key">{{ princip }}; <br></span>
                        </span>
                        <span v-else>
                            не указано
                        </span>
                    </td>
                    <td>
                        <span v-if="profile.personal_qualities != null">
                            <span v-for="(quality, key) of profile.personal_qualities" :key="key">{{ quality }}; <br></span>
                        </span>
                        <span v-else>
                            не указано
                        </span>
                    </td>
                    <td class="has-text-centered">
                        <active-profile-component
                            :id="profile.id"
                            :current-state="Boolean(profile.active)"
                            @reload-info="loadProfiles(), load()"
                        />
                     </td>
                     <td>
                        <router-link :to="{ name: 'edit-main', params: { id: profile.id } }" class="button is-success">
                            Редактировать
                        </router-link>
                     </td>
                     <td class="has-text-centered">
                        <delete-profile-component :id="profile.id" @reload-info="loadProfiles"/>
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td class="has-text-centered" :colspan="tableCollspan">
                    <i>Ничего не найдено</i>
                </td>
            </tr>
        </AppTable>
    </div>
</template>
    
<script>
import AppTable from "@/components/support/Table.vue";
import AppActiveProfile from "@/components/admin/ActiveProfile.vue";
import AppDeleteProfile from "@/components/admin/DeleteProfile.vue";
import { mapActions } from "vuex";
export default {
    components: {
        AppTable,
        "active-profile-component" : AppActiveProfile,
        "delete-profile-component" : AppDeleteProfile
    },
    data() {
        return {
            nameTitles: [
                "Образование",
                "Педагогический стаж",
                "Категория",
                "Текущее место работы (детский сад)",
                "Адрес детского сада",
                "Телефон детского сада",
                "Личные качества",
                "Принципы работы",
                "Активность",
                "Редактировать",
                "Удалить анкету"
            ],
            loading: false,
            profiles: []
        };
    },
    computed: {
        tableCollspan() {
            return this.nameTitles.length;
        },
    },
    methods: {
        ...mapActions("mainModule", ["load"]),
        async loadProfiles() {
            let result = await this.$api.home.allProfiles();
            if(result.data) {
                this.profiles = result.data;
            }
        }
    },
    async created() {
       await this.loadProfiles()
    },
}
</script>