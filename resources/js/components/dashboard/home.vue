<template>
    <v-content>
      <v-container fluid>
        <v-layout justify-center row >
          <v-flex xs4>
            <v-card
              class="ma-3"
              color="blue-grey "
              dark
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                  mdi-account
                </v-icon>
                <span class="title font-weight-light">Total Customer</span>
              </v-card-title>

              <v-card-text class="display-4 font-weight-bold">
                43
              </v-card-text>

            </v-card>
          </v-flex>

          <v-flex xs4>
            <v-card
              class="ma-3"
              color="blue-grey "
              dark
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                mdi-calendar
                </v-icon>
                <span class="title font-weight-light">This Month Bill</span>
              </v-card-title>

              <v-card-text class="display-4 font-weight-bold">
                43
              </v-card-text>

            </v-card>
          </v-flex>
          <v-flex xs4>
            <v-card
              class="ma-3"
              color="blue-grey "
              dark
            >
              <v-card-title>
                <v-icon
                  large
                  left
                >
                  mdi-checkbox-marked
                </v-icon>
                <span class="title font-weight-light">Collected Bill</span>
              </v-card-title>

              <v-card-text class="display-4 font-weight-bold">
                43
              </v-card-text>

            </v-card>
          </v-flex>
 
        </v-layout>
        
      </v-container>
      
    </v-content>
    
</template>

<script>
  export default {
    data: () => ({
      labels: [
        '12am',
        '3am',
        '6am',
        '9am',
        '12pm',
        '3pm',
        '6pm',
        '9pm'
      ],
      value: [
        200,
        675,
        410,
        390,
        310,
        460,
        250,
        240
      ],
      dialog: false,
      drawer: null,
      items: [
        { icon: 'contacts', text: 'Customer Contacts' },
        { icon: 'history', text: 'Frequently contacted' },
        { icon: 'content_copy', text: 'Duplicates' },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'Labels',
          model: true,
          children: [
            { icon: 'add', text: 'Create label' }
          ]
        },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'More',
          model: false,
          children: [
            { text: 'Import' },
            { text: 'Export' },
            { text: 'Print' },
            { text: 'Undo changes' },
            { text: 'Other contacts' }
          ]
        },
        { icon: 'settings', text: 'Settings' },
        { icon: 'chat_bubble', text: 'Send feedback' },
        { icon: 'help', text: 'Help' },
        { icon: 'phonelink', text: 'App downloads' },
        { icon: 'keyboard', text: 'Go to the old version' }
      ]
    }),
    props: {
      source: String
    }
  }
</script>