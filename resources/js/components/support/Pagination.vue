<template>
  <nav class="pagination is-rounded">
    <button class="pagination-previous has-background-success-light" :disabled="current == links.length"
      @click="get(current + 1)">
      Следущая
    </button>
    <button class="pagination-next has-background-success-light" :disabled="current == 1" @click="get(current - 1)">
      Предидущая
    </button>
    <ul class="pagination-list">
      <li v-for="(link, i) in links" :key="i">
        <a :class="{ 'is-current is-disabled': link.active }" class="pagination-link" @click="get(link.label)">
          {{ link.label }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  emits: ["change-page"],
  props: {
    pagination: { type: Object, required: true },
  },
  data() {
    return {
      current: this.pagination.current_page,
    };
  },
  computed: {
    links() {
      return this.pagination.links != undefined
        ? this.pagination.links.slice(1, -1)
        : "";
    },
  },
  methods: {
    get(page) {
      if (page == this.current) {
        return false;
      }
      this.$emit("change-page", page);
    },
  },
};
</script>
