<template>
    <div class="view-anime">
        <AnimeDetails />
    </div>
</template>

<script>
// @ is an alias to /src
import AnimeDetails from '@/components/AnimeDetails.vue'

export default {
    name: 'ViewAnime',
    components: {
        AnimeDetails
    }
}
</script>
