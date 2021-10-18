<template>
    <div class="home">
        <AnimeTable />
    </div>
</template>

<script>
    // @ is an alias to /src
    import AnimeTable from '@/components/AnimeTable.vue'

    export default {
        name: 'Home',
        components: {
            AnimeTable
        }
    }
</script>
