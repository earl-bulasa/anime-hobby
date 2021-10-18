
<template>
    <div class="col-sm-10" style="margin: auto; padding-top: 20px;">
        <b-card>
            <b-card-text style="text-align: left;">
                <b-form @submit.prevent="submitAnime">
                    <b-form-group id="myanimelist-id-group" label="MyAnimeList ID" label-for="myanimelist-id">
                        <b-form-input id="myanimelist-id" v-model="anime.myanimelist_id" type="number" min="1" placeholder="Enter MyAnimeList ID"></b-form-input>
                    </b-form-group>
                    <b-form-group id="title-group" label="Title" label-for="title">
                        <b-form-input id="title" v-model="anime.title" type="text" min="1" placeholder="Enter Title"></b-form-input>
                    </b-form-group>
                    <b-form-group id="description-group" label="Description" label-for="description">
                        <b-form-textarea id="description" v-model="anime.description" type="number" min="1" placeholder="Enter Title"></b-form-textarea>
                    </b-form-group>
                    <label>Theme Songs</label>
                    <b-row style="margin-bottom: 20px;" v-for="(theme_song, index) in anime.theme_songs" :key="index"> 
                        <b-col sm="5">
                            <b-form-select v-model="theme_song.type" :options="options"></b-form-select>
                        </b-col>
                        <b-col sm="5">
                            <b-form-input v-model="theme_song.title" type="text" min="1" placeholder="Enter Song Title"></b-form-input>
                        </b-col>
                        <b-col sm="2">
                            <b-button variant="danger" style="margin-right: 10px;" @click="removeThemeSong(index)"><font-awesome-icon icon="minus" /></b-button>
                            <b-button variant="primary" @click="addThemeSong()"><font-awesome-icon icon="plus" /></b-button>
                        </b-col>
                    </b-row>
                    <b-alert :variant="success ? 'success' : 'danger'" :show="success === null ? false : true">{{message}}</b-alert>
                    
                
                    <b-button variant="primary" type="submit" to="/" class="float-left">Back to Anime List</b-button>

                    <b-button variant="primary" type="submit" class="float-right">Save</b-button>
                 
                </b-form>
            </b-card-text>
        </b-card>
    </div>
</template>

<script>
    import {eventBus} from '@/main'

    export default {
        data() {
            return {
                anime: {
                    myanimelist_id: '',
                    title: '',
                    description: '',
                    theme_songs: [
                        {
                            type: 'Opening',
                            title: ''
                        }
                    ]
                },
                options: [
                    {
                        value: 'Opening',
                        text: 'Opening'
                    },
                    {
                        value: 'Ending',
                        text: 'Ending'
                    }
                ],
                message: '',
                success: null
            }
        },
        created() {
            this.$parent.$on('setMessage', this.setMessage);
            if(this.$route.name === "Edit Anime") {
                this.getAnime();
            }
        },
        methods: {
            addThemeSong() {
                this.anime.theme_songs.push({
                    type: 'Opening',
                    title: ''
                });
            },
            removeThemeSong(id) {
                if(this.anime.theme_songs.length > 1) {
					this.anime.theme_songs.splice(id, 1);
				}
            },
            getAnime() {
                this.axios.get('http://localhost:8000/api/anime/' + this.$route.params.anime).then((response) => {
                    console.log(response.data);
                    this.anime = response.data.anime;
                })
            },
            submitAnime() {
                eventBus.$emit('saveAnime', this.anime);
            },
            setMessage(response) {
                if(this.$route.name === "Add Anime") {
                    this.anime = {
                        myanimelist_id: '',
                        title: '',
                        description: '',
                        theme_songs: [
                            {
                                type: 'Opening',
                                title: ''
                            }
                        ]
                    };
                }
                this.message = response.msg;
                this.success = response.success;
            }
        }    
    }
</script>