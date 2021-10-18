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
    name: 'AddAnime',
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
            this.axios.post('http://localhost:8000/api/anime', anime).then((response) => {
                console.log(response.data);
                this.$emit('setMessage', response.data);
            });
        }
    }
}
</script>
