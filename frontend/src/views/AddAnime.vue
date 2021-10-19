<template>
    <div class="add-anime">
        <AnimeForm @saveAnime="saveAnime" />
    </div>
</template>

<script>
// @ is an alias to /src
import AnimeForm from '@/components/AnimeForm.vue'
export default {
    name: 'AddAnime',
    components: {
        AnimeForm
    },
    methods: {
        saveAnime(anime) {
            console.log('add', anime);
            this.axios.post('http://localhost:8000/api/anime', anime).then((response) => {
                console.log(response.data);
                this.$emit('setMessage', response.data);
            });
        }
    }
}
</script>
