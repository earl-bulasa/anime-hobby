<template>
    <b-form inline @submit.prevent="searchAnime">
        <b-form-select v-model="search.attribute" :options="options" class="mb-2 mr-sm-2 mb-sm-0"></b-form-select>
        <b-form-input v-model="search.text" placeholder="Search" class="mb-2 mr-sm-2 mb-sm-0"></b-form-input>
        <b-button variant="primary" type="submit">Search</b-button>
    </b-form>
</template>

<script>
    import {eventBus} from '@/main'

    export default {
        data() {
            return {
                search: {
                    text: '',
                    attribute: 'myanimelist_id'
                },
                options: [
                    {
                        value: 'myanimelist_id', 
                        text: 'MyAnimeList ID'
                    },
                    {
                        value: 'title', 
                        text: 'Title'
                    },
                    {
                        value: 'description', 
                        text: 'Description'
                    },
                ]
            }
        },
        created() {
            this.searchAnime();
            this.$parent.$on('refreshAnimeList', this.searchAnime);
        },
        methods: {
            searchAnime() {
                eventBus.$emit('searchAnime', this.search);
            }
        }
    }
</script>

