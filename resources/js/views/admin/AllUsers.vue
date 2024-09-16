<template>
  <div class="container">
    <h1 class="title is-3 has-text-centered has-text-success-dark">
      Список всех зарегистрированых пользователей
    </h1>
    <div class="table-container">
      <AppTable class-table="table is-bordered is-striped is-narrow is-hoverable is-fullwidth"
        :name-titles="nameTitles">
        <template v-if="users.length > 0">
          <tr class="has-text-centered" v-for="user in users" :key="user.id">
            <td>
              {{ user.first_name }} {{ user.last_name }}
            </td>
            <td>
              {{ user.email }}
            </td>
            <td>
              {{ user.created_at }}
            </td>
            <td v-if="user.roles.length > 0">
              <p v-for="role in user.roles" :key="role.id">
                <AppShowStyleName :role="role" />
              </p>
            </td>
            <td v-else>
              <p>
                <i>Нет ролей</i>
              </p>
            </td>
            <td>
              <AppEditRole :id="user.id" @reload-users="getUsers(page)" />
            </td>
            <td class="has-text-centered" :class="{ 'has-background-danger': user.blocked }">
              <AppBlockUser :id="user.id" :current-state="Boolean(user.block)" @reload-users="getUsers" />
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
            <pagination-component :pagination="objectPagination" @change-page="getUsers" />
          </td>
        </tr>
      </AppTable>
    </div>
  </div>
</template>

<script>
import AppBlockUser from "@/components/admin/roles/BlockUser.vue";
import AppShowStyleName from "@/components/admin/roles/ShowStyleName.vue";
import AppEditRole from "@/components/admin/roles/Edit.vue";
import AppTable from "@/components/support/Table.vue";

export default {
  components: {
    AppBlockUser,
    AppShowStyleName,
    AppTable,
    AppEditRole,
  },
  data() {
    return {
      nameTitles: [
        "Имя",
        "Email",
        "Дата регистрации",
        "Роль",
        "Назначить роль",
        "Заблокировать"
      ],
      users: [],
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
    async getUsers(page = 1) {
      this.loading = true;
      if (page != this.$route.query.page) {
        this.$router.push({
          name: "all-users",
          query: { page },
        });
      }
      this.objectPagination = await this.$api.admin.getUsers(page);
      this.users = this.objectPagination.users.data;
      this.page = this.$route.query.page;
      this.loading = false;
    },
  },
  created() {
    this.getUsers(this.page);
  },
};
</script>