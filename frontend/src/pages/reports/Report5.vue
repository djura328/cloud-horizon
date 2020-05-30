<template>
    <v-row justify="center">
        <v-col cols="12" sm="8">
            <div class="title py-4">List of warehouses including percentage of population(one record should
                contain warehouse name, volume, populated percentage)</div>
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
                        <v-toolbar-title>List of warehouses with details</v-toolbar-title>
                        <v-divider
                                class="mx-4"
                                inset
                                vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" small dark class="mb-2" @click="getReport()">Refresh</v-btn>
                    </v-toolbar>
                </template>
                <template v-slot:item.percentage="{ item }">
                    {{item.percentage.toFixed(2)}}%
                </template>
                <template v-slot:item.sum="{ item }">
                    {{item.sum || 0}}
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
                        text: 'Volume',
                        align: 'start',
                        sortable: true,
                        value: 'volume'
                    },
                    {
                        text: 'Used',
                        align: 'start',
                        sortable: true,
                        value: 'sum'
                    },
                    {
                        text: 'Free',
                        align: 'start',
                        sortable: true,
                        value: 'free'
                    },
                    {
                        text: 'Percentage of usage',
                        align: 'start',
                        sortable: true,
                        value: 'percentage'
                    },

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
                axios.get(`${config.apiUrl}/report/warehouse`).then(res => {
                    this.items = res.data
                }).finally(() => {
                    this.loading = false
                })
            }
        }

    }

</script>