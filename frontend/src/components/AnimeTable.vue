<style>
    .card-top {
        margin-bottom: 10px;
        display: inline-flex;
        padding: 0px !important;
    }
    .card-top > a {
        margin-left: auto;
        order: 2;
        margin-bottom: 0px !important;
    }

    .card-top > form {
        order: 1;
    }
</style>

<template>
    <b-col sm="10" style="margin: auto; padding-top: 20px;">
        <b-card>
            <b-card-text style="text-align: left">
                <b-col sm="12" class="card-top">
                    <b-button variant="outline-primary" class="mb-2" to="/add-anime">Add Anime</b-button>
                    <SearchAnime @searchAnime="getAnimes" />
                </b-col>
                
                <b-table sticky-header :fields="fields" responsive="sm" :items="items" outlined>
                    <template #table-colgroup="scope">
                        <col
                            v-for="field in scope.fields"
                            :key="field.key"
                            :style="{width: field.width}"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                        >
                    </template>
                    <template #cell(actions)="row">
                        <b-button variant="success" class="mb-2 mr-sm-2 mb-sm-0" :to="'/view-anime/' + row.item.id">View</b-button>
                        <b-button variant="primary" class="mb-2 mr-sm-2 mb-sm-0" :to="'/edit-anime/' + row.item.id">Edit</b-button>
                        <b-button variant="danger" class="mb-2 mr-sm-2 mb-sm-0" @click="deleteAnime(row.item.id)">Delete</b-button>
                    </template>
                </b-table>
                    
            </b-card-text>
        </b-card>
    </b-col>
</template>

<script>
    import SearchAnime from '@/components/SearchAnime.vue'

    export default {
        data() {
            return {
                search: {
                    text: '',
                    attribute: 'myanimelist_id'
                },
                sortBy: 'myanimelist_id',
                sortDesc: false,
                fields: [
                    {
                        key: 'myanimelist_id',
                        label: 'MyAnimeList ID',
                        sortable: true,
                        width: '20%'
                    },
                    {
                        key: 'title',
                        label: 'Title',
                        sortable: true,
                        width: '15%'
                    },
                    {
                        key: 'description',
                        label: 'Description',
                        sortable: true,
                        width: '45%'
                    },
                    {
                        key: 'actions',
                        label: 'Actions',
                        width: '20%'
                    }
                ],
                items: []
            }
        },
        components: {
            SearchAnime
        },
        methods: {
            getAnimes(search) {
                this.axios.post('http://localhost:8000/api/anime/list', search).then((response) => {
                    // console.log(response.data);
                    this.items = response.data.animes;

                });
            },
            deleteAnime(id) {
                this.axios.delete('http://localhost:8000/api/anime/' + id).then((response) => {
                    console.log(response);
                    this.$emit('refreshAnimeList', response.data);
                });
            }
        }
    }
</script>