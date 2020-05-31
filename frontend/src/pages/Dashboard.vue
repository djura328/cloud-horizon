<template>
  <v-row justify="center">
    <v-col cols="12" sm="8" v-if="loader">
      <v-progress-linear
              indeterminate
              color="primary"
      ></v-progress-linear>
      Loading... Please wait
    </v-col>
    <v-col cols="12" sm="8">
      <v-data-table
              :headers="plantsHeaders"
              :items="plants"
              :items-per-page="5"
              class="elevation-1"
              dense
      >
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>Plants</v-toolbar-title>
            <v-divider
                    class="mx-4"
                    inset
                    vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="primary" small dark class="mb-2" @click="dialog = true, type = 'plant'">New Item</v-btn>
          </v-toolbar>
        </template>
      </v-data-table>
    </v-col>

    <v-col cols="12" sm="8">
      <v-data-table
              :headers="plantTypeHeaders"
              :items="plantType"
              :items-per-page="5"
              class="elevation-1"
              dense
      >
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>Plant types</v-toolbar-title>
            <v-divider
                    class="mx-4"
                    inset
                    vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="primary" small dark class="mb-2" @click="dialog = true, type = 'plant-type'">New Item</v-btn>
          </v-toolbar>
        </template>
      </v-data-table>
    </v-col>

    <v-col cols="12" sm="8">
      <v-data-table
              :headers="warehouseHeaders"
              :items="warehouse"
              :items-per-page="5"
              class="elevation-1"
              dense
      >
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>Warehouse</v-toolbar-title>
            <v-divider
                    class="mx-4"
                    inset
                    vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-btn color="primary" small dark class="mb-2" @click="dialog = true, type = 'warehouse'">New Item</v-btn>
          </v-toolbar>
        </template>
      </v-data-table>
    </v-col>


    <v-dialog v-model="dialog" max-width="600" persistent>
      <v-card>
        <v-card-title class="headline">Add new {{type}}</v-card-title>

        <v-card-text>
            <v-row no-gutters>
              <template v-if="type === 'plant'">
                  <v-col cols="12">
                    <v-text-field
                            v-model="namePlant"
                            label="Name"
                            outlined
                            dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                            v-model="plantTypeSelected"
                            :items="plantType"
                            label="Type"
                            outlined
                            dense
                            item-text="name"
                            item-value="id"
                            return-object
                    ></v-select>
                  </v-col>
              </template>
              <template v-if="type === 'plant-type'">
                <v-col cols="12">
                  <v-text-field
                          v-model="namePlantType"
                          label="Name"
                          outlined
                          dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                          v-model="plantTypeVolume"
                          label="Volume"
                          outlined
                          dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                          v-model="plantTypeSpeed"
                          label="Speed grow"
                          outlined
                          dense
                  ></v-text-field>
                </v-col>
              </template>
              <template v-if="type === 'warehouse'">
                <v-col cols="12">
                  <v-text-field
                          v-model="nameWarehouse"
                          label="Name"
                          outlined
                          dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                          v-model="volumeWarehouse"
                          label="Volume"
                          outlined
                          dense
                  ></v-text-field>
                </v-col>
              </template>
            </v-row>
        </v-card-text>

        <v-card-actions>
          <v-btn
                  color="gray"
                  @click="dialog = false"
                  depressed
          >
            Cancel
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
                  color="primary"
                  @click="save"
                  :loading="loading"
                  :disabled="loading"
                  depressed
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-row>
</template>

<script>

import axios from 'axios';
import config from '../config';

export default {
    data(){
        return {
          loader: false,
          loading: false,

          namePlant: null,
          plantTypeSelected: null,
          warehouseSelected: null,

          namePlantType: null,
          plantTypeVolume: null,
          plantTypeSpeed: null,

          nameWarehouse: null,
          volumeWarehouse: null,

          dialog: false,
          type: null,
          plants: [],
          plantsHeaders: [
              {
                  text: 'Name',
                  align: 'start',
                  sortable: true,
                  value: 'name',
              },
              { text: 'Type', value: 'types.name' },
              { text: 'Warehouses', value: 'warehouses.name' }
          ],
          plantType: [],
          plantTypeHeaders: [
              {
                  text: 'Name',
                  align: 'start',
                  sortable: true,
                  value: 'name',
              },
              { text: 'Volume', value: 'volume' },
              { text: 'Speed growth', value: 'speed_growth' }
          ],
          warehouse: [],
          warehouseHeaders: [
              {
                  text: 'Name',
                  align: 'start',
                  sortable: true,
                  value: 'name',
              },
              { text: 'Volume', value: 'volume' }
          ]
        }
    },
    created() {
        this.loader = true
        Promise.all([this.getPlant(), this.getPlantType(), this.getWarehouse()]).then((values) => {
            this.plants = values[0].data
            this.plantType = values[1].data
            this.warehouse = values[2].data
        }).finally(() => {
            this.loader = false
        })
    },
    methods: {
        getPlant(){
            return axios.get(`${config.apiUrl}/plant`)
        },
        getPlantType(){
            return axios.get(`${config.apiUrl}/plant-type`)
        },
        getWarehouse(){
            return axios.get(`${config.apiUrl}/warehouse`)
        },
        save(){
            this.loading = true
            let data = null;
            if(this.type == 'plant'){
                data = {
                    name: this.namePlant,
                    plant_type_id: this.plantTypeSelected.id
                }
            }
            if(this.type == 'plant-type'){
                data = {
                    name: this.namePlantType,
                    volume: this.plantTypeVolume,
                    speed_growth: this.plantTypeSpeed
                }
            }
            if(this.type == 'warehouse'){
                data = {
                    name: this.nameWarehouse,
                    volume: this.volumeWarehouse,
                }
            }

            axios.post(`${config.apiUrl}/${this.type}`, data).then(res => {
                if(this.type == 'plant') this.plants.push(res.data.data)
                if(this.type == 'plant-type') this.plantType.push(res.data.data)
                if(this.type == 'warehouse') this.warehouse.push(res.data.data)
            }).catch( err => {
                console.log(err.resposne)
            }).finally(() => {
                this.loading = false
                this.dialog = false
            })
        }
    }

}

</script>
