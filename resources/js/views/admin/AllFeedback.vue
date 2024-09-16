<template>
    <div class="container">
        <h1 class="is-size-2 mb-1 has-text-centered">Все отзывы</h1>
        <AppTable class-table="is-bordered is-fullwidth" :name-titles="nameTitles">
            <tr v-if="loading">
                <loading-component />
            </tr>
            <template v-else-if="feedback.length > 0">
                <tr class="has-text-centered" v-for="item in feedback" :key="item.id">
                    <td>{{ item.user?.first_name }} {{ item.user?.last_name }}</td>
                    <td>{{ item.user?.email }}</td>
                    <td>
                        <span v-if="item.question_subject != null">
                            {{ item.question_subject }}
                        </span>
                        <span v-else>
                            Без темы
                        </span>
                    </td>
                    <td>{{ item.question }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>{{ item.status_text }}</td>
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
import { mapActions } from "vuex";
export default {
    components: {
        AppTable,
    },
    data() {
        return {
            nameTitles: [
                "Имя",
                "Email",
                "Тема",
                "Текст",
                "Дата",
                "Статус"
            ],
            loading: false,
            feedback: []
        };
    },
    computed: {
        tableCollspan() {
            return this.nameTitles.length;
        },
    },
    methods: {
        ...mapActions("mainModule", ["load"]),
        async loadFeedback() {
            let result = await this.$api.feedback.index();
            if (result.data) {
                this.feedback = result.data;
            }
        }
    },
    async created() {
        await this.loadFeedback()
    },
}
</script>