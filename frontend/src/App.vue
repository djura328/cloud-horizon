<template>
  <v-app id="inspire">
    <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            app
    >
      <v-list dense>
        <template v-for="item in items">
          <v-list-group
                  v-if="item.children"
                  :key="item.text"
                  v-model="item.model"
                  :prepend-icon="item.model ? item.icon : item['icon-alt']"
                  append-icon=""
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>
                  {{ item.text }}
                </v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list-item
                    v-for="(child, i) in item.children"
                    :key="i"
                    link
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <router-link :to="{name: child.to}">
                    {{ child.text }}
                  </router-link>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
                  v-else
                  :key="item.text"
                  link
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <router-link :to="{name: item.to}">
                  {{ item.text }}
                </router-link>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="blue darken-3"
            dark
            dense
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title
              style="width: 300px"
              class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">Cloud Horizon</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn outlined small @click="start">
        One step growing
      </v-btn>
    </v-app-bar>
    <v-content>
      <v-container>

        <router-view />

      </v-container>
    </v-content>

    <v-snackbar
            v-model="snackbar"
            top
    >
      One step of growing is done
      <v-btn
              color="pink"
              text
              @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>

  </v-app>
</template>

<script>
    import axios from 'axios';
    import config from './config';

    export default {
        props: {
            source: String,
        },
        data: () => ({
            snackbar: false,
            dialog: false,
            drawer: null,
            items: [
                { icon: 'mdi-contacts', text: 'Dashboard', to: 'dashboard' },
                {
                    icon: 'mdi-chevron-up',
                    'icon-alt': 'mdi-chevron-down',
                    text: 'Reports',
                    model: true,
                    children: [
                        { icon: 'mdi-file-document-outline', text: 'Report 1', to: 'report1'},
                        { icon: 'mdi-file-document-outline', text: 'Report 2',to: 'report2' },
                        { icon: 'mdi-file-document-outline', text: 'Report 3', to: 'report3' },
                        { icon: 'mdi-file-document-outline', text: 'Report 4', to: 'report4' },
                        { icon: 'mdi-file-document-outline', text: 'Report 5', to: 'report5' },
                        { icon: 'mdi-file-document-outline', text: 'Report 6', to: 'report6' }
                    ],
                }
            ],
        }),
        methods:{
            start(){
                axios.get(`${config.apiUrl}/game/start`).then(res => {
                    this.snackbar = true
                })
            }
        }
    }
</script>

<style>
  .v-list-item__title a{
    text-decoration: none;
  }
</style>