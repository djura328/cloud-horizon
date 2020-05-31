<template>
    <v-row justify="center">
        <v-col cols="12" sm="8">
            <div class="title py-4">List of mature plants grouped by warehouse where plant resides</div>
            <v-data-table
                    :headers="headers"
                    :items="items"
                    :items-per-page="20"
                    class="elevation-1"
                    show-expand
                    :expanded="[items[0]]"
                    single-expand
                    :loading="loading"
                    loading-text="Loading... Please wait"
            >
                <template v-slot:top>
                    <v-toolbar flat color="white">
                        <v-toolbar-title>Warehouse plants group by type</v-toolbar-title>
                        <v-divider
                                class="mx-4"
                                inset
                                vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" small dark class="mb-2" @click="getReport()">Refresh</v-btn>
                    </v-toolbar>
                </template>
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <v-simple-table class="my-4">
                            <template v-slot:default>
                                <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Growth</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                        v-for="response in item.plants"
                                        :key="response.id"
                                >
                                    <td width="60%">{{ response.name }}</td>
                                    <td width="auto" colspan="4">{{ response.growth }}</td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </td>
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
                        text: '',
                        value: 'data-table-expand'
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
                axios.get(`${config.apiUrl}/report/mature-plant/warehouse`).then(res => {
                    this.items = res.data
                }).finally(() => {
                    this.loading = false
                })
            }
        }

    }

</script>