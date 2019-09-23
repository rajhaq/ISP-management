<template>
  <v-app id="inspire">

    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="blue-grey darken-4"
      dark
      app
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer" ></v-toolbar-side-icon>
        <span class="hidden-sm-and-down" >ISP</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="search"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <!-- <v-btn icon>
        <v-icon>apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>notifications</v-icon>
      </v-btn> -->
      <v-btn icon href="/logout">
        <v-icon>power</v-icon>
      </v-btn>
    </v-toolbar>
    <router-view></router-view>


  </v-app>
</template>

<script>
import collector from './collector/collector'
  export default {
    data: () => ({
      
      dialog: false,
      drawer: null,
      items: [
        { icon: 'assignment', text: 'Dashboard', link:'' },
        { icon: 'assignment', text: 'Bill', link:'billlist' },
        { icon: 'assignment', text: 'Invoice List', link:'invoicelist' },
        { icon: 'assignment', text: 'Invoice Generate', link:'invoicecreate' },
        // { icon: 'contacts', text: 'Customer Contacts' },
        // { icon: 'history', text: 'Frequently contacted' },
        // { icon: 'content_copy', text: 'Duplicates' },
        // {
        //   icon: 'keyboard_arrow_up',
        //   'icon-alt': 'keyboard_arrow_down',
        //   text: 'Labels',
        //   model: true,
        //   children: [
        //     { icon: 'add', text: 'Create label' }
        //   ]
        // },
        // {
        //   icon: 'keyboard_arrow_up',
        //   'icon-alt': 'keyboard_arrow_down',
        //   text: 'More',
        //   model: false,
        //   children: [
        //     { text: 'Import' },
        //     { text: 'Export' },
        //     { text: 'Print' },
        //     { text: 'Undo changes' },
        //     { text: 'Other contacts' }
        //   ]
        // },
        // { icon: 'settings', text: 'Settings' },
        { icon: 'group', 
        text: 'Package',
        link: 'packagelist' },
        { icon: 'group', 
        text: 'Area',
        link: 'arealist' },
        { icon: 'group', 
        text: 'Customer',
        link: 'customerlist' },
        { icon: 'group', 
        text: 'Users',
        link: 'userlist' },
        // { icon: 'help', text: 'Help' },
        // { icon: 'phonelink', text: 'App downloads' },
        // { icon: 'keyboard', text: 'Go to the old version' }
      ]
    }),
    props: {
      source: String
    },
    components:
	{
		collector,
	},
    methods: {
      leftMenu(i)
      {
        console.log(i);
      },
        handleGoToMenu(d){
                return d
            }
    },
  }
</script>