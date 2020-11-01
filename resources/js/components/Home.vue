<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list dense>
        <template v-for="item in items">
          <v-row
            v-if="item.heading"
            :key="item.heading"
            align="center"
          >
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="item.text"
            :to="item.to"
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
              :to="child.to"
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
            v-else
            :key="item.text"
            :to="item.to"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
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
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">Payment System</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      />
      <v-spacer />
    </v-app-bar>
    <v-content>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
  import { mapState } from 'vuex'
  import axios from 'axios';
  export default {
    props: {
      source: String,
    },
    data: () => ({
      token: '',
      dialog: false,
      drawer: null,
      items: [
        { icon: 'mdi-home', text: 'Dashboard', to: '/dashboard' },
        {
          icon: 'mdi-settings',
          'icon-alt': 'mdi-chevron-down',
          text: 'Account',
          to:'/account',
          model: true,

        },
        { icon: 'mdi-power', text: 'Log Out', click:'logout', to:"#" },
      ],
    }),

     computed: {
         
         loggedIn:{
             get(){
                 return this.$store.state.user.loggedIn
             }
         },
         userDetails:{
             get() {
                 return this.$store.state.user.user
             }
         }
       },
    methods: {
        logout(){
            this.$store.dispatch('user/logout');
            window.location.href="/login"
        }
    }, 
    created(){
        axios.defaults.headers.common['Authorization']="Bearer "+ localStorage.getItem('_token');
        this.$store.dispatch('user/getDetails');
    }
  }
</script>