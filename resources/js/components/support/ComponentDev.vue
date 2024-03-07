<template>
    <div class="container">
        <p class="title is-3 has-text-primary-dark mx-2">
            Тестовая среда для разработки
        </p>
    </div>
    
</template>
    
<script>
export default {
    async created() {
        await this.$api.home.testRoute();
    }
}
</script>