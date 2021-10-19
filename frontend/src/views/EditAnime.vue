<template>
    <div class="add-anime">
        <AnimeForm @saveAnime="saveAnime" />
    </div>
</template>

<script>
// @ is an alias to /src
import AnimeForm from '@/components/AnimeForm.vue'

export default {
    name: 'EditAnime',
    components: {
        AnimeForm
    },
    methods: {
        saveAnime(anime) {
            console.log('update', anime);
            this.axios.patch('http://localhost:8000/api/anime/' + this.$route.params.anime, anime).then((response) => {
                console.log(response.data);
                this.$emit('setMessage', response.data);
            });
        }
    }
}
</script>
