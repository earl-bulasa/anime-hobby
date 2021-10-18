<template>
    <div class="add-anime">
        <AnimeForm />
    </div>
</template>

<script>
// @ is an alias to /src
import AnimeForm from '@/components/AnimeForm.vue'
import {eventBus} from '@/main'

export default {
    name: 'EditAnime',
    components: {
        AnimeForm
    },
    created() {
        eventBus.$on('saveAnime', (anime) => {
            this.saveAnime(anime);
        });
    },
    methods: {
        saveAnime(anime) {
            this.axios.patch('http://localhost:8000/api/anime/' + this.$route.params.anime, anime).then((response) => {
                console.log(response.data);
                this.$emit('setMessage', response.data);
            });
        }
    }
}
</script>
