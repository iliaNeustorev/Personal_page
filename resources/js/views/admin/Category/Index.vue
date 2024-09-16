<template>
    <div class="container">
        <h1 class="title is-3 has-text-centered has-text-success-dark">
            Список всех категорий
        </h1>
        <div class="table-container">
            <AppTable class-table="table is-bordered is-striped is-narrow is-hoverable is-fullwidth"
                :name-titles="nameTitles">
                <template v-if="categories.length > 0">
                    <tr class="has-text-centered" v-for="category in categories" :key="category.id">
                        <td>
                            {{ category.name }}
                        </td>
                        <td>
                            {{ category.sort }}
                        </td>
                        <td>
                            {{ category.created_at }}
                        </td>
                    </tr>
                </template>
                <tr v-else class="has-text-centered">
                    <td :colspan="tableCollspan">Нет данных</td>
                </tr>
                <tr>
                    <td v-if="loading" :colspan="tableCollspan">
                        <progress class="progress is-info is-medium" max="100" />
                    </td>
                    <td v-else :colspan="tableCollspan">
                        <!-- <pagination-component :pagination="objectPagination" @change-page="getUsers" /> -->
                    </td>
                </tr>
            </AppTable>
            <AppCreateCategory />
        </div>
    </div>
</template>

<script>
import AppTable from "@/components/support/Table.vue";
import AppCreateCategory from "@/components/admin/category/Create.vue"
export default {
    components: {
        AppTable,
        AppCreateCategory,
    },
    data() {
        return {
            nameTitles: [
                "Имя",
                "Сортировка",
                "Тип",
            ],
            categories: [],
            page: this.$route.query.page,
            objectPagination: [],
            loading: false,
        };
    },
    computed: {
        tableCollspan() {
            return this.nameTitles.length;
        },
    },
    methods: {
        async getCategories(page = 1) {
            this.loading = true;
            if (page != this.$route.query.page) {
                this.$router.push({
                    name: "all-categories",
                    query: { page },
                });
            }
            this.objectPagination = await this.$api.admin.categories.index(page);
            this.categories = this.objectPagination.categories;
            this.page = this.$route.query.page;
            this.loading = false;
        },
    },
    created() {
        this.getCategories(this.page);
    },
};
</script>