<template>
    <v-row justify="center">
        <v-col cols="12" sm="8">
            <div class="title py-4">List of mature plants that are not stored in warehouse</div>
            <v-data-table
                    :headers="headers"
                    :items="items"
                    :items-per-page="20"
                    class="elevation-1"
                    :loading="loading"
                    loading-text="Loading... Please wait"
            >
                <template v-slot:top>
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Plants mature that are not stored</v-toolbar-title>
                        <v-divider
                                class="mx-4"
                                inset
                                vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" small dark class="mb-2" @click="getReport()">Refresh</v-btn>
                    </v-toolbar>
                </template>
            </v-data-table>
        </v-col>

        <v-col cols="12" sm="8">
            <vue-json-pretty :data="items"></vue-json-pretty>
        </v-col>
    </v-row>
</template>

<script>

    import axios from 'axios';
    import config from '../../config';
    import VueJsonPretty from 'vue-json-pretty';

    export default {
        components: {
            VueJsonPretty
        },
        data(){
            return {
                loading: false,
                headers: [
                    {
                        text: 'Name',
                        align: 'start',
                        sortable: true,
                        value: 'name'
                    },
                    {
                        text: 'Growth',
                        align: 'start',
                        sortable: true,
                        value: 'growth'
                    }

                ],
                items: []
            }
        },
        created(){
            this.getReport();
        },
        methods:{
            getReport() {
                this.loading = true
                axios.get(`${config.apiUrl}/report/mature-plant/out-of-warehouse`).then(res => {
                    this.items = res.data
                }).finally(() => {
                    this.loading = false
                })
            }
        }

    }

</script>