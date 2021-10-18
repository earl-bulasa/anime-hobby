<style scoped>
    ol {
        padding-left: 20px;
    }
</style>
<template>
    <div class="col-sm-10" style="margin: auto; padding-top: 20px;">
        <b-card>
            <b-card-text>
                <b-row style="text-align: left;">
                    <b-col sm="12">
                        <b-button variant="primary" type="submit" to="/">Back to Anime List</b-button>
                    </b-col>
                    <b-col sm="12"><h1>Anime: {{anime.title}}</h1></b-col>
                    <b-col sm="12">{{anime.description}}</b-col>
                </b-row>
                <b-row style="text-align: left;">
                    <b-col sm="6">
                        <h3>Opening Themes</h3>
                        <ol>
                            <li v-for="opening in anime.openings" :key="opening.id">{{opening.title}}</li>
                        </ol>
                    </b-col>
                    <b-col sm="6">
                        <h3>Ending Themes</h3>
                        <ol>
                            <li v-for="ending in anime.endings" :key="ending.id">{{ending.title}}</li>
                        </ol>
                    </b-col>
                </b-row>
                 <b-row style="text-align: left;">
                    <b-col sm="12"><h2>Main Characters</h2></b-col>
                    <b-col sm="3" v-for="character in anime.characters" :key="character.name" style="text-align: center;">
                        <b-img center :src="character.image_url" style="margin-bottom: 10px"></b-img>
                        {{character.name}}
                    </b-col>
                </b-row>
            </b-card-text>
        </b-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                anime: {
                    myanimelist_id: '',
                    title: '',
                    description: '',
                    characters: [],
                    endings: [],
                    openings: []
                }
            }
        },
        created() {
            this.getAnime();
        },
        methods: {
            getAnime() {
                this.axios.get('http://localhost:8000/api/anime/' + this.$route.params.anime).then((response) => {
                    this.anime.myanimelist_id =  response.data.anime.myanimelist_id;
                    this.anime.title = response.data.anime.title;
                    this.anime.description = response.data.anime.description;
                    this.anime.openings = response.data.anime.theme_songs.filter((theme_song) => {
                        return theme_song.type === "Opening";
                    });
                    this.anime.endings = response.data.anime.theme_songs.filter((theme_song) => {
                        return theme_song.type === "Ending";
                    });
                    this.axios.get('http://localhost:8000/api/anime/cast/'+ response.data.anime.myanimelist_id).then((response) => {
                        this.anime.characters = response.data.res.characters.filter((character) => {
                            return character.role === 'Main';
                        })
                    });
                });
            }
        }
    }
</script>
